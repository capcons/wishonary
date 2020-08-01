<?php

defined('ABSPATH') || exit;

/**
 * Defined the main file
 */
define('WPCF_STRIPE_CONNECT_FILE', __FILE__);
define('WPCF_STRIPE_CONNECT_BASE_NAME', plugin_basename( WPCF_STRIPE_CONNECT_FILE ) );


if ( !function_exists( 'is_plugin_active_for_network' ) ) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

//Check is WooCommerce is Active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) {
    
    /**
     * Showing config for addons central lists
     */
    add_filter('wpcf_addons_lists_config', 'wpcf_stripe_connect_config');
    function wpcf_stripe_connect_config( $config ) {
        $basicConfig = array(
            'name'          => __( 'Stripe connect', 'wp-crowdfunding-pro' ),
            'description'   => __( 'Enable Stripe Connect payment gateways to boost donations of your campaigns.', 'wp-crowdfunding-pro' ),
            'path'          => plugin_dir_path( WPCF_STRIPE_CONNECT_FILE ),
            'url'           => plugin_dir_url( WPCF_STRIPE_CONNECT_FILE ),
            'basename'      => WPCF_STRIPE_CONNECT_BASE_NAME
        );
        $config[ WPCF_STRIPE_CONNECT_BASE_NAME ] = $basicConfig;
        return $config;
    }

    $addonConfig = wpcf_function()->get_addon_config( WPCF_STRIPE_CONNECT_BASE_NAME );
    $isEnable = (bool) wpcf_function()->avalue_dot( 'is_enable', $addonConfig );
    if ( $isEnable ) {
        include_once 'classes/wpcf-stripe-connect.php';
        include_once 'classes/init.php';
    }
}
