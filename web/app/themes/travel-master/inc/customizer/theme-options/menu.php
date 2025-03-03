<?php
/**
 * Menu options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'travel_master_menu', array(
	'title'             => esc_html__('Header Menu','travel-master'),
	'description'       => esc_html__( 'Header Menu options.', 'travel-master' ),
	'panel'             => 'nav_menus',
) );

// search enable setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[social_nav_enable]', array(
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
	'default'           => $options['social_nav_enable'],
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[social_nav_enable]', array(
	'label'             => esc_html__( 'Enable Social Links', 'travel-master' ),
	'description'       => sprintf( '%1$s <a class="topbar-menu-trigger" href="#"> %2$s </a> %3$s', esc_html__( 'Note: To show social menu.', 'travel-master' ), esc_html__( 'Click Here', 'travel-master' ), esc_html__( 'to create menu', 'travel-master' ) ),
	'section'           => 'travel_master_menu',
	'on_off_label' 		=> travel_master_switch_options(),
) ) );
