<?php
namespace WA\Gutenberg;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Vite;

if (  ! defined( 'ABSPATH' ) ) {
    exit;
}

if (  ! class_exists( Gutenberg::class ) ) {
    class Gutenberg
    {
        public function __construct()
        {
            add_action( 'admin_init', [$this, 'addOptions'] );
            add_action( 'rest_api_init', [$this, 'register_settings'] );
            add_action( 'admin_init', [$this, 'register_settings'] );
            add_action( 'rest_api_init', [$this, 'register_rest_route'] );

            add_action( 'init', [$this, 'register_blocks'] );
            //add_filter( 'render_block_core/button', [$this, 'button_icons' ], 10, 2 );

            add_action( 'admin_init', [$this, 'reset_theme_settings'] );

            add_filter( 'block_type_metadata', [$this, 'filter_attributes'] );
            //add_action( 'enqueue_block_editor_assets', [$this, 'aay_get_all_blocks_script'] );
        }

        public function addOptions()
        {
            add_option( 'wathemes', ['site_logo_tall' => '790', 'site_logo_long' => false] );
            //update_option( 'wathemes', ['site_logo_tall' => '750', 'site_logo_long' => false] );

            /*register_setting(
        'wa',
        'site_logo_tall',
        [
        'type'              => 'string',
        'show_in_rest'      => true,
        'sanitize_callback' => 'sanitize_text_field',
        ]
        );
        register_setting(
        'wa',
        'site_logo_long',
        [
        'type'              => 'string',
        'show_in_rest'      => true,
        'sanitize_callback' => 'sanitize_text_field',
        ]
        );*/
        }

        public function filter_attributes( $metadata )
        {
            if ( 'core/navigation' === $metadata['name'] ) {
                if ( isset( $metadata['attributes']['customBackgroundColor'] ) ) {
                    $metadata['attributes']['customBackgroundColor'] = false; // Disable background color
                }
            }

            return $metadata;
        }

        public function register_blocks()
        {
            wp_register_block_metadata_collection(
                get_template_directory() . '/public/build/blocks',
                get_template_directory() . '/public/build/blocks/blocks-manifest.php'
            );

            //var_dump( get_template_directory() . '/public/build/blocks/blocks-manifest.php' );

            //register_block_type( get_template_directory() . '/public/build/blocks/custom/copyright-date-block' );

            //$SiteLogo = new \WA\Blocks\SiteLogo\Block_Renderer();
            register_block_type( get_template_directory() . '/public/build/blocks/custom/site-logo-multiple' );

            //var_dump( get_template_directory() . '/public/build/blocks/custom/site-logo-multiple' );

            /*$navigation = new WA\Blocks\Navigation\Block_Renderer();
            register_block_type( get_template_directory() . '/public/build/blocks/custom/navigation-gt',
            [
            'render_callback' => [$navigation, 'render'],
            ]
            );*/

            if (  ! function_exists( 'register_block_style' ) ) {
                return;
            }

            unregister_block_style( 'core/button', 'fill' );
            unregister_block_style( 'core/button', 'outline' );

            register_block_style(
                'core/button',
                [
                    "name"       => 'primary-button',
                    "label"      => 'Primary',
                    "is_default" => true,
                ]
            );
            register_block_style(
                'core/button',
                [
                    "name"  => 'secondary-button',
                    "label" => 'Secondary',
                ]
            );
            register_block_style(
                'core/button',
                [
                    "name"  => 'outline-button',
                    "label" => 'Outline',
                ]
            );
            register_block_style(
                'core/button',
                [
                    "name"  => 'cta-button',
                    "label" => 'CTA',
                ]
            );

            register_block_style(
                'core/gallery',
                [
                    'name'  => 'masonry',
                    'label' => __( 'Masonry', 'wathemes' ),
                ]
            );

            //var_dump( $test );
        }

        public function register_rest_route()
        {
            register_rest_route( 'wa/v1', '/site/', [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => function ( $data ) {
                        return [
                            'season' => \WA\Helpers\season(),
                        ];

                    },
                    'permission_callback' => '__return_true',
                ],
            ] );
        }

        public function register_settings()
        {
            register_setting(
                'general',
                'wa_button_booking_link',
                [
                    'show_in_rest' => [
                        'name' => 'wa_button_booking_link',
                    ],
                    'type'         => 'string',
                    'label'        => __( 'Booking Link' ),
                    'description'  => __( 'Booking Link' ),
                ]
            );

            register_setting(
                'general',
                'wa_site_logo_tall_winter',
                [
                    'show_in_rest' => [
                        'name' => 'wa_site_logo_tall_winter',
                    ],
                    'type'         => 'integer',
                    'label'        => __( 'Logo (Tall - Winter)' ),
                    'description'  => __( 'Site logo (Tall - Winter).' ),
                ]
            );
            register_setting(
                'general',
                'wa_site_logo_long_winter',
                [
                    'show_in_rest' => [
                        'name' => 'wa_site_logo_long_winter',
                    ],
                    'type'         => 'integer',
                    'label'        => __( 'Logo (Long - Winter)' ),
                    'description'  => __( 'Site logo (Long - Winter).' ),
                ]
            );

            register_setting(
                'general',
                'wa_site_logo_tall_spring',
                [
                    'show_in_rest' => [
                        'name' => 'wa_site_logo_tall_spring',
                    ],
                    'type'         => 'integer',
                    'label'        => __( 'Logo (Tall - Spring)' ),
                    'description'  => __( 'Site logo (Tall - Spring).' ),
                ]
            );
            register_setting(
                'general',
                'wa_site_logo_long_spring',
                [
                    'show_in_rest' => [
                        'name' => 'wa_site_logo_long_spring',
                    ],
                    'type'         => 'integer',
                    'label'        => __( 'Logo (Long - Spring)' ),
                    'description'  => __( 'Site logo (Long - Spring).' ),
                ]
            );

            register_setting(
                'general',
                'wa_site_logo_tall_summer',
                [
                    'show_in_rest' => [
                        'name' => 'wa_site_logo_tall_summer',
                    ],
                    'type'         => 'integer',
                    'label'        => __( 'Logo (Tall - Summer)' ),
                    'description'  => __( 'Site logo (Tall - Summer).' ),
                ]
            );
            register_setting(
                'general',
                'wa_site_logo_long_summer',
                [
                    'show_in_rest' => [
                        'name' => 'wa_site_logo_long_summer',
                    ],
                    'type'         => 'integer',
                    'label'        => __( 'Logo (Long - Summer)' ),
                    'description'  => __( 'Site logo (Long - Summer).' ),
                ]
            );

            register_setting(
                'general',
                'wa_site_logo_tall_fall',
                [
                    'show_in_rest' => [
                        'name' => 'wa_site_logo_tall_fall',
                    ],
                    'type'         => 'integer',
                    'label'        => __( 'Logo (Tall - Fall)' ),
                    'description'  => __( 'Site logo (Tall - Fall).' ),
                ]
            );
            register_setting(
                'general',
                'wa_site_logo_long_fall',
                [
                    'show_in_rest' => [
                        'name' => 'wa_site_logo_long_fall',
                    ],
                    'type'         => 'integer',
                    'label'        => __( 'Logo (Long - Fall)' ),
                    'description'  => __( 'Site logo (Long - Fall).' ),
                ]
            );
        }

        public function reset_logos_option( $season, $version )
        {
            $option_key = 'wa_site_logo_' . $version . '_' . $season;
            $option     = get_option( $option_key );

            if (  ! $option ) {
                $filename = $season . '-' . $version . '.svg';
                $id       = \WA\Helpers\get_attachment_id( $filename );

                if ( $id ) {
                    update_option( $option_key, $id );
                }
            }
        }

        public function reset_theme_settings()
        {
            // wa... settings disappear on theme change, set defaults if nothing set and files exist
            $option_key = 'wa_button_booking_link';
            $option     = get_option( $option_key );

            if (  ! $option ) {
                update_option( $option_key, 'https://scouts.doubleknot.com/facilitysearch/4568' );
            }

            $seasons = ['winter', 'spring', 'summer', 'fall'];
            foreach ( $seasons as $season ) {
                $this->reset_logos_option( $season, 'tall' );
                $this->reset_logos_option( $season, 'long' );
            }
        }
    }

    new Gutenberg();
}
