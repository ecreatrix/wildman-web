<?php
namespace WA\Helpers;

use Illuminate\Support\Facades\Vite;

function enqueue_single_file( $handle, $filename, $dependencies = [], $set_type = false )
{
    $details = asset_details( $filename );

    if ( Vite::isRunningHot() && ! $details['is_external'] && false ) {
        foreach ( $dependencies as $dependency ) {
            if (  ! wp_script_is( $dependency ) ) {
                wp_enqueue_script( $dependency );
            }
        }

        echo Vite::withEntryPoints( [
            $filename,
        ] )->toHtml();
    } else {
        $is_style_extension = in_array( pathinfo( $filename, PATHINFO_EXTENSION ), ['css', 'scss'], true );
        $is_style           = $set_type ? 'css' === $set_type : $is_style_extension;

        $enqueue_function = $is_style ? 'wp_enqueue_style' : 'wp_enqueue_script';

        $filetime = $details['path'] ? filemtime( $details['path'] ) : false;

        //var_dump( $handle . ' ' .  ! $is_style . '<br>' );
        $enqueue_function(
            $handle,
            $details['uri'],
            $dependencies,
            $filetime,
             ! $is_style // In footer for scripts
        );
    }
}

function add_vite_HMR()
{
    if (  ! Vite::isRunningHot() ) {
        return;
    }

    $script = sprintf(
        <<<'JS'
            window.__vite_client_url = '%s';

            window.self !== window.top && document.head.appendChild(
                Object.assign(document.createElement('script'), { type: 'module', src: '%s' })
            );
            JS,
        untrailingslashit( Vite::asset( '' ) ),
        Vite::asset( '@vite/client' )
    );

    wp_add_inline_script( 'wp-blocks', $script );
}

function enqueue_multiple_files( $entry_points )
{
    foreach ( $entry_points as $handle => $asset ) {
        $dependencies = array_key_exists( 'dependencies', $asset ) ? $asset['dependencies'] : [];
        $set_type     = array_key_exists( 'set_type', $asset ) ? $asset['set_type'] : false;

        enqueue_single_file( $handle, $asset['filename'], $dependencies, $set_type );
    }
}

function asset_details( $filename )
{
    $hot         = Vite::isRunningHot();
    $is_external = ( strpos( $filename, 'http://' ) !== false ) || ( strpos( $filename, 'https://' ) !== false );

    $details = [
        'asset' => [],
        'uri'   => $filename,
        'path'  => false,
    ];

    //Can't use vite alone because it won't add dependencies
    if (  ! $is_external ) {
        $asset = Asset( $filename );

        $details = [
            'asset' => $asset,
            'uri'   => $hot ? Vite::asset( $filename ) : $asset->uri(),
            'path'  => $hot ? get_template_directory() . '/' . $filename : $asset->path(),
        ];
    }

    $details['is_external'] = $is_external;

    return $details;
}

function season()
{
    $month = date( 'n' );

    if ( 12 == $month || 1 == $month || 2 == $month ) {
        return "winter";
    } else if ( 3 == $month || 4 == $month || 5 == $month ) {
        return "spring";
    } else if ( 6 == $month || 7 == $month || 8 == $month ) {
        return "summer";
    }

    return "fall";
}

function season_colours( $selected = false, $version = 'dark' )
{
    $colours = [
        'winter' => [
            'light' => '#4CDBF3',
            'base'  => '#00A3BF',
            'dark'  => '#00A3BF',
        ],
        'spring' => [
            'light' => '#50F29F',
            'base'  => '#06ED77',
            'dark'  => '#04BD5F',
        ],
        'summer' => [
            'light' => '#FFD654',
            'base'  => '#FFC50C',
            'dark'  => '#E6BA28',
        ],
        'fall'   => [
            'light' => '#FF8A4C',
            'base'  => '#FF5900',
            'dark'  => '#CC4700',
        ],
    ];

    if ( $selected && array_key_exists( $selected, $colours ) ) {
        return $colours[$selected][$version];
    }

    return $colours;
}

function get_attachment_id( $filename )
{
    global $wpdb;

    $attachment = $wpdb->get_results( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_attached_file' AND meta_value like'%$filename'", OBJECT );

    if ( $attachment && is_array( $attachment ) && [$attachment[0]] ) {
        $id = reset( $attachment[0] );
        return $id;

    }

    return false;
}
