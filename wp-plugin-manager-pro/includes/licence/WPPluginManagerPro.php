<?php
require_once "WPPluginManagerProBase.php";
class WPPluginManagerPro {
    public $plugin_file=HTPMPRO_PL_ROOT;
    public $responseObj;
    public $licenseMessage;
    public $showMessage=false;
    public $slug="wp-plugin-manager-pro";
    function __construct() {
        add_action( 'admin_print_styles', [ $this, 'SetAdminStyle' ] );
        $licenseKey=get_option("WPPluginManagerPro_lic_Key","");
        $liceEmail=get_option( "WPPluginManagerPro_lic_email","");
        WPPluginManagerProBase::addOnDelete(function(){
           delete_option("WPPluginManagerPro_lic_Key");
        });
        if(WPPluginManagerProBase::CheckWPPlugin($licenseKey,$liceEmail,$this->licenseMessage,$this->responseObj, HTPMPRO_PL_ROOT)){
            add_action( 'admin_menu', [$this,'ActiveAdminMenu'],99999);
            add_action( 'admin_post_WPPluginManagerPro_el_deactivate_license', [ $this, 'action_deactivate_license' ] );
        }else{
            if(!empty($licenseKey) && !empty($this->licenseMessage)){
               $this->showMessage=true;
            }
            update_option("WPPluginManagerPro_lic_Key","") || add_option("WPPluginManagerPro_lic_Key","");
            add_action( 'admin_post_WPPluginManagerPro_el_activate_license', [ $this, 'action_activate_license' ] );
            add_action( 'admin_menu', [$this,'InactiveMenu']);
            add_action( 'admin_notices', [ $this, 'admin_notice_license_plugin' ] );
        }
    }

    function admin_notice_license_plugin() {
        $title = esc_html__( 'Welcome to WP Plugins Manager Pro!', 'htpmpro' );
        $message = esc_html__( 'Please activate your license to get automatic updates and premium support.', 'htpmpro' );
        $button = '<p><a href="'.esc_url( admin_url( 'admin.php?page='.$this->slug ) ).'" class="button button-primary">' . esc_html__( 'Activate license', 'htpmpro' ) . '</a></p>';
        printf( '<div class="notice notice-warning"><strong>%1$s</strong><p>%2$s</p>%3$s</div>', $title, $message , $button );

    }

    function SetAdminStyle() {
        wp_register_style( "WPPluginManagerProLic", HTPMPRO_ROOT_URL. '/includes/licence/style.css', 10 );
        wp_enqueue_style( "WPPluginManagerProLic" );
    }
    function ActiveAdminMenu(){
        
		add_submenu_page(
            'htpmpro_page', 
            __( 'Licence', 'htpmpro' ),
            __( 'Licence', 'htpmpro' ), 
            'manage_options', 
            $this->slug, 
            array ( $this, 'Activated' ) 
        );

    }
    function InactiveMenu() {

        add_submenu_page(
            'htpmpro_page', 
            __( 'Licence', 'htpmpro' ),
            __( 'Licence', 'htpmpro' ), 
            'manage_options', 
            $this->slug, 
            array ( $this, 'LicenseForm' ) 
        );

    }
    function action_activate_license(){
            check_admin_referer( 'el-license' );
            $licenseKey=!empty($_POST['el_license_key'])?$_POST['el_license_key']:"";
            $licenseEmail=!empty($_POST['el_license_email'])?$_POST['el_license_email']:"";
            update_option("WPPluginManagerPro_lic_Key",$licenseKey) || add_option("WPPluginManagerPro_lic_Key",$licenseKey);
            update_option("WPPluginManagerPro_lic_email",$licenseEmail) || add_option("WPPluginManagerPro_lic_email",$licenseEmail);
            wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
        }
    function action_deactivate_license() {
        check_admin_referer( 'el-license' );
        $message="";
        if(WPPluginManagerProBase::RemoveLicenseKey(__FILE__,$message)){
            update_option("WPPluginManagerPro_lic_Key","") || add_option("WPPluginManagerPro_lic_Key","");
        }
        wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
    }
    function Activated(){
        ?>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="WPPluginManagerPro_el_deactivate_license"/>
            <div class="el-license-container">
                <h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> <?php _e("WP Plugin Manager Pro License Info",$this->slug);?> </h3>
                <hr>
                <ul class="el-license-info">
                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("Status",$this->slug);?></span>

                        <?php if ( $this->responseObj->is_valid ) : ?>
                            <span class="el-license-valid"><?php _e("Valid",$this->slug);?></span>
                        <?php else : ?>
                            <span class="el-license-valid"><?php _e("Invalid",$this->slug);?></span>
                        <?php endif; ?>
                    </div>
                </li>

                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("License Type",$this->slug);?></span>
                        <?php echo $this->responseObj->license_title; ?>
                    </div>
                </li>

                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("License Expired on",$this->slug);?></span>
                        <?php echo $this->responseObj->expire_date; ?>
                    </div>
                </li>

                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("Support Expired on",$this->slug);?></span>
                        <?php echo $this->responseObj->support_end; ?>
                    </div>
                </li>
                    <li>
                        <div>
                            <span class="el-license-info-title"><?php _e("Your License Key",$this->slug);?></span>
                            <span class="el-license-key"><?php echo esc_attr( substr($this->responseObj->license_key,0,9)."XXXXXXXX-XXXXXXXX".substr($this->responseObj->license_key,-9) ); ?></span>
                        </div>
                    </li>
                </ul>
                <div class="el-license-active-btn">
                    <?php wp_nonce_field( 'el-license' ); ?>
                    <?php submit_button('Deactivate'); ?>
                </div>
            </div>
        </form>
    <?php
    }

    function LicenseForm() {
        ?>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="WPPluginManagerPro_el_activate_license"/>
        <div class="el-license-container">
            <h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> <?php _e("WP Plugin Manager Pro Licensing",$this->slug);?></h3>
            <hr>
            <?php
            if(!empty($this->showMessage) && !empty($this->licenseMessage)){
                ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo _e($this->licenseMessage,$this->slug); ?></p>
                </div>
                <?php
            }
            ?>
            <p><?php _e("Enter your license key here, to activate the product, and get full feature updates and premium support.",$this->slug);?></p>
            <div class="el-license-field">
                <label for="el_license_key"><?php _e("License code",$this->slug);?></label>
                <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
            </div>
            <div class="el-license-field">
                <label for="el_license_key"><?php _e("Email Address",$this->slug);?></label>
                <?php
                    $purchaseEmail   = get_option( "WPPluginManagerPro_lic_email", get_bloginfo( 'admin_email' ));
                ?>
                <input type="text" class="regular-text code" name="el_license_email" size="50" value="<?php echo $purchaseEmail; ?>" placeholder="" required="required">
                <div><small><?php _e("We will send update news of this product by this email address, don't worry, we hate spam",$this->slug);?></small></div>
            </div>
            <div class="el-license-active-btn">
                <?php wp_nonce_field( 'el-license' ); ?>
                <?php submit_button('Activate'); ?>
            </div>
        </div>
    </form>
        <?php
    }
}

new WPPluginManagerPro();