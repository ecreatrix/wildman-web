/**
 * External dependencies
 */
import classnames from 'clsx';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

import { addFilter } from '@wordpress/hooks';

import { unregisterBlockStyle, registerBlockStyle } from '@wordpress/blocks';

import { 
	InspectorControls, 
	LinkControl,
	BlockControls,
	store as blockEditorStore,
} from '@wordpress/block-editor';

import {
	createInterpolateElement,
	useMemo,
	useState,
	useRef,
	useEffect,
	forwardRef,
} from '@wordpress/element';

import {
	createBlock,
	cloneBlock,
	getDefaultBlockName,
	getBlockBindingsSource,
	registerBlockVariation,
} from '@wordpress/blocks';

import {
	Button,
	PanelBody,
	PanelRow,
	ToggleControl,
	__experimentalGrid as Grid,
} from '@wordpress/components';

import { store as coreStore, useEntityProp } from '@wordpress/core-data';

import { prependHTTP } from '@wordpress/url';

import { useSelect, useDispatch } from '@wordpress/data';

const mediaTextVariationParams = {
	name: 'media-text-categories',

	title: 'Media & Text (Categories)',

	attributes: {
		align: 'wide',
		backgroundColor: 'base',
		verticalAlignment: "center",
		imageFill: true,
		className: 'media-text-categories'
	},

	innerBlocks: [
		[
			'core/group',
			{},
			[
				[ 'core/paragraph', {
						placeholder: 'Category',
						content: '<strong></strong>',
						fontSize: "small",
						className: "media-block-category",
					    /*style: {
					    	spacing: {
						        margin: {
						            top: "var:preset|spacing|30",
						            bottom: "var:preset|spacing|30"
						        }
						    }
					    }*/
					} 
				], [
					'core/heading', {
						level: 2,
						placeholder: 'Heading',
						attributes: {
							textAlign: 'left',
						}
					} 
				], [
					'core/paragraph', {
						placeholder: 'Enter content here...'
					} 
				], [
					'core/button', {
						text: __( 'Book on DoubleKnot' ),
						"useBookingLink": true,
					},
				],
			]
		]
	],
	isDefault: true,
	isActive: ( blockAttributes, variationAttributes ) =>
		blockAttributes.providerNameSlug === variationAttributes.providerNameSlug,
}

window.onload = function() {
	registerBlockVariation( 'core/media-text', mediaTextVariationParams )
}