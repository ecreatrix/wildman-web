<?php
/**
 * Slider Section options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add Slider section
$wp_customize->add_section( 'travel_master_slider_section', array(
	'title'             => esc_html__( 'Main Slider','travel-master' ),
	'description'       => esc_html__( 'Slider Section options.', 'travel-master' ),
	'panel'             => 'travel_master_front_page_panel',
) );

// Slider content enable control and setting
$wp_customize->add_setting( 'travel_master_theme_options[slider_section_enable]', array(
	'default'			=> 	$options['slider_section_enable'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[slider_section_enable]', array(
	'label'             => esc_html__( 'Slider Section Enable', 'travel-master' ),
	'section'           => 'travel_master_slider_section',
	'on_off_label' 		=> travel_master_switch_options(),
) ) );

// Slider content enable control and setting
$wp_customize->add_setting( 'travel_master_theme_options[slider_autoplay]', array(
	'default'			=> 	$options['slider_autoplay'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[slider_autoplay]', array(
	'label'             => esc_html__( 'Auto Play Enable', 'travel-master' ),
	'section'           => 'travel_master_slider_section',
	'on_off_label' 		=> travel_master_switch_options(),
	'active_callback' 	=> 'travel_master_is_slider_section_enable',
) ) );

// Slider btn label setting and control
$wp_customize->add_setting( 'travel_master_theme_options[slider_btn_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['slider_btn_label'],
) );

$wp_customize->add_control( 'travel_master_theme_options[slider_btn_label]', array(
	'label'           	=> esc_html__( 'Slider Button Label', 'travel-master' ),
	'section'        	=> 'travel_master_slider_section',
	'active_callback' 	=> 'travel_master_is_slider_section_enable',
	'type'				=> 'text',
) );

for ( $i = 1; $i <= 5; $i++ ) :
	// slider pages drop down chooser control and setting
	$wp_customize->add_setting( 'travel_master_theme_options[slider_content_page_' . $i . ']', array(
		'sanitize_callback' => 'travel_master_sanitize_page',
	) );

	$wp_customize->add_control( new Travel_Master_Dropdown_Chooser( $wp_customize, 'travel_master_theme_options[slider_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'travel-master' ), $i ),
		'section'           => 'travel_master_slider_section',
		'choices'			=> travel_master_page_choices(),
		'active_callback'	=> 'travel_master_is_slider_section_enable',
	) ) );

endfor;
