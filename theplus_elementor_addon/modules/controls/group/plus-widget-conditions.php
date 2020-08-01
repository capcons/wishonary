<?php
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Rules Extension
 *
 * Adds display rules to elements
 *
 * @since 2.1.0
 */
class Theplus_Widgets_Rules extends Elementor\Widget_Base {

	/**
	 * Display Rules 
	 *
	 * Holds all the rules for display on the frontend
	 *
	 * @since 2.1.0
	 * @access protected
	 *
	 * @var bool
	 */
	protected $conditions = [];

	/**
	 * Display Rules 
	 *
	 * Holds all the rules for display on the frontend
	 *
	 * @since 2.1.0
	 * @access protected
	 *
	 * @var bool
	 */
	protected $conditions_options = [];
	
	
	public function __construct() {
	
		$theplus_options=get_option('theplus_options');
		$plus_extras=theplus_get_option('general','extras_elements');
		
		if((isset($plus_extras) && empty($plus_extras) && empty($theplus_options)) || (!empty($plus_extras) && in_array('plus_display_rules',$plus_extras))){
			
			$this->plus_add_sections_actions();
			$this->plus_add_actions();
			
		}
		
	}
	
	/**
	 * A list of scripts that the widgets is depended in
	 *
	 * @since 2.1.0
	 **/
	public function get_script_depends() {
		return [];
	}

	public function get_name() {
		return 'plus-widgets-rules';
	}
	
	/**
	 * Is disabled by default
	 *
	 * @since 2.1.0
	 * @return bool
	 */
	public static function is_default_disabled() {
		return true;
	}
	
	
	/**
	 * Add common sections
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function plus_add_sections_actions() {

		// Activate sections for widgets
		add_action( 'elementor_pro/element/common/section_custom_css/after_section_end', [ $this, 'add_rules_controls' ], 10, 2 );

		// Activate sections for sections
		add_action( 'elementor/element/section/section_custom_css/after_section_end', [ $this, 'add_rules_controls' ], 10, 2 );
		
		// Activate sections for widgets if elementor pro
		add_action( 'elementor/element/common/section_custom_css_pro/after_section_end', [ $this, 'add_rules_controls' ], 10, 2 );
		
	}
	
	/**
	 * Set the Rules options array
	 *
	 * @since 2.1.0
	 *
	 * @access private
	 */
	private function set_rules_options() {

		$this->rules_options = [
			[
				'label'		=> esc_html__( 'Visitor', 'theplus' ),
				'options' 	=> [
					'authentication' 	=> esc_html__( 'Login Status', 'theplus' ),
					'role' 				=> esc_html__( 'User Role', 'theplus' ),
					'os' 				=> esc_html__( 'Operating System', 'theplus' ),
					'browser' 			=> esc_html__( 'Browser', 'theplus' ),
				],
			],
			[
				'label'			=> esc_html__( 'Date & Time', 'theplus' ),
				'options' 		=> [
					'date' 		=> esc_html__( 'Current Date', 'theplus' ),
					'time' 		=> esc_html__( 'Time of Day', 'theplus' ),
					'day' 		=> esc_html__( 'Day of Week', 'theplus' ),
				],
			],
			[
				'label'					=> esc_html__( 'Single', 'theplus' ),
				'options' 				=> [
					'page' 				=> esc_html__( 'Page', 'theplus' ),
					'post' 				=> esc_html__( 'Post', 'theplus' ),
					'static_page' 		=> esc_html__( 'Static Page', 'theplus' ),
					'post_type' 		=> esc_html__( 'Post Type', 'theplus' ),
				],
			],
			[
				'label'					=> esc_html__( 'Archive', 'theplus' ),
				'options' 				=> [
					'taxonomy_archive' 	=> esc_html__( 'Taxonomy', 'theplus' ),
					'term_archive' 		=> esc_html__( 'Term', 'theplus' ),
					'post_type_archive'	=> esc_html__( 'Post Type', 'theplus' ),
					'date_archive'		=> esc_html__( 'Date', 'theplus' ),
					'author_archive'	=> esc_html__( 'Author', 'theplus' ),
					'search_results'	=> esc_html__( 'Search', 'theplus' ),
				],
			],
			[
				'label'					=> esc_html__( 'Advanced Custom Fields', 'theplus' ),
				'options' 				=> [
					'acf_text' 	=> esc_html__( 'Text', 'theplus' ),
					'acf_choice' 	=> esc_html__( 'Choice', 'theplus' ),
					'acf_true_false' 		=> esc_html__( 'True / False', 'theplus' ),
					'acf_post'	=> esc_html__( 'Post', 'theplus' ),
					'acf_taxonomy'		=> esc_html__( 'Taxonomy', 'theplus' ),
					'acf_date_time'	=> esc_html__( 'Date / Time', 'theplus' ),
				],
			],
		];

		// EDD Rules
		if ( class_exists( 'Easy_Digital_Downloads', false ) ) {
			$this->rules_options[] = [
				'label'					=> esc_html__( 'Easy Digital Downloads', 'theplus' ),
				'options' 				=> [
					'edd_cart' 			=> esc_html__( 'Cart', 'theplus' ),
				],
			];
		}
	}
	
	/**
	 * Add Controls
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function add_rules_controls( $element, $args ) {

		global $wp_roles;

		$default_start_date = date( 'Y-m-d', strtotime( '-3 day' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
		$default_end_date 	= date( 'Y-m-d', strtotime( '+3 day' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
		$default_interval 	= $default_start_date . ' to ' . $default_end_date;

		$element_type = $element->get_type();
		
		$element->start_controls_section(
			'plus_widgets_rules_section',
			[
				'label' => esc_html__( 'Plus Extra : Display Rules', 'theplus' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);
		
		$element->add_control(
			'tp_display_rules_enable',
			[
				'label'			=> esc_html__( 'Display Rules', 'theplus' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'default' 		=> '',
				'label_on' 		=> esc_html__( 'Yes', 'theplus' ),
				'label_off' 	=> esc_html__( 'No', 'theplus' ),
				'return_value' 	=> 'yes',
				'frontend_available'	=> true,
			]
		);

		if ( 'widget' === $element_type ) {
			$element->add_control(
				'tp_display_rules_output',
				[
					'label'		=> esc_html__( 'HTML Rendering', 'theplus' ),
					'description' => sprintf( esc_html__( 'If enabled, It will render HTML on front end and Section will be hidden by using Display;None CSS. If disabled, HTML content will not load.', 'theplus' ), $element_type ),
					'default'	=> 'yes',
					'type' 		=> Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'theplus' ),
					'label_off' 	=> esc_html__( 'No', 'theplus' ),
					'return_value' 	=> 'yes',
					'frontend_available' => true,
					'condition'	=> [
						'tp_display_rules_enable' => 'yes',
					],
				]
			);
		}

		$element->add_control(
			'tp_display_rules_relation',
			[
				'label'		=> esc_html__( 'Display When', 'theplus' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'all',
				'options' 	=> [
					'all' 		=> esc_html__( 'All Rules are True', 'theplus' ),
					'any' 		=> esc_html__( 'Any one Rule is True', 'theplus' ),
				],
				'condition'	=> [
					'tp_display_rules_enable' => 'yes',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tp_rule_key',
			[
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'authentication',
				'label_block' => true,
				'groups' 	=> $this->rules_options,
			]
		);
		
		$repeater->add_control(
			'tp_rule_operator',
			[
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'is',
				'label_block' 	=> true,
				'options' 		=> [
					'is' 		=> esc_html__( 'Is', 'theplus' ),
					'not' 		=> esc_html__( 'Not', 'theplus' ),
				],
			]
		);

		$repeater->add_control(
			'tp_rule_authentication_value',
			[
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'authenticated',
				'label_block' => true,
				'options' 	=> [
					'authenticated' => esc_html__( 'Logged in', 'theplus' ),
				],
				'condition' => [
					'tp_rule_key' => 'authentication',
				],
			]
		);;

		$repeater->add_control(
			'tp_rule_role_value',
			[
				'type' 			=> Controls_Manager::SELECT,
				'description' 	=> esc_html__( 'Warning: This rule applies only to logged in visitors.', 'theplus' ),
				'default' 		=> 'subscriber',
				'label_block' 	=> true,
				'options' 		=> $wp_roles->get_names(),
				'condition' 	=> [
					'tp_rule_key' => 'role',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_date_value',
			[
				'label'		=> esc_html__( 'In interval', 'theplus' ),
				'type' 		=> \Elementor\Controls_Manager::DATE_TIME,
				'picker_options' => [
					'enableTime'	=> false,
					'mode' 			=> 'range',
				],
				'label_block'	=> true,
				'default' 		=> $default_interval,
				'condition' 	=> [
					'tp_rule_key' => 'date',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_time_value',
			[
				'label'		=> esc_html__( 'Before', 'theplus' ),
				'type' 		=> \Elementor\Controls_Manager::DATE_TIME,
				'picker_options' => [
					'dateFormat' 	=> "H:i",
					'enableTime' 	=> true,
					'noCalendar' 	=> true,
				],
				'label_block'	=> true,
				'default' 		=> '',
				'condition' 	=> [
					'tp_rule_key' => 'time',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_day_value',
			[
				'label'			=> esc_html__( 'Before', 'theplus' ),
				'type' 			=> Controls_Manager::SELECT2,
				'placeholder'	=> esc_html__( 'Any', 'theplus' ),
				'multiple'		=> true,
				'options' => [
					'1' => esc_html__( 'Monday', 'theplus' ),
					'2' => esc_html__( 'Tuesday', 'theplus' ),
					'3' => esc_html__( 'Wednesday', 'theplus' ),
					'4' => esc_html__( 'Thursday', 'theplus' ),
					'5' => esc_html__( 'Friday', 'theplus' ),
					'6' => esc_html__( 'Saturday', 'theplus' ),
					'7' => esc_html__( 'Sunday', 'theplus' ),
				],
				'label_block'	=> true,
				'default' 		=> 'Monday',
				'condition' 	=> [
					'tp_rule_key' => 'day',
				],
			]
		);

		$os_options = $this->get_os_opt();

		$repeater->add_control(
			'tp_rule_os_value',
			[
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> array_keys( $os_options )[0],
				'label_block' 	=> true,
				'options' 		=> $os_options,
				'condition' 	=> [
					'tp_rule_key' => 'os',
				],
			]
		);

		$browser_options = $this->get_browser_opt();

		$repeater->add_control(
			'tp_rule_browser_value',
			[
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> array_keys( $browser_options )[0],
				'label_block' 	=> true,
				'options' 		=> $browser_options,
				'condition' 	=> [
					'tp_rule_key' => 'browser',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_page_value',
			[
				'type' 			=> 'plus-query',
				'default' 		=> '',
				'placeholder'	=> esc_html__( 'Any', 'theplus' ),
				'description'	=> esc_html__( 'Leave blank for any page.', 'theplus' ),
				'label_block' 	=> true,
				'multiple'		=> true,
				'query_type'	=> 'posts',
				'object_type'	=> 'page',
				'condition' 	=> [
					'tp_rule_key' => 'page',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_post_value',
			[
				'type' 			=> 'plus-query',
				'default' 		=> '',
				'placeholder'	=> esc_html__( 'Any', 'theplus' ),
				'description'	=> esc_html__( 'Leave blank for any post.', 'theplus' ),
				'label_block' 	=> true,
				'multiple'		=> true,
				'query_type'	=> 'posts',
				'object_type'	=> '',
				'condition' 	=> [
					'tp_rule_key' => 'post',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_static_page_value',
			[
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'home',
				'label_block' 	=> true,
				'options' 		=> [
					'home'		=> esc_html__( 'Default Homepage', 'theplus' ),
					'static'	=> esc_html__( 'Static Homepage', 'theplus' ),
					'blog'		=> esc_html__( 'Blog Page', 'theplus' ),
					'404'		=> esc_html__( '404 Page', 'theplus' ),
				],
				'condition' 	=> [
					'tp_rule_key' => 'static_page',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_post_type_value',
			[
				'type' 			=> Controls_Manager::SELECT2,
				'default' 		=> '',
				'placeholder'	=> esc_html__( 'Any', 'theplus' ),
				'description'	=> esc_html__( 'Leave blank or select all for any post type.', 'theplus' ),
				'label_block' 	=> true,
				'multiple'		=> true,
				'options' 		=> $this->get_post_types_opt( true ),
				'condition' 	=> [
					'tp_rule_key' => 'post_type',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_taxonomy_archive_value',
			[
				'type' 			=> Controls_Manager::SELECT2,
				'default' 		=> '',
				'placeholder'	=> esc_html__( 'Any', 'theplus' ),
				'description'	=> esc_html__( 'Leave blank or select all for any taxonomy archive.', 'theplus' ),
				'multiple'		=> true,
				'label_block' 	=> true,
				'options' 		=> $this->get_taxonomies_opt(),
				'condition' 	=> [
					'tp_rule_key' => 'taxonomy_archive',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_term_archive_value',
			[
				'label' 		=> esc_html__( 'Term', 'theplus' ),
				'description'	=> esc_html__( 'Leave blank or select all for any term archive.', 'theplus' ),
				'type' 			=> 'plus-query',
				'post_type' 	=> '',
				'options' 		=> [],
				'label_block' 	=> true,
				'multiple' 		=> true,
				'query_type' 	=> 'terms',
				'include_type' 	=> true,
				'condition' 	=> [
					'tp_rule_key' => 'term_archive',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_post_type_archive_value',
			[
				'type' 			=> Controls_Manager::SELECT2,
				'default' 		=> '',
				'placeholder'	=> esc_html__( 'Any', 'theplus' ),
				'description'	=> esc_html__( 'Leave blank or select all for any post type.', 'theplus' ),
				'multiple'		=> true,
				'label_block' 	=> true,
				'options' 		=> $this->get_post_types_opt(),
				'condition' 	=> [
					'tp_rule_key' => 'post_type_archive',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_date_archive_value',
			[
				'type' 			=> Controls_Manager::SELECT2,
				'default' 		=> '',
				'placeholder'	=> esc_html__( 'Any', 'theplus' ),
				'description'	=> esc_html__( 'Leave blank or select all for any date based archive.', 'theplus' ),
				'multiple'		=> true,
				'label_block' 	=> true,
				'options' 		=> [
					'day'		=> esc_html__( 'Day', 'theplus' ),
					'month'		=> esc_html__( 'Month', 'theplus' ),
					'year'		=> esc_html__( 'Year', 'theplus' ),
				],
				'condition' 	=> [
					'tp_rule_key' => 'date_archive',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_author_archive_value',
			[
				'type' 			=> 'plus-query',
				'default' 		=> '',
				'placeholder'	=> esc_html__( 'Any', 'theplus' ),
				'description'	=> esc_html__( 'Leave blank for all authors.', 'theplus' ),
				'multiple'		=> true,
				'label_block' 	=> true,
				'query_type'	=> 'authors',
				'condition' 	=> [
					'tp_rule_key' => 'author_archive',
				],
			]
		);

		$repeater->add_control(
			'tp_rule_search_results_value',
			[
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> '',
				'placeholder'	=> esc_html__( 'Keywords', 'theplus' ),
				'description'	=> esc_html__( 'Enter keywords, separated by commas, to condition the display on specific keywords and leave blank for any.', 'theplus' ),
				'label_block' 	=> true,
				'condition' 	=> [
					'tp_rule_key' => 'search_results',
				],
			]
		);

		if ( class_exists( 'Easy_Digital_Downloads', false ) ) {
			$repeater->add_control(
				'tp_rule_edd_cart_value',
				[
					'type' 			=> Controls_Manager::SELECT,
					'default' 		=> 'empty',
					'label_block' 	=> true,
					'options' 		=> [
						'empty'		=> esc_html__( 'Empty', 'theplus' ),
					],
					'condition' 	=> [
						'tp_rule_key' => 'edd_cart',
					],
				]
			);
		}

		$element->add_control(
			'tp_display_rules',
			[
				'label' 	=> esc_html__( 'Rules', 'theplus' ),
				'type' 		=> Controls_Manager::REPEATER,
				'default' 	=> [
					[
						'tp_rule_key' 					=> 'authentication',
						'tp_rule_operator' 			=> 'is',
						'tp_rule_authentication_value' => 'authenticated',
					],
				],
				'condition'		=> [
					'tp_display_rules_enable' => 'yes',
				],
				'fields' 		=> array_values( $repeater->get_controls() ),
				'title_field' 	=> 'Rule',
			]
		);
		$element->end_controls_section();
	}

	/**
	 * Get browser options for control
	 *
	 * @access protected
	 */
	protected function get_browser_opt() {
		return [
			'ie'			=> 'Internet Explorer',
			'chrome'		=> 'Google Chrome',
			'firefox'		=> 'Mozilla Firefox',
			'opera'			=> 'Opera',
			'opera_mini'	=> 'Opera Mini',
			'safari'		=> 'Safari',
		];
	}
	
	/**
	 * Get OS options for control
	 *
	 * @access protected
	 */
	protected function get_os_opt() {
		return [
			'iphone' 		=> 'iPhone',
			'safari'    	=> 'Safari',
			'mac_os'    	=> 'Mac OS',
			'windows' 		=> 'Windows',
			'linux'     	=> 'Linux',
			'open_bsd'		=> 'OpenBSD',
			'sun_os'    	=> 'SunOS',
			'qnx'       	=> 'QNX',
			'search_bot'	=> 'Search Bot',
			'beos'      	=> 'BeOS',
			'os2'       	=> 'OS/2',
			
		];
	}

	public function get_post_types_opt( $singular = false, $any = false, $args = [] ) {
		$post_type_args = [
			'show_in_nav_menus' => true,
		];

		if ( $any ) $post_types['any'] = esc_html__( 'Any', 'theplus' );

		if ( ! function_exists( 'get_post_types' ) )
			return $post_types;

		$post_types_obj = get_post_types( $post_type_args, 'objects' );

		foreach ( $post_types_obj as $post_type => $object ) {
			$post_types[ $post_type ] = $singular ? $object->labels->singular_name : $object->label;
		}

		return $post_types;
	}
	
	public function get_taxonomies_opt() {

		$options = [];

		$taxonomies = get_taxonomies( array(
					'show_in_nav_menus' => true
				), 'objects' );

		if ( empty( $taxonomies ) ) {
			$options[ '' ] = esc_html__( 'Not found taxonomies', 'theplus' );
			return $options;
		}

		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}

		return $options;
	}
	
	/**
	 * Add Actions
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function plus_add_actions() {

		$this->set_rules_options();

		// Activate controls for widgets		
		add_action( 'elementor/element/section/section_custom_css/after_section_end', [ $this, 'add_rules_controls' ], 10, 2 );

		// Rules for widgets
		add_action( 'elementor/widget/render_content', function( $widget_content, $element ) {

			$settings = $element->get_settings();

			if ( !empty($settings[ 'tp_display_rules_enable' ]) && 'yes' === $settings[ 'tp_display_rules_enable' ] ) {

				// Set the rules
				$this->set_rules( $element->get_id(), $settings['tp_display_rules'] );

				
				if ( ! $this->display_is_visible( $element->get_id(), $settings['tp_display_rules_relation'] ) && !empty($settings['tp_display_rules_relation'])) { // Check the rules
					if ( 'yes' !== $settings['tp_display_rules_output'] ) {
						return; // And on frontend we stop the rendering of the widget
					}
				}
			}
   
			return $widget_content;
		
		}, 10, 2 );

		// Rules for widgets
		add_action( 'elementor/frontend/widget/before_render', function( $element ) {
			
			$settings = $element->get_settings();

			if ( !empty($settings[ 'tp_display_rules_enable' ]) && 'yes' === $settings[ 'tp_display_rules_enable' ] ) {

				// Set the rules
				$this->set_rules( $element->get_id(), $settings['tp_display_rules'] );

				if ( ! $this->display_is_visible( $element->get_id(), $settings['tp_display_rules_relation'] ) && !empty($settings['tp_display_rules_relation']) ) { // Check the rules
					$element->add_render_attribute( '_wrapper', 'class', 'plus-conditions--hidden' );
				}
			}

		}, 10, 1 );

		// Rules for sections
		add_action( 'elementor/frontend/section/before_render', function( $element ) {
			
			$settings = $element->get_settings();

			if ( !empty($settings[ 'tp_display_rules_enable' ]) && 'yes' === $settings[ 'tp_display_rules_enable' ] ) {

				// Set the rules
				$this->set_rules( $element->get_id(), $settings['tp_display_rules'] );

				if ( ! $this->display_is_visible( $element->get_id(), $settings['tp_display_rules_relation'] ) && !empty($settings['tp_display_rules_relation']) ) { // Check the rules
					$element->add_render_attribute( '_wrapper', 'class', 'plus-conditions--hidden' );
				}
			}

		}, 10, 1 );

	}

	protected function render_editor_notice( $settings ) {
		?><span><?php echo esc_html__('This widget is displayed rules condition.','theplus'); ?></span>
		<?php
	}

	/**
	 * Set rules.
	 *
	 * Sets the rules methods to all rules comparison values
	 *
	 * @access protected
	 * @static
	 *
	 * @param mixed  $rules The rules from the repeater field control
	 *
	 * @return void
	 */
	protected function set_rules( $id, $rules = [] ) {
		if ( ! $rules )
			return;

		foreach ( $rules as $index => $rule ) {
			$key 		= $rule['tp_rule_key'];
			$check_is_not 	= $rule['tp_rule_operator'];
			$value 		= $rule['tp_rule_' . $key . '_value'];

			if ( method_exists( $this, 'plus_check_' . $key ) ) {
				$check = call_user_func( [ $this, 'plus_check_' . $key ], $value, $check_is_not );
				$this->conditions[ $id ][ $key . '_' . $rule['_id'] ] = $check;
			}
		}
	}

	/**
	 * Check rules.
	 *
	 * Checks for all or any rules and returns true or false
	 * @access protected
	 * @static
	 *
	 * @return bool
	 */
	protected function display_is_visible( $id, $relation ) {

		if ( ! array_key_exists( $id, $this->conditions ) )
			return;

		if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			if ( $relation === 'any' ) {
				if ( ! in_array( true, $this->conditions[ $id ] ) )
					return false;
			} else {
				if ( in_array( false, $this->conditions[ $id ] ) )
					return false;
			}
		}

		return true;
	}

	/**
	 * compare_check rules.
	 *
	 * Compare values is or not
	 *
	 * @access protected
	 * @static
	 *
	 * @param mixed  First value to compare_check.
	 * @param mixed  Second value to compare_check.
	 * @param string Comparison values.
	 *
	 * @return bool
	 */
	protected static function compare_check( $first_value, $second_value, $check_is_not ) {
		switch ( $check_is_not ) {
			case 'is':
				return $first_value == $second_value;
			case 'not':
				return $first_value != $second_value;
			default:
				return $first_value === $second_value;
		}
	}

	/**
	 * Check user login status
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string  $check_is_not  Comparison value.
	 */
	protected static function plus_check_authentication( $value, $check_is_not ) {
		return self::compare_check( is_user_logged_in(), true, $check_is_not );
	}

	/**
	 * Check user role
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string  $check_is_not  Comparison value.
	 */
	protected static function plus_check_role( $value, $check_is_not ) {

		$user = wp_get_current_user();
		
		return self::compare_check( is_user_logged_in() && in_array( $value, $user->roles ), true, $check_is_not );
	}
	
	/**
	 * Check time of day interval
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string  $check_is_not  Comparison value.
	 */
	protected static function plus_check_time( $value, $check_is_not ) {

		$time 	= date( 'H:i', strtotime( preg_replace('/\s+/', '', $value ) ) );
		$now 	= date( 'H:i', strtotime("now") + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
		
		$display 	= false;

		if ( \DateTime::createFromFormat( 'H:i', $time ) === false ) // Make sure it's a valid DateTime format
			return;
		
		$time_ts 	= strtotime( $time );
		$now_ts 	= strtotime( $now );
		
		$display = ( $now_ts < $time_ts );

		return self::compare_check( $display, true, $check_is_not );
	}
	
	/**
	 * Check date interval 
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string  $check_is_not  Comparison value.
	 */
	protected static function plus_check_date( $value, $check_is_not ) {

		$between = explode( 'to' , preg_replace('/\s+/', '', $value ) );

		if ( ! is_array( $between ) || 2 !== count( $between ) ) 
			return;

		$today 	= date('Y-m-d');
		$start_date 	= $between[0];
		$end_date 	= $between[1];		

		$display 	= false;

		if ( \DateTime::createFromFormat( 'Y-m-d', $start_date ) === false || // Make sure it's a date
			 \DateTime::createFromFormat( 'Y-m-d', $end_date ) === false ) // Make sure it's a date
			return;

		$start 	= strtotime( $start_date ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
		$end 	= strtotime( $end_date ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
		$today_date 	= strtotime( $today ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );

		$display = ( ($today_date >= $start ) && ( $today_date <= $end ) );

		return self::compare_check( $display, true, $check_is_not );
	}

	

	/**
	 * Check day of week name
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string  $check_is_not  Comparison value.
	 */
	protected static function plus_check_day( $value, $check_is_not ) {

		$display = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {
				if ( $_value === date( 'w' ) ) {
					$display = true; break;
				}
			}
		} else { $display = $value === date( 'w' ); }

		return self::compare_check( $display, true, $check_is_not );
	}

	/**
	 * Check operating system of visitor
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_os( $value, $check_is_not ) {

		$os_list = [
			'iphone'            => '(iPhone)',
			'safari'            => '(Safari)',
			'mac_os'            => '(Mac_PowerPC)|(Macintosh)',
			'windows' 			=> 'Win16|(Windows 95)|(Win95)|(Windows_95)|(Windows 98)|(Win98)|(Windows NT 5.0)|(Windows 2000)|(Windows NT 5.1)|(Windows XP)|(Windows NT 5.2)|(Windows NT 6.0)|(Windows Vista)|(Windows NT 6.1)|(Windows 7)|(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)|Windows ME',			
			'beos'              => 'BeOS',
			'linux'             => '(Linux)|(X11)',			
			'open_bsd'          => 'OpenBSD',
			'qnx'               => 'QNX',			
			'os2'              	=> 'OS/2',
			'search_bot'        => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)',
			'sun_os'            => 'SunOS',			
		];

		return self::compare_check( preg_match('@' . $os_list[ $value ] . '@', $_SERVER['HTTP_USER_AGENT'] ), true, $check_is_not );
	}

	/**
	 * Check browser of visitor
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_browser( $value, $check_is_not ) {

		$browsers_list = [
			'ie'			=> [
				'MSIE',
				'Trident',
			],
			'chrome'		=> 'Chrome',
			'firefox'		=> 'Firefox',
			'opera'			=> 'Opera',
			'opera_mini'	=> 'Opera Mini',
			'safari'		=> 'Safari',
		];

		$display = false;

		if ( $value === 'ie' ) {
			if ( false !== strpos( $_SERVER['HTTP_USER_AGENT'], $browsers_list[ $value ][0] ) || false !== strpos( $_SERVER['HTTP_USER_AGENT'], $browsers_list[ $value ][1] ) ) {
				$display = true;
			}
		} else {
			if ( false !== strpos( $_SERVER['HTTP_USER_AGENT'], $browsers_list[ $value ] ) ) {
				$display = true;

				// Additional check for Chrome that returns Safari
				if ( $value === 'firefox' || $value === 'safari' ) {
					if ( false !== strpos( $_SERVER['HTTP_USER_AGENT'], 'Chrome' ) ) {
						$display = false;
					}
				}
			}
		}
		

		return self::compare_check( $display, true, $check_is_not );
	}

	/**
	 * Check current page
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_page( $value, $check_is_not ) {
		$display = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {
				if ( is_page( $_value ) ) {
					$display = true; break;
				}
			}
		} else { $display = is_page( $value ); }

		return self::compare_check( $display, true, $check_is_not );
	}

	/**
	 * Check current post
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_post( $value, $check_is_not ) {
		$display = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {
				if ( is_single( $_value ) || is_singular( $_value ) ) {
					$display = true; break;
				}
			}
		} else { $display = is_single( $value ) || is_singular( $value ); }

		return self::compare_check( $display, true, $check_is_not );
	}

	/**
	 * Check current post type
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_post_type( $value, $check_is_not ) {
		
		$display = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {
				if ( is_singular( $_value ) ) {
					$display = true; break;
				}
			}
		} else { $display = is_singular( $value ); }

		return self::compare_check( $display, true, $check_is_not );
	}
	
	/**
	 * Check browser of visitors
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_static_page( $value, $check_is_not ) {

		if ( $value === 'home' ) {
			return self::compare_check( ( is_front_page() && is_home() ), true, $check_is_not );
		} elseif ( $value === 'static' ) {
			return self::compare_check( ( is_front_page() && ! is_home() ), true, $check_is_not );
		} elseif ( $value === 'blog' ) {
			return self::compare_check( ( ! is_front_page() && is_home() ), true, $check_is_not );
		} elseif ( $value === '404' ) {
			return self::compare_check( is_404(), true, $check_is_not );
		}
	}
	
	/**
	 * Check current taxonomy archive
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not Comparison value.
	 */
	protected static function plus_check_taxonomy_archive( $value, $check_is_not ) {
		$display = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {

				$display = self::plus_check_taxonomy_archive_type( $_value );

				if ( $display ) break;
			}
		} else { $display = self::plus_check_taxonomy_archive_type( $value ); }

		return self::compare_check( $display, true, $check_is_not );
	}

	/**
	 * Checks taxonomy current page template
	 *
	 * @access protected
	 *
	 * @param string  $taxonomy The taxonomy to check value
	 */
	protected static function plus_check_taxonomy_archive_type( $taxonomy ) {
		
		if ( $taxonomy === 'category' ) {
			return is_category();
		} else if ( $taxonomy === 'post_tag' ) {
			return is_tag();
		} else if ( $taxonomy === '' || empty( $taxonomy ) ) {
			return is_tax() || is_category() || is_tag();
		} else {
			return is_tax( $taxonomy );
		}

		return false;
	}

	/**
	 * Check current taxonomy terms archive
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_term_archive( $value, $check_is_not ) {
		$display = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {

				$display = self::plus_check_term_archive_type( $_value );

				if ( $display ) break;
			}
		} else { $display = self::plus_check_term_archive_type( $value ); }

		return self::compare_check( $display, true, $check_is_not );
	}

	/**
	 * Checks taxonomy term current page template
	 *
	 * @access protected
	 *
	 * @param string  $taxonomy  The taxonomy to check value
	 */
	protected static function plus_check_term_archive_type( $term ) {

		if ( is_category( $term ) ) {
			return true;
		} else if ( is_tag( $term ) ) {
			return true;
		} else if ( is_tax() ) {
			if ( is_tax( get_queried_object()->taxonomy, $term ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check current post type archive
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_post_type_archive( $value, $check_is_not ) {
		
		$display = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {
				if ( is_post_type_archive( $_value ) ) {
					$display = true; break;
				}
			}
		} else { $display = is_post_type_archive( $value ); }

		return self::compare_check( $display, true, $check_is_not );
	}

	/**
	 * Check current date archive
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_date_archive( $value, $check_is_not ) {
		
		$display = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {
				if ( self::plus_check_date_archive_type( $_value ) ) {
					$display = true; break;
				}
			}
		} else { $display = is_date( $value ); }

		return self::compare_check( $display, true, $check_is_not );
	}

	/**
	 * Checks date type current page template
	 *
	 * @access protected
	 *
	 * @param string  $type The type of date archive to check value
	 */
	protected static function plus_check_date_archive_type( $type ) {
		
		if ( $type === 'day' ) { 
			return is_day();
		} elseif ( $type === 'month' ) { 
			return is_month();
		} elseif ( $type === 'year' ) { 
			return is_year();
		}

		return false;
	}


	/**
	 * Check current search query
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_search_results( $value, $check_is_not ) {
		$display = false;

		if ( is_search() ) {

			if ( empty( $value ) ) {
				$display = true;
			} else {
				$phrase = get_search_query();

				if ( '' !== $phrase && ! empty( $phrase ) ) { 

					$keywords = explode( ',', $value ); 

					foreach ( $keywords as $index => $keyword ) {
						if ( self::tp_keyword_exists( trim( $keyword ), $phrase ) ) {
							$display = true; break;
						}
					}
				}
			}
		}

		return self::compare_check( $display, true, $check_is_not );
	}

	protected static function tp_keyword_exists( $keyword, $phrase ) {
		return strpos( $phrase, trim( $keyword ) ) !== false;
	}

	/**
	 * Check current author archive
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_author_archive( $value, $check_is_not ) {
		$display = false;

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $_key => $_value ) {
				if ( is_author( $_value ) ) {
					$display = true; break;
				}
			}
		} else {
			$display = is_author( $value ); 
		}

		return self::compare_check( $display, true, $check_is_not );
	}
	
	/**
	 * Check is EDD Cart is empty
	 *
	 * @access protected
	 *
	 * @param mixed  $value  The control value to check
	 * @param string $check_is_not  Comparison value.
	 */
	protected static function plus_check_edd_cart( $value, $check_is_not ) {
		
		if ( ! class_exists( 'Easy_Digital_Downloads', false ) )
			return false;

		$display = empty( edd_get_cart_contents() );

		return self::compare_check( $display, true, $check_is_not );
	}

}