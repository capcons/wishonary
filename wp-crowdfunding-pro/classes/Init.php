<?php
namespace WPCF_PRO;

defined('ABSPATH') || exit;

class Init {
	public $version = WPCF_PRO_VERSION;
	public $path;
	public $url;
	public $basename;

	private $assets;
	private $updater;

	function __construct() {

        $this->url = WPCF_PRO_DIR_URL;
		$this->path = plugin_dir_path( WPCF_PRO_FILE );
		$this->basename = plugin_basename( WPCF_PRO_FILE );

		$this->run(); //run pro plugin

		//Loading Autoloader
        spl_autoload_register(array($this, 'loader'));
        
		//Load Component from Class
		$this->assets = new \WPCF_PRO\Assets();
		$this->updater = new \WPCF_PRO\Updater();
		add_action('plugins_loaded', array($this, 'load_addons'));
		add_action('plugins_loaded', array($this, 'enable_addons'));
    }
    
	/**
	 * @param $className
	 *
	 * Auto Load class and the files
	 */
	private function loader($className) {
		if ( !class_exists($className) ) {
			$className = preg_replace(
				array('/([a-z])([A-Z])/', '/\\\/'),
				array('$1-$2', DIRECTORY_SEPARATOR),
				$className
			);

			$className = str_replace('WPCF_PRO'.DIRECTORY_SEPARATOR, 'classes'.DIRECTORY_SEPARATOR, $className);
			$file_name = $this->path.$className.'.php';

			if (file_exists($file_name) && is_readable( $file_name ) ) {
				require_once $file_name;
			}
		}
	}

    /**
	 * Run the Crowdfunding pro right now
	 */
	public function run() {
		require_once plugin_dir_path( WPCF_PRO_FILE ).'classes/PayFull.php';
		new \WPCF_PRO\PayFull();
		register_activation_hook( WPCF_PRO_FILE, array( $this, 'wpcf_pro_activate' ) );
	}

	/**
	 * Do some task during plugin activation
	 */
	public function wpcf_pro_activate() {
		$version = get_option( 'wpcf_pro_version' );
		//Save Option
		if ( !$version ) {
			update_option( 'wpcf_pro_version', $this->version );
		}
	}

	public function load_addons() {
        $addonsDir = array_filter( glob($this->path.'addons/*'), 'is_dir' );
		if ( count($addonsDir) > 0 ) {
			foreach( $addonsDir as $key => $value ) {
				$addon_dir_name = str_replace(dirname($value).DIRECTORY_SEPARATOR, '', $value);
				$file_name = $this->path.'addons'.DIRECTORY_SEPARATOR.$addon_dir_name.DIRECTORY_SEPARATOR.$addon_dir_name.'.php';
				if ( file_exists($file_name) ) {
					include_once $file_name;
				}
			}
		}
	}

	public function enable_addons() {
		if ( !get_option('wpcf_pro_first_activation') ) {
			$addons = apply_filters('wpcf_addons_lists_config', array());
			foreach ( $addons as $basName => $addon ) {
				$addonsConfig[ sanitize_text_field($basName) ]['is_enable'] = 1;
				update_option('wpcf_addons_config', $addonsConfig);
			}
			update_option( 'wpcf_pro_first_activation', 1);
		}
	}

}