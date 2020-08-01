<?php

defined('ABSPATH') || exit;

/**
 * Defined the main file
 */
define('WPCF_WALLET_FILE', __FILE__);
define('WPCF_WALLET_DIR_PATH', plugin_dir_path( WPCF_WALLET_FILE ) );
define('WPCF_WALLET_BASE_NAME', plugin_basename( WPCF_WALLET_FILE ) );

/**
 * Showing config for addons central lists
 */
add_filter('wpcf_addons_lists_config', 'wpcf_wallet_config');
function wpcf_wallet_config( $config ) {
	$basicConfig = array(
		'name'          => __( 'Wallet', 'wp-crowdfunding-pro' ),
		'description'   => __( 'Support native payment system for all donations using the native wallet addon.', 'wp-crowdfunding-pro' ),
		'path'			=> WPCF_WALLET_DIR_PATH,
		'url'			=> plugin_dir_url( WPCF_WALLET_FILE ),
		'basename'		=> WPCF_WALLET_BASE_NAME
	);
	$config[ WPCF_WALLET_BASE_NAME ] = $basicConfig;
	return $config;
}

$addonConfig = wpcf_function()->get_addon_config( WPCF_WALLET_BASE_NAME );
$isEnable = (bool) wpcf_function()->avalue_dot( 'is_enable', $addonConfig );
if ( $isEnable ) {
	include_once 'classes/init.php';
}