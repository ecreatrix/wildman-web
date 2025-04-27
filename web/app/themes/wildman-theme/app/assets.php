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

if (  ! class_exists( Assets::class ) ) {
    class Assets
    {
        public function __construct()
        {
            add_action( 'login_enqueue_scripts', [$this, 'add_login_styles'], 100 );

            add_action( 'wp_head', [$this, 'hmr_frontend'], 100 );
            add_action( 'admin_head', [$this, 'hmr_dashboard'], 100 );

            add_action( 'wp_enqueue_scripts', [$this, 'frontend_assets'] );

            add_filter( 'admin_head', [$this, 'dashboard_assets'], 200 );
            add_filter( 'block_editor_settings_all', [$this, 'inject_styles'] );

            //add_filter( 'script_loader_tag', [$this, 'add_module_attribute'], 10, 3 );
        }

        public function add_login_styles()
        {
            \WA\Helpers\add_vite_HMR();

            $entry_points = [
                'wa/login'        => [
                    'filename' => 'resources/css/login.css',
                ],
                'wa/fonts/google' => [
                    'filename' => \WA\Theme\wa_google_font(),
                    'set_type' => 'css',
                ],
            ];

            \WA\Helpers\enqueue_multiple_files( $entry_points );
        }

        public function add_module_attribute( $tag, $handle, $src )
        {
            return $tag;
            // add 'type module' to theme scripts when hot
            if (  ! Vite::isRunningHot() ) {
                return $tag;
            }

            if ( 'wa/editorjs' !== $handle && 'wa/appjs' !== $handle ) {
                return $tag;
            }

            // Add the type="module" attribute
            return '<script type="module" src="' . esc_url( $src ) . '" id="' . esc_attr( $handle ) . '"></script>';
        }

        /**
         * Inject scripts into the block editor.
         *
         * @return void
         */
        public function dashboard_assets()
        {
            if (  ! is_admin() || ! get_current_screen()?->is_block_editor() ) {
                return;
            }

            /*$dependencies = json_decode( Vite::content( 'editor.deps.json' ) );

            foreach ( $dependencies as $dependency ) {
            if (  ! wp_script_is( $dependency ) ) {
            wp_enqueue_script( $dependency );
            }
            }*/

            $dependencies   = json_decode( Vite::content( 'editor.deps.json' ) );
            $dependencies[] = 'wp-editor';
            $dependencies[] = 'wp-edit-post';
            $dependencies[] = 'wp-edit-site';

            $entry_points = [
                'wa/fonts/google' => [
                    'filename' => \WA\Theme\wa_google_font(),
                    'set_type' => 'css',
                ],
                'wa/editorcss'    => [
                    'filename' => 'resources/css/editor.css',
                ],
            ];

            if ( Vite::isRunningHot() ) {
                foreach ( $dependencies as $dependency ) {
                    if (  ! wp_script_is( $dependency ) ) {
                        wp_enqueue_script( $dependency );
                    }
                }

                echo Vite::withEntryPoints( [
                    'resources/js/editor.jsx',
                ] )->toHtml();
            } else {
                $entry_points['wa/editorjs'] = [
                    'filename'     => 'resources/js/editor.jsx',
                    'dependencies' => $dependencies,
                ];
            }

            \WA\Helpers\enqueue_multiple_files( $entry_points );

            wp_enqueue_script( 'wa/fonts/fontawesome', \WA\Theme\wa_fontawesome(), false, false, [
                'in_footer'   => true,
                'crossorigin' => 'anonymous',
            ] );

            //wp_enqueue_script( 'wa/editorjs', 'http://[::1]:5173/app/themes/wildman-theme/public/build/resources/js/editor.jsx', '', false, true );
        }

        public function frontend_assets()
        {
            $wp_deps      = ['wp-dom-ready']; //, 'wp-element', 'wp-data', 'wp-block-editor'
            $entry_points = [
                'wa/fonts/google' => [
                    'filename' => \WA\Theme\wa_google_font(),
                    'set_type' => 'css',
                ],
                'wa/appcss'       => [
                    'filename' => 'resources/css/app.css',
                ],
            ];

            $entry_points = [
                'wa/fonts/google' => [
                    'filename' => \WA\Theme\wa_google_font(),
                    'set_type' => 'css',
                ],
                'wa/appcss'       => [
                    'filename' => 'resources/css/app.css',
                ],
            ];

            if ( Vite::isRunningHot() ) {
                foreach ( $wp_deps as $dependency ) {
                    if (  ! wp_script_is( $dependency ) ) {
                        wp_enqueue_script( $dependency );
                    }
                }

                echo Vite::withEntryPoints( [
                    'resources/js/app.jsx',
                ] )->toHtml();
            } else {
                $entry_points['wa/appjs'] = [
                    'filename'     => 'resources/js/app.jsx',
                    'dependencies' => $wp_deps,
                ];
            }

            \WA\Helpers\enqueue_multiple_files( $entry_points );

            wp_enqueue_script( 'wa/fonts/fontawesome', \WA\Theme\wa_fontawesome(), false, false, [
                'in_footer'   => true,
                'crossorigin' => 'anonymous',
            ] );
        }

        public function hmr_dashboard()
        {
            if (  ! get_current_screen()?->is_block_editor() ) {
                return;
            }

            \WA\Helpers\add_vite_HMR();
        }

        public function hmr_frontend()
        {
            \WA\Helpers\add_vite_HMR();
        }

        /**
         * Inject styles into the block editor.
         *
         * @return array
         */
        public function inject_styles( $settings )
        {
            $style = Vite::asset( 'resources/css/editor.css' );

            $settings['styles'][] = [
                'css' => Vite::isRunningHot()
                ? "@import url('{$style}')"
                : Vite::content( 'resources/css/editor.css' ),
            ];

            return $settings;
        }
    }

    new Assets();
}
