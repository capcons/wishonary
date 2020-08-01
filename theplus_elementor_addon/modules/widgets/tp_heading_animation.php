<?php 
/*
Widget Name: Heading Animattion 
Description: Text Animation of style.
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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Heading_Animation extends Widget_Base {
		
	public function get_name() {
		return 'tp-heading-animation';
	}

    public function get_title() {
        return esc_html__('Heading Animation', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-i-cursor theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-creatives');
    }

    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Text Animation', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'anim_styles',[
				'label' => esc_html__( 'Animation Style','theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1' => esc_html__( 'Style 1','theplus' ),
					'style-2' => esc_html__( 'Style 2','theplus' ),
					'style-3' => esc_html__( 'Style 3','theplus' ),
					'style-4' => esc_html__( 'Style 4','theplus' ),
					'style-5' => esc_html__( 'Style 5','theplus' ),
					'style-6' => esc_html__( 'Style 6','theplus' ),
				],
			]
		);
		$this->add_control(
            'prefix',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Prefix Text', 'theplus'),
                'label_block' => true,
                'description' => esc_html__('Enter Text, Which will be visible before the Animated Text.', 'theplus'),
                'separator' => 'before',
                'default' => esc_html__('This is ', 'theplus'),
				'dynamic' => [
					'active'   => true,
				],
            ]
        );
		$this->add_control(
			'ani_title',
			[
				'label' => esc_html__( 'Animated Text', 'theplus' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'You need to add Multiple line by ctrl + Enter Or Shift + Enter for animated text.', 'theplus' ),
				'rows' => 5,
				'default' => esc_html__( 'Heading', 'theplus' ),
				'placeholder' => esc_html__( 'Type your description here', 'theplus' ),
				'dynamic' => [
					'active'   => true,
				],
			]
		);
		$this->add_control(
            'ani_title_tag', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Animated Text Tag', 'theplus'),
                'default' => 'h1',
                'options' => theplus_get_tags_options(),
            ]
        );
		$this->add_control(
            'postfix',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Postfix Text', 'theplus'),
                'label_block' => true,
                'description' => esc_html__('Enter Text, Which will be visible After the Animated Text.', 'theplus'),
                'separator' => 'before',
                'default' => esc_html__('Animation', 'theplus'),
				'dynamic' => [
					'active'   => true,
				],
            ]
        );
		$this->add_responsive_control(
			'heading_text_align',
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
				'default' => 'center',
				 'selectors' => [
                    '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline,{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline span' => 'text-align: {{VALUE}};',
                ],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_prefix_postfix_styling',
            [
                'label' => esc_html__('Prefix and Postfix', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'heading_anim_color',
            [
                'label' => esc_html__('Font Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#313131',
                'selectors' => [
                    '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline,{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline span' => 'color: {{VALUE}};',
                ],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'prefix_postfix_typography',
				'selector' => '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline,{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline span',
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_heading_animation_styling',
            [
                'label' => esc_html__('Animated Text', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'ani_color',
            [
                'label' => esc_html__('Font Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#313131',
                'selectors' => [
                    '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline b' => 'color: {{VALUE}};',
                ],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ani_typography',
				'selector' => '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline b',
			]
		);
		$this->add_control(
            'ani_bg_color',
            [
                'label' => esc_html__('Animation Background Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#d3d3d3',
				'condition' => [
					'anim_styles!' => ['style-6'],
				],
                'selectors' => [
                    '{{WRAPPER}} .pt-plus-heading-animation:not(.head-anim-style-6) .pt-plus-cd-headline b' => 'background: {{VALUE}};',
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
		$anim_styles=$settings["anim_styles"];
		$prefix=$settings["prefix"];
		$postfix=$settings["postfix"];
		$ani_title=$settings["ani_title"];
		$ani_title_tag=!empty($settings["ani_title_tag"]) ? $settings["ani_title_tag"] : 'h1';
		
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
			
			$heading_animation_back = 'style="';
			if($settings["ani_bg_color"] != "") {
				$heading_animation_back .='background: '.esc_attr($settings["ani_bg_color"]).';';
			}
			$heading_animation_back .= '"';		
				
				
			// Order of replacement
			$order   = array("\r\n", "\n", "\r", "<br/>", "<br>");
			$replace = '|';
				
			// Processes \r\n's first so they aren't converted twice.
			$str = str_replace($order, $replace, $ani_title);
			
			$lines = explode("|", $str);
			
			$count_lines = count($lines);
				
			$background_css='';
			if(!empty($settings["ani_color"])) {
				$background_css .= 'background-color: '.esc_attr($settings["ani_color"]).';';
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
				jQuery( document ).ready(function() {
					"use strict";
					tippy( "#'.esc_attr($uid_widget).'" , {
						arrowType : "'.$tooltip_arrowtype.'",
						duration : ['.esc_attr($tooltip_duration_in).','.esc_attr($tooltip_duration_out).'],
						trigger : "'.esc_attr($tooltip_trigger).'",
						appendTo: document.querySelector("#'.esc_attr($uid_widget).'")
					});
				});
				</script>';
			}
		}
		/*--Plus Extra ---*/
		
		
		$uid=uniqid('heading-animation');
		
		$heading_animation ='<div class="pt-plus-heading-animation heading-animation head-anim-'.esc_attr($anim_styles).' '.esc_attr($animated_class).' '.esc_attr($uid).'"  '.$animation_attr.'>';
		
		if ($anim_styles == 'style-1') {	
			$heading_animation .='<'.$ani_title_tag.' class="pt-plus-cd-headline letters type" >';
			if($prefix != ''){
				$heading_animation .='<span >'.$prefix.' </span>';	
			}
			$heading_animation .='<span class="cd-words-wrapper waiting" '.$heading_animation_back.'>';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= '<b  class="is-visible"> '.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= '<b> '.strip_tags($line).'</b>';
				}
				$i++;
			}
			
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';		
			$heading_animation .='</span>';
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).' </span>';	
			}
			$heading_animation .='</'.$ani_title_tag.'>';
		}
		if ($anim_styles == 'style-2') {
			$heading_animation .='<'.$ani_title_tag.' class="pt-plus-cd-headline rotate-1" >';
			if($prefix != ''){
				$heading_animation .='<span >'.esc_html($prefix).' </span>';	
			}	
			$heading_animation .='<span class="cd-words-wrapper">';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= '<b  class="is-visible"> '.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= '<b> '.strip_tags($line).'</b>';
				}
				$i++;
			} 
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';
			$heading_animation .='</span>';	
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).' </span>';	
			}
			$heading_animation .='</'.$ani_title_tag.'>';	
		}
		if ($anim_styles == 'style-3') {
			$heading_animation .='<'.$ani_title_tag.' class="pt-plus-cd-headline zoom" >';
			if($prefix != ''){
				$heading_animation .='<span >'.esc_html($prefix).' </span>';	
			}	
			$heading_animation .='<span class="cd-words-wrapper">';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= ' <b  class="is-visible ">'.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= ' <b>'.strip_tags($line).'</b>';
				}
				$i++;
			}
			
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';
			$heading_animation .='</span>';
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).' </span>';	
			}		
			$heading_animation .='</'.$ani_title_tag.'>';	
		}
		if ($anim_styles == 'style-4') {
			$heading_animation .='<'.$ani_title_tag.' class="pt-plus-cd-headline loading-bar " >';
			if($prefix != ''){
				$heading_animation .='<span >'.esc_html($prefix).' </span>';	
			}
			$heading_animation .='<span class="cd-words-wrapper">';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= ' <b class="is-visible ">'.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= ' <b>'.strip_tags($line).'</b>';
				}
				$i++;
			}
			
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';				
			$heading_animation .='</span>';	
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).'</span>';	
			}		
			$heading_animation .='</'.$ani_title_tag.'>';	
		}		
		if ($anim_styles == 'style-5') {
			$heading_animation .='<'.$ani_title_tag.' class="pt-plus-cd-headline push" >';
			if($prefix != ''){
				$heading_animation .='<span >'.esc_html($prefix).' </span>';	
			}
			$heading_animation .='<span class="cd-words-wrapper">';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= '<b  class="is-visible "> '.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= '<b> '.strip_tags($line).'</b>';
				}
				$i++;
			}
			
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';
			$heading_animation .='</span>';	
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).' </span>';	
			}		
			$heading_animation .='</'.$ani_title_tag.'>';
		}
		if ($anim_styles == 'style-6') {
			$heading_animation .='<'.$ani_title_tag.' class="pt-plus-cd-headline letters scale" >';
			if($prefix != ''){
				$heading_animation .='<span >'.esc_html($prefix).' </span>';	
			}
			$heading_animation .='<span class="cd-words-wrapper style-6"   >';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= '<b  class="is-visible ">'.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= '<b>'.strip_tags($line).'</b>';
				}
				$i++;
			}
			
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';
				$heading_animation .='</span>';	
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).' </span>';	
			}
			$heading_animation .='</'.$ani_title_tag.'>';	
		}
		$heading_animation .='</div>';
				
		$css_rule='';
		$css_rule .= '<style>';
			$css_rule .= '.'.esc_js($uid).' .pt-plus-cd-headline.loading-bar .cd-words-wrapper::after{'.esc_js($background_css).'}';
		$css_rule .= '</style>';
		echo $css_rule.$before_content.$heading_animation.$after_content;
	}
    protected function content_template() {
	
    }

}