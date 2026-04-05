/**
 * External dependencies
 */
import clsx from 'clsx';

/**
 * WordPress dependencies
 */
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

import { useSelect } from '@wordpress/data';

export default function Save(props) {
    const {
        attributes, 
        attributes: { layout, verticalAlign },
    } = props

    const blockProps = useBlockProps.save({
        className: clsx(
            layout?.type ? `is-layout-${ layout?.type }` : '',
            `align-items-${verticalAlign}`,
        )
    });

    const innerClasses = clsx(
        'wp-block-wa-page-title__inner-container',
        'w-full h-full',
    );
    
    return (
        <div { ...blockProps }>
            <div className={innerClasses}>
                <InnerBlocks.Content />
            </div>
        </div>
    );
};