import { addFilter } from '@wordpress/hooks';
import { useEffect } from '@wordpress/element';
import { dispatch } from '@wordpress/data';

function setDefaultHeadingAlignment( settings, name ) {
	if ( name === 'core/heading' ) {
		return {
			...settings,
			attributes: {
				...settings.attributes,
				textAlign: {
					...settings.attributes?.textAlign,
					default: 'center',
				},
			},
		};
	}

	return settings;
}

addFilter(
	'blocks.registerBlockType',
	'wa-edit-core/set-default-heading-alignment',
	setDefaultHeadingAlignment
);

/*function forceCenterHeadingAlignment( block ) {
	if ( block.name === 'core/heading' && block.attributes?.textAlign !== 'center' ) {
		dispatch( 'core/block-editor' ).updateBlockAttributes( block.clientId, { textAlign: 'center' } );
	}
	return block;
}*/

addFilter(
	'blocks.getSaveContent.props',
	'wa-edit-core/force-center-heading-alignment',
	( props, block ) => {
		if ( block.name === 'core/heading' ) {
			return { ...props, style: { textAlign: 'center', ...props.style } };
		}
		return props;
	}
);

addFilter(
	'editor.BlockEdit',
	'wa-edit-core/force-center-heading-edit-alignment',
	( BlockEdit ) => {
		return ( props ) => {
			if ( props.name === 'core/heading' && props.attributes?.textAlign !== 'center' ) {
				useEffect( () => {
					//props.setAttributes( { textAlign: 'center' } );
				}, [ props.clientId ] );
			}
			return <BlockEdit { ...props } />;
		};
	}
);