<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

$wp_customize->add_section( 'travel_master_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','travel-master' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'travel-master' ),
	'panel'             => 'travel_master_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'travel-master' ),
	'section'          	=> 'travel_master_breadcrumb',
	'on_off_label' 		=> travel_master_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'travel_master_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'travel-master' ),
	'active_callback' 	=> 'travel_master_is_breadcrumb_enable',
	'section'          	=> 'travel_master_breadcrumb',
) );
