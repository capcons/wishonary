<?php
/*
Widget Name: Heading Title 
Description: Creative Heading Options.
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
use Elementor\Group_Control_Text_Shadow;


if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class Theplus_Ele_Heading_Title extends Widget_Base {
		
	public function get_name() {
		return 'tp-heading-title';
	}

    public function get_title() {
        return esc_html__('Heading Title', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-header theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }
	
	protected function _register_controls() {
		/*tab Layout */
		$this->start_controls_section(
			'heading_title_layout_section',
			[
				'label' => esc_html__( 'Content', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
            'heading_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Style', 'theplus'),
                'default' => 'style_1',
                'options' => [
                    'style_1' => esc_html__('Modern', 'theplus'),
                    'style_2' => esc_html__('Simple', 'theplus'),
                    'style_4' => esc_html__('Classic', 'theplus'),
                    'style_5' => esc_html__('Double Border', 'theplus'),
                    'style_6' => esc_html__('Vertical Border', 'theplus'),
                    'style_7' => esc_html__('Dashing Dots', 'theplus'),
                    'style_8' => esc_html__('Unique', 'theplus'),
                    'style_9' => esc_html__('Stylish', 'theplus'),
                ],
            ]
        );
		$this->add_control(
			'select_heading',
			[
				'label' => esc_html__( 'Select Heading', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Default', 'theplus' ),
					'page_title' => esc_html__( 'Page Title', 'theplus' ),					
				],
			]
		);
		$this->add_control(
            'title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Heading Title', 'theplus'),
                'label_block' => true,
                'default' => esc_html__('Heading', 'theplus'),
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'select_heading' => 'default',
				],
            ]
        );		
		$this->add_control(
            'sub_title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Sub Title', 'theplus'),
                'label_block' => true,
                'separator' => 'before',
                'default' => esc_html__('Sub Title', 'theplus'),
				'dynamic' => [
					'active'   => true,
				],
            ]
        );
		$this->add_control(
            'title_s',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Extra Title', 'theplus'),
                'label_block' => true,
                'separator' => 'before',
                'default' => esc_html__('Title', 'theplus'),
				'dynamic' => [
					'active'   => true,
				],
            ]
        );
		$this->add_control(
            'heading_s_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Extra Title Position', 'theplus'),
                'default' => 'text_after',
                'options' => [
                    'text_after' => esc_html__('Prefix', 'theplus'),
                    'text_before' => esc_html__('Postfix', 'theplus'),
                ],
            ]
        );
		$this->add_responsive_control(
			'sub_title_align',
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
					'justify' => [
						'title' => esc_html__( 'Justify', 'theplus' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'prefix_class' => 'text-%s',
				'default' => 'center',
				 'separator' => 'before',				
			]
		);
		$this->add_control(
			'heading_title_subtitle_limit',
			[
				'label' => esc_html__( 'Heading Title & Sub Title Limit', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'display_heading_title_limit',
			[
				'label' => esc_html__( 'Heading Title Limit', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
				],
			]
		);
		$this->add_control(
            'display_heading_title_by', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Limit on', 'theplus'),
                'default' => 'char',
                'options' => [
                    'char' => esc_html__('Character', 'theplus'),
                    'word' => esc_html__('Word', 'theplus'),                    
                ],
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_heading_title_limit'    => 'yes',
				],
            ]
        );
		$this->add_control(
			'display_heading_title_input',
			[
				'label' => esc_html__( 'Heading Title Count', 'theplus' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 1000,
				'step' => 1,				
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_heading_title_limit'    => 'yes',
				],
			]
		);
		$this->add_control(
			'display_title_3_dots',
			[
				'label' => esc_html__( 'Display Dots', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'yes',
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_heading_title_limit'    => 'yes',
				],
			]
		);
		
		$this->add_control(
			'display_sub_title_limit',
			[
				'label' => esc_html__( 'Sub Title Limit', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
				],
			]
		);
		$this->add_control(
            'display_sub_title_by', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Limit on', 'theplus'),
                'default' => 'char',
                'options' => [
                    'char' => esc_html__('Character', 'theplus'),
                    'word' => esc_html__('Word', 'theplus'),                    
                ],
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_sub_title_limit'    => 'yes',
				],
            ]
        );
		$this->add_control(
			'display_sub_title_input',
			[
				'label' => esc_html__( 'Sub Title Count', 'theplus' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 1000,
				'step' => 1,				
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_sub_title_limit'    => 'yes',
				],
			]
		);
		$this->add_control(
			'display_sub_title_3_dots',
			[
				'label' => esc_html__( 'Display Dots', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'yes',
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_sub_title_limit'    => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*tab style/Layout*/		
		
		/*tab style*/
		$this->start_controls_section(
            'section_styling',
            [
                'label' => esc_html__('Separator Settings', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'heading_style!' => ['style_1','style_2','style_8'],
				],
            ]
        );
		$this->add_control(
            'double_color',
            [
                'label' => esc_html__('Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#4d4d4d',
                'selectors' => [
                    '{{WRAPPER}} .heading.style-5 .heading-title:before,{{WRAPPER}} .heading.style-5 .heading-title:after' => 'background: {{VALUE}};',
                ],
				'condition'    => [
					'heading_style' => 'style_5',
				],
            ]
        );
		$this->add_control(
            'double_top',
			[
				'label' => esc_html__( 'Top Separator Height', 'theplus' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'min' => -50,
				'step' => 1,
				'default' => 6,
				'condition'    => [
					'heading_style' => 'style_5',
				],
				'selectors' => [
                    '{{WRAPPER}} .heading.style-5 .heading-title:before' => 'height: {{VALUE}}px;',
                ],
				
			]
        );
		$this->add_control(
            'double_bottom',
			[
				'label' => esc_html__( 'Bottom Separator Height', 'theplus' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'min' => -50,
				'step' => 1,
				'default' => 2,
				'condition'    => [
					'heading_style' => 'style_5',
				],
				'selectors' => [
                    '{{WRAPPER}} .heading.style-5 .heading-title:after' => 'height: {{VALUE}}px;',
                ],
				
			]
        );
		$this->add_control(
			'sep_img',
			[
				'label' => esc_html__( 'Separator With Image', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition'    => [
					'heading_style' => 'style_4',
				],
			]
		);
		$this->add_control(
            'sep_clr',
            [
                'label' => esc_html__('Separator Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#4099c3',
                'selectors' => [
                    '{{WRAPPER}} .heading .title-sep' => 'border-color: {{VALUE}};',
                ],
				'condition'    => [
					'heading_style' => ['style_4','style_9'],
				],
            ]
        );
		$this->add_control(
            'sep_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Separator Width', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'range' => [
					'' => [
						'min' => 0,
						'max' => 100,
						'step' => 2,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
                    '{{WRAPPER}} .heading .title-sep,{{WRAPPER}} .heading .seprator' => 'width: {{SIZE}}{{UNIT}};',
                ],
				'condition'    => [
					'heading_style' => ['style_4','style_9'],
				],
            ]
        );
		$this->add_control(
            'dot_color',
            [
                'label' => esc_html__('Separator Dot Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ca2b2b',
                'selectors' => [
					'{{WRAPPER}} .heading .sep-dot' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .heading.style-7 .head-title:after' => 'color: {{VALUE}}; text-shadow: 15px 0 {{VALUE}}, -15px 0 {{VALUE}};',
                ],
				'condition'    => [
					'heading_style' => ['style_7','style_9'],
				],
            ]
        );
		$this->add_control(
            'sep_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Separator Height', 'theplus'),
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'range' => [
					'' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
                    '{{WRAPPER}} .heading .title-sep' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
				'condition'    => [
					'heading_style' => 'style_4',
				],
            ]
        );
		$this->add_control(
            'top_clr',
            [
                'label' => esc_html__('Separator Vertical Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#1e73be',
                'selectors' => [
                    '{{WRAPPER}} .heading .vertical-divider' => 'background-color: {{VALUE}};',
                ],
				'condition'    => [
					'heading_style' => 'style_6',
				],
            ]
        );
		$this->end_controls_section();
		/*tab style*/
		/*tab Main Title Style*/
		$this->start_controls_section(
            'section_title_styling',
            [
                'label' => esc_html__('Main Title', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'title!' => '',
				],	
								
            ]
        );
		$this->add_control(
            'title_h', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Title Tag', 'theplus'),
                'default' => 'h2',
                'options' => theplus_get_tags_options('a'),
            ]
        );
		$this->add_control(
			'title_link',
			[
				'label' => esc_html__( 'Heading Title Link', 'theplus' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'after',
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'theplus' ),
				'condition' => [
					'title_h' => 'a',
				],
			]
		);	
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'theplus'),
                'selector' => '{{WRAPPER}} .heading .heading-title',
            ]
        );
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Solid', 'theplus' ),
						'icon' => 'fa fa-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'theplus' ),
						'icon' => 'fa fa-barcode',
					],
				],
				'label_block' => false,
				'default' => 'solid',
				'toggle' => true,
			]
		);
		$this->add_control(
			'title_solid_color',
			[
				'label'     => esc_html__( 'Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .heading .heading-title' => 'color: {{VALUE}};',
				],
				'default' => '#313131',
				'condition'    => [
					'title_color' => ['solid'],
				],
			]
		);
		$this->add_control(
            'title_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition'    => [
					'title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_gradient_color1_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 1 Location', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'    => [
					'title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition'    => [
					'title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_gradient_color2_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 2 Location', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'    => [
					'title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'theplus'),
                'default' => 'linear',
                'options' => theplus_get_gradient_styles(),
				'condition'    => [
					'title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_gradient_angle', [
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Gradient Angle', 'theplus'),
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range' => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .heading .heading-title' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'title_color' => ['gradient'],
					'title_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'title_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'theplus'),
				'options' => theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .heading .heading-title' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'title_color' => [ 'gradient' ],
					'title_gradient_style' => 'radial',
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selectors' => '{{WRAPPER}} .heading .heading-title',
				'separator' => 'before',
			]
		);
		$this->add_control(
            'special_effect',
            [
				'label'   => esc_html__( 'Special Effect', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'heading_style' => [ 'style_1','style_2','style_8' ],
				],
			]			
		);
		$this->add_group_control(
			\Theplus_Overlay_Special_Effect_Group::get_type(),
			 [
				'label' => esc_html__( 'Overlay Color', 'theplus' ),
				'name'           => 'overlay_spcial',
				'condition'    => [
					'special_effect' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*tab Title Style*/
		/*tab Sub Title Style*/
		$this->start_controls_section(
            'section_sub_title_styling',
            [
                'label' => esc_html__('Sub Title', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'sub_title!' => '',
				],
            ]
        );
		$this->add_control(
            'sub_title_tag', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Subtitle Tag', 'theplus'),
                'default' => 'h3',
                'options' => theplus_get_tags_options(),
            ]
        );
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'label' => esc_html__('Typography', 'theplus'),
                'selector' => '{{WRAPPER}} .heading .heading-sub-title',
            ]
        );
		$this->add_control(
			'sub_title_color',
			[
				'label' => esc_html__( 'Subtitle Title Color', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Solid', 'theplus' ),
						'icon' => 'fa fa-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'theplus' ),
						'icon' => 'fa fa-barcode',
					],
				],
				'label_block' => false,
				'default' => 'solid',
				'toggle' => true,
			]
		);
		$this->add_control(
			'sub_title_solid_color',
			[
				'label'     => esc_html__( 'Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .heading .heading-sub-title' => 'color: {{VALUE}};',
				],
				'default' => '#313131',
				'condition'    => [
					'sub_title_color' => ['solid'],
				],
			]
		);
		$this->add_control(
            'sub_title_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition'    => [
					'sub_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'sub_title_gradient_color1_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 1 Location', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'    => [
					'sub_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'sub_title_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition'    => [
					'sub_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'sub_title_gradient_color2_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 2 Location', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'    => [
					'sub_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'sub_title_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'theplus'),
                'default' => 'linear',
                'options' => theplus_get_gradient_styles(),
				'condition'    => [
					'sub_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'sub_title_gradient_angle', [
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Gradient Angle', 'theplus'),
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range' => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .heading .heading-sub-title' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{sub_title_gradient_color1.VALUE}} {{sub_title_gradient_color1_control.SIZE}}{{sub_title_gradient_color1_control.UNIT}}, {{sub_title_gradient_color2.VALUE}} {{sub_title_gradient_color2_control.SIZE}}{{sub_title_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'sub_title_color' => ['gradient'],
					'sub_title_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'sub_title_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'theplus'),
				'options' => theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .heading .heading-sub-title' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{sub_title_gradient_color1.VALUE}} {{sub_title_gradient_color1_control.SIZE}}{{sub_title_gradient_color1_control.UNIT}}, {{sub_title_gradient_color2.VALUE}} {{sub_title_gradient_color2_control.SIZE}}{{sub_title_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'sub_title_color' => [ 'gradient' ],
					'sub_title_gradient_style' => 'radial',
				],
				'of_type' => 'gradient',
			]
        );
		$this->end_controls_section();
		/*tab Extra Title Style*/
		/*tab Ex Title Style*/
		$this->start_controls_section(
            'section_extra_title_styling',
            [
                'label' => esc_html__('Extra Title', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'heading_style' => 'style_1',
					'title_s!' => '',
				],
            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ex_title_typography',
                'label' => esc_html__('Typography', 'theplus'),
                'selector' => '{{WRAPPER}} .heading .title-s',
            ]
        );
		$this->add_control(
			'ex_title_color',
			[
				'label' => esc_html__( 'Extra Title Color', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Solid', 'theplus' ),
						'icon' => 'fa fa-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'theplus' ),
						'icon' => 'fa fa-barcode',
					],
				],
				'label_block' => false,
				'default' => 'solid',
				'toggle' => true,
			]
		);
		$this->add_control(
			'ex_title_solid_color',
			[
				'label'     => esc_html__( 'Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .heading .title-s' => 'color: {{VALUE}};',
				],
				'default' => '#313131',
				'condition'    => [
					'ex_title_color' => ['solid'],
				],
			]
		);
		$this->add_control(
            'ex_title_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition'    => [
					'ex_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'ex_title_gradient_color1_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 1 Location', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'    => [
					'ex_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'ex_title_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition'    => [
					'ex_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'ex_title_gradient_color2_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 2 Location', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'    => [
					'ex_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'ex_title_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'theplus'),
                'default' => 'linear',
                'options' => theplus_get_gradient_styles(),
				'condition'    => [
					'ex_title_color' => 'gradient',
					],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'ex_title_gradient_angle', [
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Gradient Angle', 'theplus'),
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range' => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .heading .title-s' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{ex_title_gradient_color1.VALUE}} {{ex_title_gradient_color1_control.SIZE}}{{ex_title_gradient_color1_control.UNIT}}, {{ex_title_gradient_color2.VALUE}} {{ex_title_gradient_color2_control.SIZE}}{{ex_title_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'ex_title_color' => ['gradient'],
					'ex_title_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'ex_title_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'theplus'),
				'options' => theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .heading .title-s' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{ex_title_gradient_color1.VALUE}} {{ex_title_gradient_color1_control.SIZE}}{{ex_title_gradient_color1_control.UNIT}}, {{ex_title_gradient_color2.VALUE}} {{ex_title_gradient_color2_control.SIZE}}{{ex_title_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'ex_title_color' => [ 'gradient' ],
					'ex_title_gradient_style' => 'radial',
				],
				'of_type' => 'gradient',
			]
        );
		$this->end_controls_section();
		/*tab Extra Title Style*/
		
		
		/*tab Setting option*/
		$this->start_controls_section(
            'section_settings_option_styling',
            [
                'label' => esc_html__('Advanced', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		
		$this->add_control(
            'position',
            [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Title Position', 'theplus'),
				'default' => 'after',
				'options' => [
					'before' => esc_html__('Before Title', 'theplus'),
					'after' => esc_html__('After Title', 'theplus'),
				],
			]
		);
		$this->add_control(
            'mobile_center_align',
            [
				'type' => Controls_Manager::SWITCHER,
				'label' => esc_html__('Center Alignment In Mobile', 'theplus'),
				'default' => 'no',				
			]
		);
		$this->end_controls_section();
		/*tab Extra Title Style*/
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
	protected function limit_words($string, $word_limit){
		$words = explode(" ",$string);
		return implode(" ",array_splice($words,0,$word_limit));
	}
	
	protected function render() {

	$settings = $this->get_settings_for_display();
	
		$heading_style=$settings["heading_style"];
		$heading_title_text='';
		if(!empty($settings["select_heading"]) && $settings["select_heading"]=="page_title"){
			$heading_title_text = get_the_title();
		}else if(!empty($settings["title"])){
			if((!empty($settings['display_heading_title_limit']) && $settings['display_heading_title_limit']=='yes') && !empty($settings['display_heading_title_input'])){
				if(!empty($settings['display_heading_title_by'])){				
					if($settings['display_heading_title_by']=='char'){												
						$heading_title_text = substr($settings['title'],0,$settings['display_heading_title_input']);								
					}else if($settings['display_heading_title_by']=='word'){
						$heading_title_text = $this->limit_words($settings['title'],$settings['display_heading_title_input']);					
					}
				}				
				if($settings['display_heading_title_by']=='char'){
					if(strlen($settings["title"]) > $settings['display_heading_title_input']){
						if(!empty($settings['display_title_3_dots']) && $settings['display_title_3_dots']=='yes'){
							$heading_title_text .='...';
						}
					}
				}else if($settings['display_heading_title_by']=='word'){
					if(str_word_count($settings["title"]) > $settings['display_heading_title_input']){
					if(!empty($settings['display_title_3_dots']) && $settings['display_title_3_dots']=='yes'){
						$heading_title_text .='...';
					}
				}
				}
				
				
			}else{				
				$heading_title_text =$settings["title"];
			}
		}
		
		$imgSrc=$sub_gradient_cass =$title_s_gradient_cass =$title_gradient_cass ='';
		if(!empty($settings["sep_img"]["url"])){			
			$imgSrc = $settings["sep_img"]["url"];
		}
		
		if($settings["title_color"] == "gradient") {
			$title_gradient_cass = 'heading-title-gradient';
		}
		if($settings["ex_title_color"] == "gradient") {
			$title_s_gradient_cass = 'heading-title-gradient';
		}
		if($settings["sub_title_color"] == "gradient") {
			$sub_gradient_cass = 'heading-title-gradient';
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
			
			$style_class='';
			if($heading_style =="style_1"){
				$style_class = 'style-1';
			}else if($heading_style =="style_2"){
				$style_class = 'style-2';
			}else if($heading_style =="style_4"){
				$style_class = 'style-4';
			}else if($heading_style =="style_5"){
				$style_class = 'style-5';
			}else if($heading_style =="style_6"){
				$style_class = 'style-6';
			}else if($heading_style =="style_7"){
				$style_class = 'style-7';
			}else if($heading_style =="style_8"){
				$style_class = 'style-8';
			}else if($heading_style =="style_9"){
				$style_class = 'style-9';
			}else if($heading_style =="style_10"){
				$style_class = 'style-10';
			}else if($heading_style =="style_11"){
				$style_class = 'style-11';
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
			
			$uid=uniqid('heading_style');
			
			$heading ='<div class="heading heading_style '.esc_attr($uid).' '.esc_attr($style_class).' '.$animated_class.'" '.$animation_attr.'>';
			
				$mobile_center='';
				if(!empty($settings["mobile_center_align"]) && $settings["mobile_center_align"]=='yes'){
					if ($heading_style =="style_1" || $heading_style =="style_2" || $heading_style =="style_4" || $heading_style =="style_5"  || $heading_style =="style_7" || $heading_style =="style_9"){
						$mobile_center='heading-mobile-center';
					}			
				}
				$heading .='<div class="sub-style" >';

				if ($heading_style =="style_6"){
				$heading .='<div class="vertical-divider top"> </div>';
				}
					$title_con= $s_title_con = $title_s_before ='';
					
					if($heading_style =="style_1" ){
									$title_s_before .='<span class="title-s '.$title_s_gradient_cass.'"> '.$settings["title_s"].' </span>';
					}
						
						if(!empty($heading_title_text)){
						
							$reveal_effects=$effect_attr='';
							if ($heading_style =="style_1" || $heading_style =="style_2" || $heading_style =="style_8"){
								if(!empty($settings["special_effect"]) && $settings["special_effect"]=='yes'){
									$effect_rand_no =uniqid('reveal');
									$color_1=($settings["overlay_spcial_effect_color_1"]!='') ? $settings["overlay_spcial_effect_color_1"] : '#313131';
									$color_2=($settings["overlay_spcial_effect_color_2"]!='') ? $settings["overlay_spcial_effect_color_2"] : '#ff214f';
									$effect_attr .=' data-reveal-id="'.esc_attr($effect_rand_no).'" ';
									$effect_attr .=' data-effect-color-1="'.esc_attr($color_1).'" ';
									$effect_attr .=' data-effect-color-2="'.esc_attr($color_2).'" ';
									$reveal_effects=' pt-plus-reveal '.esc_attr($effect_rand_no).' ';
								}
							}
							
							if ( ! empty( $settings['title_link']['url'] ) && $settings["title_h"]=='a') {
								$this->add_render_attribute( 'titlehref', 'href' ,$settings['title_link']['url'] );
								if ( $settings['title_link']['is_external'] ) {
									$this->add_render_attribute( 'titlehref', 'target', '_blank' );
								}
								if ( $settings['title_link']['nofollow'] ) {
									$this->add_render_attribute( 'titlehref', 'rel', 'nofollow' );
								}
							}
							
			
							$title_con ='<div class="head-title '.esc_attr($mobile_center).'" > ';
								$title_con .='<'.esc_attr($settings["title_h"]).' '.$this->get_render_attribute_string( "titlehref" ).' class="heading-title '.esc_attr($mobile_center).' '.esc_attr($reveal_effects).' '.esc_attr($title_gradient_cass).'" '.$effect_attr.'  data-hover="'.esc_attr($heading_title_text).'">';
								if($settings["heading_s_style"]=="text_before"){
									$title_con.= $title_s_before.$heading_title_text;
								}else{
									$title_con.= $heading_title_text.$title_s_before;
								}
								$title_con .='</'.esc_attr($settings["title_h"]).'>';

								if ($heading_style =="style_4" || $heading_style =="style_9"){
									$title_con .='<div class="seprator sep-l" >';
									$title_con .='<span class="title-sep sep-l" ></span>';
									if ($heading_style =="style_9" ){
										$title_con .='<div class="sep-dot">.</div>';
									}else{	
									  if($imgSrc !=''){  
										$title_con .='<div class="sep-mg"><img src="'.esc_url($imgSrc).'" /></div>';
									  }
									}
									$title_con .='<span class="title-sep sep-r" ></span>';
									$title_con .='</div>';
								}
							$title_con .='</div>';
						}
						$sub_title_dis ='';
						if($settings["sub_title"] !=""){
							if((!empty($settings['display_sub_title_limit']) && $settings['display_sub_title_limit']=='yes') && !empty($settings['display_sub_title_input'])){			
									if(!empty($settings['display_sub_title_by'])){				
										if($settings['display_sub_title_by']=='char'){
											$sub_title_dis = substr($settings['sub_title'],0,$settings['display_sub_title_input']);										
										}else if($settings['display_sub_title_by']=='word'){
											$sub_title_dis = $this->limit_words($settings['sub_title'],$settings['display_sub_title_input']);					
										}
									}
										
										if($settings['display_sub_title_by']=='char'){
											if(strlen($settings["sub_title"]) > $settings['display_heading_title_input']){
												if(!empty($settings['display_sub_title_3_dots']) && $settings['display_sub_title_3_dots']=='yes'){
													$sub_title_dis .='...';
												}
											}
										}else if($settings['display_sub_title_by']=='word'){
											if(str_word_count($settings["sub_title"]) > $settings['display_heading_title_input']){
												if(!empty($settings['display_sub_title_3_dots']) && $settings['display_sub_title_3_dots']=='yes'){
													$sub_title_dis .='...';
												}
											}
										}
												
								}else{
									$sub_title_dis = $settings['sub_title'];
								}
							$s_title_con ='<div class="sub-heading">';
							$s_title_con .='<'.esc_attr($settings["sub_title_tag"]).' class="heading-sub-title '.esc_attr($mobile_center).' '.$sub_gradient_cass.'"> '.$sub_title_dis.' </'.esc_attr($settings["sub_title_tag"]).'>';
							$s_title_con .='</div>';
						}
						if($settings["position"] =="before"){
							$heading.= $s_title_con.$title_con;
							
						}if($settings["position"] =="after"){
							$heading.= $title_con.$s_title_con;
						}
				if ($heading_style =="style_6"){
					$heading .='<div class="vertical-divider bottom"> </div>';
				}
				$heading.='</div>';
			$heading.='</div>';

		echo $before_content.$heading.$after_content;
	}
    protected function content_template() {
	
    }

}
