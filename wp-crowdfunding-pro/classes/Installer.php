<?php
namespace WPCF_PRO;
 
defined('ABSPATH') || exit;
 
class Installer {
 
    public function __construct() {
        add_action('admin_init',                                array($this, 'check_crowdfunding_free_installed'));
        add_action('admin_enqueue_scripts',                     array($this, 'enqueue_installer_scripts'));
        add_action('wp_ajax_install_crowdfunding_plugin',       array($this, 'install_crowdfunding_plugin'));
        add_action('admin_action_activate_crowdfunding_free',   array($this, 'activate_crowdfunding_free'));
    }

    public function enqueue_installer_scripts() {
        wp_enqueue_style( 'plugin-license-handler', WPCF_PRO_DIR_URL.'assets/css/installer.css', WPCF_PRO_VERSION, true);
        wp_enqueue_script( 'wpcf-pro-scripts', WPCF_PRO_DIR_URL.'assets/js/installer.js', array('jquery'), WPCF_PRO_VERSION, true );
	}
 
    public function check_crowdfunding_free_installed() {
        $crowdfunding_file = WP_PLUGIN_DIR.'/'.WPCF_FREE_BASENAME;
        if ( file_exists($crowdfunding_file) && !is_plugin_active(WPCF_FREE_BASENAME) ) {
            add_action( 'admin_notices', array($this, 'free_plugin_installed_but_inactive_notice') );
        } elseif ( !file_exists($crowdfunding_file) ) {
            add_action( 'admin_notices', array($this, 'free_plugin_not_installed') );
        }
    }
 
    public function free_plugin_installed_but_inactive_notice() { ?>
        <div class="notice notice-error wpcf-install-notice">
            <div class="wpcf-install-notice-inner">
                <div class="wpcf-install-notice-icon">
                    <img src="<?php echo WPCF_PRO_DIR_URL.'assets/images/logo-crowdfunding.png'; ?>" alt="WP Crowdfunding Logo">
                </div>
                <div class="wpcf-install-notice-content">
                    <h2><?php _e('Thanks for using WP Crowdfunding Pro','wp-crowdfunding-pro'); ?></h2>
                    <p><?php echo sprintf( __( 'You must have <a href="%s" target="_blank">WP Carowdfunding</a> Free version installed and activated on this website in order to use WP Carowdfunding Pro.', 'wp-crowdfunding-pro' ), esc_url( 'https://wordpress.org/plugins/wp-crowdfunding/' ) ); ?></p>
                    <a href="https://www.themeum.com/docs/wp-crowdfunding-introduction/" target="_blank"><?php _e('Learn more about WP Carowdfunding','wp-crowdfunding-pro'); ?></a>
                </div>
                <div class="wpcf-install-notice-button">
                    <a  class="button button-primary" href="<?php echo add_query_arg(array('action' => 'activate_crowdfunding_free'), admin_url()); ?>"><?php _e('Activate WP Crowdfunding','wp-crowdfunding-pro'); ?></a>
                </div>
            </div>
        </div>
        <?php
    }
 
    public function free_plugin_not_installed()  {
        ?>
        <div class="notice notice-error wpcf-install-notice">
            <div class="wpcf-install-notice-inner">
                <div class="wpcf-install-notice-icon">
                    <img src="<?php echo WPCF_PRO_DIR_URL.'assets/images/logo-crowdfunding.png'; ?>" alt="WP Crowdfunding Logo">
                </div>
                <div class="wpcf-install-notice-content">
                    <h2><?php _e('Thanks for using WP Crowdfunding Pro','wp-crowdfunding-pro'); ?></h2>
                    <p><?php sprintf( __( 'You must have <a href="%s" target="_blank">WP Carowdfunding</a> Free version installed and activated on this website in order to use WP Crowdfunding Pro.', 'wp-crowdfunding-pro' ), esc_url( 'https://wordpress.org/plugins/wp-crowdfunding/' ) ); ?></p>
                    <a href="https://www.themeum.com/docs/wp-crowdfunding-introduction/" target="_blank"><?php _e('Learn more about WP Crowdfunding','wp-crowdfunding-pro'); ?></a>
                </div>
                <div class="wpcf-install-notice-button">
                    <a class="install-crowdfunding-button button button-primary" data-slug="wp-crowdfunding" href="<?php echo add_query_arg(array('action' => 'install_crowdfunding_free'), admin_url()); ?>"><?php _e('Install WP Crowdfunding','wp-crowdfunding-pro'); ?></a>
                </div>
            </div>
            <div id="crowdfunding_install_msg"></div>
        </div>
        <?php
    }
 
    public function activate_crowdfunding_free(){
        activate_plugin( WPCF_FREE_BASENAME );
        wp_redirect( admin_url('plugins.php') );
        exit;
    }
 
 
    public function install_crowdfunding_plugin(){
        include(ABSPATH . 'wp-admin/includes/plugin-install.php');
        include(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
 
        if ( ! class_exists('Plugin_Upgrader')){
            include(ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php');
        }
        if ( ! class_exists('Plugin_Installer_Skin')) {
            include( ABSPATH . 'wp-admin/includes/class-plugin-installer-skin.php' );
        }
 
        $plugin = 'wp-crowdfunding';
 
        $api = plugins_api( 'plugin_information', array(
            'slug' => $plugin,
            'fields' => array(
                'short_description' => false,
                'sections' => false,
                'requires' => false,
                'rating' => false,
                'ratings' => false,
                'downloaded' => false,
                'last_updated' => false,
                'added' => false,
                'tags' => false,
                'compatibility' => false,
                'homepage' => false,
                'donate_link' => false,
            ),
        ) );
 
        if ( is_wp_error( $api ) ) {
            wp_die( $api );
        }
 
        $title = sprintf( __('Installing Plugin: %s'), $api->name . ' ' . $api->version );
        $nonce = 'install-plugin_' . $plugin;
        $url = 'update.php?action=install-plugin&plugin=' . urlencode( $plugin );
 
        $upgrader = new \Plugin_Upgrader( new \Plugin_Installer_Skin( compact('title', 'url', 'nonce', 'plugin', 'api') ) );
        $upgrader->install($api->download_link);
        die();
    }
 
}