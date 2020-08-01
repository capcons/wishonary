<?php 
/*
Widget Name: Before After Image 
Description: Horizontal,Vertical and Opacity before/after Image
Author: Theplus
Author URI: http://posimyththemes.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH'))
exit; // Exit if accessed directly


class ThePlus_Before_After extends Widget_Base {
		
	public function get_name() {
		return 'tp-before-after';
	}

    public function get_title() {
        return esc_html__('Before After', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-star-half-o theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-creatives');
    }

    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
            'type', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Style', 'theplus'),
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'theplus'),
                    'vertical' => esc_html__('Vertical', 'theplus'),
                    'cursor' => esc_html__('Opacity', 'theplus'),
                ],
            ]
        );
		$this->add_control(
            'before_image', [
				'type' => Controls_Manager::MEDIA,
				'label' => esc_html__('Image for Before', 'theplus'),
				'dynamic' => [
					'active'   => true,
				],
			]
        );
		$this->add_control(
            'before_label',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Label for Before', 'theplus'),
                'label_block' => true,
                'separator' => 'after',
                'default' => '',
				'dynamic' => [
					'active'   => true,
				],
            ]
        );
		$this->add_control(
            'after_image', [
				'type' => Controls_Manager::MEDIA,
				'label' => esc_html__('Image for After', 'theplus'),
				'dynamic' => [
					'active'   => true,
				],
			]
        );
		$this->add_control(
            'after_label',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Label for After', 'theplus'),
                'label_block' => true,
                'separator' => 'after',
                'default' => '',
				'dynamic' => [
					'active'   => true,
				],
            ]
        );
		
	$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'option_settings',
            [
                'label' => esc_html__('Options', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'toggle' => false,
			]
		);
		$this->add_control(
			'full_switch',
			[
				'label'   => esc_html__( 'Full Width', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);
		$this->add_control(
			'click_hover_move',
			[
				'label'   => esc_html__( 'Mouse Hover option', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		$this->add_control(
			'separate_switch',
			[
				'label'   => esc_html__( 'Separator Line', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition' => [
					'type' => [ 'horizontal','vertical' ],
				],
			]
		);
		$this->add_control(
            'separator_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Separator Style', 'theplus'),
                'default' => 'middle',
                'options' => [
                    'middle' => esc_html__('Middle', 'theplus'),
                    'bottom' => esc_html__('Bottom', 'theplus'),
                ],
				'condition' => [
					'type' => [ 'horizontal','vertical' ],
					'separate_switch' => 'yes',
				],
            ]
        );
		
		$this->add_control(
            'separate_width', [
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Separator Width', 'theplus'),
				'size_units' => ['px'],
				'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
						'step' => 1,
					],
				],
				'condition' => [
					'type' => [ 'horizontal','vertical' ],
					'separate_switch' => 'yes',
				],
			]
        );
		$this->add_control(
            'separate_color',
            [
                'label' => esc_html__('Separator Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
				'condition' => [
					'type' => [ 'horizontal','vertical' ],
					'separate_switch' => 'yes',
				],
            ]
        );
		$this->add_control(
            'separate_bg_color',
            [
                'label' => esc_html__('Separator Bottom Bg Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(200,200,200,0.7)',
                'selectors' => [
                    '{{WRAPPER}} .pt_plus_before_after .before-after-bottom-separate' => 'background:{{VALUE}};',
                ],
				'separator' => 'after',
				'condition' => [
					'type' => [ 'horizontal','vertical' ],
					'separate_switch' => 'yes',
					'separator_style' => 'bottom',
				],
            ]
        );
		$this->add_control(
            'image_separator', [
				'type' => Controls_Manager::MEDIA,
				'label' => esc_html__('Separator Icon', 'theplus'),
				'separator' => 'before',
			]
        );
		$this->add_control(
            'separate_position', [
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Separator Position', 'theplus'),
				'size_units' => '%',
				'default' => [
					'size' => 50,
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
			]
        );
		
		$this->end_controls_section();
		/*Adv tab*/
		$this->start_controls_section(
            'section_plus_extra_adv',
            [
                'label' => esc_html__('Plus Extras', 'theplus'),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );
		$this->end_controls_section();
		/*Adv tab*/
		$this->start_controls_section(
            'section_animation_styling',
            [
                'label' => esc_html__('On Scroll View Animation', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'animation_effects',
			[
				'label'   => esc_html__( 'Choose Animation Effect', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no-animation',
				'options' => theplus_get_animation_options(),
			]
		);
		$this->add_control(
            'animation_delay',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Animation Delay', 'theplus'),
				'default' => [
					'unit' => '',
					'size' => 50,
				],
				'range' => [
					'' => [
						'min'	=> 0,
						'max'	=> 4000,
						'step' => 15,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
				],
            ]
        );
		$this->add_control(
            'animation_duration_default',
            [
				'label'   => esc_html__( 'Animation Duration', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition' => [
					'animation_effects!' => 'no-animation',
				],
			]
		);
		$this->add_control(
            'animate_duration',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Duration Speed', 'theplus'),
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min'	=> 100,
						'max'	=> 10000,
						'step' => 100,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_duration_default' => 'yes',
				],
            ]
        );
		$this->add_control(
			'animation_out_effects',
			[
				'label'   => esc_html__( 'Out Animation Effect', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no-animation',
				'options' => theplus_get_out_animation_options(),
				'separator' => 'before',
				'condition' => [
					'animation_effects!' => 'no-animation',
				],
			]
		);
		$this->add_control(
            'animation_out_delay',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Out Animation Delay', 'theplus'),
				'default' => [
					'unit' => '',
					'size' => 50,
				],
				'range' => [
					'' => [
						'min'	=> 0,
						'max'	=> 4000,
						'step' => 15,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_out_effects!' => 'no-animation',
				],
            ]
        );
		$this->add_control(
            'animation_out_duration_default',
            [
				'label'   => esc_html__( 'Out Animation Duration', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_out_effects!' => 'no-animation',
				],
			]
		);
		$this->add_control(
            'animation_out_duration',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Duration Speed', 'theplus'),
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min'	=> 100,
						'max'	=> 10000,
						'step' => 100,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_out_effects!' => 'no-animation',
					'animation_out_duration_default' => 'yes',
				],
            ]
        );
		$this->end_controls_section();
	}
	 protected function render() {

        $settings = $this->get_settings_for_display();
		
		$type = $settings['type'];
		$click_hover_move = (($settings['click_hover_move']=='yes') ? 'on' : 'off' ); 
		$separate_width = (!empty($settings['separate_width']['size'])) ? $settings['separate_width']['size'] : 3;
		$separate_width_unit = (!empty($settings['separate_width']['unit'])) ? $settings['separate_width']['unit'] : 'px';
		$separate_position = $settings['separate_position']['size'];
		$separator_style = $settings['separator_style'];
		$separate_switch = (($settings['separate_switch']=='no') ? 'false' : 'true' );
		$separate_color = $settings['separate_color'];
		$alignment= (!empty($settings["alignment"])) ? 'text-'.$settings["alignment"] : '';
		$uid=uniqid("bf_af");
			$attr_data=$image_sep=$middle_separator=$bottom_separator=$before_image_tag=$after_image_tag=$sep_style=$before_label_text=$after_label_text='';
			
			$attr_data .=' data-id="'.esc_attr($uid).'" ';
			$attr_data .=' data-type="'.esc_attr($type).'" ';
			$attr_data .=' data-click_hover_move="'.esc_attr($click_hover_move).'" ';
			$attr_data .=' data-separate_width="'.esc_attr($separate_width).'" ';
			$attr_data .=' data-separate_position="'.esc_attr($separate_position).'" ';
			$attr_data .=' data-separator_style="'.esc_attr($separator_style).'" ';
			$attr_data .=' data-show="1" ';
			$attr_data .=' data-responsive="yes" ';
			$attr_data .= (!empty($settings["full_switch"]) && $settings["full_switch"]=='yes') ? ' data-full_width="yes" ' : ' data-full_width="no" ';
			$attr_data .=' data-width="0" ';
			$attr_data .=' data-max-width="0" ';
			$attr_data .=' data-separate_switch="'.esc_attr($separate_switch).'" ';
			
			if(!empty($settings['image_separator']['url'])){
				$attr_data .=' data-separate_image="2" ';
			}else{
				$attr_data .=' data-separate_image="1" ';
			}
			
			if(!empty($settings['before_image']['url'])){
				
				if(!empty($settings['before_image']) && !empty($settings['thumbnail_size'])){
					$before_image=$settings['before_image']['id'];
					$img = wp_get_attachment_image_src($before_image,$settings['thumbnail_size']);
					$before_imgSrc = $img[0];
					//$before_imgSrc = $settings['before_image']['url'];
				}else{
					$before_imgSrc = $settings['before_image']['url'];
				}
				$image_id=$settings["before_image"]["id"];
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
				if(!$image_alt){
					$image_alt = get_the_title($image_id);
				}else if(!$image_alt){
					$image_alt = 'Plus before image';
				}
				$before_image_tag='<img class="image-before-wrap" src="'.esc_url($before_imgSrc).'" alt="'.esc_attr($image_alt).'">';
			}
			if(!empty($settings['after_image']['url'])){
				if(!empty($settings['after_image'])){
					$after_image=$settings['after_image']['id'];
					$img = wp_get_attachment_image_src($after_image,$settings['thumbnail_size']);
					$after_imgSrc = $img[0];
					//$after_imgSrc = $settings['after_image']['url'];
				}else{
					$after_imgSrc = $settings['after_image']['url'];
				}
				
				$image_id=$settings["after_image"]["id"];
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
				if(!$image_alt){
					$image_alt = get_the_title($image_id);
				}else if(!$image_alt){
					$image_alt = 'Plus after image';
				}
				$after_image_tag='<img class="image-after-wrap" src="'.esc_url($after_imgSrc).'" alt="'.esc_attr($image_alt).'">';
			}
			if(!empty($separate_switch) && $separate_switch=='true'){
				$sep_style=' style="background: '.esc_attr($separate_color).';"';
				if(!empty($settings['image_separator']['url'])){
					$imgSrc = $settings['image_separator']['url'];
					$image_id=$settings["image_separator"]["id"];
					$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
					if(!$image_alt){
						$image_alt = get_the_title($image_id);
					}else if(!$image_alt){
						$image_alt = 'Plus separate icon';
					}
					$image_sep= '<div class="before-after-sep-icon"><img src="'.esc_url($imgSrc).'" alt="'.esc_attr($image_alt).'"></div>';
				}
				if(!empty($type) && ($type=='horizontal' || $type=='vertical')){
				if($separator_style=='middle'){
					$middle_separator='<div class="before-after-sep" '.$sep_style.'></div>';
				}else{
					$middle_separator='<div class="before-after-sep" '.$sep_style.'></div>';
					$bottom_separator='<div class="before-after-bottom-separate"></div>';
				}
				}
			}
			
			if(!empty($settings['before_label'])){
				$before_label_text='<div class="before_after_label before_label_text">'.esc_html($settings["before_label"]).'</div>';
			}
			if(!empty($settings["after_label"])){
				$after_label_text='<div class="before_after_label after_label_text">'.esc_html($settings["after_label"]).'</div>';
			}
				
			$animation_effects=$settings["animation_effects"];
			$animation_delay= (!empty($settings["animation_delay"]["size"])) ? $settings["animation_delay"]["size"] : 50;
			if($animation_effects=='no-animation'){
				$animated_class = '';
				$animation_attr = '';
			}else{
				$animate_offset = theplus_scroll_animation();
				$animated_class = 'animate-general';
				$animation_attr = ' data-animate-type="'.esc_attr($animation_effects).'" data-animate-delay="'.esc_attr($animation_delay).'"';
				$animation_attr .= ' data-animate-offset="'.esc_attr($animate_offset).'"';
				if($settings["animation_duration_default"]=='yes'){
					$animate_duration=$settings["animate_duration"]["size"];
					$animation_attr .= ' data-animate-duration="'.esc_attr($animate_duration).'"';
				}
				if(!empty($settings["animation_out_effects"]) && $settings["animation_out_effects"]!='no-animation'){
					$animation_attr .= ' data-animate-out-type="'.esc_attr($settings["animation_out_effects"]).'" data-animate-out-delay="'.esc_attr($settings["animation_out_delay"]["size"]).'"';					
					if($settings["animation_out_duration_default"]=='yes'){						
						$animation_attr .= ' data-animate-out-duration="'.esc_attr($settings["animation_out_duration"]["size"]).'"';
					}
				}
			}
				
			/*--Plus Extra ---*/
			$magic_class = $magic_attr = $parallax_scroll = '';
			if (!empty($settings['magic_scroll']) && $settings['magic_scroll'] == 'yes') {
				
				if($settings["scroll_option_popover_toggle"]==''){
					$scroll_offset=0;
					$scroll_duration=300;
				}else{
					$scroll_offset=$settings['scroll_option_scroll_offset'];
					$scroll_duration=$settings['scroll_option_scroll_duration'];
				}
				
				if($settings["scroll_from_popover_toggle"]==''){
					$scroll_x_from=0;
					$scroll_y_from=0;
					$scroll_opacity_from=1;
					$scroll_scale_from=1;
					$scroll_rotate_from=0;
				}else{
					$scroll_x_from=$settings['scroll_from_scroll_x_from'];
					$scroll_y_from=$settings['scroll_from_scroll_y_from'];
					$scroll_opacity_from=$settings['scroll_from_scroll_opacity_from'];
					$scroll_scale_from=$settings['scroll_from_scroll_scale_from'];
					$scroll_rotate_from=$settings['scroll_from_scroll_rotate_from'];
				}
				
				if($settings["scroll_to_popover_toggle"]==''){
					$scroll_x_to=0;
					$scroll_y_to=-50;
					$scroll_opacity_to=1;
					$scroll_scale_to=1;
					$scroll_rotate_to=0;
				}else{
					$scroll_x_to=$settings['scroll_to_scroll_x_to'];
					$scroll_y_to=$settings['scroll_to_scroll_y_to'];
					$scroll_opacity_to=$settings['scroll_to_scroll_opacity_to'];
					$scroll_scale_to=$settings['scroll_to_scroll_scale_to'];
					$scroll_rotate_to=$settings['scroll_to_scroll_rotate_to'];
				}
				$magic_attr .= ' data-scroll_type="position" ';
				$magic_attr .= ' data-scroll_offset="' . esc_attr($scroll_offset) . '" ';
				$magic_attr .= ' data-scroll_duration="' . esc_attr($scroll_duration) . '" ';
				
				$magic_attr .= ' data-scroll_x_from="' . esc_attr($scroll_x_from) . '" ';
				$magic_attr .= ' data-scroll_x_to="' . esc_attr($scroll_x_to) . '" ';
				$magic_attr .= ' data-scroll_y_from="' . esc_attr($scroll_y_from) . '" ';
				$magic_attr .= ' data-scroll_y_to="' . esc_attr($scroll_y_to) . '" ';
				$magic_attr .= ' data-scroll_opacity_from="' . esc_attr($scroll_opacity_from) . '" ';
				$magic_attr .= ' data-scroll_opacity_to="' . esc_attr($scroll_opacity_to) . '" ';
				$magic_attr .= ' data-scroll_scale_from="' . esc_attr($scroll_scale_from) . '" ';
				$magic_attr .= ' data-scroll_scale_to="' . esc_attr($scroll_scale_to) . '" ';
				$magic_attr .= ' data-scroll_rotate_from="' . esc_attr($scroll_rotate_from) . '" ';
				$magic_attr .= ' data-scroll_rotate_to="' . esc_attr($scroll_rotate_to) . '" ';
				
				$parallax_scroll .= ' parallax-scroll ';
				
				$magic_class .= ' magic-scroll ';
			}
			if( $settings['plus_tooltip'] == 'yes' ) {
				
				$this->add_render_attribute( '_tooltip', 'data-tippy', '', true );

				if (!empty($settings['plus_tooltip_content_type']) && $settings['plus_tooltip_content_type']=='normal_desc') {
					$this->add_render_attribute( '_tooltip', 'title', $settings['plus_tooltip_content_desc'], true );
				}else if (!empty($settings['plus_tooltip_content_type']) && $settings['plus_tooltip_content_type']=='content_wysiwyg') {
					$tooltip_content=$settings['plus_tooltip_content_wysiwyg'];
					$this->add_render_attribute( '_tooltip', 'title', $tooltip_content, true );
				}
				$plus_tooltip_position=($settings["tooltip_opt_plus_tooltip_position"]!='') ? $settings["tooltip_opt_plus_tooltip_position"] : 'top';
				$this->add_render_attribute( '_tooltip', 'data-tippy-placement', $plus_tooltip_position, true );
				
				$tooltip_interactive =($settings["tooltip_opt_plus_tooltip_interactive"]=='' || $settings["tooltip_opt_plus_tooltip_interactive"]=='yes') ? 'true' : 'false';
				$this->add_render_attribute( '_tooltip', 'data-tippy-interactive', $tooltip_interactive, true );
				
				$plus_tooltip_theme=($settings["tooltip_opt_plus_tooltip_theme"]!='') ? $settings["tooltip_opt_plus_tooltip_theme"] : 'dark';
				$this->add_render_attribute( '_tooltip', 'data-tippy-theme', $plus_tooltip_theme, true );
				
				
				$tooltip_arrow =($settings["tooltip_opt_plus_tooltip_arrow"]!='none' || $settings["tooltip_opt_plus_tooltip_arrow"]=='') ? 'true' : 'false';
				$this->add_render_attribute( '_tooltip', 'data-tippy-arrow', $tooltip_arrow , true );
				
				$plus_tooltip_arrow=($settings["tooltip_opt_plus_tooltip_arrow"]!='') ? $settings["tooltip_opt_plus_tooltip_arrow"] : 'sharp';
				$this->add_render_attribute( '_tooltip', 'data-tippy-arrowtype', $plus_tooltip_arrow, true );
				
				$plus_tooltip_animation=($settings["tooltip_opt_plus_tooltip_animation"]!='') ? $settings["tooltip_opt_plus_tooltip_animation"] : 'shift-toward';
				$this->add_render_attribute( '_tooltip', 'data-tippy-animation', $plus_tooltip_animation, true );
				
				$plus_tooltip_x_offset=($settings["tooltip_opt_plus_tooltip_x_offset"]!='') ? $settings["tooltip_opt_plus_tooltip_x_offset"] : 0;
				$plus_tooltip_y_offset=($settings["tooltip_opt_plus_tooltip_y_offset"]!='') ? $settings["tooltip_opt_plus_tooltip_y_offset"] : 0;
				$this->add_render_attribute( '_tooltip', 'data-tippy-offset', $plus_tooltip_x_offset .','. $plus_tooltip_y_offset, true );
				
				$tooltip_duration_in =($settings["tooltip_opt_plus_tooltip_duration_in"]!='') ? $settings["tooltip_opt_plus_tooltip_duration_in"] : 250;
				$tooltip_duration_out =($settings["tooltip_opt_plus_tooltip_duration_out"]!='') ? $settings["tooltip_opt_plus_tooltip_duration_out"] : 200;
				$tooltip_trigger =($settings["tooltip_opt_plus_tooltip_triggger"]!='') ? $settings["tooltip_opt_plus_tooltip_triggger"] : 'mouseenter';
				$tooltip_arrowtype =($settings["tooltip_opt_plus_tooltip_arrow"]!='') ? $settings["tooltip_opt_plus_tooltip_arrow"] : 'sharp';
			}
			
			$move_parallax=$move_parallax_attr=$parallax_move='';
			if(!empty($settings['plus_mouse_move_parallax']) && $settings['plus_mouse_move_parallax']=='yes'){
				$move_parallax='pt-plus-move-parallax';
				$parallax_move='parallax-move';
				$parallax_speed_x=($settings["plus_mouse_parallax_speed_x"]["size"]!='') ? $settings["plus_mouse_parallax_speed_x"]["size"] : 30;
				$parallax_speed_y=($settings["plus_mouse_parallax_speed_y"]["size"]!='') ? $settings["plus_mouse_parallax_speed_y"]["size"] : 30;
				$move_parallax_attr .= ' data-move_speed_x="' . esc_attr($parallax_speed_x) . '" ';
				$move_parallax_attr .= ' data-move_speed_y="' . esc_attr($parallax_speed_y) . '" ';
			}
			$tilt_attr='';
			if(!empty($settings['plus_tilt_parallax']) && $settings['plus_tilt_parallax']=='yes'){
				$tilt_scale=($settings["plus_tilt_opt_tilt_scale"]["size"]!='') ? $settings["plus_tilt_opt_tilt_scale"]["size"] : 1.1;
				$tilt_max=($settings["plus_tilt_opt_tilt_max"]["size"]!='') ? $settings["plus_tilt_opt_tilt_max"]["size"] : 20;
				$tilt_perspective=($settings["plus_tilt_opt_tilt_perspective"]["size"]!='') ? $settings["plus_tilt_opt_tilt_perspective"]["size"] : 400;
				$tilt_speed=($settings["plus_tilt_opt_tilt_speed"]["size"]!='') ? $settings["plus_tilt_opt_tilt_speed"]["size"] : 400;
				
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt', '' , true );
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt-scale', $tilt_scale , true );
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt-max', $tilt_max , true );
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt-perspective', $tilt_perspective , true );
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt-speed', $tilt_speed , true );
				
				if($settings["plus_tilt_opt_tilt_easing"] !='custom'){
					$easing_tilt=$settings["plus_tilt_opt_tilt_easing"];					
				}else if($settings["plus_tilt_opt_tilt_easing"] =='custom'){
					$easing_tilt=$settings["plus_tilt_opt_tilt_easing_custom"];
				}else{
					$easing_tilt='cubic-bezier(.03,.98,.52,.99)';
				}
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt-easing', $easing_tilt , true );
				
			}
			$reveal_effects=$effect_attr='';
			if(!empty($settings["plus_overlay_effect"]) && $settings["plus_overlay_effect"]=='yes'){
				$effect_rand_no =uniqid('reveal');
				$color_1=($settings["plus_overlay_spcial_effect_color_1"]!='') ? $settings["plus_overlay_spcial_effect_color_1"] : '#313131';
				$color_2=($settings["plus_overlay_spcial_effect_color_2"]!='') ? $settings["plus_overlay_spcial_effect_color_2"] : '#ff214f';
				$effect_attr .=' data-reveal-id="'.esc_attr($effect_rand_no).'" ';
				$effect_attr .=' data-effect-color-1="'.esc_attr($color_1).'" ';
				$effect_attr .=' data-effect-color-2="'.esc_attr($color_2).'" ';
				$reveal_effects=' pt-plus-reveal '.esc_attr($effect_rand_no).' ';
			}
			$continuous_animation='';
			if(!empty($settings["plus_continuous_animation"]) && $settings["plus_continuous_animation"]=='yes'){
				if($settings["plus_animation_hover"]=='yes'){
					$animation_class='hover_';
				}else{
					$animation_class='image-';
				}
				$continuous_animation=$animation_class.$settings["plus_animation_effect"];
			}
			
			$before_content =$after_content ='';
			$uid_widget=uniqid("plus");
			if($settings['magic_scroll'] == 'yes' || $settings['plus_tooltip'] == 'yes' || $settings['plus_mouse_move_parallax']=='yes' || $settings['plus_tilt_parallax']=='yes' || $settings["plus_overlay_effect"]=='yes' || $settings["plus_continuous_animation"]=='yes'){
				$before_content .='<div id="'.esc_attr($uid_widget).'" class="plus-widget-wrapper '.esc_attr($magic_class).' '.esc_attr($move_parallax).' '.esc_attr($reveal_effects).' '.esc_attr($continuous_animation).'" '.$effect_attr.' '.$this->get_render_attribute_string( '_tooltip' ).'>';
				$before_content .='<div class="plus-widget-inner-wrap '.esc_attr($parallax_scroll).' " '.$magic_attr.'>';
				if($settings['plus_mouse_move_parallax']=='yes'){
					$before_content .='<div class="plus-widget-inner-parallax '.esc_attr($parallax_move).'" '.$move_parallax_attr.'>';
				}
				if($settings['plus_tilt_parallax']=='yes'){
					$before_content .='<div class="plus-widget-inner-tilt js-tilt" '.$this->get_render_attribute_string( '_tilt_parallax' ).'>';
				}
			}
			if($settings['magic_scroll'] == 'yes' || $settings['plus_tooltip'] == 'yes' || $settings['plus_mouse_move_parallax']=='yes' || $settings['plus_tilt_parallax']=='yes' || $settings["plus_overlay_effect"]=='yes' || $settings["plus_continuous_animation"]=='yes'){
				$after_content .='</div>';
				$after_content .='</div>';
				if($settings['plus_mouse_move_parallax']=='yes'){
					$after_content .='</div>';
				}
				if($settings['plus_tilt_parallax']=='yes'){
					$after_content .='</div>';
				}
				if($settings['plus_tooltip'] == 'yes'){
					$after_content .='<script>
					(function($){
						"use strict";
						$( document ).ready(function() {
							tippy( "#'.esc_attr($uid_widget).'" , {
								arrowType : "'.$tooltip_arrowtype.'",
								duration : ['.esc_attr($tooltip_duration_in).','.esc_attr($tooltip_duration_out).'],
								trigger : "'.esc_attr($tooltip_trigger).'",
								appendTo: document.querySelector("#'.esc_attr($uid_widget).'")
							});
						});
					})(jQuery);
					</script>';
				}
			}
			/*--Plus Extra ---*/
				
				$bf_af ='<div class="pt_plus_before_after '.esc_attr($uid).' '.$alignment.' '.$animated_class.'" '.$attr_data.'  '.$animation_attr.'>';
					$bf_af .='<div class="before-after-inner">
						<div class="before-after-image image-before">
							'.$before_image_tag.'
							'.$before_label_text.'
						</div>
						<div class="before-after-image image-after">
							'.$after_image_tag.'
							'.$after_label_text.'
						</div>
						'.$middle_separator.'
						'.$image_sep.'
					</div>
					'.$bottom_separator;
				$bf_af .='</div>';
			
			echo $before_content.$bf_af.$after_content;
	}
    protected function content_template() {
	
    }

}
