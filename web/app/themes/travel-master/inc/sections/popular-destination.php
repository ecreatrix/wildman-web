<?php
/**
 * Popular Destination section
 *
 * This is the template for the content of popular destination section
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */
if ( ! function_exists( 'travel_master_add_popular_destination_section' ) ) :
    /**
    * Add popular destination section
    *
    *@since Travel Master 1.0.0
    */
    function travel_master_add_popular_destination_section() {
    	$options = travel_master_get_theme_options();
        // Check if destination is enabled on frontpage
        $popular_destination_enable = apply_filters( 'travel_master_section_status', true, 'popular_destination_section_enable' );

        if ( true !== $popular_destination_enable ) {
            return false;
        }
        // Get destination section details
        $section_details = array();
        $section_details = apply_filters( 'travel_master_filter_popular_destination_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render destination section now.
        travel_master_render_popular_destination_section( $section_details );
    }
endif;

if ( ! function_exists( 'travel_master_get_popular_destination_section_details' ) ) :
    /**
    * popular destination section details.
    *
    * @since Travel Master 1.0.0
    * @param array $input popular destination section details.
    */
    function travel_master_get_popular_destination_section_details( $input ) {
        $options = travel_master_get_theme_options();

        // Content type.
        $popular_destination_content_type  = $options['popular_destination_content_type'];
        
        $content = array();
        switch ( $popular_destination_content_type ) {
        	
            case 'page':
                $page_ids = array();

                for ( $i = 1; $i <= 4; $i++ ) {
                    if ( ! empty( $options['popular_destination_content_page_' . $i] ) )
                        $page_ids[] = $options['popular_destination_content_page_' . $i];
                }
                
                $args = array(
                    'post_type'         => 'page',
                    'post__in'          => ( array ) $page_ids,
                    'posts_per_page'    => 4,
                    'orderby'           => 'post__in',
                    );                    
            break;

            case 'trip':
                if ( ! class_exists( 'WP_Travel' ) )
                    return;

                $page_ids = array();

                for ( $i = 1; $i <= 4; $i++ ) {
                    if ( ! empty( $options['popular_destination_content_trip_' . $i] ) )
                        $page_ids[] = $options['popular_destination_content_trip_' . $i];
                }
                
                $args = array(
                    'post_type'         => 'itineraries',
                    'post__in'          => ( array ) $page_ids,
                    'posts_per_page'    => 4,
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
                    $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-590x650.jpg';

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
add_filter( 'travel_master_filter_popular_destination_section_details', 'travel_master_get_popular_destination_section_details' );


if ( ! function_exists( 'travel_master_render_popular_destination_section' ) ) :
  /**
   * Start destination section
   *
   * @return string destination content
   * @since Travel Master 1.0.0
   *
   */
   function travel_master_render_popular_destination_section( $content_details = array() ) {
        $options = travel_master_get_theme_options();
        $popular_destination_content_type  = $options['popular_destination_content_type'];

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="top-destinations" class="relative page-section">
            <div class="wrapper">
                <div class="section-header-wrapper clear">
                    <div class="section-header">
                        <?php if ( ! empty( $options['popular_destination_title'] ) ) : ?>
                            <h2 class="section-title"><?php echo esc_html( $options['popular_destination_title'] ); ?></h2>
                        <?php endif; ?>

                    </div><!-- .section-header -->

                </div><!-- .section-header-wrapper -->

                <div class="section-content col-4 clear">
                    <?php foreach ( $content_details as $content ) : ?>
                        <article>
                            <div class="destination-item-wrapper">
                                <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');">
                                    <div class="overlay"></div>
                                    <a href="<?php echo esc_url( $content['url'] ) ?>" class="more-link">
                                        <?php echo travel_master_get_svg( array( 'icon' => 'add' ) ); ?>
                                    </a><!-- .more-link -->

                                    <?php if ( ! in_array( $popular_destination_content_type, array( 'category', 'page', 'post' ) ) ) : 
                                        $price_key = '';
                                        $sale_enabled = get_post_meta( $content['id'], 'wp_travel_enable_sale', true );
                                        if( travel_master_wptravel_is_enable_pricing_options( $content['id'] ) ) {
                                            
                                            $pricing_options = get_post_meta( $content['id'], 'wp_travel_pricing_options', true );
                                            $price_key = wp_travel_get_min_price_key( $pricing_options );
                                        }

                                        $trip_price      = WP_Travel_Helpers_Pricings::get_price(array('trip_id'=>$content['id'], 'price_key'=>$price_key));
                                        
                                        if ( travel_master_wptravel_tab_show_in_menu( 'reviews' ) ) :
                                        $average_rating = travel_master_wptravel_get_average_rating( $content['id'] ); ?>
                                            <div class="wp-travel-average-review" title="<?php printf( esc_attr__( 'Rated %s out of 5', 'travel-master' ), $average_rating ); ?>">
                                                <span style="width:<?php echo esc_attr( ( $average_rating / 5 ) * 100 ); ?>%">
                                                    <strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average_rating ); ?></strong> <?php printf( esc_html__( 'out of %1$s5%2$s', 'travel-master' ), '<span itemprop="bestRating">', '</span>' ); ?>
                                                </span>
                                            </div>
                                        <?php endif;

                                        if ( false !== $sale_enabled && '1' === $sale_enabled ) : ?>
                                            <div class="wp-travel-offer">
                                                <span><?php esc_html_e( 'Offer', 'travel-master' ); ?></span>
                                            </div>
                                        <?php endif;
                                    endif; ?>
                                </div><!-- .featured-image -->

                                <div class="entry-container clear">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                        <?php if ( ! in_array( $popular_destination_content_type, array( 'category', 'page', 'post' ) ) ) : 
                                            $terms = wp_get_post_terms( $content['id'], 'travel_locations' );
                                            ?>
                                            <span>
                                                <?php foreach ( $terms as $term ) : ?>
                                                    <a href="<?php echo esc_url( get_term_link( $term->term_id, 'travel_locations' ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
                                                <?php endforeach; ?>
                                            </span>
                                        <?php endif; ?>
                                    </header>   

                                    <div class="price-wrapper">
                                        <?php if ( ! in_array( $popular_destination_content_type, array( 'category', 'page', 'post' ) ) ) : ?>
                                            <span class="trip-price">                       
                                                <?php echo travel_master_wptravel_get_formated_price_currency( $trip_price ); ?>
                                            </span><!-- .trip-price -->
                                        <?php endif;
                                        
                                        if ( ! empty( $options['popular_destination_read_more'] ) ) : ?>
                                            <a href="<?php echo esc_url( $content['url'] ); ?>" class="more-link"><?php echo esc_html( $options['popular_destination_read_more'] ); ?></a>
                                        <?php endif; ?>
                                    </div><!-- .price-wrapper -->
                                </div><!-- .entry-container -->
                            </div><!-- .destination-item-wrapper -->
                        </article>
                    <?php endforeach; ?>
                    
                </div><!-- .section-content -->

            </div><!-- .wrapper -->
        </div><!-- #top-destinations -->
        
    <?php }
endif;