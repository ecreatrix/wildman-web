import domReady from '@wordpress/dom-ready';
import { __ } from '@wordpress/i18n';
import { select } from '@wordpress/data';
import { addFilter } from '@wordpress/hooks';
//import '@wordpress/edit-post';
//import '@wordpress/edit-site';
import { unregisterBlockType, registerBlockStyle, unregisterBlockStyle, getBlockTypes, getBlockStyle, getBlockVariations } from '@wordpress/blocks';

import '@wordpress/editor'; // to access all blocks

domReady( () => {
	const allBlockTypes = getBlockTypes();
	//console.log( 'All Registered Block Types:', allBlockTypes );

	// Now you can iterate through allBlockTypes and find core blocks
	allBlockTypes.forEach( ( blockType ) => {
		if ( blockType.name.startsWith( 'core/' ) ) {
			console.log( 'Core Block:', blockType.name );
		}
	} );
	allBlockTypes.forEach( ( blockType ) => {
		if ( blockType.name.startsWith( 'wa/' ) ) {
			//console.log( 'WA Block:', blockType.name );
		}
	} );
} );

var allowedBlocks = [
    //'core/paragraph',
    //'core/image',
    //'core/html',
    //'core/freeform',
    //'core/buttons',
    //'core/button',
    //'core/navigation',
];

//console.log(wp)
/**
 * Component to disable dimension settings based on block context.
 *
 * @param {Object} settings - The block settings object.
 * @param {string} settingsName - The name of the settings being modified.
 * @param {string} clientId - The block id.
 * @param {string} blockName - The block name.
 * @returns {Object} The updated block settings object.
 */
const disableDimensionSettings = (settings, settingsName, clientId, blockName) => {
	if(blockName !== 'core/navigation') {
	    return settings;
	}

    // Disable these block settings.
    const disabledBlockSettings = [
        'color.palette.custom',
        'color.palette.theme',
    ];

    if (
        disabledBlockSettings.includes( settingsName ) 
    ) {
    	//console.log(blockName)
    	//console.log(settingsName)
        return false;
    }

    return settings;
};

domReady(() => {
	unregisterBlockStyle( 'core/button', 'fill');
	unregisterBlockStyle( 'core/button', 'outline' );
	//unregisterBlockType( 'core/logo' );

	/*registerBlockStyle( 'core/button', [{
	    name: 'primary-button',
	    label: 'Primary',
	    isDefault: true,
	}, {
	    name: 'secondary-button',
	    label: 'Secondary',
	}, {
	    name: 'outline-button',
	    label: 'Outline',
	} ] );*/

	//console.log(getBlockTypes())
	//unregisterBlockStyle('core/button', 'outline');

	addFilter(
	    'blockEditor.useSetting.before',
	    'wa-edit-core/disable-dimension-settings',
	    disableDimensionSettings
	);

	getBlockTypes().forEach( function( blockType ) {
		//console.log(getBlockStyle( blockType.name ))
		if ( 'core/heading' == blockType.name ) {
			console.log(blockType)
		}

	    if ( allowedBlocks.indexOf( blockType.name ) === -1 ) {
	        //unregisterBlockType( blockType.name );
	    } else {
			//console.log(blockType)
		//console.log(getBlockStyles( blockType.name ))
			//console.log(blockType)
	    }
	} );
})