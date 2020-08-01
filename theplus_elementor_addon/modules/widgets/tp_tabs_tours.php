<?php 
/*
Widget Name: Tabs And Tours
Description: Toggle of a tabs and tours content.
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
use Elementor\Group_Control_Image_Size;
use TheplusAddons\Theplus_Element_Load;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Tabs_Tours extends Widget_Base {
		
	public function get_name() {
		return 'tp-tabs-tours';
	}

    public function get_title() {
        return esc_html__('Tabs/Tours', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-th-list theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-tabbed');
    }
	public function get_keywords() {
		return ['tabs', 'tours', 'tabbed content'];
	}
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__( 'Title & Content', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Tab Title' , 'theplus' ),
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'content_source',
			[
				'label' => esc_html__( 'Content Source', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => [
					'content'  => esc_html__( 'Content', 'theplus' ),
					'page_template' => esc_html__( 'Page Template', 'theplus' ),
				],
			]
		);
		$repeater->add_control(
			'tab_content',
			[
				'label' => esc_html__( 'Content', 'theplus' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Content', 'theplus' ),
				'show_label' => false,
				'dynamic' => ['active'   => true,],
				'condition'    => [
					'content_source' => [ 'content' ],
				],
			]
		);
		$repeater->add_control(
			'content_template',
			[
				'label'       => esc_html__( 'Elementor Templates', 'theplus' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => theplus_get_templates(),
				'label_block' => 'true',
				'condition'   => ['content_source' => "page_template"],
			]
		);
		$repeater->add_control(
			'backend_preview_template',[
				'label'   => esc_html__( 'Backend Visibility', 'theplus' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),	
				'description' => esc_html__( 'Note : If disabled, Template will not visible/load in the backend for better page loading performance.', 'theplus' ),
				'separator' => 'after',
			]
		);
		
		$repeater->add_control(
			'display_icon',[
				'label'   => esc_html__( 'Show Inner Icon', 'theplus' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),	
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'icon_style',
			[
				'label' => esc_html__( 'Icon Font', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome', 'theplus' ),
					'icon_mind' => esc_html__( 'Icons Mind', 'theplus' ),
					'image' => esc_html__( 'Image', 'theplus' ),
				],
				'condition' => [
					'display_icon' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'icon_fontawesome',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-plus',
				'separator' => 'before',
				'condition' => [
					'display_icon' => 'yes',
					'icon_style' => 'font_awesome',
				],
			]
		);
		$repeater->add_control(
			'icons_mind',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::SELECT2,
				'default' => 'iconsmind-Add',
				'label_block' => true,
				'options' => theplus_icons_mind(),
				'condition' => [
					'display_icon' => 'yes',
					'icon_style' => 'icon_mind',
				],
			]
		);
		$repeater->add_control(
			'icon_image',
			[
				'label' => esc_html__( 'Icon Image', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'dynamic' => ['active'   => true,],
				'condition' => [
					'display_icon' => 'yes',
					'icon_style' => 'image',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'icon_image_thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'before',
				'condition' => [
					'display_icon' => 'yes',
					'icon_style' => 'image',
				],
			]
		);
		$repeater->add_control(
			'display_icon1',[
				'label'   => esc_html__( 'Show Outer Icon', 'theplus' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),	
				'separator' => 'before',
			]
		);		
		$repeater->add_control(
			'icon_fontawesome1',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-plus',
				'separator' => 'before',
				'condition' => [
					'display_icon1' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'tab_hashid',
			[
				'label' => esc_html__( 'Unique ID', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => [
					'active' => true,
				],
				'title' => __( 'Add custom ID WITHOUT the Pound key. e.g: tab-id', 'theplus' ),
				'label_block' => false,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tabs',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => esc_html__( 'Tab #1', 'theplus' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'theplus' ),
					],
					[
						'tab_title' => esc_html__( 'Tab #2', 'theplus' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'theplus' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'layout_content_section',
			[
				'label' => esc_html__( 'Layout', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'tabs_type',
			[
				'label' => esc_html__( 'Layout', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'theplus' ),
					'vertical' => esc_html__( 'Vertical', 'theplus' ),
				],
				'prefix_class' => 'elementor-tabs-view-',
				
			]
		);
		$this->add_control(
			'tabs_align_horizontal',
			[
				'label' => esc_html__( 'Navigation Position', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'theplus' ),
						'icon' => 'fa fa-level-up',
					],					
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'theplus' ),
						'icon' => 'fa fa-level-down',
					],
				],
				'default' => 'top',
				'label_block' => false,
				'separator' => 'after',
				'condition'    => [
					'tabs_type' => [ 'horizontal' ],
				],
			]
		);
		$this->add_control(
			'tabs_align_vertical',
			[
				'label' => esc_html__( 'Navigation Position', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon' => 'fa fa-align-left',
					],					
					'right' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'label_block' => false,
				'separator' => 'after',
				'condition'    => [
					'tabs_type' => [ 'vertical' ],
				],
			]
		);
		$this->add_control(
			'tabs_swiper',[
				'label'   => esc_html__( 'Swiper Effect', 'theplus' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'On', 'theplus' ),
				'label_off' => esc_html__( 'Off', 'theplus' ),
				'separator' => 'before',
				'condition'    => [
					'tabs_type' => [ 'horizontal' ],
				],
			]
		);
		$this->add_control(
			'default_active_tab',
			[
				'label' => esc_html__( 'Default Active Tab', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => theplus_get_numbers(),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'on_hover_tabs',[
				'label'   => esc_html__( 'On Hover Tab', 'theplus' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'connection_unique_id',
			[
				'label' => esc_html__( 'Connection Carousel ID', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',				
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_toggle_style_icon',
			[
				'label' => esc_html__( 'Icon', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
            'icon_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header .tab-icon-wrap,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title .tab-icon-wrap' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header .tab-icon-image' => 'max-width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header .tab-icon-wrap,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title .tab-icon-wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label' => esc_html__( 'Active Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover .tab-icon-wrap,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active .tab-icon-wrap,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active .tab-icon-wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__( 'Spacing', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav:not(.full-width-icon) .plus-tab-header .tab-icon-wrap,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title .tab-icon-wrap' => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-tabs-wrapper ul.plus-tabs-nav.full-width-icon .plus-tab-header .tab-icon-wrap' => 'padding-right: 0;padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'full_icon',[
				'label'   => esc_html__( 'Full Width Icon', 'theplus' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),	
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_toggle_style_icon_outer',
			[
				'label' => esc_html__( 'Outer Icon', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
            'icon_o_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-nav-wrapper .plus-tabs-nav .tab-sep-icon' => 'font-size: {{SIZE}}{{UNIT}};',					
				],
            ]
        );
		$this->add_control(
			'icon_o_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-nav-wrapper .plus-tabs-nav .tab-sep-icon' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'res_outer_icon',[
				'label'   => esc_html__( 'Hide on Mobile', 'theplus' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Yes', 'theplus' ),
				'label_off' => esc_html__( 'No', 'theplus' ),	
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Tab Title Bar', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'nav_vertical_width',
			[
				'label' => esc_html__( 'Navigation Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' , 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 600,
						'step' => 2,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 25,
				],
				'selectors'  => [
					'{{WRAPPER}}.elementor-tabs-view-vertical .theplus-tabs-nav-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tabs_type' => 'vertical',
				],
				
			]
		);
		$this->add_control(
			'nav_vertical_align',
			[
				'label' => esc_html__( 'Vertical Alignment', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'align-top' => [
						'title' => esc_html__( 'Top', 'theplus' ),
						'icon' => 'fa fa-arrow-up',
					],
					'align-center' => [
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon' => 'fa fa-align-center',
					],
					'align-bottom' => [
						'title' => esc_html__( 'Bottom', 'theplus' ),
						'icon' => 'fa fa-arrow-down',
					],
				],
				'default' => 'align-top',
				'label_block' => false,
				'separator' => 'after',
				'condition' => [
					'tabs_type' => 'vertical',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title',
			]
		);
		$this->add_control(
			'nav_align',
			[
				'label' => esc_html__( 'Nav Alignment', 'theplus' ),
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
				'default' => 'text-left',
				'label_block' => false,
			]
		);
		$this->add_control(
			'nav_full_width',
			[
				'label' => esc_html__( 'Nav Full-Width', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theplus' ),
				'label_off' => esc_html__( 'No', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'nav_title_display',
			[
				'label' => esc_html__( 'Title On/Off', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'theplus' ),
				'label_off' => esc_html__( 'Off', 'theplus' ),
				'default' => 'yes',
				'separator' => 'after',
			]
		);
		$this->add_control(
			'nav_same_width',
			[
				'label' => esc_html__( 'Nav Equal Width', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theplus' ),
				'label_off' => esc_html__( 'No', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_responsive_control(
			'nav_same_width_size',
			[
				'label' => esc_html__( 'Width Size', 'theplus' ),
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
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-tp-tabs-tours ul.plus-tabs-nav li,{{WRAPPER}} .theplus-tabs-wrapper ul.plus-tabs-nav' => 'display: block;',
				],
				'condition' => [
					'nav_same_width' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_color_options',
			[
				'label' => esc_html__( 'Title Color Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_title_style' );
		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'title_color_option',
			[
				'label' => esc_html__( 'Title Color', 'theplus' ),
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
				'default' => 'solid',
				'label_block' => false,
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'title_color_option' => 'solid',
				],
			]
		);
		$this->add_control(
            'title_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'title_color_option' => 'gradient',
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
				'condition' => [
					'title_color_option' => 'gradient',
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
				'condition' => [
					'title_color_option' => 'gradient',
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
				'condition' => [
					'title_color_option' => 'gradient',
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
				'condition' => [
					'title_color_option' => 'gradient',
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
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title span:not(.tab-icon-wrap)' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition'    => [
					'title_color_option' => 'gradient',
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
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title span:not(.tab-icon-wrap)' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition' => [
					'title_color_option' => 'gradient',
					'title_gradient_style' => 'radial',
			],
			'of_type' => 'gradient',
			]
        );
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_title_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_control(
			'title_active_color_option',
			[
				'label' => esc_html__( 'Title Active Color', 'theplus' ),
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
				'default' => 'solid',
				'label_block' => false,
			]
		);
		$this->add_control(
			'title_active_color',
			[
				'label' => esc_html__( 'Active Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3351a6',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active' => 'color: {{VALUE}}',
				],
				'condition' => [
					'title_active_color_option' => 'solid',
				],
			]
		);
		$this->add_control(
            'title_active_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'title_active_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_active_gradient_color1_control',
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
					'title_active_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_active_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition' => [
					'title_active_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_active_gradient_color2_control',
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
					'title_active_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_active_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'theplus'),
                'default' => 'linear',
                'options' => theplus_get_gradient_styles(),
				'condition' => [
					'title_active_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_active_gradient_angle', [
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
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active span:not(.tab-icon-wrap)' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_active_gradient_color1.VALUE}} {{title_active_gradient_color1_control.SIZE}}{{title_active_gradient_color1_control.UNIT}}, {{title_active_gradient_color2.VALUE}} {{title_active_gradient_color2_control.SIZE}}{{title_active_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition'    => [
					'title_active_color_option' => 'gradient',
					'title_active_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'title_active_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'theplus'),
				'options' => theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active span:not(.tab-icon-wrap)' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_active_gradient_color1.VALUE}} {{title_active_gradient_color1_control.SIZE}}{{title_active_gradient_color1_control.UNIT}}, {{title_active_gradient_color2.VALUE}} {{title_active_gradient_color2_control.SIZE}}{{title_active_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition' => [
					'title_active_color_option' => 'gradient',
					'title_active_gradient_style' => 'radial',
			],
			'of_type' => 'gradient',
			]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
//start underline
		$this->start_controls_section(
			'section_tab_underline',
			[
				'label' => esc_html__( 'Under Line', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'tab_title_underline_display',
			[
				'label' => esc_html__( 'Underline', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
				'separator' => 'after',
			]
		);
		$this->add_control(
			'underline_color',
			[
				'label' => esc_html__( 'Underline Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav.nav-tab-underline .plus-tab-header.active:before' => 'background: linear-gradient(to right,#fff0 0%,{{VALUE}}  50%,#fff0 100%)',					
				],
				'condition' => [
					'tab_title_underline_display' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'underline_top_margin',
			[
				'label' => esc_html__( 'Top Margin', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav.nav-tab-underline .plus-tab-header.active:before,{{WRAPPER}} ul.plus-tabs-nav.nav-tab-underline:before' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tab_title_underline_display' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'underline_width',
			[
				'label' => esc_html__( 'Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav.nav-tab-underline .plus-tab-header.active:before' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tab_title_underline_display' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'underline_height',
			[
				'label' => esc_html__( 'Height', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav.nav-tab-underline .plus-tab-header.active:before,{{WRAPPER}} ul.plus-tabs-nav.nav-tab-underline:before' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tab_title_underline_display' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		//end underline
		$this->start_controls_section(
			'section_title_bg_style',
			[
				'label' => esc_html__( 'Tab Title Bar Background', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'nav_inner_margin',
			[
				'label' => esc_html__( 'Nav Inner Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'nav_inner_padding',
			[
				'label' => esc_html__( 'Nav Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'nav_title_space',
			[
				'label' => esc_html__( 'Navigation Between Space', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'{{WRAPPER}}.elementor-tabs-view-horizontal .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-tabs-view-horizontal .theplus-tabs-wrapper .plus-tabs-nav li:first-child .plus-tab-header' => 'margin-left:0;',
					'{{WRAPPER}}.elementor-tabs-view-horizontal .theplus-tabs-wrapper .plus-tabs-nav li:last-child .plus-tab-header' => 'margin-right:0;',
					'{{WRAPPER}}.elementor-tabs-view-vertical .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'margin-top: {{SIZE}}{{UNIT}};margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-tabs-view-vertical .theplus-tabs-wrapper .plus-tabs-nav li:first-child .plus-tab-header' => 'margin-top:0;',
					'{{WRAPPER}}.elementor-tabs-view-vertical .theplus-tabs-wrapper .plus-tabs-nav li:last-child .plus-tab-header' => 'margin-bottom:0;',
					
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'nav_box_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'nav_border_style',
			[
				'label' => esc_html__( 'Border Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'nav_border_width',
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
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'nav_box_border_style' );
		$this->start_controls_tab(
			'nav_border_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'nav_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'nav_border_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_border_active_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'nav_border_active_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->start_controls_tabs( 'nav_background_style' );
		$this->start_controls_tab(
			'nav_background_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'nav_box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'nav_background_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'nav_box_active_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'nav_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'nav_shadow_style' );
		$this->start_controls_tab(
			'nav_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'nav_box_shadow',
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'nav_shadow_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'nav_box_active_shadow',
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*title bg style*/
		/*Tab Nav background style*/
		$this->start_controls_section(
            'section_nav_bg_styling',
            [
                'label' => esc_html__('Navigation Area Background', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_responsive_control(
			'nav_bg_margin',
			[
				'label' => esc_html__( 'Margin Space', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'nav_bg_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'nav_bg_box_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'nav_bg_border_style',
			[
				'label' => esc_html__( 'Border Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'nav_bg_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'nav_bg_box_border_width',
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
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'nav_bg_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'nav_bg_border_tab' );
		$this->start_controls_tab(
			'nav_bg_border_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
				'condition' => [
					'nav_bg_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_bg_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'nav_bg_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'nav_bg_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'nav_bg_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'nav_bg_border_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
				'condition' => [
					'nav_bg_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_bg_box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'nav_bg_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'nav_bg_border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'nav_bg_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->start_controls_tabs( 'nav_bg_background_style' );
		$this->start_controls_tab(
			'nav_bg_background_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'nav_bg_box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'nav_bg_background_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'nav_bg_box_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'nav_bg_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'nav_bg_shadow_style' );
		$this->start_controls_tab(
			'nav_bg_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'nav_bg_box_shadow',
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'nav_bg_shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'nav_bg_box_hover_shadow',
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-nav-wrapper .plus-tabs-nav:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*tab Nav background style*/
		/*desc style*/
		$this->start_controls_section(
            'section_desc_styling',
            [
                'label' => esc_html__('Content', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper .plus-tab-content .plus-content-editor',
			]
		);
		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Desc Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper .plus-tab-content .plus-content-editor,{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper .plus-tab-content .plus-content-editor p' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
		'section_desc_bg_styling',
            [
                'label' => esc_html__('Content Background', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_responsive_control(
			'content_tab_margin',
			[
				'label' => esc_html__( 'Content Margin Space', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion.mobile-accordion-tab .theplus-tabs-content-wrapper .plus-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'content_tab_padding',
			[
				'label' => esc_html__( 'Content Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion.mobile-accordion-tab .theplus-tabs-content-wrapper .plus-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'content_border_options',
			[
				'label' => esc_html__( 'Border Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'content_box_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'content_border_style',
			[
				'label' => esc_html__( 'Border Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'content_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'content_box_border_width',
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
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'content_box_border' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'content_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'content_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'content_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'content_background_options',
			[
				'label' => esc_html__( 'Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'content_box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper',
				
			]
		);
		$this->add_control(
			'content_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'content_box_shadow',
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper',
			]
		);
		
		$this->end_controls_section();
		/*desc style*/
		/* Extra option */
		$this->start_controls_section(
            'section_extra_options',
            [
                'label' => esc_html__('Extra Options', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		
		$this->start_controls_tabs( 'nav_extra_effect_style' );
		$this->start_controls_tab(
			'nav_extra_effect_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_responsive_control(
			'nav_tab_opacity',
			[
				'label' => esc_html__( 'Navigation Opacity', 'theplus' ),
				'type' => Controls_Manager::SLIDER,				
				'range' => [
					'' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'default' => [
					'unit' => '',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-tp-tabs-tours .plus-tab-header' => 'opacity: {{SIZE}};',
				],
			]
		);
		$this->add_responsive_control(
			'nav_tab_scale',
			[
				'label' => esc_html__( 'Navigation Scale/Zoom', 'theplus' ),
				'type' => Controls_Manager::SLIDER,				
				'range' => [
					'' => [
						'min' => -0.3,
						'max' => 2,
						'step' => 0.01,
					],
				],
				'default' => [
					'unit' => '',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-tp-tabs-tours .plus-tab-header' => '-webkit-transform:scale({{SIZE}});-moz-transform:scale({{SIZE}});-ms-transform:scale({{SIZE}});-o-transform:scale({{SIZE}});transform:scale({{SIZE}});',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'nav_extra_effect_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_responsive_control(
			'nav_tab_opacity_active',
			[
				'label' => esc_html__( 'Navigation Active Opacity', 'theplus' ),
				'type' => Controls_Manager::SLIDER,				
				'range' => [
					'' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'default' => [
					'unit' => '',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-tp-tabs-tours .plus-tab-header.active' => 'opacity: {{SIZE}};',
				],
			]
		);
		$this->add_responsive_control(
			'nav_tab_scale_active',
			[
				'label' => esc_html__( 'Navigation Active Scale/Zoom', 'theplus' ),
				'type' => Controls_Manager::SLIDER,				
				'range' => [
					'' => [
						'min' => -0.3,
						'max' => 2,
						'step' => 0.01,
					],
				],
				'default' => [
					'unit' => '',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-tp-tabs-tours .plus-tab-header.active' => '-webkit-transform:scale({{SIZE}});-moz-transform:scale({{SIZE}});-ms-transform:scale({{SIZE}});-o-transform:scale({{SIZE}});transform:scale({{SIZE}});',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'tab_nav_responsive',
			[
				'label'   => esc_html__( 'Tab Navigation Responsive', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => esc_html__( 'None', 'theplus' ),
					'nav_full' => esc_html__( 'Full Width (For Less tabs) ', 'theplus' ),
					'nav_one' => esc_html__( 'One By One', 'theplus' ),
					'tab_accordion' => esc_html__( 'Force Accordion', 'theplus' ),
				],
				'separator' => 'before',
				'description' => esc_html__('These options are for making your tabs look different in small devices. You can select none, If you want to keep your settings.','theplus'),
			]
		);
		$this->add_control(
			'tab_accordion_options',
			[
				'label' => esc_html__( 'Accordion Navigation Options', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tab_nav_responsive!' => ['','nav_full'],
				],
			]
		);
		$this->add_responsive_control(
			'nav_vertical_title_space',
			[
				'label' => esc_html__( 'Navigation Between Space', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}}.elementor-tabs-view-horizontal .theplus-tabs-wrapper.nav-one-by-one .plus-tabs-nav .plus-tab-header' => 'margin-top: {{SIZE}}{{UNIT}};margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-tabs-view-horizontal .theplus-tabs-wrapper.nav-one-by-one .plus-tabs-nav li:first-child .plus-tab-header' => 'margin-top:0;',
					'{{WRAPPER}}.elementor-tabs-view-horizontal .theplus-tabs-wrapper.nav-one-by-one .plus-tabs-nav li:last-child .plus-tab-header' => 'margin-bottom:0;',
					
				],
				'condition' => [
					'tabs_type' => 'horizontal',
					'tab_nav_responsive' => 'nav_one',
				],
			]
		);
		$this->add_control(
			'accordion_box_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		
		$this->add_control(
			'accordion_border_style',
			[
				'label' => esc_html__( 'Border Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
					'accordion_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'accordion_border_width',
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
					'{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
					'accordion_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'accordion__box_border_style' );
		$this->start_controls_tab(
			'accordion_border_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
					'accordion_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'accordion_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
					'accordion_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'accordion_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
					'accordion_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'accordion_border_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
					'accordion_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'accordion_border_active_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
					'accordion_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'accordion_border_active_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
					'accordion_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->start_controls_tabs( 'accordion_background_style' );
		$this->start_controls_tab(
			'accordion_background_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'accordion_box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title',
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'accordion_background_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'accordion_box_active_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active',
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'accordion_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->start_controls_tabs( 'accordion_shadow_style' );
		$this->start_controls_tab(
			'accordion_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'accordion_box_shadow',
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title',
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'accordion_shadow_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'accordion_box_active_shadow',
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active',
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/* Extra option */
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
		$templates = Theplus_Element_Load::elementor()->templates_manager->get_source( 'local' )->get_items();
		
		$tabs = $this->get_settings_for_display( 'tabs' );
		$nav_align=$settings["nav_align"];
		$id_int = substr( $this->get_id_int(), 0, 3 );
		$full_icon = ($settings['full_icon']=='yes') ? 'full-width-icon' : '';
		$nav_full_width = $settings['nav_full_width'];		
		$nav_full_width = ($nav_full_width=='yes') ? 'full-width' : '';
		$nav_underline = $settings['tab_title_underline_display'];		
		$nav_underline = ($nav_underline=='yes') ? 'nav-tab-underline' : '';
		$nav_vertical_align = $settings['nav_vertical_align'];
		$uid=uniqid("tabs");
		
		$connect_carousel =$row_bg_conn='';
		if(!empty($settings["connection_unique_id"])){
			$connect_carousel="tpca_".$settings["connection_unique_id"];
			$uid="tptab_".$settings["connection_unique_id"];
			$row_bg_conn = ' data-row-bg-conn="bgcarousel'.esc_attr($settings["connection_unique_id"]).'"';
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
			
		if(!empty($settings['res_outer_icon']) && $settings['res_outer_icon'] == 'yes'){
			$res_outer_class = 'hide_mobile_sep_icon';
		}else{
			$res_outer_class = '';
		}
		
		$swiper_container =$swiper_wrap=$swiper_slide='';
		if( !empty($settings['tabs_swiper']) && $settings['tabs_swiper']=='yes' && $settings["tabs_type"]=='horizontal'){
			$swiper_container = 'swiper-container swiper-free-mode';
			$swiper_wrap = 'swiper-wrapper';
			$swiper_slide = 'swiper-slide swiper-slide-active';
		}
			
			$tab_nav ='<div class="theplus-tabs-nav-wrapper elementor-tabs-wrapper '.esc_attr($nav_align).' '.esc_attr($nav_vertical_align).' '.esc_attr($swiper_wrap).'">';
				$tab_nav .='<ul class="plus-tabs-nav  '.esc_attr($nav_underline).' '.esc_attr($nav_full_width).' '.esc_attr($full_icon).' '.esc_attr($swiper_slide).'">';
				foreach ( $tabs as $index => $item ) :
					$tab_count = $index + 1;
					
					
					if(!empty($item['tab_hashid'])){
						$tab_title_id = trim( $item['tab_hashid'] );
						$tab_content_id = 'tab-content-'.trim( $item['tab_hashid'] );
					}else{
						$tab_title_id = 'elementor-tab-title-' . $id_int . $tab_count;
						$tab_content_id = 'elementor-tab-content-' . $id_int . $tab_count;
					}
					
					$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
					
					$this->add_render_attribute( $tab_title_setting_key, [
						'id' => $tab_title_id,
						'class' => [ 'elementor-tab-title' , 'elementor-tab-desktop-title' , 'plus-tab-header'],
						'data-tab' => $tab_count,
						'tabindex' => $id_int . $tab_count,
						'role' => 'tab',
						'aria-controls' => $tab_content_id,
					] );
					
					$tab_nav .='<li>';
					$tab_nav .='<div '.$this->get_render_attribute_string( $tab_title_setting_key ).'>';
					$image_alt='';
						if ( $item['display_icon']=='yes' ) :
							$icons=$icon_image='';
							if($item['icon_style']=='font_awesome'){
								$icons=$item['icon_fontawesome'];									
							}else if($item['icon_style']=='icon_mind'){
								$icons=$item['icons_mind'];									
							}else if($item['icon_style']=='image' && !empty($item['icon_image']["url"])){								
								$icon_image=$item['icon_image']['id'];
								$img = wp_get_attachment_image_src($icon_image,$item['icon_image_thumbnail_size']);
								$icon_image = $img[0];
								
								$image_id=$item["icon_image"]["id"];
								$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
								if(!$image_alt){
									$image_alt = get_the_title($image_id);
								}else if(!$image_alt){
									$image_alt = 'tab icon image';
								}								
							}
							if(!empty($icons) || !empty($icon_image)){
							$tab_nav .='<span class="tab-icon-wrap" aria-hidden="true">';
								if($item['icon_style']!='image'){
									$tab_nav .='<i class="tab-icon '.esc_attr( $icons ).'"></i>';
								}else{
									$tab_nav .='<img src="'.esc_url($icon_image).'" class="tab-icon tab-icon-image" alt="'.esc_attr($image_alt).'" />';
								}
								$tab_nav .='</span>';
							}
						endif;
						if($settings["nav_title_display"]=='yes'){
							$tab_nav .='<span>'.$item['tab_title'].'</span>';
						}
					$tab_nav .='</div>';
					
					if ( !empty($item['display_icon1']) && $item['display_icon1']=='yes' && !empty($item['icon_fontawesome1']) ) :
						$tab_nav .='<div class="tab-sep-icon '.esc_attr($res_outer_class).'"><i class="tab-between-icon '.esc_attr( $item['icon_fontawesome1'] ).'"></i></div>';
					endif;
					
					$tab_nav .='</li>';
				endforeach;
				$tab_nav .='</ul>';
			$tab_nav .='</div>';
			$tab_content ='<div class="theplus-tabs-content-wrapper elementor-tabs-content-wrapper">';
				foreach ( $tabs as $index => $item ) :
					$tab_count = $index + 1;
					
					$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

					$tab_title_mobile_setting_key = $this->get_repeater_setting_key( 'tab_title_mobile', 'tabs', $tab_count );
					
					$this->add_render_attribute( $tab_content_setting_key, [
						'id' => $tab_content_id,
						'class' => [ 'elementor-tab-content', 'elementor-clearfix','plus-tab-content'],
						'data-tab' => $tab_count,
						'role' => 'tabpanel',
						'aria-labelledby' => $tab_title_id,
					] );

					$this->add_render_attribute( $tab_title_mobile_setting_key, [
						'class' => [ 'elementor-tab-title', 'elementor-tab-mobile-title',$nav_align ],
						'tabindex' => $id_int . $tab_count,
						'data-tab' => $tab_count,
						'role' => 'tab',
					] );

					$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
					
					$tab_content .='<div '.$this->get_render_attribute_string( $tab_title_mobile_setting_key ).'>';
					$image_alt='';
						if ( $item['display_icon']=='yes' ) :
							$icons=$icon_image='';
							if($item['icon_style']=='font_awesome'){
								$icons=$item['icon_fontawesome'];									
							}else if($item['icon_style']=='icon_mind'){
								$icons=$item['icons_mind'];									
							}else if($item['icon_style']=='image' && !empty($item['icon_image']["url"])){
								//$icon_image=$item['icon_image']["url"];	
								$icon_image=$item['icon_image']['id'];
								$img = wp_get_attachment_image_src($icon_image,$item['icon_image_thumbnail_size']);
								$icon_image = $img[0];
								
								$image_id=$item["icon_image"]["id"];
								$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
								if(!$image_alt){
									$image_alt = get_the_title($image_id);
								}else if(!$image_alt){
									$image_alt = 'tab icon image';
								}								
							}
							if(!empty($icons) || !empty($icon_image)){
								$tab_content .='<span class="tab-icon-wrap" aria-hidden="true">';
									if($item['icon_style']!='image'){
										$tab_content .='<i class="tab-icon '.esc_attr( $icons ).'"></i>';
									}else{
										$tab_content .='<img src="'.esc_url($icon_image).'" class="tab-icon tab-icon-image" alt="'.esc_attr($image_alt).'" />';
									}
								$tab_content .='</span>';
							}
						endif;
						$tab_content .='<span>'.$item['tab_title'].'</span>';
					$tab_content .='</div>';
					$tab_content .='<div '.$this->get_render_attribute_string( $tab_content_setting_key ).'>';
						if($item['content_source']=='content' && !empty($item['tab_content'])){
							$tab_content .='<div class="plus-content-editor">'.$this->parse_text_editor( $item['tab_content'] ).'</div>';
						}
						if(\Elementor\Plugin::$instance->editor->is_edit_mode() && $item["content_source"]=='page_template' && !empty($item['content_template'])){
							if(!empty($item["backend_preview_template"]) && $item["backend_preview_template"]=='yes'){
								$tab_content .='<div class="plus-content-editor">'.Theplus_Element_Load::elementor()->frontend->get_builder_content_for_display( $item['content_template'] ).'</div>';
							}else{
								$get_template_name='';
								$get_template_id=$item['content_template'];
								if(!empty($templates) && !empty($get_template_id)){
									foreach($templates as $value){
										if($value["template_id"]==$get_template_id){
											$get_template_name=$value["title"];
										}
									}
								}
								$tab_content .='<div class="tab-preview-template-notice"><div class="preview-temp-notice-heading">Selected Template : <b>"'.esc_attr($get_template_name).'"</b></div><div class="preview-temp-notice-desc"><b>Note :</b> We have turn off visibility of template in the backend due to performance improvements. This will be visible perfectly on the frontend.</div></div>';
							}
						}else if($item["content_source"]=='page_template' && !empty($item['content_template'])){
							
							$tab_content .='<div class="plus-content-editor">'.Theplus_Element_Load::elementor()->frontend->get_builder_content_for_display( $item['content_template'] ).'</div>';
						}
					$tab_content .='</div>';
				endforeach;
			$tab_content .='</div>';
		$default_active='';
		if(!empty($settings['default_active_tab'])){
			$default_active .= ' data-tab-default="'.($settings["default_active_tab"]-1) .'"';
		}else{
			$default_active .= ' data-tab-default="0"';
		}
		if(!empty($settings['on_hover_tabs']=='yes')){
			$default_active .= ' data-tab-hover="yes"';
		}else{
			$default_active .= ' data-tab-hover="no"';
		}
		$responsive_class='';
		if($settings["tab_nav_responsive"]=='nav_full'){
			$responsive_class='nav-full-width';
		}else if($settings["tab_nav_responsive"]=='nav_one'){
			$responsive_class='nav-one-by-one';
		}else if($settings["tab_nav_responsive"]=='tab_accordion'){
			$responsive_class='mobile-accordion';
		}
		
		$output ='<div class="theplus-tabs-wrapper elementor-tabs '.esc_attr($animated_class).' '.esc_attr($responsive_class).' '.esc_attr($swiper_container).'" id="'.esc_attr($uid).'" data-tabs-id="'.esc_attr($uid).'"  data-connection="'.esc_attr($connect_carousel).'" '.$row_bg_conn.' '.$default_active.' '.$animation_attr.' role="tablist">';
			if($settings["tabs_type"]=='horizontal'){
				if($settings['tabs_align_horizontal']=='top'){
					$output .= $tab_nav.$tab_content;
				}
				if($settings['tabs_align_horizontal']=='bottom'){
					$output .= $tab_content.$tab_nav;
				}
			}
			if($settings["tabs_type"]=='vertical'){
				if($settings['tabs_align_vertical']=='left'){
					$output .= $tab_nav.$tab_content;
				}
				if($settings['tabs_align_vertical']=='right'){
					$output .= $tab_content.$tab_nav;
				}
			}
		$output .='</div>';
		echo $before_content.$output.$after_content;
	}

	protected function content_template() {
	
	}
}
