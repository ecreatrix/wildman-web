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

const groupVariationParams = {
	name: 'group-parent',

	title: 'Group (parent block)',

	attributes: {
		align: 'wide',
		backgroundColor: 'base',
		verticalAlignment: "center",
		imageFill: true
	},

	innerBlocks: [
		[
			'core/heading',
			{
				level: 2,
				placeholder: 'Heading'
			} 
		],
		[
			'core/paragraph',
			{
				placeholder: 'Enter content here...'
			} 
		],
	],
	isDefault: false,
	isActive: ( blockAttributes, variationAttributes ) =>
		blockAttributes.providerNameSlug === variationAttributes.providerNameSlug,
}
//console.log(groupVariationParams)
window.onload = function() {
	//registerBlockVariation( 'core/group', groupVariationParams )
}