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

import { InspectorControls } from '@wordpress/block-editor';

import {
	Button,
	PanelBody,
	PanelRow,
	ToggleControl,
	__experimentalGrid as Grid,
} from '@wordpress/components';

import {
	arrowRight,
	arrowLeft,
	chevronLeft,
	chevronLeftSmall,
	chevronRight,
	chevronRightSmall,
	cloud,
	cloudUpload,
	commentAuthorAvatar,
	download,
	external,
	help,
	info,
	lockOutline,
	login,
	next,
	previous,
	shuffle,
	wordpress,
} from '../../../icons';

/**
 * All available icons.
 * (Order determines presentation order)
 */
export const ICONS = [
	{
		label: __( 'Chevron Right', 'watheme-domain' ),
		value: 'chevron-right',
		icon: chevronRight,
	},
	{
		label: __( 'Chevron Left', 'watheme-domain' ),
		value: 'chevron-left',
		icon: chevronLeft,
	},
	{
		label: __( 'Chevron Right (Small)', 'watheme-domain' ),
		value: 'chevron-right-small',
		icon: chevronRightSmall,
	},
	{
		label: __( 'Chevron Left (Small)', 'watheme-domain' ),
		value: 'chevron-left-small',
		icon: chevronLeftSmall,
	},
	{
		label: __( 'Shuffle', 'watheme-domain' ),
		value: 'shuffle',
		icon: shuffle,
	},
	{
		label: __( 'Arrow Right', 'watheme-domain' ),
		value: 'arrow-right',
		icon: arrowRight,
	},
	{
		label: __( 'Arrow Left', 'watheme-domain' ),
		value: 'arrow-left',
		icon: arrowLeft,
	},
	{
		label: __( 'Next', 'watheme-domain' ),
		value: 'next',
		icon: next,
	},
	{
		label: __( 'Previous', 'watheme-domain' ),
		value: 'previous',
		icon: previous,
	},
	{
		label: __( 'Download', 'watheme-domain' ),
		value: 'download',
		icon: download,
	},
	{
		label: __( 'External Arrow', 'watheme-domain' ),
		value: 'external-arrow',
		icon: (
			<svg
				width="24"
				height="24"
				viewBox="0 0 24 24"
				xmlns="http://www.w3.org/2000/svg"
			>
				<polygon points="18 6 8.15240328 6 8.15240328 8.1101993 14.3985932 8.1101993 6 16.5087925 7.4912075 18 15.8898007 9.6014068 15.8898007 15.8475967 18 15.8475967"></polygon>
			</svg>
		),
	},
	{
		label: __( 'External', 'watheme-domain' ),
		value: 'external',
		icon: external,
	},
	{
		label: __( 'Login', 'watheme-domain' ),
		value: 'login',
		icon: login,
	},
	{
		label: __( 'Lock', 'watheme-domain' ),
		value: 'lock-outline',
		icon: lockOutline,
	},
	{
		label: __( 'Avatar', 'watheme-domain' ),
		value: 'comment-author-avatar',
		icon: commentAuthorAvatar,
	},
	{
		label: __( 'Cloud', 'watheme-domain' ),
		value: 'cloud',
		icon: cloud,
	},
	{
		label: __( 'Cloud Upload', 'watheme-domain' ),
		value: 'cloud-upload',
		icon: cloudUpload,
	},
	{
		label: __( 'Help', 'watheme-domain' ),
		value: 'help',
		icon: help,
	},
	{
		label: __( 'Info', 'watheme-domain' ),
		value: 'info',
		icon: info,
	},
	{
		label: __( 'WordPress', 'watheme-domain' ),
		value: 'wordpress',
		icon: wordpress,
	},
];

/**
 * Add the attributes needed for button icons.
 *
 * @since 0.1.0
 * @param {Object} settings
 */
function addAttributes( settings ) {
	if ( 'core/button' !== settings.name ) {
		return settings;
	}

	const iconAttributes = {
		icon: {
			type: 'string',
		},
		iconPositionLeft: {
			type: 'boolean',
			default: false,
		},
		justifySpaceBetween: {
			type: 'boolean',
			default: false,
		},
	};
	
	const newSettings = {
		...settings,
		attributes: {
			...settings.attributes,
			...iconAttributes,
		},
	};

	return newSettings;
}

addFilter(
	'blocks.registerBlockType',
	'enable-button-icons/add-attributes',
	addAttributes
);

/**
 * Filter the BlockEdit object and add icon inspector controls to button blocks.
 *
 * @since 0.1.0
 * @param {Object} BlockEdit
 */
function addInspectorControlsIcons( BlockEdit ) {
	return ( settings ) => {
		if ( settings.name !== 'core/button' ) {
			return <BlockEdit { ...settings } />;
		}

		const { attributes, setAttributes } = settings;
		const { icon: currentIcon, iconPositionLeft, justifySpaceBetween } = attributes;

		/*const newSettings = {
			...settings,
			edit( props ) {
				return (
					<div
						attributes = {props.attributes}
						setAttributes = {props.setAttributes}
						clientId = {props.clientId}
					/>
				);
			},
			save( props ) {
				return (
			 	        <div
						attributes = {props.attributes}
					/>
				);
			},
		};

		return newSettings;*/

		//console.log(BlockEdit)

		return (
			<>
				<BlockEdit { ...settings } />
				<InspectorControls>
					<PanelBody
						title={ __( 'Icon settings', 'watheme-domain' ) }
						className="button-icon-picker"
						initialOpen={ true }
					>
						<PanelRow>
							<Grid
								className="button-icon-picker__grid"
								columns="5"
								gap="0"
							>
								{ ICONS.map( ( icon, index ) => (
									<Button
										key={ index }
										label={ icon?.label }
										isPressed={ currentIcon === icon.value }
										className="button-icon-picker__button"
										onClick={ () =>
											setAttributes( {
												// Allow user to disable icons.
												icon:
													currentIcon === icon.value
														? null
														: icon.value,
											} )
										}
									>
										{ icon.icon ?? icon.value }
									</Button>
								) ) }
							</Grid>
						</PanelRow>
						<PanelRow className="button-icon-picker__settings">
							<ToggleControl
								label={ __(
									'Show icon on left',
									'watheme'
								) }
								checked={ iconPositionLeft }
								onChange={ () => {
									setAttributes( {
										iconPositionLeft: ! iconPositionLeft,
									} );
								} }
							/>
							<ToggleControl
								label={ __(
									'Justify space between',
									'watheme'
								) }
								checked={ justifySpaceBetween }
								onChange={ () => {
									setAttributes( {
										justifySpaceBetween: ! justifySpaceBetween,
									} );
								} }
							/>
						</PanelRow>
					</PanelBody>
				</InspectorControls>
			</>
		);
	};
}

//addFilter( 'editor.BlockEdit', 'wa-edit-core/button/add-inspector-controls-icon', addInspectorControlsIcons);

function addInspectorControlsBorder( BlockEdit ) {
	return ( settings ) => {
		if ( settings.name !== 'core/button' ) {
			return <BlockEdit { ...settings } />;
		}

		const { attributes, setAttributes } = settings;
		const { icon: currentIcon, iconPositionLeft, justifySpaceBetween } = attributes;

		/*const newSettings = {
			...settings,
			edit( props ) {
				return (
					<div
						attributes = {props.attributes}
						setAttributes = {props.setAttributes}
						clientId = {props.clientId}
					/>
				);
			},
			save( props ) {
				return (
			 	        <div
						attributes = {props.attributes}
					/>
				);
			},
		};

		return newSettings;*/

		console.log(settings)

		return (
			<>
				<BlockEdit { ...settings } />
			</>
		);
	};
}
//addFilter( 'editor.BlockEdit', 'wa-edit-core/button/add-inspector-controls-border', addInspectorControlsBorder);

/*registerBlockVariation( 
    'core/button', 
    {
		name: "details-with-div",
		title: "Details with div",
		innerBlocks: [
			[
				"core/group",
				{
					className: "this-is-my-container-div",
				},
				[["core/paragraph", { placeholder: "Summary" }]],
			],
		],
    }
);*/

/**
 * Add icon and position classes in the Editor.
 *
 * @since 0.1.0
 * @param {Object} BlockListBlock
 */
function addClassesIcon( BlockListBlock ) {
	return ( props ) => {
		const { name, attributes } = props;

		if ( 'core/button' !== name || ! attributes?.icon ) {
			return <BlockListBlock { ...props } />;
		}

		const classes = classnames( props?.className, {
			[ `has-icon__${ attributes?.icon }` ]: attributes?.icon,
			'has-icon-position__left': attributes?.iconPositionLeft,
			'has-justified-space-between': attributes?.justifySpaceBetween,
		} );

		return <BlockListBlock { ...props } className={ classes } />;
	};
}

addFilter( 'editor.BlockListBlock', 'wa-edit-core/button/add-classes-icon', addClassesIcon );