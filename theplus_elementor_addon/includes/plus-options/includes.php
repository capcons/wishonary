<?php
	require_once THEPLUS_INCLUDES_URL.'plus-options/extension/cmb2-field-ajax-search.php';
	require_once THEPLUS_INCLUDES_URL.'plus-options/post-type.php';
	
	$client_post=theplus_get_option('post_type','client_post_type');
	if(isset($client_post) && !empty($client_post) && ($client_post=='themes' || $client_post=='plugin' || $client_post=='themes_pro')){
		require_once THEPLUS_INCLUDES_URL.'plus-options/custom-metabox/clients_options.php';
	}
	$testimonial_post=theplus_get_option('post_type','testimonial_post_type');
	if(isset($testimonial_post) && !empty($testimonial_post) && ($testimonial_post=='themes' || $testimonial_post=='plugin' || $client_post=='themes_pro')){
		require_once THEPLUS_INCLUDES_URL.'plus-options/custom-metabox/testimonial_option.php';
	}
	$team_member_post=theplus_get_option('post_type','team_member_post_type');
	if(isset($team_member_post) && !empty($team_member_post) && ($team_member_post=='themes' || $team_member_post=='plugin' || $client_post=='themes_pro')){
		require_once THEPLUS_INCLUDES_URL.'plus-options/custom-metabox/teammember_options.php';		
	}
	
	$megamenu=theplus_get_option('general','check_elements');
	$check_category= get_option( 'theplus_api_connection_data' );
	if(isset($megamenu) && !empty($megamenu) && in_array("tp_dynamic_categories", $megamenu) && !empty($check_category['dynamic_category_thumb_check'])){
		require_once THEPLUS_INCLUDES_URL.'plus-options/custom-metabox/taxonomy_options.php';		
	}
	
	require_once THEPLUS_INCLUDES_URL.'plus-options/custom-metabox/custom_field_repeater_option.php';
?>