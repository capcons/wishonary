<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

Class Plus_Library
{
	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */	
	private static $instance = null;
	
	public $registered_widgets;
    /**
     *  Return array of registered elements.
     *
     * @todo filter output
     */	 
    public function get_registered_widgets()
    {
        return array_keys($this->registered_widgets);
    }

    /**
     * Return saved settings
     *
     * @since 2.0
     */
    public function get_plus_widget_settings($element = null)
    {
		$replace = [
			'tp_smooth_scroll' => 'tp-smooth-scroll',
			'tp_accordion' => 'tp-accordion',
			'tp_adv_text_block' => 'tp-adv-text-block',
			'tp_advanced_typography' => 'tp-advanced-typography',
			'tp_advanced_buttons' => 'tp-advanced-buttons',
			'tp_animated_service_boxes' => 'tp-animated-service-boxes',
			'tp_advertisement_banner' => 'tp_advertisement_banner',
			'tp_audio_player' => 'tp-audio-player',
			'tp_before_after' => 'tp-before-after',
			'tp_blockquote' => 'tp-blockquote',
			'tp_blog_listout' => 'tp-blog-listout',
			'tp_dynamic_smart_showcase' => 'tp-dynamic-smart-showcase',
			'tp_breadcrumbs_bar' => 'tp-breadcrumbs-bar',
			'tp_button' => 'tp-button',
			'tp_carousel_anything' => 'tp-carousel-anything',
			'tp_carousel_remote' => 'tp-carousel-remote',
			'tp_caldera_forms' => 'tp-caldera-forms',
			'tp_cascading_image' => 'tp-cascading-image',
			'tp_circle_menu' => 'tp-circle-menu',
			'tp_clients_listout' => 'tp-clients-listout',
			'tp_contact_form_7' => 'tp-contact-form-7',
			'tp_countdown' => 'tp-countdown',
			'tp_draw_svg' => 'tp-draw-svg',
			'tp_dynamic_device' => 'tp-dynamic-device',
			'tp_dynamic_listing' => 'tp-dynamic-listing',			
			'tp_everest_form' => 'tp-everest-form',
			'tp_flip_box' => 'tp-flip-box',
			'tp_gallery_listout' => 'tp-gallery-listout',
			'tp_google_map' => 'tp-google-map',
			'tp_gravity_form' => 'tp-gravityt-form',			
			'tp_heading_animation' => 'tp-heading-animation',
			'tp_header_extras' => 'tp-header-extras',
			'tp_heading_title' => 'tp-heading-title',
			'tp_hotspot' => 'tp-hotspot',
			'tp_image_factory' => 'tp-image-factory',
			'tp_info_box' => 'tp-info-box',
			'tp_instagram' => 'tp-instagram',
			'tp_mailchimp' => 'tp-mailchimp-subscribe',
			'tp_mobile_menu' => 'tp-mobile-menu',			
			'tp_morphing_layouts' => 'tp-morphing-layouts',
			'tp_navigation_menu' => 'tp-navigation-menu',
			'tp_ninja_form' => 'tp-ninja-form',
			'tp_number_counter' => 'tp-number-counter',
			'tp_off_canvas' => 'tp-off-canvas',
			'tp_page_scroll' => 'tp-page-scroll',
			'tp_pricing_list' => 'tp-pricing-list',
			'tp_pricing_table' => 'tp-pricing-table',
			'tp_product_listout' => 'tp-product-listout',
			'tp_protected_content' => 'tp-protected-content',
			'tp_post_search' => 'tp-post-search',
			'tp_progress_bar' => 'tp-progress-bar',
			'tp_process_steps' => 'tp-process-steps',
			'tp_row_background' => 'tp-row-background',
			'tp_scroll_navigation' => 'tp-scroll-navigation',
			'tp_site_logo' => 'tp-site-logo',
			'tp_shape_divider' => 'tp-shape-divider',
			'tp_social_icon' => 'tp-social-icon',
			'tp_style_list' => 'tp-style-list',
			'tp_switcher' => 'tp-switcher',
			'tp_table' => 'tp-table',
			'tp_tabs_tours' => 'tp-tabs-tours',
			'tp_team_member_listout' => 'tp-team-member-listout',
			'tp_testimonial_listout' => 'tp-testimonial-listout',
			'tp_timeline' => 'tp-timeline',
			'tp_video_player' => 'tp-video-player',
			'tp_unfold' => 'tp-unfold',
			'tp_dynamic_categories' => 'tp-dynamic-categories',
			'tp_wp_forms' => 'tp-wp-forms',
			'tp_wp_login_register' => 'tp-wp-login-register',
        ];
		$merge = [
			'plus-backend-editor'
		];
		
		$elements=theplus_get_option('general','check_elements');
		if(empty($elements)){
			$elements = array_keys($replace);
		}
		$plus_extras=theplus_get_option('general','extras_elements');
		$elements = array_map(function ($val) use ($replace) {
		    return (array_key_exists($val, $replace) ? $replace[$val] : $val);
        }, $elements);
		if(in_array('tp-shape-divider',$elements)){
			$merge[]= 'plus-wavify';
		}
		if(in_array('tp-dynamic-listing',$elements)){
			$merge[]= 'tp-custom-field';
		}
		if(in_array('tp_advertisement_banner',$elements) || in_array('tp-cascading-image',$elements)){
			$merge[]= 'plus-hover3d';
		}
		if(in_array('tp-row-background',$elements)){
			$merge[]= 'plus-vegas-gallery';
			$merge[]= 'plus-row-animated-color';
			$merge[]= 'plus-row-segmentation';
			$merge[]= 'plus-row-scroll-color';
			$merge[]= 'plus-row-canvas-particle';
			$merge[]= 'plus-row-canvas-particleground';
			$merge[]= 'plus-row-canvas-8';
		}
		if(in_array('tp-number-counter',$elements)){
			$merge[]= 'tp-draw-svg';
		}
		if(in_array('tp-blog-listout',$elements)){
			$merge[] = 'plus-listing-masonry';
			$merge[] = 'plus-carousel';
			$merge[] = 'plus-post-filter';
			$merge[] = 'plus-listing-metro';
			$merge[] = 'plus-pagination';
		}
		if(in_array('tp-dynamic-smart-showcase',$elements)){
			$merge[] = 'plus-carousel';
			$merge[] = 'plus-post-filter';
		}
		if(in_array('tp-dynamic-listing',$elements)){
			$merge[] = 'plus-listing-masonry';
			$merge[] = 'plus-carousel';
			$merge[] = 'plus-post-filter';
			$merge[] = 'plus-listing-metro';
			$merge[] = 'plus-pagination';
		}
		if(in_array('tp-clients-listout',$elements)){
			$merge[] = 'plus-listing-masonry';
			$merge[] = 'plus-carousel';
			$merge[] = 'plus-post-filter';
			$merge[] = 'plus-pagination';
		}
		if(in_array('tp-dynamic-device',$elements)){
			$merge[] = 'plus-carousel';
		}
		if(in_array('tp-gallery-listout',$elements)){
			$merge[] = 'plus-listing-masonry';
			$merge[] = 'plus-carousel';
			$merge[] = 'plus-post-filter';
			$merge[] = 'plus-listing-metro';
		}
		if(in_array('tp-product-listout',$elements)){
			$merge[] = 'plus-listing-masonry';
			$merge[] = 'plus-carousel';
			$merge[] = 'plus-post-filter';
			$merge[] = 'plus-listing-metro';
			$merge[] = 'plus-pagination';
		}
		if(in_array('tp-team-member-listout',$elements)){
			$merge[] = 'plus-listing-masonry';
			$merge[] = 'plus-carousel';
			$merge[] = 'plus-post-filter';			
		}
		if(in_array('tp-page-scroll',$elements)){
			$merge[] = 'tp-fullpage';
			$merge[] = 'tp-pagepiling';
			$merge[] = 'tp-multiscroll';
			$merge[] = 'tp-horizontal-scroll';
		}
		if(in_array('tp-dynamic-categories',$elements)){
			$merge[] = 'plus-listing-masonry';
			$merge[] = 'plus-carousel';			
			$merge[] = 'plus-listing-metro';
		}
		if(!empty($plus_extras) && in_array('column_sticky',$plus_extras)){
			$merge[] ='plus-extras-column';
		}
		if(!empty($plus_extras) && in_array('column_mouse_cursor',$plus_extras)){
			$merge[] ='plus-column-cursor';
		}
		if(!empty($plus_extras) && in_array('section_scroll_animation',$plus_extras)){
			$merge[] ='plus-extras-section-skrollr';
		}
		if(!empty($plus_extras) && in_array('plus_equal_height',$plus_extras)){
			$merge[] ='plus-equal-height';
		}
		/*if(!empty($plus_extras) && in_array('plus_section_column_link',$plus_extras)){
			$merge[] ='plus-section-column-link';
		}*/	
		$result =array_unique($merge);
		$elements =array_merge($result , $elements);
        return (isset($element) ? (isset($elements[$element]) ? $elements[$element] : 0) : array_filter($elements));
    }

    /**
     * Remove files
     * @since 2.0
     */
    public function remove_files_unlink($post_type = null, $post_id = null)
    {
        $css_path_url = $this->secure_path_url(THEPLUS_PATH . DIRECTORY_SEPARATOR . ($post_type ? 'theplus-' . $post_type : 'theplus') . ($post_id ? '-' . $post_id : '') . '.min.css');
        $js_path_url = $this->secure_path_url(THEPLUS_PATH . DIRECTORY_SEPARATOR . ($post_type ? 'theplus-' . $post_type : 'theplus') . ($post_id ? '-' . $post_id : '') . '.min.js');

        if (file_exists($css_path_url)) {
            unlink($css_path_url);
        }

        if (file_exists($js_path_url)) {
            unlink($js_path_url);
        }
    }

    /**
     * Remove in directory files
     * @since 2.0
     */
    public function remove_dir_files($path_url)
    {
        if (!is_dir($path_url) || !file_exists($path_url)) {
            return;
        }

        foreach (scandir($path_url) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            unlink($this->secure_path_url($path_url . DIRECTORY_SEPARATOR . $item));
        }
    }
	
	/**
     * Remove backend in directory files
     * @since 2.0.2
     */
    public function remove_backend_dir_files()
    {
		if (file_exists(THEPLUS_ASSET_PATH . '/theplus.min.css')) {
			unlink($this->secure_path_url(THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . '/theplus.min.css'));
		}
		if(file_exists(THEPLUS_ASSET_PATH . '/theplus.min.js')){
			unlink($this->secure_path_url(THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . '/theplus.min.js'));
		}
    }
	
	/**
     * Remove current Page in directory files
     * @since 2.1.0
     */
    public function remove_current_page_dir_files( $path_url, $plus_name = '' ) {
	
		if ((!is_dir($path_url) || !file_exists($path_url)) && empty($plus_name)) {
            return;
        }
		
		if (file_exists($path_url . '/'. $plus_name. '.min.css')) {
			unlink($this->secure_path_url($path_url . DIRECTORY_SEPARATOR . '/'. $plus_name . '.min.css'));
		}
		if(file_exists($path_url . '/'. $plus_name. '.min.js')){
			unlink($this->secure_path_url($path_url. DIRECTORY_SEPARATOR . '/'. $plus_name . '.min.js'));
		}
		
    }

    /**
     * Check if elementor preview mode or not 
	 * @since 2.0
     */
    public function is_preview_mode()
    {
        if (isset($_REQUEST['doing_wp_cron'])) {
            return true;
        }
        if (wp_doing_ajax()) {
            return true;
        }
        if (isset($_GET['elementor-preview'])) {
            return true;
        }
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'elementor') {
            return true;
        }

        return false;
    }

    /**
     * Generate secure path url
     * @since 2.0
     */
    public function secure_path_url($path_url)
    {
        $path_url = str_replace(['//', '\\\\'], ['/', '\\'], $path_url);

        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path_url);
    }
	/**
	 * Returns the instance.
	 * @since  1.0.0
	 */
	public static function get_instance( $shortcodes = array() ) {
		
		if ( null == self::$instance ) {
			self::$instance = new self( $shortcodes );
		}
		return self::$instance;
	}
}
/**
 * Returns instance of Plus_Library
 */
function theplus_library() {
	return Plus_Library::get_instance();
}