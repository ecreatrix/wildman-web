<?php
/**
 * Theme Palace basic theme structure hooks
 *
 * This file contains structural hooks.
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

$options = travel_master_get_theme_options();


if ( ! function_exists( 'travel_master_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since Travel Master 1.0.0
	 */
	function travel_master_doctype() {
	?>
		<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
	<?php
	}
endif;

add_action( 'travel_master_doctype', 'travel_master_doctype', 10 );


if ( ! function_exists( 'travel_master_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif;
	}
endif;
add_action( 'travel_master_before_wp_head', 'travel_master_head', 10 );

if ( ! function_exists( 'travel_master_page_start' ) ) :
	/**
	 * Page starts html codes
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_page_start() {
		?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'travel-master' ); ?></a>

		<?php
	}
endif;
add_action( 'travel_master_page_start_action', 'travel_master_page_start', 10 );

if ( ! function_exists( 'travel_master_header_start' ) ) :
	/**
	 * Header start html codes
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_header_start() {
		?>
		<div class="menu-overlay"></div>
		<header id="masthead" class="site-header" role="banner">
		<div class="wrapper main-menu">
		<?php
	}
endif;
add_action( 'travel_master_header_action', 'travel_master_header_start', 10 );

if ( ! function_exists( 'travel_master_page_end' ) ) :
	/**
	 * Page end html codes
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'travel_master_page_end_action', 'travel_master_page_end', 10 );

if ( ! function_exists( 'travel_master_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_site_branding() {
		$options  = travel_master_get_theme_options();
		$header_txt_logo_extra = $options['header_txt_logo_extra'];		
		?>
		<div class="site-branding">
			<?php if ( in_array( $header_txt_logo_extra, array( 'show-all', 'logo-title', 'logo-tagline' ) )  ) { ?>
				<div class="site-logo">
					<?php the_custom_logo(); ?>
				</div>
			<?php } 
			if ( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title', 'show-all', 'tagline-only', 'logo-tagline' ) ) ) : ?>
				<div id="site-identity">
					<?php
					if( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title' ) )  ) {
						if ( travel_master_is_latest_posts() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
						endif;
					} 
					if ( in_array( $header_txt_logo_extra, array( 'show-all', 'tagline-only', 'logo-tagline' ) ) ) {
						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
						<?php
						endif; 
					}?>
				</div>
			<?php endif; ?>
		</div><!-- .site-branding -->
		<?php
	}
endif;
add_action( 'travel_master_header_action', 'travel_master_site_branding', 20 );

if ( ! function_exists( 'travel_master_site_navigation' ) ) :
	/**
	 * Site navigation codes
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_site_navigation() {
		$options = travel_master_get_theme_options();
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="menu-label"><?php esc_html_e( 'Menu', 'travel-master' ); ?></span>
				<?php
				echo travel_master_get_svg( array( 'icon' => 'menu' ) );
				echo travel_master_get_svg( array( 'icon' => 'close' ) );
				?>					
			</button>

			<?php  
				$social = '';
				if ( $options['social_nav_enable'] ) :
            	
					$social .= '<li class="social-menu">';
					$social .= wp_nav_menu( array(
            			'theme_location' => 'social',
            			'container' => 'div',
            			'container_class' => 'social-icons',
            			'menu_class' => '',
            			'echo' => false,
            			'fallback_cb' => 'travel_master_menu_fallback_cb',
            			'depth' => 1,
            			'link_before' => '<span class="screen-reader-text">',
						'link_after' => '</span>',
            		) );
					$social .= '</li>';

                endif;

        		wp_nav_menu( array(
        			'theme_location' => 'primary',
        			'container' => 'div',
        			'menu_class' => 'menu nav-menu',
        			'menu_id' => 'primary-menu',
        			'echo' => true,
        			'fallback_cb' => 'travel_master_menu_fallback_cb',
        			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s' . $social . '</ul>',
        		) );
        	?>
		</nav><!-- #site-navigation -->
		</div><!-- .wrapper -->
		<?php
	}
endif;
add_action( 'travel_master_header_action', 'travel_master_site_navigation', 30 );


if ( ! function_exists( 'travel_master_header_end' ) ) :
	/**
	 * Header end html codes
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_header_end() {
		?>
		</header><!-- #masthead -->
		<?php
	}
endif;

add_action( 'travel_master_header_action', 'travel_master_header_end', 50 );

if ( ! function_exists( 'travel_master_content_start' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_content_start() {
		?>
		<div id="content" class="site-content">
		<?php
	}
endif;
add_action( 'travel_master_content_start_action', 'travel_master_content_start', 10 );

if ( ! function_exists( 'travel_master_header_image' ) ) :
	/**
	 * Header Image codes
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_header_image() {
		if ( travel_master_is_frontpage() )
			return;
		$header_image = get_header_image();
		$class = '';
		if ( is_singular() ) :
			$class = ( has_post_thumbnail() || ! empty( $header_image ) ) ? '' : 'header-media-disabled';
		else :
			$class = ! empty( $header_image ) ? '' : 'header-media-disabled';
		endif;
		
		if ( is_singular() && has_post_thumbnail() ) : 
			$header_image = get_the_post_thumbnail_url( get_the_id(), 'full' );
    	endif; ?>

    	<div id="page-site-header" class="relative <?php echo esc_attr( $class ); ?>" style="background-image: url('<?php echo esc_url( $header_image ); ?>');">
    		
            <div class="overlay"></div>
            <div class="header-wrapper">
	            <div class="wrapper">
	                <header class="page-header">
	                    <?php travel_master_custom_header_banner_title(); ?>
	                </header>

	                <?php travel_master_add_breadcrumb(); ?>
	            </div><!-- .wrapper -->
            </div><!-- .header-wrapper -->
        </div><!-- #page-site-header -->

	<?php
	}
endif;
add_action( 'travel_master_header_image_action', 'travel_master_header_image', 10 );

if ( ! function_exists( 'travel_master_add_breadcrumb' ) ) :
	/**
	 * Add breadcrumb.
	 *
	 * @since Travel Master 1.0.0
	 */
	function travel_master_add_breadcrumb() {
		$options = travel_master_get_theme_options();
		// Bail if Breadcrumb disabled.
		$breadcrumb = $options['breadcrumb_enable'];
		if ( false === $breadcrumb ) {
			return;
		}
		
		// Bail if Home Page.
		if ( travel_master_is_frontpage() ) {
			return;
		}

		echo '<div id="breadcrumb-list" >';
				/**
				 * travel_master_simple_breadcrumb hook
				 *
				 * @hooked travel_master_simple_breadcrumb -  10
				 *
				 */
				do_action( 'travel_master_simple_breadcrumb' );
		echo '</div><!-- #breadcrumb-list -->';
		return;
	}
endif;

if ( ! function_exists( 'travel_master_content_end' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_content_end() {
		?>
		</div><!-- #content -->
		<?php
	}
endif;
add_action( 'travel_master_content_end_action', 'travel_master_content_end', 10 );

if ( ! function_exists( 'travel_master_footer_start' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_footer_start() {
		?>
		<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
	}
endif;
add_action( 'travel_master_footer', 'travel_master_footer_start', 10 );

if ( ! function_exists( 'travel_master_footer_site_info' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_footer_site_info() {
		$theme_data = wp_get_theme();
		$options = travel_master_get_theme_options();
		$search = array( '[the-year]', '[site-link]' );

        $replace = array( date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_html( get_bloginfo( 'name', 'display' ) ) . '</a>' );

        $options['copyright_text'] = str_replace( $search, $replace, $options['copyright_text'] );

		$copyright_text = $options['copyright_text']; 
		?>
		<div class="site-info col-2">
                <div class="wrapper">
                    <span>
                    	<?php 
                    	echo travel_master_santize_allow_tag( $copyright_text ); 
                    	if ( function_exists( 'the_privacy_policy_link' ) ) {
							the_privacy_policy_link( ' | ' );
						}
                    	?>
                	</span>
                    <span><?php echo esc_html__( 'All Rights Reserved | ', 'travel-master' ) . esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'travel-master' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( ucwords( $theme_data->get( 'Author' ) ) ) .'</a>'; ?></span>
                </div><!-- .wrapper -->    
            </div><!-- .site-info -->

		<?php
	}
endif;
add_action( 'travel_master_footer', 'travel_master_footer_site_info', 40 );

if ( ! function_exists( 'travel_master_footer_scroll_to_top' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_footer_scroll_to_top() {
		$options  = travel_master_get_theme_options();
		if ( true === $options['scroll_top_visible'] ) : ?>
			<div class="backtotop"><?php echo travel_master_get_svg( array( 'icon' => 'up' ) ); ?></div>
		<?php endif;
	}
endif;
add_action( 'travel_master_footer', 'travel_master_footer_scroll_to_top', 40 );

if ( ! function_exists( 'travel_master_footer_end' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Travel Master 1.0.0
	 *
	 */
	function travel_master_footer_end() {
		?>
		</footer>
		<div class="popup-overlay"></div>
		<?php
	}
endif;
add_action( 'travel_master_footer', 'travel_master_footer_end', 100 );
