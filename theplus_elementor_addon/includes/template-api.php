<?php 
define( 'TP_PLUS_SL_STORE_URL', 'https://store.theplusaddons.com' );
define( 'TP_PLUS_SL_ITEM_ID', 28 );

if ( ! defined( 'ABSPATH' ) ) { exit; }

function plus_get_templates_library($category){
	
	if(!empty($category)){
		
		$data = array(
			'apikey'        => 'https://elementor.theplusaddons.com',
			'json' => 'wp-json',
			'version'        => 'v1',
			'template' => 'theplus',
			'category'  => $category
		);
		
		$url_api = $data["apikey"].'/'.$data["json"].'/'.$data["template"];
		
		$api_version = $url_api.'/'.$data["version"];
		
		$api_content_url =$api_version.'/'.$data["category"];
		
		$request = wp_remote_get( $api_content_url );
		
		if( is_wp_error( $request ) ) {
			return false;
		}
		
		$result = wp_remote_retrieve_body( $request );
		
		return $result;
		
	}else{
		return false;
	}
}
function theplus_template_library_content(){
	
	$template_library ='';
	
	$result  = plus_get_templates_library($_POST['category']);
	
	$json_content='';	
	if(!empty($result)){
	
		$json_content=json_decode($result,true);
	}
	
	if(!empty($json_content)){
	
		foreach ($json_content["content"] as $item) {
			$cate_item='';
			if(!empty($item['categories'])){
			
				foreach($category=$item['categories'] as $term){
					$cate_item .= $term["slug"].' ';
				}
			}
			if(!empty($item['template_type'])){
				$type= $item['template_type'];
			}else{
				$type= 'json';
			}
			$template_library .= '<div class="plus-template-library-template '.esc_attr($cate_item).'">';
				$template_library .= '<div class="template-library-inner-content">';
					$template_library .= '<div class="plus-template-library-template-body">';
						$template_library .= '<img src="'.esc_url($item['thumbnail']).'">';			
							$template_library .= '<div class="plus-template-library-template-download">';
								$template_library .= '<div class="overlay-library-template-inner">';
									$template_library .= '<div class="template-download" data-url="'.esc_attr($item['template_file']).'" data-type="'.esc_attr($type).'"><img src="'.THEPLUS_ASSETS_URL.'images/template-download.png" class="download-template"><img src="'.THEPLUS_ASSETS_URL.'images/lazy_load.gif" class="loading-template"></div>';
									$template_library .= '<a href="'.esc_url($item['demo_url']).'" target="_blank" class="template-demo-url" data-url="'.esc_attr__('accordion','theplus').'"><img src="'.THEPLUS_ASSETS_URL.'images/template-view.png"></a>';
								$template_library .= '</div>';
							$template_library .= '</div>';
					$template_library .= '</div>';
							
					$template_library .= '<div class="plus-template-library-template-footer">';
						$template_library .= '<div class="plus-template-title">'.esc_html($item['title']).'</div>';
					$template_library .= '</div>';
				$template_library .= '</div>';
			$template_library .= '</div>';
			}
		
		$widget_content='<div class="plus-sub-category-list">';
			$widget_content .='<ul class="sub-category-listing">';
				$widget_content .='<li class="active" data-filter="*">'.esc_html__('All','theplus').'</li>';
				foreach ($json_content["filter_category"] as $item) {
					$widget_content .='<li class="" data-filter="'.esc_attr($item['slug']).'">'.esc_html($item['name']).'</li>';
				}
			$widget_content .='</ul>';
		$widget_content .='</div>';
		$widget_content .='<div class="plus-template-container">';
			$widget_content .='<div class="plus-template-innner-content">';
				$widget_content .=$template_library;
			$widget_content .='</div>';
		$widget_content .='</div>';
		
		echo $widget_content;
	}
	
	die;
}
add_action('wp_ajax_plus_template_library_content','theplus_template_library_content');
add_action('wp_ajax_nopriv_plus_template_library_content', 'theplus_template_library_content');

function theplus_template_ajax(){
	if(!empty($_POST["widget_category"]) && !empty($_POST["template"])){
		$data = array(
			'apikey'        => 'https://elementor.theplusaddons.com',
			'json' => 'json',
			'template' => $_POST["template"],
			'category'  => $_POST["widget_category"],
			'file_type' => $_POST["file_type"]
		);
		$url_api = $data["apikey"].'/'.$data["json"].'/'.$data["category"];
		
		$api_content_url= $url_api.'/'.$data["template"].'.'.$data["file_type"];
		
		$request = wp_remote_get( $api_content_url );
		
		if(!empty($data['file_type']) && $data['file_type']=='zip'){
		
			if( is_wp_error( $request ) ) {
				return false;
			}
			$result = $api_content_url;
		}else{
		
			if( is_wp_error( $request ) ) {
				return false;
			}
			
			$result = wp_remote_retrieve_body( $request );
		}
		
		echo $result;
		
	}else{
		return false;
	}
	die;
}
add_action('wp_ajax_plus_template_ajax','theplus_template_ajax');
add_action('wp_ajax_nopriv_plus_template_ajax', 'theplus_template_ajax');


if(!function_exists('theplus_get_api_check')){
	function theplus_get_api_check($check_license ='') {
		
		
		$verify = '1' ;
			theplus_check_api_options('theplus_verified',$verify);
			return 'valid';
		
	}
}



if(!function_exists('theplus_message_display')){
	function theplus_message_display() {
		$check=theplus_get_api_check('check_license');
		
		if($check=='success_false'){
			echo '<div style="margin-bottom:40px;position: relative;display: inline-block;width: 100%;"><div style="margin-top: 10px;margin-left: 30px;margin-right: 30px;color: #a94442;background-color: #f2dede;border-color: #ebccd1;padding: 15px;border: 1px solid transparent;border-radius: 4px;"><strong>'.esc_html__('Ops 😒','theplus').'</strong> '.esc_html__('This Licence Key is invalid. Please try again.','theplus').'</div></div>';
		}else if($check=='expired'){
			echo '<div style="margin-bottom:40px;position: relative;display: inline-block;width: 100%;"><div style="margin-top: 10px;margin-left: 30px;margin-right: 30px;color: #a94442;background-color: #f2dede;border-color: #ebccd1;padding: 15px;border: 1px solid transparent;border-radius: 4px;"><strong>'.esc_html__('Licence key recently Expired 😵','theplus').'</strong> '.esc_html__('Please visit account to renew that.','theplus').'</div></div>';
		}else if($check=='valid'){
			echo '<div style="margin-bottom:40px;position: relative;display: inline-block;width: 100%;"><div  style="margin-top: 10px;margin-left: 30px;margin-right: 30px;color: #3c763d;background-color: #dff0d8;border-color: #d6e9c6;padding: 15px;border: 1px solid transparent;border-radius: 4px;"><strong>'.esc_html__('Cheers 🥳','theplus').'</strong> '.esc_html__('Your Elementor is supercharged with The Plus Addons now.','theplus').'</div></div>';
		}else if($check=='invalid'){
			echo '<div style="margin-bottom:40px;position: relative;display: inline-block;width: 100%;"><div style="margin-top: 10px;margin-left: 30px;margin-right: 30px;color: #a94442;background-color: #f2dede;border-color: #ebccd1;padding: 15px;border: 1px solid transparent;border-radius: 4px;"><strong>'.esc_html__('Ops 🤔','theplus').'</strong> '.esc_html__('Invalid Home URL. Please review and enter again in Licence Manager.','theplus').'</div></div>';
		}else{
			echo '<div style="margin-bottom:40px;position: relative;display: inline-block;width: 100%;"><div style="margin-top: 10px;margin-left: 30px;margin-right: 30px;color: #a94442;background-color: #f2dede;border-color: #ebccd1;padding: 15px;border: 1px solid transparent;border-radius: 4px;"><strong>'.esc_html__('Ops 😒','theplus').'</strong> '.esc_html__('This Licence Key is invalid. Please try again.','theplus').'</div></div>';
		}
	
	}
}
