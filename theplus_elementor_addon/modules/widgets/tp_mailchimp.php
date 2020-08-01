<?php 
/*
Widget Name: MailChimp
Description: Subscribe Email Form Using Mailchimp.
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
use Elementor\Group_Control_Background;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_MailChimp_Subscribe extends Widget_Base {
		
	public function get_name() {
		return 'tp-mailchimp-subscribe';
	}

    public function get_title() {
        return esc_html__('Mailchimp', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-envelope theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-adapted');
    }

    protected function _register_controls() {
		/*Layout Content*/
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Layout', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'form_style',
			[
				'label' => esc_html__( 'Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => theplus_get_style_list(3),
			]
		);
		$this->add_responsive_control(
			'content_align',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
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
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-3 .theplus-mailchimp-form input.form-control,{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-3 .theplus-post-search-forms input.form-control' => 'text-align: {{VALUE}};',
				],
				'default' => 'center',
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
			]
		);
		$this->end_controls_section();
		/*Layout Content*/
		/*Name Field*/
		$this->start_controls_section(
			'name_field_section',
			[
				'label' => esc_html__( 'Name Field', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'form_style!' => 'style-1',
				],
			]
		);
		$this->add_control(
            'name_switch',
            [
				'label'   => esc_html__( 'Display Name Field', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',				
			]
		);
		$this->add_control(
            'name_switch_fname',
            [
				'label'   => esc_html__( 'Display First Name', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'name_switch' => 'yes',					
				],
			]
		);
		$this->add_control(
			'name_field_placeholder',
			[
				'label'       => esc_html__( 'First Name', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Enter First Name', 'theplus' ),
				'placeholder' => esc_html__( 'Enter First Name', 'theplus' ),
				'condition' => [
					'name_switch' => 'yes',
					'name_switch_fname' => 'yes',
				],
			]
		);
		$this->add_control(
			'name_icon_fontawesome',
			[
				'label' => esc_html__( 'Name Icon Prefix', 'theplus' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-user',
				'condition' => [
					'name_switch' => 'yes',
					'name_switch_fname' => 'yes',
					'form_style!' => 'style-3',
				],
			]
		);
		$this->add_responsive_control(
			'name_field_width',
			[
				'label' => esc_html__( 'Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-3 .theplus-mailchimp-form input.form-control.tp-mailchimp-first-name' => 'width: {{SIZE}}%;',
				],				
				'condition' => [
					'form_style' => 'style-3',	
					'name_switch' => 'yes',
					'name_switch_fname' => 'yes',
				],
			]
		);
		$this->add_control(
            'name_switch_lname',
            [
				'label'   => esc_html__( 'Display Last Name', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'name_switch' => 'yes',
					'form_style' => 'style-3',
				],
			]
		);
		$this->add_control(
			'last_name_field_placeholder',
			[
				'label'       => esc_html__( 'Last Name', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Enter Last Name', 'theplus' ),
				'placeholder' => esc_html__( 'Enter Last Name', 'theplus' ),
				'condition' => [
					'name_switch' => 'yes',
					'name_switch_lname' => 'yes',
					'form_style' => 'style-3',
				],
			]
		);				
		$this->add_responsive_control(
			'lname_field_width',
			[
				'label' => esc_html__( 'Last Name Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-3 .theplus-mailchimp-form input.form-control.tp-mailchimp-last-name' => 'width: {{SIZE}}%;',
				],				
				'condition' => [
					'form_style' => 'style-3',	
					'name_switch' => 'yes',
					'name_switch_lname' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*Name Field*/
		
		/*birth Field*/
		$this->start_controls_section(
			'birth_field_section',
			[
				'label' => esc_html__( 'Birth Field', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'form_style' => 'style-3',
				],
			]
		);
		$this->add_control(
            'birth_switch',
            [
				'label'   => esc_html__( 'Display Birth Field', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',				
			]
		);
		$this->add_control(
			'bith_field_placeholder_month',
			[
				'label'       => esc_html__( 'Month', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'MM', 'theplus' ),
				'placeholder' => esc_html__( 'MM', 'theplus' ),
				'condition' => [
					'birth_switch' => 'yes',
				],
			]
		);
		$this->add_control(
			'bith_field_placeholder_day',
			[
				'label'       => esc_html__( 'Day', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'DD', 'theplus' ),
				'placeholder' => esc_html__( 'DD', 'theplus' ),
				'condition' => [
					'birth_switch' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'birth_field_width',
			[
				'label' => esc_html__( 'Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-3 .theplus-mailchimp-form input.form-control.tp-mailchimp-birth-month,
					{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-3 .theplus-mailchimp-form input.form-control.tp-mailchimp-birth-day' => 'width: {{SIZE}}%;',
				],
				'separator' => 'before',
				'condition' => [
					'form_style' => 'style-3',	
					'birth_switch' => 'yes',					
				],
			]
		);
		$this->end_controls_section();
		/*Birthdate Field*/
		
		/*phone Field*/
		$this->start_controls_section(
			'phone_field_section',
			[
				'label' => esc_html__( 'Phone Field', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'form_style' => 'style-3',
				],
			]
		);
		$this->add_control(
            'phone_switch',
            [
				'label'   => esc_html__( 'Display Phone Field', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',				
			]
		);
		$this->add_control(
			'phone_field_placeholder',
			[
				'label'       => esc_html__( 'Phone', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( '+1 123-4567', 'theplus' ),
				'placeholder' => esc_html__( '+1 123-4567', 'theplus' ),
				'condition' => [
					'phone_switch' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'phone_field_width',
			[
				'label' => esc_html__( 'Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-3 .theplus-mailchimp-form input.form-control.tp-mailchimp-phone' => 'width: {{SIZE}}%;',
				],				
				'separator' => 'before',
				'condition' => [
					'form_style' => 'style-3',	
					'phone_switch' => 'yes',					
				],
			]
		);
		$this->end_controls_section();
		/*phone Field*/
		
		/*Email Field*/
		$this->start_controls_section(
			'email_field_section',
			[
				'label' => esc_html__( 'Email Field', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'email_field_placeholder',
			[
				'label'       => esc_html__( 'Email Field Placeholder', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Enter email address', 'theplus' ),
				'placeholder' => esc_html__( 'Enter email address', 'theplus' ),
			]
		);
		$this->add_control(
			'email_icon_fontawesome',
			[
				'label' => esc_html__( 'Email Icon Prefix', 'theplus' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-envelope-o',
				'condition' => [					
					'form_style!' => 'style-3',
				],
			]
		);
		$this->add_responsive_control(
			'email_field_width',
			[
				'label' => esc_html__( 'Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-3 .theplus-mailchimp-form input.form-control.tp-mailchimp-email' => 'width: {{SIZE}}%;',
				],				
				'separator' => 'before',
				'condition' => [
					'form_style' => 'style-3',
				],
			]
		);
		$this->end_controls_section();
		/*Email Field*/
		/*Subscribe Button*/
		$this->start_controls_section(
			'subscribe_button_section',
			[
				'label' => esc_html__( 'Subscribe Button', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'SUBSCRIBE', 'theplus' ),
				'default'     => esc_html__( 'SUBSCRIBE', 'theplus' ),
			]
		);
		$this->add_control(
			'button_icon_style',
			[
				'label' => esc_html__( 'Icon Font', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'  => esc_html__( 'None', 'theplus' ),
					'font_awesome'  => esc_html__( 'Font Awesome', 'theplus' ),
					'icon_mind' => esc_html__( 'Icons Mind', 'theplus' ),
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'button_icon_fontawesome',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-chevron-right',
				'condition' => [
					'button_icon_style' => 'font_awesome',
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
					'button_icon_style' => 'icon_mind',
				],
			]
		);
		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => esc_html__( 'Left', 'theplus' ),
					'right'  => esc_html__( 'Right', 'theplus' ),
				],
				'condition' => [
					'button_icon_style!' => 'none',
				],
			]
		);
		$this->add_control(
			'button_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'theplus' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 8,
				],
				'condition' => [
					'button_icon_style!' => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-form .subscribe-btn-icon.btn-after'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-mailchimp-form .subscribe-btn-icon.btn-before'   => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'button_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theplus' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'condition' => [
					'button_icon_style!' => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-form .subscribe-btn-icon'  => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_responsive_control(
			'button_field_width',
			[
				'label' => esc_html__( 'Button Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition' => [
					'form_style' => 'style-3',
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-3 button' => 'width: {{SIZE}}%;',
				],
			]
		);
		$this->add_control(
			'button_align_custom',
			[
				'label' => esc_html__( 'Button Custom Alignment', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theplus' ),
				'label_off' => esc_html__( 'No', 'theplus' ),				
				'default' => 'no',
			]
		);
		$this->add_responsive_control(
			'button_align',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon' => 'fa fa-align-left',
					],
					'unset' => [
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-3 button' => 'float: {{VALUE}};display:block;margin:0 auto;margin-top: 10px;',
				],
				'default' => 'center',
				'separator' => 'before',
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'condition' => [
					'button_align_custom' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*Subscribe Button*/
		/*Redirect Thank you Page*/
		$this->start_controls_section(
			'redirect_thank_you_section',
			[
				'label' => esc_html__( 'Redirect Thank you Page', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'switch_redirect_thankyou',
			[
				'label' => esc_html__( 'Redirect Thank You Page', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theplus' ),
				'label_off' => esc_html__( 'No', 'theplus' ),				
				'default' => 'no',
			]
		);
		$this->add_control(
			'redirect_thankyou',
			[
				'label' => esc_html__( 'Page Link', 'theplus' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'theplus' ),
				'show_external' => false,
				'dynamic' => ['active'   => true,],
				'condition' => [
					'switch_redirect_thankyou' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*Redirect Thank you Page*/
		/*Response Message*/
		$this->start_controls_section(
			'response_msg_section',
			[
				'label' => esc_html__( 'Response Message', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'loading_suscribe_msg',
			[
				'label'       => esc_html__( 'Loading Subscribe Message', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Subscribing you please wait...', 'theplus' ),
				'placeholder' => esc_html__( 'Subscribing you please wait...', 'theplus' ),
				'label_block' => true,
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'incorrect_msg',
			[
				'label'       => esc_html__( 'Incorrect Email Id', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Incorrect Email Address.', 'theplus' ),
				'placeholder' => esc_html__( 'Incorrect Email Address.', 'theplus' ),
				'label_block' => true,
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'correct_msg',
			[
				'label'       => esc_html__( 'Success Message', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Thanks for Subscribing with us. Just wait for our Next Email.', 'theplus' ),
				'placeholder' => esc_html__( 'Thanks for Subscribing with us. Just wait for our Next Email.', 'theplus' ),
				'label_block' => true,
				'dynamic' => ['active'   => true,],
			]
		);
		$this->end_controls_section();
		/*Response Message*/
		/*Prefix Icon*/
		$this->start_controls_section(
			'section_prefix_icon_input',
			[
				'label' => esc_html__( 'Prefix Email Icon', 'theplus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_style!' => 'style-3',
					'email_icon_fontawesome!' => '',
				],
			]
		);
		$this->add_responsive_control(
            'prefix_icon_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper .plus-newsletter-input-wrapper span.prefix-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_control(
			'prefix_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper .plus-newsletter-input-wrapper span.prefix-icon' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
            'prefix_icon_adjust',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Adjust', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -50,
						'max' => 50,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper .plus-newsletter-input-wrapper span.prefix-icon' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
            'prefix_icon_adjust_left',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Left Adjust', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper.form-style-2 .plus-newsletter-input-wrapper span.prefix-icon' => 'left: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'form_style' => 'style-2',
				],
            ]
        );
		$this->end_controls_section();
		/*Prefix Icon*/
		/*Email Field Style*/
		$this->start_controls_section(
			'section_style_input',
			[
				'label' => esc_html__( 'Fields Styling', 'theplus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'email_typography',
				'selector' => '{{WRAPPER}} .theplus-mailchimp-form input.form-control',
			]
		);
		$this->add_control(
			'email_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control::placeholder' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'email_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'email_outer_padding',
			[
				'label' => esc_html__( 'Outer Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'tabs_email_field_style' );
		$this->start_controls_tab(
			'tab_email_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'input_color',
			[
				'label'     => esc_html__( 'Text Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'email_field_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-mailchimp-form input.form-control',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_email_focus',
			[
				'label' => esc_html__( 'Focus', 'theplus' ),
			]
		);
		$this->add_control(
			'input_focus_color',
			[
				'label'     => esc_html__( 'Text Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control:focus' => 'color: {{VALUE}};',
				],
			]
			);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'email_field_focus_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-mailchimp-form input.form-control:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'border_options',
			[
				'label' => esc_html__( 'Border Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'box_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'border_style',
			[
				'label' => esc_html__( 'Border Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'box_border_width',
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
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_border_style' );
		$this->start_controls_tab(
			'tab_border_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
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
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html__( 'Focus', 'theplus' ),
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control:focus' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-form input.form-control:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_shadow_style' );
		$this->start_controls_tab(
			'tab_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .theplus-mailchimp-form input.form-control',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_shadow_hover',
			[
				'label' => esc_html__( 'Focus', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_active_shadow',
				'selector' => '{{WRAPPER}} .theplus-mailchimp-form input.form-control:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Email Field Style*/
		$this->start_controls_section(
            'section_subscribe_button_styling',
            [
                'label' => esc_html__('Subscribe Button', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit',
			]
		);
		$this->add_responsive_control(
			'button_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'button_margin',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
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
			'button_color',
			[
				'label'     => esc_html__( 'Text Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit',
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
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_hover_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'button_border_options',
			[
				'label' => esc_html__( 'Border Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'button_box_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'button_border_style',
			[
				'label' => esc_html__( 'Border Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'button_box_border_width',
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
					'{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_button_border_style' );
		$this->start_controls_tab(
			'tab_button_border_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_border_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'button_border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'button_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_button_shadow_style' );
		$this->start_controls_tab(
			'tab_button_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_shadow',
				'selector' => '{{WRAPPER}} .theplus-mailchimp-wrapper button.subscribe-btn-submit:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Response Message Style*/
		$this->start_controls_section(
            'section_subscribe_msg_styling',
            [
                'label' => esc_html__('Response Message', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'message_typography',
				'selector' => '{{WRAPPER}} .theplus-mailchimp-wrapper .theplus-notification',
			]
		);
		$this->add_control(
			'message_color',
			[
				'label' => esc_html__( 'Message Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper .theplus-notification' => 'color: {{VALUE}};',
				],				
			]
		);
		$this->add_control(
			'message_loading_bg',
			[
				'label' => esc_html__( 'Loading Background', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper .theplus-notification' => 'background: {{VALUE}};',
				],				
			]
		);
		$this->add_control(
			'message_success_bg',
			[
				'label' => esc_html__( 'Success Background', 'theplus' ),
				'type' => Controls_Manager::COLOR,				
				'separator' => 'before',
				'selectors'  => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper .theplus-notification.success-msg' => 'background: {{VALUE}};',
				],				
			]
		);
		$this->end_controls_section();
		/*Response Message Style*/
		$this->start_controls_section(
            'section_responsive_styling',
            [
                'label' => esc_html__('Responsive', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
            'content_max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'theplus'),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 250,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-mailchimp-wrapper .theplus-mailchimp-form' => 'max-width: {{SIZE}}{{UNIT}}',
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
		$id   = 'plus-mailchimp-' . $this->get_id();
		$style = $settings["form_style"];
		$content_align='text-'.$settings['content_align'];
		$content_align_tablet= 'text--tablet'.$settings['content_align_tablet'];
		$content_align_mobile='text--mobile'.$settings['content_align_mobile'];
		$loading_msg=(!empty($settings['loading_suscribe_msg'])) ? $settings['loading_suscribe_msg'] : 'Subscribing you please wait...';
		$incorrect_msg=(!empty($settings['incorrect_msg'])) ? $settings['incorrect_msg'] : 'Incorrect Email Address.';
		$correct_msg=(!empty($settings['correct_msg'])) ? $settings['correct_msg'] : 'Thanks for Subscribing with us. Just wait for our Next Email.';
		
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
			$redirect_thankyou='';
			if(!empty($settings["switch_redirect_thankyou"]) && $settings["switch_redirect_thankyou"]=='yes'){
				if(!empty($settings['redirect_thankyou']['url'])){
					$redirect_thankyou=$settings['redirect_thankyou']['url'];
				}
			}
			$output ='<div class="theplus-mailchimp-wrapper form-'.esc_attr($style).' '.esc_attr($animated_class).'" '.$animation_attr.'>';
				$output .='<form action="'.site_url().'/wp-admin/admin-ajax.php" id="'.esc_attr($id).'" class="theplus-mailchimp-form '.$content_align.' '.$content_align_tablet.' '.$content_align_mobile.'" data-thank-you="'.esc_attr($redirect_thankyou).'">';
					$output .='<div class="plus-newsletter-input-wrapper">';
												
						if((!empty($settings['form_style']) && $settings['form_style'] =='style-2') && (!empty($settings['name_switch']) && $settings['name_switch']=='yes')){
							if(!empty($settings["name_icon_fontawesome"]) && $settings['form_style'] != 'style-3'){
								$output .='<span class="prefix-icon"><i class="'.$settings["name_icon_fontawesome"].'"></i></span>';
							}
							$output .='<input type="text" name="FNAME" placeholder="'.esc_attr($settings["name_field_placeholder"]).'"class="form-control tp-mailchimp-first-name">';
						}
						
						/*extra field start*/
						if((!empty($settings['form_style']) && $settings['form_style'] =='style-3')){
							if(!empty($settings['name_switch']) && $settings['name_switch']=='yes'){
								if(!empty($settings['name_switch_fname']) && $settings['name_switch_fname']=='yes'){
									$output .='<input type="text" name="FNAME" placeholder="'.esc_attr($settings["name_field_placeholder"]).'"class="form-control tp-mailchimp-first-name">';
								}
								if(!empty($settings['name_switch_lname']) && $settings['name_switch_lname']=='yes'){
									$output .='<input type="text" name="LNAME" placeholder="'.esc_attr($settings["last_name_field_placeholder"]).'" class="form-control tp-mailchimp-last-name">';
								}
							}
							
							if(!empty($settings['birth_switch']) && $settings['birth_switch']=='yes'){
								$output .='<input type="number" name="BIRTHMONTH" placeholder="'.esc_attr($settings["bith_field_placeholder_month"]).'" class="form-control tp-mailchimp-birth-month" min="1" max="12">';
								$output .='<input type="number" name="BIRTHDAY" placeholder="'.esc_attr($settings["bith_field_placeholder_day"]).'" class="form-control tp-mailchimp-birth-day" min="01" max="31">';
							}
							
							if(!empty($settings['phone_switch']) && $settings['phone_switch']=='yes'){
								$output .='<input type="text" name="PHONE" placeholder="'.esc_attr($settings["phone_field_placeholder"]).'" class="form-control tp-mailchimp-phone">';
							}
						}
						/*extra field end*/
						
						if((!empty($settings['form_style']) && $settings['form_style'] =='style-3')){
							 if(!empty($settings['name_switch']) && $settings['name_switch']=='yes'){
							 }
						}
						
						if(!empty($settings["email_icon_fontawesome"]) && $settings['form_style'] != 'style-3'){
							$output .='<span class="prefix-icon"><i class="'.$settings["email_icon_fontawesome"].'"></i></span>';
						}
						$output .='<input type="email" name="email" placeholder="'.esc_attr($settings["email_field_placeholder"]).'" required class="form-control tp-mailchimp-email" />';
						$output .='<input type="hidden" name="action" value="plus_mailchimp_subscribe" />';
						$output .='<button class="subscribe-btn-submit">'.$this->render_text($settings).'</button>';
					$output .='</div>';				
					
					$output .='<div class="theplus-notification"><div class="subscribe-response"></div></div>';
				$output .= '</form>';
			$output .= '</div>'; ?>
			<script>
			jQuery(document).ready(function($) {
				'use strict';
				$('#<?php echo esc_attr($id);?>').on('submit',function(event){
					event.preventDefault()
					var mailchimpform = $(this);
					var loading_text='<span class="loading-spinner"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span><?php echo esc_html($loading_msg); ?>';
					var notverify='<span class="loading-spinner"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span>Error : API Key or List ID invalid. Please check that again in Plugin Settings.';
					var incorrect_text='<span class="loading-spinner"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span><?php echo esc_html($incorrect_msg); ?>';
					var correct_text='<span class="loading-spinner"><i class="fa fa-envelope-o" aria-hidden="true"></i></span><?php echo esc_html($correct_msg); ?>';
					$("#<?php echo esc_attr($id);?> .theplus-notification").removeClass("not-verify danger-msg success-msg");
					$.ajax({
						type:"POST",						
						data:mailchimpform.serialize(),
						url:theplus_ajax_url,
						beforeSend: function() {
							$("#<?php echo esc_attr($id);?> .theplus-notification").fadeIn().animate({						
								opacity: 1
							  }, 200 );
							$("#<?php echo esc_attr($id);?> .theplus-notification .subscribe-response").html(loading_text);
						},
						success:function(data){
							
							if(data=='not-verify'){
								$("#<?php echo esc_attr($id);?> .theplus-notification").addClass("not-verify");
								$("#<?php echo esc_attr($id);?> .theplus-notification .subscribe-response").html(notverify);
							}
							if(data=='incorrect'){
								$("#<?php echo esc_attr($id);?> .theplus-notification").addClass("danger-msg");
								$("#<?php echo esc_attr($id);?> .theplus-notification .subscribe-response").html(incorrect_text);
							}
							if(data=='correct'){
								$("#<?php echo esc_attr($id);?> .theplus-notification").addClass("success-msg");
								$("#<?php echo esc_attr($id);?> .theplus-notification .subscribe-response").html(correct_text);
								if($('#<?php echo esc_attr($id);?>').data("thank-you")!= undefined && $('#<?php echo esc_attr($id);?>').data("thank-you")!=''){
									var redirect_url=$('#<?php echo esc_attr($id);?>').data("thank-you");
									setTimeout(function(){
										window.location.href = redirect_url;
									}, 700);
								}
							}
							$("#<?php echo esc_attr($id);?> .theplus-notification").delay(2500).fadeOut().animate({						
								opacity: 0
							}, 2500 );
							
						}
					});
					return false;
				});
			});
		</script>
		<?php 
		echo $before_content.$output.$after_content;
	}
	public function render_text($settings) {

		$this->add_render_attribute( 'content-wrapper', 'class', 'theplus-subscribe-btn-wrapper' );
		
		$btn_icon='';
		if($settings["button_icon_style"]!='none'){
			if($settings["button_icon_style"]=='font_awesome' && !empty($settings["button_icon_fontawesome"])){
				$btn_icon=$settings["button_icon_fontawesome"];				
			}
			if($settings["button_icon_style"]=='icon_mind' && !empty($settings["button_icons_mind"])){
				$btn_icon=$settings["button_icons_mind"];				
			}
		}
		$btn_before=$btn_after='';
		if($settings["icon_align"]=='left' && !empty($btn_icon)){
			$btn_before='<i class="subscribe-btn-icon btn-before '.esc_attr($btn_icon).'" aria-hidden="true"></i>';
		}
		if($settings["icon_align"]=='right' && !empty($btn_icon)){
			$btn_after='<i class="subscribe-btn-icon btn-after '.esc_attr($btn_icon).'" aria-hidden="true"></i>';
		}
		
		$subscribe_button =$btn_before.$settings['button_text'].$btn_after;

		return $subscribe_button;
	}
    protected function content_template() {
	
    }

}
