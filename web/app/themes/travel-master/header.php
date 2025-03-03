<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Travel Master
	 * @since Travel Master 1.0.0
	 */

	/**
	 * travel_master_doctype hook
	 *
	 * @hooked travel_master_doctype -  10
	 *
	 */
	do_action( 'travel_master_doctype' );

?>
<head>
<?php
	/**
	 * travel_master_before_wp_head hook
	 *
	 * @hooked travel_master_head -  10
	 *
	 */
	do_action( 'travel_master_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' ); ?>

<?php
	/**
	 * travel_master_page_start_action hook
	 *
	 * @hooked travel_master_page_start -  10
	 *
	 */
	do_action( 'travel_master_page_start_action' ); 

	/**
	 * travel_master_header_action hook
	 *
	 * @hooked travel_master_header_start -  10
	 * @hooked travel_master_site_branding -  20
	 * @hooked travel_master_site_navigation -  30
	 * @hooked travel_master_header_end -  50
	 *
	 */
	do_action( 'travel_master_header_action' );

	/**
	 * travel_master_content_start_action hook
	 *
	 * @hooked travel_master_content_start -  10
	 *
	 */
	do_action( 'travel_master_content_start_action' );

	/**
	 * travel_master_header_image_action hook
	 *
	 * @hooked travel_master_header_image -  10
	 *
	 */
	do_action( 'travel_master_header_image_action' );

    if ( travel_master_is_frontpage() ) {
    	$options = travel_master_get_theme_options();
    	$sorted = array();
    	if ( ! empty( $options['sortable'] ) ) {
			$sorted = explode( ',' , $options['sortable'] );
		}

		foreach ( $sorted as $section ) {
			add_action( 'travel_master_primary_content', 'travel_master_add_'. $section .'_section' );
		}
		do_action( 'travel_master_primary_content' );
	}