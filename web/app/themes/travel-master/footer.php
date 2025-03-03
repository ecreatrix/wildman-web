<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Travel Master
 * @since Travel Master 1.0.0
 */

/**
 * travel_master_footer_primary_content hook
 *
 * @hooked travel_master_add_contact_section -  10
 *
 */
do_action( 'travel_master_footer_primary_content' );

/**
 * travel_master_content_end_action hook
 *
 * @hooked travel_master_content_end -  10
 *
 */
do_action( 'travel_master_content_end_action' );

/**
 * travel_master_content_end_action hook
 *
 * @hooked travel_master_footer_start -  10
 * @hooked Travel_Master_Footer_Widgets->add_footer_widgets -  20
 * @hooked travel_master_footer_site_info -  40
 * @hooked travel_master_footer_end -  100
 *
 */
do_action( 'travel_master_footer' );

/**
 * travel_master_page_end_action hook
 *
 * @hooked travel_master_page_end -  10
 *
 */
do_action( 'travel_master_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
