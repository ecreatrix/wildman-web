<?php
// This file is generated. Do not modify it manually.
return array(
	'accordion-parent' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'wa/accordion-parent',
		'title' => 'Accordion',
		'category' => 'common',
		'attributes' => array(
			'anchor' => array(
				'type' => 'string'
			),
			'allowMultipleOpen' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => true,
			'color' => array(
				'text' => false,
				'background' => false
			)
		),
		'description' => 'Allow accordion style hiding of content.',
		'textdomain' => 'default',
		'keywords' => array(
			'wa'
		),
		'styles' => array(
			array(
				'name' => 'default',
				'label' => 'Default',
				'isDefault' => true
			),
			array(
				'name' => 'rounded',
				'label' => 'Rounded'
			)
		),
		'editorStyle' => 'wa-block-accordion-parent-editor',
		'style' => 'wa-block-accordion-parent'
	),
	'accordion-slide' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'wa/accordion-slide',
		'title' => 'Accordion Slide',
		'parent' => array(
			'wa/accordion-parent'
		),
		'category' => 'common',
		'attributes' => array(
			'anchor' => array(
				'type' => 'string',
				'default' => ''
			),
			'parentId' => array(
				'type' => 'string'
			),
			'startCollapsed' => array(
				'type' => 'boolean',
				'default' => true
			),
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'allowMultipleOpen' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'align' => true,
			'anchor' => true,
			'color' => array(
				'text' => false,
				'background' => false
			)
		),
		'description' => 'Individual slide with header that opens up content.',
		'textdomain' => 'default',
		'keywords' => array(
			'wa'
		),
		'styles' => array(
			array(
				'name' => 'default',
				'label' => 'Default',
				'isDefault' => true
			),
			array(
				'name' => 'rounded',
				'label' => 'Rounded'
			)
		),
		'editorStyle' => 'wa-block-accordion-slide-editor',
		'style' => 'wa-block-accordion-slide'
	),
	'carousel-parent' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'wa/carousel-parent',
		'title' => 'Carousel',
		'category' => 'common',
		'attributes' => array(
			'anchor' => array(
				'type' => 'string'
			),
			'allowMultipleOpen' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => true,
			'color' => array(
				'text' => false,
				'background' => false
			)
		),
		'description' => 'Allow carousel style hiding of content.',
		'textdomain' => 'default',
		'keywords' => array(
			'wa'
		),
		'styles' => array(
			array(
				'name' => 'default',
				'label' => 'Default',
				'isDefault' => true
			),
			array(
				'name' => 'rounded',
				'label' => 'Rounded'
			)
		),
		'editorStyle' => 'wa-block-carousel-parent-editor',
		'style' => 'wa-block-carousel-parent'
	),
	'carousel-slide' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'wa/carousel-slide',
		'title' => 'Carousel Slide',
		'parent' => array(
			'wa/carousel-parent'
		),
		'category' => 'common',
		'attributes' => array(
			'anchor' => array(
				'type' => 'string',
				'default' => ''
			),
			'parentId' => array(
				'type' => 'string'
			),
			'author' => array(
				'type' => 'string',
				'default' => ''
			),
			'group' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'align' => true,
			'anchor' => true,
			'color' => array(
				'text' => false,
				'background' => false
			)
		),
		'description' => 'Individual slide with header that opens up content.',
		'textdomain' => 'default',
		'keywords' => array(
			'wa'
		),
		'styles' => array(
			array(
				'name' => 'default',
				'label' => 'Default',
				'isDefault' => true
			),
			array(
				'name' => 'rounded',
				'label' => 'Rounded'
			)
		),
		'editorStyle' => 'wa-block-carousel-slide-editor',
		'style' => 'wa-block-carousel-slide'
	),
	'copyright-date-block' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'wa/copyright-date-block',
		'version' => '0.1.0',
		'title' => 'Copyright Date Block',
		'category' => 'widgets',
		'description' => 'Display your site\'s copyright date.',
		'example' => array(
			
		),
		'keywords' => array(
			'wa'
		),
		'allowedBlocks' => array(
			'core/paragraph',
			'core/heading',
			'core/form-input',
			'core/form-submit-button',
			'core/form-submission-notification',
			'core/group',
			'core/columns'
		),
		'attributes' => array(
			'placeholder' => array(
				'type' => 'string',
				'default' => 'All Rights Reserved'
			),
			'align' => array(
				'type' => 'string'
			),
			'content' => array(
				'type' => 'string',
				'role' => 'content'
			),
			'showIcon' => array(
				'type' => 'boolean',
				'default' => true
			),
			'fallbackCurrentYear' => array(
				'type' => 'string'
			),
			'showStartingYear' => array(
				'type' => 'boolean'
			),
			'startingYear' => array(
				'type' => 'string'
			)
		),
		'supports' => array(
			'color' => array(
				'background' => false,
				'text' => true
			),
			'html' => false,
			'typography' => array(
				'fontSize' => true
			)
		),
		'textdomain' => 'wa',
		'editorScript' => 'file:./index.jsx',
		'editorStyle' => 'file:./editor.css',
		'style' => 'file:./style.css'
	),
	'navigation-gt' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'wa/nav',
		'version' => '0.1.0',
		'title' => 'WA Navigation',
		'category' => 'theme',
		'description' => 'Navigation block',
		'example' => array(
			
		),
		'keywords' => array(
			'wa'
		),
		'allowedBlocks' => array(
			'core/navigation-link',
			'core/search',
			'core/social-links',
			'core/page-list',
			'core/spacer',
			'core/home-link',
			'core/site-title',
			'core/site-logo',
			'core/navigation-submenu',
			'core/loginout',
			'core/buttons'
		),
		'attributes' => array(
			'navItems' => array(
				'type' => 'array'
			),
			'ref' => array(
				'type' => 'number'
			),
			'textColor' => array(
				'type' => 'string'
			),
			'customTextColor' => array(
				'type' => 'string'
			),
			'rgbTextColor' => array(
				'type' => 'string'
			),
			'backgroundColor' => array(
				'type' => 'string'
			),
			'customBackgroundColor' => array(
				'type' => 'string'
			),
			'rgbBackgroundColor' => array(
				'type' => 'string'
			),
			'showSubmenuIcon' => array(
				'type' => 'boolean',
				'default' => true
			),
			'openSubmenusOnClick' => array(
				'type' => 'boolean',
				'default' => false
			),
			'overlayMenu' => array(
				'type' => 'string',
				'default' => 'mobile'
			),
			'icon' => array(
				'type' => 'string',
				'default' => 'handle'
			),
			'hasIcon' => array(
				'type' => 'boolean',
				'default' => true
			),
			'__unstableLocation' => array(
				'type' => 'string'
			),
			'overlayBackgroundColor' => array(
				'type' => 'string'
			),
			'customOverlayBackgroundColor' => array(
				'type' => 'string'
			),
			'overlayTextColor' => array(
				'type' => 'string'
			),
			'customOverlayTextColor' => array(
				'type' => 'string'
			),
			'maxNestingLevel' => array(
				'type' => 'number',
				'default' => 5
			),
			'templateLock' => array(
				'type' => array(
					'string',
					'boolean'
				),
				'enum' => array(
					'all',
					'insert',
					'contentOnly',
					false
				)
			)
		),
		'providesContext' => array(
			'textColor' => 'textColor',
			'customTextColor' => 'customTextColor',
			'backgroundColor' => 'backgroundColor',
			'customBackgroundColor' => 'customBackgroundColor',
			'overlayTextColor' => 'overlayTextColor',
			'customOverlayTextColor' => 'customOverlayTextColor',
			'overlayBackgroundColor' => 'overlayBackgroundColor',
			'customOverlayBackgroundColor' => 'customOverlayBackgroundColor',
			'fontSize' => 'fontSize',
			'customFontSize' => 'customFontSize',
			'showSubmenuIcon' => 'showSubmenuIcon',
			'openSubmenusOnClick' => 'openSubmenusOnClick',
			'style' => 'style',
			'maxNestingLevel' => 'maxNestingLevel'
		),
		'supports' => array(
			'align' => array(
				'wide',
				'full'
			),
			'ariaLabel' => true,
			'html' => false,
			'inserter' => true,
			'typography' => array(
				'fontSize' => true,
				'lineHeight' => true,
				'__experimentalFontStyle' => true,
				'__experimentalFontWeight' => true,
				'__experimentalTextTransform' => true,
				'__experimentalFontFamily' => true,
				'__experimentalLetterSpacing' => true,
				'__experimentalTextDecoration' => true,
				'__experimentalSkipSerialization' => array(
					'textDecoration'
				),
				'__experimentalDefaultControls' => array(
					'fontSize' => true
				)
			),
			'spacing' => array(
				'blockGap' => true,
				'units' => array(
					'px',
					'em',
					'rem',
					'vh',
					'vw'
				),
				'__experimentalDefaultControls' => array(
					'blockGap' => true
				)
			),
			'layout' => array(
				'allowSwitching' => false,
				'allowInheriting' => false,
				'allowVerticalAlignment' => false,
				'allowSizingOnChildren' => true,
				'default' => array(
					'type' => 'flex'
				)
			),
			'interactivity' => true,
			'renaming' => false
		),
		'editorStyle' => 'file:./editor.css',
		'style' => 'file:./style.css',
		'textdomain' => 'watheme',
		'editorScript' => 'file:./index.jsx',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./render.jsx'
	),
	'site-logo-multiple' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'wa/site-logo',
		'title' => 'Site Logo with seasons',
		'category' => 'theme',
		'description' => 'Display an image to represent this site. Update this block and the changes apply everywhere.',
		'textdomain' => 'default',
		'keywords' => array(
			'wa'
		),
		'attributes' => array(
			'width' => array(
				'type' => 'number'
			),
			'setWidth' => array(
				'type' => 'boolean',
				'default' => true
			),
			'isLink' => array(
				'type' => 'boolean',
				'default' => true,
				'role' => 'content'
			),
			'selectedVersion' => array(
				'type' => 'string',
				'default' => 'tall'
			),
			'selectedSeason' => array(
				'type' => 'string',
				'default' => 'automatic'
			),
			'linkTarget' => array(
				'type' => 'string',
				'default' => '_self',
				'role' => 'content'
			),
			'shouldSyncIcon' => array(
				'type' => 'boolean'
			)
		),
		'example' => array(
			'viewportWidth' => 500,
			'attributes' => array(
				'width' => 350,
				'className' => 'block-editor-block-types-list__site-logo-example'
			)
		),
		'supports' => array(
			'html' => false,
			'align' => true,
			'alignWide' => false,
			'color' => array(
				'text' => false,
				'background' => false
			),
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'__experimentalDefaultControls' => array(
					'margin' => false,
					'padding' => false
				)
			),
			'interactivity' => array(
				'clientNavigation' => true
			),
			'filter' => array(
				'duotone' => true
			)
		),
		'styles' => array(
			array(
				'name' => 'default',
				'label' => 'Default',
				'isDefault' => true
			),
			array(
				'name' => 'rounded',
				'label' => 'Rounded'
			)
		),
		'selectors' => array(
			'filter' => array(
				'duotone' => '.wa-block-site-logo-seasons img, .wa-block-site-logo-seasons .components-placeholder__illustration, .wa-block-site-logo-seasons .components-placeholder::before'
			)
		),
		'editorStyle' => 'wa-block-site-logo-seasons-editor',
		'style' => 'wa-block-site-logo-seasons',
		'render' => 'file:./render.php'
	)
);
