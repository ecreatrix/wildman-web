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
import { select } from '@wordpress/data';

//<!-- wp:cover {"url":"http://wildman.test/app/uploads/2025/08/wood-on-snow.webp","id":2013,"dimRatio":40,"overlayColor":"black","isUserOverlayColor":true,"minHeight":50,"minHeightUnit":"vh","sizeSlug":"full","align":"full","className":"is-style-hero-button","layout":{"type":"constrained"}} --><div class="wp-block-cover alignfull is-style-hero-button" style="min-height:50vh"><img class="wp-block-cover__image-background wp-image-2013 size-full" alt="" src="http://wildman.test/app/uploads/2025/08/wood-on-snow.webp" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim-40 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:post-title {"textAlign":"center","level":1} /--></div></div><!-- /wp:cover -->
function mediaTextVariationParams() {
	const params = {
		name: 'hero-cover',

		title: 'Hero Cover',

		attributes: {
			align: 'full',
			dimRatio: 40,
			backgroundColor: "season",
			overlayColor: "black",
			isUserOverlayColor: true,
			minHeight: 70,
			minHeightUnit: "vh",
			sizeSlug: "full",
			layout: {
				"type":"constrained"
			}
		},

		innerBlocks: [
			[
				'core/group', {}, [
					[ 'core/post-title', {
							textAlign: 'center',
							level: 1
						} 
					]
				]
			]
		],
		isDefault: false,
		//isActive: ( blockAttributes, variationAttributes ) =>
		//	blockAttributes.providerNameSlug === variationAttributes.providerNameSlug
	}

	//not working
	/*const featuredImageId = select('core/editor').getEditedPostAttribute('featured_media');
	if (featuredImageId) {
		const media = select('core').getMedia(featuredImageId);
    	const featuredImageUrl = media ? media.source_url : null;

    	if (featuredImageUrl) {
    		params.attributes.url = featuredImageUrl
    	}
    }

    console.log(params)*/

	return params
}

window.onload = function() {
	registerBlockVariation( 'core/cover', mediaTextVariationParams() )
}