<?php
/**
 * Service Section options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add Service section
$wp_customize->add_section( 'travel_master_service_section', array(
	'title'             => esc_html__( 'Services','travel-master' ),
	'description'       => esc_html__( 'Services Section options.', 'travel-master' ),
	'panel'             => 'travel_master_front_page_panel',
) );

// Service content enable control and setting
$wp_customize->add_setting( 'travel_master_theme_options[service_section_enable]', array(
	'default'			=> 	$options['service_section_enable'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[service_section_enable]', array(
	'label'             => esc_html__( 'Service Section Enable', 'travel-master' ),
	'section'           => 'travel_master_service_section',
	'on_off_label' 		=> travel_master_switch_options(),
) ) );

for ( $i = 1; $i <= 3; $i++ ) :

	// service note control and setting
	$wp_customize->add_setting( 'travel_master_theme_options[service_content_icon_' . $i . ']', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new Travel_Master_Icon_Picker( $wp_customize, 'travel_master_theme_options[service_content_icon_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Icon %d', 'travel-master' ), $i ),
		'section'           => 'travel_master_service_section',
		'active_callback'	=> 'travel_master_is_service_section_enable',
	) ) );

	// service pages drop down chooser control and setting
	$wp_customize->add_setting( 'travel_master_theme_options[service_content_page_' . $i . ']', array(
		'sanitize_callback' => 'travel_master_sanitize_page',
	) );

	$wp_customize->add_control( new Travel_Master_Dropdown_Chooser( $wp_customize, 'travel_master_theme_options[service_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'travel-master' ), $i ),
		'section'           => 'travel_master_service_section',
		'choices'			=> travel_master_page_choices(),
		'active_callback'	=> 'travel_master_is_service_section_enable',
	) ) );

	// service hr setting and control
	$wp_customize->add_setting( 'travel_master_theme_options[service_hr_'. $i .']', array(
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new Travel_Master_Customize_Horizontal_Line( $wp_customize, 'travel_master_theme_options[service_hr_'. $i .']',
		array(
			'section'         => 'travel_master_service_section',
			'active_callback' => 'travel_master_is_service_section_enable',
			'type'			  => 'hr'
	) ) );
endfor;
