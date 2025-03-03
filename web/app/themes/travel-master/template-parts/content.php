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
$class = has_post_thumbnail() ? '' : 'no-post-thumbnail';
$options = travel_master_get_theme_options();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>

    <div class="post-item-wrapper">
        <div class="entry-container">
            <?php echo travel_master_article_header_meta(); ?>

            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </header>

            <div class="entry-content">
                <p><?php the_excerpt(); ?></p>
            </div><!-- .entry-content -->
        </div><!-- .entry-container -->

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-image matchheight" style="background-image: url('<?php the_post_thumbnail_url( 'post-thumbnail' ); ?>');">
                <a href="<?php the_permalink(); ?>" class="post-thumbnail-link"></a>
            </div><!-- .featured-image -->
        <?php endif; ?>

        <div class="entry-meta">
            <?php 
                travel_master_posted_on(); 
                echo travel_master_author_meta();
            ?>
        </div><!-- .entry-meta -->
    </div><!-- .post-item-wrapper -->

</article><!-- #post-## -->
