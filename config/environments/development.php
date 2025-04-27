<?php

/**
 * Configuration overrides for WP_ENV === 'development'
 */

use function Env\env;
use Roots\WPConfig\Config;

Config::define( 'SAVEQUERIES', true );
Config::define( 'WP_DEBUG', false );
Config::define( 'WP_DEBUG_DISPLAY', true );
Config::define( 'WP_DEBUG_LOG', env( 'WP_DEBUG_LOG' ) ?? true );
Config::define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true );
Config::define( 'SCRIPT_DEBUG', true );
Config::define( 'DISALLOW_INDEXING', true );
Config::define( 'JETPACK_DEV_DEBUG', true );

ini_set( 'display_errors', '1' );

// Enable plugin and theme updates and installation from the admin
Config::define( 'DISALLOW_FILE_MODS', false );
