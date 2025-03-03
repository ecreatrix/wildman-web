<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 * @return array An array of default values
 */

function travel_master_get_default_theme_options() {
	$travel_master_default_options = array(
		// Color Options
		'header_title_color'			=> '#fff',
		'header_tagline_color'			=> '#fff',
		'header_txt_logo_extra'			=> 'show-all',

		// breadcrumb
		'breadcrumb_enable'				=> true,
		'breadcrumb_separator'			=> '/',
		
		// layout 
		'site_layout'         			=> 'wide-layout',
		'sidebar_position'         		=> 'right-sidebar',
		'post_sidebar_position' 		=> 'right-sidebar',
		'page_sidebar_position' 		=> 'right-sidebar',
		'social_nav_enable'				=> true,

		// excerpt options
		'long_excerpt_length'           => 25,
		
		// pagination options
		'pagination_enable'         	=> true,
		'pagination_type'         		=> 'default',

		// footer options
		'copyright_text'           		=> sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'travel-master' ), '[the-year]', '[site-link]' ),
		'scroll_top_visible'        	=> true,

		// reset options
		'reset_options'      			=> false,
		
		// homepage options
		'enable_frontpage_content' 		=> false,

		// homepage sections sortable
		'sortable' 						=> 'slider,trip_search,featured,popular_destination,about,service,blog,discover_places',

		// blog/archive options
		'your_latest_posts_title' 		=> esc_html__( 'Blogs', 'travel-master' ),
		'hide_date' 					=> false,
		'hide_category'					=> false,
		'hide_author'					=> false,

		// single post theme options
		'single_post_hide_date' 		=> false,
		'single_post_hide_author'		=> false,
		'single_post_hide_category'		=> false,
		'single_post_hide_tags'			=> false,

		/* Front Page */

		// Slider
		'slider_section_enable'			=> false,
		'slider_autoplay'				=> false,
		'slider_btn_label'				=> esc_html__( 'Discover More', 'travel-master' ),


		// trip search
		'trip_search_section_enable'	=> false,

		// featured
		'featured_section_enable'		=> false,
		'featured_content_type'			=> 'page',
		'featured_read_more'			=> esc_html__( 'See Details', 'travel-master' ),

		// popular destination
		'popular_destination_section_enable'	=> false,
		'popular_destination_content_type'		=> 'page',
		'popular_destination_title'				=> esc_html__( 'Popular Trips', 'travel-master' ),
		'popular_destination_read_more'			=> esc_html__( 'See Details', 'travel-master' ),

		// about
		'about_section_enable'			=> false,
		'about_btn_title'				=> esc_html__( 'Explore More', 'travel-master' ),

		// service
		'service_section_enable'		=> false,

		// blog
		'blog_section_enable'			=> false,
		'blog_content_type'				=> 'recent',
		'blog_title'					=> esc_html__( 'Amazing travel Articles', 'travel-master' ),

		// discover places
		'discover_places_section_enable'	=> false,
		'discover_places_auto_play'			=> false,
		'discover_places_content_type'		=> 'page',
		'discover_places_sub_title'			=> esc_html__( 'Last Minute', 'travel-master' ),
		'discover_places_read_more'			=> esc_html__( 'View Details', 'travel-master' ),

	);

	$output = apply_filters( 'travel_master_default_theme_options', $travel_master_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}