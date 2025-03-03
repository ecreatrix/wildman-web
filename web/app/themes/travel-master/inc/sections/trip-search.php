<?php
/**
 * Trip Search section
 *
 * This is the template for the content of trip_search section
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */
if ( ! function_exists( 'travel_master_add_trip_search_section' ) ) :
    /**
    * Add trip_search section
    *
    *@since Travel Master 1.0.0
    */
    function travel_master_add_trip_search_section() {
    	$options = travel_master_get_theme_options();
        // Check if trip_search is enabled on frontpage
        $trip_search_enable = apply_filters( 'travel_master_section_status', true, 'trip_search_section_enable' );

        if ( true !== $trip_search_enable || ! class_exists( 'WP_Travel' ) ) {
            return false;
        }

        // Render trip_search section now.
        travel_master_render_trip_search_section();
    }
endif;

if ( ! function_exists( 'travel_master_render_trip_search_section' ) ) :
  /**
   * Start trip_search section
   *
   * @return string trip_search content
   * @since Travel Master 1.0.0
   *
   */
   function travel_master_render_trip_search_section() {
        if ( ! class_exists('WP_Travel') ) 
            return;
                
        $options = travel_master_get_theme_options();
        ?>
        <div id="travel-search-section" class="relative page-section">
            <div class="wrapper">
                <div class="wp-travel-filter">
                    <?php travel_master_wptravel_search_form(); ?>
                </div><!-- wp-travel-filter -->
            </div><!-- .wrapper -->      
        </div><!-- #travel-search-section -->

    <?php }
endif;