/**
 * WordPress dependencies
 */
import { Placeholder, Button, Spinner } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { navigation, Icon } from '../../../icons/build-module';
import { speak } from '@wordpress/a11y';
import { useEffect } from '@wordpress/element';

/**
 * Internal dependencies
 */
import useNavigationEntities from '../utils/use-navigation-entities';
import NavigationMenuSelector from '../utils/navigation-menu-selector';

export default function NavigationPlaceholder( {
	isSelected,
	currentMenuId,
	clientId,
	canUserCreateNavigationMenus = false,
	isResolvingCanUserCreateNavigationMenus,
	onSelectNavigationMenu,
	onSelectClassicMenu,
	onCreateEmpty,
} ) {
	const { isResolvingMenus, hasResolvedMenus } = useNavigationEntities();

	useEffect( () => {
		if ( ! isSelected ) {
			return;
		}

		if ( isResolvingMenus ) {
			speak( __( 'Loading navigation block setup options…' ) );
		}

		if ( hasResolvedMenus ) {
			speak( __( 'Navigation block setup options ready.' ) );
		}
	}, [ hasResolvedMenus, isResolvingMenus, isSelected ] );

	const isResolvingActions =
		isResolvingMenus && isResolvingCanUserCreateNavigationMenus;

	return (
		<>
			<Placeholder className="wp-block-wa-nav-placeholder">
				{
					// The <PlaceholderPreview> component is displayed conditionally via CSS depending on
					// whether the block is selected or not. This is achieved via CSS to avoid
					// component re-renders
				 }
				<div
					aria-hidden={ ! isSelected ? true : undefined }
					className="wp-block-wa-nav-placeholder__controls"
				>
					<div className="wp-block-wa-nav-placeholder__actions">
						<div className="wp-block-wa-nav-placeholder__actions__indicator">
							<Icon icon={ navigation } /> { __( 'Navigation' ) }
						</div>

						<hr />

						{ isResolvingActions && <Spinner /> }

						<NavigationMenuSelector
							currentMenuId={ currentMenuId }
							clientId={ clientId }
							onSelectNavigationMenu={ onSelectNavigationMenu }
							onSelectClassicMenu={ onSelectClassicMenu }
						/>

						<hr />

						{ canUserCreateNavigationMenus && (
							<Button
								__next40pxDefaultSize
								variant="tertiary"
								onClick={ onCreateEmpty }
							>
								{ __( 'Start empty' ) }
							</Button>
						) }
					</div>
				</div>
			</Placeholder>
		</>
	);
}
