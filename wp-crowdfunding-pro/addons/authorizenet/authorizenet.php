<?php

defined('ABSPATH') || exit;

/**
 * Defined the WPCF main file
 */
define('WPCF_AUTHORIZENET_FILE', __FILE__);
define('WPCF_AUTHORIZENET_DIR_PATH', plugin_dir_path( WPCF_AUTHORIZENET_FILE ) );
define('WPCF_AUTHORIZENET_BASE_NAME', plugin_basename( WPCF_AUTHORIZENET_FILE ) );

/**
 * Showing config for addons central lists
 */
add_filter('wpcf_addons_lists_config', 'wpcf_authorizenet_config');
function wpcf_authorizenet_config( $config ) {
	$basicConfig = array(
		'name'          => __( 'Authorize.Net', 'wp-crowdfunding-pro' ),
		'description'   => __( 'Provide Authorize.net payment gateway option for users.', 'wp-crowdfunding-pro' ),
		'path'          => WPCF_AUTHORIZENET_DIR_PATH,
		'url'           => plugin_dir_url( WPCF_AUTHORIZENET_FILE ),
		'basename'      => WPCF_AUTHORIZENET_BASE_NAME
	);
	$config[ WPCF_AUTHORIZENET_BASE_NAME ] = $basicConfig;
	return $config;
}

$addonConfig = wpcf_function()->get_addon_config( WPCF_AUTHORIZENET_BASE_NAME );
$isEnable = (bool) wpcf_function()->avalue_dot( 'is_enable', $addonConfig );
if ( $isEnable ) {
	include_once 'classes/init.php';
}