<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */
function travel_master_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'travel-master' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}

/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function travel_master_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'travel-master' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    wp_reset_postdata();
    return  $choices;
}

/**
 * List of trips for post choices.
 * @return Array Array of post ids and name.
 */
function travel_master_trip_choices() {
    $posts = get_posts( array( 'post_type' => 'itineraries', 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'travel-master' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    wp_reset_postdata();
    return  $choices;
}

if ( ! function_exists( 'travel_master_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function travel_master_selected_sidebar() {
        $travel_master_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'travel-master' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar 1', 'travel-master' ),
        );

        $output = apply_filters( 'travel_master_selected_sidebar', $travel_master_selected_sidebar );

        return $output;
    }
endif;

if ( ! function_exists( 'travel_master_site_layout' ) ) :
    /**
     * Site Layout
     * @return array site layout options
     */
    function travel_master_site_layout() {
        $travel_master_site_layout = array(
            'wide-layout'  => get_template_directory_uri() . '/assets/images/full.png',
            'boxed-layout' => get_template_directory_uri() . '/assets/images/boxed.png',
        );

        $output = apply_filters( 'travel_master_site_layout', $travel_master_site_layout );
        return $output;
    }
endif;


if ( ! function_exists( 'travel_master_global_sidebar_position' ) ) :
    /**
     * Global Sidebar position
     * @return array Global Sidebar positions
     */
    function travel_master_global_sidebar_position() {
        $travel_master_global_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'travel_master_global_sidebar_position', $travel_master_global_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'travel_master_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function travel_master_sidebar_position() {
        $travel_master_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'travel_master_sidebar_position', $travel_master_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'travel_master_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function travel_master_pagination_options() {
        $travel_master_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'travel-master' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'travel-master' ),
        );

        $output = apply_filters( 'travel_master_pagination_options', $travel_master_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'travel_master_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function travel_master_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'travel-master' ),
            'off'       => esc_html__( 'Disable', 'travel-master' )
        );
        return apply_filters( 'travel_master_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'travel_master_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function travel_master_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'travel-master' ),
            'off'       => esc_html__( 'No', 'travel-master' )
        );
        return apply_filters( 'travel_master_hide_options', $arr );
    }
endif;

if ( ! function_exists( 'travel_master_sortable_sections' ) ) :
    /**
     * List of sections Control options
     * @return array List of Sections control options.
     */
    function travel_master_sortable_sections() {
        $sections = array(
            'slider'                => esc_html__( 'Main Slider', 'travel-master' ),
            'trip_search'           => esc_html__( 'Trip Search', 'travel-master' ),
            'featured'              => esc_html__( 'Featured', 'travel-master' ),
            'popular_destination'   => esc_html__( 'Popular Destination', 'travel-master' ),
            'about'                 => esc_html__( 'About Us', 'travel-master' ),
            'service'               => esc_html__( 'Services', 'travel-master' ),
            'blog'                  => esc_html__( 'Blog', 'travel-master' ),
            'discover_places'       => esc_html__( 'Discover Places', 'travel-master' ),
        );
        return apply_filters( 'travel_master_sortable_sections', $sections );
    }
endif;

if ( ! function_exists( 'travel_master_featured_content_type' ) ) :
    /**
     * featured Options
     * @return array site featured options
     */
    function travel_master_featured_content_type() {
        $travel_master_featured_content_type = array(
            'page'      => esc_html__( 'Page', 'travel-master' ),
        );

        if ( class_exists( 'WP_Travel' ) ) {
            $travel_master_featured_content_type = array_merge( $travel_master_featured_content_type, array(
                'trip'          => esc_html__( 'Trip', 'travel-master' ),
                ) );
        }

        $output = apply_filters( 'travel_master_featured_content_type', $travel_master_featured_content_type );


        return $output;
    }
endif;

if ( ! function_exists( 'travel_master_popular_destination_content_type' ) ) :
    /**
     * Destination Options
     * @return array site gallery options
     */
    function travel_master_popular_destination_content_type() {
        $travel_master_popular_destination_content_type = array(
            'page'      => esc_html__( 'Page', 'travel-master' ),
        );

        if ( class_exists( 'WP_Travel' ) ) {
            $travel_master_popular_destination_content_type = array_merge( $travel_master_popular_destination_content_type, array(
                'trip'          => esc_html__( 'Trip', 'travel-master' ),
                ) );
        }

        $output = apply_filters( 'travel_master_popular_destination_content_type', $travel_master_popular_destination_content_type );


        return $output;
    }
endif;

if ( ! function_exists( 'travel_master_discover_places_content_type' ) ) :
    /**
     * Destination Options
     * @return array site gallery options
     */
    function travel_master_discover_places_content_type() {
        $travel_master_discover_places_content_type = array(
            'page'      => esc_html__( 'Page', 'travel-master' ),
        );

        if ( class_exists( 'WP_Travel' ) ) {
            $travel_master_discover_places_content_type = array_merge( $travel_master_discover_places_content_type, array(
                'trip'          => esc_html__( 'Trip', 'travel-master' ),
                ) );
        }

        $output = apply_filters( 'travel_master_discover_places_content_type', $travel_master_discover_places_content_type );


        return $output;
    }
endif;
