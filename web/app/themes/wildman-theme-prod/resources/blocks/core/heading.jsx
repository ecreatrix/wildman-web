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
					default: 'left',
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

addFilter(
	'blocks.getSaveContent.props',
	'wa-edit-core/force-center-heading-alignment',
	( props, block ) => {
		if ( block.name === 'core/heading' ) {
			return { ...props, style: { textAlign: 'left', ...props.style } };
		}
		return props;
	}
);

addFilter(
	'editor.BlockEdit',
	'wa-edit-core/force-center-heading-edit-alignment',
	( BlockEdit ) => {
		return ( props ) => {
			if ( props.name === 'core/heading' && props.attributes?.textAlign !== 'left' ) {
				useEffect( () => {
				}, [ props.clientId ] );
			}
			return <BlockEdit { ...props } />;
		};
	}
);