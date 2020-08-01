<?php

defined('ABSPATH') || exit;

/**
 * Defined the WPCF main file
 */
define('WPCF_EMAIL_FILE', __FILE__);
define('WPCF_EMAIL_DIR_PATH', plugin_dir_path( WPCF_EMAIL_FILE ) );
define('WPCF_EMAIL_BASE_NAME', plugin_basename( WPCF_EMAIL_FILE ) );

/**
 * Showing config for addons central lists
 */
add_filter('wpcf_addons_lists_config', 'wpcf_email_config');
function wpcf_email_config( $config ) {
	$basicConfig = array(
		'name'          => __( 'Email', 'wp-crowdfunding-pro' ),
		'description'   => __( 'Connect with users through customizable email templates using Email addon.', 'wp-crowdfunding-pro' ),
		'path'         	=> WPCF_EMAIL_DIR_PATH,
		'url'           => plugin_dir_url( WPCF_EMAIL_FILE ),
		'basename'     	=> WPCF_EMAIL_BASE_NAME
	);
	$config[ WPCF_EMAIL_BASE_NAME ] = $basicConfig;
	return $config;
}

$addonConfig = wpcf_function()->get_addon_config( WPCF_EMAIL_BASE_NAME );
$isEnable = (bool) wpcf_function()->avalue_dot( 'is_enable', $addonConfig );
if ( $isEnable ) {
	include_once 'classes/init.php';
}