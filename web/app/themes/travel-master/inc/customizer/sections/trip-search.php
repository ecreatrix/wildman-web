<?php
/**
 * Trip Search Section options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add Trip Search section
$wp_customize->add_section( 'travel_master_trip_search_section', array(
	'title'             => esc_html__( 'Trip Search','travel-master' ),
	'description'       => sprintf( '%1$s <a href="' . esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=install' ) ) . '" target="_blank"> %2$s </a> %3$s', esc_html__( 'To enable Trip Search. Download and Activate WP Travel plugin. ', 'travel-master' ), esc_html__( 'Click Here', 'travel-master' ), esc_html__( 'to download.', 'travel-master' ) ),
	'panel'             => 'travel_master_front_page_panel',
) );

// Trip Search content enable control and setting
$wp_customize->add_setting( 'travel_master_theme_options[trip_search_section_enable]', array(
	'default'			=> 	$options['trip_search_section_enable'],
	'sanitize_callback' => 'travel_master_sanitize_switch_control',
) );

$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[trip_search_section_enable]', array(
	'label'             => esc_html__( 'Trip Search Section Enable', 'travel-master' ),
	'section'           => 'travel_master_trip_search_section',
	'on_off_label' 		=> travel_master_switch_options(),
) ) );
