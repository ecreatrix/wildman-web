<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'travel_master_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'travel-master' ),
		'priority'   			=> 900,
		'panel'      			=> 'travel_master_theme_options_panel',
	)
);

// footer text
$wp_customize->add_setting( 'travel_master_theme_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'sanitize_callback'		=> 'travel_master_santize_allow_tag',
		'transport'				=> 'postMessage',
	)
);
$wp_customize->add_control( 'travel_master_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'travel-master' ),
		'section'    			=> 'travel_master_section_footer',
		'type'		 			=> 'textarea',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'travel_master_theme_options[copyright_text]', array(
		'selector'            => '.site-info .copyright p',
		'settings'            => 'travel_master_theme_options[copyright_text]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'travel_master_copyright_text_partial',
    ) );
}

// scroll top visible
$wp_customize->add_setting( 'travel_master_theme_options[scroll_top_visible]',
	array(
		'default'       		=> $options['scroll_top_visible'],
		'sanitize_callback' => 'travel_master_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Travel_Master_Switch_Control( $wp_customize, 'travel_master_theme_options[scroll_top_visible]',
    array(
		'label'      			=> esc_html__( 'Display Scroll Top Button', 'travel-master' ),
		'section'    			=> 'travel_master_section_footer',
		'on_off_label' 		=> travel_master_switch_options(),
    )
) );