<?php 
/*
Widget Name: Progress Bar
Description: Progress Bar
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


class ThePlus_Progress_Bar extends Widget_Base {
		
	public function get_name() {
		return 'tp-progress-bar';
	}

    public function get_title() {
        return esc_html__('Progress Bar', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-file-text theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }
	
	public function get_keywords() {
		return [ 'pie chart', 'progress bar', 'chart'];
	}

    protected function _register_controls() {
		
		/* Progress Bar */
		
		$this->start_controls_section(
			'progress_bar',
			[
				'label' => esc_html__( 'Progress Bar', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'main_style',
			[
				'label' => esc_html__( 'Select Main Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'progressbar',
				'options' => [
					'progressbar'  => esc_html__( 'Progress Bar', 'theplus' ),
					'pie_chart' => esc_html__( 'Pie Chart', 'theplus' ),
				],
			]
		);
		
		$this->add_control(
			'pie_chart_style',
			[
				'label' => esc_html__( 'Pie Chart Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'theplus' ),
					'style_2'  => esc_html__( 'Style 2', 'theplus' ),
					'style_3'  => esc_html__( 'Style 3', 'theplus' ),
				],
				'condition'    => [
					'main_style' => [ 'pie_chart' ],
				],
			]
		);
		$this->add_control(
			'progressbar_style',
			[
				'label' => esc_html__( 'Progress Bar Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'theplus' ),
					'style_2'  => esc_html__( 'Style 2', 'theplus' ),
				],
				'condition'    => [
					'main_style' => [ 'progressbar' ],
				],
			]
		);
		$this->add_control(
			'pie_border_style',
			[
				'label' => esc_html__( 'Pie Chart Round Styles', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'theplus' ),
					'style_2'  => esc_html__( 'Style 2', 'theplus' ),					
				],
				'condition'    => [
					'main_style' => [ 'pie_chart' ],
					],
			]
		);
		$this->add_control(
			'progress_bar_size',
			[
				'label' => esc_html__( 'Progress Bar Height', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'small',
				'options' => [
					'small' => esc_html__( 'Small Height', 'theplus' ),					
					'medium' => esc_html__( 'Medium Height', 'theplus' ),					
					'large' => esc_html__( 'Large Height', 'theplus' ),					
				],
				'condition'    => [
					'main_style' => [ 'progressbar' ],
					'progressbar_style' => [ 'style_1' ],
				],
			]
		);
		
		$this->add_control(
			'value_width',
			[
				'label' => esc_html__( 'Dynamic Value (0-100)', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition'    => [					
					'main_style' => [ 'progressbar' ],
				],
				'default' => [
					'unit' => '%',
					'size' => 59,
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'The Plus', 'theplus' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'The Plus', 'theplus' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
			]
		);
		
		$this->add_control(
			'number',
			[
				'label' => esc_html__( 'Number', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '59', 'theplus' ),
				'placeholder' => esc_html__( 'Enter Number Ex. 50 , 60', 'theplus' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'symbol',
			[
				'label' => esc_html__( 'Prefix/Postfix Symbol', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '%', 'theplus' ),
				'placeholder' => esc_html__( 'Enter Symbol', 'theplus' ),
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'symbol_position',
			[
				'label' => esc_html__( 'Symbol Position', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => [
					'after' => esc_html__( 'After Number', 'theplus' ),
					'before'  => esc_html__( 'Before Number', 'theplus' ),
				],				
				'condition'    => [
					'symbol!' => '',
				],
			]
		);	
		
		$this->end_controls_section();
		$this->start_controls_section(
			'icon_progress_bar',
			[
				'label' => esc_html__( 'Icon', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'image_icon',
			[
				'label' => esc_html__( 'Select Icon', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('You can select Icon, Custom Image using this option.','theplus'),
				'default' => 'icon',
				'options' => [
					''  => esc_html__( 'None', 'theplus' ),
					'icon' => esc_html__( 'Icon', 'theplus' ),
					'image' => esc_html__( 'Image', 'theplus' ),					
				],
			]
		);
		$this->add_control(
			'select_image',
			[
				'label' => esc_html__( 'Use Image As icon', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'dynamic' => ['active'   => true,],
				'media_type' => 'image',
				'condition' => [
					'image_icon' => 'image',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'select_image_thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
			]
		);
		$this->add_control(
			'type',
			[
				'label' => esc_html__( 'Icon Font', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome', 'theplus' ),
					'icon_mind' => esc_html__( 'Icons Mind', 'theplus' ),
				],
				'condition' => [
					'image_icon' => 'icon',
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
					'image_icon' => 'icon',
					'type' => 'font_awesome',
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
					'image_icon' => 'icon',
					'type' => 'icon_mind',
				],
			]
		);
		$this->add_control(
			'icon_postition',
			[
				'label' => esc_html__( 'Icon Title Before after', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'before',
				'options' => [
					'before' => esc_html__( 'Before', 'theplus' ),
					'after'  => esc_html__( 'After', 'theplus' ),
				],
				'condition'    => [
					'image_icon' => [ 'icon','image','svg' ],
				],
			]
		);
		$this->end_controls_section();
		/* Progress Bar*/
		
		
		/*<-----Style tag ----> */
		/* Icon Style*/
		$this->start_controls_section(
            'section_pie_chart_styling',
            [
                'label' => esc_html__('Pie Chart Setting', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'main_style' => [ 'pie_chart' ],
				],
            ]
        );
		$this->add_control(
			'pie_value',
			[
				'label' => esc_html__( 'Dynamic Value (0-1)', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0.6,
				],
				'condition'    => [					
					'main_style' => [ 'pie_chart' ],
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'pie_size',
			[
				'label' => esc_html__( 'Pie Chart Circle Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [					
					'px' => [
						'min' => 0,
						'max' => 700,
						'step' => 2,
					],
				],
				'render_type' => 'template',
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [					
					'{{WRAPPER}} .pt-plus-circle' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [					
					'main_style' => [ 'pie_chart' ],
				],
			]
		);
		
		
		$this->add_control(
			'pie_thickness',
			[
				'label' => esc_html__( 'Thickness', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'condition'    => [					
					'main_style' => [ 'pie_chart' ],
				],
			]
		);
		$this->add_control(
			'data_empty_fill',
			[
				'label' => esc_html__( 'Pie Empty Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',				
				'condition'    => [
					'main_style' => [ 'pie_chart' ],
					'pie_chart_style!' => [ 'style_2' ],
				],
			]
		);		
		$this->add_control(
			'pie_empty_color',
			[
				'label' => esc_html__( 'pie Chart Empty Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition'    => [
					'main_style' => [ 'pie_chart1' ],
					'pie_chart_style!' => [ 'style_2' ],
				],
			]
		);
		$this->add_control(
			'pie_fill',
			[
				'label' => esc_html__( 'Chart Fill Color', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'classic' => [
						'title' => esc_html__( 'Classic', 'theplus' ),
						'icon' => 'fa fa-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'theplus' ),
						'icon' => 'fa fa-barcode',
					],
				],
				'condition'    => [
					'main_style' => [ 'pie_chart' ],
				],
				'label_block' => false,
				'default' => 'classic',
			]
		);
		
		$this->add_control(
            'pie_fill_classic',
            [
                'label' => esc_html__('Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'main_style' => [ 'pie_chart' ],
					'pie_fill' => 'classic',
				],
				
            ]
        );
		$this->add_control(
            'pie_fill_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'main_style' => [ 'pie_chart' ],
					'pie_fill' => 'gradient',
				],
				
            ]
        );
		$this->add_control(
            'pie_fill_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => 'green',
				'condition' => [
					'main_style' => [ 'pie_chart' ],
					'pie_fill' => 'gradient',
				],
				
            ]
        );
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_title_styling',
            [
                'label' => esc_html__('Title Setting', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .progress_bar .prog-title.prog-icon .progress_bar-title,{{WRAPPER}} .pt-plus-pie_chart .progress_bar-title',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} span.progress_bar-title,
					{{WRAPPER}} .progress_bar-media.large .prog-title.prog-icon.large .progres-ims,
					{{WRAPPER}} .progress_bar-media.large .prog-title.prog-icon.large .progress_bar-title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'title_margin',
			[
				'label' => esc_html__( 'Title Left Margin', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} span.progress_bar-title.
					{{WRAPPER}} .progress_bar-media.large .prog-title.prog-icon.large .progres-ims,
					{{WRAPPER}} .progress_bar-media.large .prog-title.prog-icon.large .progress_bar-title' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [					
					'main_style' => [ 'progressbar' ],
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_subtitle_styling',
            [
                'label' => esc_html__('Sub Title Setting', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .progress_bar .prog-title.prog-icon .progress_bar-sub_title,{{WRAPPER}} .pt-plus-pie_chart .progress_bar-sub_title',
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Sub Title Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .progress_bar-sub_title' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->end_controls_section();
		$this->start_controls_section(
            'section_number_styling',
            [
                'label' => esc_html__('Number Setting', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),				
				'selector' => '{{WRAPPER}} .progress_bar .counter-number .theserivce-milestone-number.icon-milestone',
			]
		);
		$this->add_control(
			'number_color',
			[
				'label' => esc_html__( 'Number Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .progress_bar .counter-number .theserivce-milestone-number.icon-milestone' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_number_pre_pos_styling',
            [
                'label' => esc_html__('Number Prefix/Postfix Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'prefix_postfix_typography',
				'label' => esc_html__( 'Typography', 'theplus' ),
				'selector' => '{{WRAPPER}} .progress_bar .counter-number .theserivce-milestone-symbol',
			]
		);
		$this->add_control(
			'prefix_postfix_symbol_color',
			[
				'label' => esc_html__( 'Prefix/Postfix Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .progress_bar .counter-number .theserivce-milestone-symbol' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->end_controls_section();
		$this->start_controls_section(
            'section_icon_styling',
            [
                'label' => esc_html__('Icon/Image Setting', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition'    => [					
					'image_icon' => [ 'icon' ],
				],
				'selectors' => [
					'{{WRAPPER}} span.progres-ims' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [					
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition'    => [					
					'image_icon' => [ 'icon' ],
				],
				'selectors' => [
					'{{WRAPPER}} .progress_bar .prog-title.prog-icon span.progres-ims,{{WRAPPER}} .pt-plus-circle .pianumber-css .progres-ims,{{WRAPPER}} .pt-plus-pie_chart .pie_chart .progres-ims' => 'font-size: {{SIZE}}{{UNIT}};',					
				],
				
			]
		);
		
		$this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],				
				'range' => [					
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'condition'    => [					
					'image_icon' => [ 'image' ],
				],
				'selectors' => [
					'{{WRAPPER}} .progress_bar .progres-ims img.progress_bar-img' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',					
				],
				
			]
		);
		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Image Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .progress_bar .progres-ims img.progress_bar-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'    => [					
					'image_icon' => [ 'image' ],
				],
			]
		);
		
		$this->end_controls_section();
		$this->start_controls_section(
            'section_progress_bar_styling',
            [
                'label' => esc_html__('Progress Bar Setting', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [					
					'main_style' => [ 'progressbar' ],
				],
            ]
        );
		$this->add_control(
			'progress_bar_margin',
			[
				'label' => esc_html__( 'Progress Bar Top Margin', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .progress_bar-skill.skill-fill' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [					
					'main_style' => [ 'progressbar' ],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'progress_filled_color',
				'label' => esc_html__( 'Filled Color', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .progress_bar-skill-bar-filled',
			]
		);
		$this->add_control(
			'progress_empty_color',
			[
				'label' => esc_html__( 'Empty Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
			]
		);
		$this->add_control(
			'progress_seprator_color',
			[
				'label' => esc_html__( 'Seprator Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .progress-style_2 .progress_bar-skill-bar-filled:after' => 'border-color: {{VALUE}}',
				],
				'condition'    => [					
					'progressbar_style' => [ 'style_2' ],
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
		
		
		
		
		$main_style = $settings['main_style'];					
		$pie_chart_style = $settings['pie_chart_style'];					
		$pie_border_style = $settings['pie_border_style'];		
		$pie_empty_color = ($settings['pie_empty_color']!='') ? $settings['pie_empty_color'] : '#8072fc';
		$progress_empty_color = ($settings['progress_empty_color']!='') ? $settings['progress_empty_color'] : '#8072fc';
		
		$progressbar_style = $settings['progressbar_style'];					
		$progress_bar_size = $settings['progress_bar_size'];												
		$pie_size = (!empty($settings['pie_size']['size'])) ? $settings['pie_size']['size'] : 200;												
		$title = $settings['title'];					
		$subtitle = $settings['sub_title'];					
		$image_icon = $settings['image_icon'];					
						
		
		 $title_content='';
		if(!empty($title)){
			 $title_content= '<span class="progress_bar-title"> '.esc_html($title).' </span>';
		}
		
		$subtitle_content='';
		if(!empty($subtitle)){
			 $subtitle_content= '<div class="progress_bar-sub_title"> '.esc_html($subtitle).' </div>';;
		}
		if($pie_size != ''){
		$inner_width = ' style="';
			$inner_width .= 'width: '.esc_attr($pie_size).'px;';
			$inner_width .= 'height: '.esc_attr($pie_size).'px;';
		$inner_width .= '"';
		}
		
		$progress_bar_img='';
		if($image_icon == 'image' && !empty($settings['select_image']["url"])){			
			$select_image=$settings['select_image']['id'];
			$img_src = wp_get_attachment_image_src($select_image,$settings['select_image_thumbnail_size']);
			$img = $img_src[0];
			$progress_bar_img='<span class="progres-ims"><img src="'.esc_url($img).'"   class="progress_bar-img" alt="" /></span>';
		}
		if($image_icon == 'icon'){
			if($settings["type"]=='font_awesome'){
				$icons = $settings["icon_fontawesome"];
			}else if($settings["type"]=='icon_mind'){
				$icons = $settings["icons_mind"];
			}else{
				$icons = '';
			}
			$progress_bar_img = '<span class="progres-ims"><i class=" '.esc_attr($icons).'"></i></span>';
		}
		
		if($settings['icon_postition'] == 'after'){
			$icon_text = $title_content.$progress_bar_img.$subtitle_content;
		}else{
			$icon_text = $progress_bar_img.$title_content.$subtitle_content;
		}
		
		if(!empty($settings['symbol'])) {
		  if($settings['symbol_position']=="after"){
			$symbol2 = '<span class="theserivce-milestone-number icon-milestone" data-counterup-nums="'.esc_attr($settings['number']).'">'.esc_html($settings['number']).'</span><span class="theserivce-milestone-symbol">'.esc_html($settings['symbol']).'</span>';
			}elseif($settings['symbol_position']=="before"){
				$symbol2 = '<span class="theserivce-milestone-symbol">'.esc_html($settings['symbol']).'</span><span class="theserivce-milestone-number" data-counterup-nums="'.esc_attr($settings['number']).'">'.esc_html($settings['number']).'</span>';
			}
		} else {
			$symbol2 = '<span class="theserivce-milestone-number icon-milestone" data-counterup-nums="'.esc_attr($settings['number']).'">'.esc_html($settings['number']).'</span>';
		}
		if($settings['pie_fill'] =='gradient'){
			$data_fill_color = ' data-fill="{&quot;gradient&quot;: [&quot;' . $settings['pie_fill_gradient_color1'] . '&quot;,&quot;' . $settings['pie_fill_gradient_color2'] . '&quot;]}" ';
		}else{
		$data_fill_color = ' data-fill="{&quot;color&quot;: &quot;'.$settings['pie_fill_classic'].'&quot;}" ';
		}
		if($main_style == 'pie_chart_style'){
			if($pie_chart_style == 'style_1'){
				if($symbol2!= ''){
				$number_markup = '<h5 class="counter-number">'.$progress_bar_img.$symbol2.'</h5>';
				}
			}else{
				if($symbol2!= ''){
				$number_markup = '<h5 class="counter-number">'.$symbol2.'</h5>';
				}
			}
		}else{
			if($symbol2!= ''){
				$number_markup = '<h5 class="counter-number">'.$symbol2.'</h5>';
				}
		}
		$pie_border_after='';
		if($pie_border_style == "style_2") {
			$pie_border_after = "pie_border_after";
			$pie_empty_color1 = "transparent";
		}else{
			$pie_empty_color1 = $pie_empty_color;
		}
		
		$progress_width= ($settings["value_width"]["size"]!='') ? $settings["value_width"]["size"].'%' : '59%';
		
		$uid=uniqid("progress_bar");
		$progress_bar ='<div class="progress_bar pt-plus-peicharts progress-skill-bar '.esc_attr($uid).' progress_bar-'.esc_attr($main_style).' '.$animated_class.'" '.$animation_attr.' data-empty="'.esc_attr($pie_empty_color).'" data-uid="'.esc_attr($uid).'" >';
			if($main_style == 'progressbar'){
				if($progressbar_style == 'style_1'){			
					if($progress_bar_size != 'large'){
						$progress_bar .= '<div class="progress_bar-media">';
							$progress_bar .= '<div class="prog-title prog-icon">';
								$progress_bar .= $icon_text; 
							$progress_bar .= '</div>'; 	
							$progress_bar .=$number_markup;
						$progress_bar .= '</div>';	
							
							$progress_bar .= '<div class="progress_bar-skill skill-fill '.esc_attr($progress_bar_size).'" style="background-color:'.esc_attr($progress_empty_color).'">';
								$progress_bar .= '<div class="progress_bar-skill-bar-filled " data-width="'.esc_attr($progress_width).'">	</div>';
							$progress_bar .= '</div>';
					}else{
							$progress_bar .= '<div class="progress_bar-skill skill-fill '.esc_attr($progress_bar_size).'" style="background-color:'.esc_attr($progress_empty_color).'" >';
								$progress_bar .= '<div class="progress_bar-skill-bar-filled " data-width="'.esc_attr($progress_width).'">	</div>';
								$progress_bar .= '<div class="progress_bar-media '.esc_attr($progress_bar_size).' ">';	
									$progress_bar .= '<div class="prog-title prog-icon '.esc_attr($progress_bar_size).'">';
										$progress_bar .= $progress_bar_img.$title_content; 	
									$progress_bar .= '</div>';
									$progress_bar .=$number_markup;
								$progress_bar .= '</div>';
							$progress_bar .= '</div>';
							
						}
				}else if($progressbar_style == 'style_2'){
						$progress_bar .= '<div class="progress_bar-media">';	
							$progress_bar .= '<div class="prog-title prog-icon">';
								$progress_bar .= $icon_text; 	
							$progress_bar .= '</div>'; 	
							$progress_bar .=$number_markup;
						$progress_bar .= '</div>';	
						$progress_bar .= '<div class="progress_bar-skill skill-fill progress-'.esc_attr($progressbar_style).'" style="background-color:'.esc_attr($progress_empty_color).'">';
							$progress_bar .= '<div class="progress_bar-skill-bar-filled "  data-width="'.esc_attr($progress_width).'">	</div>';
						$progress_bar .= '</div>';
				
				}
			}
			
			if(!empty($settings['data_empty_fill'])){
				$data_empty_fill=$settings['data_empty_fill'];
			}else{
				$data_empty_fill='transparent';
			}
			
			if($main_style == 'pie_chart'){
					$progress_bar .= '<div class="pt-plus-piechart '.esc_attr($pie_border_after).' pie-'.esc_attr($pie_chart_style).'"  '.$data_fill_color.' data-emptyfill="'.$data_empty_fill.'" data-value="'.$settings['pie_value']['size'].'"  data-size="'.$settings['pie_size']['size'].'" data-thickness="'.$settings['pie_thickness']['size'].'"  data-animation-start-value="0"  data-reverse="false">';
					
						$progress_bar .= '<div class="pt-plus-circle" '.$inner_width.'>';
							$progress_bar .='<div class="pianumber-css" >';
							if($pie_chart_style != 'style_3'){
								$progress_bar .= $number_markup;
							}else{	
								$progress_bar .= $progress_bar_img;
							}
							$progress_bar .= '</div>';	
						$progress_bar .= '</div>';
					$progress_bar .= '</div>';
						if($pie_chart_style == 'style_1'){
							$progress_bar .= '<div class="pt-plus-pie_chart" >';
								$progress_bar .= $title_content;
								$progress_bar .= $subtitle_content;
							$progress_bar .= '</div>';	
						}else if($pie_chart_style == 'style_2'){
							$progress_bar .= '<div class="pt-plus-pie_chart style-2" >';
								$progress_bar .= '<div class="pie_chart " >';
									$progress_bar .= $progress_bar_img;
								$progress_bar .= '</div >';	
								$progress_bar .= '<div class="pie_chart-style2">';
								$progress_bar .= $title_content;
								$progress_bar .= $subtitle_content;
								$progress_bar .= '</div>';
									
							$progress_bar .= '</div>';	
						}else if($pie_chart_style == 'style_3'){
							$progress_bar .= '<div class="pt-plus-pie_chart style-3">';
								$progress_bar .= '<div class="pie_chart " >';
									$progress_bar .= $number_markup;
								$progress_bar .= '</div >';	
								$progress_bar .= '<div class="pie_chart-style3">';
								$progress_bar .= $title_content;
								$progress_bar .= $subtitle_content;
								$progress_bar .= '</div>';
									
							$progress_bar .= '</div>';	
						}
						
					}
		$progress_bar .='</div>';
		$progress_bar .= '<script>( function ( $ ) { 
		"use strict";
		$( document ).ready(function() {
			var elements = document.querySelectorAll(".pt-plus-piechart");
			Array.prototype.slice.apply(elements).forEach(function(el) {
				var $el = jQuery(el);
				//$el.circleProgress({value: 0});
				new Waypoint({
					element: el,
					handler: function() {
						if(!$el.hasClass("done-progress")){
						setTimeout(function(){
							$el.circleProgress({
								value: $el.data("value"),
								emptyFill: $el.data("emptyfill"),
								startAngle: -Math.PI/4*2,
							});
							//  this.destroy();
						}, 800);
						$el.addClass("done-progress");
						}
					},
					offset: "80%"
				});
			});
		});
		$(window).on("load resize scroll", function(){
			$(".pt-plus-peicharts").each( function(){
				var height=$("canvas",this).outerHeight();
				var width=$("canvas",this).outerWidth();
				$(".pt-plus-circle",this).css("height",height+"px");
				$(".pt-plus-circle",this).css("width",width+"px");
			});
		});
	} ( jQuery ) );</script>';
		echo $before_content.$progress_bar.$after_content;
	}
	
    protected function content_template() {
		
    }

}
