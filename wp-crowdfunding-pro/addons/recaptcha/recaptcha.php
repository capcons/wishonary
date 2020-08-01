<?php

defined('ABSPATH') || exit;

/**
 * Defined the WPCF main file
 */
define('WPCF_RECAPTCHA_FILE', __FILE__);
define('WPCF_RECAPTCHA_VERSION', '1.0');
define('WPCF_RECAPTCHA_DIR_PATH', plugin_dir_path( WPCF_RECAPTCHA_FILE ) );
define('WPCF_RECAPTCHA_BASE_NAME', plugin_basename( WPCF_RECAPTCHA_FILE ) );

/**
 * Showing config for addons central lists
 */
add_filter('wpcf_addons_lists_config', 'wpcf_recaptcha_config');
function wpcf_recaptcha_config( $config ) {
	$basicConfig = array(
		'name'          => __( 'reCAPTCHA', 'wp-crowdfunding-pro' ),
		'description'   => __( 'Secure your site from bots and other identity threats with reCAPTCHA.', 'wp-crowdfunding-pro' ),
		'path'         	=> WPCF_RECAPTCHA_DIR_PATH,
		'url'          	=> plugin_dir_url( WPCF_RECAPTCHA_FILE ),
		'basename'      => WPCF_RECAPTCHA_BASE_NAME
	);
	$config[ WPCF_RECAPTCHA_BASE_NAME ] = $basicConfig;
	return $config;
}

$addonConfig = wpcf_function()->get_addon_config( WPCF_RECAPTCHA_BASE_NAME );
$isEnable = (bool) wpcf_function()->avalue_dot( 'is_enable', $addonConfig );
if ( $isEnable ) {
	include_once 'classes/init.php';
}