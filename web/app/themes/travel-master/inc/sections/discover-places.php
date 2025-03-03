<?php
/**
 * Discover Places section
 *
 * This is the template for the content of discover places section
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */
if ( ! function_exists( 'travel_master_add_discover_places_section' ) ) :
    /**
    * Add discover places section
    *
    *@since Travel Master 1.0.0
    */
    function travel_master_add_discover_places_section() {
    	$options = travel_master_get_theme_options();
        // Check if destination is enabled on frontpage
        $discover_places_enable = apply_filters( 'travel_master_section_status', true, 'discover_places_section_enable' );

        if ( true !== $discover_places_enable ) {
            return false;
        }
        // Get destination section details
        $section_details = array();
        $section_details = apply_filters( 'travel_master_filter_discover_places_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render destination section now.
        travel_master_render_discover_places_section( $section_details );
    }
endif;

if ( ! function_exists( 'travel_master_get_discover_places_section_details' ) ) :
    /**
    * discover places section details.
    *
    * @since Travel Master 1.0.0
    * @param array $input discover places section details.
    */
    function travel_master_get_discover_places_section_details( $input ) {
        $options = travel_master_get_theme_options();

        // Content type.
        $discover_places_content_type  = $options['discover_places_content_type'];
        
        $content = array();
        switch ( $discover_places_content_type ) {
        	
            case 'page':
                $page_ids = array();

                for ( $i = 1; $i <= 3; $i++ ) {
                    if ( ! empty( $options['discover_places_content_page_' . $i] ) )
                        $page_ids[] = $options['discover_places_content_page_' . $i];
                }
                
                $args = array(
                    'post_type'         => 'page',
                    'post__in'          => ( array ) $page_ids,
                    'posts_per_page'    => 3,
                    'orderby'           => 'post__in',
                    );                    
            break;

            case 'trip':
                if ( ! class_exists( 'WP_Travel' ) )
                    return;

                $page_ids = array();

                for ( $i = 1; $i <= 3; $i++ ) {
                    if ( ! empty( $options['discover_places_content_trip_' . $i] ) )
                        $page_ids[] = $options['discover_places_content_trip_' . $i];
                }
                
                $args = array(
                    'post_type'         => 'itineraries',
                    'post__in'          => ( array ) $page_ids,
                    'posts_per_page'    => 3,
                    'orderby'           => 'post__in',
                    );                    
            break;

            default:
            break;
        }


            // Run The Loop.
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) : 
                while ( $query->have_posts() ) : $query->the_post();
                    $page_post['id']        = get_the_id();
                    $page_post['title']     = get_the_title();
                    $page_post['url']       = get_the_permalink();
                    $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'large' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-590x650.jpg';

                    // Push to the main array.
                    array_push( $content, $page_post );
                endwhile;
            endif;
            wp_reset_postdata();

            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// destination section content details.
add_filter( 'travel_master_filter_discover_places_section_details', 'travel_master_get_discover_places_section_details' );


if ( ! function_exists( 'travel_master_render_discover_places_section' ) ) :
  /**
   * Start destination section
   *
   * @return string destination content
   * @since Travel Master 1.0.0
   *
   */
   function travel_master_render_discover_places_section( $content_details = array() ) {
        $options = travel_master_get_theme_options();
        $readmore = ! empty( $options['discover_places_read_more'] ) ? $options['discover_places_read_more'] : esc_html__( 'View Details', 'travel-master' );

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="discover-places" class="relative page-section">
            <div class="wrapper">
                <div class="places-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": true, "arrows":false, "autoplay": <?php echo $options['discover_places_auto_play'] ? 'true' : 'false'; ?>, "draggable": true, "fade": true, "adaptiveHeight": true }'>
                    <?php foreach ( $content_details as $content ) : ?>
                        <article style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');">
                            <div class="overlay"></div>

                            <div class="entry-container">
                                <header class="entry-header">
                                    <?php if ( ! empty( $options['discover_places_sub_title'] ) ) : ?>
                                        <p class="section-subtitle"><?php echo esc_html( $options['discover_places_sub_title'] ); ?></p>
                                    <?php endif; ?>
                                    <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                </header>

                                <div class="read-more">
                                    <a href="<?php echo esc_url( $content['url'] ); ?>" class="btn">
                                        <span class="screen-reader-text"><?php echo esc_html( $content['title'] ); ?></span>
                                        <?php echo esc_html( $readmore ); ?>
                                    </a>
                                </div><!-- .read-more -->
                            </div><!-- .entry-container -->
                        </article>
                    <?php endforeach; ?>
                </div><!-- .places-slider -->
            </div><!-- .wrapper -->
        </div><!-- #discover-places -->

    <?php }
endif;