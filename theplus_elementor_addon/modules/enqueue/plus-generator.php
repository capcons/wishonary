<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

Class Plus_Generator
{
	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;
	
	public $transient_widgets;
	public $registered_widgets;
    
	/**
     * Find Widgets in a page or post
     *
     * @since 2.0
     */
    public function collect_transient_widgets($widget)
    {
        if($widget->get_name() === 'global') {
            $global_widget = new \ReflectionClass(get_class($widget));
			
            $template_data = $global_widget->getProperty('template_data');
			
            $template_data->setAccessible(true);

            if($data_global = $template_data->getValue($widget)) {
				$widget_name=$this->get_global_widgets_use($data_global['content']);
				$widget_options=in_array($widget_name[0],array_keys($this->registered_widgets));
				if(!empty($widget_options) && $widget_options=='1'){
					$options=$widget->get_settings_for_display();					
					$this->plus_widgets_options($options,$widget_name[0]);
				}
                $this->transient_widgets = array_merge($this->transient_widgets, $widget_name);				
            }
        } else {
            $this->transient_widgets[] = $widget->get_name();
			$widget_options=in_array($widget->get_name(),array_keys($this->registered_widgets));
			
			if(!empty($widget->get_name()) && $widget->get_name()=='column'){
				$options=$widget->get_settings_for_display();
				if(!empty($options["plus_column_sticky"]) && $options["plus_column_sticky"]=='true'){					
					$this->transient_widgets[] = 'plus-extras-column';
				}
				if(!empty($options["plus_column_cursor_point"]) && $options["plus_column_cursor_point"]=='yes'){					
					$this->transient_widgets[] = 'plus-column-cursor';
				}
			}
			
			$options=$widget->get_settings_for_display();
			if(!empty($options["seh_switch"]) && $options["seh_switch"]=='yes'){					
				$this->transient_widgets[] = 'plus-equal-height';
			}
			
			if(!empty($widget->get_name()) && $widget->get_name()=='section'){				
				$options=$widget->get_settings_for_display();
				if((!empty($options["plus_section_scroll_animation_in"]) && $options["plus_section_scroll_animation_in"]!='none') || (!empty($options["plus_section_scroll_animation_out"]) && $options["plus_section_scroll_animation_out"]!='none')){
					$this->transient_widgets[] = 'plus-extras-section-skrollr';
				}
			}
			
			if(!empty($widget_options) && $widget_options=='1'){
				$options=$widget->get_settings_for_display();
				$this->plus_widgets_options($options,$widget->get_name());
			}
		}
    }
	
	/**
	* Check Widgets Options
	* @since 2.0.2
	*/
	public function plus_widgets_options($options='',$widget_name=''){
		if(!empty($options["animation_effects"]) && $options["animation_effects"]!='no-animation'){
			$this->transient_widgets[] = 'plus-velocity';
		}
		if((!empty($options["magic_scroll"]) && $options["magic_scroll"]=='yes') || (!empty($widget_name) && $widget_name=='tp-button' && !empty($options["btn_magic_scroll"]) && $options["btn_magic_scroll"]=='yes')){
			$this->transient_widgets[] = 'plus-magic-scroll';
		}
		if(!empty($options["plus_tooltip"]) && $options["plus_tooltip"]=='yes'){
			$this->transient_widgets[] = 'plus-tooltip';
		}
		if(!empty($options["plus_mouse_move_parallax"]) && $options["plus_mouse_move_parallax"]=='yes'){
			$this->transient_widgets[] = 'plus-mousemove-parallax';
		}
		if(!empty($options["plus_tilt_parallax"]) && $options["plus_tilt_parallax"]=='yes'){
			$this->transient_widgets[] = 'plus-tilt-parallax';
		}
		if((!empty($options["plus_overlay_effect"]) && $options["plus_overlay_effect"]=='yes') || (!empty($widget_name) && $widget_name=='tp-button' && !empty($options["btn_special_effect"]) && $options["btn_special_effect"]=='yes')){
			$this->transient_widgets[] = 'plus-reveal-animation';
		}
		if(!empty($options["loop_display_button"]) && $options["loop_display_button"]=='yes'){
			$this->transient_widgets[] = 'plus-button-extra';
		}
		if(!empty($widget_name) && $widget_name=='tp-advanced-typography' && !empty($options["typography_listing"]) && $options["typography_listing"]=='listing'){
			$this->transient_widgets[] = 'plus-magic-scroll';
			$this->transient_widgets[] = 'plus-mousemove-parallax';
		}
		if(!empty($widget_name) && $widget_name=='tp_advertisement_banner' && !empty($options["display_button"]) && $options["display_button"]=='yes'){
			$this->transient_widgets[] = 'plus-button';
		}
		if(!empty($widget_name) && $widget_name=='tp_advertisement_banner'){
			$this->transient_widgets[] = 'plus-content-hover-effect';
		}
		if(!empty($widget_name) && $widget_name=='tp-button' && !empty($options["btn_hover_effects"])){
			$this->transient_widgets[] = 'plus-content-hover-effect';
		}
		if(!empty($widget_name) && $widget_name=='tp-blog-listout' || !empty($widget_name) && $widget_name=='tp-product-listout' || !empty($widget_name) && $widget_name=='tp-dynamic-listing'){			
			if(!empty($options["layout"]) && $options["layout"]=='grid' || $options["layout"]=='masonry' ){
				$this->transient_widgets[] = 'plus-listing-masonry';
			}
			if(!empty($options["layout"]) && $options["layout"]=='metro'){
				$this->transient_widgets[] = 'plus-listing-metro';
			}
			if(!empty($options["layout"]) && $options["layout"]=='carousel'){
				$this->transient_widgets[] = 'plus-carousel';
			}
			if(!empty($options["filter_category"]) && $options["filter_category"]=='yes'){
				$this->transient_widgets[] = 'plus-post-filter';
			}
			if(!empty($options["post_extra_option"]) && $options["post_extra_option"]=='pagination'){
				$this->transient_widgets[] = 'plus-pagination';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-dynamic-smart-showcase'){			
			if(!empty($options["style"]) && ($options["style"] =='magazine' || $options["style"] =='none')){
				$this->transient_widgets[] = 'plus-carousel';
			}
			if(!empty($options["style"]) && $options["style"] =='news' && !empty($options["filter_category"]) && $options["filter_category"]=='yes'){
				$this->transient_widgets[] = 'plus-post-filter';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-clients-listout'){			
			if(!empty($options["layout"]) && $options["layout"]=='grid' || $options["layout"]=='masonry' ){
				$this->transient_widgets[] = 'plus-listing-masonry';
			}
			if(!empty($options["layout"]) && $options["layout"]=='carousel'){
				$this->transient_widgets[] = 'plus-carousel';
			}
			if(!empty($options["filter_category"]) && $options["filter_category"]=='yes'){
				$this->transient_widgets[] = 'plus-post-filter';
			}
			if(!empty($options["post_extra_option"]) && $options["post_extra_option"]=='pagination'){
				$this->transient_widgets[] = 'plus-pagination';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-dynamic-device'){
			if(!empty($options["device_mode"]) && $options["device_mode"]=='carousal'){
				$this->transient_widgets[] = 'plus-carousel';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-gallery-listout'){			
			if(!empty($options["layout"]) && $options["layout"]=='grid' || $options["layout"]=='masonry' ){
				$this->transient_widgets[] = 'plus-listing-masonry';
				}
			if(!empty($options["layout"]) && $options["layout"]=='metro'){
				$this->transient_widgets[] = 'plus-listing-metro';
			}
			if(!empty($options["layout"]) && $options["layout"]=='carousel'){
				$this->transient_widgets[] = 'plus-carousel';
			}
			if(!empty($options["filter_category"]) && $options["filter_category"]=='yes'){
				$this->transient_widgets[] = 'plus-post-filter';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-team-member-listout'){			
			if(!empty($options["layout"]) && $options["layout"]=='grid' || $options["layout"]=='masonry' ){
				$this->transient_widgets[] = 'plus-listing-masonry';
			}
			if(!empty($options["layout"]) && $options["layout"]=='carousel'){
				$this->transient_widgets[] = 'plus-carousel';
			}
			if(!empty($options["filter_category"]) && $options["filter_category"]=='yes'){
				$this->transient_widgets[] = 'plus-post-filter';
			}
		}
		if((!empty($widget_name) && $widget_name=='tp-flip-box') || (!empty($widget_name) && $widget_name=='tp-info-box')){
			if(!empty($options["display_button"]) && $options["display_button"]=='yes'){
				$this->transient_widgets[] = 'plus-button-extra';
			}
			if(!empty($options["info_box_layout"]) && $options["info_box_layout"]=='carousel_layout'){
				$this->transient_widgets[] = 'plus-carousel';
			}
			if(!empty($options["box_hover_effects"])){
				$this->transient_widgets[] = 'plus-content-hover-effect';
			}
			if(!empty($options["tilt_parallax"]) && $options["tilt_parallax"]=='yes'){
				$this->transient_widgets[] = 'plus-tilt-parallax';
			}
			if((!empty($options["image_icon"]) && $options["image_icon"]=='svg') || (!empty($options["loop_select_icon"]) && $options["loop_select_icon"]=='svg')){
				$this->transient_widgets[] = 'tp-draw-svg';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-image-factory'){
			if(!empty($options["bg_image_parallax"]) && $options["bg_image_parallax"]=='yes'){
				$this->transient_widgets[] = 'plus-magic-scroll';
			}
			if(!empty($options["animated_style"]) && $options["animated_style"]=='animate-image'){
				$this->transient_widgets[] = 'plus-velocity';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-instagram'){
			if(!empty($options["theplus_instafeed_masonry"]) && $options["theplus_instafeed_masonry"]=='yes'){
				$this->transient_widgets[] = 'plus-imagesloaded';
				$this->transient_widgets[] = 'plus-isotope';
			}
			if(!empty($options["theplus_instafeed_carousels"]) && $options["theplus_instafeed_carousels"]=='yes'){
				$this->transient_widgets[] = 'plus-imagesloaded';
				$this->transient_widgets[] = 'plus-carousel';
			}
		}
		if(!empty($options["box_hover_effects"]) && !empty($widget_name) && $widget_name=='tp-number-counter'){
			$this->transient_widgets[] = 'plus-content-hover-effect';
		}
		if(!empty($options["icon_type"]) && $options["icon_type"]=='svg' && !empty($widget_name) && $widget_name=='tp-number-counter'){
			$this->transient_widgets[] = 'tp-draw-svg';
		}
		if(!empty($widget_name) && $widget_name=='tp-social-icon'){
			if(!empty($options["pt_plus_social_networks"])){
				$magic_scroll= array_search('yes', array_column($options["pt_plus_social_networks"], 'loop_magic_scroll'));
				if(!empty($magic_scroll) || $magic_scroll===0){							
					$this->transient_widgets[] = 'plus-magic-scroll';
				}
				$plus_tooltip= array_search('yes', array_column($options["pt_plus_social_networks"], 'plus_tooltip'));
				if(!empty($plus_tooltip) || $plus_tooltip===0){						
					$this->transient_widgets[] = 'plus-tooltip';
				}
				$move_parallax= array_search('yes', array_column($options["pt_plus_social_networks"], 'plus_mouse_move_parallax'));
				if(!empty($move_parallax) || $move_parallax===0){						
					$this->transient_widgets[] = 'plus-mousemove-parallax';
				}
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-cascading-image'){
			if(!empty($options["image_cascading"])){
				$magic_scroll= array_search('yes', array_column($options["image_cascading"], 'loop_magic_scroll'));
				if(!empty($magic_scroll) || $magic_scroll===0){							
					$this->transient_widgets[] = 'plus-magic-scroll';
				}
				$plus_tooltip= array_search('yes', array_column($options["image_cascading"], 'plus_tooltip'));
				if(!empty($plus_tooltip) || $plus_tooltip===0){						
					$this->transient_widgets[] = 'plus-tooltip';
				}
				$special_effect= array_search('yes', array_column($options["image_cascading"], 'special_effect'));
				if(!empty($special_effect) || $special_effect===0){						
					$this->transient_widgets[] = 'plus-reveal-animation';
				}
				$move_parallax= array_search('yes', array_column($options["image_cascading"], 'cascading_move_parallax'));
				if(!empty($move_parallax) || $move_parallax===0){						
					$this->transient_widgets[] = 'plus-mousemove-parallax';
				}
				$hover_parallax= array_search('yes', array_column($options["image_cascading"], 'hover_parallax'));
				if(!empty($hover_parallax) || $hover_parallax===0){						
					$this->transient_widgets[] = 'plus-hover3d';
				}
				$link_option= array_search('popup_link', array_column($options["image_cascading"], 'link_option'));
				if(!empty($link_option) || $link_option===0){						
					$this->transient_widgets[] = 'plus-lity-popup';
				}
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-style-list'){
			if(!empty($options["icon_list"])){
				$show_tooltips= array_search('yes', array_column($options["icon_list"], 'show_tooltips'));
				if(!empty($show_tooltips) || $show_tooltips===0){						
					$this->transient_widgets[] = 'plus-tooltip';
				}
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-shape-divider'){
			if(!empty($options["shape_divider"]) && $options["shape_divider"]=='wave'){
				$this->transient_widgets[] = 'plus-wavify';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp_advertisement_banner'){
			if(!empty($options["hov_styles"]) && $options["hov_styles"]=='hover-tilt'){
				$this->transient_widgets[] = 'plus-hover3d';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-pricing-table'){
			if(!empty($options["image_icon"]) && $options["image_icon"]=='svg'){
				$this->transient_widgets[] = 'tp-draw-svg';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-row-background'){
			if(!empty($options["select_anim"]) && $options["select_anim"]=='bg_gallery'){
				$this->transient_widgets[] = 'plus-vegas-gallery';
			}
			if(!empty($options["select_anim"]) && $options["select_anim"]=='bg_color'){
				$this->transient_widgets[] = 'plus-row-animated-color';
			}
			if(!empty($options["select_anim"]) && $options["select_anim"]=='bg_Image_pieces'){
				$this->transient_widgets[] = 'plus-row-segmentation';
			}
			if(!empty($options["bg_img_parallax"]) && $options["bg_img_parallax"]=='yes'){
				$this->transient_widgets[] = 'plus-magic-scroll';
			}
			if(!empty($options["select_anim"]) && $options["select_anim"]=='scroll_animate_color'){
				$this->transient_widgets[] = 'plus-row-scroll-color';
			}
			if(!empty($options["middle_style"]) && $options["middle_style"]=='canvas'){
				if(!empty($options["canvas_style"]) && $options["canvas_style"]=='style_8'){
					$this->transient_widgets[] = 'plus-row-canvas-8';
				}
				if(!empty($options["canvas_style"]) && ($options["canvas_style"]=='style_2' || $options["canvas_style"]=='style_3' || $options["canvas_style"]=='style_4' || $options["canvas_style"]=='style_5' || $options["canvas_style"]=='style_7' || $options["canvas_style"]=='custom')){
					$this->transient_widgets[] = 'plus-row-canvas-particle';
				}
				if(!empty($options["canvas_style"]) && $options["canvas_style"]=='style_6'){
					$this->transient_widgets[] = 'plus-row-canvas-particleground';
				}
			}
			if(!empty($options["middle_style"]) && ($options["middle_style"]=='mordern_parallax' || $options["middle_style"]=='mordern_image_effect' || $options["middle_style"]=='multi_layered_parallax')){
				$this->transient_widgets[] = 'plus-magic-scroll';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-page-scroll'){
			if(!empty($options["page_scroll_opt"]) && $options["page_scroll_opt"]=='tp_full_page'){
				$this->transient_widgets[] = 'tp-fullpage';
			}
			if(!empty($options["page_scroll_opt"]) && $options["page_scroll_opt"]=='tp_page_pilling'){
				$this->transient_widgets[] = 'tp-pagepiling';
			}
			if(!empty($options["page_scroll_opt"]) && $options["page_scroll_opt"]=='tp_multi_scroll'){
				$this->transient_widgets[] = 'tp-multiscroll';
			}
			if(!empty($options["page_scroll_opt"]) && $options["page_scroll_opt"]=='tp_horizontal_scroll'){
				$this->transient_widgets[] = 'tp-horizontal-scroll';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-dynamic-categories'){			
			if(!empty($options["layout"]) && $options["layout"]=='grid' || $options["layout"]=='masonry' ){
				$this->transient_widgets[] = 'plus-listing-masonry';
			}
			if(!empty($options["layout"]) && $options["layout"]=='metro'){
				$this->transient_widgets[] = 'plus-listing-metro';
			}
			if(!empty($options["layout"]) && $options["layout"]=='carousel'){
				$this->transient_widgets[] = 'plus-carousel';
			}
		}
		
		if(!empty($widget_name) && $widget_name=='tp-advanced-typography'){
			if(!empty($options["on_hover_img_reveal_switch"]) && $options["on_hover_img_reveal_switch"] =='yes'){
				$this->transient_widgets[] = 'plus-adv-typo-extra-js-css';
			}
			if(!empty($options["typography_listing"]) && $options["typography_listing"]=='listing'){
				if(!empty($options["listing_content"])){
					$hover_image = false;
					foreach ($options["listing_content"] as $value) {
						if(!empty($value['on_hover_img_reveal_switch']) && $value['on_hover_img_reveal_switch']=='yes'){
							$hover_image = true;
							break;
						}
					}
					if($hover_image){
						$this->transient_widgets[] = 'plus-adv-typo-extra-js-css';
					}
				}
			}
			
		}
	}
	
    /**
     * Merge all Files Load
     *
     * @since 2.0
     */
    public function plus_merge_files($paths = array(), $file = 'theplus-style.min.css')
    {
        $output = '';

        if (!empty($paths)) {
            foreach ($paths as $path) {
                $output .= file_get_contents(theplus_library()->secure_path_url($path));
            }
        }

        return file_put_contents(theplus_library()->secure_path_url(THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . $file), $output);
    }

    

    /**
     * Generate scripts and minify.
     *
     * @since 2.0
     */
    public function plus_generate_scripts($elements, $file_name = null)
    {
		
        if (empty($elements)) {
            return;
        }
		
        if (!file_exists(THEPLUS_ASSET_PATH)) {
            wp_mkdir_p(THEPLUS_ASSET_PATH);
        }

        // default load js and css
        $js_url = array();
        $css_url = array(
			THEPLUS_PATH . DIRECTORY_SEPARATOR . "assets/css/main/plus-extra-adv/plus-extra-adv.min.css",
        );

        // collect library scripts & styles
        $js_url = array_merge($js_url, $this->plus_dependency_widgets($elements, 'js'));
        $css_url = array_merge($css_url, $this->plus_dependency_widgets($elements, 'css'));

        // merge files widgets
        $this->plus_merge_files($css_url, ($file_name ? $file_name : 'theplus') . '.min.css');
        $this->plus_merge_files($js_url, ($file_name ? $file_name : 'theplus') . '.min.js');
    }


    /**
     * Check if cache files exists
     *
     * @since 2.0
     */
    public function check_cache_files($post_type = null, $post_id = null)
    {
        $css_url = THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . ($post_type ? 'theplus-' . $post_type : 'theplus') . ($post_id ? '-' . $post_id : '') . '.min.css';
        $js_url = THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . ($post_type ? 'theplus-' . $post_type : 'theplus') . ($post_id ? '-' . $post_id : '') . '.min.js';

        if (is_readable(theplus_library()->secure_path_url($css_url)) && is_readable(theplus_library()->secure_path_url($js_url))) {
			return true;
        }
        return false;
    }

	/**
     * Widgets dependency for modules
     *
     * @since 2.0
     */
    public function plus_dependency_widgets(array $elements, $type)
    {
        $paths = [];

        foreach ($elements as $element) {
            if (isset($this->registered_widgets[$element])) {
                if (!empty($this->registered_widgets[$element]['dependency'][$type])) {
                    foreach ($this->registered_widgets[$element]['dependency'][$type] as $path) {
                        $paths[] = $path;
                    }
                }
            } elseif (isset($this->registered_extensions[$element])) {
                if (!empty($this->registered_extensions[$element]['dependency'][$type])) {
                    foreach ($this->registered_extensions[$element]['dependency'][$type] as $path) {
                        $paths[] = $path;
                    }
                }
            }
        }

        return array_unique($paths);
    }
	/**
     * Find global widgets
     * @since 2.0.2
     */
    public function get_global_widgets_use($widgets) {
        $get_widget = [];

        array_walk_recursive($widgets, function($val, $key) use (&$get_widget) {
            if($key == 'widgetType') {
                $get_widget[] = $val;
            }
        });

        return $get_widget;
    }
    /**
     * Generate single post scripts
     *
     * @since 2.0
     */
    public function generate_scripts_frontend()
    {
        if (theplus_library()->is_preview_mode()) {
            return;
        }

        $replace = [
            'plus-woocommerce' => 'product-plus',
        ];
        $elements = array_map(function ($val) use ($replace) {
			$val = str_replace(['theplus-'], [''], $val);
		    return (array_key_exists($val, $replace) ? $replace[$val] : $val);
        }, $this->transient_widgets);
		
        $elements = array_intersect(array_keys($this->registered_widgets), $elements);
		
        $extensions = apply_filters('theplus/section/after_render', $this->transient_extensions);

        $elements = array_unique(array_merge($elements, $extensions));
		global $wp_query;		
        if (is_home() || is_singular() || is_archive() || is_search() || (isset( $wp_query ) && (bool) $wp_query->is_posts_page) || is_404()) {
			
            $queried_object = get_queried_object_id();
			if(is_search()){
				$queried_object = 'search';
			}
			if(is_404()){
				$queried_object = '404';
			}
            $post_type = (is_singular() ? 'post' : 'term');
            $old_elements = (array) get_metadata($post_type, $queried_object, 'theplus_transient_widgets', true);

            // sort two arr for compare
            sort($elements);
            sort($old_elements);

            if ($old_elements != $elements) {
				
                update_metadata($post_type, $queried_object, 'theplus_transient_widgets', $elements);

                // if not empty widgets, regenerate cache files
                if (!empty($elements)) {
                    $this->plus_generate_scripts($elements, 'theplus-' . $post_type . '-' . $queried_object);
				
                    // load generated files - fallback
                    $this->enqueue_frontend_load($queried_object, $post_type);
                }
            }

            // if no cache files, generate new
            if (!$this->check_cache_files($post_type, $queried_object)) {			
                $this->plus_generate_scripts($elements, 'theplus-' . $post_type . '-' . $queried_object);
            }

            // if no widgets, remove cache files
            if (empty($elements)) {
               theplus_library()->remove_files_unlink($post_type, $queried_object);
            }
        }		
    }
	
	/**
	 * Enqueue editor scripts
	 *
	 * @since 2.2.0
	 *
	 * @access public
	 */
	public function enqueue_editor_scripts() {

		// Register scripts
		wp_enqueue_script( 'plus-editor-js', $this->pathurl_security(THEPLUS_URL . DIRECTORY_SEPARATOR .  'assets/js/admin/plus-editor.min.js'), [], THEPLUS_VERSION, true );
		
	}
	
	//Plus Addons Scripts
	public function plus_enqueue_scripts()
	{
	
		if ( is_admin_bar_showing() ) {
			wp_enqueue_script(
				'plus-purge-js',
				$this->pathurl_security(THEPLUS_URL . '/assets/js/main/general/theplus-purge.js'),
				['jquery'],
				THEPLUS_VERSION,
				true
			);
			echo '<script> var theplus_ajax_url = "'.admin_url("admin-ajax.php").'";
			var theplus_nonce = "'.wp_create_nonce("theplus-addons").'";</script>';
		}
		
		if (theplus_library()->is_preview_mode()) {
			
			// generate fallback scripts
			if (!$this->check_cache_files()) {
				$this->plus_generate_scripts(theplus_library()->get_plus_widget_settings());
			}

			// enqueue scripts
			if ($this->check_cache_files()) {
				$css_file = THEPLUS_ASSET_URL . '/theplus.min.css';
				$js_file = THEPLUS_ASSET_URL . '/theplus.min.js';
			} else {
				$css_file = THEPLUS_URL . '/assets/css/main/general/theplus.min.css';
				$js_file = THEPLUS_URL . '/assets/js/main/general/theplus.min.js';
			}
			
			//Load Icons Mind
			$options = get_option( 'theplus_api_connection_data' );
			$load_font_id=array();
			if(isset($options["load_icons_mind_ids"]) && !empty($options["load_icons_mind_ids"])){
				$load_font_id = explode(",", $options["load_icons_mind_ids"]);
			}
			$paged_id = get_queried_object_id();
			if(!isset($options["load_icons_mind"]) || (isset($options["load_icons_mind"]) && !empty($options["load_icons_mind"]) && $options["load_icons_mind"]=='enable') || ( isset($options["load_icons_mind"]) && $options["load_icons_mind"]=='disable' && in_array($paged_id,$load_font_id) )){
				wp_enqueue_style(
					'plus-icons-mind-css',
					$this->pathurl_security(THEPLUS_URL . '/assets/css/extra/iconsmind.min.css'),
					false,
					THEPLUS_VERSION
				);
			}
			
			//Google Map Api			
			$check_elements=theplus_get_option('general','check_elements');
			$switch_api = (!empty($options['gmap_api_switch'])) ? $options['gmap_api_switch'] : '';
			if((empty($theplus_options) || (isset($check_elements) && !empty($check_elements) && in_array('tp_google_map',$check_elements))) && (empty($switch_api) || $switch_api=='enable' || $switch_api!='none') ){
				if(!empty($options['theplus_google_map_api'])){
					$theplus_google_map_api=$options['theplus_google_map_api'];
				}else{
					$theplus_google_map_api='';
				}
				wp_enqueue_script( 'gmaps-js','//maps.googleapis.com/maps/api/js?key='.$theplus_google_map_api.'&sensor=false', array('jquery'), null, false, true);
			}
			
			if((isset($check_elements) && !empty($check_elements) && in_array('tp_wp_bodymovin',$check_elements)) && !empty($options['bodymovin_load_js_check'])){
				wp_enqueue_script( 'lottie' , $this->pathurl_security(THEPLUS_URL . DIRECTORY_SEPARATOR .  'assets/js/extra/lottie.min.js'), array(), '5.5.2' ); //Bodymovin Animation
				wp_enqueue_script( 'theplus-bodymovin' , $this->pathurl_security(THEPLUS_URL . DIRECTORY_SEPARATOR .  'assets/js/main/bodymovin/plus-bodymovin.js'), array( 'jquery', 'lottie' ), THEPLUS_VERSION, true );
			}
			
			wp_enqueue_script( 'jquery-ui-slider' );//Audio Player
			wp_enqueue_style(
				'plus-editor-css',
				$this->pathurl_security($css_file),
				false,
				THEPLUS_VERSION
			);

			wp_enqueue_script(
				'plus-editor-js',
				$this->pathurl_security($js_file),
				['jquery'],
				THEPLUS_VERSION,
				true
			);
			echo '<script> var theplus_ajax_url = "'.admin_url('admin-ajax.php').'";</script>';
			// hook extended assets
			do_action('theplus/after_enqueue_scripts', $this->check_cache_files());

		} else {
			global $wp_query;
			if (is_home() || is_singular() || is_archive() || is_search() || (isset( $wp_query ) && (bool) $wp_query->is_posts_page) || is_404()) {
				
				$queried_obj = get_queried_object_id();
				if(is_search()){
					$queried_obj = 'search';
				}
				if(is_404()){
					$queried_obj = '404';
				}
				$post_type = (is_singular() ? 'post' : 'term');
				$elements = (array) get_metadata($post_type, $queried_obj, 'theplus_transient_widgets', true);
				
				if (empty($elements)) {
					return;
				}
				$this->enqueue_frontend_load($post_type, $queried_obj);
			}
		}
	}
	// rules how css will be enqueued on front-end
	protected function enqueue_frontend_load($post_type, $queried_obj)
	{
			
		
		if ($this->check_cache_files($post_type, $queried_obj)) {
			$css_file = THEPLUS_ASSET_URL . '/theplus-' . $post_type . '-' . $queried_obj . '.min.css';
			$js_file = THEPLUS_ASSET_URL . '/theplus-' . $post_type . '-' . $queried_obj . '.min.js';
		} else {			
			if (file_exists(THEPLUS_ASSET_PATH . '/theplus.min.css') && file_exists(THEPLUS_ASSET_PATH . '/theplus.min.js')) {
				$css_file = THEPLUS_ASSET_URL . '/theplus.min.css';
				$js_file = THEPLUS_ASSET_URL . '/theplus.min.js';
			}else{
				$css_file = THEPLUS_URL . '/assets/css/main/general/theplus.min.css';
				$js_file = THEPLUS_URL . '/assets/js/main/general/theplus.min.js';
			}
		}
		
		wp_register_script( 'lottie' , $this->pathurl_security(THEPLUS_URL . DIRECTORY_SEPARATOR .  'assets/js/extra/lottie.min.js'), array(), '5.5.2' ); //Bodymovin Animation
		wp_register_script( 'theplus-bodymovin' , $this->pathurl_security(THEPLUS_URL . DIRECTORY_SEPARATOR .  'assets/js/main/bodymovin/plus-bodymovin.js'), array( 'jquery', 'lottie' ), THEPLUS_VERSION, true );
		
		//Load Icons Mind
		$options = get_option( 'theplus_api_connection_data' );
		$load_font_id=array();
		if(isset($options["load_icons_mind_ids"]) && !empty($options["load_icons_mind_ids"])){
			$load_font_id = explode(",", $options["load_icons_mind_ids"]);
		}
		
		$paged_id = get_queried_object_id();
		if(!isset($options["load_icons_mind"]) || (isset($options["load_icons_mind"]) && !empty($options["load_icons_mind"]) && $options["load_icons_mind"]=='enable') || ( isset($options["load_icons_mind"]) && $options["load_icons_mind"]=='disable' && in_array($paged_id,$load_font_id) )){
			wp_enqueue_style('plus-icons-mind-css',$this->pathurl_security(THEPLUS_URL . '/assets/css/extra/iconsmind.min.css'),false,THEPLUS_VERSION);
		}
		
		//Google Map Api		
		$check_elements=theplus_get_option('general','check_elements');
		$switch_api = (!empty($options['gmap_api_switch'])) ? $options['gmap_api_switch'] : '';	
		if((empty($theplus_options) || (isset($check_elements) && !empty($check_elements) && in_array('tp_google_map',$check_elements))) && (empty($switch_api) || $switch_api=='enable')){
			if(!empty($options['theplus_google_map_api'])){
				$theplus_google_map_api=$options['theplus_google_map_api'];
			}else{
				$theplus_google_map_api='';
			}
			wp_enqueue_script( 'gmaps-js','//maps.googleapis.com/maps/api/js?key='.$theplus_google_map_api.'&sensor=false', array('jquery'), null, false, true);
		}
		
		/*sociel login google*/
		$options = get_option( 'theplus_api_connection_data' );		
		if((empty($theplus_options) || (isset($check_elements) && !empty($check_elements) && in_array('tp_wp_login_register',$check_elements))) && !empty($options['theplus_google_client_id'])){
			wp_enqueue_script( 'google_clientid_js', 'https://apis.google.com/js/api:client.js', array('jquery'), null, false, true);
			wp_enqueue_script( 'google_platform_js', 'https://apis.google.com/js/platform.js', array('jquery'), null, false, true);
		}
		/*sociel login google*/
		
		wp_enqueue_script( 'jquery-ui-slider' );//Audio Player
		
		
		$plus_version=get_post_meta( $queried_obj, '_elementor_css', true );
		if(!empty($plus_version) && !empty($plus_version['time'])){
			$plus_version=$plus_version['time'];
		}else{
			$plus_version=time();
		}
		wp_enqueue_style('theplus-front-css',$this->pathurl_security($css_file),false,$plus_version);

		wp_enqueue_script('theplus-front-js',$this->pathurl_security($js_file),['jquery'],$plus_version,true);
		
		echo '<script> var theplus_ajax_url = "'.admin_url('admin-ajax.php').'";</script>';
		// hook extended assets
		do_action('theplus/after_enqueue_scripts', $this->check_cache_files($post_type, $queried_obj));
	}
	
    /**
     * Clear cache files
     *
     * @since 2.0
     */
    public function theplus_smart_perf_clear_cache()
    {
		check_ajax_referer('theplus-addons', 'security');

        // clear cache files
		theplus_library()->remove_dir_files(THEPLUS_ASSET_PATH);

		wp_send_json(true);
    }
	
	/**
     * Clear cache files
     *
     * @since 2.0.2
     */
    public function theplus_backend_clear_cache()
    {
		check_ajax_referer('theplus-addons', 'security');

        // clear cache files
		theplus_library()->remove_backend_dir_files();

		wp_send_json(true);
    }
	
	/**
     * Current Page Clear cache files
     *
     * @since 2.0.2
     */
    public function theplus_current_page_clear_cache()
    {
		check_ajax_referer('theplus-addons', 'security');
		
		$plus_name='';
		if(isset($_POST['plus_name']) && !empty($_POST['plus_name'])){
			$plus_name =$_POST['plus_name'];
		}
		if($plus_name== 'theplus-all') {
			// All clear cache files
			theplus_library()->remove_dir_files(THEPLUS_ASSET_PATH);		
		}else {
			// Current Page cache files
			theplus_library()->remove_current_page_dir_files( THEPLUS_ASSET_PATH, $plus_name );
		}
		wp_send_json(true);
    }
	/**
	 * Generate secure path url
	 *
	 * @since v2.0
	 */
	public function pathurl_security($url) {
        return preg_replace(['/^http:/', '/^https:/', '/(?!^)\/\//'], ['', '', '/'], $url);
    }
	
	/**
	 * Add menu in admin bar.
	 *
	 * Adds "Plus Clear Cache" items to the WordPress admin bar.
	 *
	 * Fired by `admin_bar_menu` filter.
	 *
	 * @since 2.1.0
	 */
	public function add_plus_clear_cache_admin_bar( \WP_Admin_Bar $wp_admin_bar ) {
		
		global $wp_admin_bar;

		if ( ! is_super_admin()
			 || ! is_object( $wp_admin_bar ) 
			 || ! function_exists( 'is_admin_bar_showing' ) 
			 || ! is_admin_bar_showing() ) {
			return;
		}
		
		$queried_obj = get_queried_object_id();
		if(is_search()){
			$queried_obj = 'search';
		}
		if(is_404()){
			$queried_obj = '404';
		}
		$post_type = (is_singular() ? 'post' : 'term');
		
		if (file_exists(THEPLUS_ASSET_PATH . '/theplus-' . $post_type . '-' . $queried_obj . '.min.css') || file_exists(THEPLUS_ASSET_PATH . '/theplus-' . $post_type . '-' . $queried_obj . '.min.js')) {
		
				//Parent
				$wp_admin_bar->add_node( [
					'id'	=> 'theplus-purge-clear',					
					'meta'	=> array(
						'class' => 'theplus-purge-clear',
					),
					'title' => esc_html__( 'The Plus Performance', 'theplus' ),
					
				] );
				
				//Child Item
				$args = array();
				array_push($args,array(
					'id'		=>	'plus-purge-all-pages',
					'title'		=>	esc_html__( 'Purge All Pages', 'theplus' ),
					'href'		=> 	'#clear-theplus-all',
					'parent'	=>	'theplus-purge-clear',
					'meta'   	=> 	array( 'class' => 'plus-purge-all-pages' ),
				));

				array_push($args,array(
					'id'     	=>	'plus-purge-current-page',
					'title'		=>	esc_html__( 'Purge Current Page', 'theplus' ),
					'href'		=>	'#clear-theplus-' . $post_type . '-' . $queried_obj,
					'parent' 	=>	'theplus-purge-clear',
					'meta'   	=>	array( 'class' => 'plus-purge-current-page' ),
				));
				
				sort($args);
				foreach( $args as $each_arg) {
					$wp_admin_bar->add_node($each_arg);
				}
		}
	}
	
	/**
	 * Print style.
	 *
	 * Fired by `admin_head` and `wp_head` filters.
	 *
	 * @since 1.0.0
	 */
	public function plus_purge_clear_print_style() {
		if((is_admin_bar_showing())){
		?>
			<style>#wpadminbar .theplus-purge-clear > .ab-item:before {content: '';background-image: url(<?php echo THEPLUS_URL . '/assets/images/thepluslogo-small.png'; ?>) !important;background-size: 20px !important;background-position: center;width: 20px;height: 20px;background-repeat: no-repeat;top: 50%;transform: translateY(-50%);}</style>
		<?php
		}
	}
	
	public function init(){
		$this->registered_widgets = registered_widgets();
		$this->transient_widgets = [];
		$this->transient_extensions = [];
		add_action('elementor/frontend/before_render', array($this, 'collect_transient_widgets'));
        add_action('wp_print_footer_scripts', array($this, 'generate_scripts_frontend'));
		
		add_action( 'elementor/editor/before_enqueue_scripts', array($this, 'enqueue_editor_scripts') );
		
		add_action( 'admin_bar_menu', [ $this, 'add_plus_clear_cache_admin_bar' ], 300 );
		add_action('wp_ajax_plus_purge_current_clear', array($this, 'theplus_current_page_clear_cache'));
		
		if(is_user_logged_in()){
			add_action( 'wp_head', [ $this, 'plus_purge_clear_print_style' ]);		
		}
		
		add_action('wp_enqueue_scripts', array($this, 'plus_enqueue_scripts'));
		
		if (is_admin()) {
			add_action('wp_ajax_smart_perf_clear_cache', array($this, 'theplus_smart_perf_clear_cache'));
			add_action('wp_ajax_backend_clear_cache', array($this, 'theplus_backend_clear_cache'));
		}
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
 * Returns instance of Plus_Generator
 */
function theplus_generator() {
	return Plus_Generator::get_instance();
}
