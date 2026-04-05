// External dependencies
import clsx from 'clsx';

// WordPress dependencies
import { __ } from '@wordpress/i18n';

import {
	useBlockProps,
	InspectorControls,
	InnerBlocks,
	BlockControls,
	useInnerBlocksProps,
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

import './editor.css';

const ALLOWED_BLOCKS = [ 'core/paragraph', 'core/list', 'core/heading' ];

import { buildID } from '../../utils/create-id'

export default function Edit( props ) {
	const { 
		attributes, 
		attributes: { anchor, panels, allowMultipleOpen },
		setAttributes, 
		className,
		clientId 
	} = props

	useEffect( () => {
		if( !anchor || anchor === '' ) {
			setAttributes( { anchor: buildID('collapse-') } )
		}
	}, [ anchor, setAttributes ] )

	const blockProps = useBlockProps( {
		id: `${ anchor }`,
		className: clsx(
			className,
			'-mb-2',
		),
	} )
	//blockProps.className += ` ${ getBlockClasses( { attributes, colourProps } ) }`
	const innerBlocksProps = useInnerBlocksProps(blockProps, {
		template: [ 
			[ 'wa/carousel-slide' ],
		],
		allowedBlocks: [ 
			[ 'wa/carousel-slide' ] 
		],
		templateInsertUpdatesSelection: true,
	})

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Carousel item settings' ) }>
					<ToggleControl
						label={ __( 'Allow multiple slides to be open simultaneously' ) }
						checked={ allowMultipleOpen }
						onChange={ ( value ) =>
							setAttributes( {
								allowMultipleOpen: value,
							} )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div { ...innerBlocksProps } />
			</div>
		</>
	);
}