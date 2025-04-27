/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
//import { details as icon } from '../../../icons/build-module';
import { Path, SVG } from '@wordpress/components';

/**
 * Internal dependencies
 */
import edit from './edit';
import save from './save';
import metadata from './block.json';

const { name } = metadata;
export { metadata, name };

const icon = <SVG xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><Path d="M0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128z"/></SVG>

export const settings = {
    icon,
    edit,
    save,
};

//console.log({ name, ...metadata }, settings)

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
registerBlockType( { name, ...metadata }, settings );