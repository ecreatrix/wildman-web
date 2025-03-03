<?php
/**
 * Popular Destination Section options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add Popular Destination section
$wp_customize->add_section( 'travel_master_popular_destination_section', array(
	'title'             => esc_html__( 'Popular Destination','travel-master' ),
	'description'       => esc_html__( 'Popular Destination Section options.', 'travel-master' ),
	'panel'             => 'travel_master_front_page_panel',
) );

// Popular Destination content enable control and setting
$wp_customize->add_setting( 'travel_master_theme_options[popular_destination_section_enable]', array(
	'default'			=> 	$options['popular_destination_section_enable'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[popular_destination_section_enable]', array(
	'label'             => esc_html__( 'Popular Destination Section Enable', 'travel-master' ),
	'section'           => 'travel_master_popular_destination_section',
	'on_off_label' 		=> travel_master_switch_options(),
) ) );

// popular destination title setting and control
$wp_customize->add_setting( 'travel_master_theme_options[popular_destination_title]', array(
	'default'			=> $options['popular_destination_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'travel_master_theme_options[popular_destination_title]', array(
	'label'           	=> esc_html__( 'Title', 'travel-master' ),
	'section'        	=> 'travel_master_popular_destination_section',
	'active_callback' 	=> 'travel_master_is_popular_destination_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'travel_master_theme_options[popular_destination_title]', array(
		'selector'            => '#top-destinations .section-header h2.section-title',
		'settings'            => 'travel_master_theme_options[popular_destination_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'travel_master_popular_destination_title_partial',
    ) );
}

// popular destination title setting and control
$wp_customize->add_setting( 'travel_master_theme_options[popular_destination_read_more]', array(
	'default'			=> $options['popular_destination_read_more'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'travel_master_theme_options[popular_destination_read_more]', array(
	'label'           	=> esc_html__( 'Read More Text', 'travel-master' ),
	'section'        	=> 'travel_master_popular_destination_section',
	'active_callback' 	=> 'travel_master_is_popular_destination_section_enable',
	'type'				=> 'text',
) );

// Popular Destination content type control and setting
$wp_customize->add_setting( 'travel_master_theme_options[popular_destination_content_type]', array(
	'default'          	=> $options['popular_destination_content_type'],
	'sanitize_callback' => 'travel_master_sanitize_select',
) );

$wp_customize->add_control( 'travel_master_theme_options[popular_destination_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'travel-master' ),
	'section'           => 'travel_master_popular_destination_section',
	'type'				=> 'select',
	'active_callback' 	=> 'travel_master_is_popular_destination_section_enable',
	'choices'			=> travel_master_popular_destination_content_type(),
) );

for ( $i=1; $i <= 4; $i++ ) { 
	// popular_destination pages drop down chooser control and setting
	$wp_customize->add_setting( 'travel_master_theme_options[popular_destination_content_page_' . $i . ']', array(
		'sanitize_callback' => 'travel_master_sanitize_page',
	) );

	$wp_customize->add_control( new Travel_Master_Dropdown_Chooser( $wp_customize, 'travel_master_theme_options[popular_destination_content_page_' . $i . ']', array(
		'label'             => sprintf ( esc_html__( 'Select Page %d', 'travel-master' ), $i ),
		'section'           => 'travel_master_popular_destination_section',
		'choices'			=> travel_master_page_choices(),
		'active_callback'	=> 'travel_master_is_popular_destination_section_content_page_enable',
	) ) );

	// popular_destination trips drop down chooser control and setting
	$wp_customize->add_setting( 'travel_master_theme_options[popular_destination_content_trip_' . $i . ']', array(
		'sanitize_callback' => 'travel_master_sanitize_page',
	) );

	$wp_customize->add_control( new Travel_Master_Dropdown_Chooser( $wp_customize, 'travel_master_theme_options[popular_destination_content_trip_' . $i . ']', array(
		'label'             => sprintf ( esc_html__( 'Select Trip %d', 'travel-master' ), $i ),
		'section'           => 'travel_master_popular_destination_section',
		'choices'			=> travel_master_trip_choices(),
		'active_callback'	=> 'travel_master_is_popular_destination_section_content_trip_enable',
	) ) );
}

