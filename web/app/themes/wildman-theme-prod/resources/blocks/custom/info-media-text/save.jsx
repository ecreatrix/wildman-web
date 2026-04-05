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
        attributes: { layout },
    } = props

    const blockProps = useBlockProps.save({
        className: clsx(
            'wa-block-container',
            layout?.type ? `is-layout-${ layout?.type }` : '',
        )
    });

    const innerClasses = clsx(
        'wp-block-wa-info-media-text__inner-container',
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