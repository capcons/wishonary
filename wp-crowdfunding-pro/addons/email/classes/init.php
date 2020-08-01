<?php
defined('ABSPATH') || exit;

if ( !class_exists('WPCF_Email') ) {

    class WPCF_Email {
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

        /**
         * WPCF_Email constructor.
         */
        public function __construct() {
			add_action( 'admin_init',                       array($this, 'save_email_settings') ); //save settings action
			add_filter( 'woocommerce_email_classes',        array($this, 'add_email_classes') ); //Email classes
            add_filter( 'woocommerce_locate_core_template', array($this, 'filter_woocommerce_template' ), 10, 3 );
			add_filter( 'woocommerce_locate_template',      array($this, 'filter_woocommerce_template' ), 10, 3 );
            add_filter( 'wpcf_settings_panel_tabs',         array($this, 'add_email_tab_to_wpcf_settings'));
            add_action( 'phpmailer_init',                   array($this, 'mailer_config'), 10, 3); //set smtp config
            add_action( 'pre_post_update',                  array($this, 'load_wc_email_class_instance'), 10);
		}
		
        // WC email class loader
        public function load_wc_email_class_instance(){
            WC()->mailer();
        }

        /**
         * Locate the templates and return the path of the file found
         *
         * @param string $path
         *
         * @return string
         * @since 1.0.0
         */
        public function wpcf_locate_template( $path ) {
            if ( function_exists( 'WC' ) ) {
                $woocommerce_base = WC()->template_path();
            } elseif ( defined( 'WC_TEMPLATE_PATH' ) ) {
                $woocommerce_base = WC_TEMPLATE_PATH;
            } else {
                $woocommerce_base = WC()->plugin_path() . '/templates/';
            }

            $template_woocommerce_path = $woocommerce_base . $path;
            $template_path             = '/' . $path;
            $plugin_path               = WPCF_EMAIL_DIR_PATH . 'templates/' . $path;

            $located = locate_template( array(
                $template_woocommerce_path, // Search in <theme>/woocommerce/
                $template_path,             // Search in <theme>/
                $plugin_path                // Search in <plugin>/templates/
            ) );

            if ( !$located && file_exists( $plugin_path ) ) {
                return apply_filters( 'wpcf_locate_template', $plugin_path, $path );
            }

            return apply_filters( 'wpcf_locate_template', $located, $path );
        }

	    /**
	     * @param $email_classes
	     *
	     * @return mixed
	     *
	     * Add email classes to WC Email Settings
	     *
	     * @since v.10.20
	     */
        public function add_email_classes($email_classes){
	        // include our custom email class
	        require_once( WPCF_EMAIL_DIR_PATH.'classes/wpcf-new-user.php' );
			require_once( WPCF_EMAIL_DIR_PATH.'classes/wpcf-new-backed.php' );
			require_once( WPCF_EMAIL_DIR_PATH.'classes/wpcf-campaign-submit.php' );
			require_once( WPCF_EMAIL_DIR_PATH.'classes/wpcf-campaign-accept.php' );
			require_once( WPCF_EMAIL_DIR_PATH.'classes/wpcf-campaign-update.php' );
	        require_once( WPCF_EMAIL_DIR_PATH.'classes/wpcf-target-reached.php' );
	        require_once( WPCF_EMAIL_DIR_PATH.'classes/wpcf-withdraw-request.php' );
	        
	        // add the email class to the list of email classes that WooCommerce loads
	        $email_classes['WPCF_New_User'] = new WPCF_New_User();
	        $email_classes['WPCF_New_Backed'] = new WPCF_New_Backed();
	        $email_classes['WPCF_Campaign_Submit'] = new WPCF_Campaign_Submit();
	        $email_classes['WPCF_Campaign_Accept'] = new WPCF_Campaign_Accept();
	        $email_classes['WPCF_Campaign_Update'] = new WPCF_Campaign_Update();
	        $email_classes['WPCF_Target_Reached'] = new WPCF_Target_Reached();
	        $email_classes['WPCF_Withdraw_Request'] = new WPCF_Withdraw_Request();

	        return $email_classes;
		}
		
        /**
         * Locate default templates of woocommerce in plugin, if exists
         *
         * @param $core_file     string
         * @param $template      string
         * @param $template_base string
         *
         * @return string
         * @since  1.0.0
         */
        public function filter_woocommerce_template( $core_file, $template, $template_base ) {
            $located = $this->wpcf_locate_template( $template );
            if( $located ) {
                return $located;
            } else{
                return $core_file;
            }
		}
		
		public function add_email_tab_to_wpcf_settings($tabs) {
            $tabs['email'] = array(
                'tab_name' => __('Email','wp-crowdfunding-pro'),
                'load_form_file' => WPCF_EMAIL_DIR_PATH.'pages/tab-email.php'
            );
            return $tabs;
		}
		
		 /**
         * All settings will be save in this method
         */
        public function save_email_settings() {
            if (isset($_POST['wpneo_admin_settings_submit_btn']) && isset($_POST['wpcf_email_activation']) && wp_verify_nonce( $_POST['wpneo_settings_page_nonce_field'], 'wpneo_settings_page_action' ) ) {
                //Checkbox
                $wpcf_enable_smtp = sanitize_text_field(wpcf_function()->post('wpcf_enable_smtp'));
                wpcf_function()->update_checkbox('wpcf_enable_smtp', $wpcf_enable_smtp);

                $wpcf_smtp_from_email = sanitize_text_field(wpcf_function()->post('wpcf_smtp_from_email'));
                wpcf_function()->update_text('wpcf_smtp_from_email', $wpcf_smtp_from_email);

                $wpcf_smtp_from_text = sanitize_text_field(wpcf_function()->post('wpcf_smtp_from_text'));
                wpcf_function()->update_text('wpcf_smtp_from_text', $wpcf_smtp_from_text);

                $wpcf_smtp_host = sanitize_text_field(wpcf_function()->post('wpcf_smtp_host'));
                wpcf_function()->update_text('wpcf_smtp_host', $wpcf_smtp_host);

                $wpcf_smtp_port = sanitize_text_field(wpcf_function()->post('wpcf_smtp_port'));
                wpcf_function()->update_text('wpcf_smtp_port', $wpcf_smtp_port);

                $wpcf_smtp_encription = sanitize_text_field(wpcf_function()->post('wpcf_smtp_encription'));
                wpcf_function()->update_text('wpcf_smtp_encription', $wpcf_smtp_encription);

                $wpcf_smtp_username = sanitize_text_field(wpcf_function()->post('wpcf_smtp_username'));
                wpcf_function()->update_text('wpcf_smtp_username', $wpcf_smtp_username);

                $wpcf_smtp_password = sanitize_text_field(wpcf_function()->post('wpcf_smtp_password'));
                wpcf_function()->update_text('wpcf_smtp_password', base64_encode($wpcf_smtp_password));
            }
        }


        public function mailer_config(PHPMailer $mailer) {
            $enable_smtp = get_option( 'wpcf_enable_smtp' );
            if( isset($enable_smtp) && $enable_smtp == 'true' ) {
                $mailer->IsSMTP();
                $mailer->SMTPAuth   = true;
                $mailer->Host       = get_option( 'wpcf_smtp_host' ); // your SMTP server
                $mailer->Port       = get_option( 'wpcf_smtp_port' );
                $mailer->SMTPSecure = get_option( 'wpcf_smtp_encription' );
                $mailer->Username   = get_option( 'wpcf_smtp_username' );
                $mailer->Password   = base64_decode( get_option('wpcf_smtp_password') );
                $mailer->From       = get_option( 'wpcf_smtp_from_email' );
                $mailer->FromName   = get_option( 'wpcf_smtp_from_text' );
                $mailer->CharSet    = "utf-8";
                //$mailer->SMTPDebug  = 2; // write 0 if you don't want to see client/server communication in page
            }
        }
    }
}
WPCF_Email::instance();