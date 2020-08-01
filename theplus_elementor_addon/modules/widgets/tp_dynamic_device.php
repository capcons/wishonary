<?php 
/*
Widget Name: Dynamic Devices
Description: layout of devices isplay content.
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

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Dynamic_Devices extends Widget_Base {
		
	public function get_name() {
		return 'tp-dynamic-device';
	}

    public function get_title() {
        return esc_html__('Dynamic Device', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-laptop theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-creatives');
    }
	
	public function get_keywords() {
		return ['dynamic custom skin', 'dynamic loop', 'loop builder', 'skin builder', 'custom skin', 'post skin', 'post loop','dynamic listing', 'dynamic custom post type listing', 'custom post type listing', 'post type'];
	}
    protected function _register_controls() {
		
		$this->start_controls_section(
			'device_section',
			[
				'label' => esc_html__( 'Content', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'device_mode',
			[
				'label' => esc_html__( 'Layout', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  => esc_html__( 'Normal', 'theplus' ),
					'carousal' => esc_html__( 'Special Carousel', 'theplus' ),
				],
			]
		);
		$this->add_control(
			'device_mockup',
			[
				'label' => esc_html__( 'Type', 'theplus' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'mobile' => [
						'title' => esc_html__( 'Mobile', 'theplus' ),
						'icon' => 'fa fa-mobile',
					],
					'tablet' => [
						'title' => esc_html__( 'Tablet', 'theplus' ),
						'icon' => 'fa fa-tablet',
					],
					'laptop' => [
						'title' => esc_html__( 'Laptop', 'theplus' ),
						'icon' => 'fa fa-laptop',
					],
					'desktop' => [
						'title' => esc_html__( 'Desktop', 'theplus' ),
						'icon' => 'fa fa-desktop',
					],
				],
				'default' => 'laptop',
				'toggle' => true,
				'condition'    => [
					'device_mode' => [ 'normal' ],
				],
			]
		);
		$this->add_control(
			'device_mockup_carousal',
			[
				'label' => esc_html__( 'Type', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'mobile'  => esc_html__( 'Mobile', 'theplus' ),
				],
				'default' => 'mobile',
				'toggle' => true,
				'condition'    => [
					'device_mode' => [ 'carousal' ],
				],
			]
		);
		$this->add_control(
			'device_mobile',
			[
				'label' => esc_html__( 'Mobile Device', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'iphone-white-flat',
				'options' => [
					'iphone-white-flat'  => esc_html__( 'iPhone White (320px x 594px)', 'theplus' ),
					'iphone-x-black' => esc_html__( 'iPhone X Black (320px x 672px)', 'theplus' ),
					'iphone-browser' => esc_html__( 'iPhone Browser (320px x 470px)', 'theplus' ),
					'iphone-minimal' => esc_html__( 'iPhone Minimal (300px x 527px)', 'theplus' ),
					'iphone-minimal-white' => esc_html__( 'iPhone Minimal White (320px x 564px)', 'theplus' ),
					's9-black' => esc_html__( 'S9 Black (320px x 668px)', 'theplus' ),
					's9-jet-black' => esc_html__( 'S9 Jet Black (320px x 672px)', 'theplus' ),
					's9-white' => esc_html__( 'S9 White (320px x 668px)', 'theplus' ),
				],
				'condition'    => [
					'device_mode' => [ 'normal' ],
					'device_mockup' => [ 'mobile' ],
				],
			]
		);
		$this->add_control(
			'device_mobile_carousal',
			[
				'label' => esc_html__( 'Mobile Device', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'iphone-white-flat-carousal',
				'options' => [
					'iphone-white-flat-carousal'  => esc_html__( 'iPhone White (500px x 890px)', 'theplus' ),
				],
				'condition'    => [
					'device_mode' => [ 'carousal' ],
					'device_mockup_carousal' => [ 'mobile' ],
				],
			]
		);
		$this->add_control(
			'device_tablet',
			[
				'label' => esc_html__( 'Tablet Device', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ipad-vertical-white',
				'options' => [
					'ipad-vertical-white'  => esc_html__( 'Ipad Vertical White (480px x 646px)', 'theplus' ),
					'ipad-horizontal-white'  => esc_html__( 'Ipad Horizontal White (470px x 348px)', 'theplus' ),
					'ipad-browser'  => esc_html__( 'Ipad Browser (550px x 625px)', 'theplus' ),
				],
				'condition'    => [
					'device_mode' => [ 'normal' ],
					'device_mockup' => [ 'tablet' ],
				],
			]
		);
		$this->add_control(
			'device_laptop',
			[
				'label' => esc_html__( 'Laptop Device', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'laptop-macbook-black',
				'options' => [
					'laptop-macbook-black'  => esc_html__( 'Macbook Black (800px x 500px)', 'theplus' ),
					'laptop-macbook-minimal'  => esc_html__( 'Macbook Minimal (700px x 414px)', 'theplus' ),
					'laptop-macbook-white-minimal'  => esc_html__( 'Macbook White Minimal(770px x 480px)', 'theplus' ),
					'laptop-macbook-white'  => esc_html__( 'Macbook White (800px x 525px)', 'theplus' ),
					'laptop-windows'  => esc_html__( 'Windows Laptop (800px x 471px)', 'theplus' ),
				],
				'condition'    => [
					'device_mode' => [ 'normal' ],
					'device_mockup' => [ 'laptop' ],
				],
			]
		);
		$this->add_control(
			'device_desktop',
			[
				'label' => esc_html__( 'Desktop Device', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desktop-imac-minimal',
				'options' => [
					'desktop-imac-minimal'  => esc_html__( 'iMac Minimal (1000px x 565px)', 'theplus' ),
				],
				'condition'    => [
					'device_mode' => [ 'normal' ],
					'device_mockup' => [ 'desktop' ],
				],
			]
		);
		$this->add_control(
			'media_image',
			[
				'label' => esc_html__( 'Media Image', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active'   => true,
				],
				'condition'    => [
					'device_mode' => [ 'normal' ],
				],
			]
		);
		$this->add_control(
			'slider_gallery',
			[
				'label' => esc_html__( 'Select Multiple Images', 'theplus' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
				'condition'    => [
					'device_mode' => [ 'carousal' ],
				],
			]
		);
		$this->add_control(
			'device_link_popup',
			[
				'label' => esc_html__( 'Select Link/Popup', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => esc_html__( 'Select Option', 'theplus' ),
					'link'  => esc_html__( 'Link', 'theplus' ),
					'popup'  => esc_html__( 'Popup', 'theplus' ),
					
				],
				'condition'    => [
					'device_mode' => [ 'normal' ],
				],
			]
		);
		$this->add_control(
			'device_link',
			[
				'label' => esc_html__( 'Link', 'theplus' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'before',
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'theplus' ),
				'default' => [
					'url' => '',
				],
				'condition'    => [
					'device_mode' => [ 'normal' ],
					'device_link_popup!' => '', 
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_icon_content',
            [
                'label' => esc_html__('Icon Options', 'theplus'),
                'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'device_mode' => 'normal',
				],
            ]
        );
		$this->add_control(
			'icon_show',
			[
				'label' => esc_html__( 'Show Icon', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'theplus' ),
				'label_on' => esc_html__( 'On', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'icon_image',
			[
				'label' => esc_html__( 'Upload Icon', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'condition'    => [
					'icon_show' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_icon_styling',
            [
                'label' => esc_html__('Icon Options', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'device_mode' => 'normal',
					'icon_show' => 'yes',
				],
            ]
        );
		$this->add_control(
			'icon_continuous_animation',
			[
				'label'        => esc_html__( 'Continuous Animation', 'theplus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'theplus' ),
				'label_off'    => esc_html__( 'No', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'icon_animation_effect',
			[
				'label' => esc_html__( 'Animation Effect', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'pulse',
				'options' => [
					'pulse'  => esc_html__( 'Pulse', 'theplus' ),
					'floating'  => esc_html__( 'Floating', 'theplus' ),
					'tossing'  => esc_html__( 'Tossing', 'theplus' ),
					'rotating'  => esc_html__( 'Rotating', 'theplus' ),
					'drop_waves'  => esc_html__( 'Drop Waves', 'theplus' ),
				],
				'render_type'  => 'template',
				'condition' => [
					'icon_continuous_animation' => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_animation_hover',
			[
				'label'        => esc_html__( 'Hover Animation', 'theplus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'theplus' ),
				'label_off'    => esc_html__( 'No', 'theplus' ),					
				'render_type'  => 'template',
				'condition' => [
					'icon_continuous_animation' => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_animation_duration',
			[	
				'label' => esc_html__( 'Duration Time', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => 's',
				'range' => [
					's' => [
						'min' => 0.5,
						'max' => 50,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 's',
					'size' => 2.5,
				],
				'selectors'  => [
					'{{WRAPPER}} .plus-device-wrapper .plus-device-icon .plus-device-icon-inner' => 'animation-duration: {{SIZE}}{{UNIT}};-webkit-animation-duration: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_continuous_animation' => 'yes',
					'icon_animation_effect!' => 'drop_waves',
				],
			]
		);
		$this->add_control(
			'icon_transform_origin',
			[
				'label' => esc_html__( 'Transform Origin', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'top left'  => esc_html__( 'Top Left', 'theplus' ),
					'top center"'  => esc_html__( 'Top Center', 'theplus' ),
					'top right'  => esc_html__( 'Top Right', 'theplus' ),
					'center left'  => esc_html__( 'Center Left', 'theplus' ),
					'center center'  => esc_html__( 'Center Center', 'theplus' ),
					'center right'  => esc_html__( 'Center Right', 'theplus' ),
					'bottom left'  => esc_html__( 'Bottom Left', 'theplus' ),
					'bottom center'  => esc_html__( 'Bottom Center', 'theplus' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'theplus' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .plus-device-wrapper .plus-device-icon .plus-device-icon-inner' => '-webkit-transform-origin: {{VALUE}};-moz-transform-origin: {{VALUE}};-ms-transform-origin: {{VALUE}};-o-transform-origin: {{VALUE}};transform-origin: {{VALUE}};',
				],
				'render_type'  => 'template',
				'condition' => [
					'icon_continuous_animation' => 'yes',
					'icon_animation_effect' => 'rotating',
				],
			]
		);
		$this->add_control(
			'drop_waves_color',
			[
				'label' => esc_html__( 'Drop Wave Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper .plus-device-icon .plus-device-icon-inner.image-drop_waves:after,{{WRAPPER}} .plus-device-wrapper .plus-device-icon .plus-device-icon-inner.hover_drop_waves:after' => 'background: {{VALUE}}'
				],
				'condition' => [
					'icon_continuous_animation' => 'yes',
					'icon_animation_effect' => 'drop_waves',
				],
			]
		);
		$this->add_control(
			'icon_radius',
			[
				'label'      => esc_html__( 'Icon Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-device-wrapper .plus-device-icon img,{{WRAPPER}} .plus-device-wrapper .plus-device-icon .plus-device-icon-inner,{{WRAPPER}} .plus-device-wrapper .plus-device-icon .plus-device-icon-inner.image-drop_waves:after,{{WRAPPER}} .plus-device-wrapper .plus-device-icon .plus-device-icon-inner.hover_drop_waves:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[	
				'label' => esc_html__( 'Icon Size', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => 'px',
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 500,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 90,
				],
				'selectors'  => [
					'{{WRAPPER}} .plus-device-wrapper .plus-device-icon img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_carousal_styling',
            [
                'label' => esc_html__('Carousal Options', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'device_mode' => 'carousal',
				],
            ]
        );
		$this->add_control(
			'carousal_columns',
			[
				'label' => esc_html__( 'Carousal Column', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'multiple',
				'options' => [
					'single'  => esc_html__( 'Single Slide', 'theplus' ),
					'multiple' => esc_html__( 'Multiple', 'theplus' ),
				],
			]
		);
		
		$this->add_control(
			'carousal_infinite',
			[
				'label' => esc_html__( 'Infinite', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'carousal_autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'carousal_autoplay_speed',
			[
				'label' => esc_html__( 'Autoplay Speed', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'' => [
						'min' => 500,
						'max' => 10000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => '',
					'size' => 4000,
				],
				'condition' => [
					'carousal_autoplay' => 'yes',
				],
			]
		);
		$this->add_control(
			'carousal_speed',
			[
				'label' => esc_html__( 'Slide Speed', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'' => [
						'min' => 200,
						'max' => 5000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => '',
					'size' => 700,
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_carousel_slide_styling',
            [
                'label' => esc_html__('Carousel Slide', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'carousal_slide_gap',
			[
				'label' => esc_html__( 'Slide Gap/Space', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -10,
						'max' => 300,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper .plus-device-carousal .plus-device-slide.slick-slide' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'carousal_slide_vertical',
			[
				'label' => esc_html__( 'Adjust Slide Space', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper .plus-device-carousal .plus-device-slide.slick-slide' => 'margin-top: {{SIZE}}{{UNIT}};margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'carousal_width',
			[
				'label' => esc_html__( 'Carousal Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 330,
				],
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper .plus-carousal-device-mokeup,{{WRAPPER}} .plus-device-wrapper .plus-device-carousal.column-single' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .plus-device-wrapper .plus-device-carousal .plus-device-slide.slick-slide' => 'width: calc({{SIZE}}{{UNIT}} - 15px);',
				],
			]
		);
		$this->start_controls_tabs( 'slide_shadow_style' );
		$this->start_controls_tab(
			'slide_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'slide_box_shadow',
				'selector' => '{{WRAPPER}} .plus-device-wrapper .plus-device-carousal .plus-device-slide.slick-slide:not(.slick-center)',
			]
		);
		$this->add_control(
			'slide_opacity_normal',[
				'label' => esc_html__( 'Slide Opacity', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '',
					'size' => 1,
				],
				'range' => [
					'' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper .plus-device-carousal .plus-device-slide.slick-slide:not(.slick-center)' => 'opacity: {{SIZE}};',
				],
			]
		);
		$this->add_control(
			'slide_opacity_scale',[
				'label' => esc_html__( 'Slide Scale', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '',
					'size' => 1,
				],
				'range' => [
					'' => [
						'max' => 2,
						'min' => -0.5,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper .plus-device-carousal .plus-device-slide.slick-slide:not(.slick-center)' => 'transform: scale({{SIZE}});',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'slide_shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'slide_box_hover_shadow',
				'selector' => '{{WRAPPER}} .plus-device-wrapper .plus-device-carousal .plus-device-slide.slick-slide:hover:not(.slick-center)',
			]
		);
		$this->add_control(
			'slide_opacity_hover',[
				'label' => esc_html__( 'Slide Hover Opacity', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '',
					'size' => 1,
				],
				'range' => [
					'' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper .plus-device-carousal .plus-device-slide.slick-slide:hover:not(.slick-center)' => 'opacity: {{SIZE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
            'section_device_styling',
            [
                'label' => esc_html__('Device Layout', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
            'device_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width Adjust(%)', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min'	=> 10,
						'max'	=> 100,
						'step' => 0.5,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper' => 'width: {{SIZE}}%;margin: 0 auto;text-align: center;display: block;',
				],
				'render_type' => 'ui',
            ]
        );
		$this->add_responsive_control(
			'device_margin',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'allowed_dimensions' => 'vertical',
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'device_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_device_bg_styling',
            [
                'label' => esc_html__('Device Background', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'scroll_image_effect',
			[
				'label' => esc_html__( 'Scroll Image', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,				
				'label_on' => esc_html__( 'On', 'theplus' ),
				'label_off' => esc_html__( 'Off', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_responsive_control(
			'transition_duration',
			[
				'label'   => esc_html__( 'Transition Duration', 'theplus' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 4,
				],
				'range' => [
					'px' => [
						'step' => 0.1,
						'min'  => 0.1,
						'max'  => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .plus-device-wrapper .plus-media-inner .creative-scroll-image' => 'transition: background-position {{SIZE}}s ease-in-out;-webkit-transition: background-position {{SIZE}}s ease-in-out;',
				],
				'condition' => [
					'scroll_image_effect' => 'yes',
				],
			]
		);
		$this->add_control(
			'shadow_options',
			[
				'label' => esc_html__( 'Box Shadow', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'shadow_style' );
		$this->start_controls_tab(
			'shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .plus-device-wrapper .plus-device-shape,{{WRAPPER}} .plus-device-wrapper .plus-carousal-device-mokeup',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_hover_shadow',
				'selector' => '{{WRAPPER}} .plus-device-wrapper:hover .plus-device-shape,{{WRAPPER}} .plus-device-wrapper .plus-carousal-device-mokeup:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
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
					'unit' => '',
					'size' => 50,
				],
				'range' => [
					'' => [
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
		
		$media_content=$layout_shape=$device_class ='';
		if($settings["device_mode"]=='normal'){
		
			if($settings["device_mockup"]=='mobile'){
				$layout_shape='<img src="'.THEPLUS_ASSETS_URL.'images/devices/'.$settings["device_mobile"].'.png" class="plus-device-image" alt="Plus mobile device">';
				$device_class .= $settings["device_mobile"];
			}else if($settings["device_mockup"]=='tablet'){
				$layout_shape='<img src="'.THEPLUS_ASSETS_URL.'images/devices/'.$settings["device_tablet"].'.png" class="plus-device-image" alt="Plus tablet device">';
				$device_class .= $settings["device_tablet"];
			}else if($settings["device_mockup"]=='laptop'){
				$layout_shape='<img src="'.THEPLUS_ASSETS_URL.'images/devices/'.$settings["device_laptop"].'.png" class="plus-device-image" alt="Plus laptop device">';
				$device_class .= $settings["device_laptop"];
			}else if($settings["device_mockup"]=='desktop'){
				$layout_shape='<img src="'.THEPLUS_ASSETS_URL.'images/devices/'.$settings["device_desktop"].'.png" class="plus-device-image" alt="Plus desktop device">';
				$device_class .= $settings["device_desktop"];
			}
			
			$device_url=$device_url_close='';
			if ( !empty($settings["device_link_popup"]) && ! empty( $settings['device_link']['url'] ) ) {
				$this->add_render_attribute( 'device_url', 'href', $settings['device_link']['url'] );
				if ( $settings['device_link']['is_external'] ) {
					$this->add_render_attribute( 'device_url', 'target', '_blank' );
				}
				if ( $settings['device_link']['nofollow'] ) {
					$this->add_render_attribute( 'device_url', 'rel', 'nofollow' );
				}
				if(!empty($settings["device_link_popup"]) && $settings["device_link_popup"]=='popup'){
					$this->add_render_attribute( 'device_url', 'data-lity', '' );
				}
				$device_url = '<a '.$this->get_render_attribute_string( "device_url" ).' class="plus-media-link">';
				$device_url_close = '</a>';
			}
			$icon_effect='';
			if(!empty($settings["icon_continuous_animation"]) && $settings["icon_continuous_animation"]=='yes'){
				if($settings["icon_animation_hover"]=='yes'){
					$animation_class='hover_';
				}else{
					$animation_class='image-';
				}
				$icon_effect=$animation_class.$settings["icon_animation_effect"];
			}
			$device_icon_center='';
			if(!empty($settings["icon_show"]) && $settings["icon_show"]=='yes' && !empty($settings["icon_image"]["url"])){
				$image_id=$settings["icon_image"]["id"];
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
				if(!$image_alt){
					$image_alt = get_the_title($image_id);
				}else if(!$image_alt){
					$image_alt = 'Plus icon image';
				}
				$device_icon_center .= '<div class="plus-device-icon">';
					$device_icon_center .= '<div class="plus-device-icon-inner '.esc_attr($icon_effect).'">';
						$device_icon_center .= '<img src="'.esc_url($settings["icon_image"]["url"]).'" alt="'.esc_attr($image_alt).'" />';
					$device_icon_center .= '</div>';
				$device_icon_center .= '</div>';
			}
			
			$scroll_image=$scroll_image_content='';
			if(!empty($settings["scroll_image_effect"]) && $settings['scroll_image_effect']=='yes'){
				$this->add_render_attribute( 'scroll-image', 'style', 'background-image: url(' . esc_url($settings['media_image']['url']) . ');' );
				$scroll_image_content ='<div class="creative-scroll-image" ' . $this->get_render_attribute_string( 'scroll-image' ) . '></div>';
				$scroll_image='scroll-image-wrap';
			}
			
			if(!empty($layout_shape)){
				$media_content= '<div class="plus-media-inner">';
					$media_content .= '<div class="plus-media-screen">';
						$media_content .= '<div class="plus-media-screen-inner '.esc_attr($scroll_image).'">';
							if(!empty($settings["scroll_image_effect"]) && $settings['scroll_image_effect']=='yes'){
								$media_content .= $scroll_image_content;
							}else if(!empty($settings["media_image"]["url"])){
								$image_id=$settings["media_image"]["id"];
								$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
								if(!$image_alt){
									$image_alt = get_the_title($image_id);
								}else if(!$image_alt){
									$image_alt = 'Plus device media';
								}
								$media_content .='<img src="'.esc_url($settings["media_image"]["url"]).'" class="plus-media-image" alt="'.esc_attr($image_alt).'">';
							}
							$media_content .= $device_url;
								$media_content .= $device_icon_center;
							$media_content .= $device_url_close;
						$media_content .= '</div>';
					$media_content .= '</div>';
				$media_content .= '</div>';
			}
		}
		
		$slide_image=$carousal_device=$carousal_attr='';
		if($settings["device_mode"]=='carousal'){
			if($settings["device_mockup_carousal"]=='mobile'){
				$layout_shape='<img src="'.THEPLUS_ASSETS_URL.'images/devices/'.$settings["device_mobile_carousal"].'.png" class="plus-device-image" alt="Device mobile">';
				$carousal_device .= $settings["device_mobile_carousal"];
			}
			if(!empty($settings['slider_gallery'])){
				foreach ( $settings['slider_gallery'] as $image ) {
					$image_id=$image["id"];
					$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
					if(!$image_alt){
						$image_alt = get_the_title($image_id);
					}else if(!$image_alt){
						$image_alt = 'Plus device carousel media';
					}
					$slide_image .= '<div class="plus-device-slide">';
						$slide_image .= '<img src="' . esc_url($image["url"]) . '" alt="'.esc_attr($image_alt).'">';
					$slide_image .= '</div>';
				}
			}
			
			$infinite = ($settings['carousal_infinite']=='yes') ? 'true' : 'false';
			$autoplay = ($settings['carousal_autoplay']=='yes') ? 'true' : 'false';
			$autoplay_speed = (!empty($settings['carousal_autoplay_speed']["size"])) ? $settings['carousal_autoplay_speed']["size"] : '4000';
			$speed = (!empty($settings['carousal_speed']["size"])) ? $settings['carousal_speed']["size"] : '700';
			
			$carousal_attr .= ' data-infinite="'.$infinite.'"';
			$carousal_attr .= ' data-autoplay="'.$autoplay.'"';
			$carousal_attr .= ' data-autoplay_speed="'.$autoplay_speed.'"';
			$carousal_attr .= ' data-speed="'.$speed.'"';
		}
		$uid=uniqid("device");
		$device_mockup=$settings["device_mockup"];
		$output= '<div class="plus-device-wrapper device-type-'.esc_attr($device_mockup).' '.esc_attr($device_class).' '.esc_attr($animated_class).'" '.$animation_attr.'>';
			$output .= '<div class="plus-device-inner">';
				if($settings["device_mode"]=='normal'){
					$output .= '<div class="plus-device-content">';
						$output .= '<div class="plus-device-shape">';
							$output .= $layout_shape;
						$output .= '</div>';
						$output .= '<div class="plus-device-media">';
							$output .= $media_content;
						$output .= '</div>';
					$output .= '</div>';
					
				}else if($settings["device_mode"]=='carousal'){
					$output .= '<div class="plus-carousal-device-mokeup">';
						$output .= '<div class="plus-device-content">';
							$output .= $layout_shape;
						$output .= '</div>';
					$output .= '</div>';
					$output .='<div class="plus-device-carousal column-'.$settings["carousal_columns"].' '.esc_attr($uid).'" data-id="'.esc_attr($uid).'" '.$carousal_attr.'>';
						$output .= $slide_image;
					$output .= '</div>';
				}
			$output .= '</div>';
		$output .= '</div>';
		
		echo $before_content.$output.$after_content;
	}

	protected function content_template() {
	
	}
}
