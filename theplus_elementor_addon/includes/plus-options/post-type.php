<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$client_post=theplus_get_option('post_type','client_post_type');
if(isset($client_post) && !empty($client_post) &&  $client_post=='plugin'){
/*------------------------------------clients post type--------------------------------*/
function theplus_ele_clients_function() {
	$post_name=theplus_get_option('post_type','client_plugin_name');	
	if(isset($post_name) && !empty($post_name)){
		$post_name=theplus_get_option('post_type','client_plugin_name');
	}else{
		$post_name='theplus_clients';
	}
	
	$tp_client_title=theplus_get_option('post_type','client_plugin_title');		
	$client_post_title='Tp Clients';
	if(isset($tp_client_title) && !empty($tp_client_title)){
		$client_post_title=theplus_get_option('post_type','client_plugin_title');
	}
	
	$labels = array(
		'name'                  => _x( $client_post_title, 'Post Type General Name', 'theplus' ),
		'singular_name'         => _x( $client_post_title, 'Post Type Singular Name', 'theplus' ),
		'menu_name'             => esc_html( $client_post_title ),
		'name_admin_bar'        => esc_html( $client_post_title ),
		'archives'              => esc_html__( 'Item Archives', 'theplus' ),
		'attributes'            => esc_html__( 'Item Attributes', 'theplus' ),
		'parent_item_colon'     => esc_html__( 'Parent Item:', 'theplus' ),
		'all_items'             => esc_html__( 'All Items', 'theplus' ),
		'add_new_item'          => esc_html__( 'Add New Item', 'theplus' ),
		'add_new'               => esc_html__( 'Add New', 'theplus' ),
		'new_item'              => esc_html__( 'New Item', 'theplus' ),
		'edit_item'             => esc_html__( 'Edit Item', 'theplus' ),
		'update_item'           => esc_html__( 'Update Item', 'theplus' ),
		'view_item'             => esc_html__( 'View Item', 'theplus' ),
		'view_items'            => esc_html__( 'View Items', 'theplus' ),
		'search_items'          => esc_html__( 'Search Item', 'theplus' ),
		'not_found'             => esc_html__( 'Not found', 'theplus' ),
		'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'theplus' ),
		'featured_image'        => esc_html__( 'Featured Image', 'theplus' ),
		'set_featured_image'    => esc_html__( 'Set featured image', 'theplus' ),
		'remove_featured_image' => esc_html__( 'Remove featured image', 'theplus' ),
		'use_featured_image'    => esc_html__( 'Use as featured image', 'theplus' ),
		'insert_into_item'      => esc_html__( 'Insert into item', 'theplus' ),
		'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'theplus' ),
		'items_list'            => esc_html__( 'Items list', 'theplus' ),
		'items_list_navigation' => esc_html__( 'Items list navigation', 'theplus' ),
		'filter_items_list'     => esc_html__( 'Filter items list', 'theplus' ),
	);
	$args = array(
		'label'                 => esc_html__( 'Clients', 'theplus' ),
		'description'           => esc_html__( 'Post Type Description', 'theplus' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail','revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( $post_name, $args );

}
add_action( 'init', 'theplus_ele_clients_function', 0 );

if ( ! function_exists( 'theplus_ele_clients_category' ) ) {
function theplus_ele_clients_category() {
	$post_name=theplus_get_option('post_type','client_plugin_name');	
	if(isset($post_name) && !empty($post_name)){
		$post_name=theplus_get_option('post_type','client_plugin_name');
	}else{
		$post_name='theplus_clients';
	}
	$category_name=theplus_get_option('post_type','client_category_plugin_name');
	if(isset($category_name) && !empty($category_name)){
		$category_name=theplus_get_option('post_type','client_category_plugin_name');
	}else{
		$category_name='theplus_clients_cat';
	}
	
	$tp_client_title=theplus_get_option('post_type','client_plugin_title');		
	$client_post_title='Tp Clients';
	if(isset($tp_client_title) && !empty($tp_client_title)){
		$client_post_title=theplus_get_option('post_type','client_plugin_title');
	}
	
	$labels = array(
		'name'                       => $client_post_title.' Categories',
		'singular_name'              => $client_post_title.' Category',
		'menu_name'                  => $client_post_title.' Category',
		'all_items'                  => 'All Items',
		'parent_item'                => 'Parent Item',
		'parent_item_colon'          => 'Parent Item:',
		'new_item_name'              => 'New Item Name',
		'add_new_item'               => 'Add New Item',
		'edit_item'                  => 'Edit Item',
		'update_item'                => 'Update Item',
		'view_item'                  => 'View Item',
		'separate_items_with_commas' => 'Separate items with commas',
		'add_or_remove_items'        => 'Add or remove items',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Items',
		'search_items'               => 'Search Items',
		'not_found'                  => 'Not Found',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( $category_name, array( $post_name ), $args );

}
add_action( 'init', 'theplus_ele_clients_category', 0 );
}
/*------------------------------------clients post type-------------------------*/
}
$testimonial_post=theplus_get_option('post_type','testimonial_post_type');
if(isset($testimonial_post) && !empty($testimonial_post) && $testimonial_post=='plugin'){
/*------------------------------------testimonials post type -----------------------*/
function theplus_ele_testimonials_func() {
$post_name=theplus_get_option('post_type','testimonial_plugin_name');	
	if(isset($post_name) && !empty($post_name)){
		$post_name=theplus_get_option('post_type','testimonial_plugin_name');
	}else{
		$post_name='theplus_testimonial';
	}
	
	$tp_testimonial_title=theplus_get_option('post_type','testimonial_plugin_title');		
	$tp_testimonial_post_title='TP Testimonials';
	if(isset($tp_testimonial_title) && !empty($tp_testimonial_title)){
		$tp_testimonial_post_title=theplus_get_option('post_type','testimonial_plugin_title');
	}
	
	$labels = array(
		'name'                  => _x( $tp_testimonial_post_title, 'Post Type General Name', 'theplus' ),
		'singular_name'         => _x( $tp_testimonial_post_title, 'Post Type Singular Name', 'theplus' ),
		'menu_name'             => esc_html( $tp_testimonial_post_title ),
		'name_admin_bar'        => esc_html( $tp_testimonial_post_title ),
		'archives'              => esc_html__( 'Item Archives', 'theplus' ),
		'parent_item_colon'     => esc_html__( 'Parent Item:', 'theplus' ),
		'all_items'             => esc_html__( 'All Items', 'theplus' ),
		'add_new_item'          => esc_html__( 'Add New Item', 'theplus' ),
		'add_new'               => esc_html__( 'Add New', 'theplus' ),
		'new_item'              => esc_html__( 'New Item', 'theplus' ),
		'edit_item'             => esc_html__( 'Edit Item', 'theplus' ),
		'update_item'           => esc_html__( 'Update Item', 'theplus' ),
		'view_item'             => esc_html__( 'View Item', 'theplus' ),
		'search_items'          => esc_html__( 'Search Item', 'theplus' ),
		'not_found'             => esc_html__( 'Not found', 'theplus' ),
		'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'theplus' ),
		'featured_image'        => esc_html__( 'Profile Image', 'theplus' ),
		'set_featured_image'    => esc_html__( 'Set profile image', 'theplus' ),
		'remove_featured_image' => esc_html__( 'Remove profile image', 'theplus' ),
		'use_featured_image'    => esc_html__( 'Use as profile image', 'theplus' ),
		'insert_into_item'      => esc_html__( 'Insert into item', 'theplus' ),
		'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'theplus' ),
		'items_list'            => esc_html__( 'Items list', 'theplus' ),
		'items_list_navigation' => esc_html__( 'Items list navigation', 'theplus' ),
		'filter_items_list'     => esc_html__( 'Filter items list', 'theplus' ),
	);
	$args = array(
		'label'                 => esc_html__( 'TP Testimonials', 'theplus' ),
		'description'           => esc_html__( 'Post Type Description', 'theplus' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail','revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'				=> 'dashicons-testimonial',
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( $post_name, $args );

}
add_action( 'init', 'theplus_ele_testimonials_func', 0 );

if ( ! function_exists( 'theplus_ele_testimonial_category' ) ) {
function theplus_ele_testimonial_category() {
$post_name=theplus_get_option('post_type','testimonial_plugin_name');	
	if(isset($post_name) && !empty($post_name)){
		$post_name=theplus_get_option('post_type','testimonial_plugin_name');
	}else{
		$post_name='theplus_testimonial';
	}
$category_name=theplus_get_option('post_type','testimonial_category_plugin_name');
	if(isset($category_name) && !empty($category_name)){
		$category_name=theplus_get_option('post_type','testimonial_category_plugin_name');
	}else{
		$category_name='theplus_testimonial_cat';
	}
	
	$tp_testimonial_title=theplus_get_option('post_type','testimonial_plugin_title');		
	$tp_testimonial_post_title='TP Testimonials';
	if(isset($tp_testimonial_title) && !empty($tp_testimonial_title)){
		$tp_testimonial_post_title=theplus_get_option('post_type','testimonial_plugin_title');
	}
	$labels = array(
		'name'                       => $tp_testimonial_post_title.' Categories',
		'singular_name'              => $tp_testimonial_post_title.' Category',
		'menu_name'                  => $tp_testimonial_post_title.' Category',
		'all_items'                  => 'All Items',
		'parent_item'                => 'Parent Item',
		'parent_item_colon'          => 'Parent Item:',
		'new_item_name'              => 'New Item Name',
		'add_new_item'               => 'Add New Item',
		'edit_item'                  => 'Edit Item',
		'update_item'                => 'Update Item',
		'view_item'                  => 'View Item',
		'separate_items_with_commas' => 'Separate items with commas',
		'add_or_remove_items'        => 'Add or remove items',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Items',
		'search_items'               => 'Search Items',
		'not_found'                  => 'Not Found',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( $category_name, array( $post_name ), $args );

}
add_action( 'init', 'theplus_ele_testimonial_category', 0 );
}
/*------------------------------------testimonials post type -----------------------*/
}
/*------------------------------------Team member post type-------------------------*/
$team_member_post=theplus_get_option('post_type','team_member_post_type');
if(isset($team_member_post) && !empty($team_member_post) && $team_member_post=='plugin'){
function theplus_ele_team_member_function() {
$post_name=theplus_get_option('post_type','team_member_plugin_name');	
	if(isset($post_name) && !empty($post_name)){
		$post_name=theplus_get_option('post_type','team_member_plugin_name');
	}else{
		$post_name='theplus_team_member';
	}
	
	$team_member_plugin_title=theplus_get_option('post_type','team_member_plugin_title');		
	$team_member_title='TP Team Member';
	if(isset($team_member_plugin_title) && !empty($team_member_plugin_title)){
		$team_member_title=theplus_get_option('post_type','team_member_plugin_title');
	}
	$labels = array(
		'name'                  => _x( $team_member_title, 'Post Type General Name', 'theplus' ),
		'singular_name'         => _x( $team_member_title, 'Post Type Singular Name', 'theplus' ),
		'menu_name'             => esc_html( $team_member_title ),
		'name_admin_bar'        => esc_html( $team_member_title ),
		'archives'              => esc_html__( 'Item Archives', 'theplus' ),
		'attributes'            => esc_html__( 'Item Attributes', 'theplus' ),
		'parent_item_colon'     => esc_html__( 'Parent Item:', 'theplus' ),
		'all_items'             => esc_html__( 'All Items', 'theplus' ),
		'add_new_item'          => esc_html__( 'Add New Item', 'theplus' ),
		'add_new'               => esc_html__( 'Add New', 'theplus' ),
		'new_item'              => esc_html__( 'New Item', 'theplus' ),
		'edit_item'             => esc_html__( 'Edit Item', 'theplus' ),
		'update_item'           => esc_html__( 'Update Item', 'theplus' ),
		'view_item'             => esc_html__( 'View Item', 'theplus' ),
		'view_items'            => esc_html__( 'View Items', 'theplus' ),
		'search_items'          => esc_html__( 'Search Item', 'theplus' ),
		'not_found'             => esc_html__( 'Not found', 'theplus' ),
		'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'theplus' ),
		'featured_image'        => esc_html__( 'Featured Image', 'theplus' ),
		'set_featured_image'    => esc_html__( 'Set featured image', 'theplus' ),
		'remove_featured_image' => esc_html__( 'Remove featured image', 'theplus' ),
		'use_featured_image'    => esc_html__( 'Use as featured image', 'theplus' ),
		'insert_into_item'      => esc_html__( 'Insert into item', 'theplus' ),
		'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'theplus' ),
		'items_list'            => esc_html__( 'Items list', 'theplus' ),
		'items_list_navigation' => esc_html__( 'Items list navigation', 'theplus' ),
		'filter_items_list'     => esc_html__( 'Filter items list', 'theplus' ),
	);
	$args = array(
		'label'                 => esc_html__( 'TP Team Member', 'theplus' ),
		'description'           => esc_html__( 'Post Type Description', 'theplus' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail','revisions', 'custom-fields', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,	
		'menu_icon'   => 'dashicons-id-alt',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( $post_name, $args );

}
add_action( 'init', 'theplus_ele_team_member_function', 0 );

if ( ! function_exists( 'theplus_ele_team_member_category' ) ) {
function theplus_ele_team_member_category() {
	$post_name=theplus_get_option('post_type','team_member_plugin_name');	
	if(isset($post_name) && !empty($post_name)){
		$post_name=theplus_get_option('post_type','team_member_plugin_name');
	}else{
		$post_name='theplus_team_member';
	}
	$category_name=theplus_get_option('post_type','team_member_category_plugin_name');
	if(isset($category_name) && !empty($category_name)){
		$category_name=theplus_get_option('post_type','team_member_category_plugin_name');
	}else{
		$category_name='theplus_team_member_cat';
	}
	$team_member_plugin_title=theplus_get_option('post_type','team_member_plugin_title');		
	$team_member_title='TP Team Member';
	if(isset($team_member_plugin_title) && !empty($team_member_plugin_title)){
		$team_member_title=theplus_get_option('post_type','team_member_plugin_title');
	}
	$labels = array(
		'name'                       => $team_member_title.' Categories',
		'singular_name'              => $team_member_title.' Category',
		'menu_name'                  => $team_member_title.' Category',
		'all_items'                  => 'All Items',
		'parent_item'                => 'Parent Item',
		'parent_item_colon'          => 'Parent Item:',
		'new_item_name'              => 'New Item Name',
		'add_new_item'               => 'Add New Item',
		'edit_item'                  => 'Edit Item',
		'update_item'                => 'Update Item',
		'view_item'                  => 'View Item',
		'separate_items_with_commas' => 'Separate items with commas',
		'add_or_remove_items'        => 'Add or remove items',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Items',
		'search_items'               => 'Search Items',
		'not_found'                  => 'Not Found',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( $category_name, array( $post_name ), $args );

}
add_action( 'init', 'theplus_ele_team_member_category', 0 );
}
}
/*------------------------------------team meamber post type End ------------------*/
/*-----------------Plus Mega Menu --------------------*/
$megamenu=theplus_get_option('general','check_elements');
if(isset($megamenu) && !empty($megamenu) && in_array("tp_navigation_menu", $megamenu)){
	
function plus_mega_menu_posts() {

	$labels = array(
		'name'                  => _x( 'Plus Mega Menu', 'Post Type General Name', 'theplus' ),
		'singular_name'         => _x( 'Plus Mega Menu', 'Post Type Singular Name', 'theplus' ),
		'menu_name'             => esc_html__( 'Plus Mega Menu', 'theplus' ),
		'name_admin_bar'        => esc_html__( 'Plus Mega Menu', 'theplus' ),
		'archives'              => esc_html__( 'Item Archives', 'theplus' ),
		'attributes'            => esc_html__( 'Item Attributes', 'theplus' ),
		'parent_item_colon'     => esc_html__( 'Parent Item:', 'theplus' ),
		'all_items'             => esc_html__( 'All Items', 'theplus' ),
		'add_new_item'          => esc_html__( 'Add New Item', 'theplus' ),
		'add_new'               => esc_html__( 'Add New', 'theplus' ),
		'new_item'              => esc_html__( 'New Item', 'theplus' ),
		'edit_item'             => esc_html__( 'Edit Item', 'theplus' ),
		'update_item'           => esc_html__( 'Update Item', 'theplus' ),
		'view_item'             => esc_html__( 'View Item', 'theplus' ),
		'view_items'            => esc_html__( 'View Items', 'theplus' ),
		'search_items'          => esc_html__( 'Search Item', 'theplus' ),
		'not_found'             => esc_html__( 'Not found', 'theplus' ),
		'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'theplus' ),
		'featured_image'        => esc_html__( 'Featured Image', 'theplus' ),
		'set_featured_image'    => esc_html__( 'Set featured image', 'theplus' ),
		'remove_featured_image' => esc_html__( 'Remove featured image', 'theplus' ),
		'use_featured_image'    => esc_html__( 'Use as featured image', 'theplus' ),
		'insert_into_item'      => esc_html__( 'Insert into item', 'theplus' ),
		'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'theplus' ),
		'items_list'            => esc_html__( 'Items list', 'theplus' ),
		'items_list_navigation' => esc_html__( 'Items list navigation', 'theplus' ),
		'filter_items_list'     => esc_html__( 'Filter items list', 'theplus' ),
	);
	$args = array(
		'label'                 => esc_html__( 'Plus Mega Menu', 'theplus' ),
		'description'           => esc_html__( 'Mega Menu Content', 'theplus' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor','elementor' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-widgets-menus',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'plus-mega-menu', $args );

}
add_action( 'init', 'plus_mega_menu_posts', 0 );
}
/*-----------------Plus Mega Menu --------------------*/