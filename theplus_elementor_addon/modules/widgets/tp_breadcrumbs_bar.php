<?php 
/*
Widget Name: Breadcrumbs Bar 
Description: Breadcrumbs Bar 
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
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Breadcrumbs_Bar extends Widget_Base {
		
	public function get_name() {
		return 'tp-breadcrumbs-bar';
	}

    public function get_title() {
        return esc_html__('Breadcrumbs Bar', 'theplus');
    }
	
    public function get_icon() {
        return 'fa fa-angle-right theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-header');
    }
	
    protected function _register_controls() {
		/*start advanced typography*/
		$this->start_controls_section(
			'breadcrumbs_bar_content_section',
			[
				'label' => esc_html__( 'Breadcrumbs Bar', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'breadcrumbs_style',
			[
				'label' => esc_html__( 'Breadcrumbs Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1'  => esc_html__( 'Style-1', 'theplus' ),
					'style_2' => esc_html__( 'Style-2', 'theplus' ),										
				],
			]
		);
		$this->add_control(
			'breadcrumbs_full_auto',
			[
				'label' => esc_html__( 'Breadcrumbs Full Width', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',	
				'condition' => [
					'breadcrumbs_style' => ['style_1'],
				],
			]
		);
		
		$this->add_responsive_control(
			'breadcrumbs_align',
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
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'prefix_class' => 'text-%s',
				'default' => 'left',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar #breadcrumbs' => 'justify-content: {{VALUE}};',
				],
				
			]
		);
		$this->end_controls_section();
		
		/*home icon + text*/
		$this->start_controls_section(
			'breadcrumbs_bar_main_navigation',
			[
				'label' => esc_html__( 'Home Title/Icon', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'home_title',
			[
				'label' => esc_html__( 'Home Title', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Home', 'theplus' ),				
			]
		);
		
		$this->add_control(
			'home_select_icon',
			[
				'label' => esc_html__( 'Select Icon', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('You can select Icon or Image using this option.','theplus'),
				'default' => 'icon',
				'options' => [
					''  => esc_html__( 'None', 'theplus' ),
					'icon' => esc_html__( 'Icon', 'theplus' ),
				],
				
			]
		);
		$this->add_control(
			'icon_font_style',
			[
				'label' => esc_html__( 'Icon Font', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome', 'theplus' ),
					'icon_mind' => esc_html__( 'Icons Mind', 'theplus' ),
					'icon_image' => esc_html__( 'Icon Image', 'theplus' ),
				],
				'condition' => [				
					'home_select_icon' => 'icon',
				],
			]
		);
		$this->add_control(
			'icon_fontawesome',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-bank',
				'condition' => [				
					'home_select_icon' => 'icon',
					'icon_font_style' => 'font_awesome',
				],
			]
		);
		$this->add_control(
			'icons_mind',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '',
				'label_block' => true,
				'options' => theplus_icons_mind(),
				'condition' => [				
					'home_select_icon' => 'icon',
					'icon_font_style' => 'icon_mind',
				],
			]
		);
		$this->add_control(
			'icons_image',
			[
				'label' => esc_html__( 'Use Image As icon', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'media_type' => 'image',
				'condition' => [				
					'home_select_icon' => 'icon',
					'icon_font_style' => 'icon_image',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'icons_image_thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
				'condition' => [				
					'home_select_icon' => 'icon',
					'icon_font_style' => 'icon_image',
				],
			]
		);
		$this->end_controls_section();
		/*home icon + text*/
		
		/*separator icon start*/		
		$this->start_controls_section(
			'breadcrumbs_sep_icon',
			[
				'label' => esc_html__( 'Separator Icon', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'sep_select_icon',
			[
				'label' => esc_html__( 'Select Icon', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('You can select Icon or Image using this option.','theplus'),
				'default' => '',
				'options' => [
					''  => esc_html__( 'None', 'theplus' ),
					'sep_icon' => esc_html__( 'Icon', 'theplus' ),
				],				
			]
		);
		$this->add_control(
			'sep_icon_font_style',
			[
				'label' => esc_html__( 'Icon Font', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sep_font_awesome',
				'options' => [
					'sep_font_awesome'  => esc_html__( 'Font Awesome', 'theplus' ),
					'sep_icon_mind' => esc_html__( 'Icons Mind', 'theplus' ),
					'sep_icon_image' => esc_html__( 'Icon Image', 'theplus' ),
				],
				'condition' => [				
					'sep_select_icon' => 'sep_icon',
				],
			]
		);
		$this->add_control(
			'sep_icon_fontawesome',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-chevron-right',
				'condition' => [
					'sep_select_icon' => 'sep_icon',
					'sep_icon_font_style' => 'sep_font_awesome',
				],
			]
		);
		$this->add_control(
			'sep_icons_mind',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '',
				'label_block' => true,
				'options' => theplus_icons_mind(),
				'condition' => [
					'sep_select_icon' => 'sep_icon',
					'sep_icon_font_style' => 'sep_icon_mind',
				],
			]
		);
		$this->add_control(
			'sep_icons_image',
			[
				'label' => esc_html__( 'Use Image As icon', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'media_type' => 'image',
				'condition' => [
					'sep_select_icon' => 'sep_icon',
					'sep_icon_font_style' => 'sep_icon_image',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'sep_icons_image_thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
				'condition' => [
					'sep_select_icon' => 'sep_icon',
					'sep_icon_font_style' => 'sep_icon_image',
				],
			]
		);
		$this->end_controls_section();
		/*seprator icon end*/
		
		/*extra on/off start*/		
		$this->start_controls_section(
			'breadcrumbs_on_off',
			[
				'label' => esc_html__( 'Breadcrumbs On/Off', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);	
		$this->add_control(
			'breadcrumbs_on_off_home',
			[
				'label' => esc_html__( 'Home', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'breadcrumbs_on_off_parent',
			[
				'label' => esc_html__( 'Parent', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'breadcrumbs_on_off_current',
			[
				'label' => esc_html__( 'Current', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->end_controls_section();	
		/*extra on/off end*/
		
		/*style section start*/
		$this->start_controls_section(
            'section_bredcrums_styling',
            [
                'label' => esc_html__('Breadcrumbs Text', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'bredcrums_margin',
			[
				'label' => esc_html__( 'Gap', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs .current .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs .current_active .current_tab_sec' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'    => [
					'breadcrumbs_style' => ['style_2'],
				],
			]
		);
		$this->add_responsive_control(
			'bredcrums_padding_gap',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs .current .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs .current_active .current_tab_sec' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'    => [
					'breadcrumbs_style' => ['style_2'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bredcrums_text_typo',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs .current_active,
				{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs span.current .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs .current_active .current_tab_sec',
			]
		);
		/*breadcrumb text color Tab*/		
		$this->start_controls_tabs( 'tabs_bread_text' );
		$this->start_controls_tab(
			'bred_text_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'bred_text_color_option',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Classic', 'theplus' ),
						'icon' => 'fa fa-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'theplus' ),
						'icon' => 'fa fa-barcode',						
					],
				],
				'label_block' => false,
				'default' => 'solid',
			]
		);
		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs .current_tab_sec,
					{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs .current_tab_sec' => 'color: {{VALUE}}',
				],
				'condition' => [
					'bred_text_color_option' => 'solid',
				],
			]
		);
		$this->add_control(
            'text_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'bred_text_color_option' => 'gradient',
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'text_gradient_color1_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 1 Location', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition' => [
					'bred_text_color_option' => 'gradient',
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'text_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition' => [
					'bred_text_color_option' => 'gradient',
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'text_gradient_color2_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 2 Location', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
					],
				'render_type' => 'ui',
				'condition' => [
					'bred_text_color_option' => 'gradient',
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'text_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'theplus'),
                'default' => 'linear',
                'options' => theplus_get_gradient_styles(),
				'condition' => [
					'bred_text_color_option' => 'gradient',
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'text_gradient_angle', [
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
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs  .current_tab_sec' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{text_gradient_color1.VALUE}} {{text_gradient_color1_control.SIZE}}{{text_gradient_color1_control.UNIT}}, {{text_gradient_color2.VALUE}} {{text_gradient_color2_control.SIZE}}{{text_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'bred_text_color_option' => 'gradient',
					'text_gradient_style' => ['linear'],
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'text_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'theplus'),
				'options' => theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs .current_tab_sec' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{text_gradient_color1.VALUE}} {{text_gradient_color1_control.SIZE}}{{text_gradient_color1_control.UNIT}}, {{text_gradient_color2.VALUE}} {{text_gradient_color2_control.SIZE}}{{text_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'text_color_option' => 'gradient',
					'text_gradient_style' => 'radial',
					'breadcrumbs_style!' => ['style_2'],
			],
			'of_type' => 'gradient',
			]
        );
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'bred_text_border_option',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs .current_tab_sec,
				{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs .current_tab_sec',
				'separator' => 'before',
			]
		);
		
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bred_text_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'bred_text_hover_color_option',
			[
				'label' => esc_html__( 'Text Hover Color', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Classic', 'theplus' ),
						'icon' => 'fa fa-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'theplus' ),
						'icon' => 'fa fa-barcode',
					],
				],
				'label_block' => false,
				'default' => 'solid',
			]
		);
		$this->add_control(
			'active_page_text_heading',
			[
				'label' => esc_html__( 'Active Page Text color if required then click below button', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'active_page_text_default',
			[
				'label' => esc_html__( 'Active Color for Page Title', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'text_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a:hover,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current:hover .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current_active .current_tab_sec,
					{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs a:hover,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs span.current:hover .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs span.current_active .current_tab_sec' => 'color: {{VALUE}}',
				],
				'condition' => [
					'bred_text_hover_color_option' => 'solid',
				],
			]
		);
		$this->add_control(
            'text_hover_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'bred_text_hover_color_option' => 'gradient',
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'text_hover_gradient_color1_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 1 Location', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition' => [
					'bred_text_hover_color_option' => 'gradient',
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'text_hover_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition' => [
					'bred_text_hover_color_option' => 'gradient',
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'text_hover_gradient_color2_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 2 Location', 'theplus'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
					],
				'render_type' => 'ui',
				'condition' => [
					'bred_text_hover_color_option' => 'gradient',
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'text_hover_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'theplus'),
                'default' => 'linear',
                'options' => theplus_get_gradient_styles(),
				'condition' => [
					'bred_text_hover_color_option' => 'gradient',
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'text_hover_gradient_angle', [
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
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a:hover,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current:hover .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current_active .current_tab_sec' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{text_hover_gradient_color1.VALUE}} {{text_hover_gradient_color1_control.SIZE}}{{text_hover_gradient_color1_control.UNIT}}, {{text_hover_gradient_color2.VALUE}} {{text_hover_gradient_color2_control.SIZE}}{{text_hover_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'bred_text_hover_color_option' => 'gradient',
					'text_hover_gradient_style' => ['linear'],
					'breadcrumbs_style!' => ['style_2'],
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'text_hover_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'theplus'),
				'options' => theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a:hover,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current:hover .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current_active .current_tab_sec' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{text_hover_gradient_color1.VALUE}} {{text_hover_gradient_color1_control.SIZE}}{{text_hover_gradient_color1_control.UNIT}}, {{text_hover_gradient_color2.VALUE}} {{text_hover_gradient_color2_control.SIZE}}{{text_hover_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'bred_text_hover_color_option' => 'gradient',
					'text_hover_gradient_style' => 'radial',
					'breadcrumbs_style!' => ['style_2'],
			],
			'of_type' => 'gradient',
			]
        );
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'bred_text_border_hover_option',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a:hover,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current:hover .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current_active:hover .current_tab_sec,
				{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs a:hover,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs span.current:hover .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs span.current_active:hover .current_tab_sec',
				'separator' => 'before',
			]
		);		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*breadcrumb text color end*/
		
		/*home icon style start*/
		$this->start_controls_section(
            'section_icon_styling',
            [
                'label' => esc_html__('Home icon Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs i.bread-home-icon,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs i.bread-home-icon,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner nav#breadcrumbs img.bread-home-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 35,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs i.bread-home-icon,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs i.bread-home-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [					
					'icon_font_style' => ['font_awesome','icon_mind'],
				],
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs i.bread-home-icon,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs i.bread-home-icon' => 'color: {{VALUE}}',
				],
				'condition' => [					
					'icon_font_style' => ['font_awesome','icon_mind'],
				],
			]
		);	
		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( 'Hover Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a:hover i.bread-home-icon,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs a:hover i.bread-home-icon' => 'color: {{VALUE}}',
				],
				'condition' => [					
					'icon_font_style' => ['font_awesome','icon_mind'],
				],
			]
		);	
		$this->add_responsive_control(
			'image_size',
			[
				'label' => esc_html__( 'Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 250,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner nav#breadcrumbs img.bread-home-img' => 'max-width: {{SIZE}}{{UNIT}};height: auto;'
				],
				'separator' => 'after',
				'condition' => [
					'icon_font_style' => 'icon_image',
				],
			]
		);
		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner nav#breadcrumbs img.bread-home-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'icon_font_style' => 'icon_image',
				],
			]
		);		
		
		$this->end_controls_section();
		/*home icon style end*/
		
		/*separator style start*/
		$this->start_controls_section(
            'section_seprator_styling',
            [
                'label' => esc_html__('Separator Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
		'seprator_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner nav#breadcrumbs i.bread-sep-icon:before,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner nav#breadcrumbs img.bread-sep-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'seprator_size',
			[
				'label' => esc_html__( 'Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 35,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs i.bread-sep-icon:before,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs i.bread-sep-icon:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'sep_icon_font_style' => ['sep_font_awesome','sep_icon_mind'],
				],
			]
		);
		$this->add_control(
			'seprator_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs i.bread-sep-icon:before,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs i.bread-sep-icon:before' => 'color: {{VALUE}}',
				],
				'condition' => [
					'sep_icon_font_style' => ['sep_font_awesome','sep_icon_mind'],
				],
			]
		);	
		$this->add_control(
			'seprator_color_hover',
			[
				'label' => esc_html__( 'Hover Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a:hover i.bread-sep-icon:before,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_2 nav#breadcrumbs a:hover i.bread-sep-icon:before' => 'color: {{VALUE}}',
				],
				'condition' => [
					'sep_icon_font_style' => ['sep_font_awesome','sep_icon_mind'],
				],
			]
		);
		$this->add_responsive_control(
			'seprator_image_size',
			[
				'label' => esc_html__( 'Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 250,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner nav#breadcrumbs img.bread-sep-icon' => 'max-width: {{SIZE}}{{UNIT}};height: auto;'
				],
				'separator' => 'after',
				'condition' => [
					'sep_icon_font_style' => 'sep_icon_image',
				],
			]
		);
		$this->end_controls_section();
		/*separator style end*/
		/*letter limit start*/
		$this->start_controls_section(
            'section_letter_limit',
            [
                'label' => esc_html__('Letter Limit', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		
		$this->add_control(
			'letter_limit_parent_switch',
			[
				'label' => esc_html__( 'Parent', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'return_value' => 'yes',
				'default' => 'no',
				
			]
		);
		$this->add_control(
			'letter_limit_parent',
			[
				'label' => esc_html__( 'Parent', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 10,
				'separator' => 'after',
				'condition' => [
					'letter_limit_parent_switch' => 'yes',
				],				
			]
		);
		$this->add_control(
			'letter_limit_current_switch',
			[
				'label' => esc_html__( 'Current', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control(
			'letter_limit_current',
			[
				'label' => esc_html__( 'Current', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 10,
				'separator' => 'after',
				'condition' => [
					'letter_limit_current_switch' => 'yes',
				],				
			]
		);
		$this->end_controls_section();
		/*letter limit end*/
		
		/*content background for style 1 start*/
		$this->start_controls_section(
            'section_content_background_st1_styling',
            [
                'label' => esc_html__('Content Background Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'breadcrumbs_style' => ['style_1'],
				],
            ]
        );
		$this->add_responsive_control(
		'c_bg_st1_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_background_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1',
			]
		);
		$this->add_responsive_control(
			'content_background_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_background_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_background_box_shadow_hover',
				'label' => esc_html__( 'Box Shadow Hover', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner:hover.bred_style_1',
			]
		);
		$this->end_controls_section();
		/*content background for style 1 end*/
		
		/*separate background style start*/
		$this->start_controls_section(
            'section_c_bg_st2_styl',
            [
                'label' => esc_html__('Separate Background Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				
            ]
        );
		$this->add_responsive_control(
			'sep_bg_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs .current_tab_sec' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'    => [
					'breadcrumbs_style' => ['style_1'],
				],
			]
		);
		$this->add_responsive_control(
			'sep_bg_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs .current_tab_sec' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'    => [
					'breadcrumbs_style' => ['style_1'],
				],
			]
		);		
		$this->start_controls_tabs( 'tabs_c_bg_st2' );
		$this->start_controls_tab(
			'tabs_c_bg_st2_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'c_bg_st2',
			[
				'label' => esc_html__( 'All', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner #breadcrumbs > span:not(.del) a,{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner #breadcrumbs > span:not(.del) .current_tab_sec' => 'background: {{VALUE}} !important',					
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner.bred_style_2 #breadcrumbs > span:not(.del):before' => 'border-left: 30px solid {{VALUE}}',
				],
			]
		);	
		$this->add_control(
			'c_bg_st2_home',
			[
				'label' => esc_html__( 'Home', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner #breadcrumbs > span.bc_home .home_bread_tab' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner.bred_style_2 #breadcrumbs > span.bc_home:before' => 'border-left: 30px solid {{VALUE}}',
					
				],
			]
		);
		$this->add_control(
			'c_bg_st2_current_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner #breadcrumbs > span:not(.del) .current_tab_sec' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner.bred_style_2 #breadcrumbs > span.current:before,{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner.bred_style_2 #breadcrumbs > span.current_active:before' => 'border-left: 30px solid {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_c_bg_st2_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'c_bg_st2_hover',
			[
				'label' => esc_html__( 'All', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner #breadcrumbs > span:not(.del):hover a,{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner #breadcrumbs > span.current:hover .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner #breadcrumbs > span.current_active:hover .current_tab_sec' => 'background: {{VALUE}} !important',					
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner.bred_style_2 #breadcrumbs > span:not(.del):hover:before' => 'border-left: 30px solid {{VALUE}}',
				],
			]
		);	
		$this->add_control(
			'c_bg_st2_home_hover',
			[
				'label' => esc_html__( 'Home', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner #breadcrumbs > span.bc_home:hover a' => 'background: {{VALUE}} !important',					
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner.bred_style_2 #breadcrumbs > span.bc_home:hover:before' => 'border-left: 30px solid {{VALUE}}',
				],
			]
		);		
		$this->add_control(
			'c_bg_st2_current_active_hover',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner #breadcrumbs > span.current:hover .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner #breadcrumbs > span.current_active:hover .current_tab_sec' => 'background: {{VALUE}} !important',					
					'{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner.bred_style_2 #breadcrumbs > span.current:hover:before,{{WRAPPER}} .pt_plus_breadcrumbs_bar_inner.bred_style_2 #breadcrumbs > span.current_active:hover:before' => 'border-left: 30px solid {{VALUE}}',
				],
			]
		);		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		/*separate background style end*/
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
		/*****style section end*****/
		
		
	}
	
	 protected function render() {

        $settings = $this->get_settings_for_display();
			
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
			
		$uid=uniqid("bread");
		$breadcrumbs_style = $settings['breadcrumbs_style'];
		$icons=$icontype='';
		if($settings['home_select_icon']=="icon"){
			if(!empty($settings["icon_font_style"]) && $settings["icon_font_style"]=='font_awesome'){
				$icons=$settings["icon_fontawesome"];
				$icontype='icon';
			}else if(!empty($settings["icon_font_style"]) && $settings["icon_font_style"]=='icon_mind'){
				$icons='fa '.$settings["icons_mind"];
				$icontype='icon';
			}else if(!empty($settings["icon_font_style"]) && $settings["icon_font_style"]=='icon_image'){
				//$icons=$settings["icons_image"];
				$icons_image=$settings['icons_image']['id'];
				$img = wp_get_attachment_image_src($icons_image,$settings['icons_image_thumbnail_size']);
				$icons = $img[0];
				$icontype='image';
			}
		}
		
		$sep_icons=$sep_icontype='';
		if($settings['sep_select_icon']=="sep_icon"){
			if(!empty($settings["sep_icon_font_style"]) && $settings["sep_icon_font_style"]=='sep_font_awesome'){
				$sep_icons=$settings["sep_icon_fontawesome"];
				$sep_icontype='sep_icon';
			}else if(!empty($settings["sep_icon_font_style"]) && $settings["sep_icon_font_style"]=='sep_icon_mind'){
				$sep_icons='fa '.$settings["sep_icons_mind"];
				$sep_icontype='sep_icon';
			}else if(!empty($settings["sep_icon_font_style"]) && $settings["sep_icon_font_style"]=='sep_icon_image'){
				//$sep_icons=$settings["sep_icons_image"];
				$sep_icons_image=$settings['sep_icons_image']['id'];
				$img = wp_get_attachment_image_src($sep_icons_image,$settings['sep_icons_image_thumbnail_size']);
				$sep_icons = $img[0];
				$sep_icontype='sep_image';
			}
		}
		
		
		if($breadcrumbs_style == 'style_1'){
			$bred_style_class = 'bred_style_1';
		}else if($breadcrumbs_style == 'style_2'){
			$bred_style_class = 'bred_style_2';
		}
		
		
			$home_titles=$settings["home_title"];
		
		$active_page_text_default='';
		if($settings['active_page_text_default']=='yes'){			
			$active_page_text_default = ($settings['active_page_text_default']=='yes') ? "default_active" : "";	
		}
		
		$breadcrumbs_on_off_home='';
		if($settings['breadcrumbs_on_off_home']=='yes'){			
			$breadcrumbs_on_off_home = ($settings['breadcrumbs_on_off_home']=='yes') ? "on-off-home" : "";	
		}
		$breadcrumbs_on_off_parent='';
		if($settings['breadcrumbs_on_off_parent']=='yes'){			
			$breadcrumbs_on_off_parent = ($settings['breadcrumbs_on_off_parent']=='yes') ? "on-off-parent" : "";	
		}
		
		$letter_limit_parent = (!empty($settings['letter_limit_parent'])) ? $settings['letter_limit_parent'] : '5';
		$letter_limit_current = (!empty($settings['letter_limit_current'])) ? $settings['letter_limit_current'] : '0';
		
		
		$breadcrumbs_on_off_current='';
		if($settings['breadcrumbs_on_off_current']=='yes'){			
			$breadcrumbs_on_off_current = ($settings['breadcrumbs_on_off_current']=='yes') ? "on-off-current" : "";	
		}
		
		$breadcrumbs_last_sec_tri_normal='';		
		
			$breadcrumbs_bar ='<div id="'.esc_attr($uid).'" class="pt_plus_breadcrumbs_bar '.$animated_class.'" '.$animation_attr.' style="justify-content : '.$settings['breadcrumbs_align'].'">';
			if($settings['breadcrumbs_full_auto']=='yes'){
			$breadcrumbs_bar .='<div class="pt_plus_breadcrumbs_bar_inner '.$bred_style_class.'" style="width:100%">';
			}else {
				$breadcrumbs_bar .='<div class="pt_plus_breadcrumbs_bar_inner '.$bred_style_class.'">';
			}
			$breadcrumbs_bar .= theplus_breadcrumbs($icontype,$sep_icontype,$icons,$home_titles,$sep_icons,$active_page_text_default,$breadcrumbs_last_sec_tri_normal,$breadcrumbs_on_off_home,$breadcrumbs_on_off_parent,$breadcrumbs_on_off_current,$letter_limit_parent,$letter_limit_current);
			$breadcrumbs_bar .='</div>';
			$breadcrumbs_bar .='</div>';
			
		echo $before_content.$breadcrumbs_bar.$after_content;
		
	}
	
    protected function content_template() {
	
    }

}
