<?php
/**
* Homepage (Static ) options
*
* @package Theme Palace
* @subpackage Travel Master
* @since Travel Master 1.0.0
*/

// Homepage (Static ) setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[enable_frontpage_content]', array(
	'sanitize_callback'   => 'travel_master_sanitize_checkbox',
	'default'             => $options['enable_frontpage_content'],
) );

$wp_customize->add_control( 'travel_master_theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Content', 'travel-master' ),
	'description' 	=> esc_html__( 'Check to enable content on static front page only.', 'travel-master' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
	'active_callback' => 'travel_master_is_static_homepage_enable',
) );