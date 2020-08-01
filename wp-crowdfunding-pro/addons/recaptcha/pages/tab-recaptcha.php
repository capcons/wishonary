<?php
defined('ABSPATH') || exit;

// #reCAPTCHA Settings (Tab Settings)
$arr =  array(
            // #Listing Page Seperator
            array(
                'type'      => 'seperator',
                'label'     => __('reCAPTCHA Settings','wp-crowdfunding-pro'),
                'desc'      => __('You may enable reCAPTCHA to prevent spamming','wp-crowdfunding-pro'),
                'top_line'  => 'true',
                ),
                
            // #Enable Recaptcha in User Registration
            array(
                'id'        => 'wpneo_enable_recaptcha_in_user_registration',
                'type'      => 'checkbox',
                'value'     => 'true',
                'label'     => __('Enable reCAPTCHA on user registration page','wp-crowdfunding-pro'),
                'desc'      => __('Enable/Disable','wp-crowdfunding-pro'),
                ),

            // #Enable Recaptcha in User Registration
            array(
                'id'        => 'wpneo_enable_recaptcha_campaign_submit_page',
                'type'      => 'checkbox',
                'value'     => 'true',
                'label'     => __('Enable reCAPTCHA on campaign submit page','wp-crowdfunding-pro'),
                'desc'      => __('Enable/Disable','wp-crowdfunding-pro'),
                ),

            // #Site key / Public Key
            array(
                'id'        => 'wpneo_recaptcha_site_key',
                'type'      => 'text',
                'value'     => '',
                'label'     => __('Site key / Public Key','wp-crowdfunding-pro'),
                'desc'      => __('Put your Google reCAPTCHA Public key here. <a href="https://www.google.com/recaptcha/admin#list" target="_blank">Visit this link</a> to generate one.','wp-crowdfunding-pro'),
                ),

            // #Secret Key
            array(
                'id'        => 'wpneo_recaptcha_secret_key',
                'type'      => 'text',
                'value'     => '',
                'label'     => __('Secret Key','wp-crowdfunding-pro'),
                'desc'      => __('Put your Google reCAPTCHA Secret key here. <a href="https://www.google.com/recaptcha/admin#list" target="_blank">Visit this link</a> to generate one.','wp-crowdfunding-pro'),
                ),

            // #Save Function
            array(
                'id'        => 'wpneo_recaptcha_activation',
                'type'      => 'hidden',
                'value'     => 'true',
                ),
);
if( function_exists('wpcf_function') ){
    wpcf_function()->generator( $arr );
}
