<?php
defined('ABSPATH') || exit;

// #Email Settings (Tab Settings)
$arr =  array(

    //------------------------------ Email SMTP Settings -------------------------------
    // #Email notification after new backed Seperator
    array(
        'type'      => 'seperator',
        'label'     => '',
        'desc'      => __('SMTP Settings', 'wp-crowdfunding-pro'),
        'top_line'  => 'true',
    ),

    // #Enable Email for crowdfunding Plugin
    array(
        'id'        => 'wpcf_enable_smtp',
        'type'      => 'checkbox',
        'value'     => 'true',
        'label'     => __('Enable SMTP', 'wp-crowdfunding-pro'),
        'desc'      => __('Enable SMTP for WP Crowdfunding Plugin','wp-crowdfunding-pro'),
    ),

    // #SMTP Host
    array(
        'id'        => 'wpcf_smtp_host',
        'type'      => 'text',
        'value'     => '',
        'label'     => __('SMTP Host', 'wp-crowdfunding-pro'),
        'desc'      => __('Define the SMTP host.','wp-crowdfunding-pro'),
    ),

    // #SMTP Port
    array(
        'id'        => 'wpcf_smtp_port',
        'type'      => 'text',
        'value'     => '',
        'label'     => __('SMTP Port', 'wp-crowdfunding-pro'),
        'desc'      => __('Enter  the SMTP port.','wp-crowdfunding-pro'),
    ),

    // #Encription
    array(
        'id'        => 'wpcf_smtp_encription',
        'type'      => 'radio',
        'option'    => array(
            ''      => __("None", "wp-crowdfunding"),
            'ssl'   => __("SSL", "wp-crowdfunding"),
            'tls'   => __("TLS", "wp-crowdfunding"),
        ),
        'value'     => '',
        'label'     => __( 'Encryption Type', 'wp-crowdfunding-pro' ),
        'desc'      => __( 'Select the email encryption type.', 'wp-crowdfunding-pro' ),
    ),

    // #SMTP Username
    array(
        'id'        => 'wpcf_smtp_username',
        'type'      => 'text',
        'value'     => '',
        'label'     => __('SMTP Username', 'wp-crowdfunding-pro'),
        'desc'      => __('Your SMTP account username.', 'wp-crowdfunding-pro'),
        'encrypt'   => true,
    ),

    // #SMTP Password
    array(
        'id'        => 'wpcf_smtp_password',
        'type'      => 'password',
        'value'     => '',
        'label'     => __('SMTP Password', 'wp-crowdfunding-pro'),
        'desc'      => __('Your SMTP account password.', 'wp-crowdfunding-pro'),
        'encrypt'   => true,
    ),

    // #Form Text
    array(
        'id'        => 'wpcf_smtp_from_text',
        'type'      => 'text',
        'value'     => '',
        'label'     => __('Form Name', 'wp-crowdfunding-pro'),
        'desc'      => __('Set the email sender name.','wp-crowdfunding-pro'),
    ),

    // #Form Email
    array(
        'id'        => 'wpcf_smtp_from_email',
        'type'      => 'text',
        'value'     => '',
        'label'     => __('Form Address', 'wp-crowdfunding-pro'),
        'desc'      => __('Set the email sender email.','wp-crowdfunding-pro'),
    ),

    

    // #Save Function
    array(
        'id'        => 'wpcf_email_activation',
        'type'      => 'hidden',
        'value'     => 'true',
    ),
);
if( function_exists('wpcf_function') ){
    wpcf_function()->generator( $arr );
}