<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */
$options = travel_master_get_theme_options();
$class = has_post_thumbnail() ? '' : 'no-post-thumbnail';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear ' . $class ); ?>>

	<div class="entry-meta">
		<?php if ( ! $options['single_post_hide_author'] ) :
			echo travel_master_author_meta();
		endif; 

		if ( ! $options['single_post_hide_date'] ) :
			travel_master_posted_on(); 
		endif; ?>
    </div><!-- .entry-meta -->

    <div class="entry-container">
        <div class="entry-content">
            <?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'travel-master' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'travel-master' ),
					'after'  => '</div>',
				) );
			?>
        </div><!-- .entry-content -->
    </div><!-- .entry-container -->

    <div class="entry-meta">
        <?php travel_master_entry_footer(); ?>     
    </div><!-- .entry-meta -->

</article><!-- #post-## -->
