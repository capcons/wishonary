<?php 
/*
Widget Name: Pricing List
Description: Pricing List
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
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;

use TheplusAddons\Theplus_Element_Load;
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Pricing_List extends Widget_Base {
		
	public function get_name() {
		return 'tp-pricing-list';
	}

    public function get_title() {
        return esc_html__('Pricing List', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-file-text theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }

    protected function _register_controls() {
	$this->start_controls_section(
			'Pricing_list',
			[
				'label' => esc_html__( 'Pricing List', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
	);
	$this->add_control(
			'menu_style',
			[
				'label' => esc_html__( 'Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1'  => esc_html__( 'Modern', 'theplus' ),
					'style_2' => esc_html__( 'Simple', 'theplus' ),
					'style_3' => esc_html__( 'Classic', 'theplus' ),
				],
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Italian Pizza', 'theplus' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Tag', 'theplus' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Small | Medium | Large', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by "|" ', 'theplus' ),
				'description' => esc_html__( 'Display multiple tag use separator e.g. Small | Medium | Large ', 'theplus' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'price',
			[
				'label' => esc_html__( 'Price', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '$4.99', 'theplus' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'content',
			[
				'label' => esc_html__( 'Description', 'theplus' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'theplus' ),
				'placeholder' => esc_html__( 'Type your description here', 'theplus' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
			]
		);
		
		
		$this->end_controls_section();
		$this->start_controls_section(
			'Pricing_list_image_option',
			[
				'label' => esc_html__( 'Image', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'menu_style' => 'style_3',
				],
			]
		);
		$this->add_control(
			'image_option',
			[
				'label' => esc_html__( 'Image', 'theplus' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic' => ['active'   => true,],
				'condition' => [
					'menu_style' => 'style_3',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_option_thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
				'condition' => [
					'menu_style' => 'style_3',
				],
			]
		);
		$this->add_control(
			'img_shape',
			[
				'label' => esc_html__( 'Image Shape', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'  => esc_html__( 'None', 'theplus' ),
					'img-rounded' => esc_html__( 'Rounded', 'theplus' ),
					'img-circle' => esc_html__( 'Circle', 'theplus' ),
				],
				'condition' => [
					'menu_style' => 'style_3',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_background',
			[
				'label' => esc_html__( 'Background Option', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'menu_style' => ['style_1','style_2'],
				],
			]
		);
		$this->start_controls_tabs( 'tabs_content_background' );
		$this->start_controls_tab(
			'tab_content_background_front',
			[
				'label' => esc_html__( 'Front', 'theplus' ),
				'condition' => [
					'menu_style' => ['style_1','style_2'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'front_bg_options',				
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-flipbox-front,{{WRAPPER}} .pt-plus-food-menu.food-menu-style-1 .food-menu-box',
				'condition' => [
					'menu_style' => ['style_1','style_2'],
				],
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'front_bg_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-flipbox-front,{{WRAPPER}} .pt-plus-food-menu.food-menu-style-1 .food-menu-box',
				'condition' => [
					'menu_style' => ['style_1','style_2'],
				],
			]
		);
		$this->add_responsive_control(
			'front_bg_border_radious',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-flipbox-front,{{WRAPPER}} .pt-plus-food-menu.food-menu-style-1 .food-menu-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'menu_style' => ['style_1','style_2'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'front_bg_box_shadow',
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-flipbox-front,{{WRAPPER}} .pt-plus-food-menu.food-menu-style-1 .food-menu-box',
				
				'condition' => [
					'menu_style' => ['style_1','style_2'],
				],
			]
		);
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'tab_content_background_back',
			[
				'label' => esc_html__( 'Back', 'theplus' ),
				'condition' => [
					'menu_style' => ['style_2'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'back_bg_options',				
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-flipbox-back',
				'dynamic' => ['active'   => true,],
				'condition' => [
					'menu_style' => ['style_2'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'back_bg_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-flipbox-back',
				'condition' => [
					'menu_style' => ['style_2'],
				],
			]
		);
		$this->add_responsive_control(
			'back_bg_border_radious',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-flipbox-back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'menu_style' => ['style_2'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'back_bg_box_shadow',
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-flipbox-back',
				
				'condition' => [
					'menu_style' => ['style_2'],
				],
			]
		);
		$this->end_controls_tab();		
		$this->end_controls_tabs();
	$this->end_controls_section();
	
	/*Start Pricing List Style */
	$this->start_controls_section(
			'Pricing_list_style',
			[
				'label' => esc_html__( 'Pricing List Style', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'menu_style!' => [ 'style_3'],
				],
			]
	);
	$this->add_control(
			'box_align',
			[
				'label' => esc_html__( 'Box Align', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'text-left',
				'options' => [
					'text-left' => esc_html__( 'Left', 'theplus' ),
					'text-center'  => esc_html__( 'Center', 'theplus' ),
					'text-right'  => esc_html__( 'Right', 'theplus' ),
				],
				'condition'    => [
					'menu_style' => [ 'style_1' ],
				],
			]
		);
	$this->add_control(
			'box_align_top',
			[
				'label' => esc_html__( 'Box Align', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'bottom-left',
				'options' => [
					'top-left' => esc_html__( 'Top Left', 'theplus' ),
					'top-right'  => esc_html__( 'Top Right', 'theplus' ),					
					'bottom-left'  => esc_html__( 'Bottom Left', 'theplus' ),
					'bottom-right'  => esc_html__( 'Bottom Right', 'theplus' ),
				],
				'condition'    => [
					'menu_style' => [ 'style_2' ],
				],
			]
		);
	
	$this->end_controls_section();
	/*End Pricing List Style */
	/*Start Pricing List Title */
	$this->start_controls_section(
			'Pricing_list_title_style',
			[
				'label' => esc_html__( 'Title Style', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
	);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-title',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#313131',
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'title_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-title',
				
			]
		);
		
		$this->add_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'title_border',
			[
				'label' => esc_html__( 'Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',	
				'condition'    => [					
					'menu_style' => [ 'style_3' ],
				],
			]
		);
		$this->add_control(
			'border_style',
			[
				'label' => esc_html__( 'Border', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => theplus_get_border_style(),
				'separator' => 'before',
				'condition' => [
					'title_border' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-title' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'bd_title_height',
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
				'condition' => [
					'title_border' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'title_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],		
				'condition' => [
					'title_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'bd_title_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f5f5f5',
				'condition' => [
					'title_border' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-title' => 'border-color: {{VALUE}};',
				],				
			]
		);
	$this->end_controls_section();
	/*End Pricing List Title */
	/*Start Pricing List Line */
	$this->start_controls_section(
			'Pricing_list_line_style',
			[
				'label' => esc_html__( 'Line Style', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [					
					'menu_style' => [ 'style_3' ],
				],
			]
	);
	$this->add_control(
			'border_line_style',
			[
				'label' => esc_html__( 'Line', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',	
				
			]
		);
		$this->add_control(
			'line_style',
			[
				'label' => esc_html__( 'Line', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => theplus_get_border_style(),
				'separator' => 'before',
				'condition' => [
					'border_line_style' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu.food-menu-style-3 .food-flex-line .food-menu-divider .menu-divider' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'bd_line_height',
			[
				'label' => esc_html__( 'Line Width', 'theplus' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				],
				'condition' => [
					'border_line_style' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu.food-menu-style-3 .food-flex-line .food-menu-divider .menu-divider' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_control(
			'bd_line_color',
			[
				'label' => esc_html__( 'Line Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#888',
				'condition' => [
					'border_line_style' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu.food-menu-style-3 .food-flex-line .food-menu-divider .menu-divider' => 'border-color: {{VALUE}};',
				],				
			]
		);
	$this->end_controls_section();
	/*End Pricing List Line */
	/*Start Pricing List Tag */
	$this->start_controls_section(
			'Pricing_list_tag_style',
			[
				'label' => esc_html__( 'Tag Style', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
	);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tag_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-tag',
			]
		);
		$this->add_control(
			'tag_right_margin',
			[
				'label' => esc_html__( 'Tag Space', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],				
				'range' => [					
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-tag' => 'margin-right: {{SIZE}}{{UNIT}};',
				],				
			]
		);
		$this->add_control(
			'tag_color',
			[
				'label' => esc_html__( 'Tag Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#313131',
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-tag' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'tag_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-tag',
				
			]
		);
		
		$this->add_responsive_control(
			'tag_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-tag' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],						
			]
		);
		$this->add_control(
			'tag_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
	$this->end_controls_section();
	/*End Pricing List Tag */
	/*Start Pricing List Price */
	$this->start_controls_section(
			'Pricing_list_price_style',
			[
				'label' => esc_html__( 'Price Style', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
	);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-price',
			]
		);
		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Price Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#313131',
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-price' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'price_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-price',
				
			]
		);
		
		$this->add_responsive_control(
			'price_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],						
			]
		);
		
		$this->add_control(
			'price_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-menu-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	$this->end_controls_section();
	/*End Pricing List Price */
	/*Start Pricing List desc */
	$this->start_controls_section(
			'Pricing_list_desc_style',
			[
				'label' => esc_html__( 'Description Style', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
	);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-desc',
			]
		);
		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Description Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#313131',
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-desc,{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-desc p' => 'color: {{VALUE}}',
				],
			]
		);		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'desc_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-desc',
				
			]
		);
		
		$this->add_responsive_control(
			'dec_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],						
			]
		);
		
		$this->add_control(
			'dec_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	$this->end_controls_section();
	/*End Pricing List desc */
	/*Start Pricing List Image */
		$this->start_controls_section(
			'Pricing_list_img_style',
			[
				'label' => esc_html__( 'Image Style', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'menu_style' => 'style_3',
				],
			]
		);
		$this->add_responsive_control(
            'img_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image Max Width', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-flex-imgs.food-flex-img' => 'max-width: {{SIZE}}{{UNIT}}',
				],
            ]
		);
		$this->add_responsive_control(
            'img_min_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image Min Width', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-flex-imgs.food-flex-img' => 'min-width: {{SIZE}}{{UNIT}}',
				],
            ]
		);
		$this->add_control(
			'img_border',
			[
				'label' => esc_html__( 'Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',				
			]
		);
		$this->add_control(
			'img_border_style',
			[
				'label' => esc_html__( 'Border', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => theplus_get_border_style(),
				'separator' => 'before',
				'condition' => [
					'img_border' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-flex-imgs .food-img img' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'border_height',
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
				'condition' => [
					'img_border' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-flex-imgs .food-img img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f5f5f5',
				'condition' => [
					'img_border' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-flex-imgs .food-img img' => 'border-color: {{VALUE}};',
				],				
			]
		);
		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-flex-imgs .food-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'img_shadow',
				'selector' => '{{WRAPPER}} .pt-plus-food-menu .food-menu-box .food-flex-imgs .food-img img',
			]
		);
	$this->end_controls_section();
	/*End Pricing List Image */
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
		$content = $settings['content'];
		$menu_style = $settings['menu_style'];
		$box_align_top = $settings['box_align_top'];
		$box_align = $settings['box_align'];
		$title = $settings['title'];
		$title_tag = $settings['title_tag'];
		$price = $settings['price'];
		
		$img_shape = $settings['img_shape'];
		
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


		$style_class='';
			if($menu_style =="style_1"){
				$style_class = 'style-1';
			}else if($menu_style =="style_2"){
				$style_class = 'style-2';
			}else if($menu_style =="style_3"){
				$style_class = 'style-3';
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
		$description=$food_title=$food_price=$food_img = $food_tag =$food_flex_img='';
		
		if(!empty($settings['image_option']['url'])){			
			$image_option=$settings['image_option']['id'];
			$img_af = wp_get_attachment_image_src($image_option,$settings['image_option_thumbnail_size']);
			$img = $img_af[0];
			
			$image_id=$settings["image_option"]["id"];
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
			if(!$image_alt){
				$image_alt = get_the_title($image_id);
			}else if(!$image_alt){
				$image_alt = 'Plus food image';
			}
			$food_img = '<div class="food-img '.esc_attr($img_shape).'"> <img src="'.$img.'" alt="'.esc_attr($image_alt).'"> </div>';
			$food_flex_img = 'food-flex-img';
		}
			
			if(isset($bg_back_img) && !empty($bg_back_img)){
			$bg_back_img = wp_get_attachment_image_src($bg_back_img, "full");
			$img_bg_back_Src= $bg_back_img[0];			
			}else{$img_bg_back_Src = '';}

			if(isset($bg_img) && !empty($bg_img)){
			$bg_front_img = wp_get_attachment_image_src($bg_img, "full");
			$img_bg_Src = $bg_front_img [0];			
			}else{$img_bg_Src = '';}

			if(!empty($title_tag) ){
				$array=explode("|",$title_tag);
				if(!empty($array[1])){
					foreach($array as $value){
						$food_tag .='<h5 class="food-menu-tag" >'.esc_html($value).'</h5>';
					}
				}else{
					$food_tag ='<h5 class="food-menu-tag" >'.esc_html($title_tag).'</h5>';
				}
			}
			if(!empty($title) ){
				$food_title ='<h3 class="food-menu-title" >'.esc_html($title).'</h3>';
			}
			if(!empty($price) ){
				$food_price ='<h4 class="food-menu-price" >'.esc_html($price).'</h4>';
			}
			
			
			if($content !=''){				
				$description='<div class="food-desc" > '.$content.' </div>';
				}
		
			$uid=uniqid('food_menu');
			
			if ($menu_style == 'style_1'){
				$box_align_1 = $box_align;
			}else{
				$box_align_1 = '';
			}
			
			if ($menu_style== 'style_2'){
				$box_align_top_1 = $box_align_top;
			}else{
				$box_align_top_1 = '';
			}
			
			$food_menu ='<div class="pt-plus-food-menu  '.esc_attr($box_align).' '.esc_attr($uid).'  food-menu-'.esc_attr($style_class).' '.$animated_class.'" data-uid="'.esc_attr($uid).'" '.$animation_attr.'>';
			if ($menu_style == 'style_1'){
				$food_menu.='<div class="food-menu-box">';				
					$food_menu.= $food_tag;
					$food_menu.= $food_title;
					$food_menu.= $description;
					$food_menu.= $food_price;
				$food_menu.='</div>';
			}else if ($menu_style == 'style_2'){
				$food_menu.='<div class="food-menu-box '.esc_attr($box_align_top_1).'">';	
					$food_menu.='<div class="food-flipbox flip-horizontal flip-horizontal height-full">';
						$food_menu.='<div class="food-flipbox-holder height-full perspective bezier-1">';
							$food_menu.='<div class="food-flipbox-front bezier-1 no-backface origin-center">';
								$food_menu.='<div class="food-flipbox-content width-full">';
									$food_menu.= '<div class="food-menu-block">'.$food_tag.'</div>';
									$food_menu.= '<div class="food-menu-block">'.$food_title.'</div>';
									$food_menu.= $food_price;
								$food_menu.='</div>';
							$food_menu.='</div>';
							$food_menu.='<div class="food-flipbox-back fold-back-horizontal no-backface bezier-1 origin-center">';
								$food_menu.='<div class="food-flipbox-content width-full ">';
									$food_menu.='<div class="text-center">';
										$food_menu.= $description;		
									$food_menu.='</div>';
								$food_menu.='</div>';
							$food_menu.='</div>';
						$food_menu.='</div>';
					$food_menu.='</div>';
				$food_menu.='</div>';
			}else if ($menu_style == 'style_3'){
				$food_menu.='<div class="food-menu-box">';
					$food_menu.='<div class="food-menu-flex ">';
						$food_menu.='<div class="food-flex-line ">';
							$food_menu.='<div class="food-flex-imgs '.esc_attr($food_flex_img).'">';
								$food_menu.= $food_img;
							$food_menu.='</div>';		
							$food_menu.='<div class="food-flex-content">';
								$food_menu.= '<div class="food-menu-block">'.$food_tag.'</div>';
								$food_menu.='<div class="food-title-price">';
									$food_menu.= $food_title;
									$food_menu.= '<div class="food-menu-divider"><div class="menu-divider '.esc_attr($settings['border_line_style']).'"></div></div>';
									$food_menu.= $food_price;
								$food_menu.='</div>';
								$food_menu.= $description;
							$food_menu.='</div>';	
						$food_menu.='</div>';	
						
					$food_menu.='</div>';
				$food_menu.='</div>';
			}
			$food_menu.='</div>';
		echo $before_content.$food_menu.$after_content;	
	}
	
    protected function content_template() {
		
    }

}

