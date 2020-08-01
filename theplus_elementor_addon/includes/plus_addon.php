<?php 
	if ( ! defined( 'ABSPATH' ) ) { exit; }
		
	global $theplus_options,$post_type_options;
		
add_image_size( 'tp-image-grid', 700, 700, true);

/*defer script*/
function tp_defer_scripts( $tag, $handle, $src ) {
			$defer = array( 
	'google_platform_js'
  );
  if ( in_array( $handle, $defer ) ) {
	 return '<script src="' . $src . '" async defer type="text/javascript"></script>' . "\n";
  }
	
	return $tag;
} 

add_filter( 'script_loader_tag', 'tp_defer_scripts', 10, 3 );
/*defer script*/

function theplus_get_thumb_url(){
	return THEPLUS_ASSETS_URL .'images/placeholder-grid.jpg';
}

/* Custom Link url attachment Media */
function plus_attachment_field_media( $form_fields, $post ) {
    $form_fields['plus-gallery-url'] = array(
        'label' => esc_html__('Custom URL','theplus'),
        'input' => 'url',
        'value' => get_post_meta( $post->ID, 'plus_gallery_url', true ),
        'helps' => esc_html__('Gallery Listing Widget Used Custom Url Media','theplus'),
    );
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'plus_attachment_field_media', 10, 2 );
function plus_attachment_field_save( $post, $attachment ) {    
    if( isset( $attachment['plus-gallery-url'] ) )
		update_post_meta( $post['ID'], 'plus_gallery_url', esc_url( $attachment['plus-gallery-url'] ) ); 
    
	return $post;	
}
add_filter( 'attachment_fields_to_save', 'plus_attachment_field_save', 10, 2 );
/* Custom Link url attachment Media */

class Theplus_MetaBox {
	
	public static function get($name) {
		global $post;
		
		if (isset($post) && !empty($post->ID)) {
			return get_post_meta($post->ID, $name, true);
		}
		
		return false;
	}
}
function theplus_get_option($options_type,$field){
	$theplus_options=get_option( 'theplus_options' );
	$post_type_options=get_option( 'post_type_options' );
	$values='';
	if($options_type=='general'){
		if(isset($theplus_options[$field]) && !empty($theplus_options[$field])){
			$values=$theplus_options[$field];
		}
	}
	if($options_type=='post_type'){
		if(isset($post_type_options[$field]) && !empty($post_type_options[$field])){
			$values=$post_type_options[$field];
		}
	}
	return $values;
}

function theplus_white_label_option($field){
	$label_options=get_option( 'theplus_white_label' );	
		$values='';
		if(isset($label_options[$field]) && !empty($label_options[$field])){
			$values=$label_options[$field];
		}	
	return $values;
}

function theplus_testimonial_post_name(){
	$post_type_options=get_option( 'post_type_options' );
	$testi_post_type=$post_type_options['testimonial_post_type'];
	$post_name='theplus_testimonial';
	if(isset($testi_post_type) && !empty($testi_post_type)){
		if($testi_post_type=='themes'){
			$post_name=theplus_get_option('post_type','testimonial_theme_name');
		}elseif($testi_post_type=='plugin'){
			$get_name=theplus_get_option('post_type','testimonial_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$post_name=theplus_get_option('post_type','testimonial_plugin_name');
			}
		}elseif($testi_post_type=='themes_pro'){
			$post_name='testimonial';
		}
	}else{
		$post_name='theplus_testimonial';
	}
	return $post_name;
}
function theplus_testimonial_post_category(){
	$post_type_options=get_option( 'post_type_options' );
	$testi_post_type=$post_type_options['testimonial_post_type'];
	$taxonomy_name='theplus_testimonial_cat';
	if(isset($testi_post_type) && !empty($testi_post_type)){
		if($testi_post_type=='themes'){
			$taxonomy_name=theplus_get_option('post_type','testimonial_category_name');
		}else if($testi_post_type=='plugin'){
			$get_name=theplus_get_option('post_type','testimonial_category_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$taxonomy_name=theplus_get_option('post_type','testimonial_category_plugin_name');
			}
		}elseif($testi_post_type=='themes_pro'){
			$taxonomy_name='testimonial_category';
		}
	}else{
		$taxonomy_name='theplus_testimonial_cat';
	}
	return $taxonomy_name;
}
function theplus_client_post_name(){
	$post_type_options=get_option( 'post_type_options' );
	$client_post_type=$post_type_options['client_post_type'];
	$post_name='theplus_clients';
	if(isset($client_post_type) && !empty($client_post_type)){
		if($client_post_type=='themes'){
			$post_name=theplus_get_option('post_type','client_theme_name');
		}elseif($client_post_type=='plugin'){
			$get_name=theplus_get_option('post_type','client_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$post_name=theplus_get_option('post_type','client_plugin_name');
			}
		}elseif($client_post_type=='themes_pro'){
			$post_name='clients';
		}
	}else{
		$post_name='theplus_clients';
	}
	return $post_name;
}
function theplus_client_post_category(){
	$post_type_options=get_option( 'post_type_options' );
	$client_post_type=$post_type_options['client_post_type'];
	$post_name='theplus_clients_cat';
	if(isset($client_post_type) && !empty($client_post_type)){
		if($client_post_type=='themes'){
			$post_name=theplus_get_option('post_type','client_category_name');
		}else if($client_post_type=='plugin'){
			$get_name=theplus_get_option('post_type','client_category_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$post_name=theplus_get_option('post_type','client_category_plugin_name');
			}
		}elseif($client_post_type=='themes_pro'){
			$post_name='clients_category';
		}
	}else{
		$post_name='theplus_clients_cat';
	}
	return $post_name;
}
function theplus_team_member_post_name(){
	$post_type_options=get_option( 'post_type_options' );
	$team_post_type=$post_type_options['team_member_post_type'];
	$post_name='theplus_team_member';
	if(isset($team_post_type) && !empty($team_post_type)){
		if($team_post_type=='themes'){
			$post_name=theplus_get_option('post_type','team_member_theme_name');
		}elseif($team_post_type=='plugin'){
			$get_name=theplus_get_option('post_type','team_member_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$post_name=theplus_get_option('post_type','team_member_plugin_name');
			}
		}elseif($team_post_type=='themes_pro'){
			$post_name='team_member';
		}
	}else{
		$post_name='theplus_team_member';
	}
	return $post_name;
}
function theplus_team_member_post_category(){
	$post_type_options=get_option( 'post_type_options' );
	$team_post_type=$post_type_options['team_member_post_type'];
	$taxonomy_name='theplus_team_member_cat';
	if(isset($team_post_type) && !empty($team_post_type)){
		if($team_post_type=='themes'){
			$taxonomy_name=theplus_get_option('post_type','team_member_category_name');
		}else if($team_post_type=='plugin'){
			$get_name=theplus_get_option('post_type','team_member_category_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$taxonomy_name=theplus_get_option('post_type','team_member_category_plugin_name');
			}
		}elseif($team_post_type=='themes_pro'){
			$taxonomy_name='team_member_category';
		}
	}else{
		$taxonomy_name='theplus_team_member_cat';
	}
	return $taxonomy_name;
}
function theplus_styling_option(){	
	$theplus_styling_data=get_option( 'theplus_styling_data' );
	
	$css_rules='';
	
	$css_rules .='<style>';	
	
	if(!empty($theplus_styling_data['theplus_custom_css_editor'])){
		$theplus_custom_css_editor=$theplus_styling_data['theplus_custom_css_editor'];
		$css_rules .=$theplus_custom_css_editor;
	}
	$css_rules .='</style>';
	
	if(!empty($theplus_styling_data['theplus_custom_js_editor'])){
		$css_rules .= '<script>';
			$theplus_custom_js_editor=$theplus_styling_data['theplus_custom_js_editor'];
			$css_rules .=$theplus_custom_js_editor;
		$css_rules .= '</script>';
	}
	echo $css_rules;
}
add_action('wp_head', 'theplus_styling_option');

function theplus_scroll_animation(){
	
	$theplus_data=get_option( 'theplus_api_connection_data' );
		
	if(isset($theplus_data['scroll_animation_offset']) && !empty($theplus_data['scroll_animation_offset']) && $theplus_data['scroll_animation_offset']!=0){
		$value= $theplus_data['scroll_animation_offset'].'%';
	}else if(isset($theplus_data['scroll_animation_offset']) && !empty($theplus_data['scroll_animation_offset']) && $theplus_data['scroll_animation_offset']==0){
		$value= '85%';
	}else{
		$value= '85%';
	}
	
	return $value;
}
function theplus_excerpt($limit) {
	if(method_exists('WPBMap', 'addAllMappedShortcodes')) {
		WPBMap::addAllMappedShortcodes();
	}
		global $post;
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt).'...';
		} else {
			$excerpt = implode(" ",$excerpt);
		}	
		$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	
	return $excerpt;
}
function limit_words($string, $word_limit){
	$words = explode(" ",$string);
	return implode(" ",array_splice($words,0,$word_limit));
}	
function theplus_get_title($limit) {
	if(method_exists('WPBMap', 'addAllMappedShortcodes')) {
		WPBMap::addAllMappedShortcodes();
	}
		global $post;
		$title = explode(' ', get_the_title(), $limit);
		if (count($title)>=$limit) {
			array_pop($title);
			$title = implode(" ",$title).'...';
		} else {
			$title = implode(" ",$title);
		}	
		$title = preg_replace('`[[^]]*]`','',$title);
	
	return $title;
}
function theplus_loading_image_grid($postid='',$type=''){
	global $post;
	$content_image='';
	if($type!='background'){		
		$image_url=THEPLUS_ASSETS_URL .'images/placeholder-grid.jpg';
		$content_image='<img src="'.esc_url($image_url).'" alt="'.esc_attr(get_the_title()).'"/>';
		
		return $content_image;
	
	}elseif($type=='background'){
	
		$image_url=THEPLUS_ASSETS_URL .'images/placeholder-grid.jpg';
		$data_src='style="background:url('.esc_url($image_url).') #f7f7f7;" ';
		
		return $data_src;
		
	}
}
function theplus_loading_bg_image($postid=''){
	global $post;
	$content_image='';
	if(!empty($postid)){
		$featured_image=get_the_post_thumbnail_url($postid,'full');
		if(empty($featured_image)){
			$featured_image=theplus_get_thumb_url();
		}
		$content_image='style="background:url('.esc_url($featured_image).') #f7f7f7;"';
		return $content_image;
	}else{
	return $content_image;
	}
}
function theplus_array_flatten($array) {
	  if (!is_array($array)) { 
		return FALSE; 
	  } 
	  $result = array(); 
	  foreach ($array as $key => $value) { 
		if (is_array($value)) { 
		  $result = array_merge($result, theplus_array_flatten($value)); 
		} 
		else { 
		  $result[$key] = $value; 
		} 
	  } 
	  return $result; 
}
function theplus_createSlug($str, $delimiter = '-'){
	
	$slug=preg_replace('/[^A-Za-z0-9-]+/', $delimiter, $str);
	return $slug;
	
} 
/*----------------------------load more posts ---------------------------*/
function theplus_more_post_ajax(){
		global $post;
		ob_start();
		$post_type=$_POST["post_type"];
		$post_load=$_POST["post_load"];
		$texonomy_category=$_POST["texonomy_category"];
		$layout=$_POST["layout"];
		$b_dis_badge_switch=$_POST["badge"];
		$variation_price_on=$_POST["variationprice"];
		$hover_image_on_off=$_POST["hoverimagepro"];
		$offset = $_POST["offset"];
		$display_post = $_POST["display_post"];
		$category=$_POST["category"];
		$post_tags=$_POST["post_tags"];
		$ex_cat=$_POST["ex_cat"];
		$ex_tag=$_POST["ex_tag"];
		$post_authors=$_POST["post_authors"];
		$desktop_column=$_POST["desktop_column"];
		$tablet_column=$_POST["tablet_column"];
		$mobile_column=$_POST["mobile_column"];
		$style= $_POST["style"];
		$style_layout= $_POST["style_layout"];
		$filter_category=$_POST["filter_category"];
		$order_by=$_POST["order_by"];
		$post_order=$_POST["post_order"];
		$animated_columns=$_POST["animated_columns"];
		$post_load_more=$_POST["post_load_more"];
		$display_cart_button=$_POST["cart_button"];
		$paged=$_POST["paged"];
		$metro_column=$_POST["metro_column"];
		$metro_style=$_POST["metro_style"];
		$responsive_tablet_metro=$_POST["responsive_tablet_metro"];
		$tablet_metro_column=$_POST["tablet_metro_column"];
		$tablet_metro_style=$_POST["tablet_metro_style"];
		
		$display_post_title=$_POST["display_post_title"];
		
		$display_title_limit=$_POST["display_title_limit"];
		$display_title_by=$_POST["display_title_by"];
		$display_title_input=$_POST["display_title_input"];
		$display_title_3_dots=$_POST["display_title_3_dots"];
		
		$feature_image=$_POST["feature_image"];
		
		$display_post_meta=$_POST["display_post_meta"];
		$post_meta_tag_style=$_POST["post_meta_tag_style"];
		$display_post_meta_date=$_POST["display_post_meta_date"];
		$display_post_meta_author=$_POST["display_post_meta_author"];
		$display_post_meta_author_pic=$_POST["display_post_meta_author_pic"];
		$display_excerpt=$_POST["display_excerpt"];
		$post_excerpt_count=$_POST["post_excerpt_count"];
		$display_post_category=$_POST["display_post_category"];
		$post_category_style=$_POST["post_category_style"];
		$featured_image_type=$_POST["featured_image_type"];
		
		$display_thumbnail=$_POST["display_thumbnail"];
		$thumbnail=$_POST["thumbnail"];
		$thumbnail_car=$_POST["thumbnail_car"];
		
		$display_button = $_POST['display_button'];
		$button_style = $_POST['button_style'];
		$before_after = $_POST['before_after'];
		$button_text = $_POST['button_text'];
		$button_icon_style = $_POST['button_icon_style'];
		$button_icon = $_POST['button_icon'];
		$button_icons_mind = $_POST['button_icons_mind'];
		$skin_template = $_POST['skin_template'];
		$dynamic_template =explode(",",$skin_template);
		$display_product=$_POST["display_product"];
		$display_catagory=$_POST["display_catagory"];
		$display_rating=$_POST["display_rating"];
		$dcb_single_product=$_POST["dcb_single_product"];
		$dcb_variation_product=$_POST["dcb_variation_product"];
			
		$desktop_class=$tablet_class=$mobile_class='';
		if($layout!='carousel' && $layout!='metro'){
			$desktop_class='tp-col tp-col-lg-'.esc_attr($desktop_column);
			$tablet_class='tp-col-md-'.esc_attr($tablet_column);
			$mobile_class='tp-col-sm-'.esc_attr($mobile_column);
		}
		
		$j=1;
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $post_load_more,
			$texonomy_category => $category,
			'offset' => $offset,
			'orderby'	=>$order_by,
			'post_status' =>'publish',
			'order'	=>$post_order
		);
		
		if('' !== $ex_tag){
			$ex_tag =explode(",",$ex_tag);
			$args['tag__not_in'] = $ex_tag;
		}
		if('' !== $ex_cat){
			$ex_cat =explode(",",$ex_cat);
			$args['category__not_in'] = $ex_cat;
		}
		
		if(!empty($display_product) && $display_product=='featured'){
			$args['tax_query']     = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
				),
			);
		}
		
		if(!empty($display_product) && $display_product=='on_sale'){
			$args['meta_query']     = array(
				'relation' => 'OR',
				array( // Simple products type
					'key'           => '_sale_price',
					'value'         => 0,
					'compare'       => '>',
					'type'          => 'numeric'
				),
				array( // Variable products type
					'key'           => '_min_variation_sale_price',
					'value'         => 0,
					'compare'       => '>',
					'type'          => 'numeric'
				)
			);
		}
		
		if(!empty($display_product) && $display_product=='top_sales'){
			$args['meta_query']     = array(
				array(
					'key' 		=> 'total_sales',
					'value' 	=> 0,
					'compare' 	=> '>',
					)
			);
		}
		
		if(!empty($display_product) && $display_product=='instock'){
			$args['meta_query']     = array(
				array(
					'key' 		=> '_stock_status',
					'value' 	=> 'instock',												
				)
			);
		}
		
		if(!empty($display_product) && $display_product=='outofstock'){
			$args['meta_query']     = array(
				array(
					'key' 		=> '_stock_status',
					'value' 	=> 'outofstock',												
				)
			);
		}
		
		if ( '' !== $post_tags && $post_type=='post') {
			$post_tags =explode(",",$post_tags);
			$args['tax_query'] = array(
			'relation' => 'AND',
				array(
					'taxonomy'         => 'post_tag',
					'terms'            => $post_tags,
					'field'            => 'term_id',
					'operator'         => 'IN',
					'include_children' => true,
				),
			);
		}
		if('' !== $post_authors && $post_type=='post'){
			$args['author'] = $post_authors;
		}
		
		$ji=($post_load_more*$paged)-$post_load_more+$display_post+1;
		$ij='';
		$tablet_metro_class=$tablet_ij='';
		$loop = new WP_Query($args);		
			if ( $loop->have_posts() ) :
				while ($loop->have_posts()) {
					$loop->the_post();
					
					//read more button
					$the_button='';
					if($display_button == 'yes'){
						
						$btn_uid=uniqid('btn');
						$data_class= $btn_uid;
						$data_class .=' button-'.$button_style.' ';
						
						$the_button ='<div class="pt-plus-button-wrapper">';
							$the_button .='<div class="button_parallax">';
								$the_button .='<div class="ts-button">';
									$the_button .='<div class="pt_plus_button '.$data_class.'">';
										$the_button .= '<div class="animted-content-inner">';
											$the_button .='<a href="'.esc_url(get_the_permalink()).'" class="button-link-wrap" role="button" rel="nofollow">';
											$the_button .= include THEPLUS_PATH. 'includes/blog/post-button.php'; 
											$the_button .='</a>';
										$the_button .='</div>';
									$the_button .='</div>';
								$the_button .='</div>';
							$the_button .='</div>';
						$the_button .='</div>';	
					}
					
					
					if($post_load=='blogs'){
						include THEPLUS_PATH ."includes/ajax-load-post/blog-style.php";
					}
					if($post_load=='clients'){
						include THEPLUS_PATH ."includes/ajax-load-post/client-style.php";
					}
					if($post_load=='portfolios'){
						include THEPLUS_PATH ."includes/ajax-load-post/portfolio-style.php";
					}
					if($post_load=='products'){
						include THEPLUS_PATH ."includes/ajax-load-post/product-style.php";
					}
					if($post_load=='dynamiclisting'){
						$template_id='';
						if(!empty($dynamic_template)){
							$count=count($dynamic_template);
							$value = $offset%$count;
							$template_id=$dynamic_template[$value];	
						}
						include THEPLUS_PATH ."includes/ajax-load-post/dynamic-listing-style.php";
						$offset++;
					}
					$ji++;
				}
				$content = ob_get_contents();
				ob_end_clean();
			endif;
		wp_reset_postdata();
		echo $content;
		exit;
		ob_end_clean();
	}
add_action('wp_ajax_theplus_more_post','theplus_more_post_ajax');
add_action('wp_ajax_nopriv_theplus_more_post', 'theplus_more_post_ajax');

function get_current_ID($id){
	$newid = apply_filters( 'wpml_object_id', $id, 'elementor_library', TRUE  );
	return $newid ? $newid : $id;
}


function plus_acf_repeater_field_ajax(){
	$data = [];
	
	if(!empty($_REQUEST['post_id']) && isset($_REQUEST['post_id'])){
	$acf_fields = get_field_objects($_REQUEST['post_id']);
	
		if( $acf_fields ){
			foreach( $acf_fields as $field_name => $field ){
				if($field['type'] == 'repeater'){
					$data[] = [
					  'meta_id' => $field['name'],
					  'text' => $field['label']
					] ;
				}
			}
		}
	}
	wp_send_json_success($data);
}
add_action('wp_ajax_plus_acf_repeater_field','plus_acf_repeater_field_ajax');


function get_acf_repeater_field(){
	
	$data= [];
	if(class_exists('acf') && isset($_GET['post'])){
		$post_id = get_field('tp_preview_post',$_GET['post']);
		$acf_fields = get_field_objects($post_id);
		if( $acf_fields ){
			foreach( $acf_fields as $field_name => $field ){
				if($field['type'] == 'repeater'){
					$data[$field['name']] = $field['label'];
				}
			}
		}
	}
	return $data;
}

/*Wp login ajax*/
function theplus_ajax_login() {
	$email      = $_POST['email'];
	
	if(empty($email)){
		check_ajax_referer( 'ajax-login-nonce', 'security' );
	}

		$access_info = [];
		
		if(!empty($email)){
		
			$access_info['user_login']    = !empty($email) ? $email : "";
			
			$user = get_user_by("login", $email );
			if($user->ID && $user != "FALSE") {
				wp_set_auth_cookie($user->ID);
				echo wp_json_encode( ['loggedin' => true, 'message'=> esc_html__('Login successful, Redirecting...', 'theplus')] );
			}else {			
				echo wp_json_encode( ['loggedin' => false, 'message'=> esc_html__('Ops! Something wrong..!', 'theplus')] );
			}
		}else{
			$access_info['user_login']    = !empty($_POST['username']) ? $_POST['username'] : "";
			$access_info['user_password'] = !empty($_POST['password']) ? $_POST['password'] : "";
			$access_info['rememberme']    = true;
			$user = get_user_by("login", $access_info['user_login'] );
			$user_signon = wp_signon( $access_info, false );
			if ( !is_wp_error($user_signon) ){
				wp_set_auth_cookie($user->ID);
				echo wp_json_encode( ['loggedin' => true, 'message'=> esc_html__('Login successful, Redirecting...', 'theplus')] );
				} else {			
				echo wp_json_encode( ['loggedin' => false, 'message'=> esc_html__('Ops! Something wrong..!', 'theplus')] );
			}
		}
	    die();
}
add_action( 'wp_ajax_nopriv_theplus_ajax_login', 'theplus_ajax_login' );
/*Wp login ajax*/

/*Forgot Password*/
function theplus_ajax_forgot_password_ajax() {
	global $wpdb, $wp_hasher;
	
	$nonce = $_POST['nonce'];
	
	if ( ! wp_verify_nonce( $nonce, 'tp_user_lost_password_action' ) )
        die ( 'Security checked!');
		
	$user_login = $_POST['user_login'];
	
	$errors = new WP_Error();
 
    if ( empty( $_POST['user_login'] ) || ! is_string( $_POST['user_login'] ) ) {        
		echo wp_json_encode( [ 'lost_pass'=>'empty_username', 'message'=> sprintf(__( '<strong>ERROR</strong>: Enter a username or email address.','theplus' )) ] );
		exit;
    } elseif ( strpos( $_POST['user_login'], '@' ) ) {
        $user_data = get_user_by( 'email', trim( wp_unslash( $_POST['user_login'] ) ) );
        if ( empty( $user_data ) ) {          
			echo wp_json_encode( [ 'lost_pass'=>'invalid_email', 'message'=> sprintf(__( '<strong>ERROR</strong>: There is no account with that username or email address.','theplus' )) ] );
			exit;
        }
    } else {
        $login     = trim( $_POST['user_login'] );
        $user_data = get_user_by( 'login', $login );
		if ( ! $user_data ) {			
			echo wp_json_encode( [ 'lost_pass'=>'invalidcombo', 'message'=> sprintf(__( '<strong>ERROR</strong>: There is no account with that username or email address.','theplus' )) ] );
			exit;
		}
    }
 
    do_action( 'lostpassword_post', $errors );

    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
    $key        = get_password_reset_key( $user_data );

    if ( is_wp_error( $key ) ) {
		return $key;
    }

    if ( is_multisite() ) {
		$site_name = get_network()->site_name;
    } else {
		$site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}

	$message = esc_html__( 'Someone has requested a password reset for the following account:','theplus' ) . "\r\n\r\n";

    $message .= sprintf( esc_html__( 'Site Name: %s','theplus' ), $site_name ) . "\r\n\r\n";

    $message .= sprintf( esc_html__( 'Username: %s','theplus' ), $user_login ) . "\r\n\r\n";
    $message .= esc_html__( 'If this was a mistake, just ignore this email and nothing will happen.','theplus' ) . "\r\n\r\n";
    $message .= esc_html__( 'To reset your password, visit the following address:','theplus' ) . "\r\n\r\n";
    
	$reset_url = $_POST["resetpageurl"];
	$forgot_url = $_POST["forgotpageurl"];
	if(!empty($_POST["f_p_opt"]) && $_POST["f_p_opt"]=='default'){		
		$message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n";		
	}else if(!empty($_POST["f_p_opt"]) && $_POST["f_p_opt"]=='f_p_frontend'){		
		$message .= '<' . network_site_url( "wp-login.php?action=theplusrp&key=$key&redirecturl=$reset_url&forgoturl=$forgot_url&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n";
	}

	$title = sprintf( esc_html__( '[%s] Password Reset','theplus' ), $site_name );

	$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

	$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

	if ( wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
		echo wp_json_encode( [ 'lost_pass'=>'confirm', 'message'=> esc_html__('Check your e-mail for the reset password link.','theplus') ] );
	else
		echo wp_json_encode( [ 'lost_pass'=>'could_not_sent', 'message'=> esc_html__('The e-mail could not be sent.','theplus') . "<br />\n" . esc_html__('Possible reason: your host may have disabled the mail() function.','theplus') ] );

	exit;
}
add_action( 'wp_ajax_nopriv_theplus_ajax_forgot_password', 'theplus_ajax_forgot_password_ajax' );
add_action( 'wp_ajax_theplus_ajax_forgot_password', 'theplus_ajax_forgot_password_ajax' );
/*Forgot Password*/
/*reset password start*/
add_action( 'wp_ajax_nopriv_theplus_ajax_reset_password', 'theplus_ajax_reset_password_ajax' );
add_action( 'wp_ajax_theplus_ajax_reset_password', 'theplus_ajax_reset_password_ajax' );
function theplus_ajax_reset_password_ajax() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $user_login = $_REQUEST['user_login'];
        $user_key = $_REQUEST['user_key'];
 
        $user = check_password_reset_key( $user_key, $user_login );
 
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
			   echo wp_json_encode( [ 'reset_pass'=>'expire', 'message'=> esc_html__('The entered key has expired. Please start reset process again.','theplus') ] );
            } else {
				echo wp_json_encode( [ 'reset_pass'=>'invalid', 'message'=> esc_html__('The entered key is invalid. Please start reset process again.','theplus') ] );
            }
            exit;
        }
 
        if ( isset( $_POST['user_pass'] ) ) {
            if ( $_POST['user_pass'] != $_POST['user_pass_conf'] ) {                
				echo wp_json_encode( [ 'reset_pass'=>'mismatch', 'message'=> esc_html__('Password does not match. Please try again.','theplus') ] );
				exit;
            }
 
            if ( empty( $_POST['user_pass'] ) ) {                
                echo wp_json_encode( [ 'reset_pass'=>'empty', 'message'=> esc_html__('Password Field is Empty. Enter Password.
','theplus') ] );                
                exit;
            }
			
            reset_password( $user, $_POST['user_pass'] );
			
           echo wp_json_encode( [ 'reset_pass'=>'success', 'message'=> esc_html__('Your password has been changed. Use your new password to sign in.','theplus') ] );
		   
        } else {
            echo "Invalid request.";
        }
 
        exit;
    }
}

add_action( 'login_form_theplusrp','redirect_to_tp_custom_password_reset');
if(!empty($_REQUEST['forgoturl'])){
	add_action( 'login_form_resetpass','redirect_to_tp_custom_password_reset' );	
}

function redirect_to_tp_custom_password_reset() {
		
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        // Verify key / login combo
		 
        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );		
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
				$redirect_url = $_REQUEST['forgoturl'];
				$redirect_url = add_query_arg( 'expired', 'expired', $redirect_url );
				wp_redirect($redirect_url);
            } else {
				$redirect_url = $_REQUEST['forgoturl'];
				$redirect_url = add_query_arg( 'invalid', 'invalid', $redirect_url );
				wp_redirect($redirect_url);
            }
            exit;
        }
		if(!empty($_REQUEST['redirecturl'])){
			
			$redirect_url = $_REQUEST['redirecturl'];
			$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
			$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );
			$redirect_url = add_query_arg( 'action', 'theplusrpf', $redirect_url );
			$redirect_url = add_query_arg( 'forgoturl', $_REQUEST['forgoturl'], $redirect_url );
			wp_redirect($redirect_url);
		}else{
			wp_redirect(home_url());
		}
        exit;
    }
}
/*reset password end*/

function theplus_ajax_register_user( $email='', $first_name='', $last_name='' ) {
	    $errors = new \WP_Error();
		$result    = '';
	    if ( ! is_email( $email ) ) {
	        $errors->add( 'email', esc_html__( 'The email address you entered is not valid.', 'theplus' ) );
	        return $errors;
	    }
	 
	    if ( username_exists( $email ) || email_exists( $email ) ) {
	        $errors->add( 'email_exists', esc_html__( 'An account exists with this email address.', 'theplus' ) );
	        return $errors;
	    }
		
	    if(!empty($_POST["dis_password"]) && $_POST["dis_password"]=='yes'){			
			if($_POST['password'] == $_POST['conf_password']){	
				$password = $_POST['password'];
			}else{
				$errors->add( 'pass_mismatch', esc_html__( 'Password & Conform Password Not Match!', 'theplus' ) );
				return $errors;
			}
		}else{
			$password = wp_generate_password( 12, false );
		}
	 
	    $user_data = array(
	        'user_login'    => $email,
	        'user_email'    => $email,
	        'user_pass'     => $password,
	        'first_name'    => $first_name,
	        'last_name'     => $last_name,
	        'nickname'      => $first_name,
	    );
	 
	    $user_id = wp_insert_user( $user_data );
		if(!empty($_POST["dis_password"]) && $_POST["dis_password"]=='no'){
			wp_new_user_notification( $user_id, null, 'both' );
		}
		$tp_user_role='subscriber';		
		if(!empty($_POST["tp_user_reg_role"])){
			$tp_user_role = $_POST["tp_user_reg_role"];
		}
		wp_update_user( array ('ID' => $user_id, 'role' => $tp_user_role) ) ;
	    return $user_id;
}

add_action( 'wp_ajax_nopriv_theplus_ajax_register', 'theplus_ajax_register' );
function theplus_ajax_register() {
	
	if(!isset($_POST['nonce']) || empty($_POST['nonce'])){
		check_ajax_referer( 'ajax-login-nonce', 'security' );
	}else if(!empty($_POST['nonce'])){
		check_ajax_referer( 'ajax-login-nonce', 'security', false);		
	}
	
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) { 
		if ( ! get_option( 'users_can_register' ) ) {
			echo wp_json_encode( ['registered'=>false, 'message'=> esc_html__( 'Registering new users is currently not allowed.', 'theplus' )] );
		} else {
			$email      = $_POST['email'];
			$first_name = sanitize_text_field( $_POST['first_name'] );
			$last_name  = sanitize_text_field( $_POST['last_name'] );
			
			$captcha = $_POST["token"];
			$dis_cap = $_POST["dis_cap"];
			$dis_mail_chimp = $_POST["dis_mail_chimp"];
			$mail_chimp_check = $_POST["mail_chimp_check"];
			$auto_loggedin = $_POST["auto_loggedin"];
			
			if(!empty($dis_cap) && $dis_cap=='yes'){
				if(!$captcha){
					$message = sprintf(__( 'Please check the the captcha form.', 'theplus' ), get_bloginfo( 'name' ) );
					echo wp_json_encode( ['registered' => false, 'message'=> $message] );					
					exit;
				}
			}
			$check_recaptcha= get_option( 'theplus_api_connection_data' );
			$resscore='';
			$check_captcha = false;
			if( !empty($dis_cap) && $dis_cap=='yes' && !empty($check_recaptcha['theplus_secret_key_recaptcha']) && !empty($captcha) ){
				$secretKey = $check_recaptcha['theplus_secret_key_recaptcha'];
				$ip = $_SERVER['REMOTE_ADDR'];
				
				$url = 'https://www.google.com/recaptcha/api/siteverify';
				$data = array('secret' => $secretKey, 'response' => $captcha);
				
				$options = array(
					'http' => array(
					  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					  'method'  => 'POST',
					  'content' => http_build_query($data)
					)
				  );
				  
				  
				$context  = stream_context_create($options);
				$response = file_get_contents($url, false, $context);
				$responseKeys = json_decode($response,true);
				$resscore=$responseKeys["score"];
				$check_captcha = true;
				if(!$responseKeys['success']){
					$message = sprintf(__( 'Please check the the reCaptcha form.', 'theplus' ), get_bloginfo( 'name' ) );
					echo wp_json_encode( ['registered' => false, 'message'=> $message, 'recaptcha' => false ] );
					exit;
				}
			}
			
			$result     = theplus_ajax_register_user( $email, $first_name, $last_name );

			if ( is_wp_error( $result ) ) {
				// Parse errors into a string and append as parameter to redirect
				$errors  = $result->get_error_message();
				echo wp_json_encode( ['registered' => false, 'message'=> $errors ] );
			} else {
				// Success
				$message = sprintf(__( 'You have successfully registered to %s. We have emailed your password to the email address you entered.', 'theplus' ), get_bloginfo( 'name' ) );
				$response = ['registered' => true, 'message'=> $message, 'recaptcha' => $check_captcha, 'recaptcha_score' => $resscore ];
				
				//mailchimp subscriber user
				
				if((!empty($dis_mail_chimp) && $dis_mail_chimp=='yes') && (!empty($mail_chimp_check) && $mail_chimp_check=='yes')){
					$sep_cust_mail_chimp_apikey = isset($_POST["mc_custom_apikey"]) ? $_POST["mc_custom_apikey"] : '';
					$sep_cust_mail_chimp_listid = isset($_POST["mc_custom_listid"]) ? $_POST["mc_custom_listid"] : '';
					plus_mailchimp_subscribe_using_lr($email, $first_name, $last_name,$dis_mail_chimp,$sep_cust_mail_chimp_apikey,$sep_cust_mail_chimp_listid);
				}
				
				if((!empty($auto_loggedin) && $auto_loggedin==true)){
					$access_info = [];
					$access_info['user_login']    = !empty($email) ? $email : "";
					$access_info['user_password'] = !empty($_POST['password']) ? $_POST['password'] : "";
					$access_info['rememberme']    = true;
					$user_signon = wp_signon( $access_info, false );
					if ( !is_wp_error($user_signon) ){				
						$response = ['registered' => true, 'message'=> esc_html__('Login successful, Redirecting...', 'theplus')];
					} else {			
						$response = ['registered' => false, 'message'=> esc_html__('Registered Successfully, Ops! Login Failed...!', 'theplus')];
					}
				}
				echo wp_json_encode($response);
			}
		}

		exit;
	}
}

function plus_mailchimp_subscribe_using_lr($email='', $first_name='', $last_name='',$dis_mail_chimp='',$sep_cust_mail_chimp_apikey='',$sep_cust_mail_chimp_listid=''){
	
		
	$list_id=$api_key='';
	if($dis_mail_chimp=='yes' && (!empty($sep_cust_mail_chimp_apikey) && !empty($sep_cust_mail_chimp_listid))){
		$api_key = $sep_cust_mail_chimp_apikey;
		$list_id = $sep_cust_mail_chimp_listid;		
	}else{
		$options = get_option( 'theplus_api_connection_data' );
		$list_id = (!empty($options['theplus_mailchimp_id'])) ? $options['theplus_mailchimp_id'] : '';
		$api_key = (!empty($options['theplus_mailchimp_api'])) ? $options['theplus_mailchimp_api'] : '';
	}	
	$result = json_decode( theplus_mailchimp_subscriber_message($email, 'subscribed', $list_id, $api_key, array('FNAME' => $first_name,'LNAME' => $last_name) ) );	
}

/*Google Login Start*/
add_action( 'wp_ajax_nopriv_theplus_google_ajax_register', 'theplus_google_ajax_register' );
function theplus_google_ajax_register() {
	
	if(!isset($_POST['nonce']) || empty($_POST['nonce'])){
		check_ajax_referer( 'ajax-login-nonce', 'security' );
	}else if(!empty($_POST['nonce'])){
		check_ajax_referer( 'ajax-login-nonce', 'security', false);		
	}
	
	$response  = array();
	$user_data = array();
	$result    = '';
	$response['loggedin'] = false;
	$response['message'] = 'Invalid User.';
	if ( isset( $_POST['email'] ) ) {

		$name       = isset( $_POST['name'] ) ? $_POST['name'] : '';
		$email      = isset( $_POST['email'] ) ? $_POST['email'] : '';

		$user_data = get_user_by( 'login', $email );
		
		if ( ! empty( $user_data ) && false !== $user_data ) {
			$user_ID    = $user_data->ID;
			wp_set_auth_cookie( $user_ID );
			wp_set_current_user( $user_ID, $name );
			do_action( 'wp_login', $user_data->user_login, $user_data );
			$message = sprintf(__( 'Successfully Logged In...', 'theplus' ), get_bloginfo( 'name' ) );
			$response['loggedin'] = true;
			$response['message'] = $message;
		} else {
			
			$result  = theplus_ajax_register_user( $email, $name );
			
			if ( is_wp_error( $result ) ) {
				$errors  = $result->get_error_message();
				$response['loggedin'] = false;
				$response['message'] = $errors;
			} else {
				$user_data = get_user_by( 'email', $email );
				if ( $user_data ) {
					$user_ID    = $user_data->ID;

					if ( $user_ID ) {
						wp_set_auth_cookie( $user_ID );
						wp_set_current_user( $user_ID, $name );
						do_action( 'wp_login', $user_data->user_login, $user_data );

						$message = sprintf(__( 'Successfully Logged In...', 'theplus' ), get_bloginfo( 'name' ) );
						$response['loggedin'] = true;
						$response['message'] = $message;
					}
				}
			}
			
		}
		echo wp_json_encode( $response );
		die;
	} else {
		echo wp_json_encode( $response );
		die;
	}
}
/*google login end*/

function theplus_load_metro_style_layout($columns='1',$metro_column='3',$metro_style='style-1'){
	$i=($columns!='') ? $columns : 1;
	if(!empty($metro_column)){
		//style-3
		if($metro_column=='3' && $metro_style=='style-1'){
			$i=($i<=10) ? $i : ($i%10);			
		}
		if($metro_column=='3' && $metro_style=='style-2'){
			$i=($i<=9) ? $i : ($i%9);			
		}
		if($metro_column=='3' && $metro_style=='style-3'){
			$i=($i<=15) ? $i : ($i%15);			
		}
		if($metro_column=='3' && $metro_style=='style-4'){
			$i=($i<=8) ? $i : ($i%8);			
		}
		//style-4
		if($metro_column=='4' && $metro_style=='style-1'){
			$i=($i<=12) ? $i : ($i%12);			
		}
		if($metro_column=='4' && $metro_style=='style-2'){
			$i=($i<=14) ? $i : ($i%14);			
		}
		if($metro_column=='4' && $metro_style=='style-3'){
			$i=($i<=12) ? $i : ($i%12);			
		}
		//style-5
		if($metro_column=='5' && $metro_style=='style-1'){
			$i=($i<=18) ? $i : ($i%18);			
		}
		//style-6
		if($metro_column=='6' && $metro_style=='style-1'){
			$i=($i<=16) ? $i : ($i%16);			
		}
	}
	return $i;
}

function theplus_key_notice_ajax(){
	if ( get_option( 'theplus-notice-dismissed' ) !== false ) {
		update_option( 'theplus-notice-dismissed', '1' );
	} else {
		$deprecated = null;
		$autoload = 'no';
		add_option( 'theplus-notice-dismissed','1', $deprecated, $autoload );
	}
}
add_action('wp_ajax_theplus_key_notice','theplus_key_notice_ajax');
	
//post pagination
function theplus_pagination($pages = '', $range = 2)
	{  
		$showitems = ($range * 2)+1;  
		
		global $paged;
		if(empty($paged)) $paged = 1;
		
		if($pages == '')
		{
			global $wp_query;
			if( $wp_query->max_num_pages <= 1 )
			return;
			
			$pages = $wp_query->max_num_pages;
			/*if(!$pages)
			{
				$pages = 1;
			}*/
			$pages = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		}   
		
		if(1 != $pages)
		{
			$paginate ="<div class=\"theplus-pagination\">";
			if ( get_previous_posts_link() ){
				$paginate .= '<div class="paginate-prev">'.get_previous_posts_link('<i class="fa fa-long-arrow-left" aria-hidden="true"></i> PREV').'</div>';
			}
			
			for ($i=1; $i <= $pages; $i++)
			{
				if (1 != $pages && ( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				{
					$paginate .= ($paged == $i)? "<span class=\"current\">".esc_html($i)."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".esc_html($i)."</a>";
				}
			}
			if ( get_next_posts_link() ){
				$paginate .='<div class="paginate-next">'.get_next_posts_link('NEXT <i class="fa fa-long-arrow-right" aria-hidden="true"></i>',1).'</div>';
			}
			
			$paginate .="</div>\n";
			return $paginate;
		}
}

function theplus_mailchimp_subscriber_message( $email, $status, $list_id, $api_key, $merge_fields = array() ){

    $data = array(
        'apikey'        => $api_key,
        'email_address' => $email,
        'status'        => $status,
    );
	
	if(!empty($merge_fields)){
		$data['merge_fields'] = $merge_fields;
	}
	
    $mch_api = curl_init();
 
    curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
    curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
    curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
    curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch_api, CURLOPT_POST, true);
    curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
 
    $result = curl_exec($mch_api);
    return $result;
}
function plus_mailchimp_subscribe(){
	$options = get_option( 'theplus_api_connection_data' );
	$list_id = (!empty($options['theplus_mailchimp_id'])) ? $options['theplus_mailchimp_id'] : '';
	$api_key = (!empty($options['theplus_mailchimp_api'])) ? $options['theplus_mailchimp_api'] : ''; // YOUR MAILCHIMP API KEY HERE
	
	$FNAME=$LNAME=$BIRTHDAY=$PHONE='';	
	$chimp_field = array();
	if(!empty($_POST['FNAME'])){
		$FNAME=$_POST['FNAME'];
		$chimp_field['FNAME'] =$FNAME;
	}
	if(!empty($_POST['LNAME'])){
		$LNAME=$_POST['LNAME'];
		$chimp_field['LNAME'] =$LNAME;
	}
	if(!empty($_POST['BIRTHDAY']) && !empty($_POST['BIRTHMONTH'])){
		$BIRTHDAY = $_POST['BIRTHMONTH'] . '/' . $_POST['BIRTHDAY'];
		$chimp_field['BIRTHDAY'] =$BIRTHDAY;
	}
	if(!empty($_POST['PHONE'])){
		$PHONE=$_POST['PHONE'];
		$chimp_field['PHONE'] =$PHONE;
	}
	$result = json_decode( theplus_mailchimp_subscriber_message($_POST['email'], 'subscribed', $list_id, $api_key, $chimp_field ) );
	
	if( $result->status == 400 ){
		echo 'incorrect';
	} elseif( $result->status == 'subscribed' ){
		echo 'correct';
	} else {
		echo 'not-verify';
	}
	die;
}
add_action('wp_ajax_plus_mailchimp_subscribe','plus_mailchimp_subscribe');
add_action('wp_ajax_nopriv_plus_mailchimp_subscribe', 'plus_mailchimp_subscribe');

if(!function_exists('theplus_api_check_license')){
	function theplus_api_check_license($tp_api_key='',$home_url='',$check_license='') {
		$store_url = 'https://store.theplusaddons.com';
		$item_name = 'The Plus Addons for Elementor';
		$option_name = 'theplus_verified';
		$license_action = (!empty($check_license)) ? $check_license : 'activate_license';
		$api_params = array(
			'edd_action' => $license_action,
			'license' => 'B5E0B5F8DD8689E6ACA49DD6E6E1A930',
			'item_name' => urlencode( $item_name ),
			'url' => $home_url
		);
		
		$response = 200;
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		$expire_date='lifetime';
		$verify = '1' ;
		theplus_check_api_options('theplus_verified',$verify,$expire);
			
	}
}

if(!function_exists('theplus_api_check_license_code')){
	function theplus_api_check_license_code($tp_api_key='',$generate_key='') {
		
			$get_url='https://store.theplusaddons.com/theplus-verify/';
			$method='verify';
			$get_url=$get_url.'?url=verify_api/'.$method.'/'.$tp_api_key.'/'.$generate_key;
			$response = 200;
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			$option_name = 'theplus_verified';
			$expire='lifetime';
			$verify = '1' ;
			theplus_check_api_options('theplus_verified',$verify,$expire);
	
	}
}

if(!function_exists('plus_simple_crypt')){
	function plus_simple_crypt( $string, $action = 'dy' ) {
	    $secret_key = 'PO$_key';
	    $secret_iv = 'PO$_iv';
	    $output = false;
	    $encrypt_method = "AES-128-CBC";
	    $key = hash( 'sha256', $secret_key );
	    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	 
	    if( $action == 'ey' ) {
	        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
	    }
	    else if( $action == 'dy' ){
	        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
	    }
	 
	    return $output;
	}
}

function theplus_check_api_options($option_name,$verify,$expire=''){
	
		
		$value=array(
			 'verify'=>'1',
			 'expire'=>'lifetime',
		 );
		
		
		update_option( $option_name, $value );
		
	
}

if(!function_exists('theplus_check_api_status')){
	function theplus_check_api_status() {
		$option_name = 'theplus_verified';
		$values=get_option( $option_name );
		$expired='lifetime';
		$verify=1;
		$today_date = strtotime("today midnight");
			
		if($expired!='lifetime' && $today_date >= $expired ){
			return false;
		}else if($verify==1){
			return true;
		}else{
			return false;
		}
	}
}

function check_expired_date_key() {
	$option_name = 'theplus_verified';
	
	$values=get_option( $option_name );
	$expired='lifetime';
	$verify=$values["verify"];
	$today_date = strtotime("today midnight");
	
		if($expired!='lifetime' && $today_date >= $expired ){
			$verify=0;$expire='';
			theplus_check_api_options($option_name,$verify,$expire);
		}
}
add_action( 'admin_init', 'check_expired_date_key', 1 );

if ( !class_exists( 'Theplus_BodyMovin' ) ) {
	class Theplus_BodyMovin {
		public static $animations = array();

		function __construct() {
			add_action( 'wp_footer', array( $this, 'plus_animation_data' ), 5 );			
		}

		public static function plus_addAnimation( $animation = array() ) {
			
			if ( empty( $animation ) || empty( $animation['id'] ) ) {
				return false;
			}
			
			self::$animations[$animation['container_id']] = $animation;
		}
		public static function plus_getAnimations() {
			return apply_filters( 'wpbdmv-animations', self::$animations );
		}

		public static function plus_hasAnimations() {
			$animations = self::plus_getAnimations();
			return empty( $animations ) ? false : true;
		}

		function plus_animation_data() {
			if ( !self::plus_hasAnimations() ) {
				return;
			}
			wp_localize_script( 'theplus-bodymovin', 'wpbodymovin', array(
				'animations' => self::plus_getAnimations(),
				'ajaxurl'    => admin_url( 'admin-ajax.php' )
			) );
		}

	}
	$Theplus_BodyMovin = new Theplus_BodyMovin;
}

//Woocommerce Products
if(class_exists('woocommerce')) {
function theplus_out_of_stock() {
  global $post;
  $id = $post->ID;
  $status = get_post_meta($id, '_stock_status',true);
  
  if ($status == 'outofstock') {
  	return true;
  } else {
  	return false;
  }
}
function theplus_product_badge() {
 global $post, $product;
 	if (theplus_out_of_stock()) {
		echo '<span class="badge out-of-stock">' . esc_html__( 'Out of Stock', 'theplus' ) . '</span>';
	} else if ( $product->is_on_sale() ) {
		if ('discount' == 'discount') {
			if ($product->get_type() == 'variable') {
				$available_variations = $product->get_available_variations();								
				$maximumper = 0;
				for ($i = 0; $i < count($available_variations); ++$i) {
					$variation_id=$available_variations[$i]['variation_id'];
					$variable_product1= new WC_Product_Variation( $variation_id );
					$regular_price = $variable_product1->get_regular_price();
					$sales_price = $variable_product1->get_sale_price();
					$percentage = $sales_price ? round( ( ( $regular_price - $sales_price ) / $regular_price ) * 100) : 0;
					if ($percentage > $maximumper) {
						$maximumper = $percentage;
					}
				}
				echo apply_filters('woocommerce_sale_flash', '<span class="badge onsale perc">&darr; '.$maximumper.'%</span>', $post, $product);
			} else if ($product->get_type() == 'simple'){
				$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
				echo apply_filters('woocommerce_sale_flash', '<span class="badge onsale perc">&darr; '.$percentage.'%</span>', $post, $product);
			} else if ($product->get_type() == 'external'){
				$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
				echo apply_filters('woocommerce_sale_flash', '<span class="badge onsale perc">&darr; '.$percentage.'%</span>', $post, $product);
			}
		} else {
			echo apply_filters('woocommerce_sale_flash', '<span class="badge onsale">'.esc_html__( 'Sale','theplus' ).'</span>', $post, $product);
		}
	}
}
add_action( 'theplus_product_badge', 'theplus_product_badge',3 );

function plus_filter_woocommerce_sale_flash( $output_html, $post, $product ) { 
	if ($product->get_type() == 'variable') {
		$available_variations = $product->get_available_variations();								
		$maximumper = 0;
		for ($i = 0; $i < count($available_variations); ++$i) {
			$variation_id=$available_variations[$i]['variation_id'];
			$variable_product1= new WC_Product_Variation( $variation_id );
			$regular_price = $variable_product1->get_regular_price();
			$sales_price = $variable_product1->get_sale_price();
			$percentage = $sales_price ? round( ( ( $regular_price - $sales_price ) / $regular_price ) * 100) : 0;
			if ($percentage > $maximumper) {
				$maximumper = $percentage;
			}
		}
		$output_html = '<span class="badge onsale perc">&darr; '.$maximumper.'%</span>';
	} else if ($product->get_type() == 'simple'){
		$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
		$output_html = '<span class="badge onsale perc">&darr; '.$percentage.'%</span>';
	} else if ($product->get_type() == 'external'){
		$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
		$output_html = '<span class="badge onsale perc">&darr; '.$percentage.'%</span>';
	}else {
		$output_html = '<span class="badge onsale">'.esc_html__( 'Sale','theplus' ).'</span>';
	}
    return $output_html;
}; 

add_filter( 'woocommerce_sale_flash', 'plus_filter_woocommerce_sale_flash', 11, 3 );

}


add_action('elementor/widgets/widgets_registered', function($widgets_manager){
  $elementor_widget_blacklist = [
  'plus-elementor-widget',
];

  foreach($elementor_widget_blacklist as $widget_name){
    $widgets_manager->unregister_widget_type($widget_name);
  }
}, 15);

function registered_widgets(){
	// widgets class map
	return apply_filters('theplus/registered_widgets', [
		
		'tp-adv-text-block' => [
			'dependency' => [],
		],
		'tp-advanced-typography' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/adv-typography/plus-adv-typography.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/circletype.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/adv-typography/plus-adv-typography.min.js',
				],
			],
		],
		'tp-advanced-buttons' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/advanced-buttons/plus-advanced-buttons.min.css',
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/advanced-buttons/plus-advanced-buttons.min.js',
				],
			],
		],
		'tp_advertisement_banner' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/addbanner/plus-addbanner.min.css',
				],
			],
		],
		'tp-accordion' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/tabs-tours/plus-tabs-tours.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/accordion/plus-accordion.min.js',
				],
			],
		],
		'tp-animated-service-boxes' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/animated-service-box/plus-animated-service-boxes.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/animated-service-box/plus-service-box.min.js',
				],
			],
		],
		'tp-audio-player' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/audio-player/plus-audio-player.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/audio-player/plus-audio-player.min.js',					
				],
			],
		],
		'tp-before-after' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/before-after/plus-before-after.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/before-after/plus-before-after.min.js',
				],
			],
		],
		'tp-blockquote' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/block-quote/plus-block-quote.css',
				],
			],
		],
		'tp-blog-listout' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/blog-list/plus-blog-list.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-button-extra.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
				],
			],
		],
		'tp-dynamic-smart-showcase' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/dynamic-smart-showcase/plus-dynamic-smart-showcase.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/dynamic-smart-showcase/plus-dynamic-smart-showcase.min.js',					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/dynamic-smart-showcase/plus-bss-filter.min.js',
				],
			],
		],
		'tp-breadcrumbs-bar' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/breadcrumbs-bar/plus-breadcrumbs-bar.min.css',
				],				
			],
		],
		'plus-post-filter' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-post-filter.min.css',
				],
			],
		],
		'plus-pagination' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-pagination.css',
				],
			],
		],
		'plus-listing-metro' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagesloaded.pkgd.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/isotope.pkgd.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-metro-list.min.js',
				],
			],
		],
		'plus-listing-masonry' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagesloaded.pkgd.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/isotope.pkgd.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/packery-mode.pkgd.min.js',
				],
			],
		],
		'tp-button' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/plus-extra-adv/plus-button.min.css',
				],
			],
		],
		'tp-wp-bodymovin' => [
		],
		'tp-carousel-anything' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/slick.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-slick-carousel.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-carousel-anything.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/slick.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-slick-carousel.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/carousel-anything/plus-carousel-anything.min.js',
				],
			],
		],
		'tp-carousel-remote' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-carousel-remote.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/slick.min.js',					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/carousel-remote/plus-carousel-remote.min.js',
				],
			],
		],
		'tp-caldera-forms' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/forms-style/plus-caldera-form.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/forms-style/plus-caldera-form.js',
				],
			],
		],
		'tp-cascading-image' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/image-factory/plus-image-factory.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/cascading-image/plus-cascading-image.min.js',
				],
			],
		],
		'tp-circle-menu' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/circle-menu/plus-circle-menu.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/jquery.circlemenu.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/circle-menu/plus-circle-menu.min.js',
				],
			],
		],
		'tp-clients-listout' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/client-list/plus-client-list.css',					
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
				],
			],
		],
		'tp-contact-form-7' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/forms-style/plus-cf7-style.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/forms-style/plus-cf7-form.js',
				],
			],
		],
		'tp-dynamic-listing' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/dynamic-listing/plus-dynamic-listing.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-button-extra.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/dynamic-listing/plus-dynamic-listing.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
				],
			],
		],
		'tp-custom-field' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/custom-field/plus-custom-field.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/custom-field/plus-custom-field.min.js',					
				],
			],
		],
		'tp-countdown' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/countdown/plus-countdown.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/jquery.downCount.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/countdown/plus-countdown.min.js',
				],
			],
		],
		'tp-draw-svg' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/vivus.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/draw-svg/plus-draw-svg.min.js',
				],
			],
		],
		'tp-dynamic-device' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/extra/lity.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/dynamic-device/plus-dynamic-device.min.css',					
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/lity.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/dynamic-device/plus-dynamic-device.min.js',
				],
			],
		],
		'tp-everest-form' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/forms-style/plus-everest-form.css',
				],
			],
		],
		'tp-smooth-scroll' => [
			'dependency' => [
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/smooth-scroll.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/smooth-scroll/plus-smooth-scroll.min.js',
				],
			],
		],
		'tp-flip-box' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/info-box/plus-info-box.min.css',
				],
			],
		],
		
		'tp-gallery-listout' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/gallery-list/plus-gallery-list.min.css',					
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.hoverdir.js',					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
				],
			],
		],
		'tp-google-map' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/google-map/plus-gmap.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/google-map/plus-gmap.min.js',
				]
			],
		],
		'tp-gravityt-form' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/forms-style/plus-gravity-form.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/forms-style/plus-gravity-form.js',
				]
			],
		],		
		'tp-heading-animation' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/heading-animation/plus-heading-animation.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/heading-animation/plus-heading-animation.min.js',
				]
			],
		],
		'tp-header-extras' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/header-extras/plus-header-extras.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/buzz.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/header-extras/plus-header-extras.min.js',
				],
			],
		],
		'tp-heading-title' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/heading-title/plus-heading-title.min.css',
				],
			],
		],
		'tp-hotspot' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/extra/tippy.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/hotspot/plus-hotspot.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tippy.all.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/hotspot/plus-hotspot.min.js',
				],
			],
		],
		'tp-image-factory' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/image-factory/plus-image-factory.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/image-factory/plus-image-factory.min.js',
				],
			],
		],
		
		'tp-info-box' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/info-box/plus-info-box.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/info-box/plus-info-box.min.js',
				],
			],
		],
		'tp-instagram' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/tp-bootstrap-grid.css',					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-instafeed.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagesloaded.pkgd.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/isotope.pkgd.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/instafeed.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/instafeed/plus-instafeed.min.js',
				],
			],
		],
		'tp-mailchimp-subscribe' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/mailchimp/plus-mailchimp.css',
				],
			],
		],
		
		'tp-morphing-layouts' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/shape-morph/plus-shape-morph.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/scrollmonitor.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/anime.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/shape-morph/theplus-shape-morph.min.js',
				],
			],
		],
		'tp-navigation-menu' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/navigation-menu/plus-nav-menu.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/navigation-menu/plus-nav-menu.min.js',
				],
			],
		],
		'tp-ninja-form' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/forms-style/plus-ninja-form.css',
				],
			],
		],
		'tp-number-counter' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/number-counter/plus-number-counter.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/numscroller.js',
				],
			],
		],
		'tp-off-canvas' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/off-canvas/plus-off-canvas.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/offcanvas/plus-offcanvas.js',
				],
			],
		],
		'tp-page-scroll' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/page-scroll/plus-page-scroll.min.css',
				],
				'js'  => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/page-scroll/plus-page-scroll.min.js',
				],
			],
		],
		'tp-fullpage' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/fullpage.css',
				],
				'js'  => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/fullpage.js',
				],
			],
		],
		'tp-pagepiling' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/jquery.pagepiling.css',
				],
				'js'  => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/jquery.pagepiling.min.js',
				],
			],
		],
		'tp-multiscroll' => [
			'dependency' => [
				'js'  => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/jquery.multiscroll.min.js',
				],
			],
		],
		'tp-horizontal-scroll' => [
			'dependency' => [
				'js'  => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/jquery.jInvertScroll.min.js',
				],
			],
		],
		'tp-mobile-menu' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/mobile-menu/plus-mobile-menu.min.css',
				],
				'js'  => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/mobile-menu/plus-mobile-menu.min.js',
				],
			],
		],
		'tp-pricing-list' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/pricing-list/plus-pricing-list.min.css',
				],
			],
		],
		'tp-pricing-table' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/extra/tippy.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-button-extra.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/pricing-table/plus-pricing-table.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tippy.all.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/pricing-table/plus-pricing-table.min.js',
				],
			],
		],
		'tp-product-listout' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/product-list/plus-product-list.css',					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-button-extra.min.css',
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
				],
			],
		],
		'tp-protected-content' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-password-protected.css',
				],
			],
		],
		'tp-post-search' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/mailchimp/plus-mailchimp.css',
				],
			],
		],
		'tp-progress-bar' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/progress-piechart/plus-progress-piechart.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.waypoints.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/circle-progress.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/progress-bar/plus-progress-bar.min.js',
				],
			],
		],
		'tp-process-steps' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/process-steps/plus-process-steps.min.css',
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/process-steps/plus-process-steps.min.js',
				],
			],
		],
		'tp-row-background' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/row-background/plus-row-background.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/row-background/plus-row-background.min.js',
				],
			],
		],
		'plus-vegas-gallery' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/vegas.css',					
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/vegas.js',
				],
			],
		],
		'plus-row-animated-color' => [
			'dependency' => [
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/effect.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/row-background/plus-row-animate-color.js',
				],
			],
		],
		'plus-row-segmentation' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/anime.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagesloaded.pkgd.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/segmentation.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/row-background/plus-row-segmentation.min.js',
				],
			],
		],
		'plus-row-scroll-color' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/scrolling_background_color.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/scrollmonitor.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/row-background/plus-scroll-bg-color.min.js',
				],
			],
		],
		'plus-row-canvas-particle' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/particles.min.js',
				],
			],
		],
		'plus-row-canvas-particleground' => [
			'dependency' => [
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.particleground.js', //canvas style 6
				],
			],
		],
		'plus-row-canvas-8' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/row-background/plus-row-canvas-style-8.min.js',
				],
			],
		],
		
		'tp-scroll-navigation' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/scroll-navigation/plus-scroll-navigation.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/pagescroll2id.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/scroll-navigation/plus-scroll-navigation.min.js',
				],
			],
		],
		'tp-shape-divider' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/shape-divider/plus-shape-divider.min.css',
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/shape-divider/plus-shape-divider.min.js',
				],
			],
		],
		'tp-site-logo' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/site-logo/plus-site-logo.css',
				],		
			],
		],
		'tp-social-icon' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/social-icon/plus-social-icon.min.css',
				],				
			],
		],
		'tp-style-list' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/stylist-list/plus-style-list.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/stylist-list/plus-stylist-list.min.js',
				],
			],
		],
		'tp-switcher' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/switcher/plus-switcher.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/switcher/plus-switcher.min.js',
				],
			],
		],
		'tp-table' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-button-extra.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/data-table/plus-data-table.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/jquery.datatables.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/data-table/plus-data-table.min.js',
				],
			],
		],
		'tp-tabs-tours' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/tabs-tours/plus-tabs-tours.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/tabs-tours/plus-tabs-tours.min.js',
				],
			],
		],
		'tp-team-member-listout' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/team-member-list/plus-team-member.css',
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
				],
			],
		],
		'tp-testimonial-listout' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/slick.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-slick-carousel.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/testimonial/plus-testimonial.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagesloaded.pkgd.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/slick.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-slick-carousel.min.js',
				],
			],
		],
		'tp-timeline' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-button-extra.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/main/timeline/plus-timeline.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.waypoints.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/isotope.pkgd.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/packery-mode.pkgd.min.js',					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/velocity/velocity.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/velocity/velocity.ui.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-animation-load.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/timeline/plus-timeline.min.js',					
				],
			],
		],
		'tp-unfold' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/main/unfold/plus-unfold.min.css',
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/unfold/plus-unfold.min.js',
				],
			],
		],
		'tp-video-player' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/extra/lity.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/main/video-player/plus-video-player.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/lity.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/video-player/plus-video-player.min.js',
				],
			],
		],
		'tp-dynamic-categories' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/main/dynamic-categories/plus-dynamic-categories.min.css',
				],
			],
		],
		'tp-wp-forms' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/main/forms-style/plus-wpforms-form.css',
				],
			],
		],
		'tp-wp-login-register' => [
			'dependency' => [
				'css' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/main/wp-login-register/plus-wp-login-register.min.css',
				],
			],
		],
		'plus-velocity' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.waypoints.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/velocity/velocity.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/velocity/velocity.ui.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-animation-load.min.js',
				],
			],
		],
		'plus-magic-scroll' => [
			'dependency' => [
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tweenmax/timelinemax.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tweenmax/tweenmax.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/scrollmagic/scrollmagic.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/scrollmagic/animation.gsap.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-magic-scroll.min.js',
				],
			],
		],
		'plus-tooltip' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/extra/tippy.css',
				],
				'js' => [					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tippy.all.min.js',
				],
				],
		],
		'plus-mousemove-parallax' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tweenmax/tweenmax.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-mouse-move-parallax.min.js',
				],
			],
		],
		'plus-tilt-parallax' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tilt.jquery.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-tilt-parallax.min.js',
				],
			],
		],
		'plus-reveal-animation' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.waypoints.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-reveal-animation.min.js',
				],
			],
		],
		'plus-content-hover-effect' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/plus-extra-adv/plus-content-hover-effect.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/js/main/general/plus-content-hover-effect.min.js',
				],
			],
		],
		'plus-button' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/plus-extra-adv/plus-button.min.css',
				],
			],
		],
		'plus-button-extra' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-button-extra.min.css',
				],
			],
		],
		'plus-carousel' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/slick.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-slick-carousel.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/slick.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-slick-carousel.min.js',
				],
			],
		],
		'plus-imagesloaded' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagesloaded.pkgd.min.js',
				],
			],
		],
		'plus-isotope' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/isotope.pkgd.js',
				],
			],
		],
		'plus-hover3d' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.hover3d.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-hover-tilt.js',
				],
			],
		],
		'plus-wavify' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tweenmax/tweenmax.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/wavify.js',
				],
			],
		],
		'plus-lity-popup' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/extra/lity.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/lity.min.js',
				],
			],
		],
		'plus-extras-column' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/resizesensor.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/sticky-sidebar.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.jsticky.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/column-stickly/plus-column-stickly.min.js',
				],
			],
		],
		/*'plus-section-column-link' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/section-column-link/plus-section-column-link.min.js',
				],
			],
		],*/
		'plus-equal-height' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/equal-height/plus-equal-height.min.js',
				],
			],
		],
		'plus-column-cursor' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/main/mouse-cursor/plus-mouse-cursor.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/mouse-cursor/plus-mouse-cursor.min.js',
				],
			],
		],
		'plus-extras-section-skrollr' => [
			'dependency' => [
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/skrollr.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-section-skrollr.min.js',
				],
			],
		],
		'plus-adv-typo-extra-js-css' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/imagerevealbase.css',
				],
				'js' => [										
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/charming.min.js',					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagesloaded.pkgd.min.js',					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tweenmax/tweenmax.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagerevealdemo.js',
				],
			],
		],
		'plus-backend-editor' => [
			'dependency' => [
				'css' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/extra/tippy.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/plus-extra-adv/plus-button.min.css',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/plus-extra-adv/plus-content-hover-effect.min.css',
				],
				'js' => [
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.waypoints.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/general/modernizr.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/velocity/velocity.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/velocity/velocity.ui.js',					
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tilt.jquery.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tippy.all.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tweenmax/timelinemax.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tweenmax/tweenmax.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/tweenmax/jquery-parallax.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/scrollmagic/scrollmagic.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/scrollmagic/animation.gsap.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/plus-extra-adv/plus-backend-editor.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-animation-load.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-magic-scroll.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-mouse-move-parallax.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-reveal-animation.min.js',
					THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/js/main/general/plus-content-hover-effect.min.js',
				],
			],
		],
	]);
}