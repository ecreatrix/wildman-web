/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { siteLogo as icon } from '../../../icons/build-module';

/**
 * Internal dependencies
 */
import edit from './edit';
//import save from './save';
import metadata from './block.json';

const { name } = metadata;
export { metadata, name };

export const settings = {
    icon,
    edit,
    //save,
};

//console.log({ name, ...metadata }, settings)

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
registerBlockType( { name, ...metadata }, settings );