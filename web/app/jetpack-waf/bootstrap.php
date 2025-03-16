<?php
define( 'DISABLE_JETPACK_WAF', false );
if ( defined( 'DISABLE_JETPACK_WAF' ) && DISABLE_JETPACK_WAF ) return;
define( 'JETPACK_WAF_MODE', 'silent' );
define( 'JETPACK_WAF_SHARE_DATA', false );
define( 'JETPACK_WAF_SHARE_DEBUG_DATA', false );
define( 'JETPACK_WAF_DIR', '/Volumes/Files/_Business/Web/withalyx/mine/wildman/web/app/jetpack-waf' );
define( 'JETPACK_WAF_WPCONFIG', '/Volumes/Files/_Business/Web/withalyx/mine/wildman/web/app/../wp-config.php' );
define( 'JETPACK_WAF_ENTRYPOINT', 'rules/rules.php' );
require_once '/Volumes/Files/_Business/Web/withalyx/mine/wildman/web/app/plugins/jetpack/vendor/autoload.php';
Automattic\Jetpack\Waf\Waf_Runner::initialize();
