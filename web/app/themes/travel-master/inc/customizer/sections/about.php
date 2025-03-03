<?php
/**
 * About Section options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add About section
$wp_customize->add_section( 'travel_master_about_section', array(
	'title'             => esc_html__( 'About Us','travel-master' ),
	'description'       => esc_html__( 'About Us Section options.', 'travel-master' ),
	'panel'             => 'travel_master_front_page_panel',
) );

// About content enable control and setting
$wp_customize->add_setting( 'travel_master_theme_options[about_section_enable]', array(
	'default'			=> 	$options['about_section_enable'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[about_section_enable]', array(
	'label'             => esc_html__( 'About Section Enable', 'travel-master' ),
	'section'           => 'travel_master_about_section',
	'on_off_label' 		=> travel_master_switch_options(),
) ) );

// about pages drop down chooser control and setting
$wp_customize->add_setting( 'travel_master_theme_options[about_content_page]', array(
	'sanitize_callback' => 'travel_master_sanitize_page',
) );

$wp_customize->add_control( new Travel_Master_Dropdown_Chooser( $wp_customize, 'travel_master_theme_options[about_content_page]', array(
	'label'             => esc_html__( 'Select Page', 'travel-master' ),
	'section'           => 'travel_master_about_section',
	'choices'			=> travel_master_page_choices(),
	'active_callback'	=> 'travel_master_is_about_section_enable',
) ) );

// about btn title setting and control
$wp_customize->add_setting( 'travel_master_theme_options[about_btn_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['about_btn_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'travel_master_theme_options[about_btn_title]', array(
	'label'           	=> esc_html__( 'Button Label', 'travel-master' ),
	'section'        	=> 'travel_master_about_section',
	'active_callback' 	=> 'travel_master_is_about_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'travel_master_theme_options[about_btn_title]', array(
		'selector'            => '#about-us .wrapper .read-more a',
		'settings'            => 'travel_master_theme_options[about_btn_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'travel_master_about_btn_title_partial',
    ) );
}
