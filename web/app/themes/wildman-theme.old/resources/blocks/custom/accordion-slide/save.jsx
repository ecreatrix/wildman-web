// External dependencies
import clsx from 'clsx';

// WordPress dependencies
import {
    InnerBlocks,
    useBlockProps,
    useInnerBlocksProps,
} from '@wordpress/block-editor';

// Internal dependencies
import { buttonClasses } from './const'

export default function save( { attributes, clientId, className } ) {
    const { anchor, heading, allowMultipleOpen, startCollapsed, parentId } = attributes;

    //console.log(anchor)

    let classes = clsx(
        //'collapse collapse-plus join-item bg-base-100 border border-base-300',
        'collapsable-content rounded-none border border-e-0 border-s-0 border-t-0 border-neutral-200 bg-white dark:border-neutral-600 dark:bg-body-dark',
        className ? className : null,
    )

    const blockProps = useBlockProps.save( {
        className: classes,
    } )

    const contentClasses = clsx(
        '!visible',
        startCollapsed && 'hidden'
    )

    const dataTWEHeadingShow = startCollapsed ? { 'data-twe-collapse-collapsed': '' } : {}

    const dataTWEContentShow = !startCollapsed ? { 'data-twe-collapse-show': '' } : {}

    const dataTWEParent = !allowMultipleOpen ? { 'data-twe-parent': `#${ parentId }` } : {}

    return <div { ...blockProps }>
        <h2 className="mb-0" id={ `heading${ anchor }` }>
            <button className='group relative flex w-full items-center rounded-none border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none dark:bg-body-dark [&:not([data-twe-collapse-collapsed])]:bg-white [&:not([data-twe-collapse-collapsed])]:text-season [&:not([data-twe-collapse-collapsed])]:shadow-border-b' type="button" aria-expanded="true" aria-controls={ `collapse${ anchor }` } data-twe-collapse-init data-twe-target={ `#collapse${ anchor }` } { ...dataTWEHeadingShow }>
                { heading }
                <span className="-me-1 ms-auto h-5 w-5 shrink-0 rotate-[-180deg] transition-transform duration-200 ease-in-out group-data-[twe-collapse-collapsed]:me-0 group-data-[twe-collapse-collapsed]:rotate-0 motion-reduce:transition-none [&>svg]:h-6 [&>svg]:w-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                </span>
            </button>
        </h2>

        <div id={ `collapse${ anchor }` } className={ contentClasses } aria-labelledby={ `heading${ anchor }` } data-twe-collapse-item { ...dataTWEParent } { ...dataTWEContentShow }>
            <div className="content-container px-5 py-4">
                <InnerBlocks.Content />
            </div>
        </div>
    </div>
}