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

    let authorContent = author ? <span className="author block text-sm"><strong>{ author }</strong></span> : ''
    let groupContent = group ? <span className="group block text-sm">{ group }</span> : ''

    return <div { ...blockProps }>
        <InnerBlocks.Content />
        <div className="reviewer mt-10">
            { authorContent }
            { groupContent }
        </div>
    </div>
}