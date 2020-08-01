<?php 
/*
Widget Name: Bodymovin Animations
Description: json parse animation moving
Author: Theplus
Author URI: http://posimyththemes.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class ThePlus_Bodymovin_Animations extends Widget_Base {
	
	public function get_name() {
		return 'tp-wp-bodymovin';
	}

    public function get_title() {
        return esc_html__('LottieFiles Animation', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-scissors theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-creatives');
    }
	
	public function get_keywords() {
		return [ 'bodymoving', 'animations', 'lottiefiles', 'bodylines'];
	}
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Lottie Content', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'json_code_url',
			[
				'label' => esc_html__( 'JSON Input', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'code',
				'description' => 'Note : Download JSON file <a href="https://lottiefiles.com/14288-surfing-waveboard" class="theplus-btn" target="_blank">(example link)</a> and import It’s code/url at space below.',
				'options' => [
					'code'  => esc_html__( 'Code', 'theplus' ),
					'url' => esc_html__( 'URL', 'theplus' ),					
				],
			]
		);
		$this->add_control(
			'content_parse_json_url',
			[
				'label' => esc_html__( 'JSON URL', 'theplus' ),
				'type' => Controls_Manager::URL,				
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'theplus' ),
				'condition' => [
					'json_code_url' => 'url',
				],
			]
		);
		$this->add_control(
            'bm_load_backend',
            [
				'label'   => esc_html__( 'Load in Backend', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',				
			]
		);
		$this->add_control(
            'popup',
            [
				'label'   => esc_html__( 'Elementor Popup', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',				
			]
		);
		$this->add_control(
			'content_parse_json',
			[
				'label' => esc_html__( 'JSON Code', 'theplus' ),
				'type' => Controls_Manager::CODE,
				'language' => 'json',
				'rows' => 20,
				'condition' => [
					'json_code_url' => 'code',
				],
			]
		);
		
		$this->end_controls_section();
		/*extra options start*/
		$this->start_controls_section(
			'section_bm_extra_option',
			[
				'label' => esc_html__( 'Main Settings', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);		
		$this->add_control(
			'play_action_on',
			[
				'label' => __( 'Play on', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'autoplay',
				'options' => [
					''         => __( 'Default', 'theplus' ),
					'autoplay' => __( 'Auto Play', 'theplus' ),
					'hover'    => __( 'On Hover', 'theplus' ),
					'click'    => __( 'On Click', 'theplus' ),
					'column'   => __( 'Column Hover', 'theplus' ),
					'section'  => __( 'Section Hover', 'theplus' ),					
					'mouseinout'  => __( 'Mouse In-Out Effect', 'theplus' ),
					'mousescroll'  => __( 'Scroll Parallax', 'theplus' ),
					'viewport'  => __( 'View Port Based', 'theplus' ),
				],				
			]
		);
		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Loop Animation', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'ON', 'theplus' ),
				'label_off' => esc_html__( 'OFF', 'theplus' ),
				'return_value' => 'true',
				'default' => 'true',
				'separator' => 'before',
				'condition' => [
					'play_action_on!' => '',
				],
			]
		);
		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Animation Play Speed', 'theplus' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 1,
                        'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.5,
				],
				'condition' => [
					'play_action_on!' => ['','mousescroll','mouseinout','hover','click','column','section'],
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'bm_scrollbased',
			[
				'label' => __( 'On Scroll Animation Height', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'bm_custom',
				'options' => [
					'bm_custom' => __( 'Custom Height', 'theplus' ),
					'bm_document'  => __( 'Document Height', 'theplus' ),
				],
				'description' => __( 'Note : If you select "Document height", Animation will start and end based on whole page\'s height. In Custom height, You will be able to select offset and total height for animation.', 'theplus' ),
				'separator' => 'before',
				'condition' => [
					'play_action_on' => 'mousescroll',
				],
			]
		);
		
		$this->add_control(
			'bm_section_duration',
			[
				'label' => __( 'Duration', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 2000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'condition' => [
					'play_action_on' => 'mousescroll',
					'bm_scrollbased' => 'bm_custom',
				],
			]
		);
		$this->add_control(
			'bm_section_offset',
			[
				'label' => __( 'Offset', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition' => [
					'play_action_on' => 'mousescroll',
					'bm_scrollbased' => 'bm_custom',
				],
			]
		);
		$this->add_control(
			'bm_start_custom',
			[
				'label' => esc_html__( 'Custom Animation Start Time', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'ON', 'theplus' ),
				'label_off' => esc_html__( 'OFF', 'theplus' ),
				'condition' => [
					'play_action_on' => ['autoplay','hover','click','column','section','mouseinout','mousescroll','viewport'],
				],
			]
		);
		$this->add_control(
			'bm_start_time',
			[
				'label' => esc_html__( 'Animation Start Time', 'theplus' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 5000,
				'step' => 1,
				'condition' => [
					'play_action_on' => ['autoplay','hover','click','column','section','mouseinout','mousescroll','viewport'],
					'bm_start_custom' => 'yes',
				],
			]
		);
		$this->add_control(
			'bm_end_custom',
			[
				'label' => esc_html__( 'Custom Animation End Time', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'ON', 'theplus' ),
				'label_off' => esc_html__( 'OFF', 'theplus' ),
				'condition' => [
					'play_action_on' => ['autoplay','hover','click','column','section','mouseinout','mousescroll','viewport'],
				],				
			]
		);
		$this->add_control(
			'bm_end_time',
			[
				'label' => esc_html__( 'Animation End Time', 'theplus' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 5000,
				'step' => 1,
				'condition' => [
					'play_action_on' => ['autoplay','hover','click','column','section','mouseinout','mousescroll','viewport'],
					'bm_end_custom' => 'yes',
				],
			]
		);
		$this->add_control(
			'bm_start_end_note',
			[
				'label' => ( 'Note : You need to enter Custom Start Time and End Time from Lottiefiles Web Player. You need to use same format e.g. 30,239, 699 etc.'),
				'type' => Controls_Manager::HEADING,
				'conditions'   => [
					'terms' => [
						[
							'relation' => 'or',
							'terms'    => [																
								[
									'name'     => 'play_action_on','operator' => '==','value'    => 'mouseinout',
									'name'     => 'bm_start_custom','operator' => '==','value'    => 'yes',
								],
								[
									'name'     => 'play_action_on','operator' => '==','value'    => 'mousescroll',
									'name'     => 'bm_start_custom','operator' => '==','value'    => 'yes',
								],
								[
									'name'     => 'play_action_on','operator' => '==','value'    => 'mouseinout',
									'name'     => 'bm_end_custom','operator' => '==','value'    => 'yes',
								],
								[
									'name'     => 'play_action_on','operator' => '==','value'    => 'mousescroll',
									'name'     => 'bm_end_custom','operator' => '==','value'    => 'yes',
								],
							],
						],
					],
				],
			]
		);
		$this->add_control(
			'tp_bm_link',
			[
				'label' => esc_html__( 'URL', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),				
				'default' => 'false',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tp_bm_link_type',
			[
				'label' => esc_html__( 'Type', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  => esc_html__( 'Normal', 'theplus' ),
					'dynamic' => esc_html__( 'Dynamic', 'theplus' ),
				],
				'condition' => [
					'tp_bm_link' => 'yes',					
				],				
			]
		);
		$this->add_control(
			'tp_bm_link_url',
			[
				'label' => esc_html__( 'URL', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'theplus' ),
				'default' => '#',
				'condition' => [
					'tp_bm_link' => 'yes',					
					'tp_bm_link_type' => 'normal',					
				],
			]
		);
		$this->add_control(
			'tp_bm_link_url_dynamic',
			[
				'label' => esc_html__( 'URL', 'theplus' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'theplus' ),
				'show_external' => false,
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
				'condition' => [
					'tp_bm_link' => 'yes',					
					'tp_bm_link_type' => 'dynamic',					
				],
			]
		);
		$this->add_control(
			'tp_bm_link_delay',
			[
				'label' => esc_html__( 'Click Delay', 'theplus' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 10000,
                        'step' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1000,
				],
				'condition' => [
					'tp_bm_link' => 'yes',					
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tp_bm_link_delay_note',
			[
				'label' => ( 'Note : We have added option of Delay in Click for Style “On Click”, You can add delay to finish your animation and after that link will be open.'),
				'type' => Controls_Manager::HEADING,				
			]
		);
		/*$this->add_control(
			'autoplay_viewport',
			[
				'label' => esc_html__( 'Autoplay when in Viewport', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'ON', 'theplus' ),
				'label_off' => esc_html__( 'OFF', 'theplus' ),
				'return_value' => 'true',
				'default' => 'false',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'autostop_viewport',
			[
				'label' => esc_html__( 'Autostop when out of Viewport', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'ON', 'theplus' ),
				'label_off' => esc_html__( 'OFF', 'theplus' ),
				'return_value' => 'true',
				'default' => 'false',
				'separator' => 'before',
			]
		);*/
		$this->add_control(
			'tp_bm_head',
			[
				'label' => esc_html__( 'Animation Heading', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),				
				'default' => 'false',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tp_bm_head_text',
			[
				'label' => esc_html__( 'Heading', 'theplus' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 3,
				'default' => esc_html__( 'Heading', 'theplus' ),
				'placeholder' => esc_html__( 'Type your heading here', 'theplus' ),
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'tp_bm_head' => 'yes',
				],
			]
		);
		$this->add_control(
			'tp_bm_description',
			[
				'label' => esc_html__( 'Animation Description', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),				
				'default' => 'false',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tp_bm_description_text',
			[
				'label' => esc_html__( 'Description', 'theplus' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 3,
				'default' => esc_html__( 'Lorem Ipsum is simply dummy text for the LottieFiles Animation. ', 'theplus' ),
				'placeholder' => esc_html__( 'Type your description here', 'theplus' ),
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'tp_bm_description' => 'yes',
				],
			]
		);
		$this->add_control(
			'anim_renderer',
			[
				'label' => esc_html__( 'Animation Renderer', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'svg',
				'options' => [
					'svg'  => esc_html__( 'SVG', 'theplus' ),
					'canvas' => esc_html__( 'Canvas', 'theplus' ),
					'html' => esc_html__( 'HTML', 'theplus' ),
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*extra options end*/
		
		$this->start_controls_section(
			'section_layout_option',
			[
				'label' => esc_html__( 'Layout Options', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'content_align',
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
				'prefix_ class' => 'text-%s',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'max_width',
			[
				'label' => esc_html__( 'Maximum Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'separator' => 'before',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt-plus-bodymovin' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'minimum_height',
			[
				'label' => esc_html__( 'Minimum Height', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt-plus-bodymovin' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		
		/*style tab*/
		/*heading start*/
		$this->start_controls_section(
            'bm_heading_style',
            [
                'label' => esc_html__('Heading Options', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'tp_bm_head' => 'yes',
				],
            ]
        );
		$this->add_responsive_control(
			'bm_head_align',
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
				'selectors'  => [
					'{{WRAPPER}} .theplus-bodymovin-hd .theplus-bodymovin-heading' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'bm_heading_margin',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .theplus-bodymovin-hd .theplus-bodymovin-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'bm_heading_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .theplus-bodymovin-hd .theplus-bodymovin-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bm_heading_typography',
				'selector' => '{{WRAPPER}} .theplus-bodymovin-hd .theplus-bodymovin-heading',
			]
		);
		$this->start_controls_tabs( 'bm_head_tabs' );
		$this->start_controls_tab(
			'bm_head_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),					
			]
		);
		$this->add_control(
			'bm_heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-bodymovin-hd .theplus-bodymovin-heading' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bm_head_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),					
			]
		);
		$this->add_control(
			'bm_heading_color_h',
			[
				'label' => esc_html__( 'Heading Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-bodymovin-hd:hover .theplus-bodymovin-heading' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*heading end*/
		
		/*description start*/
		$this->start_controls_section(
            'bm_description_style',
            [
                'label' => esc_html__('Description Options', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'tp_bm_description' => 'yes',
				],
            ]
        );
		$this->add_responsive_control(
			'bm_description_align',
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
				'selectors'  => [
					'{{WRAPPER}} .theplus-bodymovin-hd .theplus-bodymovin-description' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'bm_description_margin',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .theplus-bodymovin-hd .theplus-bodymovin-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'bm_description_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .theplus-bodymovin-hd .theplus-bodymovin-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bm_description_typography',
				'selector' => '{{WRAPPER}} .theplus-bodymovin-hd .theplus-bodymovin-description',
			]
		);
		$this->start_controls_tabs( 'bm_desc_tabs' );
		$this->start_controls_tab(
			'bm_desc_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),					
			]
		);
		$this->add_control(
			'bm_description_color',
			[
				'label' => esc_html__( 'Description Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-bodymovin-hd .theplus-bodymovin-description' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bm_desc_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),					
			]
		);
		$this->add_control(
			'bm_description_color_h',
			[
				'label' => esc_html__( 'Description Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-bodymovin-hd:hover .theplus-bodymovin-description' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*description end*/
		
		/*content bg start*/
		$this->start_controls_section(
            'section_c_bg_style',
            [
                'label' => esc_html__('Content Background', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'conditions'   => [
					'terms' => [
						[
							'relation' => 'or',
							'terms'    => [								
								[
									'name'     => 'tp_bm_head','operator' => '==','value'    => 'yes',
								],
								[
									'name'     => 'tp_bm_description','operator' => '==','value'    => 'yes',
								],									
							],
						],
					],
				],
            ]
        );
		$this->add_responsive_control(
			'bmc_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],				
				'selectors' => [
					'{{WRAPPER}} .theplus-bodymovin-hd' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'bmc_margin',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],				
				'selectors' => [
					'{{WRAPPER}} .theplus-bodymovin-hd' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'bmc_tabs' );
		$this->start_controls_tab(
			'bmc_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),					
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bmc_bg',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .theplus-bodymovin-hd',
			]
		);
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'bmc_border',
					'label' => esc_html__( 'Border', 'theplus' ),
					'selector' => '{{WRAPPER}} .theplus-bodymovin-hd',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'bmc_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'theplus' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .theplus-bodymovin-hd' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'bmc_bg_shadow',
				'label' => esc_html__( 'Box Shadow', 'theplus' ),
				'selector' => '{{WRAPPER}} .theplus-bodymovin-hd',
				'separator' => 'before',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bmc_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),					
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bmc_bg_h',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .theplus-bodymovin-hd:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'bmc_border_h',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .theplus-bodymovin-hd:hover',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'bmc_border_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-bodymovin-hd:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'bmc_bg_shadow_h',
			'label' => esc_html__( 'Box Shadow', 'theplus' ),
			'selector' => '{{WRAPPER}} .theplus-bodymovin-hd:hover',
			'separator' => 'before',
		]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*content bg start*/
		
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
				'label'   => esc_html__( 'In Animation Effect', 'theplus' ),
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
		/*style end*/
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
	}
	
	 protected function render() {
        $settings = $this->get_settings_for_display();
		$style_atts = $classes = '';
		
		
		$bm_start_time=$bm_end_time='';
		if(!empty($settings['bm_start_custom']) && $settings['bm_start_custom']=='yes'){
			$bm_start_time = ($settings['bm_start_time']!='') ? $settings['bm_start_time'] : 1;
		}
		if(!empty($settings['bm_end_custom']) && $settings['bm_end_custom']=='yes'){
			$bm_end_time = ($settings['bm_end_time']!='') ? $settings['bm_end_time'] : 100;
		}
		$bm_scrollbased = (!empty($settings['bm_scrollbased'])) ? $settings['bm_scrollbased'] : 'bm_custom';
		$bm_section_duration=500;
		if(!empty($settings['bm_section_duration']['size'])){
			$bm_section_duration = $settings['bm_section_duration']['size'];
		}
		$bm_section_offset=0;
		if(!empty($settings['bm_section_offset']['size'])){
			$bm_section_offset = $settings['bm_section_offset']['size'];
		}
		
		$options=array();
		
		$anim_renderer=$settings["anim_renderer"];
		$content_align=$settings["content_align"];
		$loop =(!empty($settings['loop']) && $settings['loop']=='true') ? true : false;		
		$max_width =(!empty($settings['max_width']["size"])) ? $settings['max_width']["size"].$settings['max_width']["unit"] : '100%';		
		$minimum_height =(!empty($settings['minimum_height']["size"])) ? $settings['minimum_height']["size"].$settings['minimum_height']["unit"] : '';
		$speed =(!empty($settings['speed'])) ? $settings['speed'] : '0.5';
		
		$autoplay_viewport=$autostop_viewport=false;
		if(!empty($settings['play_action_on']) && $settings['play_action_on']=='viewport'){
			$autoplay_viewport =true;
			$autostop_viewport =true;
		}
		$play_action_on ='';
		if(!empty($settings['play_action_on'])){
			$play_action_on =$settings['play_action_on'];
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
		
		$id=uniqid("movin");
		$uid=uniqid();
		
		$options = array(			
			'id'      => $uid,
			'container_id'      => $id,
			'autoplay_viewport' => $autoplay_viewport,
			'autostop_viewport' => $autostop_viewport,
			'loop'              => $loop,
			'width'             => $max_width,
			'height'            => $minimum_height,
			'lazyload'          => false,
			'playSpeed'          => $speed,
			'play_action' => $play_action_on,
			'bm_scrollbased' => $bm_scrollbased,
			'bm_section_duration' => $bm_section_duration,
			'bm_section_offset' => $bm_section_offset,
			'bm_start_time' => $bm_start_time,
			'bm_end_time' => $bm_end_time,
		);
		if ( !empty($settings['content_parse_json']) ) {
			$options['animation_data'] = $settings['content_parse_json'];
		}
		
		if ( !empty($settings['content_parse_json_url']['url']) ) {
		//if ($settings['content_parse_json_url']['url'] != '' ) {
			$ext = pathinfo($settings['content_parse_json_url']['url'], PATHINFO_EXTENSION);			
			if($ext!='json'){
				echo '<h3 class="theplus-posts-not-found">'.esc_html__("Opps!! Please Enter Only JSON File Extension.",'theplus').'</h3>';
				return false;
			}else{
				$get_json = file_get_contents($settings['content_parse_json_url']['url']);
				$options['animation_data'] = $get_json;
			}
		}
		
		if ( !isset( $options['autoplay_onload'] ) ) {
			$options['autoplay_onload'] = true;
		}
		if ( $settings["anim_renderer"] ) {
			$options['renderer'] = esc_attr($settings["anim_renderer"]);
		}
		
	
		if ( $content_align ) {
			$classes .= ' align-' . $content_align;
		}
		if ( !empty( $anim_renderer ) ) {
			$classes .= ' renderer-' . $anim_renderer;
		}
		
		if ( !empty( $anim_renderer ) && $anim_renderer == 'html' ) {
			$style_atts .= 'position: relative;';
		}
		if ( !empty( $content_align ) && $content_align == 'right'  ) {
			$style_atts .= 'margin-left: auto;';
		} elseif ( !empty( $content_align ) && $content_align == 'center' ) {
			$style_atts .= 'margin-right: auto;';
			$style_atts .= 'margin-left: auto;';
		}
		/*$data_attr ='';
		$data_options=json_encode($options);
			$data_attr .= ' data-body-movin-opt=\'' . $data_options . '\'';
			*/
		$settings_opt = '';
		if(!empty($settings['content_parse_json']) || !empty($settings['content_parse_json_url']['url'])){
			if(\Elementor\Plugin::$instance->editor->is_edit_mode() || (!empty($settings['popup']) && $settings['popup']=='yes')){
				if((!empty($settings['bm_load_backend']) && $settings['bm_load_backend']=='yes') || (!empty($settings['popup']) && $settings['popup']=='yes')){
					$settings_opt =  'data-settings=\''.htmlspecialchars(json_encode($options), ENT_QUOTES, 'UTF-8').'\'';
					$settings_opt .= 'data-editor-load="yes"';
					
					if((!empty($settings['popup']) && $settings['popup']=='yes')){
						$settings_opt .= 'data-popup-load="yes"';
					}
					$theplus_conn_opt = get_option( 'theplus_api_connection_data' );
					
					if(!array_key_exists("bodymovin_load_js_check",$theplus_conn_opt)){
						echo '<h3 class="theplus-posts-not-found">'.esc_html__( "Make sure, Your Backend load is enabled from 'ThePlus Addons Settings -> Extra Options' as well.", "theplus" ).'</h3>';
					}
					if((!empty($settings['popup']) && $settings['popup']=='yes')){
						wp_enqueue_script( 'theplus-bodymovin' );
					}
				}else{
					$settings_opt = 'data-editor-load="no"';
					$settings_opt .= 'data-popup-load="no"';
				}
			}else{
				wp_enqueue_script( 'theplus-bodymovin' );
			}
			
			//if(empty($settings['popup'])){
				$this->render_text( $options );
			//}
			$output ='';			
			if((!empty($settings['tp_bm_link']) && $settings['tp_bm_link'] == 'yes') && ((!empty($settings['tp_bm_link_url'])) || (!empty($settings['tp_bm_link_url_dynamic']['url'])) ) && !empty($settings["tp_bm_link_delay"])){				
					
				if(!empty($settings['tp_bm_link_url_dynamic']['url'])){
					$output .='<a class="theplus-bodymovin-link" href="'.$settings['tp_bm_link_url_dynamic']['url'].'">';
				}else{
					$output .='<script>
					(function($){
						"use strict";
							$( document ).ready(function() {
								$("a.theplus-bodymovin-link").click(function (e) {
								e.preventDefault();
								var storeurl = this.getAttribute("href");
								setTimeout(function(){
									 window.location = storeurl;
								}, '.$settings["tp_bm_link_delay"]["size"].');
							}); 
						});
					})(jQuery);
					</script>';
					$output .='<a class="theplus-bodymovin-link" href="'.$settings['tp_bm_link_url'].'">';
				}
				
			}
			
			if((!empty($settings['tp_bm_head']) && $settings['tp_bm_head'] == 'yes') || (!empty($settings['tp_bm_description']) && $settings['tp_bm_description'] == 'yes')){
				$output .='<div class="theplus-bodymovin-hd">';
			}
			
				$output .='<div id="' . esc_attr( $id ) . '" class="pt-plus-bodymovin '.$classes.' '.$animated_class.'" '.$animation_attr.' style="'.$style_atts.'" '.$settings_opt.'>';
				$output .='</div>';
			
			if((!empty($settings['tp_bm_head']) && $settings['tp_bm_head'] == 'yes') || (!empty($settings['tp_bm_description']) && $settings['tp_bm_description'] == 'yes')){
				
				if(!empty($settings['tp_bm_head']) && $settings['tp_bm_head'] == 'yes'){
					$output .='<div class="theplus-bodymovin-heading">'.esc_html($settings['tp_bm_head_text']).'</div>';
				}
				if(!empty($settings['tp_bm_description']) && $settings['tp_bm_description'] == 'yes'){
					$output .='<div class="theplus-bodymovin-description">'.esc_html($settings['tp_bm_description_text']).'</div>';
				}
			$output .='</div>';
			}
				
			if(!empty($settings['tp_bm_link']) && $settings['tp_bm_link'] == 'yes'){
				$output .='</a>';
			}
			
		}else{
			$output ='<h3 class="theplus-posts-not-found">'.esc_html__( "JSON Parse Not Working", "theplus" ).'</h3>';
		}
			echo $before_content.$output.$after_content;
			
		if((!empty($settings['tp_bm_head']) && $settings['tp_bm_head'] == 'yes') || (!empty($settings['tp_bm_description']) && $settings['tp_bm_description'] == 'yes')){
			echo '<style>.theplus-bodymovin-hd{position: relative;display: block;width: 100%;-webkit-transition:all 0.5s linear;moz-transition:all 0.5s linear;-o-transition:all 0.5s linear;-ms-transition:all 0.5s linear;transition:all 0.5s linear;}.theplus-bodymovin-hd .theplus-bodymovin-heading,.theplus-bodymovin-hd .theplus-bodymovin-description {position: relative;display: block;width: 100%;}.theplus-bodymovin-hd .theplus-bodymovin-heading {margin-bottom: 15px;}</style>';
		}
	}
	
	protected function render_text($options = array()) {
		$settings = $this->get_settings_for_display();
		
		if($options){	
			\Theplus_BodyMovin::plus_addAnimation($options);
		}else{
			return;
		}
	}
	
    protected function content_template() {
	
    }
}