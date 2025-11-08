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
            add_action( 'wp_loaded', [$this, 'block_styles'], 20 );

            add_action( 'admin_init', [$this, 'reset_theme_settings'] );

            add_filter( 'block_type_metadata', [$this, 'filter_attributes'] );

            // Add page header option to pages
            add_action( 'add_meta_boxes', [$this, 'page_title_custom_page_meta_box'] );
            add_action( 'save_post', [$this, 'page_title_save_custom_page_meta_box'] );
            add_action( 'admin_init', [$this, 'page_title_set_custom_meta_for_all_pages'] );
        }

        public function addOptions()
        {
            add_option( 'watheme', ['site_logo_tall' => '790', 'site_logo_long' => false] );
        }

        public function block_styles()
        {
            if (  ! function_exists( 'register_block_style' ) ) {
                return;
            }

            // Get the instance of the block registry
            $block_registry = \WP_Block_Type_Registry::get_instance();

            // Get all registered block types
            $all_blocks = $block_registry->get_all_registered();

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
                    'label' => __( 'Masonry', 'watheme' ),
                ]
            );

            /*echo '<pre>';
        echo 'All Registered Block Styles:' . "\n\n";

        // Loop through each block
        foreach ( $all_blocks as $block_name => $block_type ) {
        // Check if the block has styles
        if (  ! empty( $block_type->styles ) ) {
        echo "Block: " . esc_html( $block_name ) . "\n";
        // Loop through each style of the current block
        foreach ( $block_type->styles as $style ) {
        echo "  - Name: " . esc_html( $style['name'] ) . ", Label: " . esc_html( $style['label'] ) . "\n";
        }
        echo "\n";
        }
        }
        echo '</pre>';*/
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

        // 1. Add the meta box to the 'page' post type
        public function page_title_custom_page_meta_box()
        {
            add_meta_box(
                'page_custom_options',                              // Unique ID for the meta box
                'Page Options',                                     // Title of the meta box
                [$this, 'page_title_display_custom_page_meta_box'], // Callback function to display the fields
                'page',                                             // Post type where the meta box will appear (e.g., 'page', 'post')
                'side',                                             // Context (e.g., 'normal', 'side', 'advanced')
                'high'                                              // Priority ('high', 'core', 'default', 'low')
            );
        }

        // 2. Display the form fields inside the meta box
        public function page_title_display_custom_page_meta_box( $post )
        {
            // Use a nonce for security
            wp_nonce_field( basename( __FILE__ ), 'custom_page_nonce' );

            // Get the current value of the custom field
            $show_title = get_post_meta( $post->ID, 'show_page_title', true );

            // Check if the page is a new post (no ID yet) and set the checkbox to checked by default
            $checked_by_default = empty( $show_title ) && 'publish' !== $post->post_status && 'private' !== $post->post_status;

            $checked = $show_title || $checked_by_default ? ' checked="checked"' : '';

            // Output the HTML for the checkbox
            echo '<p>';
            echo '<label for="show_page_title">';
            echo '<input type="checkbox" name="show_page_title" id="show_page_title" value="1"' . $checked . '>';
            echo 'Show page title above content';
            echo '</label>';
            echo '</p>';
        }

        // 3. Save the custom field's value when the page is saved
        public function page_title_save_custom_page_meta_box( $post_id )
        {
            // Check if the nonce is valid
            if (  ! isset( $_POST['custom_page_nonce'] ) || ! wp_verify_nonce( $_POST['custom_page_nonce'], basename( __FILE__ ) ) ) {
                return;
            }

            // Check if the current user has permissions
            if (  ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }

            // Save or delete the custom field based on the checkbox's state
            if ( isset( $_POST['show_page_title'] ) ) {
                update_post_meta( $post_id, 'show_page_title', '1' );
            } else {
                delete_post_meta( $post_id, 'show_page_title' );
            }
        }

        public function page_title_set_custom_meta_for_all_pages()
        {
            // Define the meta key and value you want to set.
            $meta_key   = 'show_page_title';
            $meta_value = 'true';

            // We'll use a flag to make sure this script only runs once.
            // The 'flag' can be stored in the WordPress options table.
            $script_ran_flag = get_option( 'all_pages_meta_script_ran' );

            // If the flag is set, the script has already run, so we'll stop.
            if ( '1' === $script_ran_flag ) {
                return;
            }

            // Get all published pages.
            $args = [
                'post_type'      => 'page',
                'post_status'    => 'publish',
                'posts_per_page' => -1,    // Get all pages
                'fields'         => 'ids', // Only get post IDs for efficiency
            ];

            $page_ids = get_posts( $args );

            // Loop through each page ID and update the meta field.
            if (  ! empty( $page_ids ) ) {
                foreach ( $page_ids as $page_id ) {
                    // update_post_meta() will add the meta field if it doesn't exist,
                    // or update it if it does.
                    update_post_meta( $page_id, $meta_key, $meta_value );
                }

                // Set the flag so the script doesn't run again.
                update_option( 'all_pages_meta_script_ran', '1' );

                // Optional: Log a message to the debug log for confirmation.
                error_log( 'Successfully set meta value for all pages.' );
            }
        }

        public function register_blocks()
        {
            wp_register_block_metadata_collection(
                get_template_directory() . '/public/build/blocks',
                get_template_directory() . '/public/build/blocks/blocks-manifest.php'
            );

            register_block_type( get_template_directory() . '/public/build/blocks/custom/site-logo-multiple' );

            register_block_type( get_template_directory() . '/public/build/blocks/custom/page-title' );
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
                    'label'        => __( 'Booking Link', 'watheme' ),
                    'description'  => __( 'Booking Link', 'watheme' ),
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
                    'label'        => __( 'Logo (Tall - Winter)', 'watheme' ),
                    'description'  => __( 'Site logo (Tall - Winter).', 'watheme' ),
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
                    'label'        => __( 'Logo (Long - Winter)', 'watheme' ),
                    'description'  => __( 'Site logo (Long - Winter).', 'watheme' ),
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
                    'label'        => __( 'Logo (Tall - Spring)', 'watheme' ),
                    'description'  => __( 'Site logo (Tall - Spring).', 'watheme' ),
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
                    'label'        => __( 'Logo (Long - Spring)', 'watheme' ),
                    'description'  => __( 'Site logo (Long - Spring).', 'watheme' ),
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
                    'label'        => __( 'Logo (Tall - Summer)', 'watheme' ),
                    'description'  => __( 'Site logo (Tall - Summer).', 'watheme' ),
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
                    'label'        => __( 'Logo (Long - Summer)', 'watheme' ),
                    'description'  => __( 'Site logo (Long - Summer).', 'watheme' ),
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
                    'label'        => __( 'Logo (Tall - Fall)', 'watheme' ),
                    'description'  => __( 'Site logo (Tall - Fall).', 'watheme' ),
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
                    'label'        => __( 'Logo (Long - Fall)', 'watheme' ),
                    'description'  => __( 'Site logo (Long - Fall).', 'watheme' ),
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
