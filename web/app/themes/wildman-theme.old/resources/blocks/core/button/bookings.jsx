/**
 * External dependencies
 */

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

import { addFilter } from '@wordpress/hooks';

import { unregisterBlockStyle, registerBlockStyle } from '@wordpress/blocks';

import { 
	InspectorControls, 
	LinkControl,
	BlockControls,
	store as blockEditorStore,
} from '@wordpress/block-editor';

import {
	createInterpolateElement,
	useMemo,
	useState,
	useRef,
	useEffect,
	forwardRef,
} from '@wordpress/element';

import {
	createBlock,
	cloneBlock,
	getDefaultBlockName,
	getBlockBindingsSource,
} from '@wordpress/blocks';

import {
	Button,
	PanelBody,
	PanelRow,
	ToggleControl,
	__experimentalGrid as Grid,
} from '@wordpress/components';

import { store as coreStore, useEntityProp } from '@wordpress/core-data';

import { prependHTTP } from '@wordpress/url';

import { useSelect, useDispatch } from '@wordpress/data';

/**
 * Add the attributes needed
 *
 * @since 0.1.0
 * @param {Object} settings
 */
function addAttributes( settings ) {
	if ( 'core/button' !== settings.name ) {
		return settings;
	}

	const bookingLinkAttributes = {
		bookingLink: {
			"type": "string"
		},
		useBookingLink: {
			"type": "boolean",
			"default": false
		},
	}

	const newSettings = {
		...settings,
		attributes: {
			...settings.attributes,
			...bookingLinkAttributes,
		},
	};

	//onsole.log(newSettings)

	return newSettings;
}

addFilter(
	'blocks.registerBlockType',
	'enable-button-booking-link/add-attributes',
	addAttributes
);

/**
 * Filter the BlockEdit object and add icon inspector controls to button blocks.
 *
 * @since 0.1.0
 * @param {Object} BlockEdit
 */
const LINK_SETTINGS = [
	...LinkControl.DEFAULT_LINK_SETTINGS,
	{
		id: 'nofollow',
		title: __( 'Mark as nofollow' ),
	},
];
const NEW_TAB_REL = 'noreferrer noopener';
const NEW_TAB_TARGET = '_blank';
const NOFOLLOW_REL = 'nofollow';

function addInspectorControls( BlockEdit ) {
	let previousUrl;

	return ( settings ) => {
		if ( settings.name !== 'core/button' ) {
			return <BlockEdit { ...settings } />;
		}

		const { attributes, setAttributes, context, isSelected, clientId } = settings;
		const { url, metadata, bookingLink, rel, useBookingLink } = attributes;

		const { addEntities, editEntityRecord } = useDispatch(coreStore);

		//onsole.log(attributes)

		const newSettings = {
			...settings,
			edit( props ) {
				return (
					<div
						attributes = { attributes }
						setAttributes = { setAttributes }
						clientId = { clientId }
					/>
				);
			},
			save( props ) {
				return (
			 	        <div
						attributes = { attributes }
					/>
				);
			},
		};

		const {
			canUserEdit,
			siteBookingLink,
		} = useSelect( ( select ) => {
			const { canUser, getEntityRecord, getEditedEntityRecord, getEntityRecords, getEntityConfig, getRawEntityRecord } = select( coreStore );

			const _canUserEdit = canUser( 'update', {
				kind: 'root',
				name: 'site',
			} );

			const siteSettings = _canUserEdit
				? getEditedEntityRecord( 'root', 'site' )
				: undefined;

			const siteData = getEntityRecord( 'root', '__unstableBase' );

			const _siteBookingLink = _canUserEdit
				? siteSettings?.wa_button_booking_link
				: siteData?.wa_button_booking_link;

				//onsole.log(_siteBookingLink)
			return {
				canUserEdit: _canUserEdit,

				siteBookingLink: _siteBookingLink,
			};
		}, [] );

		const [ isEditingURL, setIsEditingURL ] = useState( false );
		//const isURLSet = !! bookingLink;
		const nofollow = !! rel?.includes( NOFOLLOW_REL );
		const opensInNewTab = bookingLink === NEW_TAB_TARGET;

		const {
			createPageEntity,
			userCanCreatePages,
			lockUrlControls = false,
		} = useSelect(
			( select ) => {
				if ( ! isSelected ) {
					return {};
				}

				const _settings = select( blockEditorStore ).getSettings();

				const blockBindingsSource = getBlockBindingsSource(
					metadata?.bindings?.url?.source
				);

				return {
					createPageEntity: _settings.__experimentalCreatePageEntity,
					userCanCreatePages: _settings.__experimentalUserCanCreatePages,
					lockUrlControls:
						!! metadata?.bindings?.url &&
						! blockBindingsSource?.canUserEditValue?.( {
							select,
							context,
							args: metadata?.bindings?.url?.args,
						} ),
				};
			},
			[ context, isSelected, metadata?.bindings?.url ]
		);

		// Memoize link value to avoid overriding the LinkControl's internal state. This is a temporary fix. See https://github.com/WordPress/gutenberg/issues/51256.
		//onsole.log(isEditingURL)
		//onsole.log(bookingLink)
		const setBookingLink = bookingLink || isEditingURL ? bookingLink : siteBookingLink
		//onsole.log('booking: '+bookingLink+ ' setBookingLink: '+setBookingLink)

		const onSetLink = ( 
			{ url, rel, newURL, newOpensInNewTab, newNofollow } 
		) => {
			//onsole.log(newURL)
			if ( ! newURL ) {
				return;
			}

			let updatedAttributes = getUpdatedLinkAttributes( {
				rel,
				bookingLink: newURL,
				opensInNewTab: newOpensInNewTab,
				nofollow: newNofollow,
			} )

			if( newURL != url ) {
				updatedAttributes.url = bookingLink
			}

			setAttributes( updatedAttributes )
			editEntityRecord( 'root', 'site', undefined, { wa_button_booking_link: newURL } );
		};

		function getUpdatedLinkAttributes( {
			rel = '',
			bookingLink = '',
			opensInNewTab,
			nofollow,
		} ) {
			let newLinkTarget;
			// Since `rel` is editable attribute, we need to check for existing values and proceed accordingly.
			let updatedRel = rel;

			if ( opensInNewTab ) {
				newLinkTarget = NEW_TAB_TARGET;
				updatedRel = updatedRel?.includes( NEW_TAB_REL )
					? updatedRel
					: updatedRel + ` ${ NEW_TAB_REL }`;
			} else {
				const relRegex = new RegExp( `\\b${ NEW_TAB_REL }\\s*`, 'g' );
				updatedRel = updatedRel?.replace( relRegex, '' ).trim();
			}

			if ( nofollow ) {
				updatedRel = updatedRel?.includes( NOFOLLOW_REL )
					? updatedRel
					: ( updatedRel + ` ${ NOFOLLOW_REL }` ).trim();
			} else {
				const relRegex = new RegExp( `\\b${ NOFOLLOW_REL }\\s*`, 'g' );
				updatedRel = updatedRel?.replace( relRegex, '' ).trim();
			}

			//onsole.log(bookingLink)
			//onsole.log(prependHTTP( bookingLink ))

			return {
				bookingLink: prependHTTP( bookingLink ),
				linkTarget: newLinkTarget,
				rel: updatedRel || undefined,
			};
		}

		function unlink(setAttributes) {
			setAttributes( {
				url: undefined,
				bookingLink: undefined,
				linkTarget: undefined,
				rel: undefined,
			} );

			setIsEditingURL( true );
		}

		useEffect( () => {
			// This effect will run whenever useBookingLink changes.
			if( useBookingLink && url !== setBookingLink ) {
				setAttributes( {
					url: setBookingLink
				} )
			}
		}, [ useBookingLink, url ] );

		// Booking link should always open in a new window
		const linkValue = useMemo(
			() => ( { url: setBookingLink, opensInNewTab: true, nofollow } ),
			[ setBookingLink, true, nofollow ]
		);
		console.log(linkValue)
		return (
			<>
				<BlockEdit { ...settings } />

				<InspectorControls>
					<PanelBody
						title={ __( 'Booking Link Options', 'watheme' ) }
						initialOpen={ true }
					>
						<div className="booking-link" style={{  }}>
							<ToggleControl
								label={ __(
									'Use as booking link',
									'watheme'
								) }
								checked={ useBookingLink }
								onChange={ () => {
									setAttributes( {
										useBookingLink: ! useBookingLink,
									} );
								} }
							/>
							{ useBookingLink && <LinkControl
								style={ { padding: '0px' } }
								value={ linkValue }
								onChange={ ( {
									url: newURL,
									opensInNewTab: newOpensInNewTab,
									nofollow: newNofollow,
								} ) => {
									onSetLink( {
										url,
										rel,
										newURL,
										newOpensInNewTab: true,
										newNofollow,
									} )
								} }
								onRemove={ () => {
									unlink(setAttributes);
								} }
								forceIsEditingLink={ isEditingURL }
								settings={ LINK_SETTINGS }
							/> }
						</div>
					</PanelBody>
				</InspectorControls>
			</>
		);
	};
}

addFilter( 'editor.BlockEdit', 'wa-edit-core/button/add-inspector-controls-booking-link', addInspectorControls);