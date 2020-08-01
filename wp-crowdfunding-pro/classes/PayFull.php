<?php
namespace WPCF_PRO;

defined('ABSPATH') || exit;

if( !class_exists('PayFull') ){
    class PayFull{

        function __construct() {
            add_filter('wp_crowdfunding_wc_settings',   array($this,'full_to_campaign_owner_settings'), 10, 1);
            add_action('admin_init',                    array($this,'save_pay_full_campaign_owner_settings'));
            add_filter('woocommerce_paypal_args',       array($this,'pay_full_payment_to_campaign_owner'), 10, 2);
        }


        /**
         * Add a settings for enable disable ability
         *
         * @since WP Crowdfunding 20.21
         */
        public function full_to_campaign_owner_settings($settings){
            //Seperator
            $settings[] = array(
                'type'      => 'seperator',
                'label'     => __('Pay full to Campaign Owner Settings','wp-crowdfunding-pro'),
                'desc'      => __('Enable or disable ability to Pay 100% fund to campaign owner via PayPal standard Payment','wp-crowdfunding-pro'),
                'top_line'  => 'true',
            );

            // #Send 100% Payment to Campaign Owner
            $settings[] = array(
                    'id'        => 'is_sent_full_payment_to_campaign_owner',
                    'type'      => 'checkbox',
                    'value'     => 'true',
                    'label'     => __('Send 100% Payment to Campaign Owner (PayPal Standard Only)','wp-crowdfunding-pro'),
                    'desc'      => __('Enable/Disable','wp-crowdfunding-pro'),
                );

            return $settings;
        }


        /**
         * Save Settings
         *
         * @since WP Crowdfunding 20.21
         */
        public function save_pay_full_campaign_owner_settings(){
            if ( isset($_POST['is_sent_full_payment_to_campaign_owner'])){
                $is_sent_full_payment_to_campaign_owner = sanitize_text_field(wpcf_function()->post('is_sent_full_payment_to_campaign_owner'));
                wpcf_function()->update_checkbox('is_sent_full_payment_to_campaign_owner', $is_sent_full_payment_to_campaign_owner);
            }
        }


        /**
         * Since Wp Crowdfunding 20.21
         */
        public function pay_full_payment_to_campaign_owner($paypal_param, $order){
            if (empty($paypal_param))
                return;
        
            $order_id = $order->get_id();
        
            //Checking is order for wp crowdfunding
            if ( ! get_post_meta($order_id, 'is_crowdfunding_order', true))
                return $paypal_param;
        
            $is_sent_full_payment_to_campaign_owner = get_option('is_sent_full_payment_to_campaign_owner');
            if ($is_sent_full_payment_to_campaign_owner !== 'true')
                return $paypal_param;
        
        
            $is_crowdfunding_product_exists = false;
            foreach ($order->get_items() as $item) {
                $product = wc_get_product($item['product_id']);
                if($product->get_type() == 'crowdfunding'){
                    $is_crowdfunding_product_exists = true;
                }
            }
        
            if ( ! $is_crowdfunding_product_exists){
                return $paypal_param;
            }
        
            return $paypal_param;
        }


    }
}