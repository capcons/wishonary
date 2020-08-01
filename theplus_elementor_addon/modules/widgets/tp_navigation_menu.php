<?php 
/*
Widget Name: TP Navigation Menu
Description: Style of header navigation bar menu
Author: theplus
Author URI: http://posimyththemes.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;

use TheplusAddons\Theplus_Element_Load;
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Navigation_Menu extends Widget_Base {
		
	public function get_name() {
		return 'tp-navigation-menu';
	}

    public function get_title() {
        return esc_html__('Navigation Menu', 'theplus');
		}

    public function get_icon() {
        return 'fa fa-bars theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-header');
    }
	public function get_keywords() {
		return ['navigation menu', 'mega menu', 'header builder', 'sticky menu', 'navigation bar', 'header menu', 'menu', 'navigation builder'];
	}
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'navbar_sections',
			[
				'label' => esc_html__( 'Navigation Bar', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'navbar_menu_type',
			[
				'label' => esc_html__( 'Menu Direction', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal'  => esc_html__( 'Horizontal Menu', 'theplus' ),					
					'vertical' => esc_html__( 'Vertical Menu', 'theplus' ),
					'vertical-side' => esc_html__( 'Vertical SideMenu', 'theplus' ),
				],
			]
		);
		$this->add_control(
			'navbar',
			[
				'label' => esc_html__( 'Select Menu', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => theplus_navigation_menulist(),
			]
		);
		$this->add_control(
			'menu_hover_click',
			[
				'label' => esc_html__( 'Menu Hover/Click', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover'  => esc_html__( 'Hover Sub-Menu', 'theplus' ),					
					'click' => esc_html__( 'Click Sub-Menu', 'theplus' ),
				],
			]
		);
		$this->add_control(
			'menu_transition',
			[
				'label' => esc_html__( 'Menu Effects', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Slide Up/Down (Js)', 'theplus' ),
					'style-2' => esc_html__( 'Fade In/Out (Js)', 'theplus' ),
					'style-3'  => esc_html__( 'Fade Up/Down', 'theplus' ),
					'style-4' => esc_html__( 'Fade In/Out', 'theplus' ),
				],
			]
		);
		$this->add_control(
			'vertical_side_title_bar',
			[
				'label' => esc_html__( 'Vertical Side Title Bar', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),				
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'navbar_menu_type' => 'vertical-side',
				],
			]
		);
		$this->add_control(
			'vertical_side_type',
			[
				'label' => esc_html__( 'Title Bar Hover/Click', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  => esc_html__( 'Normal', 'theplus' ),
					'hover'  => esc_html__( 'Hover', 'theplus' ),
					'click' => esc_html__( 'Click', 'theplus' ),
				],
				'condition' => [
					'navbar_menu_type' => 'vertical-side',
					'vertical_side_title_bar' => 'yes',
				],
			]
		);
		$this->add_control(
			'vertical_side_click_open',
			[
				'label' => esc_html__( 'Default Open Click', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),				
				'default' => 'no',
				'condition' => [
					'navbar_menu_type' => 'vertical-side',
					'vertical_side_type' => 'click',
				],
			]
		);
		$this->add_control(
			'vertical_side_title_text',
			[
				'label' => esc_html__( 'Title', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Navigation Menu', 'theplus' ),
				'placeholder' => esc_html__( 'Navigation Menu', 'theplus' ),
				'condition' => [
					'navbar_menu_type' => 'vertical-side',
					'vertical_side_title_bar' => 'yes',					
				],
			]
		);	
		$this->add_control(
			'vertical_side_title_link',
			[
				'label' => esc_html__( 'Title Link', 'theplus' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'before',
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'theplus' ),
				'default' => [
					'url' => '#',
				],
				'condition' => [
					'navbar_menu_type' => 'vertical-side',
					'vertical_side_title_bar' => 'yes',
					'vertical_side_type!' => 'click',
				],
			]
		);			
		$this->add_control(
			'loop_icon_prefix',
			[
				'label' => esc_html__( 'Prefix Icon', 'theplus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-bars',
					'library' => 'solid',
				],
				'condition' => [
					'navbar_menu_type' => 'vertical-side',
					'vertical_side_title_bar' => 'yes',	
				],	
			]
		);
		$this->add_control(
			'loop_icon_postfix',
			[
				'label' => esc_html__( 'Postfix Icon', 'theplus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-angle-down',
					'library' => 'solid',
				],
				'condition' => [
					'navbar_menu_type' => 'vertical-side',
					'vertical_side_title_bar' => 'yes',	
				],	
			]
		);		
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_extra_options',
            [
                'label' => esc_html__('Extra Options', 'theplus'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		
		$this->add_control(
			'nav_alignment',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'text-left' => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon' => 'fa fa-align-left',
					],
					'text-center' => [
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon' => 'fa fa-align-center',
					],
					'text-right' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'separator' => 'before',
				'default' => 'text-center',
				'toggle' => true,
				'label_block' => false,
			]
		);
		$this->add_control(
			'enable_sticky_menu',
			[
				'label' => esc_html__( 'Sticky Menu', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),				
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*mobile menu content*/
		$this->start_controls_section(
            'section_mobile_menu_options',
            [
                'label' => esc_html__('Mobile Menu', 'theplus'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
			'show_mobile_menu',
			[
				'label' => esc_html__( 'Responsive Mobile Menu', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),				
				'default' => 'yes',
			]
		);
		$this->add_control(
			'mobile_menu_type',
			[
				'label' => esc_html__( 'Menu Type', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'toggle',
				'options' => [
					'toggle'  => esc_html__( 'Toggle', 'theplus' ),
					'swiper'  => esc_html__( 'Swiper', 'theplus' ),
				],
				'condition' => [					
					'show_mobile_menu' => 'yes',
				],
			]
		);
		$this->add_control(
			'open_mobile_menu',
			[
				'label' => esc_html__( 'Open Mobile Menu', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 991,
				],
				'condition' => [					
					'show_mobile_menu' => 'yes',
				],
			]
		);
		$this->add_control(
			'mobile_menu_toggle_style',
			[
				'label' => esc_html__( 'Toggle Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Style 1', 'theplus' ),
					'style-2'  => esc_html__( 'Style 2', 'theplus' ),
					'style-3'  => esc_html__( 'Style 3', 'theplus' ),
					'style-4'  => esc_html__( 'Style 4', 'theplus' ),
					'style-5'  => esc_html__( 'Custom', 'theplus' ),
				],
				'condition' => [					
					'show_mobile_menu' => 'yes',
					'mobile_menu_type' => 'toggle',
				],
			]
		);
		$this->add_control(
			'mmts_custom',
			[
				'label' => esc_html__( 'Custom', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'custom_icon',
				'options' => [
					'custom_icon'  => esc_html__( 'Icon', 'theplus' ),
					'custom_img'  => esc_html__( 'Image', 'theplus' ),
				],
				'condition'   => [
					'show_mobile_menu' => 'yes',					
					'mobile_menu_toggle_style' => 'style-5',
				],
			]
		);
		$this->add_control(
			'mmts_custom_icon',
			[
				'label' => esc_html__( 'Open Custom Icon', 'theplus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-searchengin',
					'library' => 'solid',
				],
				'condition' => [
					'show_mobile_menu' => 'yes',
					'mobile_menu_toggle_style' => 'style-5',
					'mmts_custom' => 'custom_icon',
				],	
			]
		);
		$this->add_control(
			'mmts_custom_icon_c',
			[
				'label' => esc_html__( 'Close Custom Icon', 'theplus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-searchengin',
					'library' => 'solid',
				],
				'condition' => [
					'show_mobile_menu' => 'yes',
					'mobile_menu_toggle_style' => 'style-5',
					'mmts_custom' => 'custom_icon',
				],	
			]
		);
		$this->add_control(
			'mmts_custom_image',
			[
				'label' => esc_html__( 'Open Custom Image', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'media_type' => 'image',
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'show_mobile_menu' => 'yes',
					'mobile_menu_toggle_style' => 'style-5',
					'mmts_custom' => 'custom_img',
				],	
			]
		);
		$this->add_control(
			'mmts_custom_image_c',
			[
				'label' => esc_html__( 'Close Custom Image', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'media_type' => 'image',
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'show_mobile_menu' => 'yes',
					'mobile_menu_toggle_style' => 'style-5',
					'mmts_custom' => 'custom_img',
				],	
			]
		);
		$this->add_control(
			'mobile_toggle_alignment',
			[
				'label' => esc_html__( 'Toggle Alignment', 'theplus' ),
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
				'separator' => 'before',
				'default' => 'flex-end',
				'toggle' => true,
				'label_block' => false,
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-nav-toggle.mobile-toggle' => 'justify-content: {{VALUE}}',
				],
				'condition' => [					
					'show_mobile_menu' => 'yes',
					'mobile_menu_type' => 'toggle',
				],
			]
		);
		$this->add_control(
			'mobile_nav_alignment',
			[
				'label' => esc_html__( 'Navigation Alignment', 'theplus' ),
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
				'separator' => 'before',
				'default' => 'flex-start',
				'toggle' => true,
				'label_block' => false,
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu-content .nav li a' => 'text-align: {{VALUE}}',
				],
				'condition' => [					
					'show_mobile_menu' => 'yes',
					'mobile_menu_content' => 'normal-menu',
				],
			]
		);
		$this->add_control(
			'mobile_menu_content',
			[
				'label' => esc_html__( 'Menu Content', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal-menu',
				'options' => [
					'normal-menu'  => esc_html__( 'Normal Menu', 'theplus' ),
					'template-menu'  => esc_html__( 'Template Menu', 'theplus' ),
				],
				'condition' => [					
					'show_mobile_menu' => 'yes',
				],
			]
		);
		$this->add_control(
			'mobile_navbar',
			[
				'label' => esc_html__( 'Select Menu', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => theplus_navigation_menulist(),
				'condition' => [
					'show_mobile_menu' => 'yes',
					'mobile_menu_content' => 'normal-menu',
				],
			]
		);
		$this->add_control(
			'mobile_navbar_template',
			[
				'label'       => esc_html__( 'Elementor Templates', 'theplus' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => theplus_get_templates(),
				'label_block' => 'true',
				'condition'   => [
					'show_mobile_menu' => 'yes',
					'mobile_menu_content' => "template-menu",
				],
			]
		);
		$this->add_control(
			'mobile_navbar_outer_click',
			[
				'label' => esc_html__( 'Mobile Click Close Menu', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),				
				'default' => 'yes',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*mobile menu content*/
		
		/*Outer Menu Style*/
		$this->start_controls_section(
			'outer_nav_styling',
			[
				'label' => esc_html__( 'Outer Navigation', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navbar_menu_type' => 'vertical-side',
				],
			]
		);
		$this->add_control(
			'outer_nav_min_width',
			[
				'label' => esc_html__( 'Navigation Minimum Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 150,
						'max' => 700,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 240,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu.menu-vertical-side .navbar-nav,{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle' => 'max-width: {{SIZE}}{{UNIT}};',
					
				],
			]
		);
		$this->add_responsive_control(
			'outer_nav_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
							'top' => '',
							'right' => '',
							'bottom' => '',
							'left' => '',
							'isLinked' => false 
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu.menu-vertical-side .navbar-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'outer_nav_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-navigation-menu.menu-vertical-side .navbar-nav',
			]
		);
		$this->add_responsive_control(
			'outer_nav_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu.menu-vertical-side .navbar-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'outer_nav_bg_options',
			[
				'label' => esc_html__( 'Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'outer_nav_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-menu.menu-vertical-side .navbar-nav',
				
			]
		);
		$this->add_control(
			'outer_nav_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'outer_nav_shadow',
				'selector' => '{{WRAPPER}} .plus-navigation-menu.menu-vertical-side .navbar-nav',
			]
		);
		$this->end_controls_section();
		/*Outer Menu Style*/
		
		/*Vertical Side Title Bar Style*/
		$this->start_controls_section(
			'vertical_side_title_bar_styling',
			[
				'label' => esc_html__( 'Vertical Side Title Bar', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navbar_menu_type' => 'vertical-side',
					'vertical_side_title_bar' => 'yes',					
				],
			]
		);
		$this->add_control(
			'vertical_side_title_heading',
			[
				'label' => esc_html__( 'Title Options', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,			
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'vs_title_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle',
			]
		);
		$this->start_controls_tabs( 'tabs_vs_title' );
		$this->start_controls_tab(
			'tab_vs_title_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_vs_title_color_n',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_vs_title_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_vs_title_color_h',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		
		$this->add_control(
			'vertical_side_prefix_icn_heading',
			[
				'label' => esc_html__( 'Prefix Icon Options', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
            'vs_prefix_icn_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle span > i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_vs_prefix' );
		$this->start_controls_tab(
			'tab_vs_prefix_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_vs_prefix_color_n',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle span > i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_vs_prefix_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_vs_prefix_color_h',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle:hover span > i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();	
		
		$this->add_control(
			'vertical_side_postfix_icn_heading',
			[
				'label' => esc_html__( 'Postfix Icon Options', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_responsive_control(
            'vs_postfix_icn_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle > i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_vs_postfix' );
		$this->start_controls_tab(
			'tab_vs_postfix_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_vs_postfix_color_n',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle > i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_vs_postfix_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_vs_postfix_color_h',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle:hover > i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();	
		$this->add_control(
			'vertical_side_whole_heading',
			[
				'label' => esc_html__( 'Title Bar Options', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'vertical_side_whole_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);		

		$this->start_controls_tabs( 'tabs_vs_whole' );
		$this->start_controls_tab(
			'tab_vs_whole_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'vs_whole_background_n',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tab_vs_whole_border_n',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle',
			]
		);
		$this->add_responsive_control(
			'tab_vs_whole_border_radius_n',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tab_vs_whole_shadow_n',
				'selector' => '{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_vs_whole_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tab_vs_whole_background_h',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tab_vs_whole_border_h',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle:hover',
			]
		);
		$this->add_responsive_control(
			'tab_vs_whole_border_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tab_vs_whole_shadow_h',
				'selector' => '{{WRAPPER}} .plus-navigation-wrap .plus-vertical-side-toggle:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		/*Vertical Side Title Bar Style*/
		
		/*Main Menu Style*/
		$this->start_controls_section(
			'main_menu_styling',
			[
				'label' => esc_html__( 'Main Menu', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'main_menu_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a',
			]
		);
		$this->add_responsive_control(
			'main_menu_outer_padding',
			[
				'label' => esc_html__( 'Outer Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
							'top' => '5',
							'right' => '5',
							'bottom' => '5',
							'left' => '5',
							'isLinked' => false 
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav>li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'main_menu_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
							'top' => '10',
							'right' => '5',
							'bottom' => '10',
							'left' => '5',
							'isLinked' => false 
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.main-menu-indicator-style-2 .plus-navigation-menu .navbar-nav > li.dropdown > a:before' => 'right: calc({{RIGHT}}{{UNIT}} + 3px);',
					'[dir="rtl"] {{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.main-menu-indicator-style-2 .plus-navigation-menu .navbar-nav > li.dropdown > a:before' => 'left: calc({{Left}}{{UNIT}} + 3px);right:auto;',
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.main-menu-indicator-style-1 .plus-navigation-menu.menu-vertical-side .navbar-nav>li.dropdown>a:after' => 'right: calc({{RIGHT}}{{UNIT}} + 3px);',
					'[dir="rtl"] {{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.main-menu-indicator-style-1 .plus-navigation-menu.menu-vertical-side .navbar-nav>li.dropdown>a:after' => 'left: calc({{LEFT}}{{UNIT}} + 3px);right:auto;',
				],
			]
		);
		$this->add_control(
			'main_menu_indicator_style',
			[
				'label' => esc_html__( 'Main Menu Indicator Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'  => esc_html__( 'None', 'theplus' ),
					'style-1'  => esc_html__( 'Style 1', 'theplus' ),
				],
				'separator' => 'after',
			]
		);
		
		$this->start_controls_tabs( 'tabs_main_menu_style' );
		$this->start_controls_tab(
			'tab_main_menu_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'main_menu_normal_color',
			[
				'label' => esc_html__( 'Normal Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'main_menu_normal_icon_cls_color',
			[
				'label' => esc_html__( 'Normal Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a>.plus-nav-icon-menu' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'main_menu_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a>.plus-nav-icon-menu' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a>.plus-nav-icon-menu.icon-img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'main_menu_normal_icon_color',
			[
				'label' => esc_html__( 'Indicator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.main-menu-indicator-style-1 .plus-navigation-menu .navbar-nav > li.dropdown > a:after' => 'color: {{VALUE}}',
				],
				'condition' => [
					'main_menu_indicator_style!' => 'none',
				],
			]
		);
		$this->add_control(
			'main_menu_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'main_menu_normal_border_style',
			[
				'label'   => esc_html__( 'Border Style', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => esc_html__( 'None', 'theplus' ),
					'solid'  => esc_html__( 'Solid', 'theplus' ),
					'dotted' => esc_html__( 'Dotted', 'theplus' ),
					'dashed' => esc_html__( 'Dashed', 'theplus' ),
					'groove' => esc_html__( 'Groove', 'theplus' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'main_menu_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'main_menu_normal_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a' => 'border-color: {{VALUE}};',
				],
				'condition' => [					
					'main_menu_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'main_menu_normal_border_width',
			[
				'label' => esc_html__( 'Border Width', 'theplus' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [					
					'main_menu_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'main_menu_normal_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'main_menu_normal_bg_options',
			[
				'label' => esc_html__( 'Normal Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'main_menu_normal_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a',
				
			]
		);
		$this->add_control(
			'main_menu_normal_shadow_options',
			[
				'label' => esc_html__( 'Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'main_menu_normal_shadow',
				'selector' => '{{WRAPPER}} .plus-navigation-menu .navbar-nav>li>a',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_main_menu_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'main_menu_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:hover > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'main_menu_hover_icon_cls_color',
			[
				'label' => esc_html__( 'Hover Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:hover > a >.plus-nav-icon-menu' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'main_menu_hover_icon_color',
			[
				'label' => esc_html__( 'Hover Indicator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.main-menu-indicator-style-1 .plus-navigation-menu .navbar-nav > li.dropdown:hover > a:after' => 'color: {{VALUE}}',
				],
				'condition' => [					
					'main_menu_indicator_style!' => 'none',
				],
			]
		);
		$this->add_control(
			'main_menu_hover_border_color',
			[
				'label' => esc_html__( 'Hover Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:hover > a' => 'border-color: {{VALUE}};',
				],
				'condition' => [					
					'main_menu_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'main_menu_hover_radius',
			[
				'label'      => esc_html__( 'Hover Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:hover > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'main_menu_hover_bg_options',
			[
				'label' => esc_html__( 'Hover Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'main_menu_hover_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:hover > a',
				
			]
		);
		$this->add_control(
			'main_menu_hover_shadow_options',
			[
				'label' => esc_html__( 'Hover Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'main_menu_hover_shadow',
				'selector' => '{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:hover > a',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_main_menu_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_control(
			'main_menu_active_color',
			[
				'label' => esc_html__( 'Active Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.active > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:focus > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.current_page_item > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'main_menu_active_icon_cls_color',
			[
				'label' => esc_html__( 'Active Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.active > a >.plus-nav-icon-menu,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:focus > a>.plus-nav-icon-menu,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.current_page_item > a>.plus-nav-icon-menu' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'main_menu_active_icon_color',
			[
				'label' => esc_html__( 'Hover Indicator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.main-menu-indicator-style-1 .plus-navigation-menu .navbar-nav > li.dropdown.active > a:after,{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.main-menu-indicator-style-1 .plus-navigation-menu .navbar-nav > li.dropdown:focus > a:after,{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.main-menu-indicator-style-1 .plus-navigation-menu .navbar-nav > li.dropdown.current_page_item > a:after' => 'color: {{VALUE}}',
				],
				'condition' => [					
					'main_menu_indicator_style!' => 'none',
				],
			]
		);
		$this->add_control(
			'main_menu_active_border_color',
			[
				'label' => esc_html__( 'Active Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.active > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:focus > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.current_page_item > a' => 'border-color: {{VALUE}};',
				],
				'condition' => [					
					'main_menu_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'main_menu_active_radius',
			[
				'label'      => esc_html__( 'Active Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.active > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:focus > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.current_page_item > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'main_menu_active_bg_options',
			[
				'label' => esc_html__( 'Active Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'main_menu_active_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.active > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:focus > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.current_page_item > a',
				
			]
		);
		$this->add_control(
			'main_menu_active_shadow_options',
			[
				'label' => esc_html__( 'Active Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'main_menu_active_shadow',
				'selector' => '{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.active > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li:focus > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav > li.current_page_item > a',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Main Menu Style*/
		/*Sub Menu Style*/
		$this->start_controls_section(
			'sub_menu_styling',
			[
				'label' => esc_html__( 'Sub Menu', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_menu_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu > li > a',
			]
		);
		$this->add_control(
			'sub_menu_outer_options',
			[
				'label' => esc_html__( 'Sub-Menu Outer Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'sub_menu_outer_padding',
			[
				'label' => esc_html__( 'Outer Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
							'top' => '0',
							'right' => '0',
							'bottom' => '0',
							'left' => '0',
							'isLinked' => true
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu .dropdown-menu' => 'margin-top: {{TOP}}{{UNIT}};',
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu .dropdown-menu' => 'left: calc(100% + {{RIGHT}}{{UNIT}});',
					'[dir="rtl"] {{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu .dropdown-menu' => 'right: calc(100% + {{LEFT}}{{UNIT}});',
				],
			]
		);
		$this->add_control(
			'sub_menu_outer_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'sub_menu_outer_border_style',
			[
				'label'   => esc_html__( 'Border Style', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => esc_html__( 'None', 'theplus' ),
					'solid'  => esc_html__( 'Solid', 'theplus' ),
					'dotted' => esc_html__( 'Dotted', 'theplus' ),
					'dashed' => esc_html__( 'Dashed', 'theplus' ),
					'groove' => esc_html__( 'Groove', 'theplus' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'sub_menu_outer_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'sub_menu_outer_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu' => 'border-color: {{VALUE}};',
				],
				'condition' => [					
					'sub_menu_outer_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'sub_menu_outer_border_width',
			[
				'label' => esc_html__( 'Border Width', 'theplus' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [					
					'sub_menu_outer_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'sub_menu_outer_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'sub_menu_outer_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu',
				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'sub_menu_outer_shadow',
				'selector' => '{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu',
				'separator' => 'after',
			]
		);
		$this->add_control(
			'sub_menu_inner_options',
			[
				'label' => esc_html__( 'Sub-Menu Inner Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'sub_menu_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
							'top' => '10',
							'right' => '15',
							'bottom' => '10',
							'left' => '15',
							'isLinked' => false 
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu:not(.menu-vertical) .nav li.dropdown:not(.plus-fw) .dropdown-menu > li,{{WRAPPER}} .plus-navigation-menu.menu-vertical .nav li.dropdown:not(.plus-fw) .dropdown-menu > li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
				],
			]
		);
		$this->add_control(
			'sub_menu_indicator_style',
			[
				'label' => esc_html__( 'Sub Menu Indicator Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'  => esc_html__( 'None', 'theplus' ),
					'style-1'  => esc_html__( 'Style 1', 'theplus' ),
					'style-2'  => esc_html__( 'Style 2', 'theplus' ),
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'tabs_sub_menu_style' );
		$this->start_controls_tab(
			'tab_sub_menu_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'sub_menu_normal_color',
			[
				'label' => esc_html__( 'Normal Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu > li > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sub_menu_normal_icon_cls_color',
			[
				'label' => esc_html__( 'Normal Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu > li > a >.plus-nav-icon-menu' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sub_menu_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu > li > a >.plus-nav-icon-menu' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu > li > a >.plus-nav-icon-menu.icon-img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'sub_menu_normal_icon_color',
			[
				'label' => esc_html__( 'Indicator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-1 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu > a:after' => 'color: {{VALUE}}',
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu > a:before,{{WRAPPER}}  .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu > a:after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu > a:before' => 'border-color: {{VALUE}};background: 0 0;',
				],
				'condition' => [					
					'sub_menu_indicator_style!' => 'none',
				],
			]
		);
		$this->add_control(
			'sub_menu_normal_bg_options',
			[
				'label' => esc_html__( 'Normal Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'sub_menu_normal_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu > li',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_sub_menu_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'sub_menu_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu > li:hover > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sub_menu_hover_icon_cls_color',
			[
				'label' => esc_html__( 'Hover Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu > li:hover > a >.plus-nav-icon-menu' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sub_menu_hover_icon_color',
			[
				'label' => esc_html__( 'Hover Indicator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-1 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu:hover > a:after' => 'color: {{VALUE}}',
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu:hover > a:before,{{WRAPPER}}  .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu:hover > a:after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu:hover > a:before' => 'border-color: {{VALUE}};background: 0 0;',
				],
				'condition' => [					
					'sub_menu_indicator_style!' => 'none',
				],
			]
		);
		$this->add_control(
			'sub_menu_hover_bg_options',
			[
				'label' => esc_html__( 'Hover Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'sub_menu_hover_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-menu .nav li.dropdown .dropdown-menu > li:hover',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_sub_menu_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_control(
			'sub_menu_active_color',
			[
				'label' => esc_html__( 'Active Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav li.dropdown .dropdown-menu > li.active > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav li.dropdown .dropdown-menu > li:focus > a,{{WRAPPER}} .plus-navigation-menu .navbar-nav li.dropdown .dropdown-menu > li.current_page_item > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sub_menu_active_icon_cls_color',
			[
				'label' => esc_html__( 'Active Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [					
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav li.dropdown .dropdown-menu > li.active > a>.plus-nav-icon-menu,{{WRAPPER}} .plus-navigation-menu .navbar-nav li.dropdown .dropdown-menu > li:focus > a>.plus-nav-icon-menu,{{WRAPPER}} .plus-navigation-menu .navbar-nav li.dropdown .dropdown-menu > li.current_page_item > a>.plus-nav-icon-menu' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sub_menu_active_icon_color',
			[
				'label' => esc_html__( 'Active Indicator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-1 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu.active > a:after,{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-1 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu:focus > a:after,{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-1 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu.current_page_item > a:after' => 'color: {{VALUE}}',
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu.active > a:before,{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu:focus > a:before,{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu.current_page_item > a:before,{{WRAPPER}}  .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu.active > a:after,{{WRAPPER}}  .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu:focus > a:after,{{WRAPPER}}  .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu.current_page_item > a:after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu.active > a:before,{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu:focus > a:before,{{WRAPPER}} .plus-navigation-wrap .plus-navigation-inner.sub-menu-indicator-style-2 .plus-navigation-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu.current_page_item > a:before' => 'border-color: {{VALUE}};background: 0 0;',
				],
				'condition' => [					
					'sub_menu_indicator_style!' => 'none',
				],
			]
		);
		$this->add_control(
			'sub_menu_active_bg_options',
			[
				'label' => esc_html__( 'Active Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'sub_menu_active_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-menu .navbar-nav li.dropdown .dropdown-menu > li.active,{{WRAPPER}} .plus-navigation-menu .navbar-nav li.dropdown .dropdown-menu > li:focus,{{WRAPPER}} .plus-navigation-menu .navbar-nav li.dropdown .dropdown-menu > li.current_page_item',
				
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Mobile Menu Style*/
		$this->start_controls_section(
			'mobile_nav_options_styling',
			[
				'label' => esc_html__( 'Mobile Menu Style', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_mobile_menu' => 'yes',
				],
			]
		);
		$this->add_control(
			'mobile_nav_toggle_options',
			[
				'label' => esc_html__( 'Toggle Navigation Style', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'mobile_nav_toggle_height',
			[
				'label' => esc_html__( 'Toggle Height', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-nav-toggle.mobile-toggle' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mobile_nav_toggle_icon_st5',
			[
				'label' => esc_html__( 'Mobile Toggle Open Icon Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],				
				'selectors' => [
					'{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-5 .et_icon_img_st5 i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-5 .tp-icon-img,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-5' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [					
					'show_mobile_menu' => 'yes',
					'mobile_menu_toggle_style' => 'style-5',
				],
				
			]
		);
		$this->add_control(
			'mobile_nav_toggle_icon_st5_c',
			[
				'label' => esc_html__( 'Mobile Toggle Close Icon Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],				
				'selectors' => [
					'{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-5 .et_icon_img_st5_c i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-5 .tp-icon-img_c,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-5' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [					
					'show_mobile_menu' => 'yes',
					'mobile_menu_toggle_style' => 'style-5',
				],
				
			]
		);
		$this->add_control(
			'mobile_nav_size_open',
			[
				'label' => esc_html__( 'Navigation Width', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'full',
				'options' => [
					'full'  => esc_html__( 'Full Width', 'theplus' ),
					'custom' => esc_html__( 'Column Based', 'theplus' )					
				],
				'separator' => 'before',
				'condition' => [
					'show_mobile_menu' => 'yes',
				],
			]
		);
		$this->add_control(
			'mobile_nav_cust_heading',
			[
				'label' => esc_html__( 'Column Based Border and Shadow', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'show_mobile_menu' => 'yes',
					'mobile_nav_size_open' => 'custom',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mobile_nav_cust_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-mobile-menu-content.nav-cust-width',				
				'condition' => [
					'show_mobile_menu' => 'yes',
					'mobile_nav_size_open' => 'custom',
				],
			]
		);
		$this->add_responsive_control(
			'mobile_nav_cust_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-mobile-menu-content.nav-cust-width' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],
				'condition' => [
					'show_mobile_menu' => 'yes',
					'mobile_nav_size_open' => 'custom',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'mobile_nav_cust_shadow',
				'selector' => '{{WRAPPER}} .plus-mobile-menu-content.nav-cust-width',
				'condition' => [
					'show_mobile_menu' => 'yes',
					'mobile_nav_size_open' => 'custom',
				],
			]
		);
		$this->start_controls_tabs( 'tab_toggle_nav_style' );
		$this->start_controls_tab(
			'tab_toggle_nav_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'toggle_nav_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .mobile-plus-toggle-menu ul.toggle-lines li.toggle-line,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-2 .mobile-plus-toggle-menu-st2,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-2 .mobile-plus-toggle-menu-st2::before,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-2 .mobile-plus-toggle-menu-st2::after,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-3 .mobile-plus-toggle-menu-st3,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-3 .mobile-plus-toggle-menu-st3::before,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-3 .mobile-plus-toggle-menu-st3::after,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-4 span' => 'background: {{VALUE}}',
					'{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-5.clin.plus-collapsed i' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_toggle_nav_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_control(
			'toggle_nav_active_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .mobile-plus-toggle-menu:not(.plus-collapsed) ul.toggle-lines li.toggle-line,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-2 .mobile-plus-toggle-menu-st2-h,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-2 .mobile-plus-toggle-menu-st2-h::before,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-2 .mobile-plus-toggle-menu-st2-h::after,
					{{WRAPPER}} .mobile-plus-toggle-menu:not(.plus-collapsed).toggle-style-3 .mobile-plus-toggle-menu-st3:before,
					{{WRAPPER}} .mobile-plus-toggle-menu:not(.plus-collapsed).toggle-style-3 .mobile-plus-toggle-menu-st3:after,
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-4:not(.plus-collapsed) span:nth-last-child(3),
					{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-4:not(.plus-collapsed) span:nth-last-child(1)' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} .mobile-plus-toggle-menu.toggle-style-5.clin i' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'mobile_main_menu_options',
			[
				'label' => esc_html__( 'Mobile Main Menu Style', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mobile_main_menu_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-mobile-menu .navbar-nav>li>a',
			]
		);
		$this->add_responsive_control(
			'mobile_main_menu_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
							'top' => '10',
							'right' => '10',
							'bottom' => '10',
							'left' => '10',
							'isLinked' => false 
				],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .navbar-nav>li>a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',					
				],
			]
		);
		$this->start_controls_tabs( 'tabs_mobile_main_menu_style' );
		$this->start_controls_tab(
			'tab_mobile_main_menu_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'mobile_main_menu_normal_color',
			[
				'label' => esc_html__( 'Normal Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .navbar-nav>li>a,
					{{WRAPPER}} .plus-mobile-menu .navbar-nav>li.plus-dropdown-container.plus-fw>a.dropdown-toggle' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_main_menu_normal_icon_cls_color',
			[
				'label' => esc_html__( 'Normal Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .navbar-nav>li>a>.plus-nav-icon-menu' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_main_menu_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .navbar-nav>li>a>.plus-nav-icon-menu' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .plus-mobile-menu .navbar-nav>li>a>.plus-nav-icon-menu.icon-img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mobile_main_menu_normal_icon_color',
			[
				'label' => esc_html__( 'Indicator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li.dropdown > a:after' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_main_menu_normal_bg_options',
			[
				'label' => esc_html__( 'Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'mobile_main_menu_normal_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav>li>a',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_mobile_main_menu_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_control(
			'mobile_main_menu_active_color',
			[
				'label' => esc_html__( 'Active Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li.active > a,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li:focus > a,{{WRAPPER}} .plus-mobile-menu .navbar-nav > li.current_page_item > a,
					{{WRAPPER}} .plus-mobile-menu .plus-mobile-menu-content .navbar-nav>li.plus-fw.open>a,
					{{WRAPPER}} .plus-mobile-menu .navbar-nav>li.open>a,
					{{WRAPPER}} .plus-mobile-menu .navbar-nav>li.plus-dropdown-container.plus-fw.open>a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_main_menu_active_icon_cls_color',
			[
				'label' => esc_html__( 'Active Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li.active > a>.plus-nav-icon-menu,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li:focus > a>.plus-nav-icon-menu,{{WRAPPER}} .plus-mobile-menu .navbar-nav > li.current_page_item > a>.plus-nav-icon-menu' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_main_menu_active_icon_color',
			[
				'label' => esc_html__( 'Active Indicator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li.dropdown.active > a:after,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li.dropdown:focus > a:after,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li.dropdown.current_page_item > a:after' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_main_menu_active_bg_options',
			[
				'label' => esc_html__( 'Active Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'mobile_main_menu_active_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li.dropdown.active > a,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li.dropdown:focus > a,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav > li.dropdown.current_page_item > a',
				
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
			'mobile_menu_border_main',
			[
				'label' => esc_html__( 'Border Bottom Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'separator' => ['before','after'],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-nav-toggle .plus-mobile-menu .navbar-nav li a,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li a' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mobile_menu_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'separator' => ['before','after'],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-nav-toggle .plus-mobile-menu .navbar-nav li a,
					{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li a' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);
		/*mobile submenu*/
		$this->add_control(
			'mobile_sub_menu_options',
			[
				'label' => esc_html__( 'Mobile Sub Menu Style', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mobile_sub_menu_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-mobile-menu .nav li.dropdown .dropdown-menu > li > a',
			]
		);
		$this->add_responsive_control(
			'mobile_sub_menu_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
							'top' => '10',
							'right' => '10',
							'bottom' => '10',
							'left' => '15',
							'isLinked' => false 
				],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .nav li.dropdown .dropdown-menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',					
				],
			]
		);
		$this->start_controls_tabs( 'tabs_mobile_sub_menu_style' );
		$this->start_controls_tab(
			'tab__mobile_sub_menu_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'mobile_sub_menu_normal_color',
			[
				'label' => esc_html__( 'Normal Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .nav li.dropdown .dropdown-menu > li > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_sub_menu_normal_icon_cls_color',
			[
				'label' => esc_html__( 'Normal Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .nav li.dropdown .dropdown-menu > li > a >.plus-nav-icon-menu' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_sub_menu_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .nav li.dropdown .dropdown-menu > li > a >.plus-nav-icon-menu' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .plus-mobile-menu .nav li.dropdown .dropdown-menu > li > a >.plus-nav-icon-menu.icon-img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mobile_sub_menu_normal_icon_color',
			[
				'label' => esc_html__( 'Indicator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .nav li.dropdown .dropdown-menu > li > a:after' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_sub_menu_normal_bg_options',
			[
				'label' => esc_html__( 'Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'mobile_sub_menu_normal_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .nav li.dropdown .dropdown-menu > li > a',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_mobile_sub_menu_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_control(
			'mobile_sub_menu_active_color',
			[
				'label' => esc_html__( 'Active Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li.dropdown .dropdown-menu > li.active > a,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li.dropdown .dropdown-menu > li:focus > a,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li.dropdown .dropdown-menu > li.current_page_item > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_sub_menu_active_icon_cls_color',
			[
				'label' => esc_html__( 'Active Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff5a6e',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li.dropdown .dropdown-menu > li.active > a >.plus-nav-icon-menu,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li.dropdown .dropdown-menu > li:focus > a >.plus-nav-icon-menu,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li.dropdown .dropdown-menu > li.current_page_item > a >.plus-nav-icon-menu' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_sub_menu_active_icon_color',
			[
				'label' => esc_html__( 'Active Indicator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu.active > a:after,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu:focus > a:after,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav ul.dropdown-menu > li.dropdown-submenu.current_page_item > a:after' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_sub_menu_active_bg_options',
			[
				'label' => esc_html__( 'Active Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'mobile_sub_menu_active_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li.dropdown .dropdown-menu > li.active > a,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li.dropdown .dropdown-menu > li:focus > a,{{WRAPPER}} .plus-navigation-wrap .plus-mobile-menu .navbar-nav li.dropdown .dropdown-menu > li.current_page_item > a',
				
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Mobile Menu Style*/
		
		/*label style start*/
		/*Main & Sub Menu Label start*/
		$this->start_controls_section(
			'main_sub_label_styling',
			[
				'label' => esc_html__( 'Main & Sub Menu Label', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
			/*main menu Label Text*/
		$this->add_control(
			'main_menu_label_text_options',
			[
				'label' => esc_html__( 'Main Menu Label Text Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'main_menu_label_typography',
				'label' => esc_html__( 'Label Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-navigation-menu .plus-nav-label-text',
			]
		);
		$this->add_control(
			'main_menu_label_right',
			[
				'label' => esc_html__( 'Horizontal Offset', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -12,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .plus-nav-label-text' => 'right: {{SIZE}}{{UNIT}};',
					'[dir="rtl"] {{WRAPPER}} .plus-navigation-menu .plus-nav-label-text' => 'left: {{SIZE}}{{UNIT}};right:auto;',
				],
			]
		);
		
		$this->add_control(
			'main_menu_label_top',
			[
				'label' => esc_html__( 'Vertical Offset', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -5,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .plus-nav-label-text' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'main_menu_label_padd',
			[
				'label' => esc_html__( 'Outer Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .plus-nav-label-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'main_menu_label_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-navigation-menu .plus-nav-label-text',
			]
		);
		$this->add_control(
			'main_menu_label_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .plus-nav-label-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'main_menu_label_bg',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .plus-navigation-menu .plus-nav-label-text',
			]
		);
		/*main menu Label Text end*/
		
		/*sub menu Label Text start*/		
		$this->add_control(
			'sub_menu_label_text_options',
			[
				'label' => esc_html__( 'Label Text Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_menu_label_typography',
				'label' => esc_html__( 'Label Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-navigation-menu .dropdown-menu .plus-nav-label-text',
			]
		);
		$this->add_control(
			'sub_menu_label_right',
			[
				'label' => esc_html__( 'Horizontal Offset', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -12,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .dropdown-menu .plus-nav-label-text' => 'right: {{SIZE}}{{UNIT}};',
					'[dir="rtl"] {{WRAPPER}} .plus-navigation-menu .dropdown-menu .plus-nav-label-text' => 'left: {{SIZE}}{{UNIT}};right:auto;',
				],
			]
		);
		
		$this->add_control(
			'sub_menu_label_top',
			[
				'label' => esc_html__( 'Vertical Offset', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -5,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .dropdown-menu .plus-nav-label-text' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'sub_menu_label_padd',
			[
				'label' => esc_html__( 'Outer Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .dropdown-menu .plus-nav-label-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sub_menu_label_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-navigation-menu .dropdown-menu .plus-nav-label-text',
			]
		);
		$this->add_control(
			'sub_menu_label_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .dropdown-menu .plus-nav-label-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sub_menu_label_bg',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .plus-navigation-menu .dropdown-menu .plus-nav-label-text',
			]
		);		
		/*sub menu Label Text end*/
		$this->end_controls_section();
		/*Main & Sub Menu Label end*/
		
		/*Mobile Menu Label start*/
		$this->start_controls_section(
			'mobile_label_styling',
			[
				'label' => esc_html__( 'Mobile Menu Label', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		/*mobile menu Label Text*/
		$this->add_control(
			'mobile_main_menu_label_text_options',
			[
				'label' => esc_html__( 'Main Menu Label Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mobile_main_menu_label_typography',
				'label' => esc_html__( 'Label Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-mobile-menu .plus-nav-label-text',
			]
		);
		$this->add_control(
			'mobile_main_menu_label_right',
			[
				'label' => esc_html__( 'Horizontal Offset', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 45,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .plus-nav-label-text' => 'right: {{SIZE}}{{UNIT}};',
					'[dir="rtl"] {{WRAPPER}} .plus-mobile-menu .plus-nav-label-text' => 'left: {{SIZE}}{{UNIT}};right:auto;',
				],
			]
		);
		
		$this->add_control(
			'mobile_main_menu_label_top',
			[
				'label' => esc_html__( 'Vertical Offset', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .plus-nav-label-text' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'mobile_main_menu_label_padd',
			[
				'label' => esc_html__( 'Outer Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .plus-nav-label-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mobile_main_menu_label_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-mobile-menu .plus-nav-label-text',
			]
		);
		$this->add_control(
			'mobile_main_menu_label_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .plus-nav-label-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'mobile_main_menu_label_bg',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .plus-mobile-menu .plus-nav-label-text',
			]
		);
		/*mobile menu Label Text*/
		
		/*mobile sub menu Label Text*/
		$this->add_control(
			'mobile_sub_menu_label_text_options',
			[
				'label' => esc_html__( 'SubMenu Label Text Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mobile_sub_menu_label_typography',
				'label' => esc_html__( 'Label Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-mobile-menu .dropdown-menu .plus-nav-label-text',
			]
		);
		$this->add_control(
			'mobile_sub_menu_label_right',
			[
				'label' => esc_html__( 'Horizontal Offset', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 45,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .dropdown-menu .plus-nav-label-text' => 'right: {{SIZE}}{{UNIT}};',
					'[dir="rtl"] {{WRAPPER}} .plus-mobile-menu .dropdown-menu .plus-nav-label-text' => 'left: {{SIZE}}{{UNIT}};right:auto;',
				],
			]
		);
		
		$this->add_control(
			'mobile_sub_menu_label_top',
			[
				'label' => esc_html__( 'Vertical Offset', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .dropdown-menu .plus-nav-label-text' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'mobile_sub_menu_label_padd',
			[
				'label' => esc_html__( 'Outer Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .dropdown-menu .plus-nav-label-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mobile_sub_menu_label_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-mobile-menu .dropdown-menu .plus-nav-label-text',
			]
		);
		$this->add_control(
			'mobile_sub_menu_label_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus-mobile-menu .dropdown-menu .plus-nav-label-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'mobile_sub_menu_label_bg',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .plus-mobile-menu .dropdown-menu .plus-nav-label-text',
			]
		);
		/*mobile sub menu Label Text*/
		$this->end_controls_section();
		/*Mobile Menu Label start*/
		/*label style end*/
		
		/*Extra Options Style*/
		$this->start_controls_section(
			'extra_options_styling',
			[
				'label' => esc_html__( 'Extra Options', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'main_menu_hover_style',
			[
				'label' => esc_html__( 'Main Menu Hover Effects', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'  => esc_html__( 'None', 'theplus' ),
					'style-1'  => esc_html__( 'Style 1', 'theplus' ),
					'style-2'  => esc_html__( 'Style 2', 'theplus' ),
				],
			]
		);
		$this->add_control(
			'border-height',
			[
				'label' => esc_html__( 'Border Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav.menu-hover-style-2 > li > a:after,{{WRAPPER}} .plus-navigation-menu .navbar-nav.menu-hover-style-2 > li > a:before' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'main_menu_hover_style' => ['style-2']
				],
			]
		);
		$this->add_control(
			'alignment-border-adjust',
			[
				'label' => esc_html__( 'Alignment Border Adjust', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav.menu-hover-style-2 > li > a:after,{{WRAPPER}} .plus-navigation-menu .navbar-nav.menu-hover-style-2 > li > a:before' => 'bottom : {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'main_menu_hover_style' => ['style-2']
				],
			]
		);
		$this->add_control(
			'main_menu_hover_style_1_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav.menu-hover-style-1 > li > a:before,{{WRAPPER}} .plus-navigation-menu .navbar-nav.menu-hover-style-2 > li > a:after,{{WRAPPER}} .plus-navigation-menu .navbar-nav.menu-hover-style-2 > li > a:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'main_menu_hover_style' => ['style-1','style-2']
				],
			]
		);
		$this->add_control(
			'main_menu_hover_style_2_color',
			[
				'label' => esc_html__( 'Hover Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222',
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav.menu-hover-style-2 > li > a:hover:after,{{WRAPPER}} .plus-navigation-menu .navbar-nav.menu-hover-style-2 > li > a:hover:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'main_menu_hover_style' => ['style-2']
				],
			]
		);
		$this->add_control(
			'main_menu_hover_style_1_width',
			[
				'label' => esc_html__( 'Border Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav.menu-hover-style-1 > li > a:before' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'main_menu_hover_style' => 'style-1',
				],
			]
		);
		$this->add_control(
			'main_menu_hover_inverse',
			[
				'label' => esc_html__( 'On Hover Inverse Effect Main Menu', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),				
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'main_menu_hover_selected_opacity',
			[
				'label' => esc_html__( 'Selected Menu Opacity', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => '',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav.hover-inverse-effect > li > a.is-hover' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'main_menu_hover_inverse' => 'yes',
				],
			]
		);
		$this->add_control(
			'main_menu_hover_remaining_opacity',
			[
				'label' => esc_html__( 'Remaining Menus Opacity', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => '',
					'size' => 0.2,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav.is-hover-inverse > li > a' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'main_menu_hover_inverse' => 'yes',
				],
			]
		);
		$this->add_control(
			'sub_menu_hover_inverse',
			[
				'label' => esc_html__( 'On Hover Inverse Effect Sub Menu', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),				
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'sub_menu_hover_selected_opacity',
			[
				'label' => esc_html__( 'Selected Menu Opacity', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => '',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav.submenu-hover-inverse-effect li.dropdown .dropdown-menu > li > a.is-hover' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'sub_menu_hover_inverse' => 'yes',
				],
			]
		);
		$this->add_control(
			'sub_menu_hover_remaining_opacity',
			[
				'label' => esc_html__( 'Remaining Menus Opacity', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => '',
					'size' => 0.2,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-navigation-menu .navbar-nav.is-submenu-hover-inverse li.dropdown .dropdown-menu > li > a' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'sub_menu_hover_inverse' => 'yes',
				],
			]
		);
		$this->add_control(
			'main_menu_last_open_sub_menu',
			[
				'label' => esc_html__( 'Main Menu Last Open Sub-menu Left', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),				
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'main_menu_last_open_sub_menu_item',
			[
				'label' => esc_html__( 'Open Last Menu Left Side', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 1,
				'default' => 0,
				'condition' => [
					'main_menu_last_open_sub_menu' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		
	}
	
	 protected function render() {
		$menu_attr ='';
        $settings = $this->get_settings_for_display();
		if($settings['show_mobile_menu']=='yes' && $settings['mobile_menu_toggle_style']=='style-5' && $settings['mmts_custom']=='custom_icon'){
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['mmts_custom_icon'], [ 'aria-hidden' => 'true' ]);
			$mmts_custom_icon = ob_get_contents();
			ob_end_clean();						
		}
		if($settings['show_mobile_menu']=='yes' && $settings['mobile_menu_toggle_style']=='style-5' && $settings['mmts_custom']=='custom_icon'){
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['mmts_custom_icon_c'], [ 'aria-hidden' => 'true' ]);
			$mmts_custom_icon_c = ob_get_contents();
			ob_end_clean();						
		}
		$mmts_custom_image_url=(!empty($settings['mmts_custom_image']['url'])) ? $settings['mmts_custom_image']['url'] : '';
		$mmts_custom_image_url_c=(!empty($settings['mmts_custom_image_c']['url'])) ? $settings['mmts_custom_image_c']['url'] : '';
		
		$nav_alignment=$settings["nav_alignment"];
		$menu_hover_click='menu-'.$settings["menu_hover_click"];
		$navbar_menu_type='menu-'.$settings["navbar_menu_type"];
		if($navbar_menu_type != 'menu-vertical' ){		
			$menu_effect = (!empty($settings["menu_transition"])) ? 'plus-menu-'.$settings["menu_transition"] : 'plus-menu-style-1';
			$menu_attr .=' data-menu_transition="'.esc_attr($settings["menu_transition"]).'"';
		}else if( $navbar_menu_type == 'menu-vertical' ){		
			$menu_effect = ($settings["menu_transition"]=='style-1' || $settings["menu_transition"]=='style-2') ? 'plus-menu-'.$settings["menu_transition"] : 'plus-menu-style-1';
			$menu_attr .=($settings["menu_transition"]=='style-1' || $settings["menu_transition"]=='style-2') ? ' data-menu_transition="'.esc_attr($settings["menu_transition"]).'"' : ' data-menu_transition="style-1"';
		}
		$menu_attr .= (!empty($settings['enable_sticky_menu']) && $settings['enable_sticky_menu']=='yes') ? ' data-wid="tp-nav-sticky" data-nav-sticky="'.esc_attr($settings["enable_sticky_menu"]).'"' : '';
		$main_menu_hover_style='menu-hover-'.$settings["main_menu_hover_style"];
		$nav_menu    = ! empty( $settings['navbar'] ) ? wp_get_nav_menu_object( $settings['navbar'] ) : false;
		$mobile_navbar    = ! empty( $settings['mobile_navbar'] ) ? wp_get_nav_menu_object( $settings['mobile_navbar'] ) : false;
		$main_menu_last_open_sub_menu=($settings['main_menu_last_open_sub_menu']=='yes') ? 'open-sub-menu-left' : '';
		$main_menu_hover_inverse=($settings['main_menu_hover_inverse']=='yes') ? 'hover-inverse-effect' : '';
		$main_menu_hover_inverse .=($settings['sub_menu_hover_inverse']=='yes') ? ' submenu-hover-inverse-effect' : '';
		
		$main_menu_indicator_style='main-menu-indicator-'.$settings['main_menu_indicator_style'];
		$sub_menu_indicator_style='sub-menu-indicator-'.$settings['sub_menu_indicator_style'];
		
		$mobile_menu_toggle_style=$settings["mobile_menu_toggle_style"];
		$navbar_attr = [];
	    if ( ! $nav_menu ) {
	    	return;
	    }

		$nav_menu_args=array(
			'menu'           => $nav_menu,
			'theme_location'    => 'default_navmenu',
			'depth'             => 8,
			'container'         => '',
			'container_class'   => '',
			'menu_class'        => 'nav navbar-nav yamm '.$main_menu_hover_style.' '.$main_menu_last_open_sub_menu.' '.$main_menu_hover_inverse,
			'fallback_cb'       => false,
			'walker'            => new Theplus_Navigation_NavWalker
		);
		if($settings["show_mobile_menu"]=='yes' && $settings["mobile_menu_content"]=='normal-menu' && !empty($settings["mobile_navbar"])){
			$mobile_nav_menu_args=array(
				'menu'           => $mobile_navbar,
				'theme_location'    => 'mobile_navmenu',
				'depth'             => 5,
				'container'         => 'div',
				'container_class'   => 'plus-mobile-menu',
				'menu_class'        => 'nav navbar-nav',
				'fallback_cb'       => false,
				'walker'            => new Theplus_Navigation_NavWalker
			);
		}
		if( $settings["show_mobile_menu"]=='yes' && $settings["mobile_menu_content"]=='normal-menu' && !empty($settings["mobile_navbar"]) && !empty($settings["mobile_menu_type"]) && $settings["mobile_menu_type"]=='swiper' ){
			$mobile_swiper_menu_args=array(
				'menu'           => $mobile_navbar,
				'theme_location'    => 'mobile_navmenu',
				'depth'             => 1,
				'container'         => 'div',
				'container_class'   => 'plus-mobile-menu swiper-wrapper',
				'menu_class'        => 'nav navbar-nav swiper-slide swiper-slide-active',
				'fallback_cb'       => false,
				'walker'            => new Theplus_Navigation_NavWalker
			);
		}
		$uid = uniqid("nav-menu").$this->get_id();
		
		$vertical_toggle_title_bar = $toggle_type='';
		if(!empty($navbar_menu_type) && $navbar_menu_type == "menu-vertical-side" && !empty($settings["vertical_side_title_bar"]) && $settings["vertical_side_title_bar"] == 'yes'){
			
			if ( ! empty( $settings['vertical_side_title_link']['url'] ) ) {
				$this->add_render_attribute( 'button', 'href', $settings['vertical_side_title_link']['url'] );
				if ( $settings['vertical_side_title_link']['is_external'] ) {
					$this->add_render_attribute( 'button', 'target', '_blank' );
				}
				if ( $settings['vertical_side_title_link']['nofollow'] ) {
					$this->add_render_attribute( 'button', 'rel', 'nofollow' );
				}
			}
			$this->add_render_attribute( 'button', 'class', 'plus-vertical-side-toggle' );
			
			if(!empty($settings["loop_icon_prefix"])){
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['loop_icon_prefix'], [ 'aria-hidden' => 'true' ]);
				$prefix_icon = ob_get_contents();
				ob_end_clean();						
			}
			
			if(!empty($settings["loop_icon_postfix"])){
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['loop_icon_postfix'], [ 'aria-hidden' => 'true' ]);
				$postfix_icon = ob_get_contents();
				ob_end_clean();						
			}
			
			
			$vertical_toggle_title_bar .='<a '.$this->get_render_attribute_string( "button" ).'>';
				$vertical_toggle_title_bar .='<span>'.$prefix_icon.' '.esc_html($settings['vertical_side_title_text']).'</span>';
				$vertical_toggle_title_bar .=$postfix_icon;
			$vertical_toggle_title_bar .='</a>';
			
			if(!empty($settings["vertical_side_type"])){
				$toggle_type = 'toggle-type-'.esc_attr($settings["vertical_side_type"]);
				if(!empty($settings["vertical_side_click_open"]) && $settings["vertical_side_click_open"]=='yes'){
					$toggle_type .= ' tp-click';
				}
			}
		}
		
		if(!empty($settings["mobile_navbar_outer_click"]) && $settings["mobile_navbar_outer_click"]=='yes'){
			$menu_attr .= ' data-mobile-menu-click="yes"';
		}else{
			$menu_attr .= ' data-mobile-menu-click="no"';
		}
		
		?>
		
		<div class="plus-navigation-wrap <?php echo esc_attr($nav_alignment); ?> <?php echo esc_attr($uid); ?>">
			<div class="plus-navigation-inner <?php echo esc_attr($menu_hover_click); ?> <?php echo esc_attr($main_menu_indicator_style); ?> <?php echo esc_attr($sub_menu_indicator_style); ?> <?php echo esc_attr($menu_effect); ?>" <?php echo $menu_attr; ?>>
				<div id="theplus-navigation-normal-menu" class="collapse navbar-collapse navbar-ex1-collapse">
				
					<div class="plus-navigation-menu <?php echo esc_attr($navbar_menu_type);?>  <?php echo esc_attr($toggle_type); ?>">
						<?php echo $vertical_toggle_title_bar; ?>
						<?php wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $settings ) ); ?>
						
					</div>
					
				</div>
				
				<?php if($settings["show_mobile_menu"]=='yes'){ ?>
					<?php if( empty( $settings["mobile_menu_type"] ) || ( !empty( $settings["mobile_menu_type"] ) && $settings["mobile_menu_type"] != 'swiper') ){ ?>
						<div class="plus-mobile-nav-toggle navbar-header mobile-toggle">
						<?php 
							$st5_cust_cls="";
							if(!empty($mobile_menu_toggle_style) && $mobile_menu_toggle_style=='style-5' && ($settings['mmts_custom']=='custom_icon' || $settings['mmts_custom']=='custom_img')){
									if(!empty($mmts_custom_image_url_c) || !empty($mmts_custom_icon_c)){
										$st5_cust_cls=" clin";
									}
							}else{
								$st5_cust_cls="";
							}
						?>
							<div class="mobile-plus-toggle-menu plus-collapsed toggle-<?php echo esc_attr($mobile_menu_toggle_style)  .$st5_cust_cls; ?>" data-target="#plus-mobile-nav-toggle-<?php echo esc_attr($uid); ?>">
								<?php if(!empty($mobile_menu_toggle_style) && $mobile_menu_toggle_style=='style-1'){ ?>
								<ul class="toggle-lines">
									<li class="toggle-line"></li>
									<li class="toggle-line"></li>
								</ul>
								<?php }else if(!empty($mobile_menu_toggle_style) && $mobile_menu_toggle_style=='style-2'){ ?>
											<div class="mobile-plus-toggle-menu-st2"></div><div class="mobile-plus-toggle-menu-st2-h"></div>
								<?php }else if(!empty($mobile_menu_toggle_style) && $mobile_menu_toggle_style=='style-3'){ ?>
											<div class="mobile-plus-toggle-menu-st3"></div>
								<?php }else if(!empty($mobile_menu_toggle_style) && $mobile_menu_toggle_style=='style-4'){ ?>
											<span></span><span></span><span></span>
								<?php }else if(!empty($mobile_menu_toggle_style) && $mobile_menu_toggle_style=='style-5') { 
										
												if($settings['mmts_custom']=='custom_icon' && !empty($mmts_custom_icon)){
													echo '<span class="extra_toggle_open et_icon_img_st5">'.$mmts_custom_icon.'</span>';
													if($settings['mmts_custom']=='custom_icon' && !empty($mmts_custom_icon_c)){
														echo '<span class="extra_toggle_open et_icon_img_st5_c">'.$mmts_custom_icon_c.'</span>';
													}
												}else if($settings['mmts_custom']=='custom_img'){													
													if(!empty($mmts_custom_image_url)){
														$mmts_custom_image= $mmts_custom_image_url;	
															if(!empty($mmts_custom_image_url_c)){
																$mmts_custom_image_c= $mmts_custom_image_url_c;	
															}else{
																$mmts_custom_image_c='';
															}
													}else{
														$mmts_custom_image= '';														
													}
													echo '<img class="tp-icon-img" src='.esc_url($mmts_custom_image).' />';
														if(!empty($mmts_custom_image_url_c)){
															echo '<img class="tp-icon-img-close" src='.esc_url($mmts_custom_image_c).' />';
														}
												}
								} ?>
							</div>
						</div>
					<?php } ?>
					<?php 
					if(!empty($settings["mobile_menu_type"]) && $settings["mobile_menu_type"]=='swiper'){
						$swiper_class=' swiper-container swiper-free-mode';
					}else{
						$swiper_class='';
					}
					
					$mobile_nav_custom_class='';
					if($settings['mobile_nav_size_open']=='custom'){
						$mobile_nav_custom_class = 'nav-cust-width';
					}
					
					?>
					<div id="plus-mobile-nav-toggle-<?php echo esc_attr($uid); ?>" class="collapse navbar-collapse navbar-ex1-collapse plus-mobile-menu-content <?php echo $mobile_nav_custom_class .esc_attr($swiper_class); ?>">
						<?php
							if( $settings["mobile_menu_content"]=='normal-menu' && !empty($settings["mobile_navbar"]) && !empty($settings["mobile_menu_type"]) && $settings["mobile_menu_type"]=='swiper' ){
								wp_nav_menu( apply_filters( 'widget_nav_menu_args', $mobile_swiper_menu_args, $nav_menu, $settings ) );
							}else if($settings["mobile_menu_content"]=='normal-menu' && !empty($settings["mobile_navbar"])){							
								wp_nav_menu( apply_filters( 'widget_nav_menu_args', $mobile_nav_menu_args, $nav_menu, $settings ) );
							} ?>
						<?php if($settings["mobile_menu_content"]=='template-menu' && !empty($settings['mobile_navbar_template'])){
							echo '<div class="plus-content-editor">'.Theplus_Element_Load::elementor()->frontend->get_builder_content_for_display( $settings['mobile_navbar_template'] ).'</div>';
						 } ?>
					</div>
				<?php } ?>
				
			</div>
		</div>
		 
		<?php 
		$css_rule='';
		if($settings['main_menu_last_open_sub_menu']=='yes'){
			$menu_item=$settings['main_menu_last_open_sub_menu_item'];			
			if(is_rtl()){
				$css_rule .='[dir="rtl"] .'.esc_attr($uid).' .plus-navigation-menu:not(.menu-vertical) .navbar-nav.open-sub-menu-left > li:nth-last-child(-n+'.$menu_item.') > ul.dropdown-menu ul.dropdown-menu{right: auto;left: 100% !important;}';
			}else{
				$css_rule .='.'.esc_attr($uid).' .plus-navigation-menu:not(.menu-vertical) .navbar-nav.open-sub-menu-left > li:nth-last-child(-n+'.$menu_item.') > ul.dropdown-menu ul.dropdown-menu{left: auto !important;right: 100%;}.'.esc_attr($uid).' .plus-navigation-menu:not(.menu-vertical) .navbar-nav.open-sub-menu-left > li:nth-last-child(-n+'.$menu_item.') > ul.dropdown-menu {left: 0;}';
			}
		}
		if($settings["show_mobile_menu"]=='yes' && !empty($settings['open_mobile_menu']['size'])){
			$open_mobile_menu=($settings['open_mobile_menu']['size']).$settings['open_mobile_menu']['unit'];
			$close_mobile_menu=($settings['open_mobile_menu']['size']+1).$settings['open_mobile_menu']['unit'];
			
			$css_rule .='@media (min-width:'.esc_attr($close_mobile_menu).'){.plus-navigation-wrap.'.esc_attr($uid).' #theplus-navigation-normal-menu{display: block!important;}.plus-navigation-wrap.'.esc_attr($uid).' #plus-mobile-nav-toggle-'.esc_attr($uid).'.collapse.in{display:none;}}';
			
			$css_rule .='@media (max-width:'.esc_attr($open_mobile_menu).'){.plus-navigation-wrap.'.esc_attr($uid).' #theplus-navigation-normal-menu{display:none !important;}.plus-navigation-wrap.'.esc_attr($uid).' .plus-mobile-nav-toggle.mobile-toggle{display: -webkit-flex;display: -moz-flex;display: -ms-flex;display: flex;-webkit-align-items: center;-moz-align-items: center;-ms-align-items: center;align-items: center;-webkit-justify-content: flex-end;-moz-justify-content: flex-end;-ms-justify-content: flex-end;justify-content: flex-end;}.plus-navigation-wrap .plus-mobile-menu-content.collapse.swiper-container{display: block;}}';
		}else{
			$css_rule .='.plus-navigation-wrap.'.esc_attr($uid).' #theplus-navigation-normal-menu{display: block!important;}';
		}
		echo '<style>'.$css_rule.'</style>';
	}
	
    protected function content_template() {
	
    }

}
