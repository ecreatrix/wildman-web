<?php
/**
 * About section
 *
 * This is the template for the content of about section
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */
if ( ! function_exists( 'travel_master_add_about_section' ) ) :
    /**
    * Add about section
    *
    *@since Travel Master 1.0.0
    */
    function travel_master_add_about_section() {
    	$options = travel_master_get_theme_options();
        // Check if about is enabled on frontpage
        $about_enable = apply_filters( 'travel_master_section_status', true, 'about_section_enable' );

        if ( true !== $about_enable ) {
            return false;
        }
        // Get about section details
        $section_details = array();
        $section_details = apply_filters( 'travel_master_filter_about_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render about section now.
        travel_master_render_about_section( $section_details );
    }
endif;

if ( ! function_exists( 'travel_master_get_about_section_details' ) ) :
    /**
    * about section details.
    *
    * @since Travel Master 1.0.0
    * @param array $input about section details.
    */
    function travel_master_get_about_section_details( $input ) {
        $options = travel_master_get_theme_options();

        $content = array();
        $page_id = ! empty( $options['about_content_page'] ) ? $options['about_content_page'] : '';
        $args = array(
            'post_type'         => 'page',
            'page_id'           => $page_id,
            'posts_per_page'    => 1,
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['excerpt']   = travel_master_trim_content( 35 );
                $page_post['url']       = get_the_permalink();
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : '';

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
// about section content details.
add_filter( 'travel_master_filter_about_section_details', 'travel_master_get_about_section_details' );


if ( ! function_exists( 'travel_master_render_about_section' ) ) :
  /**
   * Start about section
   *
   * @return string about content
   * @since Travel Master 1.0.0
   *
   */
   function travel_master_render_about_section( $content_details = array() ) {
        $options = travel_master_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } 

        foreach ( $content_details as $content ) : ?>

            <div id="about-us" class="relative page-section">
                <div class="wrapper">
                    <article class="<?php echo ! empty( $content['image'] ) ? 'has' : 'no'; ?>-post-thumbnail">
                        <?php if ( ! empty( $content['image'] ) ) : ?>
                            <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');"></div>
                        <?php endif; ?>

                        <div class="entry-container">
                            <header class="entry-header">
                                <h2 class="entry-title"><?php echo esc_html( $content['title'] ); ?></h2>
                            </header>

                            <div class="entry-content">
                                <p><?php echo wp_kses_post( $content['excerpt'] ); ?></p>
                            </div><!-- .entry-content -->

                            <?php if ( ! empty( $options['about_btn_title'] ) ) : ?>
                                <div class="read-more">
                                    <a href="<?php echo esc_url( $content['url'] ); ?>" class="btn">
                                        <span class="screen-reader-text"><?php echo esc_html( $content['title'] ); ?></span>
                                        <?php echo esc_html( $options['about_btn_title'] ); ?>
                                    </a>
                                </div><!-- .read-more -->
                            <?php endif; ?>

                        </div><!-- .entry-container -->
                    </article>
                </div><!-- .wrapper -->
            </div><!-- #about-us -->

        <?php endforeach;
    }
endif;