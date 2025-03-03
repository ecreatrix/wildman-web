<?php 

	function travel_master_wptravel_search_form( ){
		if ( function_exists( 'wptravel_search_form' ) ) {
			return wptravel_search_form();
		} elseif ( function_exists( 'wp_travel_search_form' ) ) {
			return wp_travel_search_form( );
		}
	}

	function travel_master_wptravel_is_enable_pricing_options($trip_id ){
		if ( function_exists( 'wptravel_is_enable_pricing_options' ) ) {
			return wptravel_is_enable_pricing_options($trip_id );
		} elseif ( function_exists( 'wp_travel_is_enable_pricing_options' ) ) {
			return wp_travel_is_enable_pricing_options($trip_id  );
		}
	}

	function travel_master_wptravel_get_formated_price_currency( $attr ){
		if ( function_exists( 'wptravel_get_formated_price_currency' ) ) {
			return wptravel_get_formated_price_currency( $attr );
		} elseif ( function_exists( 'wp_travel_get_formated_price_currency' ) ) {
			return wp_travel_get_formated_price_currency( $attr );
		}
	}

	
	function travel_master_wptravel_get_average_rating( $attr ){
		if ( function_exists( 'wptravel_get_average_rating' ) ) {
			return wptravel_get_average_rating( $attr );
		} elseif ( function_exists( 'wp_travel_get_average_rating' ) ) {
			return wp_travel_get_average_rating( $attr );
		}
	}

	function travel_master_wptravel_tab_show_in_menu( $attr ){
		if ( function_exists( 'wptravel_tab_show_in_menu' ) ) {
			return wptravel_tab_show_in_menu( $attr );
		} elseif ( function_exists( 'wp_travel_tab_show_in_menu' ) ) {
			return wp_travel_tab_show_in_menu( $attr );
		}
	}

	function travel_master_wptravel_get_trip_duration( $trip_id ){
		if ( function_exists( 'wptravel_get_trip_duration' ) ) {
			return wptravel_get_trip_duration( $trip_id );
		} elseif ( function_exists( 'wp_travel_get_trip_duration' ) ) {
			return wp_travel_get_trip_duration( $trip_id );
		}
	}

	function travel_master_wptravel_do_deprecated_action( $tag, $args, $version, $replacement = '', $message = '' ){
		if ( function_exists( 'wptravel_do_deprecated_action' ) ) {
			return wptravel_do_deprecated_action( $tag, $args, $version, $replacement = '', $message = '' );
		} elseif ( function_exists( 'wp_travel_do_deprecated_action' ) ) {
			return wp_travel_do_deprecated_action( $tag, $args, $version, $replacement = '', $message = '' );
		}
	}

	function travel_master_wptravel_trip_rating( $trip_id ){
		if ( function_exists( 'wptravel_trip_rating' ) ) {
			return wptravel_trip_rating( $trip_id );
		} elseif ( function_exists( 'wp_travel_trip_rating' ) ) {
			return wp_travel_trip_rating( $trip_id );
		}
	}
	function travel_master_wptravel_get_group_size( $trip_id ){
		if ( function_exists( 'wptravel_get_group_size' ) ) {
			return wptravel_get_group_size( $trip_id );
		} elseif ( function_exists( 'wp_travel_get_group_size' ) ) {
			return wp_travel_get_group_size( $trip_id );
		}
	}
	function travel_master_wptravel_is_enable_sale( $trip_id, $price_key = '' ) {
		if ( method_exists( 'WP_Travel_Helpers_Trips', 'is_sale_enabled' ) ) {
			$args = array(
				'trip_id' => $trip_id,
			);
			return WP_Travel_Helpers_Trips::is_sale_enabled( $args );
		} else {
			return wp_travel_is_enable_sale( $trip_id, $price_key );
		}
	}
	function travel_master_wptravel_get_archive_view_mode( ){
		if ( function_exists( 'wptravel_get_archive_view_mode' ) ) {
			return wptravel_get_archive_view_mode( );
		} elseif ( function_exists( 'wp_travel_get_archive_view_mode' ) ) {
			return wp_travel_get_archive_view_mode( );
		}
	}
	function travel_master_wptravel_get_review_count( ){
		if ( function_exists( 'wptravel_get_review_count' ) ) {
			return wptravel_get_review_count( );
		} elseif ( function_exists( 'wp_travel_get_review_count' ) ) {
			return wp_travel_get_review_count( );
		}
	}

	function travel_master_wptravel_get_template_part( $attr1, $attr2 ){
		if ( function_exists( 'wptravel_get_template_part' ) ) {
			return wptravel_get_template_part( $attr1, $attr2 );
		} elseif ( function_exists( 'wp_travel_get_template_part' ) ) {
			return wp_travel_get_template_part( $attr1, $attr2 );
		}
	}
	function travel_master_wptravel_get_post_thumbnail( $attr1, $attr2 ){
		if ( function_exists( 'wptravel_get_post_thumbnail' ) ) {
			return wptravel_get_post_thumbnail( $attr1, $attr2 );
		} elseif ( function_exists( 'wp_travel_get_post_thumbnail' ) ) {
			return wp_travel_get_post_thumbnail( $attr1, $attr2 );
		}
	}
	function travel_master_wptravel_trip_price( $trip_id ){
		if ( function_exists( 'wptravel_trip_price' ) ) {
			return wptravel_trip_price( $trip_id );
		} elseif ( function_exists( 'wp_travel_trip_price' ) ) {
			return wp_travel_trip_price( $trip_id );
		}
	}
	function travel_master_wptravel_single_excerpt( $post_id){
		if ( function_exists( 'wptravel_single_excerpt' ) ) {
			return wptravel_single_excerpt( $post_id);
		} elseif ( function_exists( 'wp_travel_single_excerpt' ) ) {
			return wp_travel_single_excerpt( $post_id);
		}
	}

	function travel_master_wptravel_trip_map( $post_id){
		if ( function_exists( 'wptravel_trip_map' ) ) {
			return wptravel_trip_map( $post_id);
		} elseif ( function_exists( 'wp_travel_trip_map' ) ) {
			return wp_travel_trip_map( $post_id);
		}
	}
	function travel_master_wptravel_archive_wrapper_close(){
		if ( function_exists( 'wptravel_archive_wrapper_close' ) ) {
			return wptravel_get_formated_price_currency();
		} elseif ( function_exists( 'wp_travel_archive_wrapper_close' ) ) {
			return wp_travel_archive_wrapper_close();
		}
	}
 ?>