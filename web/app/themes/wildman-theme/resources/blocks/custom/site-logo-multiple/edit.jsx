/**
 * External dependencies
 */
import clsx from 'clsx';

/**
 * WordPress dependencies
 */
import { isBlobURL } from '@wordpress/blob';

import {
	createInterpolateElement,
	useEffect,
	useState,
} from '@wordpress/element';

import { __, isRTL } from '@wordpress/i18n';

import {
	PanelBody,
	RangeControl,
	ResizableBox,
	Spinner,
	ToggleControl,
	ToolbarButton,
	Placeholder,
	Button,
	DropZone,
	FlexItem,
	SelectControl,
	__experimentalItemGroup as ItemGroup,
	__experimentalHStack as HStack,
	__experimentalTruncate as Truncate,
} from '@wordpress/components';

import { useViewportMatch } from '@wordpress/compose';

import {
	BlockControls,
	InspectorControls,
	MediaPlaceholder,
	MediaReplaceFlow,
	useBlockProps,
	store as blockEditorStore,
	__experimentalImageEditor as ImageEditor,

} from '@wordpress/block-editor';

import { useSelect, useDispatch } from '@wordpress/data';

import { store as coreStore, useEntityProp } from '@wordpress/core-data';

import { upload } from '../../../icons/build-module';

import { store as noticesStore } from '@wordpress/notices';

import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';

/**
 * Internal dependencies
 */
import { MIN_SIZE } from './constants';

const ALLOWED_MEDIA_TYPES = [ 'image' ];
const ACCEPT_MEDIA_STRING = 'image/*';
const DEFAULT_VERSION = 'tall'
const DEFAULT_SEASON = 'winter'

const chooseVersion = ( season, version ) => {
    const [ error, setError ]       = useState( null );
    const [ currentSeason, setSeason ]       = useState( null );
    const [ isLoaded, setIsLoaded ] = useState( false );

    useEffect( () => {
        apiFetch( {
			path: addQueryArgs( '/wa/v1/site' ),
		} ).then(
            ( result ) => {
                setIsLoaded( true );
                setSeason( result?.season );
            },
            ( error ) => {
                setIsLoaded( true );
                setError( error );
            }
        );
    }, [ ] );

	let selectedSeason = season ? season : 'automatic' // in case it's undefined

	let chosenSeason = currentSeason && selectedSeason === 'automatic' ? currentSeason : selectedSeason // use selected option if it's not set to automatic

	return version + '-' + chosenSeason
}

const SiteLogo = ( props ) => {
	const {
		attributes,
		attributes: { align, width, height, isLink, linkTarget, shouldSyncIcon, selectedSeason, selectedVersion, setWidth },
		isSelected,
		setAttributes,

		siteUrl,

		setLogo,

		canUserEdit,

		altTallWinter,
		setLogoTallWinter,
		logoUrlTallWinter,
		logoIdTallWinter,
		iconIdTallTallWinter,

		altLongWinter,
		setLogoLongWinter,
		logoUrlLongWinter,
		logoIdLongWinter,
		iconIdTallLongWinter,

		altTallSpring,
		setLogoTallSpring,
		logoUrlTallSpring,
		logoIdTallSpring,
		iconIdTallTallSpring,

		altLongSpring,
		setLogoLongSpring,
		logoUrlLongSpring,
		logoIdLongSpring,
		iconIdTallLongSpring,

		altTallSummer,
		setLogoTallSummer,
		logoUrlTallSummer,
		logoIdTallSummer,
		iconIdTallTallSummer,

		altLongSummer,
		setLogoLongSummer,
		logoUrlLongSummer,
		logoIdLongSummer,
		iconIdTallLongSummer,

		altTallFall,
		setLogoTallFall,
		logoUrlTallFall,
		logoIdTallFall,
		iconIdTallTallFall,

		altLongFall,
		setLogoLongFall,
		logoUrlLongFall,
		logoIdLongFall,
		iconIdTallLongFall,
	} = props

    let showVersion = chooseVersion( selectedSeason, selectedVersion )

	//onsole.log(props)

	const isLargeViewport = useViewportMatch( 'medium' );
	const isWideAligned = [ 'wide', 'full' ].includes( align );
	const isResizable = ! isWideAligned && isLargeViewport;

	const [ { naturalWidth, naturalHeight }, setNaturalSize ] = useState( {} );
	const [ isEditingImage, setIsEditingImage ] = useState( false );

	const { toggleSelection } = useDispatch( blockEditorStore );

	const { imageEditing, maxWidth, title } = useSelect( ( select ) => {
		const settings = select( blockEditorStore ).getSettings();
		const siteEntities = select( coreStore ).getEntityRecord(
			'wa',
			'__unstableBase'
		);
		return {
			title: siteEntities?.name,
			imageEditing: settings.imageEditing,
			maxWidth: settings.maxWidth,
		};
	}, [] );

	useEffect( () => {
		if ( ! isSelected ) {
			setIsEditingImage( false );
		}
	}, [ isSelected ] );

	function onResizeStart() {
		toggleSelection( false );
	}

	function onResizeStop() {
		toggleSelection( true );
	}

	//onsole.log(showLongVersion ? logoUrlLong : logoUrlTall)
	//onsole.log(logoUrlLong )
	//onsole.log(showLongVersion ? logoUrlLong : logoUrlTall)

	//onsole.log(showVersion)
	let src = logoUrlLongWinter
	let alt = altLongWinter
	let blob = logoUrlLongWinter
	if( showVersion === 'long-winter') {
		src = logoUrlLongWinter
		alt = altLongWinter
		blob = logoUrlLongWinter
	} else if( showVersion === 'tall-winter') {
		src = logoUrlTallWinter
		alt = altTallWinter
		blob = logoUrlTallWinter
	} else if( showVersion === 'long-spring') {
		src = logoUrlLongSpring
		alt = altLongSpring
		blob = logoUrlLongSpring
	} else if( showVersion === 'tall-spring') {
		src = logoUrlTallSpring
		alt = altTallSpring
		blob = logoUrlTallSpring
	} else if( showVersion === 'long-summer') {
		src = logoUrlLongSummer
		alt = altLongSummer
		blob = logoUrlLongSummer
	} else if( showVersion === 'tall-summer') {
		src = logoUrlTallSummer
		alt = altTallSummer
		blob = logoUrlTallSummer
	} else if( showVersion === 'long-fall') {
		src = logoUrlLongFall
		alt = altLongFall
		blob = logoUrlLongFall
	} else if( showVersion === 'tall-fall') {
		src = logoUrlTallFall
		alt = altTallFall
		blob = logoUrlTallFall
	}  

	const img = ( <>
			<img
				className="custom-logo"
				src={ src }
				alt={ alt }
				onLoad={ ( event ) => {
					setNaturalSize( {
						naturalWidth: event.target.naturalWidth,
						naturalHeight: event.target.naturalHeight,
					} );
				} }
			/>

			{ isBlobURL( blob ) && <Spinner /> }
		</>
	);

	let imgWrapper = img;


	if ( ! isResizable || ! naturalWidth || ! naturalHeight ) {
		return <div style={ { width, height } }>{ imgWrapper }</div>;
	}

	// Set the default width to a responsible size. Note that this width is also set in the attached frontend CSS file.
	let defaultWidth = false, currentWidth = false, ratio = false, currentHeight = false, minWidth = false, minHeight = false, maxWidthBuffer = false;

	currentWidth = width || defaultWidth;

	ratio = naturalWidth / naturalHeight;
	currentHeight = currentWidth / ratio;
	minWidth = naturalWidth < naturalHeight ? MIN_SIZE : Math.ceil( MIN_SIZE * ratio );
	minHeight = naturalHeight < naturalWidth ? MIN_SIZE : Math.ceil( MIN_SIZE / ratio );

 	//With the current implementation of ResizableBox, an image needs an explicit pixel value for the max-width. In absence of being able to set the content-width, this max-width is currently dictated by the vanilla editor style. The following variable adds a buffer to this vanilla style, so 3rd party themes have some wiggleroom. This does, in most cases, allow you to scale the image beyond the width of the main column, though not infinitely. @todo It would be good to revisit this once a content-width variable becomes available.
	maxWidthBuffer = maxWidth * 2.5;

	let showRightHandle = false;
	let showLeftHandle = false;

	/* eslint-disable no-lonely-if */
	// See https://github.com/WordPress/gutenberg/issues/7584.
	if ( align === 'center' ) {
		// When the image is centered, show both handles.
		showRightHandle = true;
		showLeftHandle = true;
	} else if ( isRTL() ) {
		// In RTL mode the image is on the right by default. Show the right handle and hide the left handle only when it is aligned left. Otherwise always show the left handle.
		if ( align === 'left' ) {
			showRightHandle = true;
		} else {
			showLeftHandle = true;
		}
	} else {
		// Show the left handle and hide the right handle only when the image is aligned right. Otherwise always show the right handle.
		if ( align === 'right' ) {
			showLeftHandle = true;
		} else {
			showRightHandle = true;
		}
	}
	/* eslint-enable no-lonely-if */
	const hasID = logoIdTallWinter ||logoIdLongWinter || logoIdTallSpring ||logoIdLongSpring || logoIdTallSummer ||logoIdLongSummer || logoIdTallFall ||logoIdLongFall

	const canEditImage = hasID && naturalWidth && naturalHeight && imageEditing;

	const imgEdit = <ResizableBox
		size={ {
			width: currentWidth,
			height: currentHeight,
		} }
		showHandle={ isSelected }
		minWidth={ minWidth }
		maxWidth={ maxWidthBuffer }
		minHeight={ minHeight }
		maxHeight={ maxWidthBuffer / ratio }
		lockAspectRatio
		enable={ {
			top: false,
			right: showRightHandle,
			bottom: true,
			left: showLeftHandle,
		} }
		onResizeStart={ onResizeStart }
		onResizeStop={ ( event, direction, elt, delta ) => {
			onResizeStop();
			setAttributes( {
				width: parseInt( currentWidth + delta.width, 10 ),
				height: parseInt( currentHeight + delta.height, 10 ),
			} );
		} }
	>
		{ imgWrapper }
	</ResizableBox>

	// Support the previous location for the Site Icon settings. To be removed
	// when the required WP core version for Gutenberg is >= 6.5.0.
	const shouldUseNewUrl = ! window?.__experimentalUseCustomizerSiteLogoUrlTall;

	const siteIconSettingsUrl = shouldUseNewUrl
		? siteUrl + '/wp-admin/options-general.php'
		: siteUrl + '/wp-admin/customize.php?autofocus[section]=title_tagline';

	//onsole.log(attributes)

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings' ) }>

					<ToggleControl
						label={ __( 'Have a set width (in px)' ) }
						onChange={ () => setAttributes( { setWidth: ! setWidth } ) }
						checked={ setWidth }
					/>
					{ setWidth && <RangeControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Image width' ) }
						onChange={ ( newWidth ) => {
							console.log(newWidth)
							setAttributes( { width: newWidth } )
						} }
						min={ minWidth }
						max={ maxWidthBuffer }
						initialPosition={ Math.min(
							defaultWidth,
							maxWidthBuffer
						) }
						value={ width || '' }
						disabled={ ! isResizable }
						allowReset={ true }
					/> }

					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Link image to home' ) }
						onChange={ () => setAttributes( { isLink: ! isLink } ) }
						checked={ isLink }
					/>
				</PanelBody>
			</InspectorControls>

			{ imgEdit }
		</>
	);
};

// This is a light wrapper around MediaReplaceFlow because the block has two different MediaReplaceFlows, one for the inspector and one for the toolbar.
function SiteLogoReplaceFlow( { mediaURL, ...mediaReplaceProps } ) {
	//onsole.log(mediaReplaceProps)

	return (
		<MediaReplaceFlow
			{ ...mediaReplaceProps }
			mediaURL={ mediaURL }
			allowedTypes={ ALLOWED_MEDIA_TYPES }
			accept={ ACCEPT_MEDIA_STRING }
		/>
	);
}

const InspectorLogoPreview = ( { label, media, itemGroupProps } ) => {
	const {
		alt_text: altTall,
		source_url: logoUrlTall,
		slug: logoSlug,
		media_details: logoMediaDetails,
	} = media ?? {};

	const logoLabel = logoMediaDetails?.sizes?.full?.file || logoSlug;

	return (
		<ItemGroup { ...itemGroupProps } as="span">
			<HStack justify="flex-start" as="span">
				<img src={ logoUrlTall } alt={ altTall } />
				<FlexItem as="span">
					<Truncate
						numberOfLines={ 1 }
						className="block-library-site-logo__inspector-media-replace-title"
					>
						{ logoLabel }
					</Truncate>
				</FlexItem>
			</HStack>
		</ItemGroup>
	);
};

export default function LogoEdit( props ) {
	const {
		attributes,
		attributes: { align, width, shouldSyncIcon, selectedSeason, selectedVersion, setWidth },
		className,
		setAttributes,
		isSelected,
	} = props

	//onsole.log(attributes)

	const { addEntities, editEntityRecord } = useDispatch(coreStore);

    let showVersion = chooseVersion( selectedSeason, selectedVersion )

	//const version = showSeasonVersion ? showSeasonVersion : DEFAULT_VERSION
	const { createErrorNotice } = useDispatch( noticesStore );

	const {
		canUserEdit,
		url,

		siteLogoIdTallWinter,
		mediaItemDataTallWinter,
		isRequestingMediaItemTallWinter,

		siteLogoIdLongWinter,
		mediaItemDataLongWinter,
		isRequestingMediaItemLongWinter,

		siteLogoIdTallSpring,
		mediaItemDataTallSpring,
		isRequestingMediaItemTallSpring,

		siteLogoIdLongSpring,
		mediaItemDataLongSpring,
		isRequestingMediaItemLongSpring,

		siteLogoIdTallSummer,
		mediaItemDataTallSummer,
		isRequestingMediaItemTallSummer,

		siteLogoIdLongSummer,
		mediaItemDataLongSummer,
		isRequestingMediaItemLongSummer,

		siteLogoIdTallFall,
		mediaItemDataTallFall,
		isRequestingMediaItemTallFall,

		siteLogoIdLongFall,
		mediaItemDataLongFall,
		isRequestingMediaItemLongFall,
	} = useSelect( ( select ) => {
		const { canUser, getEntityRecord, getEditedEntityRecord, getEntityRecords, getEntityConfig, getRawEntityRecord } = select( coreStore );

		const _canUserEdit = canUser( 'update', {
			kind: 'root',
			name: 'site',
		} );

		const siteSettings = _canUserEdit
			? getEditedEntityRecord( 'root', 'site' )
			: undefined;

		//onsole.log(siteSettings)

		const siteData = getEntityRecord( 'root', '__unstableBase' );

		const _siteLogoIdTallWinter = _canUserEdit
			? siteSettings?.wa_site_logo_tall_winter
			: siteData?.wa_site_logo_tall_winter;

		const mediaItemTallWinter = _siteLogoIdTallWinter &&
			select( coreStore ).getMedia( _siteLogoIdTallWinter, {
				context: 'view',
			} );

		const _isRequestingMediaItemTallWinter =
			!! _siteLogoIdTallWinter &&
			! select( coreStore ).hasFinishedResolution( 'getMedia', [
				_siteLogoIdTallWinter,
				{ context: 'view' },
			] );

		const _siteLogoIdLongWinter = _canUserEdit
			? siteSettings?.wa_site_logo_long_winter
			: siteData?.wa_site_logo_long_winter;

		const mediaItemLongWinter = _siteLogoIdLongWinter &&
			select( coreStore ).getMedia( _siteLogoIdLongWinter, {
				context: 'view',
			} );

		const _isRequestingMediaItemLongWinter =
			!! _siteLogoIdLongWinter &&
			! select( coreStore ).hasFinishedResolution( 'getMedia', [
				_siteLogoIdLongWinter,
				{ context: 'view' },
			] );


		const _siteLogoIdTallSpring = _canUserEdit
			? siteSettings?.wa_site_logo_tall_spring
			: siteData?.wa_site_logo_tall_spring;

		const mediaItemTallSpring = _siteLogoIdTallSpring &&
			select( coreStore ).getMedia( _siteLogoIdTallSpring, {
				context: 'view',
			} );

		const _isRequestingMediaItemTallSpring =
			!! _siteLogoIdTallSpring &&
			! select( coreStore ).hasFinishedResolution( 'getMedia', [
				_siteLogoIdTallSpring,
				{ context: 'view' },
			] );

		const _siteLogoIdLongSpring = _canUserEdit
			? siteSettings?.wa_site_logo_long_spring
			: siteData?.wa_site_logo_long_spring;

		const mediaItemLongSpring = _siteLogoIdLongSpring &&
			select( coreStore ).getMedia( _siteLogoIdLongSpring, {
				context: 'view',
			} );

		const _isRequestingMediaItemLongSpring =
			!! _siteLogoIdLongSpring &&
			! select( coreStore ).hasFinishedResolution( 'getMedia', [
				_siteLogoIdLongSpring,
				{ context: 'view' },
			] );


		const _siteLogoIdTallSummer = _canUserEdit
			? siteSettings?.wa_site_logo_tall_summer
			: siteData?.wa_site_logo_tall_summer;

		const mediaItemTallSummer = _siteLogoIdTallSummer &&
			select( coreStore ).getMedia( _siteLogoIdTallSummer, {
				context: 'view',
			} );

		const _isRequestingMediaItemTallSummer =
			!! _siteLogoIdTallSummer &&
			! select( coreStore ).hasFinishedResolution( 'getMedia', [
				_siteLogoIdTallSummer,
				{ context: 'view' },
			] );

		const _siteLogoIdLongSummer = _canUserEdit
			? siteSettings?.wa_site_logo_long_summer
			: siteData?.wa_site_logo_long_summer;

		const mediaItemLongSummer = _siteLogoIdLongSummer &&
			select( coreStore ).getMedia( _siteLogoIdLongSummer, {
				context: 'view',
			} );

		const _isRequestingMediaItemLongSummer =
			!! _siteLogoIdLongSummer &&
			! select( coreStore ).hasFinishedResolution( 'getMedia', [
				_siteLogoIdLongSummer,
				{ context: 'view' },
			] );

		const _siteLogoIdTallFall = _canUserEdit
			? siteSettings?.wa_site_logo_tall_fall
			: siteData?.wa_site_logo_tall_fall;

		const mediaItemTallFall = _siteLogoIdTallFall &&
			select( coreStore ).getMedia( _siteLogoIdTallFall, {
				context: 'view',
			} );

		const _isRequestingMediaItemTallFall =
			!! _siteLogoIdTallFall &&
			! select( coreStore ).hasFinishedResolution( 'getMedia', [
				_siteLogoIdTallFall,
				{ context: 'view' },
			] );

		const _siteLogoIdLongFall = _canUserEdit
			? siteSettings?.wa_site_logo_long_fall
			: siteData?.wa_site_logo_long_fall;

		const mediaItemLongFall = _siteLogoIdLongFall &&
			select( coreStore ).getMedia( _siteLogoIdLongFall, {
				context: 'view',
			} );

		const _isRequestingMediaItemLongFall =
			!! _siteLogoIdLongFall &&
			! select( coreStore ).hasFinishedResolution( 'getMedia', [
				_siteLogoIdLongFall,
				{ context: 'view' },
			] );

		return {
			canUserEdit: _canUserEdit,
			url: siteData?.home,

			siteLogoIdTallWinter: _siteLogoIdTallWinter,
			mediaItemDataTallWinter: mediaItemTallWinter,
			isRequestingMediaItemTallWinter: _isRequestingMediaItemTallWinter,

			siteLogoIdLongWinter: _siteLogoIdLongWinter,
			mediaItemDataLongWinter: mediaItemLongWinter,
			isRequestingMediaItemLongWinter: _isRequestingMediaItemLongWinter,

			siteLogoIdTallSpring: _siteLogoIdTallSpring,
			mediaItemDataTallSpring: mediaItemTallSpring,
			isRequestingMediaItemTallSpring: _isRequestingMediaItemTallSpring,

			siteLogoIdLongSpring: _siteLogoIdLongSpring,
			mediaItemDataLongSpring: mediaItemLongSpring,
			isRequestingMediaItemLongSpring: _isRequestingMediaItemLongSpring,

			siteLogoIdTallSummer: _siteLogoIdTallSummer,
			mediaItemDataTallSummer: mediaItemTallSummer,
			isRequestingMediaItemTallSummer: _isRequestingMediaItemTallSummer,

			siteLogoIdLongSummer: _siteLogoIdLongSummer,
			mediaItemDataLongSummer: mediaItemLongSummer,
			isRequestingMediaItemLongSummer: _isRequestingMediaItemLongSummer,

			siteLogoIdTallFall: _siteLogoIdTallFall,
			mediaItemDataTallFall: mediaItemTallFall,
			isRequestingMediaItemTallFall: _isRequestingMediaItemTallFall,

			siteLogoIdLongFall: _siteLogoIdLongFall,
			mediaItemDataLongFall: mediaItemLongFall,
			isRequestingMediaItemLongFall: _isRequestingMediaItemLongFall,
		};
	}, [] );

	const { getSettings } = useSelect( blockEditorStore );

	const [ 
		temporaryURLTallWinter, setTemporaryURLTallWinter, temporaryURLLongWinter, setTemporaryURLLongWinter,
		temporaryURLTallSpring, setTemporaryURLTallSpring, temporaryURLLongSpring, setTemporaryURLLongSpring,
		temporaryURLTallSummer, setTemporaryURLTallSummer, temporaryURLLongSummer, setTemporaryURLLongSummer,
		temporaryURLTallFall, setTemporaryURLTallFall, temporaryURLLongFall, setTemporaryURLLongFall,
	] = useState();


	// Multiuse functions
	const setLogo = ( newValue, shouldForceSync = false, version = DEFAULT_VERSION, season = DEFAULT_SEASON ) => {
		//onsole.log('setLogo: '+ newValue+' version: '+version+' season: '+season)
		//onsole.log(version+' '+season)
		// `shouldForceSync` is used to force syncing when the attribute may not have updated yet.

		let params = false

		if(season === 'winter') {
			if(version === 'tall') {
				params = {
					wa_site_logo_tall_winter: newValue,
				}
			} else if(version === 'long') {
				params = {
					wa_site_logo_long_winter: newValue,
				}
			}
		} else if(season === 'spring') {
			if(version === 'tall') {
				params = {
					wa_site_logo_tall_spring: newValue,
				}
			} else if(version === 'long') {
				params = {
					wa_site_logo_long_spring: newValue,
				}
			}
		} else if(season === 'summer') {
			if(version === 'tall') {
				params = {
					wa_site_logo_tall_summer: newValue,
				}
			} else if(version === 'long') {
				params = {
					wa_site_logo_long_summer: newValue,
				}
			}
		} else if(season === 'fall') {
			if(version === 'tall') {
				params = {
					wa_site_logo_tall_fall: newValue,
				}
			} else if(version === 'long') {
				params = {
					wa_site_logo_long_fall: newValue,
				}
			}
		} 

		//onsole.log(params)

		if(params) {
			editEntityRecord( 'root', 'site', undefined, params );
		}
	};

	const onSelectLogo = ( media, shouldForceSync, version, season ) => {
		if ( ! media ) {
			return;
		}

		if ( ! media.id && media.url ) {
			// This is a temporary blob image.
			setTemporaryURLLong( media.url );
			setLogo( undefined, shouldForceSync, version, season );

			return;
		}

		setLogo( media.id, shouldForceSync, version, season );
	};

	const onInitialSelectLogo = ( media, version = 'tall', season = 'winter' ) => {
		// Initialize the syncSiteIcon toggle. If we currently have no Site logo and no
		// site icon, automatically sync the logo to the icon.
		if ( shouldSyncIcon === undefined ) {
			const shouldForceSync = ! siteIconId;

			setAttributes( { shouldSyncIcon: shouldForceSync } );

			// Because we cannot rely on the `shouldSyncIcon` attribute to have updated bythe time `setLogo` is called, pass an argument to force the syncing.
			onSelectLogo( media, shouldForceSync, version, season );

			return;
		}

		onSelectLogo( media, shouldForceSync, version, season );
	};

	const onUploadError = ( message, version = 'tall', season = 'winter' ) => {
		createErrorNotice( message, { type: 'snackbar' } );

		if(season === 'winter') {
			if(version === 'tall') {
				setTemporaryURLTallWinter( );
			} else if(version === 'long') {
				setTemporaryURLLongWinter( );
			}
		} else if(season === 'spring') {
			if(version === 'tall') {
				setTemporaryURLTallSpring( );
			} else if(version === 'long') {
				setTemporaryURLLongSpring( );
			}
		} else if(season === 'summer') {
			if(version === 'tall') {
				setTemporaryURLTallSummer( );
			} else if(version === 'long') {
				setTemporaryURLLongSummer( );
			}
		} else if(season === 'fall') {
			if(version === 'tall') {
				setTemporaryURLTallFall( );
			} else if(version === 'long') {
				setTemporaryURLLongFall( );
			}
		} 
	};

	const onFilesDrop = ( params, version = 'tall', season = 'winter' ) => {
		getSettings().mediaUpload( {
			...params,
			onFileChange( [ image ] ) {
				if ( isBlobURL( image?.url ) ) {
					setTemporaryURLTall( image.url );

					if(season === 'winter') {
						if(version === 'tall') {
							setTemporaryURLTallWinter( image.url );
						} else if(version === 'long') {
							setTemporaryURLLongWinter( image.url );
						}
					} else if(season === 'spring') {
						if(version === 'tall') {
							setTemporaryURLTallSpring( image.url );
						} else if(version === 'long') {
							setTemporaryURLLongSpring( image.url );
						}
					} else if(season === 'summer') {
						if(version === 'tall') {
							setTemporaryURLTallSummer( image.url );
						} else if(version === 'long') {
							setTemporaryURLLongSummer( image.url );
						}
					} else if(season === 'fall') {
						if(version === 'tall') {
							setTemporaryURLTallFall( image.url );
						} else if(version === 'long') {
							setTemporaryURLLongFall( image.url );
						}
					} 

					return;
				}

				if(season === 'winter') {
					if(version === 'tall') {
						onInitialSelectLogo( image, 'tall', 'winter' );
					} else if(version === 'long') {
						onInitialSelectLogo( image, 'long', 'winter' );
					}
				} else if(season === 'spring') {
					if(version === 'tall') {
						onInitialSelectLogo( image, 'tall', 'spring' );
					} else if(version === 'long') {
						onInitialSelectLogo( image, 'long', 'spring' );
					}
				} else if(season === 'summer') {
					if(version === 'tall') {
						onInitialSelectLogo( image, 'tall', 'summer' );
					} else if(version === 'long') {
						onInitialSelectLogo( image, 'long', 'summer' );
					}
				} else if(season === 'fall') {
					if(version === 'tall') {
						onInitialSelectLogo( image, 'tall', 'fall' );
					} else if(version === 'long') {
						onInitialSelectLogo( image, 'long', 'fall' );
					}
				}
			},
			onError: onUploadErrorTall,

			multiple: false,
		} );
	};

	// Season/Version specific functions

	// Winter
	const { alt_text: altLongWinter, source_url: logoUrlLongWinter } = mediaItemDataLongWinter ?? {};
	const { alt_text: altTallWinter, source_url: logoUrlTallWinter } = mediaItemDataTallWinter ?? {};

	const onInitialSelectLogoLongWinter = ( media ) => {
		let version = 'long'
		let season = 'winter'

		onInitialSelectLogo( media, version, season );
	};

	const onSelectLogoLongWinter = ( newValue, shouldForceSync = false ) => {
		let version = 'long'
		let season = 'winter'

		onSelectLogo( newValue, shouldForceSync, version, season );
	};

	const onRemoveLogoLongWinter = ( shouldForceSync ) => {
		let version = 'long'
		let season = 'winter'

		setLogo( null, shouldForceSync, version, season );

		//setAttributes( { width: undefined } );
	};

	const onUploadErrorLongWinter = ( message ) => {
		let version = 'long'
		let season = 'winter'

		onUploadError( message, version, season ) 
	};

	const onFilesDropLongWinter = ( filesList ) => {
		let params = {
			onError: onUploadLongWinter,
		}

		onFilesDrop( params, version = 'long', season = 'winter' )
	};

	const onInitialSelectLogoTallWinter = ( media ) => {
		let version = 'tall'
		let season = 'winter'

		onInitialSelectLogo( media, version, season );
	};

	const onSelectLogoChosen = ( media, shouldForceSync = false ) => {
		let version = 'tall'
		let season = 'winter'

		//onsole.log(media)

		onSelectLogo( media, shouldForceSync, version, season );
	};

	const onSelectLogoTallWinter = ( media, shouldForceSync = false ) => {
		let version = 'tall'
		let season = 'winter'

		onSelectLogo( media, shouldForceSync, version, season );
	};

	const onRemoveLogoTallWinter = ( shouldForceSync ) => {
		let version = 'tall'
		let season = 'winter'

		setLogo( null, shouldForceSync, version, season );

		//setAttributes( { width: undefined } );
	};

	const onUploadErrorTallWinter = ( message ) => {
		let version = 'tall'
		let season = 'winter'

		onUploadError( message, version, season ) 
	};

	const onFilesDropTallWinter = ( filesList ) => {
		let params = {
			onError: onUploadTallWinter,
		}

		onFilesDrop( params, version = 'tall', season = 'winter' )
	};

	const mediaReplaceFlowPropsLongWinter = {
		mediaURL: logoUrlLongWinter,
		name: ! logoUrlLongWinter ? __( 'Choose logo (winter - long version)' ) : __( 'Replace' ),
		onSelect: onSelectLogoLongWinter,
		onError: onUploadErrorLongWinter,
		onReset: onRemoveLogoLongWinter,
	};

	const mediaReplaceFlowPropsTallWinter = {
		mediaURL: logoUrlTallWinter,
		name: ! logoUrlTallWinter ? __( 'Choose logo (winter - tall version)' ) : __( 'Replace' ),
		onSelect: onSelectLogoTallWinter,
		onError: onUploadErrorTallWinter,
		onReset: onRemoveLogoTallWinter,
	};

	const isLoadingTallWinter = siteLogoIdTallWinter === undefined || isRequestingMediaItemTallWinter;
	const isLoadingLongWinter = siteLogoIdLongWinter === undefined || isRequestingMediaItemLongWinter;
	
	// Spring
	const { alt_text: altLongSpring, source_url: logoUrlLongSpring } = mediaItemDataLongSpring ?? {};
	const { alt_text: altTallSpring, source_url: logoUrlTallSpring } = mediaItemDataTallSpring ?? {};

	const onInitialSelectLogoLongSpring = ( media ) => {
		let version = 'long'
		let season = 'spring'

		onInitialSelectLogo( media, version, season );
	};

	const onSelectLogoLongSpring = ( media, shouldForceSync = false ) => {
		let version = 'long'
		let season = 'spring'

		onSelectLogo( media, shouldForceSync, version, season );
	};

	const onRemoveLogoLongSpring = ( shouldForceSync ) => {
		let version = 'long'
		let season = 'spring'

		setLogo( null, shouldForceSync, version, season );

		//setAttributes( { width: undefined } );
	};

	const onUploadErrorLongSpring = ( message ) => {
		let version = 'long'
		let season = 'spring'

		onUploadError( message, version, season ) 
	};

	const onFilesDropLongSpring = ( filesList ) => {
		let params = {
			onError: onUploadLongSpring,
		}

		onFilesDrop( params, version = 'long', season = 'spring' )
	};

	const onInitialSelectLogoTallSpring = ( media ) => {
		let version = 'tall'
		let season = 'spring'

		onInitialSelectLogo( media, version, season );
	};

	const onSelectLogoTallSpring = ( media, shouldForceSync = false ) => {
		let version = 'tall'
		let season = 'spring'

		onSelectLogo( media, shouldForceSync, version, season );
	};

	const onRemoveLogoTallSpring = ( shouldForceSync ) => {
		let version = 'tall'
		let season = 'spring'

		setLogo( null, shouldForceSync, version, season );

		//setAttributes( { width: undefined } );
	};

	const onUploadErrorTallSpring = ( message ) => {
		let version = 'tall'
		let season = 'spring'

		onUploadError( message, version, season ) 
	};

	const onFilesDropTallSpring = ( filesList ) => {
		let params = {
			onError: onUploadTallSpring,
		}

		onFilesDrop( params, version = 'tall', season = 'spring' )
	};

	const mediaReplaceFlowPropsLongSpring = {
		mediaURL: logoUrlLongSpring,
		name: ! logoUrlLongSpring ? __( 'Choose logo (spring - long version)' ) : __( 'Replace' ),
		onSelect: onSelectLogoLongSpring,
		onError: onUploadErrorLongSpring,
		onReset: onRemoveLogoLongSpring,
	};

	const mediaReplaceFlowPropsTallSpring = {
		mediaURL: logoUrlTallSpring,
		name: ! logoUrlTallSpring ? __( 'Choose logo (spring - tall version)' ) : __( 'Replace' ),
		onSelect: onSelectLogoTallSpring,
		onError: onUploadErrorTallSpring,
		onReset: onRemoveLogoTallSpring,
	};

	const isLoadingTallSpring = siteLogoIdTallSpring === undefined || isRequestingMediaItemTallSpring;
	const isLoadingLongSpring = siteLogoIdLongSpring === undefined || isRequestingMediaItemLongSpring;

	// Summer
	const { alt_text: altLongSummer, source_url: logoUrlLongSummer } = mediaItemDataLongSummer ?? {};
	const { alt_text: altTallSummer, source_url: logoUrlTallSummer } = mediaItemDataTallSummer ?? {};

	const onInitialSelectLogoLongSummer = ( media ) => {
		let version = 'long'
		let season = 'summer'

		onInitialSelectLogo( media, version, season );
	};

	const onSelectLogoLongSummer = ( media, shouldForceSync = false ) => {
		let version = 'long'
		let season = 'summer'

		onSelectLogo( media, shouldForceSync, version, season );
	};

	const onRemoveLogoLongSummer = ( shouldForceSync ) => {
		let version = 'long'
		let season = 'summer'

		setLogo( null, shouldForceSync, version, season );

		//setAttributes( { width: undefined } );
	};

	const onUploadErrorLongSummer = ( message ) => {
		let version = 'long'
		let season = 'summer'

		onUploadError( message, version, season ) 
	};

	const onFilesDropLongSummer = ( filesList ) => {
		let params = {
			onError: onUploadLongSummer,
		}

		onFilesDrop( params, version = 'long', season = 'summer' )
	};

	const onInitialSelectLogoTallSummer = ( media ) => {
		let version = 'tall'
		let season = 'summer'

		onInitialSelectLogo( media, version, season );
	};

	const onSelectLogoTallSummer = ( media, shouldForceSync = false ) => {
		let version = 'tall'
		let season = 'summer'

		onSelectLogo( media, shouldForceSync, version, season );
	};

	const onRemoveLogoTallSummer = ( shouldForceSync ) => {
		let version = 'tall'
		let season = 'summer'

		setLogo( null, shouldForceSync, version, season );

		//setAttributes( { width: undefined } );
	};

	const onUploadErrorTallSummer = ( message ) => {
		let version = 'tall'
		let season = 'summer'

		onUploadError( message, version, season ) 
	};

	const onFilesDropTallSummer = ( filesList ) => {
		let params = {
			onError: onUploadTallSummer,
		}

		onFilesDrop( params, version = 'tall', season = 'summer' )
	};

	const mediaReplaceFlowPropsLongSummer = {
		mediaURL: logoUrlLongSummer,
		name: ! logoUrlLongSummer ? __( 'Choose logo (summer - long version)' ) : __( 'Replace' ),
		onSelect: onSelectLogoLongSummer,
		onError: onUploadErrorLongSummer,
		onReset: onRemoveLogoLongSummer,
	};

	const mediaReplaceFlowPropsTallSummer = {
		mediaURL: logoUrlTallSummer,
		name: ! logoUrlTallSummer ? __( 'Choose logo (summer - tall version)' ) : __( 'Replace' ),
		onSelect: onSelectLogoTallSummer,
		onError: onUploadErrorTallSummer,
		onReset: onRemoveLogoTallSummer,
	};

	const isLoadingTallSummer = siteLogoIdTallSummer === undefined || isRequestingMediaItemTallSummer;
	const isLoadingLongSummer = siteLogoIdLongSummer === undefined || isRequestingMediaItemLongSummer;

	// Fall
	const { alt_text: altLongFall, source_url: logoUrlLongFall } = mediaItemDataLongFall ?? {};
	const { alt_text: altTallFall, source_url: logoUrlTallFall } = mediaItemDataTallFall ?? {};

	const onInitialSelectLogoLongFall = ( media ) => {
		let version = 'long'
		let season = 'fall'

		onInitialSelectLogo( media, version, season );
	};

	const onSelectLogoLongFall = ( media, shouldForceSync = false ) => {
		let version = 'long'
		let season = 'fall'

		onSelectLogo( media, shouldForceSync, version, season );
	};

	const onRemoveLogoLongFall = ( shouldForceSync ) => {
		let version = 'long'
		let season = 'fall'

		setLogo( null, shouldForceSync, version, season );

		//setAttributes( { width: undefined } );
	};

	const onUploadErrorLongFall = ( message ) => {
		let version = 'long'
		let season = 'fall'

		onUploadError( message, version, season ) 
	};

	const onFilesDropLongFall = ( filesList ) => {
		let params = {
			onError: onUploadLongFall,
		}

		onFilesDrop( params, version = 'long', season = 'fall' )
	};

	const onInitialSelectLogoTallFall = ( media ) => {
		let version = 'tall'
		let season = 'fall'

		onInitialSelectLogo( media, version, season );
	};

	const onSelectLogoTallFall = ( media, shouldForceSync = false ) => {
		let version = 'tall'
		let season = 'fall'

		onSelectLogo( media, shouldForceSync, version, season );
	};

	const onRemoveLogoTallFall = ( shouldForceSync ) => {
		let version = 'tall'
		let season = 'fall'

		setLogo( null, shouldForceSync, version, season );

		//setAttributes( { width: undefined } );
	};

	const onUploadErrorTallFall = ( message ) => {
		let version = 'tall'
		let season = 'fall'

		onUploadError( message, version, season ) 
	};

	const onFilesDropTallFall = ( filesList ) => {
		let params = {
			onError: onUploadTallFall,
		}

		onFilesDrop( params, version = 'tall', season = 'fall' )
	};

	const mediaReplaceFlowPropsLongFall = {
		mediaURL: logoUrlLongFall,
		name: ! logoUrlLongFall ? __( 'Choose logo (fall - long version)' ) : __( 'Replace' ),
		onSelect: onSelectLogoLongFall,
		onError: onUploadErrorLongFall,
		onReset: onRemoveLogoLongFall,
	};

	const mediaReplaceFlowPropsTallFall = {
		mediaURL: logoUrlTallFall,
		name: ! logoUrlTallFall ? __( 'Choose logo (fall - tall version)' ) : __( 'Replace' ),
		onSelect: onSelectLogoTallFall,
		onError: onUploadErrorTallFall,
		onReset: onRemoveLogoTallFall,
	};

	const isLoadingTallFall = siteLogoIdTallFall === undefined || isRequestingMediaItemTallFall;
	const isLoadingLongFall = siteLogoIdLongFall === undefined || isRequestingMediaItemLongFall;

	//onsole.log(logoUrlTall)



	// Content
	let logoImage, logoUrl, temporaryURL, isLoading, placeholderParams;

	if( showVersion === 'long-winter' ) {
		if( isLoadingLongWinter ) {
			logoImage = <Spinner />;
		}

		logoUrl = logoUrlLongWinter;
		temporaryURL = temporaryURLLongWinter
		isLoading = isLoadingLongWinter
		placeholderParams = {
			onError: onUploadErrorLongWinter,
		}
	} else if( showVersion === 'tall-winter' ) {
		if( isLoadingTallWinter ) {
			logoImage = <Spinner />;
		}

		logoUrl = logoUrlTallWinter;
		temporaryURL = temporaryURLTallWinter
		isLoading = isLoadingTallWinter
		placeholderParams = {
			onError: onUploadErrorTallWinter,
		}
	} else if( showVersion === 'long-spring' ) {
		if( isLoadingLongSpring ) {
			logoImage = <Spinner />;
		}

		logoUrl = logoUrlLongSpring;
		temporaryURL = temporaryURLLongSpring
		isLoading = isLoadingLongSpring

		placeholderParams = {
			onError: onUploadErrorLongWinter,
		}
	} else if( showVersion === 'tall-spring' ) {
		if( isLoadingTallSpring ) {
			logoImage = <Spinner />;
		}

		logoUrl = logoUrlTallSpring;
		temporaryURL = temporaryURLTallSpring
		isLoading = isLoadingTallSpring
		placeholderParams = {
			onError: onUploadErrorTallWinter,
		}
	} else if( showVersion === 'long-summer' ) {
		if( isLoadingLongSummer ) {
			logoImage = <Spinner />;
		}

		logoUrl = logoUrlLongSummer;
		temporaryURL = temporaryURLLongSummer
		isLoading = isLoadingLongSummer

		placeholderParams = {
			onError: onUploadErrorLongWinter,
		}
	} else if( showVersion === 'tall-summer' ) {
		if( isLoadingTallSummer ) {
			logoImage = <Spinner />;
		}

		logoUrl = logoUrlTallSummer;
		temporaryURL = temporaryURLTallSummer
		isLoading = isLoadingTallSummer
		placeholderParams = {
			onError: onUploadErrorTallWinter,
		}
	} else if( showVersion === 'long-fall' ) {
		if( isLoadingLongFall ) {
			logoImage = <Spinner />;
		}

		logoUrl = logoUrlLongFall;
		temporaryURL = temporaryURLLongFall
		isLoading = isLoadingLongFall

		placeholderParams = {
			onError: onUploadErrorLongWinter,
		}
	} else if( showVersion === 'tall-fall' ) {
		if( isLoadingTallFall ) {
			logoImage = <Spinner />;
		}

		logoUrl = logoUrlTallFall;
		temporaryURL = temporaryURLTallFall
		isLoading = isLoadingTallFall
		placeholderParams = {
			onError: onUploadErrorTallWinter,
		}
	}  

	if ( logoUrl || temporaryURL ) {
		logoImage = (
			<>
				<SiteLogo
					attributes={ attributes }
					className={ className }
					isSelected={ isSelected }
					setAttributes={ setAttributes }

					logoUrlTallWinter={ temporaryURLTallWinter || logoUrlTallWinter }
					logoIdTallWinter={ mediaItemDataTallWinter?.id || siteLogoIdTallWinter }

					logoUrlLongWinter={ temporaryURLLongWinter || logoUrlLongWinter }
					logoIdLongWinter={ mediaItemDataLongWinter?.id || siteLogoIdLongWinter }

					logoUrlTallSpring={ temporaryURLTallSpring || logoUrlTallSpring }
					logoIdTallSpring={ mediaItemDataTallSpring?.id || siteLogoIdTallSpring }

					logoUrlLongSpring={ temporaryURLLongSpring || logoUrlLongSpring }
					logoIdLongSpring={ mediaItemDataLongSpring?.id || siteLogoIdLongSpring }

					logoUrlTallSummer={ temporaryURLTallSummer || logoUrlTallSummer }
					logoIdTallSummer={ mediaItemDataTallSummer?.id || siteLogoIdTallSummer }

					logoUrlLongSummer={ temporaryURLLongSummer || logoUrlLongSummer }
					logoIdLongSummer={ mediaItemDataLongSummer?.id || siteLogoIdLongSummer }

					logoUrlTallFall={ temporaryURLTallFall || logoUrlTallFall }
					logoIdTallFall={ mediaItemDataTallFall?.id || siteLogoIdTallFall }

					logoUrlLongFall={ temporaryURLLongFall || logoUrlLongFall }
					logoIdLongFall={ mediaItemDataLongFall?.id || siteLogoIdLongFall }

					siteUrl={ url }
					canUserEdit={ canUserEdit }
				/>

				{ canUserEdit && <DropZone onFilesDrop={ onFilesDropTallWinter } /> }
			</>
		);
	}
		//onsole.log(logoImage)
	const placeholder = ( content, logoImage ) => {
		const placeholderClassName = clsx(
			'block-editor-media-placeholder',
			className
		);


		return (
			<Placeholder
				className={ placeholderClassName }
				preview={ logoImage }
				withIllustration
				style={ {
					width,
				} }
			>
				{ content }
			</Placeholder>
		);
	};

	// Reset temporary url when logoUrl is available.
	useEffect( () => {
		if ( logoUrlTallWinter && temporaryURLTallWinter ) {
			setTemporaryURLTallWinter();
		}

		if ( logoUrlTallSpring && temporaryURLTallSpring ) {
			setTemporaryURLTallSpring();
		}

		if ( logoUrlTallSummer && temporaryURLTallSummer ) {
			setTemporaryURLTallSummer();
		}

		if ( logoUrlTallFall && temporaryURLTallFall ) {
			setTemporaryURLTallFall();
		}
	}, [ 
		logoUrlTallWinter, temporaryURLTallWinter, logoUrlLongWinter, temporaryURLLongWinter,
		logoUrlTallSpring, temporaryURLTallSpring, logoUrlLongSpring, temporaryURLLongSpring,
		logoUrlTallSummer, temporaryURLTallSummer, logoUrlLongSummer, temporaryURLLongSummer,
		logoUrlTallFall, temporaryURLTallFall, logoUrlLongFall, temporaryURLLongFall,
	] );

	const classes = clsx( className, 'blockprops', {
		'is-layout-constrained': align,
		'is-default-size': ! width,
		'is-transient-tall-winter': temporaryURLTallWinter,
		'is-transient-long-winter': temporaryURLLongWinter,
		'is-transient-tall-spring': temporaryURLTallSpring,
		'is-transient-long-spring': temporaryURLLongSpring,
		'is-transient-tall-summer': temporaryURLTallSummer,
		'is-transient-long-summer': temporaryURLLongSummer,
		'is-transient-tall-fall': temporaryURLTallFall,
		'is-transient-long-fall': temporaryURLLongFall,
	} );

	const blockProps = useBlockProps( { className: classes } );

	const mediaInspectorPanel = ( canUserEdit || logoUrl || logoUrl ) && (
		<InspectorControls>
			<PanelBody title={ __( 'Media' ) }>
				<div className="block-library-site-logo__inspector-media-replace-container">
					{ ! canUserEdit ? (
						<InspectorLogoPreview
							media={ mediaItemDataTall }
							itemGroupProps={ {
								isBordered: true,
								className:
									'block-library-site-logo__inspector-readonly-logo-preview',
							} }
						/>
					) : (
						<>
							<SelectControl
								marginTop= "2rem"
								label={ __( 'Show version (this instance)' ) }
								value={ selectedVersion }
								onChange={ ( value ) => setAttributes( { selectedVersion: value } ) }
								options={ [
									{ value: 'tall', label: __( 'Tall') },
									{ value: 'long', label: __( 'Long') },
								] }
							/>

							{ false && <SelectControl
								marginTop= "2rem"
								label={ __( 'Show season (this instance)' ) }
								value={ selectedVersion }
								onChange={ ( value ) => setAttributes( { selectedVersion: value } ) }
								options={ [
									{ value: 'automatic', label: __( 'Automatic') },
									{ value: 'winter', label: __( 'Winter') },
									{ value: 'spring', label: __( 'Spring') },
									{ value: 'summer', label: __( 'Summer') },
									{ value: 'fall', label: __( 'Fall') },
								] }
							/> }

							<h3 style={{ marginTop: "0", marginBottom: "0" }}>Winter - Tall Version</h3>
							<SiteLogoReplaceFlow
								{ ...mediaReplaceFlowPropsTallWinter }
								name={
									!! logoUrlTallWinter ? (
										<InspectorLogoPreview
											media={ mediaItemDataTallWinter }
										/>
									) : (
										__( 'Choose logo (tall version)' )
									)
								}

								renderToggle={ ( props ) => (
									<Button { ...props } __next40pxDefaultSize>
										{ temporaryURLTallWinter ? (
											<Spinner />
										) : (
											props.children
										) }
									</Button>
								) }
							/>
							<DropZone onFilesDrop={ onFilesDropTallWinter } />

							<h3 style={{ marginTop: "2rem", marginBottom: "0" }}>Winter - Long Version</h3>
							<SiteLogoReplaceFlow
								{ ...mediaReplaceFlowPropsLongWinter }
								name={
									!! logoUrlLongWinter ? (
										<InspectorLogoPreview
											media={ mediaItemDataLongWinter }
										/>
									) : (
										__( 'Choose logo (winter - long version)' )
									)
								}

								renderToggle={ ( props ) => (
									<Button { ...props } __next40pxDefaultSize>
										{ temporaryURLLongWinter ? (
											<Spinner />
										) : (
											props.children
										) }
									</Button>
								) }
							/>
							<DropZone onFilesDrop={ onFilesDropLongWinter } />

							<h3 style={{ marginTop: "2rem", marginBottom: "0" }}>Spring - Tall Version</h3>
							<SiteLogoReplaceFlow
								{ ...mediaReplaceFlowPropsTallSpring }
								name={
									!! logoUrlTallSpring ? (
										<InspectorLogoPreview
											media={ mediaItemDataTallSpring }
										/>
									) : (
										__( 'Choose logo (tall version)' )
									)
								}

								renderToggle={ ( props ) => (
									<Button { ...props } __next40pxDefaultSize>
										{ temporaryURLTallSpring ? (
											<Spinner />
										) : (
											props.children
										) }
									</Button>
								) }
							/>
							<DropZone onFilesDrop={ onFilesDropTallSpring } />

							<h3 style={{ marginTop: "2rem", marginBottom: "0" }}>Spring - Long Version</h3>
							<SiteLogoReplaceFlow
								{ ...mediaReplaceFlowPropsLongSpring }
								name={
									!! logoUrlLongSpring ? (
										<InspectorLogoPreview
											media={ mediaItemDataLongSpring }
										/>
									) : (
										__( 'Choose logo (spring - long version)' )
									)
								}

								renderToggle={ ( props ) => (
									<Button { ...props } __next40pxDefaultSize>
										{ temporaryURLLongSpring ? (
											<Spinner />
										) : (
											props.children
										) }
									</Button>
								) }
							/>
							<DropZone onFilesDrop={ onFilesDropLongSpring } />

							<h3 style={{ marginTop: "2rem", marginBottom: "0" }}>Summer - Tall Version</h3>
							<SiteLogoReplaceFlow
								{ ...mediaReplaceFlowPropsTallSummer }
								name={
									!! logoUrlTallSummer ? (
										<InspectorLogoPreview
											media={ mediaItemDataTallSummer }
										/>
									) : (
										__( 'Choose logo (tall version)' )
									)
								}

								renderToggle={ ( props ) => (
									<Button { ...props } __next40pxDefaultSize>
										{ temporaryURLTallSummer ? (
											<Spinner />
										) : (
											props.children
										) }
									</Button>
								) }
							/>
							<DropZone onFilesDrop={ onFilesDropTallSummer } />

							<h3 style={{ marginTop: "2rem", marginBottom: "0" }}>Summer - Long Version</h3>
							<SiteLogoReplaceFlow
								{ ...mediaReplaceFlowPropsLongSummer }
								name={
									!! logoUrlLongSummer ? (
										<InspectorLogoPreview
											media={ mediaItemDataLongSummer }
										/>
									) : (
										__( 'Choose logo (summer - long version)' )
									)
								}

								renderToggle={ ( props ) => (
									<Button { ...props } __next40pxDefaultSize>
										{ temporaryURLLongSummer ? (
											<Spinner />
										) : (
											props.children
										) }
									</Button>
								) }
							/>
							<DropZone onFilesDrop={ onFilesDropLongSummer } />

							<h3 style={{ marginTop: "2rem", marginBottom: "0" }}>Fall - Tall Version</h3>
							<SiteLogoReplaceFlow
								{ ...mediaReplaceFlowPropsTallFall }
								name={
									!! logoUrlTallFall ? (
										<InspectorLogoPreview
											media={ mediaItemDataTallFall }
										/>
									) : (
										__( 'Choose logo (tall version)' )
									)
								}

								renderToggle={ ( props ) => (
									<Button { ...props } __next40pxDefaultSize>
										{ temporaryURLTallFall ? (
											<Spinner />
										) : (
											props.children
										) }
									</Button>
								) }
							/>
							<DropZone onFilesDrop={ onFilesDropTallFall } />

							<h3 style={{ marginTop: "2rem", marginBottom: "0" }}>Fall - Long Version</h3>
							<SiteLogoReplaceFlow
								{ ...mediaReplaceFlowPropsLongFall }
								name={
									!! logoUrlLongFall ? (
										<InspectorLogoPreview
											media={ mediaItemDataLongFall }
										/>
									) : (
										__( 'Choose logo (fall - long version)' )
									)
								}

								renderToggle={ ( props ) => (
									<Button { ...props } __next40pxDefaultSize>
										{ temporaryURLLongFall ? (
											<Spinner />
										) : (
											props.children
										) }
									</Button>
								) }
							/>
							<DropZone onFilesDrop={ onFilesDropLongFall } />
						</>
					) }
				</div>
			</PanelBody>
		</InspectorControls>
	);

	return (
		<div { ...blockProps }>
			{ mediaInspectorPanel }

			{ ( !! logoUrl || !! temporaryURL ) && logoImage }

			{ ( isLoading ||
				( ! temporaryURL && ! logoUrl && ! canUserEdit ) ) && (
				<Placeholder className="site-logo_placeholder" withIllustration>
					{ isLoading && (
						<span className="components-placeholder__preview">
							<Spinner />
						</span>
					) }
				</Placeholder>
			) }

			{ ! isLoading && ! temporaryURL && ! logoUrl && canUserEdit && (
				<MediaPlaceholder
					{ ...placeholderParams }
					onSelect={ onInitialSelectLogoTallWinter }
					accept={ ACCEPT_MEDIA_STRING }
					allowedTypes={ ALLOWED_MEDIA_TYPES }
					placeholder={ placeholder }
					mediaLibraryButton={ ( { open } ) => {
						return (
							<Button
								__next40pxDefaultSize
								icon={ upload }
								variant="primary"
								label={ __( 'Choose logo' ) }
								showTooltip
								tooltipPosition="middle right"
								onClick={ () => {
									open();
								} }
							/>
						);
					} }
				/>
			) }
		</div>
	);
}
