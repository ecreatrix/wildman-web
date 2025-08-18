<?php
$season  = array_key_exists( 'selectedSeason', $attributes ) && $attributes['selectedSeason'] ? $attributes['selectedSeason'] : false;
$version = array_key_exists( 'selectedVersion', $attributes ) && $attributes['selectedVersion'] ? $attributes['selectedVersion'] : false;

if ( str_contains( $season, 'automatic' ) ) {
    $season = \WA\Helpers\season();
}

$option_slug = 'wa_site_logo_' . $version . '_' . $season;

$id = get_option( $option_slug );

$width    = array_key_exists( 'width', $attributes ) && $attributes['width'] ? $attributes['width'] : false;
$setWidth = array_key_exists( 'setWidth', $attributes ) && $attributes['setWidth'] ? $attributes['setWidth'] : false;
$isLink   = array_key_exists( 'isLink', $attributes ) && $attributes['isLink'] ? $attributes['isLink'] : false;

if ( $id ) {
    $tag    = wp_get_attachment_image( $id );
    $is_svg = get_post_mime_type( $id ) === 'image/svg+xml';

    if ( $is_svg ) {
        $tag = file_get_contents( get_attached_file( $id ) );
    }

    if ( $isLink ) {
        $aria_current =  ! is_paged() && ( is_front_page() || is_home() && ( (int) get_option( 'page_for_posts' ) !== get_queried_object_id() ) ) ? ' aria-current="page"' : '';
        $link_target  =  ! empty( $attributes['linkTarget'] ) ? $attributes['linkTarget'] : '_self';

        $tag = sprintf(
            '<a href="%1$s" target="%2$s" rel="home"%3$s>%4$s</a>',
            esc_url( home_url() ),
            esc_attr( $link_target ),
            $aria_current,
            $tag
        );
    }

    $styles = [];
    if ( $setWidth ) {
        $styles[] = 'width: ' . $width . 'px;';
    }

    if ( count( $styles ) > 0 ) {
        $styles = ' style="' . implode( '', $styles ) . '"';
    } else {
        $styles = '';
    }

    echo '<div class="is-default-size wa-block-site-logo-seasons inner-fit-svg"' . $styles . '">' . $tag . '</div>';
}
