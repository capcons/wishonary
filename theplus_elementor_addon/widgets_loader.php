<?php
namespace TheplusAddons;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Theplus_Element_Load {
	/**
		* Core singleton class
		* @var self - pattern realization
	*/
	private static $_instance;

	/**
	 * @var Manager
	 */
	private $_modules_manager;

	/**
	 * @deprecated
	 * @return string
	 */
	public function get_version() {
		return THEPLUS_VERSION;
	}
	
	/**
	* Cloning disabled
	*/
	public function __clone() {
	}
	
	/**
	* Serialization disabled
	*/
	public function __sleep() {
	}
	
	/**
	* De-serialization disabled
	*/
	public function __wakeup() {
	}
	
	/**
	* @return \Elementor\Theplus_Element_Loader
	*/
	public static function elementor() {
		return \Elementor\Plugin::$instance;
	}
	
	/**
	* @return Theplus_Element_Loader
	*/
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * we loaded module manager + admin php from here
	 * @return [type] [description]
	 */
	private function includes() {
		if ( ! class_exists( 'CMB2' ) ){
			require_once THEPLUS_INCLUDES_URL.'plus-options/metabox/init.php';
		}
		$option_name='default_plus_options';
		$value='1';
		if ( is_admin() && get_option( $option_name ) !== false ) {
		} else if( is_admin() ){
			$default_load=get_option( 'theplus_options' );
			if ( $default_load !== false && $default_load!='') {
				$deprecated = null;
				$autoload = 'no';
				add_option( $option_name,$value, $deprecated, $autoload );
			}else{
				$theplus_options=get_option( 'theplus_options' );
				$theplus_options['check_elements']= array('tp_accordion','tp_adv_text_block','tp_advanced_typography','tp_shape_divider','tp_advertisement_banner','tp_animated_service_boxes','tp_before_after','tp_blog_listout','tp_button','tp_carousel_anything','tp_cascading_image','tp_circle_menu','tp_clients_listout','tp_contact_form_7','tp_countdown','tp_flip_box','tp_gallery_listout','tp_google_map','tp_heading_title','tp_image_factory','tp_info_box','tp_mailchimp','tp_morphing_layouts','tp_navigation_menu','tp_number_counter','tp_off_canvas','tp_pricing_table','tp_progress_bar','tp_row_background','tp_scroll_navigation','tp_social_icon','tp_style_list','tp_switcher','tp_smooth_scroll','tp_tabs_tours');
				
				$deprecated = null;
				$autoload = 'no';
				add_option( 'theplus_options',$theplus_options, $deprecated, $autoload );
				add_option( $option_name,$value, $deprecated, $autoload );
			}
		}
		if( !class_exists( 'Theplus_SL_Plugin_Updater' ) && THEPLUS_TYPE=='store') {
			include( THEPLUS_PATH . 'includes/Theplus_SL_Plugin_Updater.php' );
		}
		
		require_once THEPLUS_INCLUDES_URL .'plus_addon.php';
		
		$megamenu=theplus_get_option('general','check_elements');
		if(isset($megamenu) && !empty($megamenu) && in_array("tp_navigation_menu", $megamenu) ){
			include THEPLUS_INCLUDES_URL . 'custom-nav-item/menu-item-custom-fields.php';
			include THEPLUS_INCLUDES_URL . 'custom-nav-item/plus-navigation-fields.php';
		}
		if ( file_exists(THEPLUS_INCLUDES_URL . 'plus-options/metabox/init.php' ) ) {
			require_once THEPLUS_INCLUDES_URL.'plus-options/includes.php';
		}
		require_once THEPLUS_INCLUDES_URL .'template-api.php';
		require THEPLUS_INCLUDES_URL.'theplus_options.php';
			
		require THEPLUS_PATH.'modules/theplus-integration.php';
		require THEPLUS_PATH.'modules/query-control/module.php';
		
		require THEPLUS_PATH.'modules/mobile_detect.php';
		require_once THEPLUS_PATH .'modules/helper-function.php';
		
		
		if(is_admin()){
			if( empty( get_option( 'theplus-notice-dismissed' ) ) ) {
				add_action( 'admin_notices',array($this, 'thepluskey_verify_notify'));
			}
		}
	}
	
	/**
	* Widget Include required files
	*
	*/
	public function include_widgets()
	{			
		require_once THEPLUS_PATH.'modules/theplus-include-widgets.php';		
	}
	
	public function theplus_editor_styles() {
		wp_enqueue_style( 'theplus-ele-admin', THEPLUS_ASSETS_URL .'css/admin/theplus-ele-admin.css', array(),THEPLUS_VERSION,false );
	}
	public function theplus_elementor_admin_css() {  
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_style( 'theplus-ele-admin', THEPLUS_ASSETS_URL .'css/admin/theplus-ele-admin.css', array(),THEPLUS_VERSION,false );
		wp_enqueue_script( 'theplus-admin-js', THEPLUS_ASSETS_URL .'js/admin/theplus-admin.js', array(),THEPLUS_VERSION,false );
		//echo '<script> var theplus_ajax_url = "'.admin_url("admin-ajax.php").'";
			//var theplus_nonce = "'.wp_create_nonce("theplus-addons").'";</script>';
		wp_localize_script(
			'theplus-admin-js', 'theplus_ajax_url', admin_url("admin-ajax.php")
		);
		wp_localize_script(
			'theplus-admin-js', 'theplus_nonce', wp_create_nonce("theplus-addons")
		);
	}
	function theplus_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		return $mimes;
	}
	
	
	/**
	 * Print style.
	 *
	 * Adds custom CSS to the HEAD html tag. The CSS that emphasise the maintenance
	 * mode with red colors.
	 *
	 * Fired by `admin_head` and `wp_head` filters.
	 *
	 * @since 2.1.0
	 */
	public function print_style() {
		?>
		<style>*:not(.elementor-editor-active) .plus-conditions--hidden {
				  display: none;
				}</style>
		<?php
	}
	
	/*
	 * Admin notice text
	 */
	public function thepluskey_verify_notify(){
		$verify_api=1;
		if($verify_api!=1){
			echo '<div class="plus-key-notify notice notice-info is-dismissible">';
				echo '<h3>'.esc_html('Activation Required.', 'theplus' ) .'</h3>';
				echo '<p>'. esc_html__( '🤝 Thanks for Installation,', 'theplus' ) .' ';
				echo '<b>'. esc_html__( 'You are just one step away to supercharge your Elementor Page Builder with The Plus Addons.', 'theplus' ) .'</b>';
				echo ' <a href="'.admin_url('admin.php?page=theplus_purchase_code').'">'. esc_html__( 'Click Here to activate.', 'theplus' ) .'</a></p>';
			echo '</div>';
		}
	}
	
	public function add_elementor_category() {
			
		$elementor = \Elementor\Plugin::$instance;
		
		//Add elementor category
		$elementor->elements_manager->add_category('plus-essential', 
			[
				'title' => esc_html__( 'PlusEssential', 'theplus' ),
				'icon' => 'fa fa-plug',
			],
			1
		);
		$elementor->elements_manager->add_category('plus-listing', 
			[
				'title' => esc_html__( 'PlusListing', 'theplus' ),
				'icon' => 'fa fa-plug',
			],
			1
		);
		$elementor->elements_manager->add_category('plus-creatives', 
			[
				'title' => esc_html__( 'PlusCreatives', 'theplus' ),
				'icon' => 'fa fa-plug',
			],
			1
		);
		$elementor->elements_manager->add_category('plus-tabbed', 
			[
				'title' => esc_html__( 'PlusTabbed', 'theplus' ),
				'icon' => 'fa fa-plug',
			],
			1
		);
		$elementor->elements_manager->add_category('plus-adapted', 
			[
				'title' => esc_html__( 'PlusAdapted', 'theplus' ),
				'icon' => 'fa fa-plug',
			],
			1
		);
		$elementor->elements_manager->add_category('plus-header', 
			[
				'title' => esc_html__( 'PlusHeader', 'theplus' ),
				'icon' => 'fa fa-plug',
			],
			1
		);
		
	}
	
	public function theplus_load_template( $single_template ) {
		
		global $post;

		if ( 'plus-mega-menu' == $post->post_type) {

			$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

			if ( file_exists( $elementor_2_0_canvas ) ) {
				return $elementor_2_0_canvas;
			} else {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}

		return $single_template;
	}
	
	function theplus_settings_links ( $links ) {
		$setting_link = array(
				'<a href="' . admin_url( 'admin.php?page=theplus_options' ) . '">'.esc_html__("Settings","theplus").'</a>',
			);
		return array_merge( $links, $setting_link );
	
	}
	
	
	private function hooks() {
		$theplus_options=get_option('theplus_options');
		$plus_extras=theplus_get_option('general','extras_elements');
		
		if((isset($plus_extras) && empty($plus_extras) && empty($theplus_options)) || (!empty($plus_extras) && in_array('plus_display_rules',$plus_extras))){
			add_action( 'wp_head', [ $this, 'print_style' ] );
		}
		add_action( 'elementor/init', [ $this, 'add_elementor_category' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'theplus_editor_styles' ] );
		
		add_filter('upload_mimes', array( $this,'theplus_mime_types'));
		// Include some backend files
		add_action( 'admin_enqueue_scripts', [ $this,'theplus_elementor_admin_css'] );
		add_filter( 'plugin_action_links_' . THEPLUS_PBNAME ,[ $this, 'theplus_settings_links'] );
		add_filter( 'single_template', [ $this, 'theplus_load_template' ] );
		
		
	}
	
	public static function nav_item_load() {
		add_filter( 'wp_edit_nav_menu_walker', array( __CLASS__, 'plus_filter_walker' ), 99 );
	}
		
	/**
	 * ThePlus_Load constructor.
	 */
	private function __construct() {
		
		// Register class automatically
		$this->includes();
		// Finally hooked up all things
		$this->hooks();		
		theplus_elements_integration()->init();
		$this->include_widgets();		
		theplus_widgets_include();
		
	}
}

function theplus_addon_load()
{
	return Theplus_Element_Load::instance();
}
// Get theplus_addon_load Running
theplus_addon_load();