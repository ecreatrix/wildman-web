// External dependencies
import clsx from 'clsx';

// WordPress dependencies
import {
	InnerBlocks,
	useBlockProps,
} from '@wordpress/block-editor';

// Internal dependencies

export default function save( {
		attributes, 
		attributes: { anchor },
	} ) {

	let blockProps = useBlockProps.save( { 
		id: `${ anchor }`,
		//className: clsx(
		//	'join join-vertical'
		//)
	} )

	return (
		<div { ...blockProps }>
			<InnerBlocks.Content />
		</div>
	)
}
