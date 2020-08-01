<?php 
/*
Widget Name: Advanced Buttons
Description: Advanced Buttons
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
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use TheplusAddons\Theplus_Element_Load;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Advanced_Buttons extends Widget_Base {
		
	public function get_name() {
		return 'tp-advanced-buttons';
	}

    public function get_title() {
        return esc_html__('Advanced Buttons', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-anchor theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-creatives');
    }
	public function get_keywords() {
		return ['buttons', 'advance buttons', 'call to action buttons', 'CTA buttons', 'download buttons', 'creative buttons'];
	}
	
    protected function _register_controls() {
		/*adv button section start*/
		$this->start_controls_section(
			'section_advanced_buttons',
			[
				'label' => esc_html__( 'Advanced Buttons', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'ab_button_type',
			[
				'label' => esc_html__( 'Button Type', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cta',
				'options' => [
					'cta'  => esc_html__( 'CTA Button', 'theplus' ),					
					'download' => esc_html__( 'Download Button', 'theplus' ),
				],
			]
		);
		$this->add_control(
            'cta_button_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Style', 'theplus'),
                'default' => 'tp_cta_st_1',
                'options' => [
                    'tp_cta_st_1' => esc_html__('Style 1', 'theplus'),
                    'tp_cta_st_2' => esc_html__('Style 2', 'theplus'),
                    'tp_cta_st_3' => esc_html__('Style 3', 'theplus'),
                    'tp_cta_st_4' => esc_html__('Style 4', 'theplus'),
                    'tp_cta_st_5' => esc_html__('Style 5', 'theplus'),
                    'tp_cta_st_6' => esc_html__('Style 6', 'theplus'),
                    'tp_cta_st_7' => esc_html__('Style 7', 'theplus'),
                    'tp_cta_st_8' => esc_html__('Style 8', 'theplus'),
                    'tp_cta_st_9' => esc_html__('Style 9', 'theplus'),
                    'tp_cta_st_10' => esc_html__('Style 10', 'theplus'),
                    'tp_cta_st_11' => esc_html__('Style 11', 'theplus'),
                    'tp_cta_st_12' => esc_html__('Style 12', 'theplus'),
                    'tp_cta_st_13' => esc_html__('Style 13', 'theplus'),
                    'tp_cta_st_14' => esc_html__('Style 14', 'theplus'),
                    
                ],
				'condition' => [
					'ab_button_type' => 'cta',
				],
            ]
        );				
		$this->add_control(
            'download_button_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Style', 'theplus'),
                'default' => 'tp_download_st_1',
                'options' => [
                    'tp_download_st_1' => esc_html__('Style 1', 'theplus'),                    
                    'tp_download_st_2' => esc_html__('Style 2', 'theplus'),                    
                    'tp_download_st_3' => esc_html__('Style 3', 'theplus'),                    
                    'tp_download_st_4' => esc_html__('Style 4', 'theplus'),                    
                    'tp_download_st_5' => esc_html__('Style 5', 'theplus'),                    
                ],
				'condition' => [
					'ab_button_type' => 'download',
				],
            ]
        );
		$this->add_control(
			'common_button_text',
			[
				'label' => esc_html__( 'Button Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Read More', 'theplus' ),
				'placeholder' => esc_html__( 'Read More', 'theplus' ),				
			]
		);
		$this->add_control(
			'dbt_button_text_2',
			[
				'label' => esc_html__( 'Loading text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'downloading...', 'theplus' ),
				'placeholder' => esc_html__( 'downloading...', 'theplus' ),
				'selectors' => [
                    '{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .tp-meter:before' => ' content:"{{VALUE}}";',
				],
				'condition' => [
					'download_button_style' => 'tp_download_st_5',
				],
			]
		);
		$this->add_control(
			'dbt_button_text_3',
			[
				'label' => esc_html__( 'Success text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'done!', 'theplus' ),
				'placeholder' => esc_html__( 'done!', 'theplus' ),
				'selectors' => [
                    '{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .tp-meter.is-done:after' => ' content:"{{VALUE}}";',
				],
				'condition' => [
					'download_button_style' => 'tp_download_st_5',
				],
			]
		);		
		$this->add_control(
			'common_button_text_2',
			[
				'label' => esc_html__( 'Extra Text 1', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Theplus', 'theplus' ),
				'placeholder' => esc_html__( 'Button Text 2', 'theplus' ),
				'selectors' => [
                    '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-btn-parrot:before' => ' content:"{{VALUE}}";',
				],
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => ['tp_cta_st_6','tp_cta_st_9','tp_cta_st_13'],					
				],
			]
		);
		$this->add_control(
			'db_common_button_text_2',
			[
				'label' => esc_html__( 'Extra Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Theplus', 'theplus' ),
				'placeholder' => esc_html__( 'Button Text', 'theplus' ),
				'selectors' => [
                    '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-btn-parrot:before' => ' content:"{{VALUE}}";',
				],
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style' => ['tp_download_st_3'],					
				],
			]
		);
		$this->add_responsive_control(
            'db_common_min_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Minimum Width', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 115,
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.tp_download_st_3 .adv-button-link-wrap' => 'min-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style' => ['tp_download_st_3'],					
				],
            ]
        );
		$this->add_control(
			'common_button_text_3',
			[
				'label' => esc_html__( 'Extra Text 2', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Theplus', 'theplus' ),
				'placeholder' => esc_html__( 'Button Text 2', 'theplus' ),
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => ['tp_cta_st_6','tp_cta_st_9','tp_cta_st_13'],
				],
				'selectors' => [
                    '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_6 .adv-button-link-wrap:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-button-link-wrap:hover .adv-btn-parrot:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:after' => ' content:"{{VALUE}}";',
				],
			]
		);
		$this->add_control(
			'common_emoji_normal',
			[
				'label' => esc_html__( 'Normal Emoji', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( '💯', 'theplus' ),
				'placeholder' => esc_html__( 'Normal Emoji', 'theplus' ),
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_8',
				],
				'selectors' => [
                    '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-btn-emoji:before' => ' content:"{{VALUE}}";',
				],				
			]
		);
		$this->add_control(
			'common_emoji_hover',
			[
				'label' => esc_html__( 'Hover Emoji', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( '👏', 'theplus' ),
				'placeholder' => esc_html__( 'Hover Emoji', 'theplus' ),
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_8',
				],
				'selectors' => [
                    '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-button-link-wrap:hover .adv-btn-emoji:before' => ' content:"{{VALUE}}";',
				],				
			]
		);		
		$this->add_responsive_control(
			'st14_button_width',
			[
				'label' => esc_html__( 'Button Width', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 500,
				'step' => 1,				
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => ['tp_cta_st_14'],
				],
			]
		);
		$this->add_responsive_control(
			'st10_button_width',
			[
				'label' => esc_html__( 'Button Width', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => 155,				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_10 .adv-button-link-wrap svg' => 'width: {{SIZE}}px',
				],
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => ['tp_cta_st_10'],
				],
			]
		);
		$this->add_responsive_control(
			'st10_button_height',
			[
				'label' => esc_html__( 'Button Height', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => 55,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_10 .adv-button-link-wrap svg' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => ['tp_cta_st_10'],
				],
			]
		);
		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Link', 'theplus' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'before',
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'theplus' ),
				'default' => [
					'url' => '#',
				],
			]
		);	
		$this->add_control(
			'download_file_name',
			[
				'label' => esc_html__( 'Download File Name', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'download', 'theplus' ),
				'placeholder' => esc_html__( 'Download File Name', 'theplus' ),
				'condition' => [
					'ab_button_type' => 'download',					
				],				
			]
		);
		$this->end_controls_section();
		/*adv button section end*/
		
		/*Alignment  option start*/
		$this->start_controls_section(
            'section_button_align',
            [
                'label' => esc_html__('Alignment', 'theplus'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_responsive_control(
			'button_align',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'flex-start',
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-adv-button-wrapper' => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'download_button_style!' => 'tp_download_st_5',					
				],
			]
		);
		$this->add_responsive_control(
			'button_align_d_st5',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-adv-button-wrapper' => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'download_button_style' => 'tp_download_st_5',					
				],
			]
		);
		$this->add_control(
			'tooltip_alignment',
			[
				'label' => esc_html__( 'Tool tip Position', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'st13_tt_align_left',
				'options' => [
					'st13_tt_align_left' => esc_html__( 'Left', 'theplus' ),
					'st13_tt_align_right'  => esc_html__( 'Right', 'theplus' ),
				],
				'condition' => [
					'ab_button_type!' => 'download',
					'cta_button_style' => 'tp_cta_st_13',
				],	
			]
		);
		
		$this->end_controls_section();
		/*Alignment  option end*/
		
		/*extra option section start*/
		$this->start_controls_section(
			'section_ab_extra_options',
			[
				'label' => esc_html__( 'Extra Options', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => ['tp_cta_st_3','tp_cta_st_4','tp_cta_st_5','tp_cta_st_6'],
				],
			]
		);
		$this->add_responsive_control(
            'min_width_st5',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Minimum width', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 500,
						'step' => 1,
					],
				],
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_5',
				],
				'render_type' => 'ui',			
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap' => 'min-width: calc({{SIZE}}{{UNIT}} + 1px);',
				],				
            ]
        );
		$this->add_control(
			'animate_duration_normal',
			[
				'label' => esc_html__( 'Normal Animation Speed', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,				
				'selectors' => [
                    '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4 .pulsing:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4 .pulsing:after,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .tp-cta-st5-text'=> 'animation-duration: {{VALUE}}s;-o-animation-duration: {{VALUE}}s;
					-ms-animation-duration: {{VALUE}}s;-moz-animation-duration: {{VALUE}}s;-webkit-animation-duration: {{VALUE}}s;',                
				],
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => ['tp_cta_st_3','tp_cta_st_4'],
				],
			]
		);
			$this->add_control(
			'animate_duration_hover',
			[
				'label' => esc_html__( 'Hover Animation Speed', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,				
				'selectors' => [
                    '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4:hover .pulsing:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4:hover .pulsing:after,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap:hover .tp-cta-st5-text' => 'animation-duration: 0.{{VALUE}}s;-o-animation-duration: 0.{{VALUE}}s;-ms-animation-duration: 0.{{VALUE}}s;-moz-animation-duration: 0.{{VALUE}}s;-webkit-animation-duration: 0.{{VALUE}}s;',
				],
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => ['tp_cta_st_3','tp_cta_st_4','tp_cta_st_5'],
				],
			]
		);
		$this->add_control(
			'marquee_speed',
			[
				'label' => esc_html__( 'Marquee Speed', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 12,				
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_6',
				],
			]
		);
		$this->add_control(
            'marquee_direction', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Marquee Direction', 'theplus'),
                'default' => 'left',
                'options' => [
                    'right' => esc_html__('Left to Right', 'theplus'),
                    'left' => esc_html__('Right to Left', 'theplus'),
                ],
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_6',
				],
            ]
        );
		$this->end_controls_section();
		/*extra option section end*/
		
		/* style section start*/
		$this->start_controls_section(
            'section_styling',
            [
                'label' => esc_html__('Advanced Button Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style!' => ['tp_cta_st_10','tp_cta_st_11','tp_cta_st_14'],
				],
            ]
        );		
		$this->add_responsive_control(
            'btn_cta1_2_circle_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Outer Border Height/Width', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 55,
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_1 .adv-button-link-wrap:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_2 .adv-button-link-wrap:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => ['tp_cta_st_1','tp_cta_st_2'],
				],
            ]
        );
		$this->add_responsive_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_1 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_2 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_6 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_7 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_12 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover > span',
			]
		);
		
		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		
		$this->add_control(
			'btn_text_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta .adv-button-link-wrap,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap .tp-cta-st5-text' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_text_extra_color',
			[
				'label' => esc_html__( 'Extra Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_9',
				],
			]
		);		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_1 .adv-button-link-wrap:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_2 .adv-button-link-wrap:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4 .pulsing:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4 .pulsing:after,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_6 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_7 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_12 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_1 .adv-button-link-wrap:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_2 .adv-button-link-wrap:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_6 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_7 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_12 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_1 .adv-button-link-wrap:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_2 .adv-button-link-wrap:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_6 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_7 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_12 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				/*not-cta-4*/
				],	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_1 .adv-button-link-wrap:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_2 .adv-button-link-wrap:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_6 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_7 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_12 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap',				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'btn_text_hover_color',
			[
				'label' => esc_html__( 'Text Hover Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap:hover .tp-cta-st5-text' => 'color: {{VALUE}};',
				],
				'condition' => [					
					'cta_button_style!' => 'tp_cta_st_13',
				],
				
			]
		);
		$this->add_control(
			'btn_cta_13_text_hover_color',
			[
				'label' => esc_html__( 'Text Hover Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
				'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover > span' => 'color: {{VALUE}};',
				],
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_13',
				],
			]
		);		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_1 .adv-button-link-wrap:hover:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_2 .adv-button-link-wrap:hover:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_6 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_7 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_12 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_hover_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_1 .adv-button-link-wrap:hover:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_2 .adv-button-link-wrap:hover:before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_4 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_6 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_7 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_12 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover',
				'separator' => 'before',				
			]
		);
		$this->add_responsive_control(
			'button_hover_radius',
			[
				'label'      => esc_html__( 'Hover Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_1 .adv-button-link-wrap:hover:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_2 .adv-button-link-wrap:hover:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_6 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_7 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_12 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',					
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_1 .adv-button-link-wrap:hover:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_2 .adv-button-link-wrap:hover:before,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_3 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_5 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_6 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_7 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_8 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_12 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover',					
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*style section end*/
		
		/*style cta 13 section start*/
		$this->start_controls_section(
            'section_styling_cta13_tt',
            [
                'label' => esc_html__('Tool Tip Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_13',
				],
            ]
        );		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'buttontt_cta13_typography',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:after',
			]
		);
		
		$this->start_controls_tabs( 'tabs_buttontt_cta13_style' );

		$this->start_controls_tab(
			'tab_buttontt_cta13_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		
		$this->add_control(
			'text_buttontt_cta13_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:after' => 'color: {{VALUE}};',
				],
			]
		);		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'buttontt_cta13_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:before',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'buttontt_cta13_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:before',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'buttontt_cta13_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'buttontt_cta13_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:before',
			]
		);
		$this->add_control(
			'buttontt_cta13_transform',
			[
				'label' => esc_html__( 'Transform css', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'skew(-25deg)',
				'placeholder' => esc_html__( 'skew(-25deg)', 'theplus' ),
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:before' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;'
				],	
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_buttontt_cta13_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'buttontt_cta13_txt_hover_color',
			[
				'label' => esc_html__( 'Text Hover Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover:after' => 'color: {{VALUE}};',
				],
			]
		);
			
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'buttontt_cta13_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover:before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'buttontt_cta13_hover_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover:before',
				'separator' => 'before',				
			]
		);
		$this->add_responsive_control(
			'buttontt_cta13_hover_radius',
			[
				'label'      => esc_html__( 'Hover Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',					
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'buttontt_cta13_hover_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover:before',
			]
		);
			$this->add_control(
			'buttontt_cta13_transform_h',
			[
				'label' => esc_html__( 'Transform css', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'skew(-25deg)',
				'placeholder' => esc_html__( 'skew(-25deg)', 'theplus' ),
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_13 .adv-button-link-wrap:hover:before' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;'
				],	
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*style cta 13 section end*/
		
		/*style cta 10 section start*/
		$this->start_controls_section(
            'section_styling_cta10',
            [
                'label' => esc_html__('Advanced Button Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_10',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_cta10_typography',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_10 .adv-button-link-wrap',				
			]
		);
		$this->add_control(
			'btn_cta10_text_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_10 .adv-button-link-wrap' => 'color: {{VALUE}};',
				],
			]
		);			
		$this->add_control(
			'btn_cta10_fill_color',
			[
				'label' => esc_html__( 'Fill Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_10 .adv-button-link-wrap svg .tp-cpt-btn01' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_cta10_hover_fill_color',
			[
				'label' => esc_html__( 'Hover Fill Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_10 .adv-button-link-wrap:hover .tp-cpt-btn01' => 'fill: {{VALUE}};',
				],
			]
		);	
		$this->add_control(
			'btn_cta10_hover_dot_color',
			[
				'label' => esc_html__( 'Hover Dot Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_10 .adv-button-link-wrap svg .tp-cpt-btn02' => 'stroke: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_cta10_stroke_color',
			[
				'label' => esc_html__( 'Stroke Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_10 .adv-button-link-wrap svg .tp-cpt-btn01' => 'stroke: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
            'btn_cta10_stroke_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Stroke Width', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_10 .adv-button-link-wrap svg' => 'stroke-width: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->end_controls_section();
		/*style cat 10 section end*/
		
		/*style cta 11 section start*/
		$this->start_controls_section(
            'section_styling_cta_11',
            [
                'label' => esc_html__('Advanced Button Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_11',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_cta_11_typography',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap',				
			]
		);
		$this->start_controls_tabs( 'tabs_button_cta_11_style' );
		$this->start_controls_tab(
			'tab_button_cta_11_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'btn_text_cta_11_color_n',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'btn_text_cta_11_bg_n',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap',
			]
		);		
		$this->add_control(
			'btn_text_cta_11_border_n',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_text_cta_11_dots_head_n',
			[
				'label' => esc_html__( 'Dots Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'btn_text_cta_11_dots_bg_n',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap::before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap::after',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_cta_11_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'btn_text_cta_11_color_h',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'btn_text_cta_11_bg_h',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap:hover',
			]
		);	
		$this->add_control(
			'btn_text_cta_11_border_h',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_text_cta_11_dots_head_h',
			[
				'label' => esc_html__( 'Dots Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'btn_text_cta_11_dots_bg_h',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap:hover::before,
				{{WRAPPER}} .pt_plus_adv_button.ab-cta.tp_cta_st_11 .adv-button-link-wrap:hover::after',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*style cta 11 section end*/
		
		/*style cta 14 section start*/
		$this->start_controls_section(
            'section_styling_cta_14',
            [
                'label' => esc_html__('Advanced Button Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ab_button_type' => 'cta',
					'cta_button_style' => 'tp_cta_st_14',
				],
            ]
        );		
		$this->add_control(
			'st14_font_family',
			[
				'label' => esc_html__( 'Font Family', 'theplus' ),
				'type' => \Elementor\Controls_Manager::FONT,
				'default' => "Open Sans",				
			]
		);
		$this->add_control(
			'st14_text_size',
			[
				'label' => esc_html__( 'Text Size', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 500,
				'step' => 1,
				'default' => 14,
			]
		);
		$this->add_control(
			'st14_text_weight',
			[
				'label' => esc_html__( 'Font Weight', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'100' => esc_html__( '100', 'theplus' ),
					'200' => esc_html__( '200', 'theplus' ),
					'300' => esc_html__( '300', 'theplus' ),
					'400' => esc_html__( '400', 'theplus' ),
					'500' => esc_html__( '500', 'theplus' ),
					'600' => esc_html__( '600', 'theplus' ),
					'700' => esc_html__( '700', 'theplus' ),
					'800' => esc_html__( '800', 'theplus' ),
					'900' => esc_html__( '900', 'theplus' ),					
					'' => esc_html__( 'Default', 'theplus' ),
					'bold' => esc_html__( 'Bold', 'theplus' ),
					'normal'  => esc_html__( 'Normal', 'theplus' ),
				],
			]
		);
		
		$this->add_control(
			'st14_text_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default' => '#fff',
			]
		);
		$this->add_control(
			'st14_color_2',
			[
				'label' => esc_html__( 'Top Layer Background Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default' => '#8072fc',
			]
		);
		$this->add_control(
			'st14_color_1',
			[
				'label' => esc_html__( 'Bottom Layer Background Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default' => '#ff5a6e',	
			]
		);		
		$this->add_control(
			'st14_color_3',
			[
				'label' => esc_html__( 'Hover Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default' => '#6fc784',	
			]
		);		
		$this->end_controls_section();
		
		
		/*style download button section start*/
		$this->start_controls_section(
            'section_styling_download',
            [
                'label' => esc_html__('Advanced Button Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style' => ['tp_download_st_1','tp_download_st_2','tp_download_st_4','tp_download_st_5','tp_download_st_3'],
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'st5_typography',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .tp-meter:before,
				{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .tp-meter.is-done:after,
				{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap span',
				'condition' => [					
					'download_button_style!' => ['tp_download_st_1','tp_download_st_2','tp_download_st_4'],
				],
			]
		);
		$this->add_control(
			'st5__color_n',
			[
				'label' => esc_html__( 'Normal Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .adv-button-link-wrap,
					{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap span' => 'color: {{VALUE}};',
				],
				'condition' => [					
					'download_button_style!' => ['tp_download_st_1','tp_download_st_2','tp_download_st_4'],
				],
			]
		);
		$this->add_control(
			'st5_color_h',
			[
				'label' => esc_html__( 'Hover Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .adv-button-link-wrap:hover,
					{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap:hover span' => 'color: {{VALUE}};',
				],
				'condition' => [					
					'download_button_style!' => ['tp_download_st_1','tp_download_st_2','tp_download_st_4'],
				],
			]
		);
		$this->add_control(
			'dst3_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap:before,
					{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap:after' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [					
					'download_button_style!' => ['tp_download_st_1','tp_download_st_2','tp_download_st_4','tp_download_st_5'],
				],
			]
		);
		$this->add_control(
			'dst3_icon_bg',
			[
				'label' => esc_html__( 'Icon Background Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap:before,
					{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap:after' => 'background: {{VALUE}};',
				],
				'condition' => [					
					'download_button_style!' => ['tp_download_st_1','tp_download_st_2','tp_download_st_4','tp_download_st_5'],
				],
			]
		);
		$this->add_control(
			'dst3_icon_bg_h',
			[
				'label' => esc_html__( 'Icon Hover Background Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap:hover:before,
					{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap:hover:after' => 'background: {{VALUE}};',
				],
				'condition' => [					
					'download_button_style!' => ['tp_download_st_1','tp_download_st_2','tp_download_st_4','tp_download_st_5'],
				],
			]
		);
		$this->add_control(
			'st5_complete_txt_color',
			[
				'label' => esc_html__( 'Complete Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .tp-meter.is-done:after' => 'color: {{VALUE}};',
				],
				'condition' => [					
					'download_button_style!' => ['tp_download_st_1','tp_download_st_2','tp_download_st_3','tp_download_st_4'],
				],
			]
		);
		$this->add_responsive_control(
            'd_st4_iconsize',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap i::after' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					
					'download_button_style!' => ['tp_download_st_1','tp_download_st_2','tp_download_st_3','tp_download_st_5'],
				],
            ]
        );
		$this->add_control(
			'download_n_color',
			[
				'label' => esc_html__( 'Normal Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap svg polyline,
					{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap svg path,
					{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2 .adv-button-link-wrap #arrow path, {{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2 .adv-button-link-wrap #arrow polyline' => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap i::after' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tp_download_st_5 .adv-button-link-wrap .icon-download' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .tp_download_st_5 .adv-button-link-wrap .icon-download:after' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .tp_download_st_5 .adv-button-link-wrap .icon-download:before' => 'background: {{VALUE}};',
				],
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style!' => ['tp_download_st_3'],
				],
			]
		);
		$this->add_control(
			'download_h_color',
			[
				'label' => esc_html__( 'Hover Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2 .adv-button-link-wrap:hover #arrow path, {{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2 .adv-button-link-wrap:hover #arrow polyline' => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap:hover i::after' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tp_download_st_5 .adv-button-link-wrap:hover .icon-download' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .tp_download_st_5 .adv-button-link-wrap:hover .icon-download:after' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .tp_download_st_5 .adv-button-link-wrap:hover .icon-download:before' => 'background: {{VALUE}};',
				],
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style!' => ['tp_download_st_1','tp_download_st_3'],
				],
			]
		);
		$this->add_control(
			'download_a_color',
			[
				'label' => esc_html__( 'Download Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap.downloaded svg path#check,
					{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2 .adv-button-link-wrap svg#check' => 'stroke: {{VALUE}};',
				],
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style!' => ['tp_download_st_3','tp_download_st_4','tp_download_st_5'],
				],
			]
		);
		$this->add_control(
			'download_btn_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2 .adv-button-link-wrap.load #border	' => 'stroke: {{VALUE}};',
				],
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style!' => ['tp_download_st_1','tp_download_st_3','tp_download_st_4','tp_download_st_5'],
				],
			]
		);
		$this->start_controls_tabs( 'tabs_download_style' );

		$this->start_controls_tab(
			'tab_download_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'download_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .adv-button-link-wrap,
				{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap span',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'download_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_5 .tp-meter,
				{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap span',
				'separator' => 'before',
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style!' => ['tp_download_st_2'],
				],
			]
		);
		$this->add_responsive_control(
			'download_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_5 .tp-meter,
				{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',					
				],
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style!' => ['tp_download_st_2'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'download_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap,
				{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .adv-button-link-wrap,
				{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap span',
				'separator' => 'before',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_download_Hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'download_background_hover',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_5 .tp-meter,
				{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap:hover span'
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'download_border_hover',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap:hover',
				'separator' => 'before',
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style!' => ['tp_download_st_2','tp_download_st_3','tp_download_st_5'],
				],
			]
		);
		$this->add_control(
			'download_border_hover_st5',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_5 .tp-meter,
					{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap:hover span' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style!' => ['tp_download_st_1','tp_download_st_2','tp_download_st_4'],
				],
			]
		);
		
		$this->add_responsive_control(
			'download_radius_hover',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap.downloaded:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',					
				],
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style!' => ['tp_download_st_2','tp_download_st_3','tp_download_st_5'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'download_shadow_hover',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_1 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_2 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_4 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.tp_download_st_5 .adv-button-link-wrap:hover,
				{{WRAPPER}} .pt_plus_adv_button.ab-download.tp_download_st_5 .tp-meter,
				{{WRAPPER}} .tp_download_st_3 .adv-button-link-wrap:hover span',
				'separator' => 'before',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*style download button section end*/
		
		
		/*Extra text download btn st 1-2-4 start*/
		$this->start_controls_section(
            'section_ext_btn_txt_124_dwnld',
            [
                'label' => esc_html__('Download Text Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ab_button_type' => 'download',
					'download_button_style' => ['tp_download_st_1','tp_download_st_2','tp_download_st_4'],
				],
            ]
        );
		$this->add_responsive_control(
			'ext_btn_124_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);		
		$this->add_responsive_control(
            'ext_btn_124_top_offset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Top Offset', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -250,
						'max' => 250,
						'step' => 1,
					],
				],
				'separator' => 'before',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt' => 'top: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
            'ext_btn_124_right_offset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Right Offset', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -250,
						'max' => 250,
						'step' => 1,
					],
				],
				'separator' => 'before',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ext_btn_124_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt',
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_ext_btn_124' );
		$this->start_controls_tab(
			'tab_ext_btn_124',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_ext_btn_124_color_n',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'tab_ext_btn_124_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tab_ext_btn_124_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'tab_ext_btn_124_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tab_ext_btn_124_shadow',
				'selector' => '{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt',				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_ext_btn_124_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_ext_btn_124_color_h',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'tab_ext_btn_124_background_h',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tab_ext_btn_124_border_h',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt:hover',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'tab_ext_btn_124_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tab_ext_btn_124_shadow_h',
				'selector' => '{{WRAPPER}} .pt-plus-adv-button-wrapper .adv_btn_ext_txt:hover',				
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Extra text download btn st 1-2-4 end*/
		
		/*style download st3 start*/
		$this->start_controls_section(
            'section_styling_d_st3',
            [
                'label' => esc_html__('Box Content', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ab_button_type!' => 'cta',
					'cta_button_style!' => ['tp_download_st_1','tp_download_st_2','tp_download_st_4','tp_download_st_5'],
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_download_style_3' );

		$this->start_controls_tab(
			'tab_download_3_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'download_3_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.tp_download_st_3 .adv-button-link-wrap',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'download_3_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.tp_download_st_3 .adv-button-link-wrap',
				'separator' => 'before',				
			]
		);
		$this->add_responsive_control(
			'download_3_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_adv_button.tp_download_st_3 .adv-button-link-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',					
				],				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'download_3_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.tp_download_st_3 .adv-button-link-wrap',
				'separator' => 'before',
			]
		);
		$this->end_controls_tab();
			$this->start_controls_tab(
			'tab_download_3_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'download_3_h_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_adv_button.tp_download_st_3 .adv-button-link-wrap:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'download_3_border_h',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.tp_download_st_3 .adv-button-link-wrap:hover',
				'separator' => 'before',				
			]
		);
		$this->add_responsive_control(
			'download_3_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_adv_button .tp_download_st_3.adv-button-link-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',					
				],				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'download_3_shadow_h',
				'selector' => '{{WRAPPER}} .pt_plus_adv_button.tp_download_st_3 .adv-button-link-wrap:hover',
				'separator' => 'before',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*style download st3 end*/
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
	}
    protected function render() {
		$settings = $this->get_settings_for_display();
		$data_class='';
		$ab_button_type=$settings['ab_button_type'];
		$cta_button_style=$settings['cta_button_style'];
		$download_button_style=$settings['download_button_style'];		
		
		$download_file_name = ($settings['download_file_name']!='') ? $settings['download_file_name'] : 'download';
		
		$tooltip_alignment=$settings['tooltip_alignment'];
		
		
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
			
		if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href' ,$settings['button_link']['url'] );
			if ( $settings['button_link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
			if ( $settings['button_link']['nofollow'] ) {
				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
			}
		}
		$this->add_render_attribute( 'button', 'class', 'adv-button-link-wrap' );
		$this->add_render_attribute( 'button', 'role', 'button' );
		
		if($ab_button_type=='download'){
			$this->add_render_attribute( 'button', 'download', ''.$download_file_name.'' );
		}
		
				
		$data_class =' ab-'.$ab_button_type.' ';
		if($ab_button_type=='cta'){
			$data_class .=' '.$cta_button_style.' ';				
		}		
		if($ab_button_type=='download'){
			$data_class .=' '.$download_button_style.' ';			
		}
		
		$tt_position_class='';
		if(!empty($cta_button_style) && $cta_button_style=='tp_cta_st_13'){	
			if(!empty($tooltip_alignment) && $tooltip_alignment == 'st13_tt_align_left'){
				$tt_position_class = 'st13_tt_align_left';
			}else if(!empty($tooltip_alignment) && $tooltip_alignment == 'st13_tt_align_right'){
				$tt_position_class = 'st13_tt_align_right';
			}
		}
		if($cta_button_style=='tp_cta_st_14'){			
			if(!empty($settings['button_align']) && $settings['button_align']=='flex-start'){
				$tt_position_class='st14_left';
			}
			if(!empty($settings['button_align']) && $settings['button_align']=='flex-end'){
				$tt_position_class='st14_right';
			}
			if(!empty($settings['button_align']) && $settings['button_align']=='center'){
				$tt_position_class='st14_center';
			}
			
			$data_attr ='data-st14txtcolor='.$settings["st14_text_color"].'';
			$data_attr .= ' data-st14fontfamily=\'' . $settings["st14_font_family"] . '\'';			
			$data_attr .=' data-st14textsize='.$settings["st14_text_size"].'';
			$data_attr .=' data-st14textweight='.$settings["st14_text_weight"].'';
		}else if($ab_button_type=='download'){
			$data_attr =' data-dfname='.$settings["download_file_name"].'';
		}else{
			$data_attr ='';
		}
		
		$down_btn_align='';
		if($ab_button_type=='download'){			
			if(!empty($settings['button_align']) && $settings['button_align']=='flex-start'){
				$down_btn_align='dba_left';
			}
			if(!empty($settings['button_align']) && $settings['button_align']=='flex-end'){
				$down_btn_align='dba_right';
			}
			if(!empty($settings['button_align']) && $settings['button_align']=='center'){
				$down_btn_align='dba_center';
			}
		}
		$id = $this->get_id();
		$uid_advbutton=uniqid("advbutton");			
		$adv_button ='<div class="pt-plus-adv-button-wrapper '.$animated_class.'" '.$animation_attr.'>';
			
			if(!empty($settings['common_button_text'])){
				if($ab_button_type=='download' && ($download_button_style=='tp_download_st_1' || $download_button_style=='tp_download_st_2' || $download_button_style=='tp_download_st_4')){
						$adv_button .='<div class="adv_btn_ext_txt">'.esc_html($settings['common_button_text']).'</div>';						
				}
			}
			$adv_button .='<div id="'.esc_attr($uid_advbutton).'" class="pt_plus_adv_button '.$data_class.' '.$tt_position_class.' '.$down_btn_align.'" '.$data_attr.'>';
				if($cta_button_style=='tp_cta_st_4'){
					$adv_button .='<div class="pulsing"></div>';
				}
				$adv_button .='<a '.$this->get_render_attribute_string( "button" ).'>';				
				$adv_button .= $this->render_text();
				$adv_button .='</a>';
				
				if($download_button_style=='tp_download_st_5'){
					$adv_button .='<div class="tp-meter"><span class="tp-meter-progress"></span></div>';
				}
			$adv_button .='</div>';			
		$adv_button .='</div>';
		if($ab_button_type == 'cta' && $cta_button_style == 'tp_cta_st_9'){
				$adv_button .='<style>#'.$uid_advbutton.'.pt_plus_adv_button.ab-cta.tp_cta_st_9 .adv-btn-parrot{animation: tp-blink-'.$id.' 0.8s infinite;}
				@keyframes tp-blink-'.$id.' {
					  25%,
						75% {
						color: transparent;
					  }
					  40%,
						60% {
						color: '.$settings['btn_text_extra_color'].';
					  }
					}</style>';
		}
		echo $before_content.$adv_button.$after_content;
	}

	protected function content_template() {
	
	}
	protected function render_text() {			
		$settings = $this->get_settings_for_display();
		
		$common_button_text='';		
		$ab_button_type=$settings['ab_button_type'];
		$cta_button_style=$settings['cta_button_style'];
		$download_button_style=$settings['download_button_style'];
		$button_text = $settings['common_button_text'];
		$button_text_1 = $settings['common_button_text_2'];
		$button_text_2 = $settings['common_button_text_3'];		
		$st10_button_width = ($settings['st10_button_width']!='') ? $settings['st10_button_width'] : '150';		
		$st10_button_height = ($settings['st10_button_height']!='') ? $settings['st10_button_height'] : '55';
		$db_button_text_1 = $settings['db_common_button_text_2'];
		
		if(!empty($ab_button_type) && $ab_button_type=='cta'){		
			if($cta_button_style=='tp_cta_st_1' || $cta_button_style=='tp_cta_st_2' || $cta_button_style=='tp_cta_st_3' || $cta_button_style=='tp_cta_st_4' || $cta_button_style=='tp_cta_st_12'){
				$common_button_text ='<span>'.$button_text.'</span>';
			}
			if($cta_button_style=='tp_cta_st_5'){
				$common_button_text ='<p class="tp-cta-st5-text">'.$button_text.'</p>';
			}
			if($cta_button_style=='tp_cta_st_6'){
				$common_button_text =$button_text.'<marquee scrollamount="'.$settings['marquee_speed'].'" direction="'.$settings['marquee_direction'].'" ><span>'.$button_text_1.'</span></marquee>';
			}
			if($cta_button_style=='tp_cta_st_7'){
				$common_button_text =$button_text.'<div class="hands"></div>';
			}
			if($cta_button_style=='tp_cta_st_8'){
				$common_button_text =$button_text.'<div class="adv-btn-emoji"></div><div class="adv-btn-emoji"></div><div class="adv-btn-emoji"></div>';				
			}
			if($cta_button_style=='tp_cta_st_9'){
				$common_button_text =$button_text.'<div class="adv-btn-parrot"></div><div class="adv-btn-parrot"></div><div class="adv-btn-parrot"></div>
						<div class="adv-btn-parrot"></div><div class="adv-btn-parrot"></div><div class="adv-btn-parrot"></div>';
			}
			if($cta_button_style=='tp_cta_st_10'){
				$common_button_text ='<span>'.$button_text.'</span>
									<svg>
									<polyline class="tp-cpt-btn01" points="0 0, '.$st10_button_width.' 0, '.$st10_button_width.' '.$st10_button_height.', 0 '.$st10_button_height.', 0 0"></polyline>
									<polyline class="tp-cpt-btn02" points="0 0, '.$st10_button_width.' 0, '.$st10_button_width.' '.$st10_button_height.', 0 '.$st10_button_height.', 0 0"></polyline>
									</svg>';
			}
			if($cta_button_style=='tp_cta_st_11'){
				$common_button_text =$button_text;				
			}
			if($cta_button_style=='tp_cta_st_13'){				
				$common_button_text =$button_text.'<span>'.$button_text_1.'</span>';
			}
			if($cta_button_style=='tp_cta_st_14'){
				$common_button_text ='<svg class="liquid-button"
									 data-text="'.$button_text.'"
									 data-width="'.$settings['st14_button_width'].'"									 
									 data-force-factor="0.1"
									 data-layer-1-viscosity="0.5"
									 data-layer-2-viscosity="0.4"
									 data-layer-1-mouse-force="400"
									 data-layer-2-mouse-force="500"
									 data-layer-1-force-limit="1"
									 data-layer-2-force-limit="2"
									 data-color1="'.$settings['st14_color_1'].'"
									 data-color2="'.$settings['st14_color_2'].'"
									 data-color3="'.$settings['st14_color_3'].'"></svg>';
			}
		}else if(!empty($ab_button_type) && $ab_button_type=='download'){
			if($download_button_style=='tp_download_st_1'){				
				$common_button_text ='<svg width="22px" height="16px" viewBox="0 0 22 16">
									<path d="M2,10 L6,13 L12.8760559,4.5959317 C14.1180021,3.0779974 16.2457925,2.62289624 18,3.5 L18,3.5 C19.8385982,4.4192991 21,6.29848669 21,8.35410197 L21,10 C21,12.7614237 18.7614237,15 16,15 L1,15" id="check"></path>
									<polyline points="4.5 8.5 8 11 11.5 8.5" class="svg-out"></polyline>
									<path d="M8,1 L8,11" class="svg-out"></path>
									</svg>';
			}
			if($download_button_style=='tp_download_st_2'){
				$common_button_text ='<svg id="arrow" width="14px" height="20px" viewBox="17 14 14 20">
											<path d="M24,15 L24,32"></path>
											<polyline points="30 27 24 33 18 27"></polyline>
									 </svg>
									  <svg id="check" width="21px" height="15px" viewBox="13 17 21 15">
										<polyline points="32.5 18.5 20 31 14.5 25.5"></polyline>
									  </svg>
									  <svg  id="border" width="48px" height="48px" viewBox="0 0 48 48">
										<path d="M24,1 L24,1 L24,1 C36.7025492,1 47,11.2974508 47,24 L47,24 L47,24 C47,36.7025492 36.7025492,47 24,47 L24,47 L24,47 C11.2974508,47 1,36.7025492 1,24 L1,24 L1,24 C1,11.2974508 11.2974508,1 24,1 L24,1 Z"></path>
									  </svg>';
			}
			if($download_button_style=='tp_download_st_3'){
				$common_button_text ='<span>'.$db_button_text_1.'</span><span>'.$button_text.'</span>';
			}
			if($download_button_style=='tp_download_st_4'){
				$common_button_text ='<i class="fa"></i>';
			}
			if($download_button_style=='tp_download_st_5'){
				$common_button_text =''.$button_text.'
									  <span class="icon-wrap">
										<i class="icon-download"></i>
									  </span>';
			}
		}
		
		return $common_button_text;
	}
}
