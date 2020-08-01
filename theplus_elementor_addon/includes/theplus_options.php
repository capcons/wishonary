<?php	
use Elementor\Plugin;
if (!defined('ABSPATH')) {
    exit;
}

class Theplus_Elementor_Plugin_Options
{
    
    /**
     * Option key, and option page slug
     * @var string
     */
    private $key = 'theplus_options';
    
    /**
     * Array of metaboxes/fields
     * @var array
     */
    protected $option_metabox = array();
    
    /**
     * Options Page title
     * @var string
     */
    protected $title = '';
    
    /**
     * Options Page hook
     * @var string
     */
    protected $options_page = '';
    protected $options_pages = array();
    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct()
    {
        // Set our title
		add_action( 'admin_enqueue_scripts', array( $this,'theplus_options_scripts') );		
		add_action( 'admin_post_theplus_api_key_deactive', array( $this,'theplus_key_api_form_de_action') );
		add_action( 'admin_post_theplus_api_key_active', array( $this,'theplus_key_api_form_ac_action') );
        $this->title = esc_html__('ThePlus Settings', 'theplus');
		add_action( 'admin_head', [ $this, 'plus_icon_logo' ] );
        require_once THEPLUS_INCLUDES_URL.'plus-options/cmb2-conditionals.php';
        // Set our CMB fields
        $this->fields = array(
        );
    }
    
	public function theplus_key_api_form_ac_action() {
		$action_page = 'theplus_purchase_code';
		
		if(isset($_POST["submit-key"]) && !empty($_POST["submit-key"]) && $_POST["submit-key"]=='Activate'){
			
			if ( ! isset( $_POST['nonce_theplus_purchase_field'] ) || ! wp_verify_nonce( $_POST['nonce_theplus_purchase_field'], 'nonce_theplus_purchase_action' ) ) {
			   wp_redirect(admin_url('admin.php?page='.$action_page));
			} else {
				if (FALSE === get_option($action_page)){
					$default_value = array('tp_api_key' => 'B5E0B5F8DD8689E6ACA49DD6E6E1A930');
					//$default_value = serialize($default_value);
					add_option($action_page,$default_value);
					
					wp_redirect(admin_url('admin.php?page='.$action_page));
				}else{
					
						$update_value = array('tp_api_key' => $_POST['tp_api_key']);
						//$update_value = serialize($update_value);
						update_option( $action_page, $update_value );
						theplus_get_api_check();
						wp_redirect(admin_url('admin.php?page='.$action_page));
					
				}
			}
		}else{
			wp_redirect(admin_url('admin.php?page='.$action_page));
		}
		
	}
	
	public function theplus_key_api_form_de_action() {
		$action_page = 'theplus_purchase_code';
		if(isset($_POST["submit-key"]) && !empty($_POST["submit-key"]) && $_POST["submit-key"]=='Deactivate'){
			
			if ( ! isset( $_POST['nonce_theplus_purchase_field'] ) || ! wp_verify_nonce( $_POST['nonce_theplus_purchase_field'], 'nonce_theplus_purchase_action' ) ) {
			   wp_redirect(admin_url('admin.php?page='.$action_page));
			} else {
				if ( FALSE === get_option($action_page) ){
					$default_value = array('tp_api_key' => 'B5E0B5F8DD8689E6ACA49DD6E6E1A930');
					//$default_value = serialize($default_value);
					add_option($action_page,$default_value);
					wp_redirect(admin_url('admin.php?page=theplus_purchase_code'));
				}else{
					$default_value = array('tp_api_key' => 'B5E0B5F8DD8689E6ACA49DD6E6E1A930');
					//$update_value = serialize($update_value);
					update_option( $action_page, $update_value );
					wp_redirect(admin_url('admin.php?page=theplus_purchase_code'));
				}
			}
		}else{
			wp_redirect(admin_url('admin.php?page=theplus_purchase_code'));
		}
	}
    /**
     * Initiate our hooks
     * @since 1.0.0
     */
	public function theplus_options_scripts() {
		wp_enqueue_script( 'cmb2-conditionals', THEPLUS_URL .'includes/plus-options/cmb2-conditionals.js', array() );
		wp_enqueue_script('thickbox', null, array('jquery'));
		wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
	}

    public function hooks()
    {
        add_action('admin_init', array(
            $this,
            'init'
        ));
        add_action('admin_menu', array(
            $this,
            'add_options_page'
        ));
    }
    
    /**
     * Register our setting to WP
     * @since  1.0.0
     */
    public function init()
    {
        //register_setting( $this->key, $this->key );
        $option_tabs = self::option_fields();
        foreach ($option_tabs as $index => $option_tab) {
            register_setting($option_tab['id'], $option_tab['id']);
        }
    }
    
    /**
     * Add menu options page
     * @since 1.0.0
     */
    public function add_options_page()
    {
		$verify_api=theplus_check_api_status();
        $option_tabs = self::option_fields($verify_api);
		$plugin_name = theplus_white_label_option('tp_plugin_name');
		if(isset($plugin_name) && !empty($plugin_name)){
			$this->title = $plugin_name;
		}
		
        foreach ($option_tabs as $index => $option_tab) {
            if ($index == 0) {
                $this->options_pages[] = add_menu_page($this->title, $this->title, 'manage_options', $option_tab['id'], array(
                    $this,
                    'admin_page_display'
                ),'dashicons-plus-settings');
				
					add_submenu_page($option_tabs[0]['id'], $this->title, $option_tab['title'], 'manage_options', $option_tab['id'], array(
						$this,
						'admin_page_display'
					));
				
            } else {			
				if(isset($option_tabs) && $option_tab['id'] != "theplus_white_label" && $option_tab['id'] != "theplus_purchase_code"){
					$this->options_pages[] = add_submenu_page($option_tabs[0]['id'], $this->title, $option_tab['title'], 'manage_options', $option_tab['id'], array(
						$this,
						'admin_page_display'
					));
				}else{
					$label_options=get_option( 'theplus_white_label' );	
					if( (empty($label_options['tp_hidden_label']) || $label_options['tp_hidden_label']!='on') && ($option_tab['id'] == "theplus_white_label" || $option_tab['id'] == "theplus_purchase_code")){
						$this->options_pages[] = add_submenu_page($option_tabs[0]['id'], $this->title, $option_tab['title'], 'manage_options', $option_tab['id'], array(
							$this,
							'admin_page_display'
						));
					}
				}
				
            }
        }
    }
	public function plus_icon_logo(){
		$plus_logo = theplus_white_label_option('tp_plus_logo');
		if(!empty($plus_logo)){
			?>
		<style>.wp-menu-image.dashicons-before.dashicons-plus-settings{background: url(<?php echo esc_url($plus_logo); ?>);background-size: 22px;background-repeat: no-repeat;background-position: center;}.theplus-current-version.wp-badge{background: url(<?php echo esc_url($plus_logo); ?>) center 25px no-repeat;background-size: 35px;background-position: center 30px;}</style>
	<?php }
	}
    
    /**
     * 
     * @since  1.0.0
     */
    public function admin_page_display()
    {
		$verify_api=theplus_check_api_status();
        $option_tabs = self::option_fields($verify_api);	
        $tab_forms   = array();
?>

		<div class="<?php  echo $this->key; ?>">
		<div id="ptplus-banner-wrap">
			<div id="ptplus-banner" class="ptplus-banner-sticky">
				<h2><?php echo $this->title; ?><!--<span><img src="<?php echo THEPLUS_URL .'vc_elements/images/thepluslogo.png'; ?>"></span>--></h2>
				<div class="theplus-current-version wp-badge"> <?php echo esc_html__('Version','theplus'); ?> <?php echo THEPLUS_VERSION; ?></div>
			</div>
		</div>
		<h2 class="nav-tab-wrapper">
            	<?php
	        foreach ($option_tabs as $option_tab):
	            $tab_slug  = $option_tab['id'];
	            $nav_class = 'nav-tab';
	            if ($tab_slug == $_GET['page']) {
	                $nav_class .= ' nav-tab-active'; //add active class to current tab
	                $tab_forms[] = $option_tab; //add current tab to forms to be rendered
	            } ?>
				<?php 
				$label_options=get_option( 'theplus_white_label' );	
				if( (empty($label_options['tp_hidden_label']) || $label_options['tp_hidden_label']!='on') && ($tab_slug == "theplus_white_label" || $tab_slug == "theplus_purchase_code")){ ?>
						<a class="<?php echo $nav_class; ?>" href="<?php  menu_page_url($tab_slug); ?>"><?php echo esc_html($option_tab['title']); ?></a>
				<?php }else if($tab_slug != "theplus_white_label" && $tab_slug != "theplus_purchase_code"){ ?>
					<a class="<?php echo $nav_class; ?>" href="<?php  menu_page_url($tab_slug); ?>"><?php echo esc_html($option_tab['title']); ?></a>
				<?php } ?>
           	<?php endforeach; ?>
        </h2>
		<?php foreach ($tab_forms as $tab_form): ?>
		
				<?php if($verify_api!=1){ ?>
					<input type="hidden" name="theplus_verified_api" id="theplus_verified_api" value="<?php echo esc_attr($verify_api); ?>" />
				<?php } ?>
				<?php if($tab_form['id']=='post_type_options'){ ?>
					<div class="post_type_options_btn_link">	
						<ul class="post_type_options_btn_link_list">
							<li><a href="#client_p_t"><?php echo esc_html__('Clients','theplus'); ?></a></li>
							<li><a href="#testimonial_p_t" ><?php echo esc_html__('Testimonial','theplus'); ?></a></li>
							<li><a href="#team_member_p_t" ><?php echo esc_html__('Team Member','theplus'); ?></a></li>
						</ul>	
					</div>				
				<?php } ?>
				<?php if($tab_form['id']=='theplus_purchase_code'){ ?>
					<div class="tp_active_mainwrapp">
						<div class="theplus_about-tab changelog" style="padding-bottom: 0;">
						<?php if(THEPLUS_TYPE=='code'){ ?>
							<div class="feature-section">
								<h4 style="padding-left:15px;"><?php echo esc_html__('Verify your plugin in 4 easy steps : Read below or ','theplus');?><?php echo '<a href="https://youtu.be/X-9CxBP6nJY" target="_blank">Watch Our Video Tutorial</a>' ?></h4>					
								<p style="padding-left:15px;"><?php echo esc_html__('1. Visit this ','theplus'); ?><?php echo '<i><a href="https://store.theplusaddons.com/theplus-verify" target="_blank">Verification URL</a></i>, Where you need to enter your "Envato Purchase Code" and press "Submit" button.</br>  <b> Note</b> : How to get purchase code : visit this <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">URL</a> or check <a href="https://www.youtube.com/watch?v=UsoNThFMHv8" target="_blank"> Video</a>'; ?></p>
								<p style="padding-left:15px;"><?php echo esc_html__('2. Add Your Website URL in the form with your email address.','theplus'); ?> </br><?php echo '<b>Important</b> : Website URL must be Home URL. You can get that by going Settings -> General -> WordPress Address (URL) and copy URL from there.'; ?></p>
								<p style="padding-left:15px;"><?php echo esc_html__('3. You will get "The Plus Unique Key" after submitting your details. Now Copy that key.','theplus'); ?></p>
								<p style="padding-left:15px;"><?php echo esc_html__('4.Enter Your "The Plus Unique key" at Verification Area and Press "Save" Button. Your Plugin is now verified to use all functionalities.','theplus'); ?></p>
								
							</div>							
						<?php } ?>
						<?php if(THEPLUS_TYPE=='store'){ ?>
							<div class="feature-section">
								<h4 style="padding-left:15px;"><?php echo esc_html__('Verify your plugin in 4 easy steps :','theplus');?></h4>					
								<p style="padding-left:15px;"><?php echo esc_html__('1. Visit your ','theplus'); ?><?php echo '<i><a href="https://store.theplusaddons.com/checkout/purchase-history/" target="_blank">Purchase History</a></i>'; ?></p>
								<p style="padding-left:15px;"><?php echo esc_html__('2. In the Page of "Purchase History" Go to View Licenses -> Manage Sites.','theplus'); ?></p>
								<p style="padding-left:15px;"><?php echo esc_html__('3. Add Your Home URL in the form and press "Add Site". Important : Website URL must be Home URL. You can get that by going Settings -> General -> WordPress Address (URL) and copy URL from there.','theplus'); ?></p>
								<p style="padding-left:15px;"><?php echo esc_html__('4. Now Your License Key will be activated for your Entered Website URL. Use that License key to activate your plugin.','theplus'); ?></p>
								
							</div>
						<?php } ?>
					</div>
					
				<?PHP } ?>
				
				<?php if($tab_form['id']!='theplus_import_data' && $tab_form['id']!='theplus_purchase_code'){ ?>
					<div id="<?php echo esc_attr($tab_form['id']); ?>" class="group theplus_form_content">
						<?php cmb2_metabox_form($tab_form, $tab_form['id']); ?>
					</div>
				<?php } ?>
				
				<?php if($tab_form['id']=='theplus_purchase_code'){
					$purchase_option=get_option( 'theplus_purchase_code' );
					$plus_key =$plus_last_key_char='';
					$plus_key = 'B5E0B5F8DD8689E6ACA49DD6E6E1A930';
					$plus_last_key_char = substr($plus_key, -4);
					?>
					<div id="theplus_purchase_code" class="group theplus_form_content">
					<form class="cmb-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" id="theplus_purchase_code" enctype="multipart/form-data" encoding="multipart/form-data">
						<?php wp_nonce_field( 'nonce_theplus_purchase_action', 'nonce_theplus_purchase_field' ); ?>
						<div class="cmb2-wrap form-table">
							<div id="cmb2-metabox-theplus_purchase_code" class="cmb2-metabox cmb-field-list">
								<div class="cmb-row cmb-type-text cmb2-id-tp-api-key table-layout" data-fieldtype="text">
									<div class="cmb-th">
										<label for="tp_api_key"><?php echo esc_html__("ThePlus Key",'theplus'); ?></label>
									</div>
									<div class="cmb-td">
										
											<input type="text" class="regular-text plus-deactivate-key" name="tp_api_key_de" id="tp_api_key" value="**** **** **** **** <?php echo $plus_last_key_char; ?>" placeholder="<?php echo esc_html__("Enter your Key","theplus"); ?>" readonly disabled>
											<input type="hidden" name="action" value="theplus_api_key_deactive">
										
									</div>
								</div>
							</div>
						</div>
						<?php if($verify_api==1 && !empty($plus_key)){ ?>
							<input type="submit" name="submit-key" value="<?php echo esc_html__("Deactivate","theplus"); ?>" class="button-primary deactivate-plus">
						<?php }else{ ?>
							<input type="submit" name="submit-key" value="<?php echo esc_html__("Activate","theplus"); ?>" class="button-primary">
						<?php } ?>
					</form>
					</div>
					<?php echo theplus_message_display(); ?>
				<?php } ?>
				<?php if($tab_form['id']=='theplus_purchase_code'){ ?>
					</div>
					<div class="tp_active_right_sidebar">
						<div class="tp_active_right_sidebar_wrapper">
							<ul class="tp_active_right_sidebar_list">
								<li>
									<a href="https://store.theplusaddons.com/checkout/purchase-history/" target="_blank">
									<div class="sidebar_icon"><span class="dashicons dashicons-admin-users"></span></div>
									<div class="sidebar_title"><?php echo esc_html__('Manage Account','theplus'); ?></div>
									</a>	
								</li>
								<li>
									<a href="https://posimyth.ticksy.com/" target="_blank">
									<div class="sidebar_icon"><span class="dashicons dashicons-sos"></span></div>
									<div class="sidebar_title"><?php echo esc_html__('Support Center','theplus'); ?></div>
									</a>	
								</li>
								<li>
									<a href="https://elementor.theplusaddons.com/documentation/" target="_blank">
									<div class="sidebar_icon"><span class="dashicons dashicons-media-document"></span></div>
									<div class="sidebar_title"><?php echo esc_html__('Documentation','theplus'); ?></div>
									</a>	
								</li>
								<li>
									<a href="https://www.youtube.com/playlist?list=PLFRO-irWzXaLK9H5opSt88xueTnRhqvO5" target="_blank">
									<div class="sidebar_icon"><span class="dashicons dashicons-format-video"></span></div>
									<div class="sidebar_title"><?php echo esc_html__('Video Tutorials','theplus'); ?></div>
									</a>	
								</li>
								<li>
									<a href="https://www.facebook.com/groups/theplus4elementor/" target="_blank">
									<div class="sidebar_icon"><span class="dashicons dashicons-facebook-alt"></span></div>
									<div class="sidebar_title"><?php echo esc_html__('Facebook Community','theplus'); ?></div>
									</a>	
								</li>
								<li>
									<a href="https://elementor.theplusaddons.com/changelog/" target="_blank">
									<div class="sidebar_icon"><span class="dashicons dashicons-welcome-write-blog"></span></div>
									<div class="sidebar_title"><?php echo esc_html__('Changelog','theplus'); ?></div>
									</a>	
								</li>
								<li>
									<a href="https://elementor.theplusaddons.com/#tpf-footer" target="_blank">
									<div class="sidebar_icon"><span class="dashicons dashicons-share-alt"></span></div>
									<div class="sidebar_title"><?php echo esc_html__('Subscribe Us','theplus'); ?></div>
									</a>	
								</li>
								<li>
									<a href="https://elementor.theplusaddons.com/client-feedback-and-suggestions/" target="_blank">
									<div class="sidebar_icon"><span class="dashicons dashicons-editor-help"></span></div>
									<div class="sidebar_title"><?php echo esc_html__('Suggestions','theplus'); ?></div>
									</a>	
								</li>
							</ul>				
						</div>
					</div>	
				<?php } ?>
				
				<?php if($tab_form['id']=='theplus_import_data'){
					wp_enqueue_script( 'jquery-masonry');
					$ajax = Plugin::$instance->common->get_component( 'ajax' );
				?>
				<div class="theplus_about-tab changelog">
					<div class="feature-section">
						<?php if(!empty($verify_api) && $verify_api==1){ ?>
						<div id="pt-plus-import-form">
							<div class="plus-template-main-category">
								<div class="theplus-import-template-library">
									<img src="<?php echo THEPLUS_ASSETS_URL; ?>/images/template-import.png"><?php echo esc_html__("Import","theplus"); ?>
								</div>
								<ul class="plus-main-category-list">
									<li class="active-open"><div class="plus-templates-tab" data-listing="special-blocks"><?php echo esc_html__("Special Blocks","theplus"); ?></div></li>
									<li><div class="plus-templates-tab" data-listing="plus-templates"><?php echo esc_html__("Plus Templates","theplus"); ?></div></li>
									<li><div class="plus-templates-tab" data-listing="plus-widgets"><?php echo esc_html__("Plus Widgets","theplus"); ?></div></li>
									<li><div class="plus-templates-tab" data-listing="plus-listing"><?php echo esc_html__("Plus Listing","theplus"); ?></div></li>							
								</ul>
								
								<div class="plus-import-listing-widgets">
									<div id="listing-special-blocks" class="widgets-listing-content active">
										<img src="<?php echo THEPLUS_ASSETS_URL; ?>/images/ajax-loader.gif" class="templates-loading" />
									</div>
									<div id="listing-plus-templates" class="widgets-listing-content">
										<img src="<?php echo THEPLUS_ASSETS_URL; ?>/images/ajax-loader.gif" class="templates-loading" />
									</div>
									<div id="listing-plus-widgets" class="widgets-listing-content">
										<img src="<?php echo THEPLUS_ASSETS_URL; ?>/images/ajax-loader.gif" class="templates-loading" />
									</div>
									<div id="listing-plus-listing" class="widgets-listing-content">
										<img src="<?php echo THEPLUS_ASSETS_URL; ?>/images/ajax-loader.gif" class="templates-loading" />
									</div>									
								</div>
							</div>
							
							<div id="elementor-import-template-area" class="theplus-import-template-library-form hidden">
								<form id="elementor-import-template-form" method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" enctype="multipart/form-data">
									<input type="hidden" name="action" value="elementor_library_direct_actions">
									<input type="hidden" name="library_action" value="direct_import_template">
									<input type="hidden" name="_nonce" value="<?php echo $ajax->create_nonce(); ?>">
									<h3><?php echo esc_html__("Import Designs (.Json)","theplus"); ?></h3>
									<fieldset id="elementor-import-template-form-inputs">
										<input type="file" name="file" accept=".json,application/json,.zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed" required>
										<input type="submit" class="button" value="<?php echo esc_attr__( 'Import Now', 'theplus' ); ?>">
									</fieldset>
								</form>
							</div>
									
						</div>
						<?php }else{ ?>
							<div class="pt-plus-page-form text-center">
								<div class="plus-notice-varified">
									<img src="<?php echo THEPLUS_ASSETS_URL; ?>/images/verify-plugin-note.png" />
									<div class="plus-notice-block-content">
										<div class="plus-notice-importance-title"><?php echo esc_html__('Important Notice','theplus'); ?></div>
										<div class="plus-notice-importance-desc-title"><?php echo '<a href="admin.php?page=theplus_purchase_code">'.esc_html__("Verify","theplus").'</a>'; ?><?php echo esc_html__(' your plugin and get access of all functionalities. Go to Verify section of settings to proceed further.','theplus'); ?></div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>	
				<?php } ?>
            	<?php  endforeach; ?>
		</div>
		<?php
		
		$current_screen = get_current_screen();
		$hidden_label = theplus_white_label_option('tp_hidden_label');
		if( !empty($hidden_label) && $hidden_label=='on' ){
		
			if( is_admin() && !empty($current_screen) && ($current_screen->id === "theplus-settings_page_theplus_white_label" || $current_screen->id === "theplus-settings_page_theplus_purchase_code")) {
				wp_redirect( admin_url( 'admin.php?page=theplus_options' ) );
				exit;
			}
			echo '<style>#theplus_white_label{display:none;}</style>';
		}
    }
    
    /**
     * Defines the theme option metabox and field configuration
     * @since  1.0.0
     * @return array
     */
    public function option_fields($verify_api='')
    {
		
        // Only need to initiate the array once per page-load
        if (!empty($this->option_metabox)) {
            return $this->option_metabox;
        }
		
        $this->option_metabox[] = array(
            'id' => 'theplus_options',
            'title' => 'Plus Widgets',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_options'
                )
            ),
            'show_names' => true,
            'fields' => array(
				array(
	                'name' => esc_html__('Plus Widgets', 'theplus'),
	                'desc' => esc_html__('Use above option to hide/unhide widgets. If you want to use just few widgets, We suggest to uncheck rest, which will help you to improve performance of website.', 'theplus'),
	                'id' => 'check_elements',
	                'type' => 'multicheck',
					'default' => '',
	                'options' => array(
	                    'tp_accordion' => esc_html__('Accordion', 'theplus'),
	                    'tp_adv_text_block' => esc_html__('TP Text Block', 'theplus'),
	                    'tp_advanced_typography' => esc_html__('Advanced Typography', 'theplus'),
						'tp_advanced_buttons' => esc_html__('Advanced Buttons', 'theplus'),
						'tp_shape_divider' => esc_html__('Advanced Separators', 'theplus'),
						'tp_advertisement_banner' => esc_html__('Advertisement Banner', 'theplus'),
						'tp_animated_service_boxes' => esc_html__('Animated Service Boxes', 'theplus'),
						'tp_audio_player' => esc_html__('Audio Player', 'theplus'),
	                    'tp_before_after' => esc_html__('Before After', 'theplus'),
	                    'tp_blockquote' => esc_html__('Blockquote', 'theplus'),
	                    'tp_blog_listout' => esc_html__('Blog Listing', 'theplus'),
	                    'tp_breadcrumbs_bar' => esc_html__('Breadcrumbs Bar', 'theplus'),
	                    'tp_button' => esc_html__('Button', 'theplus'),
						'tp_wp_bodymovin' => esc_html__('LottieFiles Animation', 'theplus'),
						'tp_caldera_forms' => esc_html__('Caldera Forms', 'theplus'),
						'tp_carousel_anything' => esc_html__('Carousel Anything', 'theplus'),
						'tp_carousel_remote' => esc_html__('Carousel Remote', 'theplus'),
	                    'tp_cascading_image' => esc_html__('Cascading Image', 'theplus'),
	                    'tp_circle_menu' => esc_html__('Circle Menu', 'theplus'),
	                    'tp_clients_listout' => esc_html__('Clients Listing', 'theplus'),
	                    'tp_contact_form_7' => esc_html__('Contact Form 7', 'theplus'),
	                    'tp_dynamic_listing' => esc_html__('Dynamic Listing', 'theplus'),
	                    'tp_countdown' => esc_html__('Count Down', 'theplus'),
	                    'tp_design_tool' => esc_html__('Design Tool', 'theplus'),
						'tp_dynamic_categories' => esc_html__('Dynamic Categories', 'theplus'),
	                    'tp_dynamic_device' => esc_html__('Dynamic Device', 'theplus'),
						'tp_dynamic_smart_showcase' => esc_html__('Dynamic Smart Showcase', 'theplus'),
	                    'tp_draw_svg' => esc_html__('Draw SVG', 'theplus'),
						'tp_everest_form' => esc_html__('Everest Form', 'theplus'),
	                    'tp_flip_box' => esc_html__('Flip Box', 'theplus'),
	                    'tp_gallery_listout' => esc_html__('Gallery Listing', 'theplus'),
	                    'tp_google_map' => esc_html__('Google Map', 'theplus'),
						'tp_gravity_form' => esc_html__('Gravity Form', 'theplus'),
	                    'tp_heading_animation' => esc_html__('Heading Animation', 'theplus'),
	                    'tp_header_extras' => esc_html__('Header Extras', 'theplus'),
						'tp_heading_title' => esc_html__('Heading Title', 'theplus'),
						'tp_hotspot' => esc_html__('Hotspot', 'theplus'),
	                    'tp_image_factory' => esc_html__('Creative Image', 'theplus'),
	                    'tp_info_box' => esc_html__('Info Box', 'theplus'),
						'tp_instagram' => esc_html__('Instagram', 'theplus'),
	                    'tp_mailchimp' => esc_html__('Mailchimp', 'theplus'),
						'tp_mobile_menu' => esc_html__('Mobile Menu', 'theplus'),
	                    'tp_morphing_layouts' => esc_html__('Morphing Layouts', 'theplus'),
						'tp_navigation_menu' => esc_html__('TP Navigation Menu', 'theplus'),
						'tp_ninja_form' => esc_html__('Ninja Form', 'theplus'),
	                    'tp_number_counter' => esc_html__('Number Counter', 'theplus'),
	                    'tp_off_canvas' => esc_html__('Off Canvas/Toggle', 'theplus'),
						'tp_page_scroll' => esc_html__('Page Scroll', 'theplus'),
						'tp_pricing_list' => esc_html__('Pricing List', 'theplus'),
	                    'tp_pricing_table' => esc_html__('Pricing Table', 'theplus'),
	                    'tp_product_listout' => esc_html__('Product Listing', 'theplus'),
						'tp_protected_content' => esc_html__('Protected Content', 'theplus'),
	                    'tp_post_search' => esc_html__('Post Search', 'theplus'),
	                    'tp_progress_bar' => esc_html__('Progress Bar', 'theplus'),
						'tp_process_steps' => esc_html__('Process Steps', 'theplus'),
						'tp_row_background' => esc_html__('Row Background', 'theplus'),
						'tp_scroll_navigation' => esc_html__('Scroll Navigation', 'theplus'),
						'tp_site_logo' => esc_html__('Site Logo', 'theplus'),
	                    'tp_social_icon' => esc_html__('Social Icon', 'theplus'),
	                    'tp_style_list' => esc_html__('Style List', 'theplus'),
	                    'tp_switcher' => esc_html__('Switcher', 'theplus'),
	                    'tp_smooth_scroll' => esc_html__('Smooth Scroll', 'theplus'),
						'tp_table' => esc_html__('Table', 'theplus'),
						'tp_tabs_tours' => esc_html__('Tabs/Tours', 'theplus'),
	                    'tp_team_member_listout' => esc_html__('Team Member Listing', 'theplus'),
	                    'tp_testimonial_listout' => esc_html__('Testimonial', 'theplus'),
	                    'tp_timeline' => esc_html__('Timeline', 'theplus'),
	                    'tp_unfold' => esc_html__('Unfold', 'theplus'),
	                    'tp_video_player' => esc_html__('Video Player', 'theplus'),						
						'tp_wp_forms' => esc_html__('WP Forms', 'theplus'),
						'tp_wp_login_register' => esc_html__('WP Login & Register', 'theplus'),
	                )
	            ),
				array(
	                'name' => esc_html__('Plus Extras', 'theplus'),
	                'desc' => esc_html__('Use above option to hide/unhide Sections/Columns Plus Extras Options. If you want to use just few Options, We suggest to uncheck rest, which will help you to improve performance of website.', 'theplus'),
	                'id' => 'extras_elements',
	                'type' => 'multicheck',
					'select_all_button' => true,
					'default' => '',
	                'options' => array(
	                    'section_scroll_animation' => esc_html__('Section Scroll Animation', 'theplus'),
	                    'section_custom_css' => esc_html__('Section Custom CSS', 'theplus'),
	                    'column_sticky' => esc_html__('Sticky Column', 'theplus'),
	                    'custom_width_column' => esc_html__('Custom/Media Width Column', 'theplus'),
	                    'order_sort_column' => esc_html__('Order AND Width Column', 'theplus'),
	                    'column_custom_css' => esc_html__('Column Custom CSS', 'theplus'),
	                    'column_mouse_cursor' => esc_html__('Column Mouse Cursor', 'theplus'),
	                    'plus_display_rules' => esc_html__('Display Rules', 'theplus'),
	                    'plus_event_tracker' => esc_html__('Event Tracker', 'theplus'),
	                    'plus_section_column_link' => esc_html__('Wrapper Link', 'theplus'),
	                    'plus_equal_height' => esc_html__('Equal Height', 'theplus'),
	                )
	            ),
				array(
					'id'   => 'tp_widgets_list_hidden',
					'type' => 'hidden',
					'default' => 'hidden',
				),
            )
        );
        
        $this->option_metabox[] = array(
            'id' => 'post_type_options',
            'title' => 'Plus Listing',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'post_type_options'
                )
            ),
            'show_names' => true,
            'fields' => array(				
				/* client option start */
				array(
					'name' => esc_html__('Clients Post Type Settings', 'theplus'),
					'desc' => '',
					'type' => 'title',
					'id' => 'client_post_title'
				),
				array(
						'name' => esc_html__('Select Post Type Type', 'theplus'),
						'desc' => '',
						'id' => 'client_post_type',
						'type' => 'select',
						'show_option_none' => true,
						'default' => 'disable',
						'options' => array(
							'disable' => esc_html__('Disable', 'theplus'),
							'plugin' => esc_html__('ThePlus Post Type', 'theplus'),
							'themes' => esc_html__('Prebuilt Theme Based', 'theplus'),
						)
				),
				array(
				'name' => esc_html__('Post Name : (Keep Blank if you want to keep default Name)', 'theplus'),
				'desc' => esc_html__('Enter value for clients custom post type name. Default: "theplus_clients"', 'theplus'),
				'default' => '',
				'id' => 'client_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'client_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Post Title : (Keep Blank if you want to keep default Title)', 'theplus'),
				'desc' => esc_html__('Enter value for clients custom post title name. Default: "Tp Clients"', 'theplus'),
				'default' => '',
				'id' => 'client_plugin_title',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'client_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Category Taxonomy Value : (Keep Blank if you want to keep default Name)', 'theplus'),
				'desc' => esc_html__('Enter value for Category Taxonomy Value. Default : "theplus_clients_cat" ', 'theplus'),
				'default' => '',
				'id' => 'client_category_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'client_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Post Name : (You can find that from here)', 'theplus'),
				'desc' => sprintf( __('Enter the value of your current post type name which is prebuilt with your theme. E.g.: "theplus_clients" <a href="%s" class="thickbox" title="Get the Post Name of Custom Post type as per above Screenshot.">Check screenshot</a> for how to get that value from URL of your current post type.', 'theplus'), THEPLUS_URL.'assets/images/post-type-screenshot.png' ),
				'default' => '',
				'id' => 'client_theme_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'client_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Category Taxonomy Value : (You can find that from here)', 'theplus'),
				'desc' => sprintf( __('Enter the value of your current Category Taxonomy Value which is prebuilt with your theme.  E.g. : "theplus_clients_cat" <a href="%s" class="thickbox" title="Get the Category Taxonomy Value as per above screenshot.">Check screenshot</a> for how to get that value from URL of your current taxonomy.', 'theplus'), THEPLUS_URL.'assets/images/taxonomy-screenshot.png'),
				'default' => '',
				'id' => 'client_category_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'client_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				/* client option start */
				/* testimonial option start */
				array(
					'name' => esc_html__('Testimonial Post Type Settings', 'theplus'),
					'desc' => '',
					'type' => 'title',
					'id' => 'testimonial_post_title'
				),
				array(
						'name' => esc_html__('Select Post type Type', 'theplus'),
						'desc' => '',
						'id' => 'testimonial_post_type',
						'type' => 'select',
						'show_option_none' => true,
						'default' => 'disable',
						'options' => array(
							'disable' => esc_html__('Disable', 'theplus'),
							'plugin' => esc_html__('ThePlus Post Type', 'theplus'),
							'themes' => esc_html__('Prebuilt Theme Based', 'theplus'),
						)
				),
				array(
				'name' => esc_html__('Post Name : (Keep Blank if you want to keep default Name)', 'theplus'),
				'desc' => esc_html__('Enter value for testimonial custom post type name. Default: "theplus_testimonial"', 'theplus'),
				'default' => '',
				'id' => 'testimonial_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'testimonial_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Post Title : (Keep Blank if you want to keep default Title)', 'theplus'),
				'desc' => esc_html__('Enter value for testimonial custom post title name. Default: "TP Testimonials"', 'theplus'),
				'default' => '',
				'id' => 'testimonial_plugin_title',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'testimonial_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Category Taxonomy Value : (Keep Blank if you want to keep default Name)', 'theplus'),
				'desc' => esc_html__('Enter value for Category Taxonomy Value. Default :"theplus_testimonial_cat"', 'theplus'),
				'default' => '',
				'id' => 'testimonial_category_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'testimonial_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Post Name : (You can find that from here)', 'theplus'),
				'desc' => sprintf( __('Enter the value of your current post type name which is prebuilt with your theme. E.g.: "theplus_testimonial" <a href="%s" class="thickbox" title="Get the Post Name of Custom Post type as per above Screenshot.">Check screenshot</a> for how to get that value from URL of your current post type.', 'theplus'), THEPLUS_URL.'assets/images/post-type-screenshot.png' ),
				'default' => '',
				'id' => 'testimonial_theme_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'testimonial_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Category Taxonomy Value : (You can find that from here)', 'theplus'),
				'desc' => sprintf( __('Enter the value of your current Category Taxonomy Value which is prebuilt with your theme.  E.g. : "theplus_testimonial_cat" <a href="%s" class="thickbox" title="Get the Category Taxonomy Value as per above screenshot.">Check screenshot</a> for how to get that value from URL of your current taxonomy.', 'theplus'), THEPLUS_URL.'assets/images/taxonomy-screenshot.png' ),
				'default' => '',
				'id' => 'testimonial_category_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'testimonial_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				/* testimonial option start */
				/* Team Member option start */
				array(
					'name' => esc_html__('Team Member Post Type Settings','theplus'),
					'desc' => '',
					'type' => 'title',
					'id' => 'team_member_post_title'
				),
				array(
						'name' => esc_html__('Select Team Member Post Type', 'theplus'),
						'desc' => '',
						'id' => 'team_member_post_type',
						'type' => 'select',
						'show_option_none' => true,
						'default' => 'disable',
						'options' => array(
							'disable' => esc_html__('Disable', 'theplus'),
							'plugin' => esc_html__('ThePlus Post Type', 'theplus'),
							'themes' => esc_html__('Prebuilt Theme Based', 'theplus'),
						)
				),
				array(
				'name' => esc_html__('Post Name : (Keep Blank if you want to keep default Name)', 'theplus'),
				'desc' => esc_html__('Enter value for team member custom post type name. Default: "theplus_team_member"', 'theplus'),
				'default' => '',
				'id' => 'team_member_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'team_member_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Post Title : (Keep Blank if you want to keep default Title)', 'theplus'),
				'desc' => esc_html__('Enter value for team member custom post type title. Default: "TP Team Members"', 'theplus'),
				'default' => '',
				'id' => 'team_member_plugin_title',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'team_member_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Category Taxonomy Value (Keep Blank if you want to keep default Name)', 'theplus'),
				'desc' => esc_html__('Enter value for Category Taxonomy Value. Default : "theplus_team_member_cat"', 'theplus'),
				'default' => '',
				'id' => 'team_member_category_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'team_member_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Post Name : (You can find that from here)', 'theplus'),
				'desc' => sprintf( __('Enter the value of your current post type name which is prebuilt with your theme. E.g.: "theplus_team_member" <a href="%s" class="thickbox" title="Get the Post Name of Custom Post type as per above Screenshot.">Check screenshot</a> for how to get that value from URL of your current post type.', 'theplus'), THEPLUS_URL.'assets/images/post-type-screenshot.png' ),
				'default' => '',
				'id' => 'team_member_theme_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'team_member_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Category Taxonomy Value (You can find that from here)', 'theplus'),
				'desc' => sprintf( __('Enter the value of your current Category Taxonomy Value which is prebuilt with your theme.  E.g. : "theplus_team_member_cat" <a href="%s" class="thickbox" title="Get the Category Taxonomy Value as per above screenshot.">Check screenshot</a> for how to get that value from URL of your current taxonomy.', 'theplus'), THEPLUS_URL.'assets/images/taxonomy-screenshot.png' ),
				'default' => '',
				'id' => 'team_member_category_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'team_member_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				/* Team Member option start */
            )
        );
		$this->option_metabox[] = array(
            'id' => 'theplus_import_data',
            'title' => 'Plus Designs',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_import_data'
                )
            ),
            'show_names' => true,
        );
		$this->option_metabox[] = array(
            'id' => 'theplus_api_connection_data',
            'title' => 'Extra Options',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_api_connection_data'
                )
            ),
            'show_names' => true,
            'fields' => array(
				 array(
	                'name' => esc_html__('Site Key reCAPTCHA v3', 'theplus'),
	                'desc' => sprintf(__('Note: <a href="https://www.google.com/recaptcha/intro/v3.html" target="_blank">reCAPTCHA v3</a> is a free service by Google that protects your website from spam and abuse.', 'theplus')),
	                'default' => '',
	                'id' => 'theplus_site_key_recaptcha',
	                'type' => 'text',					
	            ),
				array(
	                'name' => esc_html__('Secret Key reCAPTCHA v3', 'theplus'),
	                'desc' => sprintf(__('Note: <a href="https://www.google.com/recaptcha/intro/v3.html" target="_blank">reCAPTCHA v3</a> is a free service by Google that protects your website from spam and abuse.', 'theplus')),
	                'default' => '',
	                'id' => 'theplus_secret_key_recaptcha',
	                'type' => 'text',					
	            ),
				array(
					'name' => esc_html__('Facebook App Id', 'theplus'),
					'desc' => sprintf(__('Note: Generate Facebook App Id using <a href="https://developers.facebook.com/apps" target="_blank">link</a>. This id will be used for your "Login with Facebook" feature in Login/Signup Widget.', 'theplus')),
					'default' => '',
					'id' => 'theplus_facebook_app_id',
					'type' => 'text',
				),
				array(
					'name' => esc_html__('Google Client Id', 'theplus'),
					'desc' => sprintf(__('Note: Generate Google Client Id using <a href="https://console.developers.google.com/" target="_blank">link</a>. This id will be used for your "Login with Google" feature in Login/Signup Widget.', 'theplus')),
					'default' => '',
					'id' => 'theplus_google_client_id',
					'type' => 'text',
				),
				array(
					'name' => esc_html__('Google Analytics (Tracking) Id', 'theplus'),
					'desc' => sprintf(__('<a href="https://support.google.com/analytics/answer/1008080?hl=en" target="_blank">Generate Tracking Id</a>. Note : Keep this field empty, If you have already added Tracking Script on Website. ', 'theplus')),
					'default' => '',
					'id' => 'theplus_google_analytics_id',
					'type' => 'text',
					'attributes'  => array(
						'placeholder' => esc_html__('e.g UA-000000-2', 'theplus'),
					),
				),
				array(
					'name' => esc_html__('Facebook Pixel Id', 'theplus'),
					'desc' => sprintf(__('<a href="https://www.facebook.com/business/help/952192354843755" target="_blank">Generate Facebook Pixel Id</a>. Note : Keep this field empty, If you have already added Tracking Script on Website.', 'theplus')),
					'default' => '',
					'id' => 'theplus_facebook_pixel_id',
					'type' => 'text',
					'attributes'  => array(
						'placeholder' => esc_html__('e.g 38736373773', 'theplus'),
					),
				),
				array(
						'name' => esc_html__('Iconsmind Font Functionality', 'theplus'),
						'desc' => esc_html__('NOTE : If you disable this, It will stop loading frontend and in the backend throughout the website.', 'theplus'),
						'id' => 'load_icons_mind',
						'type' => 'select',
						'show_option_none' => false,
						'default' => 'enable',
						'options' => array(
							'enable' => esc_html__('Enable', 'theplus'),
							'disable' => esc_html__('Disable', 'theplus'),
						),
				),
				array(
	                'name' => esc_html__('Iconsmind in Specific Page/Post', 'theplus'),
	                'desc' => esc_html__('NOTE : You can add Page/Post id with separated by comma to load this fonts on those specific posts or pages.', 'theplus'),
	                'default' => '',
	                'id' => 'load_icons_mind_ids',
	                'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'load_icons_mind',
						'data-conditional-value' => 'disable',
					),
	            ),
				array(
						'name' => esc_html__('Google Map API Key', 'theplus'),
						'desc' => esc_html__('NOTE : Turn Off this key If you theme already have google key option. So, It will not generate error in console for multiple google map keys.', 'theplus'),
						'id' => 'gmap_api_switch',
						'type' => 'select',
						'show_option_none' => false,
						'default' => 'enable',
						'options' => array(
							'none' => esc_html__('None', 'theplus'),
							'enable' => esc_html__('Show', 'theplus'),
							'disable' => esc_html__('Hide', 'theplus'),
						),
				),
	            array(
	                'name' => esc_html__('Google Map API Key', 'theplus'),
	                'desc' => sprintf(__('This field is required if you want to use Advance Google Map element. You can obtain your own Google Maps Key here: (<a href="https://developers.google.com/maps/documentation/javascript/get-api-key">Click Here</a>)', 'theplus')),
	                'default' => '',
	                'id' => 'theplus_google_map_api',
	                'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'gmap_api_switch',
						'data-conditional-value' => 'enable',
					),
	            ),
				array(
	                'name' => esc_html__('Mailchimp API Key', 'theplus'),
	                'desc' => esc_html__('Go to your Mailchimp > Account > Extras > API Keys then create a key and paste here', 'theplus'),
	                'default' => '',
	                'id' => 'theplus_mailchimp_api',
	                'type' => 'text',
	            ),
				array(
	                'name' => esc_html__('Mailchimp List ID', 'theplus'),
	                'desc' => esc_html__('Go to your Mailchimp > List > Settings > List name and default > Copy the list ID and paste here.', 'theplus'),
	                'default' => '',
	                'id' => 'theplus_mailchimp_id',
	                'type' => 'text',
	            ),
				array(
					'name' => esc_html__('Thumbnail options (Dynamic Categories)', 'theplus'),
					'desc' => esc_html__('If you enable this option, Thumbnail image option will be available under each custom post type, Which you can use for Dynamic Categories widget.', 'theplus'),
					'id'   => 'dynamic_category_thumb_check',
					'type' => 'checkbox',
				),
				array(
					'name' => esc_html__('Lottiefiles Backend JS', 'theplus'),
					'desc' => esc_html__('You can enable/disable backend JS of lottiefiles using above option. This is master option, So You have to enable this to make it work in elementor backend. You should keep it disable if your backend have any performance issue, Size of this JS is 246KB.', 'theplus'),
					'id'   => 'bodymovin_load_js_check',
					'type' => 'checkbox',
				),
				array(
						'name' => esc_html__('On Scroll View Animation Offset', 'theplus'),
						'desc' => esc_html__('Enter the value which will be used for offset of on scroll view animation. If you select 90, Then It will start taking effect from bottom\'s 10%. Default : 80 E.g. 90,85..etc.', 'theplus'),
						'id' => 'scroll_animation_offset',
						'type' => 'text',
						'attributes' => array(
							'type' => 'number',
							'pattern' => '\d*',
							'min'  => '30',
							'max'  => '120',							
						),
						'sanitization_cb' => 'absint',
						'escape_cb'       => 'absint',
				),
			),
        );
		$this->option_metabox[] = array(
            'id' => 'theplus_performance',
            'title' => 'Performance',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_performance'
                )
            ),
            'show_names' => true,
            'fields' => array(
				array(
						'name' => esc_html__('Smart Performance', 'theplus'),
						'desc' => '',
						'id' => 'plus_smart_performance',
						'type' => 'select',
						'show_option_none' => true,
						'default' => 'enable',
						'desc' => esc_html__( 'This is auto enabled functionality of The Plus Addons. In this functionality We use Unity method to combine all JS and CSS of page in two separate files for the best possible performance with less requests. All Cache stored at "SiteURL/wp-content/uploads/theplus-addons/".', 'theplus' ),
						'options' => array(							
							'enable' => esc_html__('Enable', 'theplus'),
							'disable' => esc_html__('Disable', 'theplus'),
						)
				),
			),
        );
		$this->option_metabox[] = array(
            'id' => 'theplus_styling_data',
            'title' => 'Custom',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_styling_data'
                )
            ),
            'show_names' => true,
            'fields' => array(				
				array( 
					'name' => esc_html__( 'Custom CSS', 'theplus' ),
					'desc' => esc_html__( 'Add Your Custom CSS Styles', 'theplus' ),
					'id' => 'theplus_custom_css_editor',
					'type' => 'textarea_code',
					'default' => '',
				),
				array( 
					'name' => esc_html__( 'Custom JS', 'theplus' ),
					'desc' => esc_html__( 'Add Your Custom JS Scripts', 'theplus' ),
					'id' => 'theplus_custom_js_editor',
					'type' => 'textarea_code',
					'default' => '',
				),
				array(
					'id'   => 'tp_styling_hidden',
					'type' => 'hidden',
					'default' => 'hidden',
				),
			),
        );
		$this->option_metabox[] = array(
            'id' => 'theplus_purchase_code',
            'title' => 'Activate',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_purchase_code'
                )
            ),
            'show_names' => true,
            /*'fields' => array(				
				array(
					'name' => esc_html__('ThePlus Key', 'theplus'),
					'desc' => '',
					'default' => '',
					'id' => 'tp_api_key',
					'type' => 'text',
					'attributes'  => array(
						'placeholder' => 'Enter Your key',
					),
				),
			),*/
        );
		
			$this->option_metabox[] = array(
				'id' => 'theplus_white_label',
				'title' => 'White Label',
				'show_on' => array(
					'key' => 'options-page',
					'value' => array(
						'theplus_white_label'
					)
				),
				'show_names' => true,
				'fields' => array(				
					array(
						'name' => esc_html__('Plugin Name', 'theplus'),
						'desc' => '',
						'default' => '',
						'id' => 'tp_plugin_name',
						'type' => 'text',
						'attributes'  => array(
							'placeholder' => esc_html__('Enter Plugin Name', 'theplus'),
						),
					),
					array(
						'name' => 'Plugin Description',
						'desc' => '',
						'default' => '',
						'id' => 'tp_plugin_desc',
						'type' => 'textarea_small',
						'attributes'  => array(
							'placeholder' => esc_html__('Enter Plugin Description', 'theplus'),
						),
					),
					array(
						'name' => esc_html__('Developer / Agency', 'theplus'),
						'desc' => '',
						'default' => '',
						'id' => 'tp_author_name',
						'type' => 'text',
						'attributes'  => array(
							'placeholder' => esc_html__('Enter Developer Name', 'theplus'),
						),
					),
					array(
						'name' => esc_html__('Website URL', 'theplus'),
						'desc' => '',
						'default' => '',
						'id' => 'tp_author_uri',
						'type' => 'text_url',
						'attributes'  => array(
							'placeholder' => esc_html__('Enter Website URL', 'theplus'),
						),
					),
					/*array(
						'name' => esc_html__('Admin Menu', 'theplus'),
						'desc' => '',
						'default' => '',
						'id' => 'tp_admin_name',
						'type' => 'text',
						'attributes'  => array(
							'placeholder' => esc_html__('Enter Admin Menu Setting Name', 'theplus'),
						),
					),*/
					array(
						'name'    => esc_html__('Plus Icon/Logo','theplus'),
						'desc'    => '',
						'id'      => 'tp_plus_logo',
						'type'    => 'file',
						'options' => array(
							'url' => false,
						),
						'query_args' => array(						
							 'type' => array(
								'image/gif',
								'image/jpeg',
								'image/png',
							 ),
						),
						'preview_size' => 'large',
					),
					array(
						'name' => '',
						'desc' => esc_html__('Important Note : If you will enable above two force disable option, Both tabs will be hidden for everyone. If you want to get those tabs back, You will need to deactivate plugin and activate again.','theplus'),
						'id'   => 'tp_hidden_label',
						'type' => 'checkbox',
					),
					array(
					'id'   => 'tp_white_label_hidden',
					'type' => 'hidden',
					'default' => 'hidden',
				),
				),
			);
        return $this->option_metabox;
    }
	
    public function get_option_key($field_id)
    {
        $option_tabs = $this->option_fields();
        foreach ($option_tabs as $option_tab) { //search all tabs
            foreach ($option_tab['fields'] as $field) { //search all fields
                if ($field['id'] == $field_id) {
                    return $option_tab['id'];
                }
            }
        }
        return $this->key; //return default key if field id not found
    }
    /**
     * Public getter method for retrieving protected/private variables
     * @since  1.0.0
     * @param  string  $field Field to retrieve
     * @return mixed          Field value or exception is thrown
     */
    public function __get($field)
    {
        
        // Allowed fields to retrieve
        if (in_array($field, array('key','fields','title','options_page'), true)) {
            return $this->{$field};
        }
        if ('option_metabox' === $field) {
            return $this->option_fields();
        }
        
        throw new Exception('Invalid property: ' . $field);
    }
    
}


// Get it started
$Theplus_Elementor_Plugin_Options = new Theplus_Elementor_Plugin_Options();
$Theplus_Elementor_Plugin_Options->hooks();

/**
 * Wrapper function around cmb_get_option
 * @since  1.0.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function theplus_ele_get_option($key = '')
{
    global $Theplus_Elementor_Plugin_Options;
    return cmb_get_option($Theplus_Elementor_Plugin_Options->key, $key);
}