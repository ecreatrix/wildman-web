<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    public function season()
    {
        return \WA\Helpers\season();
    }

    public function siteLogo()
    {
        if ( has_custom_logo() ) {
            $file     = get_attached_file( get_theme_mod( 'custom_logo' ) );
            $validate = wp_check_filetype( basename( $file ) );

            if ( $validate && 'image/svg+xml' === $validate['type'] ) {
                return file_get_contents( $file );
            } else {
                return '<img src="' . wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] . '">';
            }

        } else {
            return $this->siteName();
        }
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo( 'name', 'display' );
    }

    public static function social_media()
    {
        $social_info = [
            'linkedin'  => [
                'name' => 'LinkedIn',
                'icon' => 'linkedin-square',
                'link' => get_theme_mod( 'wa_linkedin' ),
            ],
            'instagram' => [
                'name' => 'Instagram',
                'icon' => 'instagram',
                'link' => get_theme_mod( 'wa_instagram' ),
            ],
            'twitter'   => [
                'name' => 'Twitter',
                'icon' => 'twitter-square',
                'link' => get_theme_mod( 'wa_twitter' ),
            ],
            'facebook'  => [
                'name' => 'Facebook',
                'icon' => 'facebook-square',
                'link' => get_theme_mod( 'wa_facebook' ),
            ],
            'discord'   => [
                'name' => 'Discord',
                'icon' => 'discord',
                'link' => get_theme_mod( 'wa_discord' ),
            ],
            'youtube'   => [
                'name' => 'YouTube',
                'icon' => 'youtube-square',
                'link' => get_theme_mod( 'wa_youtube' ),
            ],
        ];

        return $social_info;
    }

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'season'      => $this->season(),
            'siteLogo'    => $this->siteLogo(),
            'siteName'    => $this->siteName(),
            'socialLinks' => $this->social_media(),
        ];
    }
}
