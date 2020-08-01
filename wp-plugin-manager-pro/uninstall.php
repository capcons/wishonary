<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit();
}

if ( defined( 'WPMU_PLUGIN_DIR' ) ) {
	$htpmpro_mu_plugins_path = WPMU_PLUGIN_DIR;
} else {
	$htpmpro_mu_plugins_path = WP_CONTENT_DIR . '/' . 'mu-plugins';
}
$htpmpro_mu_plugin_file_path = $htpmpro_mu_plugins_path . '/htpmp-mu-plugin.php';

/**
 * Remove mu file
 */
if( file_exists( $htpmpro_mu_plugin_file_path ) ){
	unlink( $htpmpro_mu_plugin_file_path );
}
