<?php
/**
 * Featured Section options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add Featured section
$wp_customize->add_section( 'travel_master_featured_section', array(
	'title'             => esc_html__( 'Featured','travel-master' ),
	'description'       => esc_html__( 'Featured Section options.', 'travel-master' ),
	'panel'             => 'travel_master_front_page_panel',
) );

// Featured content enable control and setting
$wp_customize->add_setting( 'travel_master_theme_options[featured_section_enable]', array(
	'default'			=> 	$options['featured_section_enable'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[featured_section_enable]', array(
	'label'             => esc_html__( 'Featured Section Enable', 'travel-master' ),
	'section'           => 'travel_master_featured_section',
	'on_off_label' 		=> travel_master_switch_options(),
) ) );

// popular destination read more setting and control
$wp_customize->add_setting( 'travel_master_theme_options[featured_read_more]', array(
	'default'			=> $options['featured_read_more'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'travel_master_theme_options[featured_read_more]', array(
	'label'           	=> esc_html__( 'Read More Text', 'travel-master' ),
	'section'        	=> 'travel_master_featured_section',
	'active_callback' 	=> 'travel_master_is_featured_section_enable',
	'type'				=> 'text',
) );

// Featured content type control and setting
$wp_customize->add_setting( 'travel_master_theme_options[featured_content_type]', array(
	'default'          	=> $options['featured_content_type'],
	'sanitize_callback' => 'travel_master_sanitize_select',
) );

$wp_customize->add_control( 'travel_master_theme_options[featured_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'travel-master' ),
	'section'           => 'travel_master_featured_section',
	'type'				=> 'select',
	'active_callback' 	=> 'travel_master_is_featured_section_enable',
	'choices'			=> travel_master_featured_content_type(),
) );

for ( $i=1; $i <= 4; $i++ ) { 
	// featured pages drop down chooser control and setting
	$wp_customize->add_setting( 'travel_master_theme_options[featured_content_page_' . $i . ']', array(
		'sanitize_callback' => 'travel_master_sanitize_page',
	) );

	$wp_customize->add_control( new Travel_Master_Dropdown_Chooser( $wp_customize, 'travel_master_theme_options[featured_content_page_' . $i . ']', array(
		'label'             => sprintf ( esc_html__( 'Select Page %d', 'travel-master' ), $i ),
		'section'           => 'travel_master_featured_section',
		'choices'			=> travel_master_page_choices(),
		'active_callback'	=> 'travel_master_is_featured_section_content_page_enable',
	) ) );

	// featured trips drop down chooser control and setting
	$wp_customize->add_setting( 'travel_master_theme_options[featured_content_trip_' . $i . ']', array(
		'sanitize_callback' => 'travel_master_sanitize_page',
	) );

	$wp_customize->add_control( new Travel_Master_Dropdown_Chooser( $wp_customize, 'travel_master_theme_options[featured_content_trip_' . $i . ']', array(
		'label'             => sprintf ( esc_html__( 'Select Trip %d', 'travel-master' ), $i ),
		'section'           => 'travel_master_featured_section',
		'choices'			=> travel_master_trip_choices(),
		'active_callback'	=> 'travel_master_is_featured_section_content_trip_enable',
	) ) );
}
