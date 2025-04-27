// External dependencies
import clsx from 'clsx';

// WordPress dependencies

import { __ } from '@wordpress/i18n';

import {
	InnerBlocks,
	InspectorControls,
	useBlockProps,
	useInnerBlocksProps,
	store as coreStore
} from '@wordpress/block-editor';

import {
	PanelBody,
	Button,
	TextControl,
	ToggleControl,
} from '@wordpress/components';

import {
	useState,
	useRef,
	useEffect,
} from '@wordpress/element';

import { useSelect } from '@wordpress/data';

import './editor.css';

import { buildID } from '../../utils/create-id'

import { buttonClasses } from './const'

export default function Edit( props ) {
	const { 
		attributes, 
		attributes: { anchor, parentId, heading, startCollapsed, allowMultipleOpen,  },
		setAttributes, 
		clientId,
		className,
	} = props
	
	const parentAttributes = useSelect( ( select ) => {
		const {
			getBlockParents,
			getBlock,
		} = select( coreStore )

		const parents = getBlockParents( clientId, true )
		const hasParents = !! parents.length
		const parentBlock = hasParents ? getBlock( parents[ 0 ] ) : {}
		return parentBlock?.attributes || false
	}, [ ] )

	useEffect( () => {
		if( !anchor || anchor === '' ) {
			setAttributes( { anchor: buildID('item-') } )
		}

		if( allowMultipleOpen !== parentAttributes.allowMultipleOpen ) {
			setAttributes( { allowMultipleOpen: parentAttributes.allowMultipleOpen } )
		}

		//onsole.log(parentAttributes)

		if( !parentId || parentId === '' || parentId !== parentAttributes.anchor ) {
			setAttributes( { parentId: parentAttributes.anchor } )
		}
	}, [ anchor, parentAttributes, parentId ] )

	//onsole.log(attributes)

	const blockProps = useBlockProps( {
	} )

	const { hasInnerBlocks } = useSelect(
		( select ) => {
			const { getBlock } = select( coreStore );

			const block = getBlock( clientId );

			return {
				hasInnerBlocks: !! ( block && block.innerBlocks.length ),
			};
		},
		[ clientId ]
	);

	const innerBlocksProps = useInnerBlocksProps(
		blockProps,
		{
			//templateLock: false,
			allowedBlocks: [
				'core/list',
				'core/image',
				'core/table',
				'core/button',
				'core/group',
				'core/paragraph',
				'core/heading',
				'core/separator',
				'core/column',
				'core/columns',
				'core/gallery',
			],
			renderAppender: hasInnerBlocks
				? undefined
				: InnerBlocks.ButtonBlockAppender,
			template: [ [ 'core/paragraph', {
				placeholder: 'Enter content...'
			} ] ]
		}
	)

	blockProps.className += clsx(
		' ',
		className,
		'collapsable-content mb-4 pb-4 border-b'
	)

	//const innerBlocksProps2 = useInnerBlocksProps();

    const contentClasses = clsx(
        '!visible',
        //startCollapsed && 'hidden'
    )

    let panelTitle = `Panel Title (will be ${ startCollapsed ? 'hidden' : 'visible' } on page load)`

	return <>
			<InspectorControls>
				<PanelBody title={ __( 'Accordion item settings' ) }>
					<ToggleControl
						label={ __( 'Start collapsed' ) }
						checked={ startCollapsed }
						onChange={ ( value ) =>
							setAttributes( {
								startCollapsed: value,
							} )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
	        <h2 className="mb-0" id={ `heading${ anchor }` }>
	            <button className='group relative flex w-full items-center rounded-none border-0 bg-white text-left text-base text-neutral-800' type="button">
					<TextControl
						className="w-full pr-3"
						label={ __( panelTitle, 'watheme' ) }
						value={ heading }
						onChange={ ( value ) => setAttributes( { heading: value } ) }
					/>
	                <span className="-me-1 ms-auto h-5 w-5 shrink-0 rotate-[-180deg] transition-transform duration-200 ease-in-out group-data-[twe-collapse-collapsed]:me-0 group-data-[twe-collapse-collapsed]:rotate-0 motion-reduce:transition-none [&>svg]:h-6 [&>svg]:w-6">
	                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
	                </span>
	            </button>
	        </h2>
	        <div className={ contentClasses }>
	            <div className="content-container">
	                <div { ...innerBlocksProps } />
	            </div>
	        </div>
	    </div>
    </>
}