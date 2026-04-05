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

export default function Edit( props ) {
	const { 
		attributes, 
		attributes: { anchor, parentId },
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
		//onsole.log(parentAttributes)

		if( !parentId || parentId === '' || parentId !== parentAttributes.anchor ) {
			setAttributes( { parentId: parentAttributes.anchor } )
		}
	}, [ anchor, parentAttributes, parentId ] )

	//onsole.log(attributes)

	const blockProps = useBlockProps( {
		//className: clsx(
		//	className,
		//	'mb-4 pb-4 border-b'
		//),
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
			],

			renderAppender: hasInnerBlocks
				? undefined
				: InnerBlocks.ButtonBlockAppender,

			template: [ [ 'core/paragraph', {
				placeholder: 'Enter content...'
			} ] ],

			className: '',
		}
	)

	blockProps.className += clsx(
		' ',
		className,
		'mb-4 pb-4 border-b'
	)

	//const innerBlocksProps2 = useInnerBlocksProps();

	return <>
			<InspectorControls>
				<PanelBody title={ __( 'Carousel item settings' ) }>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
		        <div { ...innerBlocksProps } />
	    </div>
    </>
}