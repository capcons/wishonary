<?php
defined('ABSPATH') || exit;

if ( !class_exists('WPCF_Recaptcha') ) {
    
    class WPCF_Recaptcha {
        /**
         * @var null
         *
         * Instance of this class
         */
        protected static $_instance = null;

        /**
         * @return null|WPCF
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct(){
            add_action('admin_init',                                        array($this, 'recaptcha_save_settings') );
            add_action('wp_enqueue_scripts',                                array($this, 'recaptcha_enqueue_frontend_script') ); // Add recaptcha js in footer
            add_filter('wpcf_user_registration_fields',                     array($this, 'recaptcha_add_user_registration_form')); // Hook to add recaptcha field with user registration form
            add_filter('wpcf_before_closing_crowdfunding_campaign_form',    array($this, 'recaptcha_add_campaign_form'));
            add_filter('wpcf_settings_panel_tabs',                          array($this, 'add_recaptcha_tab'));
            add_action('wpcf_before_user_registration_action',              array($this, 'before_user_registration_action'));
            add_action('wpcf_before_campaign_submit_action',                array($this, 'before_user_campaign_submit_action'));
            add_shortcode('wpcf_recaptcha',                                 array($this, 'recaptcha_shortcode_generator')); // Short code for HTML section google reCAPTCHA
            register_activation_hook(WPCF_RECAPTCHA_FILE,                   array($this, 'initial_plugin_setup'));
        }

        /**
         * Some task during plugin activate
         */
        public static function initial_plugin_setup(){
            //Check is plugin used before or not
            if (get_option('wpneo_recaptcha_is_used')){ return false; }

            update_option( 'wpneo_recaptcha_is_used', WPCF_RECAPTCHA_VERSION );
            update_option( 'wpneo_enable_recaptcha', 'false');
            update_option( 'wpneo_enable_recaptcha_in_user_registration', 'false');
            update_option( 'wpneo_enable_recaptcha_campaign_submit_page', 'false');
        }

        public function recaptcha_shortcode_generator(){
            $wpcf_recaptcha_site_key = get_option('wpneo_recaptcha_site_key');
            $html = '<div class="g-recaptcha" data-sitekey="'.$wpcf_recaptcha_site_key.'"></div>';
            return $html;
        }

        public function recaptcha_add_user_registration_form($registration_fields){
            if ( get_option('wpneo_enable_recaptcha_in_user_registration' ) == 'true') {
                $registration_fields[] =  array(
                                                'type' => 'shortcode',
                                                'shortcode' => '[wpcf_recaptcha]',
                                            );
            }
            return $registration_fields;
        }

        public function recaptcha_add_campaign_form() {
            $html = '';
            if ( get_option('wpneo_enable_recaptcha_campaign_submit_page') == 'true' ) {
                $html .= '<div class="text-right">';
                $html .= do_shortcode('[wpcf_recaptcha]');
                $html .= '</div>';
            }
            return $html;
        }

        public function recaptcha_enqueue_frontend_script() {
            if( (get_option('wpneo_enable_recaptcha_campaign_submit_page') == 'true') || (get_option('wpneo_enable_recaptcha_in_user_registration') == 'true') ) {
                wp_enqueue_script('wpcf-recaptcha-js', 'https://www.google.com/recaptcha/api.js', null, WPCF_PRO_VERSION, true);
            }
        }

        public function add_recaptcha_tab($tabs){
            $tabs['recaptcha'] = array(
                'tab_name' => __('reCAPTCHA','wp-crowdfunding-pro'),
                'load_form_file' => WPCF_RECAPTCHA_DIR_PATH.'pages/tab-recaptcha.php'
            );
            return $tabs;
        }

        /**
         * All settings will be save in this method
         */
        public function recaptcha_save_settings() {
            if (isset($_POST['wpneo_admin_settings_submit_btn']) && isset($_POST['wpneo_recaptcha_activation']) && wp_verify_nonce( $_POST['wpneo_settings_page_nonce_field'], 'wpneo_settings_page_action' ) ){
                //Checkbox
                update_option( 'wpneo_enable_recaptcha_in_user_registration', 'false');
                update_option( 'wpneo_enable_recaptcha_campaign_submit_page', 'false');

                if (!empty($_POST['wpneo_enable_recaptcha_in_user_registration'])) {
                    update_option('wpneo_enable_recaptcha_in_user_registration', $_POST['wpneo_enable_recaptcha_in_user_registration']);
                }
                if (!empty($_POST['wpneo_enable_recaptcha_campaign_submit_page'])) {
                    update_option('wpneo_enable_recaptcha_campaign_submit_page', $_POST['wpneo_enable_recaptcha_campaign_submit_page']);
                }

                //Text Field
                if (!empty($_POST['wpneo_recaptcha_site_key'])) {
                    update_option('wpneo_recaptcha_site_key', $_POST['wpneo_recaptcha_site_key']);
                }
                if (!empty($_POST['wpneo_recaptcha_secret_key'])) {
                    update_option('wpneo_recaptcha_secret_key', $_POST['wpneo_recaptcha_secret_key']);
                }
            }
        }


        public function before_user_registration_action() {
            if (get_option('wpneo_enable_recaptcha_in_user_registration') == 'true') {
                $this->checking_recaptcha_api();
            }
        }

        function before_user_campaign_submit_action() {
            if (get_option('wpneo_enable_recaptcha_campaign_submit_page') == 'true') {
                $this->checking_recaptcha_api();
            }
        }

        public function checking_recaptcha_api() {
            $recaptcha = (object)array('success' => false);
            if ( isset($_POST['g-recaptcha-response'])) {
                $secret_key = get_option('wpneo_recaptcha_secret_key');
    
                $recaptcha_response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
                    'method' => 'POST',
                    'body' => array( 'secret' => $secret_key, 'response' => sanitize_text_field($_POST['g-recaptcha-response']) ),
                ));
                $recaptcha = json_decode($recaptcha_response['body']);
            }
            if (!$recaptcha->success) {
                die(json_encode(array('success'=> 0, 'message' => __('Error with reCAPTCHA, please check again', 'wp-crowdfunding-pro'))));
            }
        }
    }
}

WPCF_Recaptcha::instance();

