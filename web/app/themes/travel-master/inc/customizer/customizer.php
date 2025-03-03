<?php
/**
 * Travel Master Customizer.
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

//load upgrade-to-pro section
require get_template_directory() . '/inc/customizer/upgrade-to-pro/class-customize.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function travel_master_customize_register( $wp_customize ) {
	$options = travel_master_get_theme_options();

	// Load custom control functions.
	require_once get_template_directory() . '/inc/customizer/custom-controls.php';

	// Load customize active callback functions.
	require get_template_directory() . '/inc/customizer/active-callback.php';

	// Load partial callback functions.
	require get_template_directory() . '/inc/customizer/partial.php';

	// Load validation callback functions.
	require get_template_directory() . '/inc/customizer/validation.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	// Remove the core header textcolor control, as it shares the main text color.
	$wp_customize->remove_control( 'header_textcolor' );

	// Header title color setting and control.
	$wp_customize->add_setting( 'travel_master_theme_options[header_title_color]', array(
		'default'           => $options['header_title_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'			=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'travel_master_theme_options[header_title_color]', array(
		'priority'			=> 5,
		'label'             => esc_html__( 'Header Title Color', 'travel-master' ),
		'section'           => 'colors',
	) ) );

	// Header tagline color setting and control.
	$wp_customize->add_setting( 'travel_master_theme_options[header_tagline_color]', array(
		'default'           => $options['header_tagline_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'			=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'travel_master_theme_options[header_tagline_color]', array(
		'priority'			=> 6,
		'label'             => esc_html__( 'Header Tagline Color', 'travel-master' ),
		'section'           => 'colors',
	) ) );

	// Site identity extra options.
	$wp_customize->add_setting( 'travel_master_theme_options[header_txt_logo_extra]', array(
		'default'           => $options['header_txt_logo_extra'],
		'sanitize_callback' => 'travel_master_sanitize_select',
		'transport'			=> 'refresh'
	) );

	$wp_customize->add_control( 'travel_master_theme_options[header_txt_logo_extra]', array(
		'priority'			=> 50,
		'type'				=> 'radio',
		'label'             => esc_html__( 'Site Identity Extra Options', 'travel-master' ),
		'section'           => 'title_tagline',
		'choices'				=> array( 
			'hide-all'     => esc_html__( 'Hide All', 'travel-master' ),
			'show-all'     => esc_html__( 'Show All', 'travel-master' ),
			'title-only'   => esc_html__( 'Title Only', 'travel-master' ),
			'tagline-only' => esc_html__( 'Tagline Only', 'travel-master' ),
			'logo-title'   => esc_html__( 'Logo + Title', 'travel-master' ),
			'logo-tagline' => esc_html__( 'Logo + Tagline', 'travel-master' ),
			)
	) );

	// Add panel for common theme options
	$wp_customize->add_panel( 'travel_master_theme_options_panel' , array(
	    'title'      => esc_html__( 'Theme Options','travel-master' ),
	    'description'=> esc_html__( 'Travel Master Theme Options.', 'travel-master' ),
	    'priority'   => 150,
	) );

	// breadcrumb
	require get_template_directory() . '/inc/customizer/theme-options/breadcrumb.php';

	// load layout
	require get_template_directory() . '/inc/customizer/theme-options/layout.php';

	// load menu
	require get_template_directory() . '/inc/customizer/theme-options/menu.php';

	// load static homepage option
	require get_template_directory() . '/inc/customizer/theme-options/homepage-static.php';

	// load archive option
	require get_template_directory() . '/inc/customizer/theme-options/excerpt.php';

	// load archive option
	require get_template_directory() . '/inc/customizer/theme-options/archive.php';
	
	// load single post option
	require get_template_directory() . '/inc/customizer/theme-options/single-posts.php';

	// load pagination option
	require get_template_directory() . '/inc/customizer/theme-options/pagination.php';

	// load footer option
	require get_template_directory() . '/inc/customizer/theme-options/footer.php';

	// load reset option
	require get_template_directory() . '/inc/customizer/theme-options/reset.php';

	// Add panel for front page theme options.
	$wp_customize->add_panel( 'travel_master_front_page_panel' , array(
	    'title'      => esc_html__( 'Front Page','travel-master' ),
	    'description'=> esc_html__( 'Front Page Theme Options.', 'travel-master' ),
	    'priority'   => 140,
	) );

	// load slider option
	require get_template_directory() . '/inc/customizer/sections/slider.php';

	// load trip search option
	require get_template_directory() . '/inc/customizer/sections/trip-search.php';

	// load featured option
	require get_template_directory() . '/inc/customizer/sections/featured.php';

	// load popular destination option
	require get_template_directory() . '/inc/customizer/sections/popular-destination.php';

	// load about option
	require get_template_directory() . '/inc/customizer/sections/about.php';

	// load service option
	require get_template_directory() . '/inc/customizer/sections/service.php';

	// load blog option
	require get_template_directory() . '/inc/customizer/sections/blog.php';

	// load discover places option
	require get_template_directory() . '/inc/customizer/sections/discover-places.php';

}
add_action( 'customize_register', 'travel_master_customize_register' );

/*
 * Load customizer sanitization functions.
 */
require get_template_directory() . '/inc/customizer/sanitize.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function travel_master_customize_preview_js() {
	wp_enqueue_script( 'travel-master-customizer', get_template_directory_uri() . '/assets/js/customizer' . travel_master_min() . '.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'travel_master_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function travel_master_customize_control_js() {
	// fontawesome
	wp_enqueue_style( 'font-awesome-css', get_template_directory_uri() . '/assets/css/font-awesome' . travel_master_min() . '.css' );
	
	// Choose from select jquery.
	wp_enqueue_style( 'chosen-css', get_template_directory_uri() . '/assets/css/chosen' . travel_master_min() . '.css' );
	wp_enqueue_script( 'jquery-chosen', get_template_directory_uri() . '/assets/js/chosen.jquery' . travel_master_min() . '.js', array( 'jquery' ), '1.4.2', true );

	// simple icon picker
	wp_enqueue_style( 'simple-iconpicker-css', get_template_directory_uri() . '/assets/css/simple-iconpicker' . travel_master_min() . '.css' );
	wp_enqueue_script( 'jquery-simple-iconpicker', get_template_directory_uri() . '/assets/js/simple-iconpicker' . travel_master_min() . '.js', array( 'jquery' ), '', true );

	wp_enqueue_style( 'travel-master-customize-controls-css', get_template_directory_uri() . '/assets/css/customize-controls' . travel_master_min() . '.css' );
	wp_enqueue_script( 'travel-master-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls' . travel_master_min() . '.js', array(), '1.0', true );
	$travel_master_reset_data = array(
		'reset_message' => esc_html__( 'Refresh the customizer page after saving to view reset effects', 'travel-master' )
	);
	// Send list of color variables as object to custom customizer js
	wp_localize_script( 'travel-master-customize-controls', 'travel_master_reset_data', $travel_master_reset_data );
}
add_action( 'customize_controls_enqueue_scripts', 'travel_master_customize_control_js' );

if ( !function_exists( 'travel_master_reset_options' ) ) :
	/**
	 * Reset all options
	 *
	 * @since Travel Master 1.0.0
	 *
	 * @param bool $checked Whether the reset is checked.
	 * @return bool Whether the reset is checked.
	 */
	function travel_master_reset_options() {
		$options = travel_master_get_theme_options();
		if ( true === $options['reset_options'] ) {
			// Reset custom theme options.
			set_theme_mod( 'travel_master_theme_options', array() );
			// Reset custom header and backgrounds.
			remove_theme_mod( 'header_image' );
			remove_theme_mod( 'header_image_data' );
			remove_theme_mod( 'background_image' );
			remove_theme_mod( 'background_color' );
			remove_theme_mod( 'header_textcolor' );
	    }
	  	else {
		    return false;
	  	}
	}
endif;
add_action( 'customize_save_after', 'travel_master_reset_options' );
