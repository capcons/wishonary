<?php 
/*
Widget Name: Icon Stylist List
Description: Text of icon list stylist.
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
use Elementor\Group_Control_Css_Filter;

use TheplusAddons\Theplus_Element_Load;
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Style_List extends Widget_Base {
		
	public function get_name() {
		return 'tp-style-list';
	}

    public function get_title() {
        return esc_html__('Style Lists', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-list theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
			'label' => esc_html__( 'Stylist List', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'hover_background_style',
			[
				'label' => esc_html__( 'Interactive Links', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'separator' => 'before',
				'default' => 'no',
			]
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'content_description',
			[
				'label' => esc_html__( 'Description', 'theplus' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'theplus' ),
				'placeholder' => esc_html__( 'Type your description here', 'theplus' ),
				'dynamic' => ['active'   => true,],
			]
		);
		$repeater->add_control(
			'icon_style',
			[
				'label' => esc_html__( 'Icon Font', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					''  => esc_html__( 'None', 'theplus' ),
					'font_awesome'  => esc_html__( 'Font Awesome', 'theplus' ),
					'icon_mind' => esc_html__( 'Icons Mind', 'theplus' ),
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
					'icon_style' => 'icon_mind',
				],
			]
		);
		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'theplus' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => esc_html__( 'https://your-link.com', 'theplus' ),
				'separator' => 'after',
				'dynamic' => ['active'   => true,],
			]
		);
		$repeater->add_control(
			'show_pin_hint',
			[
				'label' => esc_html__( 'Pin Hint', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'separator' => 'before',
				'default' => 'no',
			]
		);
		$repeater->add_control(
			'hint_text',
			[
				'label' => esc_html__( 'Hint Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Featured', 'theplus' ),
				'placeholder' => esc_html__( 'Ex. Unique,Top,Featured...', 'theplus' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'show_pin_hint' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'hint_text_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper {{CURRENT_ITEM}} .plus-icon-list-text span.plus-hint-text' => 'color: {{VALUE}}'
				],
				'condition' => [
					'show_pin_hint' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'hint_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper {{CURRENT_ITEM}} .plus-icon-list-text span.plus-hint-text' => 'background: {{VALUE}}'
				],
				'dynamic' => ['active'   => true,],
				'condition' => [
					'show_pin_hint' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'show_background_style',
			[
				'label' => esc_html__( 'Background Style', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'separator' => 'before',
				'default' => 'no',
			]
		);
		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'background_hover',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-bg-hover-effect {{CURRENT_ITEM}}',
				'condition' => [
					'show_background_style' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'show_tooltips',
			[
				'label'        => esc_html__( 'Tooltip', 'theplus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'theplus' ),
				'label_off'    => esc_html__( 'No', 'theplus' ),
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'content_type',
			[
				'label' => esc_html__( 'Content Type', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal_desc',
				'options' => [
					'normal_desc'  => esc_html__( 'Content Text', 'theplus' ),
					'content_wysiwyg'  => esc_html__( 'Content WYSIWYG', 'theplus' ),
					'template' => esc_html__( 'Template', 'theplus' ),
				],
				'condition' => [
					'show_tooltips' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'tooltip_content_desc',
			[
				'label' => esc_html__( 'Description', 'theplus' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 5,
				'default' => esc_html__( 'Luctus nec ullamcorper mattis', 'theplus' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'content_type' => 'normal_desc',
					'show_tooltips' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'tooltip_content_wysiwyg',
			[
				'label' => esc_html__( 'Tooltip Content', 'theplus' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'theplus' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'content_type' => 'content_wysiwyg',
					'show_tooltips' => 'yes',
				],
			]				
		);
		$repeater->add_control(
			'tooltip_content_align',
			[
				'label'   => esc_html__( 'Text Alignment', 'theplus' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .tippy-tooltip .tippy-content' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'content_type' => 'normal_desc',
					'show_tooltips' => 'yes',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tooltip_content_typography',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .tippy-tooltip .tippy-content',
				'condition' => [
					'content_type' => ['normal_desc','content_wysiwyg'],
					'show_tooltips' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'tooltip_content_color',
			[
				'label'  => esc_html__( 'Text Color', 'theplus' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .tippy-tooltip .tippy-content,{{WRAPPER}} {{CURRENT_ITEM}} .tippy-tooltip .tippy-content p' => 'color: {{VALUE}}',
				],
				'condition' => [
					'content_type' => ['normal_desc','content_wysiwyg'],
					'show_tooltips' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'tooltip_content_template',
			[
				'label'       => esc_html__( 'Elementor Templates', 'theplus' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => theplus_get_templates(),
				'label_block' => 'true',
				'condition' => [
					'content_type' => 'template',
					'show_tooltips' => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_list',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'content_description' => esc_html__( 'List Item 1', 'theplus' ),
						'icon_fontawesome' => 'fa fa-check',
					],
					[
						'content_description' => esc_html__( 'List Item 2', 'theplus' ),
						'icon_fontawesome' => 'fa fa-times',
					],
					[
						'content_description' => esc_html__( 'List Item 3', 'theplus' ),
						'icon_fontawesome' => 'fa fa-dot-circle-o',
					],
				],
				'title_field' => '{{{ content_description }}}',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_read_more_toggle',
			[
				'label' => esc_html__( 'Read More Toggle', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'read_more_toggle',
			[
				'label'        => esc_html__( 'Read More Toggle', 'theplus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'theplus' ),
				'label_off'    => esc_html__( 'No', 'theplus' ),
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'load_show_list_toggle',
			[
				'label' => esc_html__( 'List Open Default', 'theplus' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 3,
				'condition' => [
					'read_more_toggle' => 'yes',
				],
			]
		);
		$this->add_control(
			'read_show_option',
			[
				'label' => esc_html__( 'Expand Section Title', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '+ Show all options', 'theplus' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
				'condition' => [
					'read_more_toggle' => 'yes',
				],
			]
		);
		$this->add_control(
			'read_less_option',
			[
				'label' => esc_html__( 'Shrink Section Title', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '- Less options', 'theplus' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'read_more_toggle' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_icon_list',
			[
				'label' => esc_html__( 'List', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label' => esc_html__( 'Space Between', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .plus-icon-list-items .plus-icon-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .plus-icon-list-items .plus-icon-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',					
				],
			]
		);
		$this->add_responsive_control(
			'icon_align',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
			]
		);
		$this->add_control(
			'icon_border_bottom_color',
			[
				'label' => esc_html__( 'Separate Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-icon-list-items .plus-icon-list-item:not(:last-child)' => 'border-bottom: 1px solid {{VALUE}};width: 100%;',
				],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .plus-icon-list-icon i' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( 'Icon Hover', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .plus-icon-list-item:hover .plus-icon-list-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .plus-icon-list-icon' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .plus-icon-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_indent',
			[
				'label' => esc_html__( 'Icon Indent', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .plus-icon-list-icon' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'vertical_center',
			[
				'label' => esc_html__( 'Vertical Center', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theplus' ),
				'label_off' => esc_html__( 'No', 'theplus' ),				
				'default' => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'adv_icon_style',
			[
				'label' => esc_html__( 'Advanced Style', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theplus' ),
				'label_off' => esc_html__( 'No', 'theplus' ),				
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'icon_inner_width',
			[
				'label' => esc_html__( 'Icon Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 45,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};text-align:center;align-items: center;justify-content: center;',
				],
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'label' => esc_html__( 'Icon Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-icon',
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);
		$this->start_controls_tabs('icon_adv_style_tabs');
		$this->start_controls_tab(
			'icon_adv_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_adv_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_adv_bg',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-icon',
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_adv_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-icon',
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'icon_adv_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);		
		$this->add_control(
			'icon_border_hover',
			[
				'label' => esc_html__( 'Border Hover', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-item:hover .plus-icon-list-icon' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_adv_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-item:hover .plus-icon-list-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_adv_hover_bg',
				'label' => esc_html__( 'Background Hover', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-item:hover .plus-icon-list-icon',
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_adv_hover_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-item:hover .plus-icon-list-icon',
				'condition' => [
					'adv_icon_style' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
		
		$this->start_controls_section(
            		'section_styling',
	            	[
	                	'label' => esc_html__('Content Options', 'theplus'),
	                	'tab' => Controls_Manager::TAB_STYLE,
	            	]
	        );		
		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .plus-icon-list-text' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
			]
		);
		$this->add_control(
			'text_color_hover',
			[
				'label' => esc_html__( 'Text Hover', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .plus-icon-list-item:hover .plus-icon-list-text' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'text_indent',
			[
				'label' => esc_html__( 'Text Indent', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .plus-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .plus-icon-list-item,{{WRAPPER}} .plus-icon-list-item p',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_toggle_expand_styling',
            [
                'label' => esc_html__('Read More Toggle', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'read_more_toggle' => 'yes',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'toggle_expand_typography',
				'label' => esc_html__( 'Expand/Toggle Text Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .plus-stylist-list-wrapper a.read-more-options',
			]
		);
		$this->add_control(
			'toggle_expand_text_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper a.read-more-options' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'top_toggle_indent',
			[
				'label' => esc_html__( 'Top Indent', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -10,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper a.read-more-options' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_hint_text_styling',
            [
                'label' => esc_html__('Hint Text Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'hint_align',
			[
				'label' => esc_html__( 'Hint Text Alignment', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'label_block' => false,
				'default' => 'right',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'hint_typography',
				'selector' => '{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-text span.plus-hint-text',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'hint_box_shadow',
				'selector' => '{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-text span.plus-hint-text',
			]
		);
		$this->add_responsive_control(
			'hint_padding',
			[
				'label' => esc_html__( 'Hint Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-text span.plus-hint-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
            'hint_left_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Horizontal Adjust', 'theplus'),
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min'	=> -200,
						'max'	=> 200,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-text span.plus-hint-text' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_responsive_control(
            'hint_left_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Min Width Adjust', 'theplus'),
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'hint_align' => 'left',
				],
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-text span.plus-hint-text.left' => 'min-width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_responsive_control(
            'hint_right_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Min Width Adjust', 'theplus'),				
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 400,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'hint_align' => 'right',
				],
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-text span.plus-hint-text.right' => 'min-width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_responsive_control(
            'hint_top_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Vertical Adjust', 'theplus'),
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'	=> -150,
						'max'	=> 150,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper .plus-icon-list-text span.plus-hint-text' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->end_controls_section();
		/*Tooltip Option*/
		$this->start_controls_section(
            'section_tooltip_styling',
            [
                'label' => esc_html__('Tooltip Options', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			\Theplus_Tooltips_Option_Group::get_type(),
			array(
				'label' => esc_html__( 'Tooltip Options', 'theplus' ),
				'name'           => 'tooltip_common_option',
			)
		);
		$this->add_group_control(
			\Theplus_Tooltips_Option_Style_Group::get_type(),
			array(
				'label' => esc_html__( 'Style Options', 'theplus' ),
				'name'           => 'tooltip_common_style',
			)
		);
		$this->end_controls_section();
		/*Tooltip Option*/
		/*Extra Option*/
		$this->start_controls_section(
            'section_extra_option_styling',
            [
                'label' => esc_html__('Extra Options', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'hover_inverse_effect',
			[
				'label' => esc_html__( 'On Hover Inverse Effect', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'theplus' ),
				'label_off' => esc_html__( 'Off', 'theplus' ),				
				'default' => 'no',
			]
		);
		$this->add_control(
			'unhover_item_opacity',
			[
				'label' => esc_html__( 'NotSelected Item Opacity', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.6,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-stylist-list-wrapper.hover-inverse-effect:hover .on-hover .plus-icon-list-item' => 'opacity: {{SIZE}};',
				],
				'condition'    => [
					'hover_inverse_effect' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'label' => esc_html__( 'NotSelected Item CSS Filter', 'theplus' ),
				'name' => 'unhover_item_css_filters',
				'selector' => '{{WRAPPER}} .plus-stylist-list-wrapper.hover-inverse-effect:hover .on-hover .plus-icon-list-item',
				'condition'    => [
					'hover_inverse_effect' => 'yes',
				],
			]
		);
		$this->add_control(
			'hover_effect_area',
			[
				'label' => esc_html__( 'Effect Area', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'individual',
				'options' => [
					'individual'  => esc_html__( 'Individual', 'theplus' ),
					'global' => esc_html__( 'Global', 'theplus' ),
				],
				'condition'    => [
					'hover_inverse_effect' => 'yes',
				],
			]
		);
		$this->add_control(
			'global_hover_item_id',
			[
				'label' => esc_html__( 'Global List Connection Id', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => esc_html__( 'Note : Use unique id here and put same in all connected lists.', 'theplus' ),
				'condition'    => [
					'hover_inverse_effect' => 'yes',
					'hover_effect_area' => 'global',
				],
			]
		);
		$this->end_controls_section();
		/*Extra Option*/
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
			'animated_column_list',
			[
				'label'   => esc_html__( 'List Load Animation', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => esc_html__( 'Content Animation Block', 'theplus' ),
					'stagger' => esc_html__( 'Stagger Based Animation', 'theplus' ),
				],
				'condition'    => [
					'animation_effects!' => [ 'no-animation' ],
				],
			]
		);
		$this->add_control(
            'animation_stagger',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Animation Stagger', 'theplus'),
				'default' => [
					'unit' => '',
					'size' => 150,
				],
				'range' => [
					'' => [
						'min'	=> 0,
						'max'	=> 6000,
						'step' => 10,
					],
				],
				'condition' => [
					'animation_effects!' => [ 'no-animation' ],
					'animated_column_list' => 'stagger',
				],
            ]
        );
		$this->add_control(
            'animation_duration_default',
            [
				'label'   => esc_html__( 'Animation Duration', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition'    => [
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
	
		$vertical_center =($settings["vertical_center"]=='yes') ? 'd-flex-center' : 'd-flex-top';
		
		$hover_inverse_effect=$hover_inverse_attr_id =$hover_inverse_id='';
		if($settings["hover_inverse_effect"]=='yes'){
			$hover_inverse_effect = ($settings["hover_effect_area"]=='global') ? 'hover-inverse-effect-global' : 'hover-inverse-effect';
			$hover_inverse_attr_id = ($settings["hover_effect_area"]=='global' && $settings["global_hover_item_id"]!='') ? 'data-hover-inverse="hover-'.$settings["global_hover_item_id"].'"' : '';
			$hover_inverse_id = ($settings["hover_effect_area"]=='global' && $settings["global_hover_item_id"]!='') ? 'hover-'.$settings["global_hover_item_id"] : '';
		}
		
		$animation_effects=$settings["animation_effects"];
		$animation_delay= (!empty($settings["animation_delay"]["size"])) ? $settings["animation_delay"]["size"] : 50;
		$animation_stagger=(!empty($settings["animation_stagger"]["size"])) ? $settings["animation_stagger"]["size"] : 150;
		$animated_columns='';		
		if($animation_effects=='no-animation'){
			$animated_class='';
			$animation_attr='';
		}else{
			$animate_offset = theplus_scroll_animation();
			$animated_class = 'animate-general';
			$animation_attr = ' data-animate-type="'.esc_attr($animation_effects).'" data-animate-delay="'.esc_attr($animation_delay).'"';
			$animation_attr .= ' data-animate-offset="'.esc_attr($animate_offset).'"';
			if($settings["animated_column_list"]=='stagger'){
				$animated_columns='animated-columns';
				$animation_attr .=' data-animate-columns="stagger"';
				$animation_attr .=' data-animate-stagger="'.esc_attr($animation_stagger).'"';
			}
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
		?>
		
		<?php echo $before_content; ?>
		
		<?php if($settings["hover_background_style"]=='yes'){ ?>
				<div class="plus-bg-hover-effect">
				<?php
					$j=0;
					foreach ( $settings['icon_list'] as $index => $item ) :
						if($j==0){
						$active_class='active';
						}else{
						$active_class='';
						}
						echo '<div class="hover-item-content elementor-repeater-item-'.esc_attr($item['_id']).' '.esc_attr($active_class).'"></div>';
						$j++;
					endforeach;
				?>
				</div>
			<?php } ?>
		<div class="plus-stylist-list-wrapper <?php echo esc_attr($animated_class); ?> <?php echo esc_attr($hover_inverse_effect); ?> <?php echo esc_attr($hover_inverse_id); ?>" <?php echo $animation_attr; ?> <?php echo $hover_inverse_attr_id; ?>>
			
		<ul class="plus-icon-list-items <?php echo esc_attr($vertical_center); ?>">
			<?php
			$ij=0;
			$i=0;
			foreach ( $settings['icon_list'] as $index => $item ) :
				$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'icon_list', $index );

				$this->add_inline_editing_attributes( $repeater_setting_key );
				$tooltip_class='';
				if($item["show_tooltips"]=='yes'){
					$tooltip_class='plus-tooltip';
				}
				$uniqid=uniqid("tooltip");
				if($i==0){
					$active_class='active';
				}else{
					$active_class='';
				}
				$_tooltip='_tooltip_'.$i;
				if( $item['show_tooltips'] == 'yes' ) {
					
					$this->add_render_attribute( $_tooltip, 'data-tippy', '', true );

					if (!empty($item['content_type']) && $item['content_type']=='normal_desc') {
						$this->add_render_attribute( $_tooltip, 'title', $item['tooltip_content_desc'], true );
					}else if (!empty($item['content_type']) && $item['content_type']=='content_wysiwyg') {
						$tooltip_content=$item['tooltip_content_wysiwyg'];
						$this->add_render_attribute( $_tooltip, 'title', $tooltip_content, true );
					}else if($item["content_type"]=='template' && !empty($item['tooltip_content_template'])){
						$tooltip_content=Theplus_Element_Load::elementor()->frontend->get_builder_content_for_display( $item['tooltip_content_template'] );
						$this->add_render_attribute( $_tooltip, 'title', $tooltip_content, true );
					}
					
					$plus_tooltip_position=($settings["tooltip_common_option_plus_tooltip_position"]!='') ? $settings["tooltip_common_option_plus_tooltip_position"] : 'top';
					$this->add_render_attribute( $_tooltip, 'data-tippy-placement', $plus_tooltip_position, true );
					
					$tooltip_interactive =($settings["tooltip_common_option_plus_tooltip_interactive"]=='' || $settings["tooltip_common_option_plus_tooltip_interactive"]=='yes') ? 'true' : 'false';
					$this->add_render_attribute( $_tooltip, 'data-tippy-interactive', $tooltip_interactive, true );
					
					$plus_tooltip_theme=($settings["tooltip_common_option_plus_tooltip_theme"]!='') ? $settings["tooltip_common_option_plus_tooltip_theme"] : 'dark';
					$this->add_render_attribute( $_tooltip, 'data-tippy-theme', $plus_tooltip_theme, true );
					
					
					$tooltip_arrow =($settings["tooltip_common_option_plus_tooltip_arrow"]!='none' || $settings["tooltip_common_option_plus_tooltip_arrow"]=='') ? 'true' : 'false';
					$this->add_render_attribute( $_tooltip, 'data-tippy-arrow', $tooltip_arrow , true );
					
					$plus_tooltip_arrow=($settings["tooltip_common_option_plus_tooltip_arrow"]!='') ? $settings["tooltip_common_option_plus_tooltip_arrow"] : 'sharp';
					$this->add_render_attribute( $_tooltip, 'data-tippy-arrowtype', $plus_tooltip_arrow, true );
					
					$plus_tooltip_animation=($settings["tooltip_common_option_plus_tooltip_animation"]!='') ? $settings["tooltip_common_option_plus_tooltip_animation"] : 'shift-toward';
					$this->add_render_attribute( $_tooltip, 'data-tippy-animation', $plus_tooltip_animation, true );
					
					$plus_tooltip_x_offset=($settings["tooltip_common_option_plus_tooltip_x_offset"]!='') ? $settings["tooltip_common_option_plus_tooltip_x_offset"] : 0;
					$plus_tooltip_y_offset=($settings["tooltip_common_option_plus_tooltip_y_offset"]!='') ? $settings["tooltip_common_option_plus_tooltip_y_offset"] : 0;
					$this->add_render_attribute( $_tooltip, 'data-tippy-offset', $plus_tooltip_x_offset .','. $plus_tooltip_y_offset, true );
					
					$tooltip_duration_in =($settings["tooltip_common_option_plus_tooltip_duration_in"]!='') ? $settings["tooltip_common_option_plus_tooltip_duration_in"] : 250;
					$tooltip_duration_out =($settings["tooltip_common_option_plus_tooltip_duration_out"]!='') ? $settings["tooltip_common_option_plus_tooltip_duration_out"] : 200;
					$tooltip_trigger =($settings["tooltip_common_option_plus_tooltip_triggger"]!='') ? $settings["tooltip_common_option_plus_tooltip_triggger"] : 'mouseenter';
					$tooltip_arrowtype =($settings["tooltip_common_option_plus_tooltip_arrow"]!='') ? $settings["tooltip_common_option_plus_tooltip_arrow"] : 'sharp';
				}
				
				?>
				<li id="<?php echo esc_attr($uniqid); ?>" class="plus-icon-list-item elementor-repeater-item-<?php echo esc_attr($item['_id']); ?> <?php echo esc_attr($tooltip_class); ?> <?php echo esc_attr($animated_columns); ?> <?php echo esc_attr($active_class); ?>" data-local="true" <?php echo $this->get_render_attribute_string( $_tooltip ); ?>>
					<?php
					if ( ! empty( $item['link']['url'] ) ) {
						$link_key = 'link_' . $index;

						$this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

						if ( $item['link']['is_external'] ) {
							$this->add_render_attribute( $link_key, 'target', '_blank' );
						}

						if ( $item['link']['nofollow'] ) {
							$this->add_render_attribute( $link_key, 'rel', 'nofollow' );
						}

						echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
					}
					if($item['icon_style']=='font_awesome'){
						$icons=$item['icon_fontawesome'];									
					}else if($item['icon_style']=='icon_mind'){
						$icons=$item['icons_mind'];									
					}else{
						$icons='';
					}
					if ( ! empty( $icons ) ) :
						?>
						<div class="plus-icon-list-icon">
							<i class="<?php echo esc_attr( $icons ); ?>" aria-hidden="true"></i>
						</div>
					<?php endif; ?>
					<?php 
					$inline_class='';
					if($item['show_pin_hint']=='yes'){
						$inline_class=' pin-hint-inline';
					} ?>
					<div class="plus-icon-list-text <?php echo esc_attr($inline_class); ?>" <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['content_description']; ?><?php if($item['show_pin_hint']=='yes'){ ?><span class="plus-hint-text <?php echo esc_attr($settings['hint_align']); ?>"><?php echo esc_html($item['hint_text']); ?></span><?php } ?></div>
					<?php if ( ! empty( $item['link']['url'] ) ) : ?>
						</a>
					<?php endif; ?>
					<?php if($item['show_tooltips'] == 'yes'){
						echo '<script>
						jQuery( document ).ready(function() {
							"use strict";
							tippy( "#'.esc_attr($uniqid).'" , {
								arrowType : "'.$tooltip_arrowtype.'",
								duration : ['.esc_attr($tooltip_duration_in).','.esc_attr($tooltip_duration_out).'],
								trigger : "'.esc_attr($tooltip_trigger).'",
								appendTo: document.querySelector("#'.esc_attr($uniqid).'")
							});
						});
						</script>';
					} ?>
				</li>
				<?php
				
				$i++;
				$ij++;
			endforeach;
			?>
		</ul>
		<?php 
		$default_load=$settings['load_show_list_toggle'];
		if($settings["read_more_toggle"]=='yes' && $ij > $default_load){
			$default_load=$default_load-1;
			echo '<a href="#" class="read-more-options more" data-default-load="'.esc_attr($default_load).'" data-more-text="'.esc_attr($settings["read_show_option"]).'" data-less-text="'.esc_attr($settings["read_less_option"]).'">'.esc_html($settings["read_show_option"]).'</a>';
		}
		?>
		</div>		
		<?php
		echo $after_content;
		if(!empty($hover_inverse_effect) && $hover_inverse_effect=="hover-inverse-effect-global" && !empty($hover_inverse_id)){
			$custom=$settings["unhover_item_css_filters_css_filter"];
			$blur='blur( '.$settings["unhover_item_css_filters_blur"]["size"].$settings["unhover_item_css_filters_blur"]["unit"].')';
			$brightness=' brightness('.$settings["unhover_item_css_filters_brightness"]["size"].'%)';
			$contrast=' contrast('.$settings["unhover_item_css_filters_contrast"]["size"].'%)';
			$saturate=' saturate('.$settings["unhover_item_css_filters_saturate"]["size"].'%)';
			$hue=' hue-rotate('.$settings["unhover_item_css_filters_hue"]["size"].'deg)';
				echo '<style>body.hover-stylist-global .hover-inverse-effect-global.'.esc_attr($hover_inverse_id).' .on-hover .plus-icon-list-item{opacity:'.$settings["unhover_item_opacity"]["size"].';';
			if($custom=='custom'){
				echo 'filter:'.$blur.$brightness.$contrast.$saturate.$hue.';';
			}
			echo '}</style>';
		}
	}
	
    protected function content_template() {
	
    }

}
