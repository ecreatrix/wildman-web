<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'travel_master_excerpt_section', array(
	'title'             => esc_html__( 'Excerpt','travel-master' ),
	'description'       => esc_html__( 'Excerpt section options.', 'travel-master' ),
	'panel'             => 'travel_master_theme_options_panel',
) );


// long Excerpt length setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[long_excerpt_length]', array(
	'sanitize_callback' => 'travel_master_sanitize_number_range',
	'validate_callback' => 'travel_master_validate_long_excerpt',
	'default'			=> $options['long_excerpt_length'],
) );

$wp_customize->add_control( 'travel_master_theme_options[long_excerpt_length]', array(
	'label'       		=> esc_html__( 'Blog Page Excerpt Length', 'travel-master' ),
	'description' 		=> esc_html__( 'Total words to be displayed in archive page/search page.', 'travel-master' ),
	'section'     		=> 'travel_master_excerpt_section',
	'type'        		=> 'number',
	'input_attrs' 		=> array(
		'style'       => 'width: 80px;',
		'max'         => 100,
		'min'         => 5,
	),
) );
