<?php 
/*
Widget Name: Advertisement Banner
Description: Advertisement Banner
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


class ThePlus_Advertisement_Banner extends Widget_Base {
		
	public function get_name() {
		return 'tp_advertisement_banner';
	}

    public function get_title() {
        return esc_html__('Advertisement Banner', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-file-text theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-creatives');
    }

    protected function _register_controls() {
	$this->start_controls_section(
			'section_advertisement_banner',
			[
				'label' => esc_html__( 'Advertisement Banner', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
	);
	//start main style
	$this->add_control(
		'add_style',
		[
			'label' => esc_html__( 'Styles', 'theplus' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'style-1',
			'options' => [
				'style-1'  => esc_html__( 'Style 1', 'theplus' ),
				'style-2'  => esc_html__( 'Style 2', 'theplus' ),
				'style-3'  => esc_html__( 'Style 3', 'theplus' ),
				'style-4'  => esc_html__( 'Style 4', 'theplus' ),
				'style-5'  => esc_html__( 'Style 5', 'theplus' ),
				'style-6'  => esc_html__( 'Style 6', 'theplus' ),
				'style-7'  => esc_html__( 'Style 7', 'theplus' ),
				'style-8'  => esc_html__( 'Style 8', 'theplus' ),
				
			],
		]
	);
	//end main style
	//start banner image
	$this->add_control(
		'banner_img',
		[
			'label' => esc_html__( 'Banner Image', 'theplus' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			],
			'dynamic' => [
				'active' => true,
			],
		]
	);
	$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'banner_img_thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
			]
		);
	//end banner image
	//start titile
	$this->add_control(
		'title',
		[
			'label' => esc_html__( 'Title', 'theplus' ),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__( 'This Is Title', 'theplus' ),
			'separator' => 'before',
			'dynamic' => [
					'active'   => true,
			],
		]
	);
	//end titile
	//start subtitile
	$this->add_control(
		'subtitle',
		[
			'label' => esc_html__( 'SubTitle', 'theplus' ),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__( 'This Is Subtitle', 'theplus' ),
			'separator' => 'before',
			'dynamic' => [
					'active'   => true,
			],
		]
	);
	//start subtitile	
	//start hover style
	$this->add_control(
		'hov_styles',
		[
			'label' => esc_html__( 'Hover Styles', 'theplus' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'addbanner-image-blur',
			'options' => [
				'addbanner-image-blur' => esc_html__( 'Blur Effect', 'theplus' ),
				'simple' => esc_html__( 'Simple', 'theplus' ),
				'addbanner-image-vertical' => esc_html__( 'Vertical', 'theplus' ),
				'hover-tilt' => esc_html__( 'Parallax', 'theplus' ),				
			],
			'condition'    => [
				'add_style' => [ 'style-1','style-2','style-3','style-4','style-5','style-6','style-7' ],
			],
		]
	);
	//end hover style
	$this->end_controls_section();
	$this->start_controls_section(
			'section_advertisement_button',
			[
				'label' => esc_html__( 'Button', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
	);	
	//start button
	$this->add_control(
			'display_button',
			[
				'label' => esc_html__( 'Button', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',
				
			]
		);
		$this->add_control(
            'button_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Button Style', 'theplus'),
                'default' => 'style-7',
                'options' => [
                    'style-1' => esc_html__('Style 1', 'theplus'),
                    'style-2' => esc_html__('Style 2', 'theplus'),
                    'style-3' => esc_html__('Style 3', 'theplus'),
                    'style-4' => esc_html__('Style 4', 'theplus'),
                    'style-5' => esc_html__('Style 5', 'theplus'),
                    'style-6' => esc_html__('Style 6', 'theplus'),
                    'style-7' => esc_html__('Style 7', 'theplus'),
					'style-8' => esc_html__('Style 8', 'theplus'),
					'style-9' => esc_html__('Style 9', 'theplus'),
					'style-10' => esc_html__('Style 10', 'theplus'),
					'style-11' => esc_html__('Style 11', 'theplus'),
					'style-12' => esc_html__('Style 12', 'theplus'),
					'style-13' => esc_html__('Style 13', 'theplus'),
					'style-14' => esc_html__('Style 14', 'theplus'),
					'style-15' => esc_html__('Style 15', 'theplus'),
					'style-16' => esc_html__('Style 16', 'theplus'),
					'style-17' => esc_html__('Style 17', 'theplus'),
					'style-18' => esc_html__('Style 18', 'theplus'),
					'style-19' => esc_html__('Style 19', 'theplus'),
					'style-20' => esc_html__('Style 20', 'theplus'),
					'style-21' => esc_html__('Style 21', 'theplus'),
					'style-22' => esc_html__('Style 22', 'theplus'),                    
                ],
				'condition' => [				
					'display_button' => 'yes',
				],
            ]
        );
		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Read More', 'theplus' ),
				'placeholder' => esc_html__( 'Read More', 'theplus' ),
				'condition' => [				
					'display_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_hover_text',
			[
				'label' => esc_html__( 'Hover Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Click Here', 'theplus' ),
				'placeholder' => esc_html__( 'Click Here', 'theplus' ),
				'condition' => [
					'button_style' => ['style-4','style-11','style-14'],
					'display_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button Link', 'theplus' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'theplus' ),
				'default' => [
					'url' => '#',
				],
				'condition' => [				
					'display_button' => 'yes',
				],
			]
		);
		$this->add_control(
            'icon_hover_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Icon Hover Style', 'theplus'),
                'default' => 'hover-top',
                'options' => [
                    'hover-top' => esc_html__('On Top', 'theplus'),
                    'hover-bottom' => esc_html__('On Bottom', 'theplus'),
                ],
				'condition' => [
					'button_style' => ['style-17'],
					'display_button' => 'yes',
				],
				'separator' => 'before',
            ]
        );
		$this->add_control(
			'button_icon_style',
			[
				'label' => esc_html__( 'Icon Font', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome', 'theplus' ),
					'icon_mind' => esc_html__( 'Icons Mind', 'theplus' ),
				],
				'condition' => [
					'button_style!' => ['style-3','style-6','style-7','style-9'],
					'display_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Icon', 'theplus' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-chevron-right',
				'condition' => [
					'button_style!' => ['style-3','style-6','style-7','style-9'],
					'button_icon_style' => 'font_awesome',
					'display_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_icons_mind',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '',
				'label_block' => true,
				'options' => theplus_icons_mind(),
				'condition' => [
					'button_style!' => ['style-3','style-6','style-7','style-9'],
					'button_icon_style' => 'icon_mind',
					'display_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'before_after',
			[
				'label' => esc_html__( 'Icon Position', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => [
					'after' => esc_html__( 'After', 'theplus' ),
					'before' => esc_html__( 'Before', 'theplus' ),
				],
				'condition' => [
					'button_style!' => ['style-3','style-6','style-7','style-9','style-17'],
					'button_icon_style!' => '',
					'display_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Icon Spacing', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'condition' => [
					'button_style!' => ['style-3','style-6','style-7','style-9','style-17'],
					'button_icon_style!' => '',
					'display_button' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .button-link-wrap i.button-after' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .button-link-wrap i.button-before' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap .btn-icon.button-before' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap .btn-icon.button-after' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'separator' => 'before',
				'condition' => [
					'button_style!' => ['style-3','style-6','style-7','style-9','style-17'],
					'button_icon_style!' => '',
					'display_button' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .button-link-wrap i.btn-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
	$this->end_controls_section();
	/*Start Style Tag */
	/*Start title Style */
	$this->start_controls_section(
			'adv_banner_title_style',
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
			'selector' => '{{WRAPPER}} .pt_plus_addbanner .addbanner-block .addbanner_inner .addbanner_title,{{WRAPPER}} .pt_plus_addbanner .addbanner_product_box .addbanner_title',
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
		'title_color_normal',
		[
			'label' => esc_html__( 'Title Color', 'theplus' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#313131',
			'scheme' => [
				'type' => \Elementor\Scheme_Color::get_type(),
				'value' => \Elementor\Scheme_Color::COLOR_1,
			],
			'selectors' => [
				'{{WRAPPER}} .pt_plus_addbanner .addbanner-block .addbanner_inner .addbanner_title,
				{{WRAPPER}} .pt_plus_addbanner .addbanner_product_box .addbanner_title' => 'color: {{VALUE}}',
			],
		]
	);	
	$this->end_controls_tab();
	$this->start_controls_tab(
		'tab_title_hover',
		[
			'label' => esc_html__( 'Hover', 'theplus' ),
		]
	);
	$this->add_control(
		'title_color_hover',
		[
			'label' => esc_html__( 'Title Hover Color', 'theplus' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#313131',
			'scheme' => [
				'type' => \Elementor\Scheme_Color::get_type(),
				'value' => \Elementor\Scheme_Color::COLOR_1,
			],
			'selectors' => [
				'{{WRAPPER}} .pt_plus_addbanner:hover .addbanner-block .addbanner_inner .addbanner_title,
				{{WRAPPER}} .pt_plus_addbanner:hover .addbanner_product_box .addbanner_title' => 'color: {{VALUE}}',
			],
		]
	);
	$this->end_controls_tab();
	$this->end_controls_tabs();
	$this->end_controls_section();
	/*end title Style */
	/*Start subtitle Style */
	$this->start_controls_section(
			'adv_banner_subtitle_style',
			[
				'label' => esc_html__( 'Subitle Style', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
	);
	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'subtitle_typography',
			'label' => esc_html__( 'Typography', 'theplus' ),
			'selector' => '{{WRAPPER}} .pt_plus_addbanner .addbanner-block .addbanner_inner .addbanner_subtitle,{{WRAPPER}} .pt_plus_addbanner .addbanner_product_box .addbanner_subtitle',
		]
	);
	$this->start_controls_tabs( 'tabs_subtitle_style' );
	$this->start_controls_tab(
		'tab_subtitle_normal',
		[
			'label' => esc_html__( 'Normal', 'theplus' ),
		]
	);	
	$this->add_control(
		'subtitle_color_normal',
		[
			'label' => esc_html__( 'Subtitle Color', 'theplus' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#313131',
			'scheme' => [
				'type' => \Elementor\Scheme_Color::get_type(),
				'value' => \Elementor\Scheme_Color::COLOR_1,
			],
			'selectors' => [
				'{{WRAPPER}} .pt_plus_addbanner .addbanner-block .addbanner_inner .addbanner_subtitle,
				{{WRAPPER}} .pt_plus_addbanner .addbanner_product_box .addbanner_subtitle' => 'color: {{VALUE}}',
			],
		]
	);	
	$this->end_controls_tab();
	$this->start_controls_tab(
		'tab_subtitle_hover',
		[
			'label' => esc_html__( 'Hover', 'theplus' ),
		]
	);
	$this->add_control(
		'subtitle_color_hover',
		[
			'label' => esc_html__( 'Subtitle Hover Color', 'theplus' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#313131',
			'scheme' => [
				'type' => \Elementor\Scheme_Color::get_type(),
				'value' => \Elementor\Scheme_Color::COLOR_1,
			],
			'selectors' => [
				'{{WRAPPER}} .pt_plus_addbanner:hover .addbanner-block .addbanner_inner .addbanner_subtitle,
				{{WRAPPER}} .pt_plus_addbanner:hover .addbanner_product_box .addbanner_subtitle' => 'color: {{VALUE}}',
			],
		]
	);	
	
	$this->end_controls_tab();
	$this->end_controls_tabs();
	$this->end_controls_section();
	/*end subtitle Style */
	/*button style*/
		$this->start_controls_section(
            'section_button_styling',
            [
                'label' => esc_html__('Button Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'display_button' => 'yes',
				],
            ]
        );
		$this->add_control(
            'button_top_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Button Above Space', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_addbanner .pt-plus-button-wrapper .ts-button' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'after',
				'condition' => [
					'display_button' => 'yes',
				],
            ]
        );
		$this->add_responsive_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button .button-link-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
				'condition' => [
					'display_button' => 'yes',
				],
			]
		);
		$this->add_control(
            'btn_hover_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Button Style', 'theplus'),
                'default' => 'hover-left',
                'options' => [
                    'hover-left' => esc_html__('On Left', 'theplus'),
                    'hover-right' => esc_html__('On Right', 'theplus'),
                    'hover-top' => esc_html__('On Top', 'theplus'),
                    'hover-bottom' => esc_html__('On Bottom', 'theplus'),
                ],
				'condition' => [
					'button_style' => ['style-11','style-13'],
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .pt_plus_button .button-link-wrap',
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
					'{{WRAPPER}} .pt_plus_button .button-link-wrap' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pt_plus_button.button-style-3 .button-link-wrap .arrow *' => 'fill: {{VALUE}};stroke: {{VALUE}};',
					'{{WRAPPER}} .pt_plus_button.button-style-7 .button-link-wrap:after' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_button.button-style-2 .button-link-wrap i,
								{{WRAPPER}} .pt_plus_button.button-style-3 a.button-link-wrap:before,
								{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-5 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-10 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-15 .button-link-wrap::before,{{WRAPPER}} .pt_plus_button.button-style-15 .button-link-wrap::after,
								{{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap::after,
								{{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-18 .button-link-wrap::after,
								{{WRAPPER}} .pt_plus_button.button-style-19 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-21 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap',				
				'condition' => [
					'button_style!' => ['style-1','style-6','style-7','style-9','style-12','style-13'],
				],
			]
		);
		$this->add_control(
			'button_border_style',
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
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-5 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-10 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-19 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-21 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'button_style' => ['style-4','style-5','style-8','style-10','style-11','style-12','style-13','style-14','style-16','style-17','style-19','style-20','style-21','style-22'],
				],
			]
		);

		$this->add_responsive_control(
			'button_border_width',
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
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-5 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-10 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap::before,{{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-19 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-21 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-4','style-5','style-8','style-10','style-11','style-12','style-13','style-14','style-16','style-17','style-19','style-20','style-21','style-22'],
					'button_border_style!' => 'none',
				]
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#313131',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-5 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-10 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-19 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-21 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .pt_plus_button.button-style-18 .button-link-wrap' => 'background: {{VALUE}};',
				],
				'condition' => [
					'button_style' => ['style-4','style-5','style-8','style-10','style-11','style-12','style-13','style-14','style-16','style-17','style-18','style-19','style-20','style-21','style-22'],
					'button_border_style!' => 'none'
				],
			]
		);

		$this->add_responsive_control(
			'button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-10 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-18 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-18 .button-link-wrap::after,{{WRAPPER}} .pt_plus_button.button-style-19 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-21 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-4','style-8','style-10','style-11','style-12','style-13','style-14','style-16','style-17','style-19','style-20','style-21','style-22'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_button.button-style-2 .button-link-wrap i,
							   {{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-5 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-10 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-15 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-18 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-19 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-21 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap',
				'condition' => [
					'button_style' => ['style-2','style-4','style-5','style-8','style-10','style-11','style-12','style-13','style-14','style-15','style-16','style-17','style-18','style-19','style-20','style-21','style-22'],
				],
			]
		);
		$this->add_control(
			'btn_bottom_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'button_style' => 'style-1',
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button .button-link-wrap .button_line' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
            'bottom_border_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Border Height', 'theplus'),
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min'	=> 1,
						'max'	=> 20,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'button_style' => 'style-1',
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button .button-link-wrap .button_line' => 'height: {{SIZE}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .pt_plus_button .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap .btn-icon,{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap .btn-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap::before,{{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap::after' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pt_plus_button.button-style-3 .button-link-wrap:hover .arrow-1 *' => 'fill: {{VALUE}};stroke: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_button.button-style-2 .button-link-wrap:hover i,
								{{WRAPPER}} .pt_plus_button.button-style-3 .button-link-wrap:hover:before,
								{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap::after,
								{{WRAPPER}} .pt_plus_button.button-style-5 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-5 .button-link-wrap:before,{{WRAPPER}} .pt_plus_button.button-style-5 .button-link-wrap:after,
								{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover,
								{{WRAPPER}} .pt_plus_button.button-style-10 .button-link-wrap:hover,
								{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap::before,
								{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap::before,
								{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap::before,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap::after,
								{{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap:hover,
								{{WRAPPER}} .pt_plus_button.button-style-15 .button-link-wrap:hover::after,
								{{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap::before,
								{{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap::before,
								{{WRAPPER}} .pt_plus_button.button-style-18 .button-link-wrap:hover::after,
								{{WRAPPER}} .pt_plus_button.button-style-19 .button-link-wrap:after,
								{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap:after,
								{{WRAPPER}} .pt_plus_button.button-style-21 .button-link-wrap:after,
								{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap:hover',
				'condition' => [
					'button_style!' => ['style-1','style-6','style-7','style-9'],
				],
			]
		);
		$this->add_control(
			'button_border_hover_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#313131',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-5 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-10 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap::before,{{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-19 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-21 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .pt_plus_button.button-style-18 .button-link-wrap::before' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'button_style' => ['style-4','style-5','style-8','style-10','style-11','style-12','style-13','style-14','style-16','style-17','style-18','style-19','style-20','style-21','style-22'],
					'button_border_style!' => 'none'
				],
			]
		);

		$this->add_responsive_control(
			'button_hover_radius',
			[
				'label'      => esc_html__( 'Hover Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-10 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-19 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-21 .button-link-wrap:hover,{{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-4','style-8','style-10','style-11','style-12','style-13','style-14','style-16','style-17','style-19','style-20','style-21','style-22'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_button.button-style-2 .button-link-wrap:hover i,
							   {{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-5 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-10 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-14 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-15 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-16 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-17 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-18 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-19 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-21 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-22 .button-link-wrap:hover',
				'condition' => [
					'button_style' => ['style-2','style-4','style-5','style-8','style-10','style-11','style-12','style-13','style-14','style-15','style-16','style-17','style-18','style-19','style-20','style-21','style-22'],
				],
			]
		);
		$this->add_control(
			'btn_bottom_border_hover_color',
			[
				'label' => esc_html__( 'Border Hover Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'button_style' => 'style-1',
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button .button-link-wrap:hover .button_line' => 'background: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->end_controls_tabs();
		
		$this->add_control(
			'button_main_background',
			[
				'label' => esc_html__( 'Background Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#676767',
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_addbanner.add-banner-style-8 .addbanner_product_box .ab_btn_back' => 'background: {{VALUE}}',
				],
				'condition'    => [
				'add_style' => [ 'style-8' ],
				],
				
			]
		);
		$this->end_controls_section();
		/*button style*/
	/*Start animation_settings  */
	$this->start_controls_section(
			'section_animation_settings',
			[
				'label' => esc_html__( 'Animation Settings', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
	);
	$this->add_control(
		'content_hover_effects',
		[
			'label' => esc_html__( 'Content Hover Effects', 'theplus' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => theplus_get_content_hover_effect_options(),
			'separator' => 'before',						
		]
	);
	$this->add_control(
			'hover_shadow_color',
			[
				'label' => esc_html__( 'Shadow Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0, 0, 0, 0.6)',				
				'selectors'  => [
					'{{WRAPPER}} .pt-plus-food-menu.food-menu-style-3 .food-flex-line .food-menu-divider .menu-divider' => 'border-color: {{VALUE}};',
				],
				'condition' => [
				'content_hover_effects' => ['float_shadow','grow_shadow','shadow_radial'],				 	
			],
				
			]
		);
	$this->end_controls_section();
	/*Start animation_settings  */
	$this->start_controls_section(
			'boxshadow_setting',
			[
				'label' => esc_html__( 'Background Setting', 'theplus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
	);	
	$this->start_controls_tabs( 'tabs_box_shadow_style' );
		$this->start_controls_tab(
			'tab_box_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);	
			$this->add_responsive_control(
			'content_background_border_radious',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_addbanner .addbanner-block,{{WRAPPER}} .pt_plus_addbanner .addbanner_inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'add_style!' => ['style-8'],
				],
			]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'content_background_shadow_normal',
					'selector' => '{{WRAPPER}} .pt_plus_addbanner .addbanner-block',
				]
			);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_box_shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);	
			$this->add_control(
			'background_overlay_heading',
			[
				'label' => esc_html__( 'Background Overlay', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,				
			]
			);
			$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_overlay',
				'label' => esc_html__( 'Background Overlay', 'theplus' ),
				'types' => [ 'classic', 'gradient'],				
				'selector' => '{{WRAPPER}} .pt_plus_addbanner .entry-thumb .entry-hover:before',
			]
			);
			$this->add_responsive_control(
			'content_background_border_radious_hover',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_addbanner .addbanner-block:hover,{{WRAPPER}} .pt_plus_addbanner .addbanner_inner:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'content_background_shadow_hover',
					'selector' => '{{WRAPPER}} .pt_plus_addbanner .addbanner-block:hover',
				]
			);
		$this->end_controls_tab();
	$this->end_controls_tabs();	
	$this->end_controls_section();
	/*end Box Shadow  */
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
		$add_style = $settings['add_style'];
		$content_hover_effects = $settings['content_hover_effects'];
		$hov_styles = $settings['hov_styles'];
		
		$hover_class=$hover_attr=$data_class=$button_hover_text='';
		
		$hover_uniqid = uniqid('hover-effect');
		if ($content_hover_effects == "float_shadow" || $content_hover_effects == "grow_shadow" || $content_hover_effects == "shadow_radial") {
			$hover_attr .= 'data-hover_uniqid="' . esc_attr($hover_uniqid) . '" ';
			$hover_attr .= ' data-hover_shadow="' . esc_attr($settings['hover_shadow_color']) . '" ';
			$hover_attr .= ' data-content_hover_effects="' . esc_attr($content_hover_effects) . '" ';
		}
		if ($content_hover_effects == "grow") {
			$hover_class .= 'content_hover_grow';
		} elseif ($content_hover_effects == "push") {
			$hover_class .= 'content_hover_push';
		} elseif ($content_hover_effects == "bounce-in") {
			$hover_class .= 'content_hover_bounce_in';
		} elseif ($content_hover_effects == "float") {
			$hover_class .= 'content_hover_float';
		} elseif ($content_hover_effects == "wobble_horizontal") {
			$hover_class .= 'content_hover_wobble_horizontal';
		} elseif ($content_hover_effects == "wobble_vertical") {
			$hover_class .= 'content_hover_wobble_vertical';
		} elseif ($content_hover_effects == "float_shadow") {
			$hover_class .= ' ' . esc_attr($hover_uniqid) . ' content_hover_float_shadow';
		} elseif ($content_hover_effects == "grow_shadow") {
			$hover_class .= ' ' . esc_attr($hover_uniqid) . ' content_hover_grow_shadow';
		} elseif ($content_hover_effects == "shadow_radial") {
			$hover_class .= '' . esc_attr($hover_uniqid) . ' content_hover_radial';
		}
		
		$banner_subtitle=$banner_title=$text_alignment=$content_alignment=$parralex_attr=$hover_clss='';

		if($hov_styles == "addbanner-image-blur") {
			$hover_clss = 'addbanner-image-blur';
		}else if($hov_styles == "addbanner-image-vertical"){
			$hover_clss = 'addbanner-image-vertical';
		}else if($hov_styles == "hover-tilt"){
			$hover_clss = 'hover-tilt';
		}
		/*-------------------------------------------------------------------*/
		
		/*-------------------------------------------------------------------*/
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
		
		$rand_no=rand(1000000, 1500000);
		$data_class=$add_image=$style_content=$icons_before=$icons_after='';
		
		if(!empty($settings['banner_img']['url'])){			
			if($settings['banner_img']['url']== \Elementor\Utils::get_placeholder_image_src()){
				$img = $settings['banner_img']['url'];
			}else{				
				$banner_img=$settings['banner_img']['id'];
				$imgSrc = wp_get_attachment_image_src($banner_img,$settings['banner_img_thumbnail_size']);
				$img = $imgSrc[0];
			}
			
			$image_id=$settings["banner_img"]["id"];
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
			if(!$image_alt){
				$image_alt = get_the_title($image_id);
			}else if(!$image_alt){
				$image_alt = 'Plus adv banner';
			}
			$add_image ='<img class="info_img " src="'.esc_url($img).'" alt="'.esc_attr($image_alt).'">';
		}
		
		$the_button='';
		if($settings['display_button'] == 'yes'){
			if ( ! empty( $settings['button_link']['url'] ) ) {
				$this->add_render_attribute( 'button', 'href', $settings['button_link']['url'] );
				if ( $settings['button_link']['is_external'] ) {
					$this->add_render_attribute( 'button', 'target', '_blank' );
				}
				if ( $settings['button_link']['nofollow'] ) {
					$this->add_render_attribute( 'button', 'rel', 'nofollow' );
				}
			}
			$this->add_render_attribute( 'button', 'class', 'button-link-wrap' );
			$hover_box_class = (!empty($settings["hover_info_button"]) && $settings["hover_info_button"]=='yes') ? ' hover_box_button' : '';
			$this->add_render_attribute( 'button', 'class', $hover_box_class );
			$this->add_render_attribute( 'button', 'role', 'button' );
			
			if(!empty($settings['button_hover_text'])){
			$this->add_render_attribute( 'button', 'data-hover', $settings['button_hover_text'] );
			}else{
				$this->add_render_attribute( 'button', 'data-hover', $settings['button_text'] );
			}
			
			$button_style = $settings['button_style'];
			$button_text = $settings['button_text'];
			$button_hover_text = $settings['button_hover_text'];
			$btn_hover_style = $settings['btn_hover_style'];
			$icon_hover_style = $settings['icon_hover_style'];
			$btn_uid=uniqid('btn');
			$data_class= $btn_uid;
			$data_class .=' button-'.$button_style.' ';
			
			if($button_style=='style-11' || $button_style=='style-13'){
			$data_class .=' '.$btn_hover_style.' ';
			}
			if($button_style=='style-17'){
				$data_class .=' '.$icon_hover_style.' ';
			}
			
			$the_button ='<div class="pt-plus-button-wrapper">';
				$the_button .='<div class="button_parallax">';
					$the_button .='<div class="ts-button">';
						$the_button .='<div class="pt_plus_button '.$data_class.'">';
							$the_button .= '<div class="animted-content-inner">';
								$the_button .='<a '.$this->get_render_attribute_string( "button" ).'>';
								$the_button .= $this->render_text();
								$the_button .='</a>';
							$the_button .='</div>';
						$the_button .='</div>';
					$the_button .='</div>';
				$the_button .='</div>';
			$the_button .='</div>';
		}
				
		/*-------------------------------------------------------------------*/
			if($add_style== "style-1" || $add_style== "style-2" || $add_style== "style-3" ){
				$text_alignment .= 'text-left';

			}
			if($add_style== "style-4" || $add_style== "style-5" || $add_style== "style-6" ){
				$text_alignment .= 'text-right';
			}
			if($add_style== "style-7"){
				$text_alignment .= 'text-center';
			}
			/*-------------------------------------------------------------------*/
			if($add_style== "style-1"){
				$content_alignment .= 'top-left';
			}
			if($add_style== "style-2" || $add_style== "style-7"){
				$content_alignment .= 'center-left';
			}
			if($add_style== "style-3"){   
				$content_alignment .= 'bottom-left';
			}
			if($add_style== "style-4"){
				$content_alignment .= 'top-right';
			}
			if($add_style== "style-5"){
				$content_alignment .= 'center-right';
			}
			if($add_style== "style-6"){   
				$content_alignment .= 'bottom-right';
			}
			
		$start_atag = $end_atag ='';
		if($settings['display_button'] == 'yes'){
			if ( ! empty( $settings['button_link']['url'] ) ) {
				$this->add_render_attribute( 'title_link', 'href', $settings['button_link']['url'] );
				if ( $settings['button_link']['is_external'] ) {
					$this->add_render_attribute( 'title_link', 'target', '_blank' );
				}
				if ( $settings['button_link']['nofollow'] ) {
					$this->add_render_attribute( 'title_link', 'rel', 'nofollow' );
				}
				$start_atag = '<a '.$this->get_render_attribute_string( "title_link" ).'>';
				$end_atag = '</a>';
			}
		}
		
		if(!empty($settings['title'])){
			$banner_title = $start_atag.'<h3 class="addbanner_title">'.esc_html($settings['title']).'</h3>'.$end_atag;
		}
		if(!empty($settings['subtitle'])){
			$banner_subtitle = '<h4 class="addbanner_subtitle">'.esc_html($settings['subtitle']).'</h4>';
		}
		
		$uid=uniqid('add-banner');
		
		$add_banner = '<div class="content_hover_effect ' . esc_attr($hover_class) . ' " ' . $hover_attr . '>';
		$add_banner .='<div class="pt_plus_addbanner add-banner-'.$add_style.' '.$hover_clss.' addbanner-fade-out image-loaded box_saddow_addbanner '.esc_attr($uid).'  '.esc_attr($animated_class).' " '.$animation_attr.'> ';
		
		if($add_style != "style-8"){

				$add_banner .='<div class="addbanner-block" >';  
					$add_banner .='<div class="addbanner_inner '.esc_attr($text_alignment).'">'; 
						$add_banner .='<div class="'.esc_attr($content_alignment).'">';
							$add_banner .='<div class="content-level2">';
								$add_banner .='<div class="content-level3">';
									$add_banner .=$banner_subtitle;
							            $add_banner .=$banner_title;
										if($settings['display_button'] == 'yes'){
											$add_banner .=$the_button;
										};
						$add_banner .='</div>';
							$add_banner .='</div>';
						$add_banner .='</div>';
						$add_banner .='<div class="addbanner_inner_img ">';
							$add_banner .=$add_image; 
						$add_banner .='</div>';
					$add_banner .='<div class="entry-thumb">'; 
						$add_banner .='<div class="entry-hover">';
						$add_banner .='</div>';
					$add_banner .='</div>';      
				 $add_banner .='</div>';
				$add_banner .='</div>';

			}else{
				$featured_image =$full_image= '';
					if ($settings['banner_img']['url'] != '' ) {
							if($settings['banner_img']['url']== \Elementor\Utils::get_placeholder_image_src()){
								$full_image=$settings['banner_img']['url'];
							}else{				
								$banner_img=$settings['banner_img']['id'];
								$imgSrc = wp_get_attachment_image_src($banner_img,$settings['banner_img_thumbnail_size']);
								$full_image = $imgSrc[0];
							}
							
					}else{ 
							//$featured_image = pt_plus_loading_image_grid('','background');
							$full_image = THEPLUS_ASSETS_URL.'images/placeholder-grid.jpg';
					}
					$add_banner .='<div class="addbanner_product_box">';
						$add_banner .= '<div class="addbanner_product_box_wrapper" style="background:url('.$full_image.') #f7f7f7;">';
							$add_banner .= '<div class="ad-banner-img-hide"> '.$add_image.' </div>';
							$add_banner .='<div class="addbanner_content">';
								$add_banner .=$banner_title;
								$add_banner .=$banner_subtitle;
							$add_banner .='</div>'; 
						$add_banner .='</div>';
			           if($settings['display_button'] == 'yes'){
							$add_banner .='<div class="ab_btn_back ">'.$the_button.'</div>';
							}else{
							$add_banner .='<div class="ab_btn_back "></div>';
							}
					$add_banner .='</div>'; 
				 
			}
			$add_banner .='</div>';
			$add_banner .='</div>'; 			
			echo $before_content.$add_banner.$after_content;
	}
	
    protected function content_template() {
		
    }
	protected function render_text() {	
		$icons_after=$icons_before=$button_text=$style_content='';
		$settings = $this->get_settings_for_display();
		
		$button_style = $settings['button_style'];
		$before_after = $settings['before_after'];
		$button_text = $settings['button_text'];
		
		if($settings["button_icon_style"]=='font_awesome'){
			$icons=$settings["button_icon"];
		}else if($settings["button_icon_style"]=='icon_mind'){
			$icons=$settings["button_icons_mind"];
		}else{
			$icons='';
		}
		
		if($before_after=='before' && !empty($icons)){
			$icons_before = '<i class="btn-icon button-before '.esc_attr($icons).'"></i>';
		}
		if($before_after=='after' && !empty($icons)){
		   $icons_after = '<i class="btn-icon button-after '.esc_attr($icons).'"></i>';
		}
		
		if($button_style=='style-1'){
			$button_text =$icons_before.$button_text . $icons_after;
			$style_content='<div class="button_line"></div>';
		}
		if($button_style=='style-2' || $button_style=='style-5' || $button_style=='style-8' || $button_style=='style-10'){
			$button_text =$icons_before . $button_text . $icons_after;
		}
		if($button_style=='style-3'){
			$button_text =$button_text.'<svg class="arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="48" height="9" viewBox="0 0 48 9"><path d="M48.000,4.243 L43.757,8.485 L43.757,5.000 L0.000,5.000 L0.000,4.000 L43.757,4.000 L43.757,0.000 L48.000,4.243 Z" class="cls-1"></path></svg><svg class="arrow-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="48" height="9" viewBox="0 0 48 9"><path d="M48.000,4.243 L43.757,8.485 L43.757,5.000 L0.000,5.000 L0.000,4.000 L43.757,4.000 L43.757,0.000 L48.000,4.243 Z" class="cls-1"></path></svg>';
		}
		if($button_style=='style-4'){
			$button_text =$icons_before.$button_text . $icons_after;
		}
		if($button_style=='style-6'){
			$button_text =$button_text;
		}
		if($button_style=='style-7'){
			$button_text =$button_text.'<span class="btn-arrow"></span>';
		}
		if($button_style=='style-9'){
			$button_text =$button_text.'<span class="btn-arrow"><i class="fa-show fa fa-chevron-right" aria-hidden="true"></i><i class="fa-hide fa fa-chevron-right" aria-hidden="true"></i></span>';
		}
		if($button_style=='style-11'){
			$button_text ='<span>'.$icons_before . $button_text . $icons_after.'</span>';
		}
		if($button_style=='style-12' || $button_style=='style-15' || $button_style=='style-16'){
			$button_text ='<span>'.$icons_before . $button_text . $icons_after.'</span>';
		}
		if($button_style=='style-13'){
			$button_text ='<span>'.$icons_before . $button_text . $icons_after.'</span>';			
		}
		if($button_style=='style-14'){
			$button_text ='<span>'.$icons_before . $button_text . $icons_after.'</span>';
		}
		if($button_style=='style-17'){
			$icons_before='<i class="btn-icon button-after '.esc_attr($icons).'"></i>';
			$button_text =$icons_before .'<span>'. $button_text .'</span>';		
		}
		if($button_style=='style-18' || $button_style=='style-19' || $button_style=='style-20' || $button_style=='style-21' || $button_style=='style-22'){
			$button_text =$icons_before .'<span>'. esc_html($button_text) .'</span>'. $icons_after;
		}
		return $button_text.$style_content;
	}
}
