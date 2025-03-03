<?php
/**
 * Reset options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

/**
* Reset section
*/
// Add reset enable section
$wp_customize->add_section( 'travel_master_reset_section', array(
	'title'             => esc_html__('Reset all settings','travel-master'),
	'description'       => esc_html__( 'Caution: All settings will be reset to default. Refresh the page after clicking Save & Publish.', 'travel-master' ),
) );

// Add reset enable setting and control.
$wp_customize->add_setting( 'travel_master_theme_options[reset_options]', array(
	'default'           => $options['reset_options'],
	'sanitize_callback' => 'travel_master_sanitize_checkbox',
	'transport'			  => 'postMessage',
) );

$wp_customize->add_control( 'travel_master_theme_options[reset_options]', array(
	'label'             => esc_html__( 'Check to reset all settings', 'travel-master' ),
	'section'           => 'travel_master_reset_section',
	'type'              => 'checkbox',
) );
