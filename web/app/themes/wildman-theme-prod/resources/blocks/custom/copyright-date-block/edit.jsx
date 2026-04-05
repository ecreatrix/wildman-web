/**
 * External dependencies
 */
import clsx from 'clsx';

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * Imports the InspectorControls component, which is used to wrap
 * the block's custom controls that will appear in in the Settings
 * Sidebar when the block is selected.
 *
 * Also imports the React hook that is used to mark the block wrapper
 * element. It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#inspectorcontrols
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { 
	InnerBlocks,
	BlockControls,
	AlignmentControl,
	InspectorControls, 
	useBlockProps, 
	useInnerBlocksProps,
	RichText, 
	store as blockEditorStore,
} from '@wordpress/block-editor';

import { useSelect } from '@wordpress/data';

/**
 * Imports the necessary components that will be used to create
 * the user interface for the block's settings.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/panel/#panelbody
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/text-control/
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/toggle-control/
 */
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';

/**
 * Imports the useEffect React Hook. This is used to set an attribute when the
 * block is loaded in the Editor.
 *
 * @see https://react.dev/reference/react/useEffect
 */
import { useEffect } from '@wordpress/element';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {
	const {
		mergeBlocks,
		onReplace,
		onRemove,
		attributes, attributes: { align, content, showIcon, fallbackCurrentYear, showStartingYear, startingYear, placeholder },
		setAttributes,
		//className,
		clientId,
	} = props

	//console.log(props)

	const currentYear = new Date().getFullYear().toString();

	useEffect( () => {
		if ( startingYear == '' || !startingYear ) {
			setAttributes( { startingYear: currentYear } );
		}
		if ( currentYear !== fallbackCurrentYear ) {
			setAttributes( { fallbackCurrentYear: currentYear } );
		}
	}, [ currentYear, fallbackCurrentYear, setAttributes ] );

	let displayDate;

	// Display the starting year as well if supplied by the user.
	if ( showStartingYear && startingYear ) {
		displayDate = startingYear + '–' + currentYear;
	} else {
		displayDate = currentYear;
	}

	const blockProps = useBlockProps( {
		className: clsx( 
			'wa-block-copyright',
		{
			[ `has-text-align-${ align }` ]: align,
		} ),
	} );

	const { hasInnerBlocks } = useSelect(
		( select ) => {
			const { getBlock } = select( blockEditorStore );
			const block = getBlock( clientId );
			return {
				hasInnerBlocks: !! ( block && block.innerBlocks.length ),
			};
		},
		[ clientId ]
	);

	const innerBlocksProps = useInnerBlocksProps( {
			...blockProps,

			className: clsx(
				'wa-copyright-inner-content' ,
			),
		}, {
		template: [
			[
				'core/site-title',
				{
					className: 'site-title',
				}
			],[
				'core/paragraph',
				{
					type: 'text',
					label: placeholder,
					required: false,
				},
			]
		],
		renderAppender: hasInnerBlocks
			? undefined
			: InnerBlocks.ButtonBlockAppender,
	} );

	return (
		<>
			<BlockControls group="block">
				<AlignmentControl
					value={ align }
					onChange={ ( newAlign ) =>
						setAttributes( {
							align: newAlign,
						} )
					}
				/>
			</BlockControls>
			<InspectorControls>
				<PanelBody
					title={ __( 'Settings', 'watheme-domain' ) }
				>
					<ToggleControl
						checked={ showIcon }
						label={ __(
							'Show ©',
							'watheme'
						) }
						onChange={ () =>
							setAttributes( {
								showIcon: ! showIcon,
							} )
						}
					/>
					<ToggleControl
						checked={ showStartingYear }
						label={ __(
							'Show starting year',
							'watheme'
						) }
						onChange={ () =>
							setAttributes( {
								showStartingYear: ! showStartingYear,
							} )
						}
					/>
					{ showStartingYear && (
						<TextControl
							label={ __(
								'Starting year',
								'watheme'
							) }
							value={ startingYear }
							onChange={ ( value ) =>
								setAttributes( { startingYear: value } )
							}
						/>
					) }
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<span>
					{ showIcon && '© ' }
					{ displayDate }
				</span>
				<div
					{ ...innerBlocksProps }
				/>
			</div>
		</>
	);
}
