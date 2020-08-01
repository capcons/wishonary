<?php

defined('ABSPATH') || exit;

/**
 * Defined the WPCF main file
 */
define('WPCF_2CHECKOUT_FILE', __FILE__);
define('WPCF_2CHECKOUT_BASE_NAME', plugin_basename( WPCF_2CHECKOUT_FILE ) );

/**
 * Showing config for addons central lists
 */
add_filter('wpcf_addons_lists_config', 'wpcf_2checkout_config');
function wpcf_2checkout_config( $config ) {
	$basicConfig = array(
		'name'          => __( '2Checkout', 'wp-crowdfunding-pro' ),
		'description'   => __( 'Offer 2Checkout.com payment gateway option for all transactions.', 'wp-crowdfunding-pro' ),
		'path'         	=> plugin_dir_path( WPCF_2CHECKOUT_FILE ),
		'url'           => plugin_dir_url( WPCF_2CHECKOUT_FILE ),
		'basename'      => WPCF_2CHECKOUT_BASE_NAME
	);
	$config[ WPCF_2CHECKOUT_BASE_NAME ] = $basicConfig;
	return $config;
}

$addonConfig = wpcf_function()->get_addon_config( WPCF_2CHECKOUT_BASE_NAME );
$isEnable = (bool) wpcf_function()->avalue_dot( 'is_enable', $addonConfig );
if ( $isEnable ) {
	include_once 'classes/init.php';
}