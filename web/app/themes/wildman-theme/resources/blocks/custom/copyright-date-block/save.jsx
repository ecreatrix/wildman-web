/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InnerBlocks, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @param {Object} props            Properties passed to the function.
 * @param {Object} props.attributes Available block attributes.
 *
 * @return {Element} Element to render.
 */
export default function save( { attributes } ) {
	const { fallbackCurrentYear, showStartingYear, startingYear, showIcon } = attributes;
	
	const blockProps = useBlockProps.save( { 
		className: 'wa-block-copyright',
	} );

	// If there is no fallbackCurrentYear, which could happen if the block
	// is loaded from a template/pattern, return null. In this case, block
	// rendering will be handled by the render.php file.
	if ( ! fallbackCurrentYear ) {
		return null;
	}

	let displayDate;

	// Display the starting year as well if supplied by the user.
	if ( showStartingYear && startingYear ) {
		displayDate = startingYear + '–' + fallbackCurrentYear;
	} else {
		displayDate = fallbackCurrentYear;
	}

	const innerBlocksProps = useInnerBlocksProps.save( { 
		className: 'wa-copyright-inner-content' 
	} );

	//console.log(innerBlocksProps)

	return <div { ...blockProps }>
		<span>
			{ showIcon && '© ' }
			{ displayDate }
		</span>
		<div {...innerBlocksProps} />
	</div>
}