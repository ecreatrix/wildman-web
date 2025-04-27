/**
 * WordPress dependencies
 */
/*import { InnerBlocks } from '@wordpress/block-editor';

import {
	createInterpolateElement,
	useEffect,
	useState,
} from '@wordpress/element';

import { useSelect, useDispatch } from '@wordpress/data';

import { store as coreStore, useEntityProp } from '@wordpress/core-data';

import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';

export default function save( { attributes } ) {
  	const { addEntities, editEntityRecord } = useDispatch(coreStore);

  	addEntities([
        {
            name: 'watheme',           // route name
            kind: 'wa/v1', // namespace
            baseURL: '/wa/v1/site', // API path without /wp-json
           	key: "wathemes" 
        }
    ])

	//console.log(attributes)
	useEffect( () => {
		let fetch = apiFetch( {
			path: addQueryArgs( '/wa/v1/site' ),
		    method: 'GET',
	        //headers: {
	        //    'Content-Type': 'application/json',
	        //},
			//path: addQueryArgs( '/wa/v1/site', {
			//	wathemes: postId,
			//} ),
		} ).then( ( res ) => {
			console.log(res)
		} );

		console.log(fetch)
	}, [ ] )

	const {
		canUserEdit,
		url,

		siteLogoIdTall,
		mediaItemDataTall,
		isRequestingMediaItemTall,

		siteLogoIdLong,
		mediaItemDataLong,
		isRequestingMediaItemLong,
	} = useSelect( ( select ) => {
		const { canUser, getEntityRecord, getEditedEntityRecord, getEntityRecords, getEntityConfig, getRawEntityRecord } = select( coreStore );

		console.log(getEntityRecords( 'wa/v1', 'site' ))
		console.log(getEntityRecord( 'wa/v1', 'site' ))

	//console.log( select( coreStore ))
		const _canUserEdit = canUser( 'update', {
			kind: 'root',
			name: 'site',
		} );

		const siteSettings = _canUserEdit
			? getEditedEntityRecord( 'root', 'site' )
			: undefined;

		const siteData = getEntityRecord( 'root', '__unstableBase' );

		const _siteLogoIdTall = _canUserEdit
			? siteSettings?.wa_site_logo_tall
			: siteData?.wa_site_logo_tall;

	//console.log(getEditedEntityRecord( 'root', 'site' ))
	//console.log( select( coreStore ).getAuthors())

		const mediaItemTall = _siteLogoIdTall &&
			select( coreStore ).getMedia( _siteLogoIdTall, {
				context: 'view',
			} );

		const _isRequestingMediaItemTall =
			!! _siteLogoIdTall &&
			! select( coreStore ).hasFinishedResolution( 'getMedia', [
				_siteLogoIdTall,
				{ context: 'view' },
			] );

		const _siteLogoIdLong = _canUserEdit
			? siteSettings?.wa_site_logo_long
			: siteData?.wa_site_logo_long;
			//console.log('tall: '+_siteLogoIdTall+' long: '+ _siteLogoIdLong)

		const mediaItemLong = _siteLogoIdLong &&
			select( coreStore ).getMedia( _siteLogoIdLong, {
				context: 'view',
			} );

		const _isRequestingMediaItemLong =
			!! _siteLogoIdLong &&
			! select( coreStore ).hasFinishedResolution( 'getMedia', [
				_siteLogoIdLong,
				{ context: 'view' },
			] );

		return {
			canUserEdit: _canUserEdit,
			url: siteData?.home,

			siteLogoIdTall: _siteLogoIdTall,
			mediaItemDataTall: mediaItemTall,
			isRequestingMediaItemTall: _isRequestingMediaItemTall,

			siteLogoIdLong: _siteLogoIdLong,
			mediaItemDataLong: mediaItemLong,
			isRequestingMediaItemLong: _isRequestingMediaItemLong
		};
	}, [] );

	//console.log(mediaItemDataTall)

	return <img url="test" />
}
*/