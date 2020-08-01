<?php
/**
Plugin Name: WP Plugin Manager Pro
Plugin URI: https://hasthemes.com/plugins/
Description: Deactivate plugins per page
Version: 1.0.0
Author: codecarnival
Author URI: https://hasthemes.com/
Text Domain: htpmpro
*/

defined( 'ABSPATH' ) or die();

/**
 * Define path
 */
define( 'HTPMPRO_ROOT_URL', plugins_url('', __FILE__) );
define( 'HTPMPRO_PL_ROOT', __FILE__ );
define( 'HTPMPRO_ROOT_DIR', dirname( __FILE__ ) );
define( 'HTPMPRO_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );

/**
 * Include files
 */
require_once HTPMPRO_ROOT_DIR . '/includes/plugin-options-page.php';
require_once HTPMPRO_ROOT_DIR . '/includes/licence/WPPluginManagerPro.php';

/**
 * Load text domain
 */
function htpmpro_load_textdomain() {
    load_plugin_textdomain( 'htpmpro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'htpmpro_load_textdomain' );


/**
 * Plugin activation hook
 */
register_activation_hook( __FILE__, 'htpmpro_plugin_activation' );
function htpmpro_plugin_activation(){
	if(empty(get_option('htpmpro_status')) || get_option('htpmpro_status')){
		update_option('htpmpro_status', 'active');
    }
    else {
      	add_option('htpmpro_status', 'active');
    }
}

/**
 * Plugin deactivation hook
 */
register_deactivation_hook( __FILE__, 'htpmpro_plugin_deactivation' );
function htpmpro_plugin_deactivation(){
	if(empty(get_option('htpmpro_status')) || get_option('htpmpro_status')){
		update_option('htpmpro_status', 'deactive');
    }
    else {
      	add_option('htpmpro_status', 'deactive');
    }
}

/**
 * Enqueue admin scripts and styles.
 */
function htpmpro_admin_scripts( $hook_suffix ) {
	if( $hook_suffix ==  'plugin-manager_page_htpmpro-options' ){
		wp_enqueue_style( 'select2', HTPMPRO_ROOT_URL . '/assets/css/select2.min.css' );
		wp_enqueue_style( 'htpmpro-admin', HTPMPRO_ROOT_URL . '/assets/css/admin-style.css' );
		wp_enqueue_style( 'jquery-ui', HTPMPRO_ROOT_URL . '/assets/css/jquery-ui.css' );

		// load jquery ui files
		wp_enqueue_script( 'jquery-ui-accordion');
		wp_enqueue_script( 'select2', HTPMPRO_ROOT_URL . '/assets/js/select2.min.js', array('jquery'), '', true );
		wp_enqueue_script( 'htpmpro-admin', HTPMPRO_ROOT_URL . '/assets/js/admin.js', array('jquery'), '', true );
	}
}
add_action( 'admin_enqueue_scripts', 'htpmpro_admin_scripts' );

/**
 * Add mu file
 */
function htpmpro_create_mu_file(){
    // create mu file
    if(!function_exists('get_mu_plugins')){
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

    $mu_plugin_file_source_path = HTPMPRO_ROOT_DIR . '/mu-plugin/htpm-mu-plugin.php';
    $mu_plugins = get_mu_plugins();

    $mu_plugin_file = 'htpm-mu-plugin.php';
    if ( defined( 'WPMU_PLUGIN_DIR' ) ) {
        $mu_plugins_path = WPMU_PLUGIN_DIR;
    } else {
        $mu_plugins_path = WP_CONTENT_DIR . '/' . 'mu-plugins';
    }

    $mu_plugin_file_path = $mu_plugins_path . '/htpm-mu-plugin.php';

    // add mu file 
    if ( file_exists( $mu_plugins_path ) && !array_key_exists( $mu_plugin_file, $mu_plugins ) ){
        copy( $mu_plugin_file_source_path, $mu_plugin_file_path );
    } else {
        // create mu-plugins folder
        if ( !file_exists($mu_plugins_path) ) {
            $create_mu_folder = mkdir( $mu_plugins_path, 0755, true );
            if( $create_mu_folder ){
                copy( $mu_plugin_file_source_path, $mu_plugin_file_path );
            }
        }
    }
}
add_action('init', 'htpmpro_create_mu_file');