<?php
defined('ABSPATH') || exit;

class WPCF_Stripe_Connect_Init {

    protected $is_active = false;
    protected $client_id;
    protected $client_secret;
    protected $publishable_key;

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

    public function __construct() {
        $settings = get_option('woocommerce_wpneo_stripe_connect_settings');
        if ( !empty($settings['enabled'])  && $settings['enabled'] == 'yes' ) {
            $this->is_active = true;
            add_action( 'init', array($this, 'enqueue_frontend_script') ); //Do
            add_action( 'wpcf_dashboard_after_dashboard_form', array($this, 'generate_stripe_connect_form'),10);
        }

        if ($settings['test_mode'] === 'yes'){
            $this->client_id = empty($settings['test_client_id']) ? '' : $settings['test_client_id'];
            $this->client_secret = empty($settings['test_secret_key']) ? '' : $settings['test_secret_key'];
            $this->publishable_key = empty($settings['test_publishable_key']) ? '' : $settings['test_publishable_key'];
        } else {
            $this->client_id = empty($settings['live_client_id']) ? '' : $settings['live_client_id'];
            $this->client_secret = empty($settings['secret_key']) ? '' : $settings['secret_key'];
            $this->publishable_key = empty($settings['publishable_key']) ? '' : $settings['publishable_key'];
        }

        if ( !empty($settings['enabled'])  && $settings['enabled'] == 'yes' ) {
            add_action( 'wp_ajax_wpcf_stripe_disconnect', array($this, 'stripe_disconnect') );
            add_filter( 'woocommerce_available_payment_gateways', array($this, 'filter_gateways'), 1 );
        }
    }

    public function get_authorized_from_stripe_application() {
        $user = wp_get_current_user();

        if (isset($_GET['code'])) { // Redirect w/ code
            $code = sanitize_text_field($_GET['code']);

            $token_request_body = array(
                        'grant_type'    => 'authorization_code',
                        'client_id'     => $this->client_id,
                        'code'          => $code,
                        'client_secret' => $this->client_secret
            );

            $req = curl_init("https://connect.stripe.com/oauth/token");
            curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($req, CURLOPT_POST, true );
            curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));

            // TODO: Additional error handling
            $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
            $resp = json_decode(curl_exec($req), true);
            curl_close($req);

            if ( !empty($resp['stripe_user_id']) ) {
                update_user_meta($user->ID, 'stripe_user_id', $resp['stripe_user_id']);
                return $resp['stripe_user_id'];
            }
        } else {
            return get_user_meta($user->ID, 'stripe_user_id', true);
        }
        return false;
    }

    public function enqueue_frontend_script(){
        wp_enqueue_style('wpcf-stripe-connect-css', plugin_dir_url(__DIR__).'assets/stripe-connect.css', array(), WPCF_PRO_VERSION);
    }

    public function generate_stripe_connect_form(){
        $stripe_user_id = $this->get_authorized_from_stripe_application();
        $authorize_request_body = array(
            'response_type' => 'code',
            'scope' => 'read_write',
            'client_id' => $this->client_id
        );
        $url = 'https://connect.stripe.com/oauth/authorize' . '?' . http_build_query($authorize_request_body);

        $html = '';
        $html .= '<div class="wpneo-single"><div class="wpneo-name float-left"><p>Stripe:</p></div><div class="wpneo-fields float-right">';

        if ($stripe_user_id) {
            $html .= '<a href="'.$url.'" class="stripe-connect"><span>'.__('Connected', 'wp-crowdfunding-pro').'</span></a>'; // Connect Button
            $html .= '<a class="stripe-connect wpcf-stripe-connect-deauth" href="javascript:void(0)"><span>'.__('Disconnect', 'wp-crowdfunding-pro').'</span></a>'; // Disconnect Button
        } else {
            $html .= '<a href="'.$url.'" class="stripe-connect"><span>'.__('Connect with Stripe', 'wp-crowdfunding-pro').'</span></a>';
        }
        $html .= '</div></div>';
        echo $html;
    }

    /**
     * @param $gateways
     * @return mixed
     */

    function filter_gateways($gateways){
        global $woocommerce;

        foreach ($woocommerce->cart->cart_contents as $key => $values) {
            if (isset($values['product_id'])) {
                $_product = wc_get_product($values['product_id']);
                if ($_product->is_type('crowdfunding')) {
                    if (is_array($gateways)) {
                        //Check if this campaign owner connected with stripe?
                        $post = get_post($_product->get_id());
                        $campaign_owner_id = $post->post_author;
                        $campaign_owner = get_user_meta($campaign_owner_id, 'stripe_user_id', true);
                        if ( !$campaign_owner ) {
                            unset($gateways['wpneo_stripe_connect']);
                        }
                    }
                } else {
                    unset($gateways['wpneo_stripe_connect']);
                }
            }
        }
        return $gateways;
    }

    // Stripe disconnect action
    public function stripe_disconnect() {
        $user = wp_get_current_user();
        $stripe_user_id = get_user_meta($user->ID, 'stripe_user_id', true);
        $request_body = array(
                    'client_id'         => $this->client_id,
                    'stripe_user_id'    => $stripe_user_id
        );
        $headers = array(
            'Content-type: application/json',
            'Authorization: Bearer '.$this->client_secret,
        );
        $req = curl_init("https://connect.stripe.com/oauth/deauthorize");
        curl_setopt($req, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req, CURLOPT_POST, true );
        curl_setopt($req, CURLOPT_POSTFIELDS, json_encode($request_body));
        $resp = json_decode(curl_exec($req), true);
        curl_close($req);

        $redirect = get_permalink(get_option('wpneo_crowdfunding_dashboard_page_id')).'?page_type=dashboard';
        if ( !empty($resp['stripe_user_id']) ) {
            update_user_meta($user->ID, 'stripe_user_id', '');
            die(json_encode(array('success'=> 1, 'message' => __('Stripe disconnected', 'wp-crowdfunding'), 'redirect' => $redirect)));
        } else {
            die(json_encode(array('success'=> 0, 'message' => __('Something went wrong, please try again', 'wp-crowdfunding'), 'redirect' => $redirect)));
        }
    }
    
}
WPCF_Stripe_Connect_Init::instance();

