<?php 
/*
Widget Name: WP Login Register
Description: WP Login Register
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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use TheplusAddons\Theplus_Element_Load;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Wp_Login_Register extends Widget_Base {
		
	public function get_name() {
		return 'tp-wp-login-register';
	}

    public function get_title() {
        return esc_html__('WP Login & Register', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-user-circle-o theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }
	public function get_keywords() {
		return ['login', 'signup', 'password', 'login header bar', 'signup header bar', 'login signup panel', 'login panel', 'signup panel' ,'forgot' , 'reset' ,'register'];
	}
	
    protected function _register_controls() {	
		$this->start_controls_section(
			'section_forms_layout',
			[
				'label' => esc_html__( 'Forms Layout', 'theplus' ),
			]
		);		
		$this->add_control(
			'form_selection',
			[
				'label' => esc_html__( 'Select', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tp_login',
				'options' => [
					'tp_login'  => esc_html__( 'Login', 'theplus' ),
					'tp_register'  => esc_html__( 'Register', 'theplus' ),
					'tp_login_register'  => esc_html__( 'Login and Register', 'theplus' ),
					'tp_forgot_password'  => esc_html__( 'Forgot Password', 'theplus' ),					
				],
			]
		);
		
		$this->add_control(
			'_skin',
			[
				'label' => esc_html__( 'Select Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Standard Form', 'theplus' ),
					'tp-dropdown'  => esc_html__( 'Button Hover', 'theplus' ),
					'tp-modal'  => esc_html__( 'Button Click', 'theplus' ),
					'tp-popup'  => esc_html__( 'Button Popup', 'theplus' ),
				],
				'condition' => [
					'form_selection!' => ['tp_forgot_password'],
				],
			]
		);
		$this->add_control(
			'layout_start_from',
			[
				'label' => esc_html__( 'Drop Down Alignment', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tp-lrfp-lyot-con-left',
				'options' => [					
					'tp-lrfp-lyot-con-left'  => esc_html__( 'Left', 'theplus' ),
					'tp-lrfp-lyot-con-right'  => esc_html__( 'Right', 'theplus' ),
					'tp-lrfp-lyot-con-center'  => esc_html__( 'Center', 'theplus' ),
				],				
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'form_selection',
							'operator' => '!==',
							'value' => 'tp_forgot_password',
						],
						[
							'name' => '_skin',
							'operator' => '!==',
							'value' => 'default',
						],
						[
						'name' => '_skin',
							'operator' => '!==',
							'value' => 'tp-popup',
						],
					],
				],
			]
		);		
		$this->add_control(
			'f_p_opt',
			[
				'label' => esc_html__( 'Password Reset Page', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Email to Default Page', 'theplus' ),
					'f_p_frontend'  => esc_html__( 'Email to Custom Page', 'theplus' ),					
				],
				'separator' => 'before',
				'condition' => [
					'form_selection' => ['tp_forgot_password'],
				],
			]
		);
		$this->add_control(
			'reset_pass_url',
			[
				'label' => esc_html__( 'Reset Password Page', 'theplus' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => [],
				'separator' => 'before',
				'options'     => the_plus_get_term_options(),
				'condition' => [
					'form_selection' => ['tp_forgot_password'],
					'f_p_opt' => 'f_p_frontend',
				],
			]
		);
		$this->add_control(
			'hcp_button_align',
			[
				'label' => esc_html__( 'Button Alignment', 'theplus' ),
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
				'separator' => 'before',
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .tp-user-login,{{WRAPPER}} .tp-user-register,{{WRAPPER}} .tp-lr-combo' => 'float: {{VALUE}} !important;',					
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'form_selection',
							'operator' => '!==',
							'value' => 'tp_forgot_password',
						],
						[
							'name' => '_skin',
							'operator' => '!==',
							'value' => 'default',
						],						
					],
				],
				
			]
		);
		$this->add_control(
			'form_align',
			[
				'label' => esc_html__( 'Form Content Alignment', 'theplus' ),
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
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf,
					{{WRAPPER}} .tp-wp-lrcf .tp-button,
					{{WRAPPER}} .tp-wp-lrcf input,{{WRAPPER}} .tp-wp-lrcf input::placeholder' => 'text-align: {{VALUE}};',					
				],
				
			]
		);
		$this->end_controls_section();
		/*form content end*/
		
		/*SignUp Form Extra Options start*/
		$this->start_controls_section(
			'section_signup_extra_options',
			[
				'label' => esc_html__( 'SignUp Form Extra Options', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'tp_dis_name_field',
			[
				'label' => esc_html__( 'Display Name Field', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'yes',				
			]
		);
		$this->add_control(
			'tp_dis_fname_field',
			[
				'label' => esc_html__( 'Display First Name Field', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'yes',				
				'condition' => [					
					'tp_dis_name_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'tp_dis_lname_field',
			[
				'label' => esc_html__( 'Display Last Name Field', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'yes',				
				'condition' => [					
					'tp_dis_name_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'tp_dis_pass_field',
			[
				'label' => esc_html__( 'Display Password Field', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'tp_dis_pass_field_strong',
			[
				'label' => esc_html__( 'Strong Password', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
				'condition' => [
					'tp_dis_pass_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'display_captcha_swtch',
			[
				'label' => esc_html__( 'reCAPTCHA v3', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'tp_mail_chimp_subscribe_opt',
			[
				'label' => esc_html__( 'MailChimp Subscribe', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'tp_terms_condition_opt',
			[
				'label' => esc_html__( 'Terms of Conditions', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'user_role',
			[
				'label' => esc_html__( 'New User Role', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'subscriber',
				'options' => tp_wp_lr_user_role(),
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*SignUp Form Extra Options end*/
		
		/*template select start*/
		$this->start_controls_section(
			'section_forms_layout_left_temp',
			[
				'label' => esc_html__( 'Left Side Template', 'theplus' ),				
				'conditions'   => [
					'terms' => [
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'form_selection','operator' => '==','value'    => 'tp_login_register',
								],
								[
									'name'     => '_skin','operator' => '!==','value'    => 'default',
								],								
							],
						],
					],
				],
			]
		);
		$this->add_control(
			'select_template',
			[
				'label' => esc_html__( 'Left Side Template', 'theplus' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => [],
				'separator' => 'before',
				'options'     => theplus_get_templates(),
			]
		);
		$this->end_controls_section();
		/*template select end*/
		
		/*Click/Hover/Popup Button start*/
		$this->start_controls_section(
			'section_dropdown_button',
			[
				'label' => esc_html__( 'Click/Hover/Popup Button', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,				
				'conditions'   => [
					'terms' => [						
						[
							'relation' => 'or',
							'terms'    => [
								[
									'terms' => [
										[ 'name'  => 'form_selection','operator' => '==','value' => 'tp_login' ],
										[ 'name'  => '_skin','operator' => '!=','value' => 'default', ],
									],
								],
								[
									'terms' => [
										[ 'name'  => 'form_selection','operator' => '==','value' => 'tp_register' ],
										[ 'name'  => '_skin','operator' => '!=','value' => 'default',],
									],
								],
								[
									'terms' => [
										[ 'name'  => 'form_selection','operator' => '==','value' => 'tp_login_register', ],
										[ 'name'  => '_skin','operator' => '!=','value' => 'default', ],
									],
								],
							],
						],
					],
				],				
			]
		);
		
		$this->add_control(
			'dropdown_button_text',
			[
				'label'   => esc_html__( 'Common Button Text', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Button Text', 'theplus' ),
				'condition' => [
					'form_selection!' => ['tp_forgot_password'],
					'_skin!' => 'default',
				],
			]
		);
		$this->add_control(
			'loop_icon_fontawesome',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'form_selection!' => ['tp_forgot_password'],
					'_skin!' => 'default',
				],
				
			]
		);
		$this->add_control(
			'modal_close_button',
			[
				'label'   => esc_html__( 'Close Button', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [					
					'_skin!' => 'tp-dropdown',
				],
				
			]
		);
		$this->add_control(
			'modal_close_button_icon',
			[
				'label' => esc_html__( 'Choose Image', 'theplus' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => THEPLUS_ASSETS_URL .'images/tp-close.png',
				],
				'condition' => [					
					'_skin!' => 'tp-dropdown',
					'modal_close_button' => 'yes',					
				],
			]
		);		
		$this->end_controls_section();
		/*Click/Hover/Popup Button end*/
		
		/*form heading start*/
		$this->start_controls_section(
			'section_forms_heading_options',
			[
				'label' => esc_html__( 'Form Heading', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_register','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'modal_header',
			[
				'label'   => esc_html__( 'Heading Text', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);
		$this->add_control(
			'modal_header_description_log',
			[
				'label' => esc_html__( 'Login Heading', 'theplus' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Heading Description', 'theplus' ),
				'placeholder' => esc_html__( 'Type your description here', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
					'modal_header' => 'yes',
				],
			]
		);
		$this->add_control(
			'modal_header_description_reg',
			[
				'label' => esc_html__( 'Registration Heading', 'theplus' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Heading Description', 'theplus' ),
				'placeholder' => esc_html__( 'Type your description here', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'modal_header' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*form heading end*/
		
		$this->start_controls_section(
			'section_forms_login_additional_options',
			[
				'label' => esc_html__( 'Login Options', 'theplus' ),
				'condition' => [					
					'form_selection' => ['tp_login','tp_login_register'],					
				],
			]
		);		
		$this->add_control(
			'tab_com_login',
			[
				'label'   => esc_html__( 'Login Tab Title', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Login', 'theplus' ),
				'separator' => 'after',
				'condition' => [
					'form_selection' => 'tp_login_register',
				],
			]
		);
		
		$this->add_control(
			'show_labels',
			[
				'label'   => esc_html__( 'Form Label', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',				
				'condition' => [
					'form_selection!' => ['tp_forgot_password'],
				],
			]
		);
		/*login custom label*/
		$this->add_control(
			'custom_labels',
			[
				'label'     => esc_html__( 'Form Custom Label', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
					'show_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'user_label',
				[
				'label'     => esc_html__( 'Username Label', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Username or Email', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'user_placeholder',
			[
				'label'     => esc_html__( 'Username Placeholder', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Username or Email', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'password_label',
			[
				'label'     => esc_html__( 'Password Label', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Password', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'password_placeholder',
			[
				'label'     => esc_html__( 'Password Placeholder', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Password', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Login Button Text', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Log In', 'theplus' ),
				'separator' => 'before',
				'condition' => [
					'form_selection!' => ['tp_register','tp_forgot_password'],
				],
			]
		);
		$this->add_control(
			'show_remember_me',
			[
				'label'   => esc_html__( 'Remember Me', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'remember_me_text',
			[
				'label'   => esc_html__( 'Remember Me Text', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Remember Me', 'theplus' ),				
				'condition' => [
					'show_remember_me' => 'yes',
				],
			]
		);
		/*login custom label*/
		$this->add_control(
			'show_lost_password',
			[
				'label'   => esc_html__( 'Lost your password?', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'bottom_lost_pass_text',
			[
				'label'     => esc_html__( 'Lost password Text', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Lost Password', 'theplus' ),
				'condition' => [
				'show_lost_password' => 'yes',
				],
			]
		);
		if ( get_option( 'users_can_register' ) ) {
			$this->add_control(
				'show_register',
				[
					'label'   => esc_html__( 'Register', 'theplus' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'separator' => 'before',
				]
			);
		}
		$this->add_control(
			'bottom_register_text',
			[
				'label'     => esc_html__( 'Register Text', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Register', 'theplus' ),
				'condition' => [
					'show_register' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_register_opt',
			[
				'label' => esc_html__( 'Registration Link Selection', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Default', 'theplus' ),
					'custom'  => esc_html__( 'Custom', 'theplus' ),
				],
				'condition' => [
					'show_register' => 'yes',	
				],
			]
		);
		$this->add_control(
			'show_register_opt_link',
			[
				'label' => esc_html__( 'Link', 'theplus' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],				
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'theplus' ),
				'default' => [
					'url' => '#',
				],
				'show_external' => false,
				'condition' => [
					'show_register' => 'yes',	
					'show_register_opt' => 'custom',
				],
			]
		);
		$this->add_control(
			'redirect_after_login',
			[
				'label' => esc_html__( 'Redirect After Login', 'theplus' ),
				'type'  => Controls_Manager::SWITCHER,
				'separator' => 'before',				
			]
		);

		$this->add_control(
			'redirect_url',
			[
				'type'          => Controls_Manager::URL,
				'show_label'    => false,
				'show_external' => false,
				'separator'     => false,
				'placeholder'   => 'http://your-link.com/',
				'description'   => esc_html__( 'Note: Because of security reasons, you can ONLY use your current domain here.', 'theplus' ),
				'condition'     => [
					'redirect_after_login' => 'yes',
				],
			]
		);			
		$this->end_controls_section();
		/*login option end*/
		
		/*register option start*/
		$this->start_controls_section(
			'section_forms_register_options',
			[
				'label' => esc_html__( 'Register Options', 'theplus' ),
				'condition' => [					
					'form_selection' => ['tp_register','tp_login_register'],					
				],
			]
		);		
		$this->add_control(
			'tab_com_signup',
			[
				'label'   => esc_html__( 'Register Tab Title', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Sign Up', 'theplus' ),
				'condition' => [
					'form_selection' => 'tp_login_register',
				],
			]
		);
		$this->add_control(
			'show_labels_reg',
			[
				'label'   => esc_html__( 'Form Label', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'form_selection!' => ['tp_forgot_password'],
				],
			]
		);
		/*register custom label*/
		$this->add_control(
			'custom_labels_reg',
			[
				'label'     => esc_html__( 'Form Custom Label', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'show_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'first_name_label',
				[
				'label'     => esc_html__( 'First Name Label', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'First Name', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'show_labels_reg'   => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'first_name_placeholder',
			[
				'label'     => esc_html__( 'First Name Placeholder', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'John', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'show_labels_reg'   => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'last_name_label',
				[
				'label'     => esc_html__( 'Last Name Label', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Last Name', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'show_labels_reg'   => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
			);
		$this->add_control(
			'last_name_placeholder',
			[
				'label'     => esc_html__( 'Last Name Placeholder', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Doe', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'show_labels_reg'   => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'email_label',
			[
				'label'     => esc_html__( 'Email Label', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Email', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'show_labels_reg' => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'email_placeholder',
			[
				'label'     => esc_html__( 'Email Placeholder', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'example@email.com', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'show_labels_reg'   => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'r_password_label',
			[
				'label'     => esc_html__( 'Password Label', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Password', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'tp_dis_pass_field' => 'yes',
					'show_labels_reg' => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'r_password_placeholder',
			[
				'label'     => esc_html__( 'Password Placeholder', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '****', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'tp_dis_pass_field' => 'yes',
					'show_labels_reg'   => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'r_conf_password_label',
			[
				'label'     => esc_html__( 'Confirm Password Label', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Confirm Password', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'tp_dis_pass_field' => 'yes',
					'show_labels_reg' => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'r_conf_password_placeholder',
			[
				'label'     => esc_html__( 'Confirm Password Placeholder', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '****', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'tp_dis_pass_field' => 'yes',
					'show_labels_reg'   => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'r_mail_chimp_label',
			[
				'label'     => esc_html__( 'MailChimp Label', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Yes, Please subscribe me for Newsletters.', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'tp_mail_chimp_subscribe_opt' => 'yes',					
				],
			]
		);
		$this->add_control(
			'r_terms_conition_label',
			[
				'label'     => esc_html__( 'Terms & Condition Label', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'I agree, With Terms of Conditions before signing up.', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
					'tp_terms_condition_opt' => 'yes',
				],
			]
		);
		
		/*register custom label*/
		$this->add_control(
			'redirect_after_register',
			[
				'label' => esc_html__( 'Redirect After Register', 'theplus' ),
				'type'  => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'redirect_url_reg',
			[
				'type'          => Controls_Manager::URL,
				'show_label'    => false,
				'show_external' => false,
				'separator'     => false,
				'placeholder'   => 'http://your-link.com/',
				'description'   => esc_html__( 'Note: Because of security reasons, you can ONLY use your current domain here.', 'theplus' ),
				'condition'     => [
					'redirect_after_register' => 'yes',
				],
			]
		);
		$this->add_control(
			'auto_loggedin',
			[
				'label' => esc_html__( 'Auto Login After Register ', 'theplus' ),
				'type'  => Controls_Manager::SWITCHER,
				'condition'     => [
					'tp_dis_pass_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_login',
			[
				'label' => esc_html__( 'Login', 'theplus' ),
				'type'  => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'bottom_login_text',
			[
				'label'     => esc_html__( 'Login Text', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Login', 'theplus' ),
				'condition' => [
					'show_login' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_login_opt',
			[
				'label' => esc_html__( 'Login Link Selection', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Default', 'theplus' ),
					'custom' => esc_html__( 'Custom', 'theplus' ),
				],
				'condition'     => [
					'show_login' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_login_opt_link',
			[
				'label' => esc_html__( 'Link', 'theplus' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],				
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'theplus' ),
				'default' => [
					'url' => '#',
				],
				'show_external' => false,
				'condition' => [
					'show_login' => 'yes',	
					'show_login_opt' => 'custom',
				],
				]
		);
		$this->add_control(
			'login_before_text',
			[
				'label'     => esc_html__( 'Login Before Text', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Already have an account?', 'theplus' ),
				'condition' => [
					'show_login' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_logged_in_message_reg',
			[
				'label'   => esc_html__( 'After login Panel', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'show_additional_message',
			[
				'label' => esc_html__( 'Additional Bottom Message', 'theplus' ),
				'type'  => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'additional_message',
			[
				'label'     => esc_html__( 'Additional Message', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Note: Your password will be generated automatically and sent to your email address.', 'theplus' ),
				'condition' => [
					'show_additional_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_text_reg',
			[
				'label'   => esc_html__( 'Register Button Text', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Register', 'theplus' ),
				'separator' => 'before',
				'condition' => [
					'form_selection!' => ['tp_login','tp_forgot_password'],
				],
			]
		);
		$this->end_controls_section();
		
		/*social login start*/
		$this->start_controls_section(
			'content_social_login',
			[
				'label' => esc_html__( 'Social Login/Signup', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'form_selection!' => 'tp_forgot_password',
				],
				
			]
		);
		$this->add_control(
			'content_social_login_heading',
			[
				'label' => esc_html__( 'Note : You need to add App id(Facebook) and Client Id(Google) from The Plus Settings - Extra Options to make social login/signup working.', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,				
			]
		);
		$this->add_control(
			'tp_sl_facebook',
			[
				'label' => esc_html__( 'Facebook', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'tp_sl_google',
			[
				'label' => esc_html__( 'Google', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			's_icon_align',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
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
				'default' => 'flex-start',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-social-login-wrapper' => 'justify-content: {{VALUE}};',					
				],
				
			]
		);
		$this->add_control(
			'redirect_url_social_head',
			[
				'label' => esc_html__( 'Redirect URL', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);		
		$this->add_control(
			'redirect_url_social',
			[
				'type'          => Controls_Manager::URL,
				'show_label'    => false,
				'show_external' => false,
				'separator'     => false,
				'placeholder'   => 'http://your-link.com/',				
			]
		);	
		$this->add_control(
			'hide_form',
			[
				'label' => esc_html__( 'Hide Form', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'form_selection' => ['tp_register','tp_login'],
					'_skin' => 'default',
				],
			]
		);
		$this->end_controls_section();
		/*social login end*/
		
		/*Mailchimp Individual List ID & API Key start*/
		$this->start_controls_section(
			'mc_i_li_ak',
			[
				'label' => esc_html__( 'Mailchimp Individual List ID & API Key', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'tp_mail_chimp_subscribe_opt' => 'yes',
				],
				
			]
		);
		$this->add_control(
			'mc_i_li_ak_swtch',
			[
				'label' => esc_html__( 'Individual List ID & API Key', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'mc_custom_apikey',
			[
				'label'     => esc_html__( 'API Key', 'theplus' ),
				'type'      => Controls_Manager::TEXT,				
				'separator' => 'before',
				'condition' => [
					'mc_i_li_ak_swtch' => 'yes',
				],
			]
		);
		$this->add_control(
			'mc_custom_apikey_desc',
			[
				'label' => 'Go to your Mailchimp > Account > Extras > API Keys then create a key and paste here',
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'mc_i_li_ak_swtch' => 'yes',
				],
			]
		);
		$this->add_control(
			'mc_custom_listid',
			[
				'label'     => esc_html__( 'List ID', 'theplus' ),
				'type'      => Controls_Manager::TEXT,				
				'separator' => 'before',
				'condition' => [
					'mc_i_li_ak_swtch' => 'yes',
				],
			]
		);
		$this->add_control(
			'mc_custom_listid_desc',
			[
				'label' => 'Go to your Mailchimp > List > Settings > List name and default > Copy the list ID and paste here.',
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'mc_i_li_ak_swtch' => 'yes',
				],
			]
		);		
		$this->end_controls_section();
		/*Mailchimp Individual List ID & API Key end*/
		
		/*reset password start*/
		$this->start_controls_section(
			'content_reset_pass_section',
			[
				'label' => esc_html__( 'Reset Password', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'form_selection' => ['tp_forgot_password'],
					'f_p_opt' => 'f_p_frontend',
				],
			]
		);
		$this->add_control(
			'res_pass_placeholder',
			[
				'label'     => esc_html__( 'Reset Password Placeholder', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '****', 'theplus' ),
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'res_conf_pass_placeholder',
			[
				'label'     => esc_html__( 'Reset Confirm Password Placeholder', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '****', 'theplus' ),
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'reset_pass_btn',
			[
				'label'   => esc_html__( 'Reset Password Button Text', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Reset Password', 'theplus' ),
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*reset password end*/
		
		/*forgot password start*/
		$this->start_controls_section(
			'section_forms_loast_pass_options',
			[
				'label' => esc_html__( 'Lost Password Options', 'theplus' ),
				'conditions'   => [
					'terms' => [
						[
							'relation' => 'or',
							'terms'    => [
								[
									'name'     => 'form_selection','operator' => '==','value'    => 'tp_forgot_password',
								],
								[
									'name'     => 'show_lost_password','operator' => '==','value'    => 'yes',
								],								
							],
						],
					],
				],
			]
		);
		$this->add_control(
			'lost_pass_placeholder',
			[
				'label'     => esc_html__( 'Lost Password Placeholder', 'theplus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Username/Email', 'theplus' ),				
			]
		);
		$this->add_control(
			'forgot_pass_btn',
			[
				'label'   => esc_html__( 'Lost Password Button Text', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Email Reset Link', 'theplus' ),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'lost_password_heading_desc',
			[
				'label' => esc_html__( 'Lost Password Heading', 'theplus' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'rows' => 10,
				'default' => esc_html__( 'Lost your password?', 'theplus' ),
				'placeholder' => esc_html__( 'Type your Lost password description here', 'theplus' ),
			]
		);
		$this->end_controls_section();
		/*forgot password end*/
		
		/**/
		$this->start_controls_section(
			'section_forms_after_login_panel_options',
			[
				'label' => esc_html__( 'My Account Panel', 'theplus' ),
				'condition' => [
					'form_selection!' => ['tp_forgot_password'],
				],
			]
		);
		$this->add_control(
			'show_logged_in_message',
			[
				'label'   => esc_html__( 'My Account Panel', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);		
		$this->add_control(
			'after_login_panel_align',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
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
				'default' => 'flex-start',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf.aflp' => 'justify-content: {{VALUE}};display:flex',					
				],
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'edit_profile_text_switch',
			[
				'label' => esc_html__( 'Edit Pofile', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'yes',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'edit_profile_text',
			[
				'label'   => esc_html__( 'Edit Pofile Text', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Edit Profile', 'theplus' ),
				'condition' => [
					'show_logged_in_message' => 'yes',
					'edit_profile_text_switch' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_text_logout_switch',
			[
				'label' => esc_html__( 'Logout Text', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_text_logout',
			[
				'label'   => esc_html__( 'Logout Text', 'theplus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Logout', 'theplus' ),
				'condition' => [
					'show_logged_in_message' => 'yes',
					'button_text_logout_switch' => 'yes',
				],
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'loop_title',
			[
				'label' => esc_html__( 'Title', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Download', 'theplus' ),
				'dynamic' => ['active'   => true,],
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
		$this->add_control(
            'loop_content',
            [
				'label' => esc_html__( 'Extra Menu', 'theplus' ),
                'type' => Controls_Manager::REPEATER,               
                'separator' => 'before',
				'fields' => $repeater->get_controls(),
                'title_field' => '{{{ loop_title }}}',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
            ]
        );
		$this->end_controls_section();
		/*my account panel end*/
		
		/*notification start*/
		$this->start_controls_section(
			'section_msg_options',
			[
				'label' => esc_html__( 'Notification Message', 'theplus' ),
				'condition' => [
					'form_selection!' => ['tp_forgot_password'],
				],
			]
		);
		$this->add_control(
			'login_msg',
			[
				'label' => esc_html__( 'Login Message Option', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'login_msg_loading_txt',
			[
				'label' => esc_html__( 'Loading text', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Please Wait...', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'login_msg_success',
			[
				'label' => esc_html__( 'Success text', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Login Successful.', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'login_msg_validation',
			[
				'label' => esc_html__( 'Validation text', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Ops! Wrong username or password!', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'login_msg_error',
			[
				'label' => esc_html__( 'Error text', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Something Wrong. Please try again.', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'register_msg',
			[
				'label' => esc_html__( 'Register Message Option', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'reg_msg_loading',
			[
				'label' => esc_html__( 'Loading text', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Please wait...', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
				],
			]
		);
		
		$this->add_control(
			'reg_msg_success',
			[
				'label' => esc_html__( 'Success text', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Registration Successful.', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'reg_msg_email_duplication',
			[
				'label' => esc_html__( 'Email Validate', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'An account exists with this email address.', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'reg_msg_error',
			[
				'label' => esc_html__( 'Error Text', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Something Wrong. Please try again.', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
				],
			]
		);
		
		$this->add_control(
			'forgot_msg',
			[
				'label' => esc_html__( 'Lost Password Message Option', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',				
			]
		);
		$this->add_control(
			'fp_msg_loading',
			[
				'label' => esc_html__( 'Loading text', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Please wait...', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),				
			]
		);
		
		$this->add_control(
			'fp_msg_success',
			[
				'label' => esc_html__( 'Success text', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Link Send to Your Mail', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),				
			]
		);
		$this->add_control(
			'fp_msg_error',
			[
				'label' => esc_html__( 'Error text', 'theplus' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Something Wrong. Please try again.', 'theplus' ),
				'placeholder' => esc_html__( 'Type here', 'theplus' ),
			]
		);
		$this->end_controls_section();
		/*section  end*/
		
		/*Layout width option login start*/
		$this->start_controls_section(
			'log_section_layout_size_options',
			[
				'label' => esc_html__( 'Login Field Layout Size', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'l_field_heading',
			[
				'label' => esc_html__( 'You can set seprate width of field', 'theplus' ),
				'type' => Controls_Manager::HEADING,
			]
		);
		$this->add_responsive_control(
            'l_ls_user_name',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('User Name', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-l-lr-user-name' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'l_ls_password',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Password', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-l-lr-password' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'l_ls_rememberme',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Remember Me', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-remember-me' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
            ]
        );
		$this->end_controls_section();
		/*Layout width option login end*/
		
		/*Reset Password start*/
		$this->start_controls_section(
			'section_reset_pass_options',
			[
				'label' => esc_html__( 'Reset Password Option', 'theplus' ),				
			]
		);
		$this->add_control(
			'tp_dp_reset_field_strong',
			[
				'label' => esc_html__( 'Reset Strong Password', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->end_controls_section();
		/*Layout width option login end*/
		
		/*Layout width option register start*/
		$this->start_controls_section(
			'section_layout_size_options',
			[
				'label' => esc_html__( 'Register Field Layout Size', 'theplus' ),
				'condition' => [
					'form_selection' => ['tp_register','tp_login_register'],
				],
			]
		);
		$this->add_control(
			'field_heading',
			[
				'label' => esc_html__( 'You can set seprate width of field', 'theplus' ),
				'type' => Controls_Manager::HEADING,
			]
		);
		$this->add_responsive_control(
            'ls_fisrt_name',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('First Name', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-lr-f-first-name' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'ls_last_name',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Last Name', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-lr-f-last-name' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'ls_email_field',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Email', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-lr-f-email' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'ls_password_field',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Password', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-lr-f-user-pass,{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-lr-f-user-conf-pass' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'ls_mail_chimp_sub_field',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('MailChimp Subscribe', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-lr-f-mail-chimp-sub' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'ls_terms_condition_field',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Terms & Conditions', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-lr-f-tac' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'ls_aditional_msg_field',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Additional Message', 'theplus'),
				'size_units' => [ '%' ],
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked .tp-lr-f-add-msg' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
            ]
        );
		$this->end_controls_section();
		/*Layout width option end*/		
		
		/*style start*/
		/*label style start*/
		$this->start_controls_section(
            'section_label_style',
            [
                'label' => esc_html__('Form Label', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .tp-field-group .tp-form-label',
			]
		);		
		$this->add_control(
            'label_color',
            [
                'label' => esc_html__('Label Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#888',
                'selectors' => [
                    '{{WRAPPER}} .tp-field-group .tp-form-label' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->end_controls_section();
		/*label style end*/
		
		/*field style start*/
		$this->start_controls_section(
            'section_field_style',
            [
                'label' => esc_html__('Form Input Fields', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'field_typography',
				'selector' => '{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input',
			]
		);	
		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input::placeholder,
					{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input::placeholder,
					{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input::placeholder' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_responsive_control(
			'input_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'input_inner_margin',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'tabs_input_field_style' );
		$this->start_controls_tab(
			'tab_input_field_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'input_field_color',
			[
				'label'     => esc_html__( 'Text Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'input_field_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_input_field_focus',
			[
				'label' => esc_html__( 'Focus', 'theplus' ),
			]
		);
		$this->add_control(
			'input_field_focus_color',
			[
				'label'     => esc_html__( 'Text Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input:focus,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input:focus,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input:focus' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'input_field_focus_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input:focus,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input:focus,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'input_border_options',
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
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input' => 'border-style: {{VALUE}} !important;',
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
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
			]
		);
		$this->add_control(
			'box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input' => 'border-color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html__( 'Focus', 'theplus' ),
			]
		);
		$this->add_control(
			'box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input:focus,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input:focus,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input:focus' => 'border-color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input:focus,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input:focus,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
				'selector' => '{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input',
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
				'selector' => '{{WRAPPER}} .tp-field-group .tp-form-controls .tp-input:focus,{{WRAPPER}} .tp-form-stacked-fp .tp-ulp-input-group .tp-input:focus,{{WRAPPER}} .tp-form-stacked-reset .tp-ulp-input-group .tp-input:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*field style end*/
		
		/*button style start*/
		$this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__('Form Button', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );
		$this->add_control(
			'button_align',
			[
				'label' => esc_html__( 'Button Alignment', 'theplus' ),
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
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .elementor-field-type-submit.tp-field-group' => 'text-align: {{VALUE}};',					
				],
			]
		);
		$this->add_control(
			'button_text_align',
			[
				'label' => esc_html__( 'Text Alignment', 'theplus' ),
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
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .elementor-field-type-submit.tp-field-group .tp-button,
					{{WRAPPER}} .tp-forg-pass-form .tp-form-stacked-fp button.tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass' => 'text-align: {{VALUE}};',					
				],
			]
		);
		$this->add_responsive_control(
            'button_max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'theplus'),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
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
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,
					{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass' => 'max-width: {{SIZE}}{{UNIT}} !important',
				],
				'separator' => 'after',
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass',
			]
		);
		$this->add_responsive_control(
			'button_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass',
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
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button:hover,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp:hover,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_hover_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button:hover,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp:hover,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass:hover',
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
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass' => 'border-style: {{VALUE}} !important;',
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
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
			]
		);
		$this->add_control(
			'button_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass' => 'border-color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_border_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'button_box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button:hover,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp:hover,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass:hover' => 'border-color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button:hover,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp:hover,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
				'selector' => '{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass',
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
				'selector' => '{{WRAPPER}} .tp-form-stacked .elementor-field-type-submit .tp-button:hover,{{WRAPPER}} .tp-form-stacked-fp  .tp-button-fp:hover,{{WRAPPER}} .tp-reset-pass-form .tp-form-stacked-reset button.tp-button-reset-pass:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*button style end*/
		
		/*hover/click/popup style start*/
		$this->start_controls_section(
            'section_hover_click_popup_style',
            [
                'label' => esc_html__('Hover/Click/Popup Button', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection!' => ['tp_forgot_password'],
					'_skin!' => 'default',
				],
            ]
        );
		$this->add_responsive_control(
            'tab_icon_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Right Padding', 'theplus'),
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
					'{{WRAPPER}} .tp-wp-lrcf .elementor-button-content-wrapper i,
					{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap .tp-ursp-btn i' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
            'tab_icon_size_font',
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
					'{{WRAPPER}} .tp-wp-lrcf .elementor-button-content-wrapper i,
					{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap .tp-ursp-btn i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_control(
			'tab_icon_color_n',
			[
				'label' => esc_html__( 'Normal Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .elementor-button-content-wrapper i,
					{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap .tp-ursp-btn i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tab_icon_color_h',
			[
				'label' => esc_html__( 'Hover Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf a:hover .elementor-button-content-wrapper i,
					{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap .tp-ursp-btn:hover i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
            'hcp_button_max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'theplus'),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
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
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn' => 'max-width: {{SIZE}}{{UNIT}} !important;width: {{SIZE}}{{UNIT}} !important',
				],
				'separator' => 'before',
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'hcp_button_typography',
				'selector' => '{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
							{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
							{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn',
			]
		);
		$this->add_responsive_control(
			'hcp_button_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'hcp_button_margin',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'tabs_hcp_button_style' );
		$this->start_controls_tab(
			'tab_hcp_button_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'hcp_button_color',
			[
				'label'     => esc_html__( 'Text Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'hcp_button_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
							{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
							{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_hcp_button_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'hcp_button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn:hover,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown:hover,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn:hover,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn:hover,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown:hover,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn:hover,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn:hover,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown:hover,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'hcp_button_hover_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn:hover,
							{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown:hover,
							{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn:hover,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn:hover,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown:hover,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn:hover,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn:hover,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown:hover,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'hcp_button_border_options',
			[
				'label' => esc_html__( 'Border Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'hcp_button_box_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'hcp_button_border_style',
			[
				'label' => esc_html__( 'Border Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn' => 'border-style: {{VALUE}} !important;',
				],
				'condition' => [
					'hcp_button_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'hcp_button_box_border_width',
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
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'hcp_button_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_hcp_button_border_style' );
		$this->start_controls_tab(
			'tab_hcp_button_border_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'hcp_button_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,				
				'selectors'  => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'hcp_button_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'hcp_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_hcp_button_border_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
			'hcp_button_box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn:hover,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown:hover,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn:hover,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn:hover,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown:hover,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn:hover,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn:hover,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown:hover,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn:hover' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'hcp_button_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'hcp_button_border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn:hover,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown:hover,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn:hover,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn:hover,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown:hover,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn:hover,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn:hover,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown:hover,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'hcp_button_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_hcp_button_shadow_style' );
		$this->start_controls_tab(
			'tab_hcp_button_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'hcp_button_shadow',
				'selector' => '{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn,
							{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown,
							{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown,
							{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown,
							{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_hcp_button_shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'hcp_button_hover_shadow',
				'selector' => '{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-lr-model-btn:hover,
						{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .tp-button-dropdown:hover,
						{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-ulsp-btn:hover,
						{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-lr-model-btn:hover,
						{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .tp-button-dropdown:hover,
						{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-ursp-btn:hover,
						{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-btn:hover,
						{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-button-dropdown:hover,
						{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*hover/click/popup style end*/
		
		/*close image option start*/
		$this->start_controls_section(
            'section_close_img_style',
            [
                'label' => esc_html__('Click/Popup Close Button', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'_skin' => ['tp-modal','tp-popup'],
				],
            ]
        );
		$this->add_responsive_control(
			'close_icon_size',
			[
				'label' => esc_html__( 'Width', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 300,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .lr-close-custom_img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',					
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'close_icon_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .lr-close-custom_img',
			]
		);
		$this->add_responsive_control(
			'close_icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .lr-close-custom_img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'close_icon_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'theplus' ),
				'selector' => '{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .lr-close-custom_img',
			]
		);
		
		$this->end_controls_section();
		/*close image option end*/
		
		/*form heading option start*/		
		$this->start_controls_section(
            'section_form_heading_style',
            [
                'label' => esc_html__('Heading Option', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );	
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_heading_typography',
				'selector' => '{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-modal-header h2,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-popup-header h2,
					{{WRAPPER}} .tp-l-r-main-wrapper .tp-tab-content-inner.tab-signup .tp-popup-header h2,
					{{WRAPPER}} .tp-user-login tp-user-login-skin-modal .tp-modal-header h2,
					{{WRAPPER}} .tp-user-login tp-user-login-skin-popup .tp-popup-header h2,
					{{WRAPPER}} .tp-l-r-main-wrapper .tp-tab-content-inner.tab-login .tp-popup-header h2,
					{{WRAPPER}} .tp-form-stacked-fp .tp-forgot-password-label,
					{{WRAPPER}} .tp-form-stacked-fp .tp-forgot-password-label p,
					{{WRAPPER}} .tp-wp-lrcf .tp-modal-title,{{WRAPPER}} .tp-wp-lrcf .tp-modal-title p,
					{{WRAPPER}} .tp-wp-lrcf .tp-popup-header,{{WRAPPER}} .tp-wp-lrcf .tp-popup-header p',
			]
		);
		$this->add_control(
			'form_heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-modal-header h2,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-popup-header h2,
					{{WRAPPER}} .tp-l-r-main-wrapper .tp-tab-content-inner.tab-signup .tp-popup-header h2,
					{{WRAPPER}} .tp-user-login tp-user-login-skin-modal .tp-modal-header h2,
					{{WRAPPER}} .tp-user-login tp-user-login-skin-popup .tp-popup-header h2,
					{{WRAPPER}} .tp-l-r-main-wrapper .tp-tab-content-inner.tab-login .tp-popup-header h2,
					{{WRAPPER}} .tp-form-stacked-fp .tp-forgot-password-label,
					{{WRAPPER}} .tp-form-stacked-fp .tp-forgot-password-label p,
					{{WRAPPER}} .tp-wp-lrcf .tp-modal-title,{{WRAPPER}} .tp-wp-lrcf .tp-modal-title p,
					{{WRAPPER}} .tp-wp-lrcf .tp-popup-header,{{WRAPPER}} .tp-wp-lrcf .tp-popup-header p' => 'color: {{VALUE}}',
				],				
			]
		);
		$this->end_controls_section();		
		/*form heading option end*/
		
		/*register  Additional msg option start*/
		$this->start_controls_section(
            'section_form_reg_adi_msg_style',
            [
                'label' => esc_html__('Register Additional Message', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_additional_message' => 'yes',
				],
            ]
        );	
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_reg_adi_msg_typography',
				'selector' => '{{WRAPPER}} .tp-field-group .tp-register-additional-message',
			]
		);
		$this->add_control(
			'form_reg_adi_msgcolor',
			[
				'label' => esc_html__( 'Heading Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-field-group .tp-register-additional-message' => 'color: {{VALUE}}',
				],				
			]
		);
		$this->end_controls_section();		
		/*register  Additional msg option end*/
		
		/*rememberme start*/
		$this->start_controls_section(
            'section_remember_me_style',
            [
                'label' => esc_html__('Remember Me', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => ['tp_login','tp_login_register'],
					'show_remember_me' => 'yes',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'checkbox_typography',
				'selector' => '{{WRAPPER}} .tp-field-group.tp-remember-me .tp-form-label .remember-me-label',
			]
		);
		$this->add_control(
			'checked_txt_color',
			[
				'label'     => esc_html__( 'Remember Me color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-field-group.tp-remember-me .tp-form-label .remember-me-label' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);		
		$this->add_control(
			'unchecked_field_bgcolor',
			[
				'label'     => esc_html__( 'UnChecked Bg Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-field-group.tp-remember-me [type="checkbox"]:checked + label:before,
					{{WRAPPER}} .tp-field-group.tp-remember-me [type="checkbox"]:not(:checked) + label:before' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'checked_field_bgcolor',
			[
				'label'     => esc_html__( 'Checked Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-field-group.tp-remember-me [type="checkbox"]:checked + label:after,
					{{WRAPPER}} .tp-field-group.tp-remember-me [type="checkbox"]:not(:checked) + label:after' => 'background: {{VALUE}};',
				],
			]
		);		
		$this->end_controls_section();
		/*remember me end*/
		/*Lost Password/Register Text Styling option start*/		
		$this->start_controls_section(
            'section_extra_link_opt_style',
            [
                'label' => esc_html__('Lost Password/Register Text Styling', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_extra_link_typography',
				'selector' => '{{WRAPPER}} .tp-user-login-password .tp-lost-password,
				{{WRAPPER}} .tp-user-login-password .tp-register,
				{{WRAPPER}} .tp-user-register-password .tp-login',
			]
		);
		$this->add_control(
			'form_extra_link_color',
			[
				'label' => esc_html__( 'Text color', 'theplus' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .tp-user-login-password .tp-lost-password,
				{{WRAPPER}} .tp-user-login-password .tp-register,
				{{WRAPPER}} .tp-user-register-password .tp-login' => 'color: {{VALUE}}',
				],				
			]
		);
		$this->add_responsive_control(
            'form_extra_link_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Right Space', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],
				'render_type' => 'ui',			
				'selectors' => [
					'{{WRAPPER}} .tp-user-login-password .tp-lost-password,
				{{WRAPPER}} .tp-user-login-password .tp-register,
				{{WRAPPER}} .tp-user-register-password .tp-login' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
            ]
        );		
		$this->end_controls_section();		
		/*Lost Password/Register Text Styling option end*/
		
		/*Lost Password Back Arrow Styling start*/
		$this->start_controls_section(
            'section_lost_pass_btn_style',
            [
                'label' => esc_html__('Lost Password Back Arrow Styling', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection!' => ['tp_forgot_password'],
					'show_lost_password' => 'yes',
				],
            ]
        );		
		$this->add_control(
			'lpba_icon',
			[
				'label' => esc_html__( 'Back Arrow', 'theplus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-arrow-circle-left',
					'library' => 'solid',
				],
			]
		);
		$this->add_responsive_control(
            'lost_pass_btn_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 300,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-form-stacked-fp .tp-lpu-back i:before' => 'font-size: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_control(
			'lost_pass_btn_color',
			[
				'label' => esc_html__( 'Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-form-stacked-fp .tp-lpu-back i:before' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		/*Lost Password Back Arrow Styling end*/
		
		/*mailchimp style start*/
		$this->start_controls_section(
            'section_mail_chimp_dyn_style',
            [
                'label' => esc_html__('MailChimp', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [					
					'tp_mail_chimp_subscribe_opt' => 'yes',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mail_chimp_dyn_typography',
				'selector' => '{{WRAPPER}} .tp-wp-lrcf .tp-lr-f-mail-chimp-sub .tp-form-label',
			]
		);		
		$this->add_control(
            'mail_chimp_dyn_color',
            [
                'label' => esc_html__('Text Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#888',
                'selectors' => [
                    '{{WRAPPER}} .tp-wp-lrcf .tp-lr-f-mail-chimp-sub .tp-form-label' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->add_control(
			'mail_chimp_chk_box_opt',
			[
				'label' => __( 'Checkbox Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',				
			]
		);
		$this->start_controls_tabs( 'mc_ckhbox_tabs' );
		$this->start_controls_tab(
			'mc_unchk_tab',
			[
				'label' => esc_html__( 'Uncheck', 'theplus' ),					
			]
		);
		$this->add_control(
			'mc_unchk_bg',
			[
				'label' => esc_html__( 'Background Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .user_mail_chimp_subscribe_checkbox' => 'background: {{VALUE}}',
				],					
			]
		);
		$this->add_control(
			'mc_unchk_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .user_mail_chimp_subscribe_checkbox' => 'border-color: {{VALUE}}',
				],					
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'mc_chk_tab',
			[
				'label' => esc_html__( 'Check', 'theplus' ),					
			]
		);
		$this->add_control(
			'mc_chk_bg',
			[
				'label' => esc_html__( 'Check Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .user_mail_chimp_subscribe_checkbox:before,{{WRAPPER}} .tp-wp-lrcf .user_mail_chimp_subscribe_checkbox:after' => 'background: {{VALUE}}',
				],					
			]
		);		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		/*mailchimp style end*/
		
		/*terms & condition style start*/
		$this->start_controls_section(
            'section_t_a_c_style',
            [
                'label' => esc_html__('Terms & Condition', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [					
					'tp_terms_condition_opt' => 'yes',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tac_typography',
				'selector' => '{{WRAPPER}} .tp-wp-lrcf .tp-lr-f-tac .tp-form-label',
			]
		);		
		$this->add_control(
            'tac_dyn_color',
            [
                'label' => esc_html__('Text Color', 'theplus'),
                'type' => Controls_Manager::COLOR,
                'default' => '#888',
                'selectors' => [
                    '{{WRAPPER}} .tp-wp-lrcf .tp-lr-f-tac .tp-form-label' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->add_control(
			'tac_chk_box_opt',
			[
				'label' => __( 'Checkbox Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',				
			]
		);
		$this->start_controls_tabs( 'tac_ckhbox_tabs' );
		$this->start_controls_tab(
			'tac_unchk_tab',
			[
				'label' => esc_html__( 'Uncheck', 'theplus' ),					
			]
		);
		$this->add_control(
			'tac_unchk_bg',
			[
				'label' => esc_html__( 'Background Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .user_tac_checkbox' => 'background: {{VALUE}}',
				],					
			]
		);
		$this->add_control(
			'tac_unchk_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .user_tac_checkbox' => 'border-color: {{VALUE}}',
				],					
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tac_chk_tab',
			[
				'label' => esc_html__( 'Check', 'theplus' ),					
			]
		);
		$this->add_control(
			'tac_chk_bg',
			[
				'label' => esc_html__( 'Check Icon Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .tp-wp-lrcf .user_tac_checkbox:before,{{WRAPPER}} .tp-wp-lrcf .user_tac_checkbox:after' => 'background: {{VALUE}}',
				],					
			]
		);		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		/*mailchimp style end*/
		
		/*LR combo style start*/
		$this->start_controls_section(
            'section_lr_tabbing_style',
            [
                'label' => esc_html__('Login/Register Tabbing', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => 'tp_login_register',
				],
            ]
        );
		$this->add_responsive_control(
			'lr_tabbing_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'lr_tabbing_typo',
						'label' => esc_html__( 'Typography', 'theplus' ),				
						'selector' => '{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab',
				'separator' => 'before',
			]
		);	
		$this->add_responsive_control(
            'lr_tabbing_max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'theplus'),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
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
					'{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab' => 'max-width: {{SIZE}}{{UNIT}} !important;min-width: {{SIZE}}{{UNIT}} !important',
				],
				'separator' => 'before',
            ]
        );	
		$this->start_controls_tabs('lr_combo_tabs');
		$this->start_controls_tab('lr_combo_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
		'lr_combo_color_normal',
		[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,			
				'selectors' => [
					'{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'lr_combo_bg_normal',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab',
			]
		);
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'lr_combo_border_normal',
					'label' => esc_html__( 'Border', 'theplus' ),
					'selector' => '{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'lr_combo_border_radious_normal',
				[
					'label'      => esc_html__( 'Border Radius', 'theplus' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],					
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'lr_combo_shadow_normal',
				'selector' => '{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab',			
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab('lr_combo_active_tab',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_control(
		'lr_combo_color_active',
		[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,			
				'selectors' => [
					'{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab.active' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'lr_combo_bg_active',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab.active',				
			]
		);
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'lr_combo_border_active',
					'label' => esc_html__( 'Border', 'theplus' ),
					'selector' => '{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab.active',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'lr_combo_border_radious_active',
				[
					'label'      => esc_html__( 'Border Radius', 'theplus' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],					
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'lr_combo_shadow_active',
				'selector' => '{{WRAPPER}} .tp-lr-cl-100per .tp-l-r-main-wrapper .tp-l-r-tab.active',			
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		/*LR combo style start*/
		
		/*Notification Message style start*/
		$this->start_controls_section(
            'section_ajax_msg_option_style',
            [
                'label' => esc_html__('Notification Message Option', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );		
		$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'ajax_msg_typography',
						'label' => esc_html__( 'Typography', 'theplus' ),				
						'selector' => '{{WRAPPER}} .theplus-notification.active .tp-lr-response',				
			]
		);	
		$this->add_control(
				'ajax_msg_color',
				[
					'label' => esc_html__( 'Text Color', 'theplus' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .theplus-notification.active .tp-lr-response' => 'color: {{VALUE}}',
					],
					
				]
			);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'ajax_bg',
				'label' => esc_html__( 'Notification Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .theplus-notification.active',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*Notification Message style END*/
		
		/*Reset mail Message style start*/
		$this->start_controls_section(
            'section_reset_mail_option_style',
            [
                'label' => esc_html__('Reset Mail Expired/Invalid Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => ['tp_forgot_password'],
					'f_p_opt' => 'f_p_frontend',
				],
            ]
        );
		$this->add_responsive_control(
			'rmt_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-invalid-expired-key' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'rmt_margin',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-invalid-expired-key' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',				
			]
		);
		$this->add_responsive_control(
			'rmt_alignment',
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
				'default' => 'left',
				'selectors'  => [
					'{{WRAPPER}} .tp-invalid-expired-key' => 'text-align: {{VALUE}};',
				],				
			]
		);
		$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'rmt_typography',
						'label' => esc_html__( 'Typography', 'theplus' ),				
						'selector' => '{{WRAPPER}} .tp-invalid-expired-key',
			]
		);	
		$this->add_control(
				'rmt_msg_color',
				[
					'label' => esc_html__( 'Text Color', 'theplus' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .tp-invalid-expired-key' => 'color: {{VALUE}}',
					],
					
				]
			);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'rmt_bg',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .tp-invalid-expired-key',
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'rmt_border',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .tp-invalid-expired-key',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'rmt_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-invalid-expired-key' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'rmt_shadow',
				'selector' => '{{WRAPPER}} .tp-invalid-expired-key',
			]
		);
		$this->end_controls_section();
		/*reset mail Message style END*/
		
		/*logoutstyle start*/
		$this->start_controls_section(
            'section_logout_style',
            [
                'label' => esc_html__('After login Panel', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );
$this->add_responsive_control(
			'after_login_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .tp-user-login' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'after_login_panel_text',
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
					'justify' => [
						'title' => esc_html__( 'Justify', 'theplus' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .tp-user-login ul li' => 'text-align: {{VALUE}};justify-content: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'after_login_typography',
						'label' => esc_html__( 'Typography', 'theplus' ),				
						'selector' => '{{WRAPPER}} .after_login_btn_wrapper *,
						{{WRAPPER}} .after_login_btn_wrapper .tp-user-login .tp-list .tp-user-logged-out .tp-button,
						{{WRAPPER}} .after_login_btn_wrapper .tp-user-login ul .tp-user-name a,
						{{WRAPPER}} .after_login_btn_wrapper .tp-user-login ul .after_login_panel_link a',
			]
		);	
		$this->add_control(
				'after_login_color',
				[
					'label' => esc_html__( 'Text Color', 'theplus' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .after_login_btn_wrapper *,
						{{WRAPPER}} .after_login_btn_wrapper .tp-user-login .tp-list .tp-user-logged-out .tp-button,
						{{WRAPPER}} .after_login_btn_wrapper .tp-user-login ul .tp-user-name a,
						{{WRAPPER}} .after_login_btn_wrapper .tp-user-login ul .after_login_panel_link a' => 'color: {{VALUE}}',
					],
					
				]
			);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'after_login_bg',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .tp-user-login',
				'separator' => 'before',
			]
		);
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'after_login_border',
					'label' => esc_html__( 'Border', 'theplus' ),
					'selector' => '{{WRAPPER}} .after_login_btn_wrapper .tp-user-login',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'after_login_border_radious',
				[
					'label'      => esc_html__( 'Border Radius', 'theplus' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .after_login_btn_wrapper .tp-user-login' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],					
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'after_login_shadow',
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .tp-user-login',
			]
		);
		$this->add_control(
			'lr_al_img_head',
			[
				'label' => esc_html__( 'After Login Panel Image Style', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
            'lr_al_img_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],				
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main span .avatar' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'lr_al_img_border_n',
				'label' => esc_html__( 'Border', 'theplus' ),
				'selector' => '{{WRAPPER}} .tp-wp-lrcf .after_login_btn_wrapper .elementor-button-text .avatar',
			]
		);
		$this->add_responsive_control(
			'lr_al_img_border_radius_n',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-wp-lrcf .after_login_btn_wrapper .elementor-button-text .avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'lr_al_img_shadow_n',
				'selector' => '{{WRAPPER}} .tp-wp-lrcf .after_login_btn_wrapper .elementor-button-text .avatar',
			]
		);
		$this->add_control(
			'lr_al_head',
			[
				'label' => esc_html__( 'After Login Panel Button Style', 'theplus' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_al_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'lr_al_typo',
						'label' => esc_html__( 'Typography', 'theplus' ),				
						'selector' => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main span',
				'separator' => 'before',
			]
		);
$this->start_controls_tabs('lr_al_tabs');
		$this->start_controls_tab('lr_al_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
		'lr_al_color_normal',
		[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,			
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'lr_al_bg_normal',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main',
			]
		);
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'lr_al_border_normal',
					'label' => esc_html__( 'Border', 'theplus' ),
					'selector' => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'lr_al_border_radious_normal',
				[
					'label'      => esc_html__( 'Border Radius', 'theplus' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],					
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'lr_al_shadow_normal',
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main',			
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab('lr_al_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'theplus' ),
			]
		);
		$this->add_control(
		'lr_al_color_active',
		[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => \Elementor\Controls_Manager::COLOR,			
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main:hover  span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'lr_al_bg_active',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main:hover',				
			]
		);
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'lr_al_border_active',
					'label' => esc_html__( 'Border', 'theplus' ),
					'selector' => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main:hover',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'lr_al_border_radious_active',
				[
					'label'      => esc_html__( 'Border Radius', 'theplus' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],					
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'lr_al_shadow_active',
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main:hover',			
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*logout style END*/
		/*box content login register forgot option start*/
		$this->start_controls_section(
            'section_box_content_lrf_option_style',
            [
                'label' => esc_html__('Box Content Option', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection!' => ['tp_login_register'],
				],
            ]
        );		
		$this->add_responsive_control(
			'bc_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .lr-extra-div,{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .lr-extra-div  .tp-form-stacked-fp,	
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-modal,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-register-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-modal,
					{{WRAPPER}} .tp-wp-lrcf .tp-forg-pass-form .tp-form-stacked-fp,{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked-reset' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'bc_margin',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .lr-extra-div,{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .lr-extra-div  .tp-form-stacked-fp,		
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-modal,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-register-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-modal,
					{{WRAPPER}} .tp-wp-lrcf .tp-forg-pass-form .tp-form-stacked-fp,{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked-reset' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'bc_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .lr-extra-div,{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .lr-extra-div  .tp-form-stacked-fp,	
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-modal,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-register-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-modal,
					{{WRAPPER}} .tp-wp-lrcf .tp-forg-pass-form .tp-form-stacked-fp,{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked-reset',
			]
		);
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'bc_border',
					'label' => esc_html__( 'Border', 'theplus' ),
					'selector' => '{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .lr-extra-div,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-modal,
					{{WRAPPER}} .tp-user-register-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-modal,
					{{WRAPPER}} .tp-wp-lrcf .tp-forg-pass-form .tp-form-stacked-fp,{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked-reset',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'bc_border_radious',
				[
					'label'      => esc_html__( 'Border Radius', 'theplus' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked,
						{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .lr-extra-div,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-modal,
					{{WRAPPER}} .tp-user-register-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-modal,
					{{WRAPPER}} .tp-wp-lrcf .tp-forg-pass-form .tp-form-stacked-fp,{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked-reset' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],					
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'bc_shadow',
				'selector' => '{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .lr-extra-div,{{WRAPPER}} .tp-user-login.tp-user-login-skin-dropdown .lr-extra-div  .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login-skin-default .tp-form-stacked-fp,		
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-modal .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-modal,
					{{WRAPPER}} .tp-user-login.tp-user-login-skin-popup .tp-form-stacked-fp,
					{{WRAPPER}} .tp-user-register-skin-default .tp-form-stacked,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-modal .tp-modal-dialog,
					{{WRAPPER}} .tp-user-register.tp-user-register-skin-popup .tp-modal,
					{{WRAPPER}} .tp-wp-lrcf .tp-forg-pass-form .tp-form-stacked-fp,{{WRAPPER}} .tp-wp-lrcf .tp-form-stacked-reset',
			]
		);
		$this->end_controls_section();
		/*box content login register forgot option end*/
		
		/*box content login register combo option start*/
		$this->start_controls_section(
            'section_box_content_lrcom_option_style',
            [
                'label' => esc_html__('Box Content Option', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => 'tp_login_register',
				],
            ]
        );
		$this->add_responsive_control(
            'lrcom_max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'theplus'),
				'size_units' => ['px','vw'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 5,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per' => 'max-width: {{SIZE}}{{UNIT}} !important;min-width: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'_skin!' => 'default',
				],
				'separator' => 'after',
            ]
        );
		$this->add_responsive_control(
            'lrcom_max_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Height', 'theplus'),
				'size_units' => ['px','vh'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 5,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per' => 'max-height: {{SIZE}}{{UNIT}} !important;min-height: {{SIZE}}{{UNIT}} !important',
				],
				'condition' => [
					'_skin!' => 'default',
				],
				'separator' => 'after',
            ]
        );
		$this->add_responsive_control(
			'bc_com_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per .tp-form-stacked-fp,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per .tp-form-stacked-fp,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal .tp-form-stacked-fp,
					{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap:not(.tp-lr-combo) .tp-lr-cl-100per,
					{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap:not(.tp-lr-combo) .tp-lr-cl-100per .tp-form-stacked-fp' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'bc_com_margin',
			[
				'label' => esc_html__( 'Margin', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per .tp-form-stacked-fp,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per .tp-form-stacked-fp,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal,
					{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal .tp-form-stacked-fp,
					{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap:not(.tp-lr-combo) .tp-lr-cl-100per, 
					{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap:not(.tp-lr-combo) .tp-lr-cl-100per .tp-form-stacked-fp' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'bc_com_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per,
				{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per .tp-form-stacked-fp,
				{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per,
				{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per .tp-form-stacked-fp,
				{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal,
				{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal .tp-form-stacked-fp,
				{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap:not(.tp-lr-combo) .tp-lr-cl-100per,
				{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap:not(.tp-lr-combo) .tp-lr-cl-100per .tp-form-stacked-fp',
			]
		);
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'bc_com_border',
					'label' => esc_html__( 'Border', 'theplus' ),
					'selector' => '{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per,
						{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per,
						{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal,
						{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap:not(.tp-lr-combo) .tp-lr-cl-100per',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'bc_com_border_radious',
				[
					'label'      => esc_html__( 'Border Radius', 'theplus' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per,
						{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per,
						{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal,
						{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap:not(.tp-lr-combo) .tp-lr-cl-100per' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],					
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'bc_com_shadow',
				'selector' => '{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per,
						{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per,
						{{WRAPPER}} .tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal,
						{{WRAPPER}} .tp-wp-lrcf .tp-lr-comm-wrap:not(.tp-lr-combo) .tp-lr-cl-100per',
			]
		);
		$this->end_controls_section();
		/*box content login register combo option end*/		
		/*style start*/
	}
	
	public function form_fields_render_attributes() {
		$settings = $this->get_settings();
		$id       = 'lr'.$this->get_id();

		$this->add_render_attribute(
			[
				'submit-group' => [
					'class' => [
						'elementor-field-type-submit',
						'tp-field-group',
					],
				],							
				'dropdown-button-settings' => [
					'class' => [
						'elementor-button',
						'tp-button-dropdown',
					],
					'href' => 'javascript:void(0)',
				],
				'modal-button' => [
					'class' => [
						'elementor-button',
						'tp-button-modal',
					],					
				],
			]
		);

		if ( ! $settings['show_labels'] || ! $settings['show_labels_reg'] ) {
			$this->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
		}

		$this->add_render_attribute( 'field-group', 'class' )
			->add_render_attribute( 'input', 'required', true )
			->add_render_attribute( 'input', 'aria-required', 'true' );

	}
		
		
	protected function render_text_reg_dropdown() {
	
		$settings    = $this->get_settings();
		if(!empty($settings['loop_icon_fontawesome'])){
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['loop_icon_fontawesome'], [ 'aria-hidden' => 'true' ]);
			$list_img = ob_get_contents();
			ob_end_clean();						
		}
		
		if ( is_user_logged_in() && ! Theplus_Element_Load::elementor()->editor->is_edit_mode() ) {
			$button_text = esc_html__( $settings['button_text_logout'], 'theplus' );
		} else {
			$button_text = $settings['dropdown_button_text'];
		}
		
		?>

		<span class="elementor-button-content-wrapper">				
			<span class="elementor-button-text">
				<?php echo $list_img.esc_html($button_text); ?>
			</span>
		</span>
		<?php
	}
		
	protected function render_text() {
		$settings    = $this->get_settings();
		if(!empty($settings['loop_icon_fontawesome'])){
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['loop_icon_fontawesome'], [ 'aria-hidden' => 'true' ]);
			$list_img = ob_get_contents();
			ob_end_clean();						
		}
		
		if ( is_user_logged_in() && ! Theplus_Element_Load::elementor()->editor->is_edit_mode() ) {
			$button_text = esc_html__( $settings['button_text_logout'], 'theplus' );
		} else {
			$button_text = $settings['dropdown_button_text'];
		}
		
		?>
		<span class="elementor-button-content-wrapper">				
			<span class="elementor-button-text">
				<?php echo $list_img.esc_html($button_text); ?>
			</span>
		</span>
		<?php
	}
	protected function render_text_model() {
		$settings    = $this->get_settings();
		if(!empty($settings['loop_icon_fontawesome'])){
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['loop_icon_fontawesome'], [ 'aria-hidden' => 'true' ]);
			$list_img = ob_get_contents();
			ob_end_clean();						
		}
		if ( is_user_logged_in() && ! Theplus_Element_Load::elementor()->editor->is_edit_mode() ) {
			$button_text = esc_html__( $settings['button_text_logout'], 'theplus' );
		} else {
			$button_text = $settings['dropdown_button_text'];
		}
		
		?>
		<span class="elementor-button-content-wrapper">				
			<span class="elementor-button-text">
				<?php echo $list_img.esc_html($button_text); ?>
			</span>
		</span>
		<?php
	}
	
	
	public function render() {
	
		$settings    = $this->get_settings();
		$current_url = remove_query_arg( 'fake_arg' );
		$id          = 'lr'.$this->get_id();
		
		if(!empty($settings['loop_icon_fontawesome'])){
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['loop_icon_fontawesome'], [ 'aria-hidden' => 'true' ]);
			$list_img = ob_get_contents();
			ob_end_clean();						
		}
		
		
		if ( $settings['redirect_after_login'] && ! empty( $settings['redirect_url']['url'] ) ) {
			$redirect_url = $settings['redirect_url']['url'];
		} else {
			$redirect_url = $current_url;
		}
		
		
		if($settings['form_selection']=='tp_login_register'){
		
				$tp_login_registe_script ='<script>';
					$tp_login_registe_script .='jQuery(document).ready(function(){
							jQuery("#'.esc_attr($id).'.tp-l-r-main-wrapper .tp-l-r-tab").on("click", function(event) {
								event.preventDefault();							
								jQuery("#'.esc_attr($id).'.tp-l-r-main-wrapper .tp-l-r-tab").removeClass("active");
								jQuery(this).addClass("active");
								var active = jQuery(this).data("active");
								jQuery(this).closest(".tp-l-r-main-wrapper").find(".tp-tab-content-inner").removeClass("active");
								jQuery(this).closest(".tp-l-r-main-wrapper").find(".tp-tab-content-inner.tab-"+active).addClass("active");
							});	
							
							/*hover*/
					jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-hover").on( "mouseenter",function() {
						jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per").show("slow")
					}).on( "mouseleave",function() {
							setTimeout(function() {
							if(!(jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-hover:hover").length > 0))
								jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-hover .tp-lr-cl-100per").hide("slow");
							}, 200);
						});				
							/*hover*/
							
							/*click*/
							jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-model-btn").on("click",function(){
							jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per").toggle("slow");
					});
							/*close icon*/
					jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-click  .lr-close-custom_img").on("click",function(){					
						jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-click .tp-lr-cl-100per").toggle("slow");
					});				
					/*close icon*/
							/*click*/
							
							/*popup*/
						jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-trigger").on("click",function(event) {
							event.preventDefault();	
							jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-popup .tp-modal-wrapper").toggleClass("open");
							jQuery("#'.esc_attr($id).'.tp-lr-combo.tp-lr-comnbo-skin-popup .tp-ursp-page-wrapper").toggleClass("blur");
							return false;
						});
					/*popup*/
						
					});';
				$tp_login_registe_script .='</script>';
			
			echo $tp_login_registe_script;
		
		}
		
		$aflp='';
		if ( is_user_logged_in() && ! Theplus_Element_Load::elementor()->editor->is_edit_mode() ) {
			$aflp = 'aflp';
		}
		echo '<div class="tp-wp-lrcf '.$aflp.'">';
		
		$current_user = wp_get_current_user();
		
		
	$after_login_panel ='<div class="after_login_btn_wrapper">';
		$after_login_panel .='<a class="after_login_btn_main"  aria-expanded="true">
								<span class="elementor-button-text">'.get_avatar( $current_user->user_email, 128 ).' '.$current_user->display_name.' </span>
								</a>
						
					<div class="tp-user-login '.$settings['layout_start_from'].'">
							<ul class="tp-list">';								
								if(!empty($settings['edit_profile_text_switch']) && $settings['edit_profile_text_switch']=='yes'){
								$after_login_panel .='<li class="tp-user-name"><a href="'.get_edit_user_link().'" class="tp-text-bold">'.esc_html__($settings['edit_profile_text'], 'theplus' ).'</a>
								</li>';	
								}
								$i=0;
								foreach($settings["loop_content"] as $item) {
									if ( ! empty( $item['loop_url_link']['url'] ) ) {
										$this->add_render_attribute( 'loop_box_link'.$i, 'href', $item['loop_url_link']['url'] );
										if ( $item['loop_url_link']['is_external'] ) {
											$this->add_render_attribute( 'loop_box_link'.$i, 'target', '_blank' );
										}
										if ( $item['loop_url_link']['nofollow'] ) {
											$this->add_render_attribute( 'loop_box_link'.$i, 'rel', 'nofollow' );
										}
									}
									
									$title_a_start=$title_a_end='';
									if(!empty($item['loop_title'])){
										if (!empty($item['loop_url_link']['url'])){
											$title_a_start = '<a '.$this->get_render_attribute_string( "loop_box_link".$i ).'>';
											$title_a_end = '</a>';
										}
										$after_login_panel .= '<li class="after_login_panel_link">'.$title_a_start.' '.$item['loop_title'].' '.$title_a_end.'</li>';
									}
									$i++;
								}
						if(!empty($settings['button_text_logout_switch']) && $settings['button_text_logout_switch']=='yes'){
						$after_login_panel .= '<li class="tp-user-logged-out">
													<a href="'.wp_logout_url( $current_url ).'" class="tp-button tp-button-primary">
													'.esc_html__($settings['button_text_logout'], 'theplus' ).'</a>
											   </li>';
							}
						$after_login_panel .= '</ul>
				</div>';
	$after_login_panel .='</div></div>';
		
		if((empty($_GET['action']))|| (!empty($_GET['action']) && $_GET['action'] !='theplusrpf')){
		if(!empty($settings['form_selection']) && ($settings['form_selection']=='tp_login' || $settings['form_selection']=='tp_login_register')){
			
			if ( is_user_logged_in() && ! Theplus_Element_Load::elementor()->editor->is_edit_mode() ) {
				if ( $settings['show_logged_in_message'] ) {
					echo $after_login_panel;
				}
				return;
			}
			
			
			$this->form_fields_render_attributes();
			
			if($settings['_skin']=='default' && $settings['form_selection']=='tp_login'){ ?>
			
				<div id="<?php echo esc_attr($id); ?>" class="tp-user-login tp-user-login-skin-default">
					<div class="elementor-form-fields-wrapper">						
						<?php if ($settings['modal_header']=='yes' && (!empty($settings['hide_form']) && $settings['hide_form']=='no')) : ?>
						<div class="tp-modal-header">
							<h2 class="tp-modal-title"><span tp-icon="user"></span> <?php echo $settings['modal_header_description_log']; ?></h2>			
						</div>
						<?php endif; ?>
						<?php $this->user_login_form(); ?>
					</div>
				</div>
				<?php }else if($settings['_skin']=='tp-dropdown'  && $settings['form_selection']=='tp_login'){ ?>
				<div id="<?php echo esc_attr($id); ?>" class="tp-user-login tp-user-login-skin-dropdown">
					<a <?php echo $this->get_render_attribute_string('dropdown-button-settings'); ?>>
						<?php $this->render_text(); ?>
					</a>
					<div <?php echo $this->get_render_attribute_string('dropdown-settings'); ?>>
						<div class="elementor-form-fields-wrapper">
							<div class="lr-extra-div <?php echo $settings['layout_start_from']; ?>">
							<?php if ($settings['modal_header']=='yes') : ?>
							<div class="tp-modal-header">
								<h2 class="tp-modal-title"><span tp-icon="user"></span> <?php echo $settings['modal_header_description_log']; ?></h2>			
							</div>
							<?php endif; ?>
							<?php $this->user_login_form(); ?>
							</div>
						</div>

					</div>
				</div>
					
			<?php }else if($settings['_skin']=='tp-modal' && $settings['form_selection']=='tp_login'){ ?>
			
				<div id="<?php echo esc_attr($id); ?>" class="tp-user-login tp-user-login-skin-modal">
					<a class="tp-lr-model-btn" <?php echo $this->get_render_attribute_string('modal-button-settings'); ?>>
						<?php $this->render_text_model(); ?>
					</a>

					<div id="<?php echo esc_attr($id); ?>" class="tp-user-login-modal">
						<div class="tp-modal-dialog <?php echo $settings['layout_start_from']; ?>">	
							<?php if ($settings['modal_close_button']=='yes') : ?>
								<img src="<?php echo $settings['modal_close_button_icon']['url']; ?>" class="lr-close-custom_img"/>
							<?php endif; ?>
							
							<div class="elementor-form-fields-wrapper tp-modal-body">
								<?php if ($settings['modal_header']=='yes') : ?>
							<div class="tp-modal-header">
								<h2 class="tp-modal-title"><span tp-icon="user"></span> <?php echo $settings['modal_header_description_log']; ?></h2>			
							</div>
							<?php endif; ?>
								<?php $this->user_login_form(); ?>
							</div>
						</div>
					</div>
				</div>
				
		<?php }else if($settings['_skin']=='tp-popup' && $settings['form_selection']=='tp_login'){ ?>
		
				<div id="<?php echo esc_attr($id); ?>" class="tp-user-login tp-user-login-skin-popup">
					<div class="tp-ulsp-page-wrapper">
						<a class="tp-ulsp-btn tp-ulsp-trigger" href="javascript:;">
							<?php $this->render_text_model(); ?>
						</a>
					</div>
					
					<div class="tp-modal-wrapper">
					  <div class="tp-modal">						
						  <a class="tp-ulsp-btn-close tp-ulsp-trigger" href="javascript:;"><img src="<?php echo $settings['modal_close_button_icon']['url']; ?>" class="lr-close-custom_img"/></a>
						<div class="tp-ulsp-content">
							<div class="elementor-form-fields-wrapper tp-popup-body">
								<?php if ($settings['modal_header']=='yes') : ?>
									<div class="tp-popup-header">												
										<h2 class="tp-popup-title"><span tp-icon="user"></span> <?php echo $settings['modal_header_description_log']; ?></h2>
									</div>
								<?php endif; ?>
								<?php $this->user_login_form(); ?>
							</div>								
						</div>
					  </div>
					</div>
				</div>
				
		<?php }
		}
		}else if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='theplusrpf'){				
				$this->user_reset_password_form(); 
		}
		
		if(!empty($settings['form_selection']) && ($settings['form_selection']=='tp_forgot_password')){
			if((empty($_GET['action']))|| (!empty($_GET['action']) && $_GET['action'] !='theplusrpf')){
				$this->user_lost_password_form('login-time-fp'); 
			}
			/*if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='theplusrpf'){
				$this->user_reset_password_form(); 
			}*/
		}
		
		if((empty($_GET['action']))|| (!empty($_GET['action']) && $_GET['action'] !='theplusrpf')){
		if(!empty($settings['form_selection']) && ($settings['form_selection']=='tp_register' || $settings['form_selection']=='tp_login_register')){
			
			if ( is_user_logged_in() && ! Theplus_Element_Load::elementor()->editor->is_edit_mode() ) {
				if ( $settings['show_logged_in_message_reg'] ) {
					echo $after_login_panel;
				}					

				return;

			} elseif ( !get_option('users_can_register') ) {
				?>
					<div class="tp-alert tp-alert-warning" tp-alert>
						<a class="tp-alert-close" tp-close></a>
						<p><?php esc_html_e( 'Registration option not enbled in your general settings.', 'theplus' ); ?></p>
					</div>
				<?php 
				return;
			}
			

			$this->form_fields_render_attributes();

				
			if($settings['_skin']=='default' && $settings['form_selection']=='tp_register'){	?>
			<div class="tp-user-register tp-user-register-skin-default">
				<div class="elementor-form-fields-wrapper">
					<?php if ($settings['modal_header']=='yes' && (!empty($settings['hide_form']) && $settings['hide_form']=='no')) : ?>
						<div class="tp-modal-header">									
							<h2 class="tp-modal-title"><span tp-icon="user"></span> <?php echo $settings['modal_header_description_reg']; ?></h2>
						</div>
					<?php endif; ?>
					<?php $this->user_register_form(); ?>
				</div>
			</div>
		<?php 
		
		}else if($settings['_skin']=='tp-dropdown' && $settings['form_selection']=='tp_register'){
			?>
			<div id="<?php echo esc_attr($id); ?>" class="tp-user-register tp-user-register-skin-dropdown">
				<a <?php echo $this->get_render_attribute_string( 'dropdown-button-settings' ); ?>>
					<?php $this->render_text_reg_dropdown(); ?>
				</a>

				<div <?php echo $this->get_render_attribute_string( 'dropdown-settings' ); ?>>
					<div class="elementor-form-fields-wrapper">
						<div class="lr-extra-div <?php echo $settings['layout_start_from']; ?>">
							<?php if ($settings['modal_header']=='yes') : ?>
								<div class="tp-modal-header">									
									<h2 class="tp-modal-title"><span tp-icon="user"></span> <?php echo $settings['modal_header_description_reg']; ?></h2>
								</div>
							<?php endif; ?>
							<?php $this->user_register_form(); ?>
						</div>
					</div>
				</div>
			</div>
		
		<?php }
		
		
		if($settings['_skin']=='tp-modal' && $settings['form_selection']=='tp_register'){ ?>

			<div id="<?php echo esc_attr($id); ?>" class="tp-user-register tp-user-register-skin-modal">
				<a class="tp-lr-model-btn" <?php echo $this->get_render_attribute_string('modal-button-settings'); ?>>
					<?php $this->render_text_reg_dropdown(); ?>
				</a>				
				<div id="<?php echo esc_attr($id); ?>" class="tp-user-register-modal">
					<div class="tp-modal-dialog <?php echo $settings['layout_start_from']; ?>">
						<?php if ($settings['modal_close_button']=='yes') : ?>
							<img src="<?php echo $settings['modal_close_button_icon']['url']; ?>" class="lr-close-custom_img"/>
						<?php endif; ?>
						
						<div class="elementor-form-fields-wrapper tp-modal-body">
							<?php if ($settings['modal_header']=='yes') : ?>
								<div class="tp-modal-header">									
									<h2 class="tp-modal-title"><span tp-icon="user"></span> <?php echo $settings['modal_header_description_reg']; ?></h2>
								</div>
							<?php endif; ?>
							<?php $this->user_register_form(); ?>
						</div>
					</div>
				</div>
			</div>
		<?php
		
		
		}else if($settings['_skin']=='tp-popup' && $settings['form_selection']=='tp_register'){ ?>
			
			<div id="<?php echo esc_attr($id); ?>" class="tp-user-register tp-user-register-skin-popup">
				<div class="tp-ursp-page-wrapper">
				  <a class="tp-ursp-btn tp-ursp-trigger" href="javascript:;">
					<?php $this->render_text_reg_dropdown(); ?>
					</a>
				</div>
				<div class="tp-modal-wrapper">
				  <div class="tp-modal">						
					  <a class="tp-ursp-btn-close tp-ursp-trigger" href="javascript:;"><img src="<?php echo $settings['modal_close_button_icon']['url']; ?>" class="lr-close-custom_img"/></a>						
					<div class="tp-ursp-content">
						<div class="elementor-form-fields-wrapper tp-popup-body">
							<?php if ($settings['modal_header']=='yes') : ?>
								<div class="tp-popup-header">
									<h2 class="tp-popup-title"><span tp-icon="user"></span> <?php echo $settings['modal_header_description_reg']; ?></h2>
								</div>
							<?php endif; ?>
							<?php $this->user_register_form(); ?>
						</div>
					</div>
				  </div>
				</div>
			</div>
				
		<?php }
		
			
			$lr_popup_start='<div id="'.esc_attr($id).'" class="tp-lr-comm-wrap tp-lr-combo tp-lr-comnbo-skin-popup">
									<div class="tp-ursp-page-wrapper">
										<a class="tp-ursp-btn tp-ursp-trigger" href="javascript:;">'.$list_img.' '.$settings['dropdown_button_text'].'</a>
									</div>
							<div class="tp-modal-wrapper">
								<div class="tp-modal">						
									<a class="tp-ursp-btn-close tp-ursp-trigger" href="javascript:;"><img src="'.esc_url($settings['modal_close_button_icon']['url']).'" class="lr-close-custom_img"/></a>						
									<div class="tp-ursp-content">';
								
			$lr_popup_close='</div>
							</div>
					  </div>
					</div>';
		
			$lr_hover_start='<div id="'.esc_attr($id).'" class="tp-lr-comm-wrap tp-lr-combo tp-lr-comnbo-skin-hover">
								<a class="elementor-button tp-button-dropdown" href="javascript:void(0)">
									<span class="elementor-button-content-wrapper">				
										'.$list_img.'<span class="elementor-button-text">'.$settings['dropdown_button_text'].'</span>
									</span>
								</a>';	
			$lr_hover_close='</div>';
			
			$lr_click_start='<div id="'.esc_attr($id).'" class="tp-lr-comm-wrap tp-lr-combo tp-lr-comnbo-skin-click">
								<a class="tp-lr-model-btn">
									<span class="elementor-button-content-wrapper">				
										'.$list_img.'<span class="elementor-button-text">'.$settings['dropdown_button_text'].'</span>
									</span>
								</a>';
			$lr_click_close='</div>';
			
			
			if(!empty($settings['form_selection']) && $settings['form_selection']=='tp_login_register'){
				if(!empty($settings['_skin']) && $settings['_skin']=='tp-popup'){
					echo $lr_popup_start;
				}
				if(!empty($settings['_skin']) && $settings['_skin']=='tp-dropdown'){
					echo $lr_hover_start;
				}
				if(!empty($settings['_skin']) && $settings['_skin']=='tp-modal'){
					echo $lr_click_start;
				}
				
				if(!empty($settings['_skin']) && $settings['_skin']=='default'){
					echo '<div class="tp-lr-comm-wrap">';
				}
				?>			
				<div id="<?php echo esc_attr($id); ?>" class="tp-lr-cl-100per <?php echo $settings['layout_start_from']; ?>">
					<?php if(!empty($settings['_skin']) && $settings['_skin']=='tp-modal'){
					if ($settings['modal_close_button']=='yes') : ?>
								<img src="<?php echo $settings['modal_close_button_icon']['url']; ?>" class="lr-close-custom_img"/>
							<?php endif; 
					} ?>
							
					<?php if(!empty($settings['select_template'])){ ?>
						<div class="cl-50per">
						<?php
							echo '<div class="temp">'.Theplus_Element_Load::elementor()->frontend->get_builder_content_for_display( $settings['select_template'] ).'</div>';
						?>
						</div>
						<div class="cl-50per">
					<?php }else{ ?>
							<div class="cl-100per">
					<?php } ?>
							<div id="<?php echo esc_attr($id); ?>" class="tp-l-r-main-wrapper">
								  <ul id="<?php echo esc_attr($id); ?>" class="tp-l-r-tab-group">
									<li class="tp-l-r-tab active" data-active="login"><?php echo $settings['tab_com_login']; ?></li>
									<li class="tp-l-r-tab" data-active="signup"><?php echo $settings['tab_com_signup']; ?></li>
								  </ul>      
								  
									  <div class="tp-l-r-tab-content">
											<div class="tp-tab-content-inner tab-login active">   
													<?php if ($settings['modal_header']=='yes') : ?>
														<div class="tp-popup-header">													
															<h2 class="tp-popup-title"><span tp-icon="user"></span> <?php echo $settings['modal_header_description_log']; ?></h2>
														</div>
													<?php endif; ?>
													<?php $this->user_login_form(); ?>
											</div>  
											<div class="tp-tab-content-inner tab-signup">
												<?php if ($settings['modal_header']=='yes') : ?>
														<div class="tp-popup-header">													
															<h2 class="tp-popup-title"><span tp-icon="user"></span> <?php echo $settings['modal_header_description_reg']; ?></h2>
														</div>
													<?php endif; ?>
											  <?php $this->user_register_form(); ?>
											</div>
									  </div>      
							</div>
						</div>
					</div>
			<?php
				
				if(!empty($settings['_skin']) && $settings['_skin']=='default'){
					echo '</div>';
				}
				if(!empty($settings['_skin']) && $settings['_skin']=='tp-popup'){
					echo $lr_popup_close;
				}
				if(!empty($settings['_skin']) && $settings['_skin']=='tp-dropdown'){
					echo $lr_hover_close;
				}
				if(!empty($settings['_skin']) && $settings['_skin']=='tp-modal'){
					echo $lr_click_close;
				}
				
			}
			
		}
		}
		if(!empty($settings['form_selection']) && $settings['form_selection']=='tp_login'){
			$this->user_login_ajax_script();	
		}else if(!empty($settings['form_selection']) && $settings['form_selection']=='tp_register'){
			$this->user_register_ajax_script();
		}else if(!empty($settings['form_selection']) && $settings['form_selection']=='tp_login_register'){
			$this->user_login_ajax_script();
			$this->user_register_ajax_script();
		}
		?>		
		</div>
		<?php
		
	}
	
	/*User Forgot Password Form*/
	public function user_lost_password_form( $value = '' ) {
	
		$settings    = $this->get_settings();
		$current_url = remove_query_arg( 'fake_arg' );
		$id          = 'lr'.$this->get_id();
		if($settings['form_selection']=='tp_forgot_password'){
			echo '<div class="tp-forg-pass-form">';
		}
		
		
		if(!empty($_GET['expired']) && $_GET['expired']=='expired'){
			$key_msg = 'The entered key has expired. Please start reset process again.';
		}else if(!empty($_GET['invalid']) && $_GET['invalid']=='invalid'){
			$key_msg = 'The entered key is invalid. Please start reset process again.';
		}else{
			$key_msg ='';
		}
		if(!empty($key_msg)){
			echo '<div class="tp-invalid-expired-key">'.esc_html($key_msg).'</div>';
		}
		?>
		<form id="tp-user-lost-password<?php echo esc_attr($id); ?>" class="tp-form-stacked-fp" method="post" action="forgot-password" data-f_p_opt="<?php echo $settings['f_p_opt']; ?>">
			<?php if ( function_exists( 'wp_nonce_field' ) ) 
					wp_nonce_field( 'tp_user_lost_password_action', 'tp_user_lost_password_nonce' ); ?>
			<?php 
				$lpba_icon='';
				if(!empty($settings['lpba_icon'])){
					ob_start();
					\Elementor\Icons_Manager::render_icon( $settings['lpba_icon'], [ 'aria-hidden' => 'true' ]);
					$lpba_icon = ob_get_contents();
					ob_end_clean();						
				}
				
				if(!empty($settings['form_selection']) && $settings['form_selection']!=='tp_forgot_password'){
					echo '<a class="tp-lpu-back">'.$lpba_icon.'</a>';
				}
			?>
			<?php 
				if( !empty($value) && $value=='login-time-fp' ){
					echo '<span class="tp-forgot-password-label">';
						echo $settings['lost_password_heading_desc'];
					echo '</span>';
				}
			?>
			<div class="tp-ulp-input-group">
				<input type="text" name="user_login" id="user_login<?php echo esc_attr($id); ?>" placeholder="<?php echo esc_attr($settings['lost_pass_placeholder']); ?>" class="tp-input" required>
			</div>
			<?php do_action( 'lostpassword_form' ); ?>
			<input type="hidden" name="_tp_login_form" value="lostPassword">
			<button type="submit" class="tp-button-fp"><?php echo $settings['forgot_pass_btn']; ?></button>			
			<div class="theplus-notification"><div class="tp-lr-response"></div></div>
			
		</form>
		
		<?php
		if($settings['form_selection']=='tp_forgot_password'){
			echo '</div>';
		}
		
		$this->user_forgot_pass_ajax_script();
		
	}
	/*User Forgot Password Form*/
	
	/*User Reset Password Form*/
	public function user_reset_password_form() {
	
		$settings    = $this->get_settings();		
		$id          = 'lr'.$this->get_id();
		
		$attributes = array();
		if ( is_user_logged_in() ) {
			echo  __( 'You are already signed in.', 'theplus' );
		} else {
			if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
				$attributes['login'] = $_REQUEST['login'];
				$attributes['key'] = $_REQUEST['key'];
				$attributes['forgoturl'] = $_REQUEST['forgoturl'];
			}
		}
		if(!empty($attributes)){
			
			$pattern_pass_reset='';
			$tp_dp_reset_field_strong = ( $settings['tp_dp_reset_field_strong'] == 'yes' ) ? 'yes' : 'no';			
			if(!empty($tp_dp_reset_field_strong) && $tp_dp_reset_field_strong=='yes'){
				$pattern_pass_reset='pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"';
			}
		?>		
			<div class="tp-reset-pass-form">
			<form id="tp-user-reset-password<?php echo esc_attr($id); ?>" class="tp-form-stacked-reset" method="post">
				<input type="hidden" id="tp-reset-login-user<?php echo esc_attr($id); ?>" name="tp_login" value="<?php echo esc_attr( $attributes['login'] ); ?>" autocomplete="off" />
				<input type="hidden" id="tp-reset-forgot-url<?php echo esc_attr($id); ?>" name="tp_forgot_url" value="<?php echo esc_attr( $attributes['forgoturl'] ); ?>" autocomplete="off" />
				<input type="hidden" id="tp-reset-user-key<?php echo esc_attr($id); ?>" name="tp_key" value="<?php echo esc_attr( $attributes['key'] ); ?>" />
				<div class="tp-ulp-input-group">
					<input type="password" name="user_reset_pass" id="user_reset_pass<?php echo esc_attr($id); ?>" placeholder="<?php echo esc_attr($settings['res_pass_placeholder']); ?>" class="tp-input" required <?php echo $pattern_pass_reset; ?> style="margin-bottom:15px">
				</div>
				<div class="tp-ulp-input-group">
					<input type="password" name="user_reset_pass_conf" id="user_reset_pass_conf<?php echo esc_attr($id); ?>" placeholder="<?php echo esc_attr($settings['res_conf_pass_placeholder']); ?>" class="tp-input" required>
				</div>
				
				<?php if ( function_exists( 'wp_nonce_field' ) ){ wp_nonce_field( 'tp_reset_pass', 'tp_reset_pass' ); } ?>			
				<button type="submit" class="tp-button-reset-pass"><?php echo $settings['reset_pass_btn']; ?></button>			
				<div class="theplus-notification"><div class="tp-lr-response"></div></div>
			</form>
			</div>
			<script type="text/javascript">
			jQuery(document).ready(function($) {
				
				var reset_pass_form = 'form#tp-user-reset-password<?php echo esc_attr($id); ?>';
				var fp_loading='<span class="loading-spinner-reg"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span>';
				var forgot_url = $(reset_pass_form + ' #tp-reset-forgot-url<?php echo esc_attr($id); ?>').val();
			    
			    $(reset_pass_form).on('submit', function(e){
			        $.ajax({
			            type: 'POST',
			            dataType: 'json',
			            url: theplus_ajax_url,
			            data: { 
			                'action': 'theplus_ajax_reset_password',
			                'user_login': $(reset_pass_form + ' #tp-reset-login-user<?php echo esc_attr($id); ?>').val(),
							'user_key': $(reset_pass_form + ' #tp-reset-user-key<?php echo esc_attr($id); ?>').val(), 
							'user_pass': $(reset_pass_form + ' #user_reset_pass<?php echo esc_attr($id); ?>').val(), 
							'user_pass_conf': $(reset_pass_form + ' #user_reset_pass_conf<?php echo esc_attr($id); ?>').val(), 
							//'redirecturl': '<?php echo get_the_permalink(); ?>',
							'nonce': $(reset_pass_form + ' #tp_reset_pass_nonce').val()
			            },
						beforeSend: function(){
							$("#tp-user-reset-password<?php echo esc_attr($id);?> .theplus-notification").addClass("active");
							$("#tp-user-reset-password<?php echo esc_attr($id);?> .theplus-notification .tp-lr-response").html('Please Wait...');
						},
			            success: function(data) {
								$("#tp-user-reset-password<?php echo esc_attr($id);?> .theplus-notification").addClass("active");
								$("#tp-user-reset-password<?php echo esc_attr($id);?> .theplus-notification .tp-lr-response").html(fp_loading + data.message);
								if(data.reset_pass=='success'){
									if( forgot_url != ''){
										window.location = forgot_url;
									}
								}
								if(data.reset_pass=='empty'){
									$(reset_pass_form + ' #user_reset_pass<?php echo esc_attr($id); ?>').value='';
									$(reset_pass_form + ' #user_reset_pass_conf<?php echo esc_attr($id); ?>').value='';
								}
								if(data.reset_pass=='mismatch'){
									$(reset_pass_form + ' #user_reset_pass_conf<?php echo esc_attr($id); ?>').value='';
								}
								if(data.reset_pass=='expire'){
									if( forgot_url != ''){
										window.location = forgot_url;
									}
								}
								if(data.reset_pass=='invalid'){
									if( forgot_url != ''){
										window.location = forgot_url;
									}
								}
			            },
						complete: function(){
							setTimeout(function(){
								$("#tp-user-reset-password<?php echo esc_attr($id);?> .theplus-notification").removeClass("active");	
							}, 3200);
						}
			        });
			        e.preventDefault();					
			    });			
			});
		</script>
		<?php
		}
	}
	/*User Reset Password Form*/
	
	/*User Login Form*/
	public function user_login_form() {
	
		$settings    = $this->get_settings();

		$current_url = remove_query_arg( 'fake_arg' );
		$id          = 'lr'.$this->get_id();

		if ( $settings['redirect_after_login'] && ! empty( $settings['redirect_url']['url'] ) ) {
			$redirect_url = $settings['redirect_url']['url'];
		} else {
			$redirect_url = $current_url;
		}
		$hide_form = ( $settings['hide_form'] == 'yes' ) ? 'yes' : 'no';
		
		if(!empty($hide_form) && $hide_form != 'yes'){
		?>
		
		<form id="tp-user-login<?php echo esc_attr($id); ?>" class="tp-form-stacked " method="post" action="login">
			<div class="tp-user-login-status"></div>
			<div class="tp-field-group tp-l-lr-user-name">
				<?php
				
				if ( $settings['show_labels']=='yes' && ($settings['form_selection']=='tp_login' || $settings['form_selection']=='tp_login_register')) {					
					echo '<label for="user'.esc_attr($id).'" class="tp-form-label">'.$settings['user_label'].'</label>';					
				}
				echo '<div class="tp-form-controls">';
				echo '<input type="text" name="log" id="user'.esc_attr($id).'" placeholder="'.$settings['user_placeholder'].'" class="tp-input" required>';
				echo '</div>';

				?>
			</div>

			<div class="tp-field-group tp-l-lr-password">
				<?php
				if ( $settings['show_labels']=='yes' && ($settings['form_selection']=='tp_login' || $settings['form_selection']=='tp_login_register'))  :					
					echo '<label for="password'.esc_attr($id).'" class="tp-form-label">'.$settings['password_label'].'</label>';
				endif;
				echo '<div class="tp-form-controls">';				
				echo '<input type="password" name="pwd" id="password'.esc_attr($id).'" placeholder="'.$settings['password_placeholder'].'" class="tp-input" required>';
				echo '</div>';
				?>
			</div>

			<?php if ( $settings['show_remember_me']=='yes' ) : ?>
				<div class="tp-field-group tp-remember-me">
					<label for="remember-me-<?php echo esc_attr($id); ?>" class="tp-form-label">
						<input type="checkbox" id="remember-me-<?php echo esc_attr($id); ?>" class="tp-checkbox" name="rememberme" value="forever"> 
						<label class="remember-me-label" for="remember-me-<?php echo esc_attr($id); ?>"><?php echo esc_html($settings['remember_me_text']); ?></label>
					</label>
				</div>
			<?php endif; ?>
			
			<div <?php echo $this->get_render_attribute_string( 'submit-group' ); ?>>
				<button type="submit" class="tp-button" name="wp-submit">
					<?php if ( ! empty( $settings['button_text'] ) ) : ?>
						<span><?php echo $settings['button_text']; ?></span>
					<?php endif; ?>
				</button>
			</div>

			<?php
			$show_lost_password = $settings['show_lost_password'];
			$show_register      = get_option( 'users_can_register' ) && $settings['show_register'];

			if ( $show_lost_password || $show_register ) : ?>
				<div class="tp-field-group  tp-user-login-password">
					   
					<?php if ( $show_lost_password=='yes' ) : ?>
						<a class="tp-lost-password"><?php echo esc_html($settings['bottom_lost_pass_text']); ?></a>
					<?php endif; ?>

					<?php if ( $show_register=='yes' ) : ?>
						<a class="tp-register" href="<?php 
							if($settings['show_register_opt']=='default'){
								echo wp_registration_url(); 
							}else if($settings['show_register_opt']=='custom'){						
								if ( ! empty( $settings['show_register_opt_link']['url'] ) ) {
									echo $settings['show_register_opt_link']['url'];								
								}
							}
						?>"><?php echo esc_html($settings['bottom_register_text']); ?></a>
					<?php endif; ?>
					
				</div>
			<?php endif; ?>
			
			<?php wp_nonce_field( 'ajax-login-nonce', 'tp-user-login-sc' ); 
				echo '<div class="theplus-notification"><div class="tp-lr-response"></div></div>'; ?>
		</form>
		<?php
		}
		$this->user_social_log_reg('login');
		
		if(!empty($settings['show_lost_password']) && $settings['show_lost_password']=='yes'){			
			if((empty($_GET['action'])) || (!empty($_GET['action']) && $_GET['action'] !='theplusrpf')){
				$this->user_lost_password_form('login-time-fp'); 
			}
			if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='theplusrpf'){
				$this->user_reset_password_form(); 
			}
		}
		
	}
	/*User Login Form*/
	
	/*User Register Form*/
	public function user_register_form() {
		$settings    = $this->get_settings();

		$id          = 'lr'.$this->get_id();
		$current_url = remove_query_arg( 'fake_arg' );

		if ( $settings['redirect_after_register'] && ! empty( $settings['redirect_url_reg']['url'] ) ) {
			$redirect_url_reg = $settings['redirect_url_reg']['url'];
		} else {
			$redirect_url_reg = $current_url;
		}
		
		
		$dis_cap = ( $settings['display_captcha_swtch'] == 'yes' ) ? 'yes' : 'no';
		$hide_form = ( $settings['hide_form'] == 'yes' ) ? 'yes' : 'no';
		
		$dis_password = ( $settings['tp_dis_pass_field'] == 'yes' ) ? 'yes' : 'no';
		$tp_user_reg_role = ($settings['user_role']) ? $settings['user_role'] : 'subscriber';
				
		$dis_mail_chimp = ( $settings['tp_mail_chimp_subscribe_opt'] == 'yes' ) ? 'yes' : 'no';
		$mc_custom_apikey=$mc_custom_listid='';
		if(!empty($dis_mail_chimp) && $dis_mail_chimp=='yes'){
			if((!empty($settings['mc_i_li_ak_swtch']) && $settings['mc_i_li_ak_swtch']=='yes') && (!empty($settings['mc_custom_apikey']) && !empty($settings['mc_custom_listid']))){
				$mc_custom_apikey = $settings['mc_custom_apikey'];
				$mc_custom_listid = $settings['mc_custom_listid'];			
			}
		}
		
		$dis_cap = ( $settings['display_captcha_swtch'] == 'yes' ) ? 'yes' : 'no';
		
		$redirect_url_reg = $settings['redirect_url_reg']['url']  ? $settings['redirect_url_reg']['url'] : '';
		
		?>
		
		<form id="tp-user-register<?php echo esc_attr($id); ?>" class="tp-form-stacked " method="post" action="" data-dis_cap="<?php echo $dis_cap; ?>" data-dis_password="<?php echo $dis_password; ?>" data-after_reg_redirect="<?php echo $redirect_url_reg; ?>" data-dis_mail_chimp="<?php echo $dis_mail_chimp; ?>" data-mc_custom_apikey="<?php echo $mc_custom_apikey; ?>" data-mc_custom_listid="<?php echo $mc_custom_listid; ?>" data-tp_user_reg_role="<?php echo $tp_user_reg_role; ?>">
			
			<?php if(!empty($hide_form) && $hide_form != 'yes'){
				if(!empty($settings['tp_dis_name_field']) && $settings['tp_dis_name_field']=='yes'){ 
				if(!empty($settings['tp_dis_fname_field']) && $settings['tp_dis_fname_field']=='yes'){ 	
					?>
			
			<div class="tp-field-group tp-lr-f-first-name">
				<?php				
				if ( $settings['show_labels_reg']=='yes' && ($settings['form_selection']=='tp_register' || $settings['form_selection']=='tp_login_register')) {					
					echo '<label for="first_name'.esc_attr($id).'" class="tp-form-label">'.$settings['first_name_label'].'</label>';					
				}
				echo '<div class="tp-form-controls">';
				echo '<input type="text" name="first_name" id="first_name'.esc_attr($id).'" placeholder="'.$settings['first_name_placeholder'].'" class="tp-input" required>';
				echo '</div>';

			?>
			</div>
			<?php }
			if(!empty($settings['tp_dis_lname_field']) && $settings['tp_dis_lname_field']=='yes'){ 	?>
			<div class="tp-field-group tp-lr-f-last-name">
				<?php
				if ( $settings['show_labels_reg']=='yes' && ($settings['form_selection']=='tp_register' || $settings['form_selection']=='tp_login_register')) {					
					echo '<label for="last_name'.esc_attr($id).'" class="tp-form-label">'.$settings['last_name_label'].'</label>';									
				}
				echo '<div class="tp-form-controls">';				
				echo '<input type="text" name="last_name" id="last_name'.esc_attr($id).'" placeholder="'.$settings['last_name_placeholder'].'" class="tp-input" required>';
				echo '</div>';

				?>
			</div>
			<?php }
				} ?>
			<div class="tp-field-group tp-lr-f-email">
				<?php
				if ( $settings['show_labels_reg']=='yes' && ($settings['form_selection']=='tp_register' || $settings['form_selection']=='tp_login_register')){					
					echo '<label for="user_email'.esc_attr($id).'" class="tp-form-label">'.$settings['email_label'].'</label>';						
				}
				echo '<div class="tp-form-controls">';				
				echo '<input type="email" name="user_email" id="user_email'.esc_attr($id).'" placeholder="'.$settings['email_placeholder'].'" class="tp-input" required>';
				echo '</div>';
				?>
			</div>
			
			<?php 
			/*password field start*/ 
			
			if(!empty($settings['tp_dis_pass_field']) && $settings['tp_dis_pass_field']=='yes'){
			
			$pattern_pass_reg='';
			$tp_dis_pass_field_strong = ( $settings['tp_dis_pass_field_strong'] == 'yes' ) ? 'yes' : 'no';			
			if(!empty($tp_dis_pass_field_strong) && $tp_dis_pass_field_strong=='yes'){
				$pattern_pass_reg='pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"';
			}
			?>
			<div class="tp-field-group tp-lr-f-user-pass">
				<?php
				if ( $settings['show_labels_reg']=='yes' && ($settings['form_selection']=='tp_register' || $settings['form_selection']=='tp_login_register')){					
					echo '<label for="user_password'.esc_attr($id).'" class="tp-form-label">'.$settings['r_password_label'].'</label>';						
				}
				echo '<div class="tp-form-controls">';				
				echo '<input type="password" name="user_password" id="user_password'.esc_attr($id).'" placeholder="'.$settings['r_password_placeholder'].'" class="tp-input" required '.$pattern_pass_reg.'>';
				echo '</div>';
				?>
			</div>
			
			<div class="tp-field-group tp-lr-f-user-conf-pass">
				<?php
				if ( $settings['show_labels_reg']=='yes' && ($settings['form_selection']=='tp_register' || $settings['form_selection']=='tp_login_register')){					
					echo '<label for="user_conf_password'.esc_attr($id).'" class="tp-form-label">'.$settings['r_conf_password_label'].'</label>';						
				}
				echo '<div class="tp-form-controls">';				
				echo '<input type="password" name="user_conf_password" id="user_conf_password'.esc_attr($id).'" placeholder="'.$settings['r_conf_password_placeholder'].'" class="tp-input" required >';
				echo '</div>';
				?>
			</div>
			
			<?php }	/*password field end*/ ?>
			<?php if ( $settings['show_additional_message'] ) : ?>
				<div class="tp-field-group tp-lr-f-add-msg">
					<span class="tp-register-additional-message"><?php echo $settings['additional_message']; ?></span>
				</div>
			<?php endif;
				$id = 'lr'.$this->get_id();
				
				if( !empty($settings['form_selection']) && (($settings['form_selection']=='tp_register' && (!empty($settings['display_captcha_swtch']) && $settings['display_captcha_swtch']=='yes')) 
					|| ($settings['form_selection']=='tp_login_register' && (!empty($settings['display_captcha_swtch']) && $settings['display_captcha_swtch']=='yes')))	){
				
				$check_recaptcha= get_option( 'theplus_api_connection_data' );
				if(!empty($check_recaptcha['theplus_site_key_recaptcha'])){
					$site_key_captcha = $check_recaptcha['theplus_site_key_recaptcha'];
				?>
				<div class="tp-plus-re-captcha tp-lrfp-ff-<?php echo $settings['form_align']; ?>">
					<div id="inline-badge-<?php echo esc_attr($id); ?>"></div>
					<script src="https://www.google.com/recaptcha/api.js?render=explicit&onload=plus_onLoadReCaptcha<?php echo esc_attr($id); ?>"></script>
						<script>
						window.plus_onLoadReCaptcha<?php echo esc_attr($id); ?> = function() {
							var clientId = grecaptcha.render('inline-badge-<?php echo esc_attr($id); ?>', {
								'sitekey': '<?php echo $site_key_captcha; ?>',
								'badge': 'inline',
								'size': 'invisible'
							  });
							grecaptcha.ready(function() {
								grecaptcha.execute(clientId, {
								  action: 'register'
								})
								  .then(function(token) {
									jQuery('#tp-user-register<?php echo esc_attr($id); ?>').prepend('<input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response-<?php echo esc_attr($id); ?>" value="' + token + '">');
								});
							});
						}
						</script>		
						
				</div>
				<?php } } ?>
				
				<?php
			/*mailchimp field start*/ 
			if(!empty($settings['tp_mail_chimp_subscribe_opt']) && $settings['tp_mail_chimp_subscribe_opt']=='yes'){
			?>
			<div class="tp-field-group tp-lr-f-mail-chimp-sub tp-lrfp-ff-<?php echo $settings['form_align']; ?>">
				<?php
				echo '<script type="text/javascript">
					jQuery(document).ready(function($) {
							$(".tp-lr-f-mail-chimp-sub .tp-form-controls input.tp-input").prop("indeterminate", true);			
					});
				</script>';
				echo '<div class="tp-form-controls " style="display: flex;">';	
				echo '<input type="checkbox" name="user_mail_chimp_subscribe" id="user_mail_chimp_subscribe'.esc_attr($id).'"  class="tp-input" checked>';
				if(!empty($settings['form_align']) && $settings['form_align']=='left' || !empty($settings['form_align']) && $settings['form_align']=='center'){
					echo '<label class="user_mail_chimp_subscribe_checkbox" for="user_mail_chimp_subscribe'.esc_attr($id).'"></label>';
				}
				if ($settings['form_selection']=='tp_register' || $settings['form_selection']=='tp_login_register'){
					echo '<label class="tp-form-label">'.$settings['r_mail_chimp_label'].'</label>';						
				}
				if(!empty($settings['form_align']) && $settings['form_align']=='right'){
					echo '<label class="user_mail_chimp_subscribe_checkbox" for="user_mail_chimp_subscribe'.esc_attr($id).'" style="padding-left:15px;margin-left:15px;"></label>';					
				}
				echo '</div>';
				echo '</div>';
			}
			/*mailchimp field start*/
			
			
			/*Terms of Conditions start*/ 
			if(!empty($settings['tp_terms_condition_opt']) && $settings['tp_terms_condition_opt']=='yes'){
			?>
			<div class="tp-field-group tp-lr-f-tac tp-lrfp-ff-<?php echo $settings['form_align']; ?>">
				<?php				
				echo '<div class="tp-form-controls " style="display: flex;">';	
				echo '<input type="checkbox" name="user_tac" id="user_tac'.esc_attr($id).'" class="tp-input" required>';
				if(!empty($settings['form_align']) && $settings['form_align']=='left' || !empty($settings['form_align']) && $settings['form_align']=='center'){
					echo '<label class="user_tac_checkbox" for="user_tac'.esc_attr($id).'"></label>';
				}
				if($settings['form_selection']=='tp_register' || $settings['form_selection']=='tp_login_register'){					
					echo '<label class="tp-form-label">'.$settings['r_terms_conition_label'].'</label>';						
				}
				if(!empty($settings['form_align']) && $settings['form_align']=='right'){
					echo '<label class="user_tac_checkbox" for="user_tac'.esc_attr($id).'" style="padding-left:15px;margin-left:15px;"></label>';
				}
				echo '</div>';
				echo '</div>';
			}
			/*Terms of Conditions end*/
			?>
			
			
			<div <?php echo $this->get_render_attribute_string( 'submit-group' ); ?>>				
				<button type="submit" class="tp-button" name="wp-submit">
					<?php if ( ! empty( $settings['button_text_reg'] ) ) : ?>
						<span><?php echo $settings['button_text_reg']; ?></span>
					<?php endif; ?>
				</button>
			</div>
				
			<?php			
			$show_login = $settings['show_login'];
			if ( $show_login ) : ?>
			
				<div class="tp-field-group tp-user-register-password">
					<?php if (!empty($show_login) && $show_login=='yes') :
						if(!empty($settings['login_before_text'])){
							echo '<div class="login-before-text">'.$settings['login_before_text'].'</div>';
						}
						 ?><a class="tp-login" href="<?php 
						if($settings['show_login_opt']=='default'){
							echo wp_login_url();
						}else if($settings['show_login_opt']=='custom'){	
							if ( ! empty( $settings['show_login_opt_link']['url'] ) ) {
								echo $settings['show_login_opt_link']['url'];								
							}
						}
						?>">
							<?php echo esc_html($settings['bottom_login_text']); ?>
						</a>
					<?php endif; ?>					
				</div>
				
			<?php endif; ?>
			
			<?php wp_nonce_field( 'ajax-login-nonce', 'tp-user-register-sc' ); 
				echo '<div class="theplus-notification"><div class="tp-lr-response"></div></div>';
			}
			?>
		</form>
		
		<?php
		
		$this->user_social_log_reg('register');
	}
	/*User Register Form*/	
	
	/*Login Ajax*/
	public function user_login_ajax_script() { 
	
		$settings    = $this->get_settings();
		$current_url = remove_query_arg( 'fake_arg' );
		$id          = 'lr'.$this->get_id();

		if ( $settings['redirect_after_login'] && ! empty( $settings['redirect_url']['url'] ) ) {
			$redirect_url = $settings['redirect_url']['url'];
		} else {
			$redirect_url = $current_url;
		}
		?>
		
		<script type="text/javascript">
			jQuery(document).ready(function($) {				
				//login start
				var login_form = 'form#tp-user-login<?php echo esc_attr($id); ?>';
				var loading_text='<span class="loading-spinner-log"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span><?php echo esc_html($settings["login_msg_loading_txt"]); ?>';
				var notverify='<span class="loading-spinner-log"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span><?php echo esc_html($settings["login_msg_validation"]); ?>';
				var incorrect_text='<span class="loading-spinner-log"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span><?php echo esc_html($settings["login_msg_error"]); ?>';
				var correct_text='<span class="loading-spinner-log"><i class="fa fa-envelope-o" aria-hidden="true"></i></span><?php echo esc_html($settings["login_msg_success"]); ?>';
							
			    
			    $(login_form).on('submit', function(e){			        
			        $.ajax({
			            type: 'POST',
			            dataType: 'json',
			            url: theplus_ajax_url,
			            data: { 
			                'action': 'theplus_ajax_login',
			                'username': $(login_form + ' #user<?php echo esc_attr($id); ?>').val(), 
			                'password': $(login_form + ' #password<?php echo esc_attr($id); ?>').val(), 
			                'security': $(login_form + ' #tp-user-login-sc').val() 
			            },
						beforeSend: function(){							
							$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification").addClass("active");
							$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification .tp-lr-response").html(loading_text);
						},
			            success: function(data) {							
			                if (data.loggedin == true){
								$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification").addClass("active");
								$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification .tp-lr-response").html(correct_text);
			                    document.location.href = '<?php echo esc_url( $redirect_url ); ?>';
			                } else {
								$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification").addClass("active");
								$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification .tp-lr-response").html(notverify);
			                }
			            },
			            error: function(data) {
							$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification").addClass("active");
							$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification .tp-lr-response").html(incorrect_text);
						},
						complete: function(){
							setTimeout(function(){
										$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification").removeClass("active");	
									}, 1500);
						}
			        });
			        e.preventDefault();
				
			    });
				
				/*hover*/				
				$("#<?php echo esc_attr($id); ?>.tp-user-login.tp-user-login-skin-dropdown,#<?php echo esc_attr($id); ?>.tp-user-login.tp-user-login-skin-dropdown .lr-extra-div").on( "mouseenter",function() {
					$('#<?php echo esc_attr($id); ?>.tp-user-login.tp-user-login-skin-dropdown .lr-extra-div').show('slow')
				}).on( "mouseleave",function() {
					setTimeout(function() {
					if(!($('#<?php echo esc_attr($id); ?>.tp-user-login.tp-user-login-skin-dropdown:hover').length > 0))
						$('#<?php echo esc_attr($id); ?>.tp-user-login.tp-user-login-skin-dropdown .lr-extra-div').hide('slow');
					}, 200);
				});
				/*hover*/
				/*click popup*/
				$("#<?php echo esc_attr($id); ?>.tp-user-login .tp-lr-model-btn").on("click",function(){
					$("#<?php echo esc_attr($id); ?>.tp-user-login.tp-user-login-skin-modal .tp-modal-dialog").toggle('slow');
				});
				/*close icon*/
				$("#<?php echo esc_attr($id); ?>.tp-user-login .lr-close-custom_img").on("click",function(){					
					$("#<?php echo esc_attr($id); ?>.tp-user-login.tp-user-login-skin-modal .tp-modal-dialog").toggle('slow');					
				});
				
				/*close icon*/
				/*click popup*/
				/*popup*/
				$('#<?php echo esc_attr($id); ?>.tp-user-login.tp-user-login-skin-popup .tp-ulsp-trigger').on("click",function() {
					$('#<?php echo esc_attr($id); ?>.tp-user-login.tp-user-login-skin-popup .tp-modal-wrapper').toggleClass('open');
					$('#<?php echo esc_attr($id); ?>.tp-user-login.tp-user-login-skin-popup .tp-ulsp-page-wrapper').toggleClass('blur');
					return false;
   			    });
				/*popup*/
			
				/*lost password*/
					$("#tp-user-login<?php echo esc_attr($id); ?> .tp-lost-password").on("click",function(){					
						$("#tp-user-lost-password<?php echo esc_attr($id); ?>.tp-form-stacked-fp ").toggle();
					});
					  
					/*back*/
					$("#tp-user-lost-password<?php echo esc_attr($id); ?>.tp-form-stacked-fp .tp-lpu-back").on("click",function(){					
						$("#tp-user-lost-password<?php echo esc_attr($id); ?>.tp-form-stacked-fp").hide();
					});
					/*back*/
				/*lost password*/
			});
		</script>
		<?php
	}
	/*Login Ajax*/
	
	/*Register Ajax*/
	public function user_register_ajax_script() { 
	
		$settings = $this->get_settings();
		$id       = 'lr'.$this->get_id();
		if(!empty($settings['auto_loggedin']) && $settings['auto_loggedin']=='yes' && $settings['tp_dis_pass_field']=='yes'){
			$auto_loggedin = true;
		}else{
			$auto_loggedin = false;
		}
		
		$mc_custom_apikey=$mc_custom_listid='';
		$dis_mail_chimp=$settings['tp_mail_chimp_subscribe_opt'];
		if(!empty($dis_mail_chimp) && $dis_mail_chimp=='yes'){			
			if(!empty($settings['mc_custom_apikey']) && $settings['mc_custom_listid']){
				$mc_custom_apikey = $settings['mc_custom_apikey'];
				$mc_custom_listid = $settings['mc_custom_listid'];
			}				
		}
		
		if(!empty($settings['redirect_after_register']) && $settings['redirect_after_register']=='yes' && !empty($settings['redirect_url_reg']['url'])){
			$reg_redirect_page = $settings['redirect_url_reg']['url'];
		}else{
			$reg_redirect_page = '';
		}
		
		?>
		
		<script type="text/javascript">		
			jQuery(document).ready(function($) {				
				//register start
				var register_form = 'form#tp-user-register<?php echo esc_attr($id); ?>';
				var reg_loading_text='<span class="loading-spinner-reg"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span><?php echo esc_html($settings["reg_msg_loading"]); ?>';
				var reg_email_duplicate='<span class="loading-spinner-reg"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span><?php echo esc_html($settings["reg_msg_email_duplication"]); ?>';
				var reg_incorrect_text='<span class="loading-spinner-reg"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span><?php echo esc_html($settings["reg_msg_error"]); ?>';
				var reg_correct_text='<span class="loading-spinner-reg"><i class="fa fa-envelope-o" aria-hidden="true"></i></span><?php echo esc_html($settings["reg_msg_success"]); ?>';
				var reg_redirect_page = "<?php echo $reg_redirect_page; ?>";
			    $(register_form).on('submit', function(e){
			       if($(register_form + ' #user_mail_chimp_subscribe<?php echo esc_attr($id); ?>').prop('checked')== true){
						var mail_chimp_check = 'yes';
				    }else{
						var mail_chimp_check = 'no';
					}
			        $(register_form + ' button.tp-button').attr("disabled", true);
			        $.ajax({
			            type: 'POST',
			            dataType: 'json',
			            url: theplus_ajax_url,
			            data: { 
			                'action': 'theplus_ajax_register', //calls wp_ajax_nopriv
			                'first_name': $(register_form + ' #first_name<?php echo esc_attr($id); ?>').val(), 
			                'last_name': $(register_form + ' #last_name<?php echo esc_attr($id); ?>').val(), 
			                'email': $(register_form + ' #user_email<?php echo esc_attr($id); ?>').val(), 
			                'password': $(register_form + ' #user_password<?php echo esc_attr($id); ?>').val(), 
			                'conf_password': $(register_form + ' #user_conf_password<?php echo esc_attr($id); ?>').val(), 
			                'security': $(register_form + ' #tp-user-register-sc').val(),
							'token':$(register_form + ' .g-recaptcha-response-<?php echo esc_attr($id); ?>').val(),
							'dis_cap':$(register_form).data('dis_cap'), 
							'dis_password':$(register_form).data('dis_password'), 
							'dis_mail_chimp':$(register_form).data('dis_mail_chimp'),
							'mail_chimp_check': mail_chimp_check,
							'auto_loggedin': '<?php echo $auto_loggedin; ?>',
							'mc_custom_apikey': '<?php echo $mc_custom_apikey; ?>',
							'mc_custom_listid': '<?php echo $mc_custom_listid; ?>',
							'tp_user_reg_role':$(register_form).data('tp_user_reg_role'),
			            },
						beforeSend: function(){							
							$(register_form+" .theplus-notification").addClass("active");
							$(register_form+" .theplus-notification .tp-lr-response").html(reg_loading_text);
						},
			            success: function(data) {						
			                if (data.registered == true){
								$(register_form+" .theplus-notification").addClass("active");
								$(register_form+" .theplus-notification .tp-lr-response").html(reg_correct_text);
			                	if(reg_redirect_page!='' && reg_redirect_page!= undefined){
									document.location.href = reg_redirect_page;
			                	}else{
									location.reload(true);
								}
			                }else if(data.registered == false){								
								$(register_form+" .theplus-notification").addClass("active");
								$(register_form+" .theplus-notification .tp-lr-response").html(data.message);
			                }
			        		$(register_form + ' button.tp-button').removeAttr("disabled");
			            },
						 error: function(data) {
							$(register_form+" .theplus-notification").addClass("active");
							$(register_form+" .theplus-notification .tp-lr-response").html(reg_incorrect_text);
						},
						complete: function(){
							setTimeout(function(){
										$(register_form+" .theplus-notification").removeClass("active");	
									}, 1500);
						}
			        });
			        e.preventDefault();

			    });
				
				/*hover*/
				$("#<?php echo esc_attr($id); ?>.tp-user-register.tp-user-register-skin-dropdown,#<?php echo esc_attr($id); ?>.tp-user-register.tp-user-register-skin-dropdown .lr-extra-div").on( "mouseenter",function() {
					$('#<?php echo esc_attr($id); ?>.tp-user-register.tp-user-register-skin-dropdown .lr-extra-div').show('slow')
				}).on( "mouseleave",function() {
					setTimeout(function() {
					if(!($('#<?php echo esc_attr($id); ?>.tp-user-register.tp-user-register-skin-dropdown:hover').length > 0))
						$('#<?php echo esc_attr($id); ?>.tp-user-register.tp-user-register-skin-dropdown .lr-extra-div').hide('slow');
					}, 200);
				});
				/*hover*/
				
				/*click popup*/
				$("#<?php echo esc_attr($id); ?>.tp-user-register .tp-lr-model-btn").on("click",function(){
					$("#<?php echo esc_attr($id); ?>.tp-user-register.tp-user-register-skin-modal .tp-modal-dialog").toggle('slow');
				});
				/*close icon*/
				$("#<?php echo esc_attr($id); ?>.tp-user-register .lr-close-custom_img").on("click",function(){					
					$("#<?php echo esc_attr($id); ?>.tp-user-register.tp-user-register-skin-modal .tp-modal-dialog").toggle('slow');					
				});
				
				/*close icon*/
				/*click popup*/
				
				/*popup*/
				$('#<?php echo esc_attr($id); ?>.tp-user-register.tp-user-register-skin-popup .tp-ursp-trigger').on("click",function() {
					$('#<?php echo esc_attr($id); ?>.tp-user-register.tp-user-register-skin-popup .tp-modal-wrapper').toggleClass('open');
					$('#<?php echo esc_attr($id); ?>.tp-user-register.tp-user-register-skin-popup .tp-ursp-page-wrapper').toggleClass('blur');
					return false;
   			    });
				/*popup*/
				
				/*lost password*/
					$("#tp-user-register<?php echo esc_attr($id); ?> .tp-lost-password").on("click",function(){					
						$("#tp-user-lost-password<?php echo esc_attr($id); ?>.tp-form-stacked-fp ").toggle();
					});
					/*back*/
					$("#tp-user-lost-password<?php echo esc_attr($id); ?>.tp-form-stacked-fp .tp-lpu-back").on("click",function(){					
						$("#tp-user-lost-password<?php echo esc_attr($id); ?>.tp-form-stacked-fp").hide();
					});
					/*back*/
				/*lost password*/
			});
		</script>
		<?php
	}
	/*Register Ajax*/
	
	/*social login start*/	
	public function user_social_log_reg($type='') {
		$settings = $this->get_settings();
		/*condition*/
		$id          = 'lr'.$this->get_id();
		$gid='';
		if($type=='login'){
			$action = 'theplus_ajax_login';
			$gid = 'login';
		}else if($type=='register'){
			$action = 'theplus_ajax_register';
			$gid = 'register';
		}
		if((!empty($settings['tp_sl_facebook']) && $settings['tp_sl_facebook']=="yes") || (!empty($settings['tp_sl_google']) && $settings['tp_sl_google']=="yes")){
		echo '<style>div#g-signin2-register .abcRioButton,div#g-signin2-login .abcRioButton{height:24px!important;width:70px!important}div#g-signin2-register .abcRioButton .abcRioButtonIcon,div#g-signin2-login .abcRioButton .abcRioButtonIcon{padding:5px!important}div#g-signin2-register .abcRioButton .abcRioButtonIcon .abcRioButtonSvgImageWithFallback,div#g-signin2-login .abcRioButton .abcRioButtonIcon .abcRioButtonSvgImageWithFallback{width:16px!important;height:16px!important}div#g-signin2-register .abcRioButtonContentWrapper .abcRioButtonContents,div#g-signin2-login .abcRioButtonContentWrapper .abcRioButtonContents{font-size:11px!important;line-height:1!important;margin:0}div#g-signin2-register .abcRioButtonContentWrapper,div#g-signin2-login .abcRioButtonContentWrapper{display:flex;align-items:center}div#g-signin2-register,div#g-signin2-login{margin-left:15px;border-radius:3px!important;overflow:hidden}</style>';
		
		echo '<div class="tp-social-login-wrapper">';
		if((!empty($settings['tp_sl_facebook']) && $settings['tp_sl_facebook']=='yes')){
		$check_fb_appid= get_option( 'theplus_api_connection_data' );
		$facebook_appid = (!empty($check_fb_appid['theplus_facebook_app_id'])) ? $check_fb_appid['theplus_facebook_app_id'] : '';		
		$nonce = wp_create_nonce( 'ajax-login-nonce' );
		?>
		<script>		
		  
		  function statusChangeCallback(response,type) {  			
			if (response.status === 'connected') { 
			  facebook_fetch_info(type);			  
			} else { 
			}
		  }
			
		  function checkloginstatus(type='') {
			FB.getLoginStatus(function(response) {
			  statusChangeCallback(response,type);
			});
		  }


		  window.fbAsyncInit = function() {
			FB.init({
			  appId      : '<?php echo $facebook_appid; ?>',
			  cookie     : true,
			  xfbml      : true,
			  version    : 'v5.0'
			});

			FB.getLoginStatus(function(response) {   
			  statusChangeCallback(response);        
			});
		  };
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			  }(document, 'script', 'facebook-jssdk')); 
		 
		  function facebook_fetch_info(type) {
			FB.api('/me',{ fields: 'id, name, first_name, last_name, email, link, gender, locale, picture' }, function(response) {			 
			var action='';
			if(type=='login'){
				 action = 'theplus_ajax_login';
			}else if(type=='register'){
				 action = 'theplus_ajax_register';
			}
			if(response.id && response.email && action){
				
				var facebook_fetch_data = {							
							'action' : action,
							'id'  : response.id,
							'name' : response.name,
							'first_name' : response.first_name,
							'last_name' : response.last_name,
							'email' : response.email,
							'link' : response.link,
							'nonce' : "<?php echo $nonce; ?>",
						};
				jQuery.ajax( {
						type: 'POST',
			            dataType: 'json',
			            url: theplus_ajax_url,
			            data: facebook_fetch_data,
						success: function( data ) {				
							if( data.loggedin === true || data.registered === true) {
								//$scope.find( '.status' ).addClass( 'success' ).text( 'Thanks for logging in, ' + response.name + '!' );
								if( '<?php echo $settings['redirect_url_social']['url'] !=''; ?>'){
									window.location = '<?php echo $settings['redirect_url_social']['url']; ?>';
								}else{
									location.reload();
								}	
							}
						}
				});
			}
			});
			
		  }
		
		</script>
		<fb:login-button scope="public_profile,email" onlogin="checkloginstatus('<?php echo $type; ?>');"></fb:login-button>
			<div id="status"></div>
		<?php
		}
		/*facebook login end*/
		
		/*google login start*/			
			if((!empty($settings['tp_sl_google']) && $settings['tp_sl_google']=='yes') && !is_user_logged_in()){
				$check_g_appid= get_option( 'theplus_api_connection_data' );
				$google_clint_id = (!empty($check_g_appid['theplus_google_client_id'])) ? $check_g_appid['theplus_google_client_id'] : '';
				$nonce = wp_create_nonce( 'ajax-login-nonce' );				
			
			if($type=='login'){
				$action = 'theplus_ajax_login';
				$form_id = 'tp-user-login'.esc_attr($id);
			}else if($type=='register'){
				$action = 'theplus_google_ajax_register';
				$form_id = 'tp-user-register'.esc_attr($id);
			}
			?>
			<script>
			var redirect_page = "<?php echo $settings['redirect_url_social']['url']; ?>";
			var fp_loading='<span class="loading-spinner-reg"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span>';
				gapi.load( 'auth2', function() {
					gapi.signin2.render('g-signin2-<?php echo esc_attr($gid); ?>', {
						'scope': 'profile email',
					});
					auth2 = gapi.auth2.init({
						client_id: '<?php echo $google_clint_id; ?>',
						cookiepolicy: 'single_host_origin',
					});
					auth2.attachClickHandler( 'g-signin2-<?php echo esc_attr($gid); ?>', {},

						function ( googleUser ) {
							var profile = googleUser.getBasicProfile();
							var name =  profile.getName();
							var email = profile.getEmail();
							var id_token = googleUser.getAuthResponse().id_token;
							
							var google_data = {
								'nonce': "<?php echo $nonce; ?>",
								'action' : "<?php echo $action; ?>",
								'name' : name,
								'email' : email,
								'id_token' : id_token,
							};
							
							jQuery.ajax({
									url: theplus_ajax_url,
									method: 'post',
									data: google_data,
									dataType: 'json',
									
									success: function(data) {
										if( data.loggedin === true ) {
											if(redirect_page !=''){
												window.location = redirect_page;
											}else{
												location.reload();
											}								
										}else if( data.loggedin === false ) {
											jQuery("#<?php echo esc_attr($form_id);?> .theplus-notification").addClass("active");
											jQuery("#<?php echo esc_attr($form_id);?> .theplus-notification .tp-lr-response").html(fp_loading + data.message);
										}
									},
									complete: function(){
										setTimeout(function(){
											jQuery("#<?php echo esc_attr($form_id);?> .theplus-notification").removeClass("active");	
										}, 3200);
									}
								});

						}, function( error ) {
							console.log( JSON.stringify( error, undefined, 2 ) );                            
						}
					);

				}); 
			</script>
				<div class="g-signin2-<?php echo esc_attr($gid); ?>" id="g-signin2-<?php echo esc_attr($gid); ?>" data-onsuccess="onSignIn"></div>
				<?php
			}			
		/*google login end*/
		echo '</div>';		
		}
		
	}
	/*social login end*/
	
	/*Forgot Password Ajax*/
	public function user_forgot_pass_ajax_script() {
	
		$settings = $this->get_settings();
		$id       = 'lr'.$this->get_id();
		
		if(!empty($settings['reset_pass_url'])){
			$reset_page_url = get_permalink($settings['reset_pass_url']);
			$forgot_page_url = get_the_permalink();
		}else{
			$reset_page_url = get_the_permalink();
			$forgot_page_url = get_the_permalink();
		}
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				
				var forgot_pass_form = 'form#tp-user-lost-password<?php echo esc_attr($id); ?>';
				var fp_loading_text='<span class="loading-spinner-fp"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span><?php echo esc_html($settings["fp_msg_loading"]); ?>';
				var fp_loading='<span class="loading-spinner-reg"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span>';
				var fp_correct_email='<span class="loading-spinner-reg"><i class="fa fa-envelope-o" aria-hidden="true"></i></span><?php echo esc_html($settings["fp_msg_success"]); ?>';
				var fp_err_msg='<span class="loading-spinner-reg"><i class="fa fa-envelope-o" aria-hidden="true"></i></span><?php echo esc_html($settings["fp_msg_error"]); ?>';
			    
			    $(forgot_pass_form).on('submit', function(e){
			        $.ajax({
			            type: 'POST',
			            dataType: 'json',
			            url: theplus_ajax_url,
			            data: { 
			                'action': 'theplus_ajax_forgot_password',
			                'user_login': $(forgot_pass_form + ' #user_login<?php echo esc_attr($id); ?>').val(),
							'f_p_opt': $(forgot_pass_form).data('f_p_opt'), 
							'resetpageurl': '<?php echo $reset_page_url; ?>',
							'forgotpageurl': '<?php echo $forgot_page_url; ?>',
							'nonce': $(forgot_pass_form + ' #tp_user_lost_password_nonce').val()
			            },
						beforeSend: function(){							
							$("#tp-user-lost-password<?php echo esc_attr($id);?> .theplus-notification").addClass("active");
							$("#tp-user-lost-password<?php echo esc_attr($id);?> .theplus-notification .tp-lr-response").html(fp_loading_text);
						},
			            success: function(data) {
						
								if(data.message){
									$("#tp-user-lost-password<?php echo esc_attr($id);?> .theplus-notification").addClass("active");
									$("#tp-user-lost-password<?php echo esc_attr($id);?> .theplus-notification .tp-lr-response").html(fp_loading + data.message);
								}else{
									$("#tp-user-lost-password<?php echo esc_attr($id);?> .theplus-notification").addClass("active");
									$("#tp-user-lost-password<?php echo esc_attr($id);?> .theplus-notification .tp-lr-response").html(fp_loading + 'Is Not Working Server Issue...');
								}
			            },
						complete: function(){
							setTimeout(function(){
								$("#tp-user-lost-password<?php echo esc_attr($id);?> .theplus-notification").removeClass("active");	
							}, 3200);
						}
			        });
			        e.preventDefault();
					
			    });
			
			});
		</script>
		<?php
	}
}