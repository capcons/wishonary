<?php
/**
 * Plugin Name:     PressApps Video
 * Description:     Standalone Video Posts Plugin
 * Author:          PressApps
 * Version:         2.0.0
 * Plugin URI:      https://codecanyon.net/item/sortable-video-embed-wordpress-plugin/5610823
 * Author URI:      https://codecanyon.net/user/pressapps
 * Text Domain:     pressapps-knowledge-base
 * Domain Path:     /lang
 */

/* Return option page data */
$pavi_settings = get_option( 'pavi_settings' );
define( 'PAVI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PAVI_PLUGIN_URL', plugins_url("", __FILE__) );

define( 'PAVI_PLUGIN_INCLUDES_DIR', PAVI_PLUGIN_DIR . "/includes/" );
define( 'PAVI_PLUGIN_INCLUDES_URL', PAVI_PLUGIN_URL . "/includes/" );

define( 'PAVI_PLUGIN_ASSETS_DIR', PAVI_PLUGIN_DIR . "/assets/" );
define( 'PAVI_PLUGIN_ASSETS_URL', PAVI_PLUGIN_URL . "/assets/" );

define( 'PAVI_PLUGIN_TEMPLATES_DIR', PAVI_PLUGIN_DIR . "/templates/" );
define( 'PAIV_PLUGIN_TEMPLATES_URL', PAVI_PLUGIN_URL . "/templates/" );

class PAVI_VIDEO_PLUGIN{
    
    /**
     * Setup the Environment for the Plugin
     */
    function __construct() {

        global $pavi_settings;

        include_once PAVI_PLUGIN_INCLUDES_DIR . 'functions.php';
        include_once PAVI_PLUGIN_INCLUDES_DIR . 'actions.php';
        include_once PAVI_PLUGIN_INCLUDES_DIR . 'filters.php';
        include_once PAVI_PLUGIN_INCLUDES_DIR.  'help.php';
        if ( is_admin() ) {
            include_once PAVI_PLUGIN_INCLUDES_DIR. 'admin.php';
        }

        add_theme_support('post-thumbnails');
        add_image_size( 'image_735x413', 735, 413, true );
      
        load_plugin_textdomain( 'pressapps-video', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
        
        add_action('init' , array($this,'init'));

        if ( $pavi_settings['custom-css'] ) {
            add_action( 'wp_head', 'print_custom_css' );
        }

    }
    
    function init(){
        
        add_filter( 'widget_text', 'do_shortcode' );
        
        register_post_type( 'video',array(
            'description'           => __('Video Posts','pressapps-video'),
            'labels'                => array(
                'name'                  => __('Videos'                     ,'pressapps-video'),
                'singular_name'         => __('Video'                      ,'pressapps-video'),
                'add_new'               => __('Add New'                    ,'pressapps-video'),  
                'add_new_item'          => __('Add New Video'              ,'pressapps-video'),  
                'edit_item'             => __('Edit Video'                 ,'pressapps-video'),  
                'new_item'              => __('New Video'                  ,'pressapps-video'),  
                'view_item'             => __('View Video'                 ,'pressapps-video'),  
                'search_items'          => __('Search Videos'              ,'pressapps-video'),  
                'not_found'             => __('No Videos found'            ,'pressapps-video'),  
                'not_found_in_trash'    => __('No Videos found in Trash'   ,'pressapps-video'),
                'all_items'             => __('All Videos'                 ,'pressapps-video'),
            ),
            'public'                => true,
            'menu_position'         => 5,
            'rewrite'               => array('slug' => 'video'),
            'supports'              => array('title','editor', 'thumbnail'),
            'public'                => true,
            'show_ui'               => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => true
        ));
        
        register_taxonomy( 'video_category',array( 'video' ),array( 
            'hierarchical'  => false,
            'labels'        => array(
                'name'              => __( 'Categories'             ,'pressapps-video'),
                'singular_name'     => __( 'Category'               ,'pressapps-video'),
                'search_items'      => __( 'Search Categories'      ,'pressapps-video'),
                'all_items'         => __( 'All Categories'         ,'pressapps-video'),
                'parent_item'       => __( 'Parent Category'        ,'pressapps-video'),
                'parent_item_colon' => __( 'Parent Category:'       ,'pressapps-video'),
                'edit_item'         => __( 'Edit Category'          ,'pressapps-video'),
                'update_item'       => __( 'Update Category'        ,'pressapps-video'),
                'add_new_item'      => __( 'Add New Category'       ,'pressapps-video'),
                'new_item_name'     => __( 'New Category Name'      ,'pressapps-video'),
                'popular_items'     => NULL,
                'menu_name'         => __( 'Categories'             ,'pressapps-video') 
            ),
            'show_ui'       => true,
            'public'        => true,
            'query_var'     => true,
            'hierarchical'  => true,
            'rewrite'       => array( 'slug' => 'video_category' )
        ));
        
        
        wp_register_style('pavi-video'      , PAVI_PLUGIN_ASSETS_URL . '/css/pressapps-video.css');
        wp_register_script('pavi-video'  , PAVI_PLUGIN_ASSETS_URL . 'js/pressapps-video.js');
       
    }
}
$pavi_video = new PAVI_VIDEO_PLUGIN();