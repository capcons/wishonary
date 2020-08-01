<?php
/*
 * Plugin Name:       WP Crowdfunding Pro
 * Plugin URI:        https://www.themeum.com/product/wp-crowdfunding-plugin/
 * Description:       WP crowdfunding (Enterprise) for collect fund and investment
 * Version:           11.1.3
 * Author:            Themeum
 * Author URI:        https://themeum.com
 * Text Domain:       wp-crowdfunding
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

defined('ABSPATH') || exit;

// Defined
define('WPCF_PRO_FILE', __FILE__);
define('WPCF_PRO_VERSION', '11.1.3');
define('WPCF_PRO_DIR_URL', plugin_dir_url( WPCF_PRO_FILE ));
define('WPCF_FREE_BASENAME', 'wp-crowdfunding/wp-crowdfunding.php');

add_action('init', 'wpcf_pro_language_load');
function wpcf_pro_language_load(){
    load_plugin_textdomain('wp-crowdfunding-pro', false, basename(dirname( WPCF_PRO_FILE )).'/languages/');
}

include_once 'classes/Init.php';
include_once ABSPATH.'wp-admin/includes/plugin.php';

if( file_exists(WP_PLUGIN_DIR.'/'.WPCF_FREE_BASENAME) && is_plugin_active(WPCF_FREE_BASENAME) ) {
	new \WPCF_PRO\Init();
} else {
	include_once 'classes/Installer.php';
	new \WPCF_PRO\Installer();
}