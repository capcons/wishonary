<?php 
/*
Widget Name: Process/Steps
Description: Process/Steps
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
use Elementor\Group_Control_Image_Size;


if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Process_Steps extends Widget_Base {
		
	public function get_name() {
		return 'tp-process-steps';
	}

    public function get_title() {
        return esc_html__('Process/Steps', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-ellipsis-h theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-creatives');
    }
	public function get_keywords() {
		return ['process', 'steps', 'sequence','process bar'];
	}
	
    protected function _register_controls() {
		/*process steps section start*/
		$this->start_controls_section(
			'section_process_steps',
			[
				'label' => esc_html__( 'Process/Steps', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'ps_style',
			[
				'label' => esc_html__( 'Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1'  => esc_html__( 'Vertical', 'theplus' ),					
					'style_2' => esc_html__( 'Horizontal', 'theplus' ),
				],
			]
		);
		$this->add_control(
			'pro_ste_display_counter',
			[
				'label' => esc_html__( 'Dispaly Counter', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'pro_ste_display_counter_style',
			[
				'label' => esc_html__( 'Counter Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'number-normal',
				'options' => [									
					'number-normal'  => esc_html__( 'Normal', 'theplus' ),
					'decimal-leading-zero'  => esc_html__( 'Decimal Leading Zero', 'theplus' ),
					'upper-alpha'  => esc_html__( 'Upper Alpha', 'theplus' ),
					'lower-alpha'  => esc_html__( 'Lower Alpha', 'theplus' ),
					'lower-roman'  => esc_html__( 'Lower Roman', 'theplus' ),
					'upper-roman'  => esc_html__( 'Upper Roman', 'theplus' ),
					'lower-greek'  => esc_html__( 'Lower Greek', 'theplus' ),
					'custom-text'  => esc_html__( 'Custom Text', 'theplus' ),
				],
				'condition'    => [
					'pro_ste_display_counter' => 'yes',					
				],
			]
		);
		$this->add_control(
			'pro_ste_display_special_bg',
			[
				'label' => esc_html__( 'Special Background', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'pro_ste_display_info_box',
			[
				'label' => esc_html__( 'Normal Layout In Mobile', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',
				'condition'    => [
					'ps_style' => 'style_2',					
				],				
			]
		);
		$this->add_responsive_control(
			'img_st2_align',
			[
				'label' => esc_html__( 'Circle Alignment', 'theplus' ),
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
				'default' => 'center',
				'condition'    => [
					'ps_style' => 'style_2',					
					'pro_ste_display_info_box' => 'yes',					
				],
			]
		);	
		$this->add_responsive_control(
			'content_st2_align',
			[
				'label' => esc_html__( 'Content Alignment', 'theplus' ),
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
				'default' => 'center',				
				'condition'    => [
					'ps_style' => 'style_2',					
					'pro_ste_display_info_box' => 'yes',					
				],
			]
		);		
		$this->add_control(
			'default_active',
			[
				'label' => esc_html__( 'Default Active', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => [					
					'0'  => esc_html__( '1', 'theplus' ),
					'1'  => esc_html__( '2', 'theplus' ),
					'2'  => esc_html__( '3', 'theplus' ),
					'3'  => esc_html__( '4', 'theplus' ),
					'4'  => esc_html__( '5', 'theplus' ),
					'5'  => esc_html__( '6', 'theplus' ),
					'6'  => esc_html__( '7', 'theplus' ),
					'7'  => esc_html__( '8', 'theplus' ),
					'8'  => esc_html__( '9', 'theplus' ),
					'9'  => esc_html__( '10', 'theplus' ),
					'50'  => esc_html__( 'None', 'theplus' ),
				],
			]
		);
		
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'loop_title',
			[
				'label' => esc_html__( 'Title', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'The Plus', 'theplus' ),
				'dynamic' => ['active'   => true,],
			]
		);
		$repeater->add_control(
			'loop_content_desc',
			[
				'label' => esc_html__( 'Description', 'theplus' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__('I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'theplus' ),
			]
		);		
		$repeater->add_control(
			'loop_image_icon',
			[
			'label' => esc_html__( 'Select Icon', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('You can select Icon, Custom Image or Text using this option.','theplus'),
				'default' => 'icon',
				'separator' => 'before',
				'options' => [
					''  => esc_html__( 'None', 'theplus' ),
					'icon' => esc_html__( 'Icon', 'theplus' ),
					'image' => esc_html__( 'Image', 'theplus' ),
					'text' => esc_html__( 'Text', 'theplus' ),
				],
			]
		);
		$repeater->add_control(
			'loop_select_image',
			[
				'label' => esc_html__( 'Use Image As icon', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'media_type' => 'image',
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'loop_image_icon' => 'image',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
				'condition' => [
					'loop_image_icon' => 'image',
				],
			]
		);
		$repeater->add_control(
			'loop_icon_style',
			[
				'label' => esc_html__( 'Icon Font', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome', 'theplus' ),
					'icon_mind' => esc_html__( 'Icons Mind', 'theplus' ),
				],
				'condition' => [
					'loop_image_icon' => 'icon',
				],
			]
		);
		$repeater->add_control(
			'loop_icon_fontawesome',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'loop_image_icon' => 'icon',
					'loop_icon_style' => 'font_awesome',
				],	
			]
		);
		$repeater->add_control(
			'loop_icons_mind',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '',
				'label_block' => true,
				'options' => theplus_icons_mind(),
				'condition' => [
					'loop_image_icon' => 'icon',
					'loop_icon_style' => 'icon_mind',
				],
			]
		);
		$repeater->add_control(
			'loop_select_text',
			[
				'label' => esc_html__( 'Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'The Plus', 'theplus' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'loop_image_icon' => 'text',
				],
			]
		);
		$repeater->add_control(
			'loop_url_link',
			[
				'label' => esc_html__( 'Link', 'theplus' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'theplus' ),
				'show_external' => true,
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
				'dynamic' => [
					'active'   => true,
				],
			]
		);
		$repeater->add_control(
			'sep_pre_ste_background_n_head',
			[
				'label' => 'Normal Background Option',
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',				
			]
		);
		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'sep_pre_ste_background',
				'types'     => [ 'classic', 'gradient' ],			
				'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .tp-ps-left-imt .tp-ps-icon-img',
			]
		);
		$repeater->add_control(
			'sep_pre_ste_background_h_head',
			[
				'label' => 'Hover Background Option',
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',				
			]
		);
		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'sep_pre_ste_background_h',
				'types'     => [ 'classic', 'gradient' ],			
				'selector'  => '{{WRAPPER}} .tp-process-steps-wrapper:hover{{CURRENT_ITEM}} .tp-ps-left-imt .tp-ps-icon-img,
				{{WRAPPER}} .tp-process-steps-wrapper.active{{CURRENT_ITEM}} .tp-ps-left-imt .tp-ps-icon-img',
			]
		);
		$repeater->add_control(
			'dis_counter_custom_text_head',
			[
				'label' => 'Display Counter Custom Text',
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',				
			]
		);
		$repeater->add_control(
			'dis_counter_custom_text',
			[
				'label' => esc_html__( 'Custom Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Step', 'theplus' ),
				'dynamic' => ['active'   => true,],				
			]
		);
		$this->add_control(
            'loop_content',
            [
				'label' => esc_html__( 'Process/Steps', 'theplus' ),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'loop_title' => 'The Plus 1',                       
                    ],
					[
                        'loop_title' => 'The Plus 2',
                    ],
					[
                        'loop_title' => 'The Plus 3',
                    ],					
                ],
                'separator' => 'before',
				'fields' => $repeater->get_controls(),
                'title_field' => '{{{ loop_title }}}',				
            ]
        );
		$this->add_control(
			'connection_switch',
			[
				'label' => esc_html__( 'Carousel Anything Connection', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'connection_unique_id',
			[
				'label' => esc_html__( 'Connection Carousel ID', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'condition' => [					
					'connection_switch' => 'yes',
				],				
			]
		);
		$this->add_control(
			'connection_hover_click',
			[
				'label' => esc_html__( 'Effect on', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'con_pro_hover',
				'options' => [
					'con_pro_hover'  => esc_html__( 'Hover', 'theplus' ),
					'con_pro_click' => esc_html__( 'Click', 'theplus' ),
				],
				'condition' => [					
					'connection_switch' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*process steps section start*/
		
		/* style section start*/
		/*title style start*/
		$this->start_controls_section(
            'section_title_styling',
            [
                'label' => esc_html__('Title Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );	
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-content .tp-pro-step-title',
			]
		);
		$this->add_control(
			'title_text_color_n',
			[
				'label' => esc_html__( 'Text Color Normal', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-content .tp-pro-step-title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_text_color_h',
			[
				'label' => esc_html__( 'Text Color Hover', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-content .tp-pro-step-title,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-content .tp-pro-step-title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		/*title style end*/
		
		/*description style start*/
		$this->start_controls_section(
            'section_description_styling',
            [
                'label' => esc_html__('Description Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );	
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-content .tp-pro-step-desc,{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-content .tp-pro-step-desc p,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-content .tp-pro-step-desc span',
			]
		);
		$this->add_control(
			'title_description_color_n',
			[
				'label' => esc_html__( 'Description Color Normal', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-content .tp-pro-step-desc,{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-content .tp-pro-step-desc p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_description_color_h',
			[
				'label' => esc_html__( 'Description Color Hover', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-content .tp-pro-step-desc,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-content .tp-pro-step-desc,{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-content .tp-pro-step-desc p,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-content .tp-pro-step-desc p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		/*description style end*/
		
		/*Icon/Image style start*/
		$this->start_controls_section(
            'section_icon_image_styling',
            [
                'label' => esc_html__('Icon/Image Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );
		
		$this->add_control(
			'tab_icon_heading',
			[
				'label' => esc_html__( 'Icon Options', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,				
			]
		);
		$this->add_responsive_control(
            'tab_icon_size',
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
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-ps-icon-img i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_tab_icon' );
		$this->start_controls_tab(
			'tab_tab_icon_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_icon_color_n',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_tab_icon_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_icon_color_h',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-icon-img i,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-icon-img i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		
		$this->add_control(
			'tab_image_heading',
			[
				'label' => esc_html__( 'Image Options', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
            'tab_image_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image Size', 'theplus'),
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
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img .tp-icon-img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
			'tab_image_border_radius_n',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img .tp-icon-img:first-child' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		
		$this->add_control(
			'tab_text_heading',
			[
				'label' => esc_html__( 'Text Options', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_text_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img .tp-ps-text',
			]
		);
		$this->start_controls_tabs( 'tabs_tab_text' );
		$this->start_controls_tab(
			'tab_tab_text_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_text_color_n',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img .tp-ps-text' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_tab_text_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'tab_text_color_h',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-icon-img .tp-ps-text,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-icon-img .tp-ps-text' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'tab_bg_heading',
			[
				'label' => esc_html__( 'Background Options', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
            'tab_bg_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Background Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 90,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tp-process-steps-widget .tp-ps-left-imt .tp-ps-special-bg:after' => 'width: calc({{SIZE}}{{UNIT}} + 20px);height:calc({{SIZE}}{{UNIT}} + 20px);',
					'{{WRAPPER}} .tp-process-steps-widget .tp-ps-left-imt .tp-ps-special-bg:before' => 'width: calc({{SIZE}}{{UNIT}} + 40px);height:calc({{SIZE}}{{UNIT}} + 40px);',
					'{{WRAPPER}} .tp-process-steps-widget.style_1 .tp-process-steps-wrapper .tp-ps-left-imt:after,
					{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-process-steps-wrapper .tp-ps-left-imt:after' => 'left:calc(({{SIZE}}{{UNIT}} /2 ) - ({{seprator_border_width_n.SIZE}}px));',
					'{{WRAPPER}} .tp-process-steps-widget.style_1 .tp-process-steps-wrapper .tp-ps-left-imt' => 'margin-right: calc(({{SIZE}}{{UNIT}}/1.3));',
					'{{WRAPPER}} .tp-process-steps-widget.style_1 .tp-process-steps-wrapper .tp-ps-right-content' => 'width: calc((100% - ({{SIZE}}{{UNIT}} * 2)));',
				],
            ]
        );
		$this->add_responsive_control(
            'pro_ste_minimum_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Minimum Height of Content', 'theplus'),
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
					'size' => 150,
				],
				'separator' => 'before',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper,
					{{WRAPPER}} .tp-process-steps-widget.style_1 .tp-process-steps-wrapper .tp-ps-left-imt:after' => 'min-height: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_tab_bg' );
		$this->start_controls_tab(
			'tab_tab_bg_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tab_bg_background_n',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tab_bg_border_n',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img',
			]
		);
		$this->add_responsive_control(
			'tab_bg_border_radius_n',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img:first-child,
					{{WRAPPER}} .tp-process-steps-widget .tp-ps-left-imt .tp-ps-special-bg:before,
					{{WRAPPER}} .tp-process-steps-widget .tp-ps-left-imt .tp-ps-special-bg:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tab_bg__shadow_n',
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img:first-child,
				{{WRAPPER}} .tp-process-steps-widget .tp-ps-left-imt .tp-ps-special-bg:before,
					{{WRAPPER}} .tp-process-steps-widget .tp-ps-left-imt .tp-ps-special-bg:after',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_tab_bg_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tab_bg_background_h',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-icon-img,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-icon-img',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tab_bg_border_h',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-icon-img,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-icon-img',
			]
		);
		$this->add_responsive_control(
			'tab_bg_border_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-icon-img:first-child,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-left-imt .tp-ps-special-bg:before,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-left-imt .tp-ps-special-bg:after,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-icon-img:first-child,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-left-imt .tp-ps-special-bg:before,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-left-imt .tp-ps-special-bg:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tab_bg__shadow_h',
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-icon-img:first-child,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-left-imt .tp-ps-special-bg:before,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-left-imt .tp-ps-special-bg:after,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-icon-img:first-child,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-left-imt .tp-ps-special-bg:before,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-left-imt .tp-ps-special-bg:after',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		
		$this->start_controls_tabs( 'tabs_transform' );
		$this->start_controls_tab(
			'tab_transform',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'transform_n',
			[
				'label' => esc_html__( 'Transform css', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img .tp-ps-text,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img .tp-icon-img,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-icon-img i' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;-webkit-transition: all .3s ease-in-out;
					-moz-transition: all .3s ease-in-out;-o-transition: all .3s ease-in-out;transition: all .3s ease-in-out;'
				],
			]
		);
		$this->add_control(
			'overlay_color_n',
			[
				'label' => esc_html__( 'Overlay Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-wrapper .tp-ps-left-imt .tp-ps-icon-img' => 'box-shadow: {{VALUE}} 0 0 0 100px inset;',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_transform_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'transform_h',
			[
				'label' => esc_html__( 'Transform css', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-icon-img .tp-ps-text,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-icon-img .tp-icon-img,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-icon-img i,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-icon-img .tp-ps-text,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-icon-img .tp-icon-img,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-icon-img i' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;'
				],
			]
		);
		$this->add_control(
			'overlay_color_h',
			[
				'label' => esc_html__( 'Overlay Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-wrapper:hover .tp-ps-left-imt .tp-ps-icon-img,
					{{WRAPPER}} .tp-process-steps-wrapper.active .tp-ps-left-imt .tp-ps-icon-img' => 'box-shadow: {{VALUE}} 0 0 0 100px inset;',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		

		$this->end_controls_section();
		/*Icon/Image style end*/
		
		/*Separator/Line style start*/
		$this->start_controls_section(
            'section_seprator_styling',
            [
                'label' => esc_html__('Separator/Line Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );			
		$this->start_controls_tabs( 'tabs_seprator' );
		$this->start_controls_tab(
			'tab_seprator_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'seprator_color_n',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget.style_1 .tp-process-steps-wrapper .tp-ps-left-imt:after,
{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-ps-left-imt:before,
{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-process-steps-wrapper .tp-ps-left-imt:after' => 'border-color:{{VALUE}};',
				],
			]
		);
	
		$this->add_control(
			'seprator_border_style_n',
			[
				'label' => esc_html__( 'Border Type', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
                    'solid' => esc_html__('Solid', 'theplus'),
                    'dashed' => esc_html__('Dashed', 'theplus'),
                    'dotted' => esc_html__('Dotted', 'theplus'),
                    'groove' => esc_html__('Groove', 'theplus'),
                    'inset' => esc_html__('Inset', 'theplus'),
                    'outset' => esc_html__('Outset', 'theplus'),
                    'ridge' => esc_html__('Ridge', 'theplus'),
                    'border_img_custom' => esc_html__('Custom', 'theplus'),
                ],
				'selectors'  => [
					'{{WRAPPER}} .tp-process-steps-widget.style_1 .tp-process-steps-wrapper .tp-ps-left-imt:after,
{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-ps-left-imt:before,
{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-process-steps-wrapper .tp-ps-left-imt:after' => 'border-style: {{VALUE}};',
				],				
			]
		);
		$this->add_responsive_control(
            'seprator_border_width_n',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Border Size', 'theplus'),
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-process-steps-wrapper .tp-ps-left-imt:before,
					{{WRAPPER}} .tp-process-steps-widget.style_1 .tp-process-steps-wrapper .tp-ps-left-imt:after' => 'border-width: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [					
					'seprator_border_style_n!' => 'border_img_custom',
				],
            ]
        );
		$this->add_control(
			'seprator_cusom_img',
			[
				'label' => esc_html__( 'Separator/Line Image', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'media_type' => 'image',
				'default' => [
					'url' => '',
				],
				'condition' => [
					'seprator_border_style_n' => 'border_img_custom',					
				],
			]
		);
		$this->add_responsive_control(
            'seprator_main_top_offset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Separator/Line Offset', 'theplus'),
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget.style_1.tp_ps_sep_img .tp-sep-custom-img-inner,
					{{WRAPPER}} .tp-process-steps-widget.style_2.tp_ps_sep_img .tp-sep-custom-img-inner' => 'left: {{SIZE}}{{UNIT}} !important;position:relative;',
				],
				'condition' => [					
					'seprator_border_style_n' => 'border_img_custom',
				],
            ]
        );
		$this->add_responsive_control(
            'seprator_main_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Separator/Line Size', 'theplus'),
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [					
					'{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-process-steps-wrapper .tp-ps-left-imt:before' => 'width: {{SIZE}}{{UNIT}} !important;
	right: calc((-{{SIZE}}{{UNIT}} / 2) - 10px)!important;',
					'{{WRAPPER}} .tp-process-steps-widget.style_1.tp_ps_sep_img .tp-sep-custom-img-inner' => 'max-height: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'ps_style!' => 'style_1',					
					'seprator_border_style_n!' => 'border_img_custom',					
				],
            ]
        );
		$this->add_responsive_control(
            'seprator_img_height_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image Maximum Size', 'theplus'),
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [					
					'{{WRAPPER}} .tp-process-steps-widget.style_1.tp_ps_sep_img .tp-sep-custom-img-inner' => 'max-height: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .tp-process-steps-widget.style_2.tp_ps_sep_img .tp-sep-custom-img-inner' => 'width: {{SIZE}}{{UNIT}} !important;height:auto !important;max-width: {{SIZE}}{{UNIT}} !important;'
				],
				'condition' => [
					'seprator_border_style_n' => 'border_img_custom',					
				],
            ]
        );
		
		$this->add_responsive_control(
			'seprator_cusom_img_button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-process-steps-widget.tp_ps_sep_img .tp-process-steps-wrapper .separator_custom_img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
				'condition' => [
					'seprator_border_style_n' => 'border_img_custom',					
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_seprator_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'seprator_color_h',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget.style_1 .tp-process-steps-wrapper:hover .tp-ps-left-imt:after,
{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-process-steps-wrapper:hover .tp-ps-left-imt:before,
{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-process-steps-wrapper:hover .tp-ps-left-imt:after,
{{WRAPPER}} .tp-process-steps-widget.style_1 .tp-process-steps-wrapper.active .tp-ps-left-imt:after,
{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-process-steps-wrapper.active .tp-ps-left-imt:before,
{{WRAPPER}} .tp-process-steps-widget.style_2 .tp-process-steps-wrapper.active .tp-ps-left-imt:after' => 'border-color:{{VALUE}};',
				],
			]
		);		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Separator/Line style end*/
		
		/*display counter start*/
		$this->start_controls_section(
            'section_display_counter_styling',
            [
                'label' => esc_html__('Display Counter Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pro_ste_display_counter' => 'yes',					
				],
            ]
        );
		$this->add_responsive_control(
			'display_counter_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-wrapper .tp-ps-dc.dc_custom_text .ds_custom_text_label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'pro_ste_display_counter_style' => 'custom-text',					
				],
				'separator' => 'after',
			]
		);		

		$this->add_responsive_control(
            'display_counter_left_offset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Left Offset', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
						'step' => 1,
					],
				],				
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-ps-left-imt .tp-ps-dc' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
            'display_counter_top_offset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Top Offset', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
						'step' => 1,
					],
				],				
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-ps-left-imt .tp-ps-dc' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'display_counter_typography',
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper .tp-ps-dc.dc_custom_text .ds_custom_text_label',
				'separator' => 'before',
			]
		);		
		$this->start_controls_tabs( 'tabs_display_counter' );
		$this->start_controls_tab(
			'tab_display_counter_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'display_counter_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper .tp-ps-dc.dc_custom_text .ds_custom_text_label' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'display_counter_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper .tp-ps-dc.dc_custom_text .ds_custom_text_label',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'display_counter_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper .tp-ps-dc.dc_custom_text .ds_custom_text_label',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'display_counter_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-left-imt .tp-ps-dc:after,
					{{WRAPPER}} .tp-process-steps-wrapper .tp-ps-dc.dc_custom_text .ds_custom_text_label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'display_counter_shadow',
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper .tp-ps-dc.dc_custom_text .ds_custom_text_label',				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_display_counter_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'display_counter_color_h',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper:hover .tp-ps-dc.dc_custom_text .ds_custom_text_label,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper.active .tp-ps-dc.dc_custom_text .ds_custom_text_label' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'display_counter_background_h',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper:hover .tp-ps-dc.dc_custom_text .ds_custom_text_label,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper.active .tp-ps-dc.dc_custom_text .ds_custom_text_label',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'display_counter_border_h',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper:hover .tp-ps-dc.dc_custom_text .ds_custom_text_label,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper.active .tp-ps-dc.dc_custom_text .ds_custom_text_label',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'display_counter_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-left-imt .tp-ps-dc:after,
					{{WRAPPER}} .tp-process-steps-wrapper:hover .tp-ps-dc.dc_custom_text .ds_custom_text_label,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-left-imt .tp-ps-dc:after,
					{{WRAPPER}} .tp-process-steps-wrapper.active .tp-ps-dc.dc_custom_text .ds_custom_text_label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'display_counter_shadow_h',
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper:hover .tp-ps-dc.dc_custom_text .ds_custom_text_label,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-left-imt .tp-ps-dc:after,
				{{WRAPPER}} .tp-process-steps-wrapper.active .tp-ps-dc.dc_custom_text .ds_custom_text_label',				
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*display counter end*/
		
		/*Content Background Style start*/
		$this->start_controls_section(
            'section_content_bg_styling',
            [
                'label' => esc_html__('Content Background Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );
		$this->add_responsive_control(
			'content_bg_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-right-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'content_bg_margin_st2',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget.style_2  .tp-process-steps-wrapper .tp-ps-right-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
				'condition' => [
					'ps_style' => 'style_2',					
				],
			]
		);
		$this->add_responsive_control(
            'content_bg_margin_right',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Left Content Right Margin', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-process-steps-widget.style_1 .tp-process-steps-wrapper .tp-ps-left-imt' => 'margin-right: {{SIZE}}{{UNIT}} !important',
				],
				'condition' => [
					'ps_style' => 'style_1',					
				],
            ]
        );		
		$this->start_controls_tabs( 'tabs_content_bg' );
		$this->start_controls_tab(
			'tab_content_bg_n',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'content_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-right-content',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_bg_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-right-content',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'content_bg_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-right-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'content_bg_shadow',
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper .tp-ps-right-content',				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_content_bg_h',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'content_background_h',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-right-content,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-right-content',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_bg_border_h',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-right-content,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-right-content',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'content_bg_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-right-content,
					{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-right-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'content_bg_shadow_h',
				'selector' => '{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper:hover .tp-ps-right-content,
				{{WRAPPER}} .tp-process-steps-widget .tp-process-steps-wrapper.active .tp-ps-right-content',				
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Content Background Style end*/
		/* style section end*/
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
			
		$pro_ste_display_counter_style = $settings['pro_ste_display_counter_style'];		$uid=uniqid('proste');
		
		$display_counter_class=$display_special_bg=$responsive_class=$seprator_cusom_img_class='';
		
		if($pro_ste_display_counter_style == 'number-normal'){
			$display_counter_class = 'number_normal';
		}else if($pro_ste_display_counter_style == 'decimal-leading-zero'){
			$display_counter_class = 'decimal_leading_zero';
		}else if($pro_ste_display_counter_style == 'upper-alpha'){
			$display_counter_class = 'upper_alpha';
		}else if($pro_ste_display_counter_style == 'lower-alpha'){
			$display_counter_class = 'lower_alpha';
		}else if($pro_ste_display_counter_style == 'lower-roman'){
			$display_counter_class = 'lower_roman';
		}else if($pro_ste_display_counter_style == 'upper-roman'){
			$display_counter_class = 'upper_roman';
		}else if($pro_ste_display_counter_style == 'lower-greek'){
			$display_counter_class = 'lower_greek';
		}else if($pro_ste_display_counter_style == 'custom-text'){
			$display_counter_class = 'dc_custom_text';
		}
		
		if(!empty($settings['seprator_border_style_n']) && $settings['seprator_border_style_n'] == 'border_img_custom'){
			$seprator_cusom_img_class = 'tp_ps_sep_img';
		}
		
		if(!empty($settings['pro_ste_display_special_bg']) && $settings['pro_ste_display_special_bg'] == 'yes'){
			$display_special_bg = 'tp-ps-special-bg';
		}
		$mobile_class='';
		if(!empty($settings['pro_ste_display_info_box']) && $settings['pro_ste_display_info_box']=='yes'){
			$mobile_class = 'mobile';
		}
		
		$connect_carousel =$connection_hover_click='';
		if(!empty($settings["connection_unique_id"])){
			$connect_carousel='tpca_'.$settings["connection_unique_id"];
			$uid="tptab_".$settings["connection_unique_id"];
			$connection_hover_click=$settings["connection_hover_click"];
		}
			
			 if(!empty($settings["loop_content"])) {
				$output = '<div id="'.$uid.'" class="tp-process-steps-widget '.$settings['ps_style'].' '.$seprator_cusom_img_class.' '.$mobile_class.' '.$settings['img_st2_align'].' '.$settings['content_st2_align'].' '.$animated_class.'" '.$animation_attr.' data-connection="'.esc_attr($connect_carousel).'" data-eventtype="'.esc_attr($connection_hover_click).'">';	
					$loop_content=$settings["loop_content"];
					$index=0;					
					foreach($loop_content as $index => $item) {
						$ps_count = $index;
						$on_load_class='';
						$default_active=$settings['default_active'];
						if($ps_count==$default_active){
							$on_load_class = 'active';		
						}
						$list_title=$description=$title_a_start=$title_a_end=$list_img='';
						
						/*link*/
						if ( ! empty( $item['loop_url_link']['url'] ) ) {
							$this->add_render_attribute( 'loop_box_link'.$index, 'href', $item['loop_url_link']['url'] );
							if ( $item['loop_url_link']['is_external'] ) {
								$this->add_render_attribute( 'box_link'.$index, 'target', '_blank' );
							}
							if ( $item['loop_url_link']['nofollow'] ) {
								$this->add_render_attribute( 'box_link'.$index, 'rel', 'nofollow' );
							}
						}
						/*link*/
						
						/*tile*/
						if(!empty($item['loop_title'])){							
							if (!empty($item['loop_url_link']['url'])){
								$title_a_start = '<a '.$this->get_render_attribute_string( "loop_box_link".$index ).'>';
								$title_a_end = '</a>';
							}							
							$list_title = $title_a_start.'<h6 class="tp-pro-step-title">'.$item['loop_title'].'</h6>'.$title_a_end;							
						}
						/*tile*/
						
						/*description*/					
						if(!empty($item['loop_content_desc'])){
							 $description='<div class="tp-pro-step-desc"> '.$item['loop_content_desc'].' </div>';
						}	
						/*description*/
						
						/*icon-image-text*/
						if(!empty($item['loop_image_icon'])){
							/*image*/
							if(isset($item['loop_image_icon']) && $item['loop_image_icon'] == 'image'){
								$image_alt='';
									
									if(!empty($item["loop_select_image"]["url"])){
										$loop_select_image=$item['loop_select_image']['id'];
										$img = wp_get_attachment_image_src($loop_select_image,$item['thumbnail_size']);
										$loop_imgSrc = $img[0];
										//$loop_imgSrc= $item["loop_select_image"]["url"];
										$image_id=$item["loop_select_image"]["id"];
										$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
										if(!$image_alt){
											$image_alt = get_the_title($image_id);
										}else if(!$image_alt){
											$image_alt = 'Image Icon';
										}
									}else{
										$loop_imgSrc='';
									}
									
									$list_img ='<div class="tp-ps-icon-img tp-pro-step-icon-img" >';
										$list_img .='<img class="tp-icon-img" src='.esc_url($loop_imgSrc).' alt="'.esc_attr($image_alt).'" />';
									$list_img .='</div>';
							}
							/*image*/							
							/*icon*/
							else if(isset($item['loop_image_icon']) && $item['loop_image_icon'] == 'icon'){		
								if(!empty($item["loop_icon_style"]) && $item["loop_icon_style"]=='icon_mind'){
									$list_img='<i class=" '.$item["loop_icons_mind"].' tp-icon-fi" ></i>';
								}else{
									$list_img='';
								}
							}
							/*icon*/
							/*text*/
							else if(isset($item['loop_image_icon']) && $item['loop_image_icon'] == 'text'){
								$list_img='<span class="tp-ps-text">'.$item['loop_select_text'].'</span>';
							}
							/*test*/
							
						}
						/*icon-image-text*/
						if(!empty($item["loop_icon_style"]) && $item["loop_icon_style"]=='font_awesome'){
							ob_start();
							\Elementor\Icons_Manager::render_icon( $item['loop_icon_fontawesome'], [ 'aria-hidden' => 'true' ]);
							$list_img = ob_get_contents();
							ob_end_clean();						
						}
						
						$display_counter='';
						if(!empty($settings['pro_ste_display_counter']) && $settings['pro_ste_display_counter']=='yes'){
							$display_counter = '<div class="tp-ps-dc '.$display_counter_class.'">';
								if($settings['pro_ste_display_counter']=='yes' && $settings['pro_ste_display_counter_style']=='custom-text'){
									$display_counter .= '<span class="ds_custom_text_label">'.$item['dis_counter_custom_text'].'</span>';
								}
							$display_counter .= '</div>';
						}
						
						$dis_sep_custom_img='';
						if(!empty($settings['seprator_border_style_n']) && $settings['seprator_border_style_n'] == 'border_img_custom'){							
							$dis_sep_custom_img='<span class="separator_custom_img"><img class="tp-sep-custom-img-inner" src="'.$settings['seprator_cusom_img']['url'].'" /></span>';
						}						
					
						$output .= '<div class="tp-process-steps-wrapper elementor-repeater-item-' . $item['_id'] . ' elementor-ps-content-'.$ps_count.' '.$on_load_class.'" data-index="'.$ps_count.'">';
							if(!empty($settings['ps_style'])){
								if($settings['ps_style']=='style_1' || $settings['ps_style']=='style_2'){									
									$output .= '<div class="tp-ps-left-imt '.$display_special_bg.'">';														
													if(!empty($list_img)){
														$output .= ''.$dis_sep_custom_img.'<span class="tp-ps-icon-img '.$display_special_bg.'">'.$list_img.'</span>'.$display_counter.' ';
													}
									$output .= '</div>';									
									$output .= '<div class="tp-ps-right-content">';
										$output .= '<span class="tp-ps-content">'.$list_title.' '.$description.'</span>';
									$output .= '</div>';
								}
							}
						$output .= '</div>';
						$index++;
					}
					
				$output .= '</div>';				
				echo $before_content.$output.$after_content;
			}
	}
}