/**
 * WordPress dependencies
 */
import { VisuallyHidden } from '@wordpress/components';

export default function AccessibleDescription( { id, children } ) {
	return (
		<VisuallyHidden>
			<div id={ id } className="wa-block-navigation__description">
				{ children }
			</div>
		</VisuallyHidden>
	);
}
