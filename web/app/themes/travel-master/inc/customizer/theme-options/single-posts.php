<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'travel_master_single_post_section', array(
	'title'             => esc_html__( 'Single Post','travel-master' ),
	'description'       => esc_html__( 'Options to change the single posts globally.', 'travel-master' ),
	'panel'             => 'travel_master_theme_options_panel',
) );

// Tourableve date meta setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[single_post_hide_date]', array(
	'default'           => $options['single_post_hide_date'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[single_post_hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'travel-master' ),
	'section'           => 'travel_master_single_post_section',
	'on_off_label' 		=> travel_master_hide_options(),
) ) );

// Tourableve author meta setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[single_post_hide_author]', array(
	'default'           => $options['single_post_hide_author'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[single_post_hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'travel-master' ),
	'section'           => 'travel_master_single_post_section',
	'on_off_label' 		=> travel_master_hide_options(),
) ) );

// Tourableve author category setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[single_post_hide_category]', array(
	'default'           => $options['single_post_hide_category'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[single_post_hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'travel-master' ),
	'section'           => 'travel_master_single_post_section',
	'on_off_label' 		=> travel_master_hide_options(),
) ) );

// Tourableve tag category setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[single_post_hide_tags]', array(
	'default'           => $options['single_post_hide_tags'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[single_post_hide_tags]', array(
	'label'             => esc_html__( 'Hide Tag', 'travel-master' ),
	'section'           => 'travel_master_single_post_section',
	'on_off_label' 		=> travel_master_hide_options(),
) ) );
