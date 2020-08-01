<?php

defined('ABSPATH') || exit;

/**
 * Defined the WPCF main file
 */
define('WPCF_REPORTS_FILE', __FILE__);
define('WPCF_REPORTS_DIR_PATH', plugin_dir_path( WPCF_REPORTS_FILE ) );
define('WPCF_REPORTS_BASE_NAME', plugin_basename( WPCF_REPORTS_FILE ) );

/**
 * Showing config for addons central lists
 */
add_filter('wpcf_addons_lists_config', 'wpcf_reports_config');
function wpcf_reports_config( $config ) {
	$basicConfig = array(
		'name'          => __( 'Reports', 'wp-crowdfunding-pro' ),
		'description'   => __( 'Get detailed analytics & stats using advanced filters with powerful reports.', 'wp-crowdfunding-pro' ),
		'path'			=> WPCF_REPORTS_DIR_PATH,
		'url'			=> plugin_dir_url( WPCF_REPORTS_FILE ),
		'basename'		=> WPCF_REPORTS_BASE_NAME
	);
	$config[ WPCF_REPORTS_BASE_NAME ] = $basicConfig;
	return $config;
}

$addonConfig = wpcf_function()->get_addon_config( WPCF_REPORTS_BASE_NAME );
$isEnable = (bool) wpcf_function()->avalue_dot( 'is_enable', $addonConfig );
if ( $isEnable ) {
	include_once 'classes/init.php';
}