// External dependencies
import clsx from 'clsx';

// WordPress dependencies
import {
    InnerBlocks,
    useBlockProps,
    useInnerBlocksProps,
} from '@wordpress/block-editor';

// Internal dependencies

export default function save( { attributes, clientId, className } ) {
    const { anchor, author, group, parentId } = attributes;

    //console.log(anchor)

    const blockProps = useBlockProps.save( {
        className: clsx(
            'embla__slide',
            className ? className : null,
        ),
    } )
    
    return <div { ...blockProps }>
        <InnerBlocks.Content />
    </div>
}