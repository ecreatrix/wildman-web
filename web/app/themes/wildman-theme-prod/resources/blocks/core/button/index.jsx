import domReady from '@wordpress/dom-ready';
import { unregisterBlockType, registerBlockStyle, unregisterBlockStyle, getBlockTypes, getBlockStyle, getBlockVariations } from '@wordpress/blocks';

//import './icons';
import './bookings';

domReady(() => {	
	unregisterBlockStyle( 'core/button', 'fill');
	unregisterBlockStyle( 'core/button', 'outline' );
})