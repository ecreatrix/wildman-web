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
	useSetting,
	useBlockProps, 
	useInnerBlocksProps,
	RichText, 
	BlockVerticalAlignmentToolbar, 
	store as blockEditorStore,
	__experimentalBlockAlignmentMatrixControl as BlockAlignmentMatrixControl,
	__experimentalBlockFullHeightAligmentControl as FullHeightAlignmentControl,
} from '@wordpress/block-editor';

import { useSelect, useDispatch } from '@wordpress/data';

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
		attributes, 
		attributes: { verticalAlign },
		setAttributes,
		//className,
		clientId,
		hasInnerBlocks,
	} = props

	//console.log(props)
	//console.log(attributes)
	//console.log( wp.data.select( 'core/block-editor' ).getBlocks() );

    // Get the current post's title from the editor store
	const { postTitle } = useSelect(
		( select ) => ({
			postTitle: select( 'core/editor' ).getEditedPostAttribute( 'title' ),
		}),
		[]
	);

    const ALLOWED_BLOCKS = [ 'core/cover' ];

    const TEMPLATE = [ [
    	'core/heading', 
    		{ "level":1, content: postTitle, "textAlign": "left", className: 'title-content', placeholder: 'Page title goes here...' },
    ] ]

    // Setup content positioning like the core/cover block. Use hooks to get and set the block's alignment attribute
	const { layout } = useSelect(
		( select ) => select( 'core/block-editor' ).getBlockAttributes( clientId ),
		[ clientId ]
	);

	const { updateBlockAttributes } = useDispatch( 'core/block-editor' );

    const onPositionChange = ( newValue ) => {
        updateBlockAttributes( clientId, { layout: { ...layout, contentJustification: newValue } } );
    };

	const blockProps = useBlockProps({
		className: clsx(
			layout?.type ? `is-layout-${ layout?.type }` : '',
        	`align-items-${verticalAlign}`
		)
    });

    const innerClasses = clsx(
        'wp-block-wa-page-title__inner-container',
        'w-full h-full',
    );

    return (
    	<>
    		<BlockControls group="block">
				<BlockVerticalAlignmentToolbar
                    value={verticalAlign}
                    onChange={(value) => setAttributes({ verticalAlign: value })}
                />
			</BlockControls>
	        <div { ...blockProps }>
                <div className={innerClasses}>
                	<InnerBlocks 
	                    template={ TEMPLATE }
	                    templateLock="all"
	                />
	            </div>
	        </div>
	    </>
    );
}
