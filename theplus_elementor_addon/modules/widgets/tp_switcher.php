<?php 
/*
Widget Name: Switcher
Description: Content of toggle switcher.
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
use Elementor\Group_Control_Box_Shadow;

use TheplusAddons\Theplus_Element_Load;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Switcher extends Widget_Base {
		
	public function get_name() {
		return 'tp-switcher';
	}

    public function get_title() {
        return esc_html__('Switcher', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-toggle-on theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-tabbed');
    }

    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_one_section',
			[
				'label' => esc_html__( 'Content 1', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'switch_a_title',
			[
				'label'   => esc_html__( 'Title', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Switch A' , 'theplus' ),
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'content_a_source',
			[
				'label' => esc_html__( 'Select Source', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => [
					'content'  => esc_html__( 'Custom Content', 'theplus' ),
					'template' => esc_html__( 'Template', 'theplus' ),
				],
			]
		);
		$this->add_control(
			'content_a_desc',
			[
				'label' => esc_html__( 'Content', 'theplus' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'I am text block. Click edit button to change this text.', 'theplus' ),
				'placeholder' => esc_html__( 'Type your description here', 'theplus' ),
				'dynamic' => ['active'   => true,],
				'condition'    => [
					'content_a_source' => [ 'content' ],
				],
			]
		);
		$this->add_control(
			'content_a_template',
			[
				'label'       => esc_html__( 'Elementor Templates', 'theplus' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => theplus_get_templates(),
				'label_block' => 'true',
				'condition'   => ['content_a_source' => "template"],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'content_b_section',
			[
				'label' => esc_html__( 'Content 2', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'switch_b_title',
			[
				'label'   => esc_html__( 'Title', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Switch B' , 'theplus' ),
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'content_b_source',
			[
				'label' => esc_html__( 'Select Source', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => [
					'content'  => esc_html__( 'Custom Content', 'theplus' ),
					'template' => esc_html__( 'Template', 'theplus' ),
				],
			]
		);
		
		$this->add_control(
			'content_b_desc',
			[
				'label' => esc_html__( 'Content', 'theplus' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'theplus' ),
				'placeholder' => esc_html__( 'Type your description here', 'theplus' ),
				'dynamic' => ['active'   => true,],
				'condition'    => [
					'content_b_source' => [ 'content' ],
				],
			]
		);
		$this->add_control(
			'content_b_template',
			[
				'label'       => esc_html__( 'Elementor Templates', 'theplus' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => theplus_get_templates(),
				'label_block' => 'true',
				'condition'   => ['content_b_source' => "template"],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'content_switcher_section',
			[
				'label' => esc_html__( 'Switch/Toggle', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'switcher_unique_id',
			[
				'label' => esc_html__( 'Unique Switcher ID', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'separator' => 'after',
				'description' => esc_html__('Keep this blank or Setup Unique id for switcher which you can use with "Carousel Remote" widget.','theplus'),
			]
		);
		$this->add_control(
			'show_switcher_button',
			[
				'label' => esc_html__( 'Display Switcher Button', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'switcher_style',
			[
				'label' => esc_html__( 'Switcher Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Style 1', 'theplus' ),
					'style-2' => esc_html__( 'Style 2', 'theplus' ),
					'style-3' => esc_html__( 'Style 3', 'theplus' ),
					'style-4' => esc_html__( 'Style 4', 'theplus' ),
				],
			]
		);
		$this->add_control(
			'switch-align',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
				'toggle' => true,
			]
		);
		$this->add_control(
            'switch_label_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Label Spacing', 'theplus'),
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 100,
						'step' => 2,
					],
					'%' => [
						'min'	=> 0,
						'max'	=> 30,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-switcher .switch-1' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-switcher  .switch-2' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [
					'switcher_style' => [ 'style-1','style-2' ],					
				],
            ]
        );
		$this->add_control(
            'switch_toggle_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Switch/Toggle Size', 'theplus'),
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 50,
						'step' => 2,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-switcher .switcher-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [
					'switcher_style' => [ 'style-1','style-2' ],					
				],
            ]
        );
		$this->add_control(
            'switch_4_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Switch Max-Width', 'theplus'),
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 280,
				],
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 600,
						'step' => 2,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-switcher .switcher-toggle.style-3,{{WRAPPER}} .theplus-switcher .switcher-toggle.style-4' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [
					'switcher_style' => ['style-3','style-4'],					
				],
            ]
        );
		$this->end_controls_section();
		$this->start_controls_section(
            'section_switcher_styling',
            [
                'label' => esc_html__('Switcher Cosmetics', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'switch_color',
            [
                'label' => esc_html__('Switch Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .switch-slider.style-1:before,{{WRAPPER}} .switch-slider.style-2:before' => 'background:{{VALUE}};',
                ],
				'condition'    => [
					'switcher_style!' => [ 'style-3','style-4' ],
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_switcher_style' );
		$this->start_controls_tab(
			'tab_normal_switcher',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
            'normal_bg_color',
            [
                'label' => esc_html__('Background Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#3351a6',
                'selectors' => [
                    '{{WRAPPER}} .switch-toggle + .switch-slider,{{WRAPPER}} .switcher-toggle.style-4' => 'background:{{VALUE}};',
                ],
				'condition' => [
					'switcher_style!' => 'style-3',
				],
            ]
        );
		$this->add_control(
            'normal_label_color',
            [
                'label' => esc_html__('Label Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#313131',
				'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .switch-toggle + .switch-slider' => 'color:{{VALUE}};',
                    '{{WRAPPER}} .theplus-switcher .switcher-toggle.inactive .switch-label-2,{{WRAPPER}} .theplus-switcher .switcher-toggle.active .switch-label-1,{{WRAPPER}} .switcher-toggle.style-4 .switch-label-text' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_active_switcher',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_control(
            'active_bg_color',
            [
                'label' => esc_html__('Background Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0112b',
                'selectors' => [
                    '{{WRAPPER}} .switch-toggle:checked + .switch-slider,{{WRAPPER}} .switcher-toggle.style-4:before' => 'background:{{VALUE}};',
                ],
				'condition' => [
					'switcher_style!' => 'style-3',
				],
            ]
        );
		$this->add_control(
            'active_label_color',
            [
                'label' => esc_html__('Label Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#313131',
				'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .switch-toggle + .switch-slider' => 'color:{{VALUE}};',
					'{{WRAPPER}} .theplus-switcher .switcher-toggle.inactive .switch-label-1,{{WRAPPER}} .theplus-switcher .switcher-toggle.active .switch-label-2,{{WRAPPER}} .switcher-toggle.style-4 .switch-label-text' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'switch_box_shadow',
				'selector' => '{{WRAPPER}} .theplus-switcher .switch-slider.style-1:before,{{WRAPPER}} .theplus-switcher .switch-slider.style-2:before,{{WRAPPER}}  .theplus-switcher .switcher-toggle.style-4',
				'condition' => [
					'switcher_style!' => 'style-3',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_switcher_typography_styling',
            [
                'label' => esc_html__('Switcher Typography', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typho_a_label',
                'label' => esc_html__('Label 1 Typography', 'theplus'),
				'separator' => 'before',
                'selector' => '{{WRAPPER}} .theplus-switcher .switch-label-text.switch-label-1',
            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typho_b_label',
                'label' => esc_html__('Label 2 Typography', 'theplus'),
                'selector' => '{{WRAPPER}} .theplus-switcher .switch-label-text.switch-label-2',
            ]
        );
		$this->end_controls_section();
		//start switcher underlines
		$this->start_controls_section(
            'section_switcher_underline_styling',
            [
                'label' => esc_html__('Switcher Underline', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'switcher_style' => 'style-3',
				],
            ]
        );
		$this->add_control(
			'underline_color',
			[
				'label' => esc_html__( 'Underline Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-switcher .switcher-toggle.style-3 .st-pricing-underlines .st-pricing-underlines-2' => 'background: linear-gradient(to right,rgba(0,227,246,.04) 0%,{{VALUE}} 50%,rgba(255,255,255,.1) 100%)',
				],
			]
		);
		$this->add_control(
			'line_bottom_offset',
			[
				'label' => esc_html__( 'Bottom Offset', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 70,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-switcher .switcher-toggle.style-3 .st-pricing-underlines .st-pricing-underlines-2' => 'bottom: -{{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'underline_height',
			[
				'label' => esc_html__( 'Height', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-switcher .switcher-toggle.style-3 .st-pricing-underlines-2' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'content_underline_position',
			[
				'label' => esc_html__( 'Content Position', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_underline_position' );
		$this->start_controls_tab(
			'tab_underline_content_1',
			[
				'label' => esc_html__( 'Content 1', 'theplus' ),
			]
		);
		$this->add_responsive_control(
			'underline_pos_content1',
			[
				'label' => esc_html__( 'Position', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-switcher .fieldset .switcher-toggle.style-3.inactive .st-pricing-underlines-2' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_underline_content_2',
			[
				'label' => esc_html__( 'Content 2', 'theplus' ),
			]
		);
		$this->add_responsive_control(
			'underline_pos_content2',
			[
				'label' => esc_html__( 'Position', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-switcher .fieldset .switcher-toggle.style-3.active .st-pricing-underlines-2' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		//end switcher underlines
		$this->start_controls_section(
            'section_content_1_styling',
            [
                'label' => esc_html__('WYSIWYG Content 1', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'content_a_source' => 'content',
				],
            ]
        );
		$this->add_control(
            'content_section_a_color',
            [
                'label' => esc_html__('Content 1 Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#313131',
                'selectors' => [
					'{{WRAPPER}} .theplus-switcher .switcher-toggle-sections .content-1,{{WRAPPER}} .theplus-switcher .switcher-toggle-sections .content-1 p' => 'color:{{VALUE}};',
                ],
				'condition' => [
					'content_a_source' => 'content',
				],
            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_section_a',
                'label' => esc_html__('Content Section 1 Typography', 'theplus'),
				'separator' => 'before',
                'selectors' => '{{WRAPPER}} .theplus-switcher .switcher-toggle-sections .content-1',
				'condition' => [
					'content_a_source' => 'content',
				],
            ]
        );
		$this->end_controls_section();
		$this->start_controls_section(
            'section_content_2_styling',
            [
                'label' => esc_html__('WYSIWYG Content 2', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'content_b_source' => 'content',
				],
            ]
        );
		$this->add_control(
            'content_section_b_color',
            [
                'label' => esc_html__('Content 2 Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#313131',
                 'selectors' => [
					'{{WRAPPER}} .theplus-switcher .switcher-toggle-sections .content-2,{{WRAPPER}} .theplus-switcher .switcher-toggle-sections .content-2 p' => 'color:{{VALUE}};',
                ],
				'condition' => [
					'content_b_source' => 'content',
				],
            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_section_b',
                'label' => esc_html__('Content Section 2 Typography', 'theplus'),
                'selectors' => '{{WRAPPER}} .theplus-switcher .switcher-toggle-sections .content-2',
				'condition' => [
					'content_b_source' => 'content',
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
		$switch_a_title = $settings['switch_a_title'];
		$switch_b_title = $settings['switch_b_title'];
		$switcher_style = $settings['switcher_style'];
		$switch_align = $settings['switch-align'];
		
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
			$uid=uniqid("switch");
			
			if(!empty($settings["switcher_unique_id"])){
				$uid="tpca_".$settings["switcher_unique_id"];
			}
			
			$switcher ='<div id="'.esc_attr($uid).'" class="theplus-switcher switch-1 '.$animated_class.'" '.$animation_attr.' data-id="'.esc_attr($uid).'" >';
					$switcher .='<div class="switcher-toggle inactive '.$switch_align.' '.esc_attr($switcher_style).'">';
						if($switcher_style=='style-1' || $switcher_style=='style-2' || $switcher_style=='style-3' || $switcher_style=='style-4'){					
							$switcher .='<div class="switch-1">
								<h5 class="switch-label-text switch-label-1">'.esc_html($switch_a_title).'</h5>
							</div>';
							$switcher .='<div class="switcher-button" data-type="'.esc_attr($switcher_style).'">
								<label class="switch-label-btn"><input class="switch-toggle round-'.esc_attr($switcher_style).'" type="checkbox"><span class="switch-slider '.esc_attr($switcher_style).' switch-round"></span></label>
							</div>';
							$switcher .='<div class="switch-2">
								<h5 class="switch-label-text switch-label-2">'.esc_html($switch_b_title).'</h5>
							</div>';
							if($switcher_style=='style-3'){
								$switcher .='<div class="st-pricing-underlines">
								<div class="st-pricing-underlines-2"></div>
								</div>';									
							}
						}
					$switcher .='</div>';
				$switcher .='<div class="switcher-toggle-sections">';
					$switcher .='<div class="switcher-section-1" style="display: block;">';
						if($settings["content_a_source"]=='content' && !empty($settings["content_a_desc"])){
							$switcher .='<div class="content-1">';
								$switcher .= $settings["content_a_desc"];
							$switcher .= '</div>';	
						}
						if($settings["content_a_source"]=='template' && !empty($settings["content_a_template"])){
							$switcher .= Theplus_Element_Load::elementor()->frontend->get_builder_content_for_display( $settings['content_a_template'] );
						}
						
					$switcher .='</div>';
					$switcher .='<div class="switcher-section-2" style="display: none;">';
						if($settings["content_b_source"]=='content' && !empty($settings["content_b_desc"])){
							$switcher .='<div class="content-2">';
								$switcher .= $settings["content_b_desc"];
							$switcher .= '</div>';							
						}
						if($settings["content_b_source"]=='template'){
							$switcher .= Theplus_Element_Load::elementor()->frontend->get_builder_content_for_display( $settings['content_b_template'] );
						}
						
					$switcher .='</div>';
				$switcher .='</div>';
			$switcher .='</div>';				
			$css_rule ='';
			if($settings["show_switcher_button"]!='yes'){
				$css_rule .='<style>#'.esc_attr($uid).' .switcher-toggle{display:none;}</style>';
			}
		echo $css_rule.$before_content.$switcher.$after_content;
	}
    protected function content_template() {
	
    }

}
