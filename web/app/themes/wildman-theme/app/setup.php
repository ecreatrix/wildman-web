<?php

/**
 * Theme setup.
 */

namespace WA\App;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Vite;

if (  ! defined( 'ABSPATH' ) ) {
    exit;
}

if (  ! class_exists( Setup::class ) ) {
    class Setup
    {
        public function __construct()
        {
            add_filter( 'theme_file_path', [$this, 'change_themejson_location'], 10, 2 );
            add_action( 'after_setup_theme', [$this, 'theme_supports'], 20 );
            add_filter( 'excerpt_more', [$this, 'excerpt_more'] );
            add_action( 'login_head', [$this, 'add_favicon_admin'] );
            add_action( 'admin_head', [$this, 'add_favicon_admin'] );
            add_action( 'wp_head', [$this, 'add_favicon_frontend'] );
            add_action( 'excerpt_more', [$this, 'excerpt_more'] );

            add_filter( 'wp_theme_json_data_theme', [$this, 'theme_json_season'] );

        }

        public function add_favicon( $favicon )
        {
            // Set favicon by filname from attachment if possible, if not use theme
            $id  = \WA\Helpers\get_attachment_id( $favicon );
            $uri = false;
            if ( $id ) {
                $uri = \wp_get_attachment_url( $id );
            } else {
                $favicon = \WA\Helpers\asset_details( 'resources/images/favicon-admin.png' );

                if (  ! $favicon || is_array( $favicon ) ) {
                    $uri = $favicon['uri'];
                }
            }

            if (  ! $uri ) {
                return;
            }

            $output = '<link rel="icon" href="' . $uri . '" sizes="32x32">
                <link rel="icon" href="' . $uri . '" sizes="192x192">
                <link rel="apple-touch-icon" href="' . $uri . '">
                <meta name="msapplication-TileImage" content="' . $uri . '">
            ';

            echo $output;
        }

        public function add_favicon_admin()
        {
            $favicon = 'admin.png';

            $this->add_favicon( $favicon );
        }

        public function add_favicon_frontend()
        {
            $favicon = 'favicon.png';

            $this->add_favicon( $favicon );
        }

        /**
         * Use the generated theme.json file.
         *
         * @return string
         */
        public function change_themejson_location( $path, $file )
        {
            return 'theme.json' === $file ? public_path( 'build/assets/theme.json' )
            : $path;
        }

        /**
         * Add "… Continued" to the excerpt.
         *
         * @return string
         */
        public function excerpt_more()
        {
            return sprintf( ' &hellip; <a href="%s">%s</a>', get_permalink(), __( 'Continued', 'watheme' ) );
        }

        public function theme_json_season( $theme_json )
        {
            //Set seson color based on actual season and update in theme.json
            $theme_json_array = $theme_json->get_data();
            $palette          = $theme_json_array['settings']['color']['palette']['theme'];

            $season       = \WA\Helpers\season();
            $season_color = \WA\Helpers\season_colours( $season );

            foreach ( $palette as $key => $color ) {
                if ( 'season' === $color['slug'] ) {
                    //var_dump( $theme_json_array['settings']['color']['palette']['theme'][$key] );
                    $theme_json_array['settings']['color']['palette']['theme'][$key]['color'] = $season_color;
                }
            }

            return $theme_json->update_with( $theme_json_array );
        }

        /**
         * Register the initial theme setup.
         *
         * @return void
         */
        public function theme_supports()
        {
            /**
             * Register the navigation menus.
             *
             * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
             */
            register_nav_menus( [
                'primary_navigation' => __( 'Primary Navigation', 'watheme' ),
                'footer'             => __( 'Footer Navigation', 'watheme' ),
            ] );

            /**
             * Disable the default block patterns.
             *
             * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
             */
            remove_theme_support( 'core-block-patterns' );

            /**
             * Enable plugins to manage the document title.
             *
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
             */
            add_theme_support( 'title-tag' );

            /**
             * Enable post thumbnail support.
             *
             * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
             */
            add_theme_support( 'post-thumbnails' );

            /**
             * Enable responsive embed support.
             *
             * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
             */
            add_theme_support( 'responsive-embeds' );

            /**
             * Enable HTML5 markup support.
             *
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
             */
            add_theme_support( 'html5', [
                'caption',
                'comment-form',
                'comment-list',
                'gallery',
                'search-form',
                'script',
                'style',
            ] );

            /**
             * Enable selective refresh for widgets in customizer.
             *
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
             */
            add_theme_support( 'customize-selective-refresh-widgets' );
        }
    }

    new Setup();
}
