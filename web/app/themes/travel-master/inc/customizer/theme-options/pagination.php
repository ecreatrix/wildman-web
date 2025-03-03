<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'travel_master_pagination', array(
	'title'               => esc_html__('Pagination','travel-master'),
	'description'         => esc_html__( 'Pagination section options.', 'travel-master' ),
	'panel'               => 'travel_master_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[pagination_enable]', array(
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
	'default'             => $options['pagination_enable'],
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[pagination_enable]', array(
	'label'               => esc_html__( 'Pagination Enable', 'travel-master' ),
	'section'             => 'travel_master_pagination',
	'on_off_label' 		=> travel_master_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[pagination_type]', array(
	'sanitize_callback'   => 'travel_master_sanitize_select',
	'default'             => $options['pagination_type'],
) );

$wp_customize->add_control( 'travel_master_theme_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'travel-master' ),
	'section'             => 'travel_master_pagination',
	'type'                => 'select',
	'choices'			  => travel_master_pagination_options(),
	'active_callback'	  => 'travel_master_is_pagination_enable',
) );
