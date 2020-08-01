<?php
/*
* Plugin Name: The Plus Addons for Elementor Page Builder
* Plugin URI: https://elementor.theplusaddons.com/
* Description: Ultimate collection of Addons for Elementor Page Builder and proudly developed by POSIMYTH Themes Team.
* Version: 3.3.3
* Author: POSIMYTH Themes
* Author URI: http://posimyththemes.com
* Text Domain: theplus
* Elementor tested up to: 2.9.8
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
defined( 'THEPLUS_VERSION' ) or define( 'THEPLUS_VERSION', '3.3.3' );
define( 'THEPLUS_FILE__', __FILE__ );

define( 'THEPLUS_PATH', plugin_dir_path( __FILE__ ) );
define( 'THEPLUS_PBNAME', plugin_basename(__FILE__) );
define( 'THEPLUS_PNAME', basename( dirname(__FILE__)) );
define( 'THEPLUS_URL', plugins_url( '/', __FILE__ ) );
define( 'THEPLUS_ASSETS_URL', THEPLUS_URL . 'assets/' );
define('THEPLUS_ASSET_PATH', wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . 'theplus-addons');
define('THEPLUS_ASSET_URL', wp_upload_dir()['baseurl'] . '/theplus-addons');
define( 'THEPLUS_INCLUDES_URL', THEPLUS_PATH . 'includes/' );
define( 'THEPLUS_TYPE', 'store' );



/* theplus language plugins loaded */
function theplus_pluginsLoaded() {
	load_plugin_textdomain( 'theplus', false, basename( dirname( __FILE__ ) ) . '/lang' ); 
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'theplus_elementor_load_notice' );
		return;
	}
	// Elementor widget loader
	if(THEPLUS_TYPE=='store' && is_admin()){
		add_action( 'admin_init', 'theplus_plugin_updater', 0 );
	}
    require( THEPLUS_PATH . 'widgets_loader.php' );
}
add_action( 'plugins_loaded', 'theplus_pluginsLoaded' );
update_option( 'theplus_purchase_code', 'B5E0B5F8DD8689E6ACA49DD6E6E1A930' );
/* theplus elementor load notice */
function theplus_elementor_load_notice() {	
	$plugin = 'elementor/elementor.php';	
	if ( theplus_elementor_activated() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }
		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
		$admin_notice = '<p>' . esc_html__( 'Something Missing : It\'s Elementor. You already installed that, Please activate Elementor, Unless The Plus Addons will not be working.', 'theplus' ) . '</p>';
		$admin_notice .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor Now', 'theplus' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) { return; }
		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
		$admin_notice = '<p>' . esc_html__( 'Something Missing : It\'s Elementor. Please install Elementor, Unless The Plus Addons will not be working.', 'theplus' ) . '</p>';
		$admin_notice .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor Now', 'theplus' ) ) . '</p>';
	}
	echo '<div class="notice notice-error is-dismissible">'.$admin_notice.'</div>';
}

/**
	* Plugin Updater	
*/
function theplus_plugin_updater() {
	
    $purchase_key = get_option( 'theplus_purchase_code' );
	$verify_api=theplus_check_api_status();
    // setup the updater
	if(!empty($purchase_key['tp_api_key']) && !empty($verify_api) && $verify_api==1){
		$edd_updater = new Theplus_SL_Plugin_Updater( TP_PLUS_SL_STORE_URL, __FILE__, array(
			'version' => THEPLUS_VERSION,
			'license' => $purchase_key['tp_api_key'],		
			'item_id'       => TP_PLUS_SL_ITEM_ID,
			'author' => 'POSIMYTH Themes',
			'url'           => home_url(),
			'beta' => false,
		));
	}
}

function theplus_activated_plugin( $plugin ) { 
	if( $plugin == plugin_basename( __FILE__ ) ) {
		$activate_plus_label=get_option( 'theplus_white_label' );			
		if ( !empty($activate_plus_label["tp_hidden_label"]) && $activate_plus_label["tp_hidden_label"] === 'on' ) {
			$activate_plus_label["tp_hidden_label"] = '';
			update_option('theplus_white_label', $activate_plus_label);
		}			
	}
}
add_action( 'activated_plugin', 'theplus_activated_plugin',10 );

/**
	* Elementor activated or not
*/
if ( ! function_exists( 'theplus_elementor_activated' ) ) {
	
	function theplus_elementor_activated() {
		$file_path = 'elementor/elementor.php';
		$installed_plugins = get_plugins();
		
		return isset( $installed_plugins[ $file_path ] );
	}
}