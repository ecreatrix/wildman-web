<?php
/**
 * Discover Places Section options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add Discover Places section
$wp_customize->add_section( 'travel_master_discover_places_section', array(
	'title'             => esc_html__( 'Discover Places','travel-master' ),
	'description'       => esc_html__( 'Discover Places Section options.', 'travel-master' ),
	'panel'             => 'travel_master_front_page_panel',
) );

// Discover Places content enable control and setting
$wp_customize->add_setting( 'travel_master_theme_options[discover_places_section_enable]', array(
	'default'			=> 	$options['discover_places_section_enable'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[discover_places_section_enable]', array(
	'label'             => esc_html__( 'Discover Places Section Enable', 'travel-master' ),
	'section'           => 'travel_master_discover_places_section',
	'on_off_label' 		=> travel_master_switch_options(),
) ) );

// Discover Places auto play enable control and setting
$wp_customize->add_setting( 'travel_master_theme_options[discover_places_auto_play]', array(
	'default'			=> 	$options['discover_places_auto_play'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[discover_places_auto_play]', array(
	'label'             => esc_html__( 'Auto Play Enable', 'travel-master' ),
	'section'           => 'travel_master_discover_places_section',
	'on_off_label' 		=> travel_master_switch_options(),
	'active_callback' 	=> 'travel_master_is_discover_places_section_enable',
) ) );

// Discover Places title setting and control
$wp_customize->add_setting( 'travel_master_theme_options[discover_places_sub_title]', array(
	'default'			=> $options['discover_places_sub_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'travel_master_theme_options[discover_places_sub_title]', array(
	'label'           	=> esc_html__( 'Title', 'travel-master' ),
	'section'        	=> 'travel_master_discover_places_section',
	'active_callback' 	=> 'travel_master_is_discover_places_section_enable',
	'type'				=> 'text',
) );

// Discover Places title setting and control
$wp_customize->add_setting( 'travel_master_theme_options[discover_places_read_more]', array(
	'default'			=> $options['discover_places_read_more'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'travel_master_theme_options[discover_places_read_more]', array(
	'label'           	=> esc_html__( 'Read More Text', 'travel-master' ),
	'section'        	=> 'travel_master_discover_places_section',
	'active_callback' 	=> 'travel_master_is_discover_places_section_enable',
	'type'				=> 'text',
) );

// Discover Places content type control and setting
$wp_customize->add_setting( 'travel_master_theme_options[discover_places_content_type]', array(
	'default'          	=> $options['discover_places_content_type'],
	'sanitize_callback' => 'travel_master_sanitize_select',
) );

$wp_customize->add_control( 'travel_master_theme_options[discover_places_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'travel-master' ),
	'section'           => 'travel_master_discover_places_section',
	'type'				=> 'select',
	'active_callback' 	=> 'travel_master_is_discover_places_section_enable',
	'choices'			=> travel_master_discover_places_content_type(),
) );

for ( $i=1; $i <= 3; $i++ ) { 
	// discover_places pages drop down chooser control and setting
	$wp_customize->add_setting( 'travel_master_theme_options[discover_places_content_page_' . $i . ']', array(
		'sanitize_callback' => 'travel_master_sanitize_page',
	) );

	$wp_customize->add_control( new Travel_Master_Dropdown_Chooser( $wp_customize, 'travel_master_theme_options[discover_places_content_page_' . $i . ']', array(
		'label'             => sprintf ( esc_html__( 'Select Page %d', 'travel-master' ), $i ),
		'section'           => 'travel_master_discover_places_section',
		'choices'			=> travel_master_page_choices(),
		'active_callback'	=> 'travel_master_is_discover_places_section_content_page_enable',
	) ) );

	// discover_places trips drop down chooser control and setting
	$wp_customize->add_setting( 'travel_master_theme_options[discover_places_content_trip_' . $i . ']', array(
		'sanitize_callback' => 'travel_master_sanitize_page',
	) );

	$wp_customize->add_control( new Travel_Master_Dropdown_Chooser( $wp_customize, 'travel_master_theme_options[discover_places_content_trip_' . $i . ']', array(
		'label'             => sprintf ( esc_html__( 'Select Trip %d', 'travel-master' ), $i ),
		'section'           => 'travel_master_discover_places_section',
		'choices'			=> travel_master_trip_choices(),
		'active_callback'	=> 'travel_master_is_discover_places_section_content_trip_enable',
	) ) );
}
