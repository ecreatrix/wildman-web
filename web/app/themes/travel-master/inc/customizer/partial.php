<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage Travel Master
* @since Travel Master 1.0.0
*/

if ( ! function_exists( 'travel_master_popular_destination_title_partial' ) ) :
    // popular destination title
    function travel_master_popular_destination_title_partial() {
        $options = travel_master_get_theme_options();
        return esc_html( $options['popular_destination_title'] );
    }
endif;

if ( ! function_exists( 'travel_master_about_btn_title_partial' ) ) :
    // about btn title
    function travel_master_about_btn_title_partial() {
        $options = travel_master_get_theme_options();
        return esc_html( $options['about_btn_title'] );
    }
endif;

if ( ! function_exists( 'travel_master_blog_title_partial' ) ) :
    // blog title
    function travel_master_blog_title_partial() {
        $options = travel_master_get_theme_options();
        return esc_html( $options['blog_title'] );
    }
endif;

if ( ! function_exists( 'travel_master_copyright_text_partial' ) ) :
    // copyright text
    function travel_master_copyright_text_partial() {
        $options = travel_master_get_theme_options();
        return esc_html( $options['copyright_text'] );
    }
endif;
