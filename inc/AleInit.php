<?php
require_once plugin_dir_path( __FILE__ ) ."AleBase.php";

class Ale {
    public $plugin_file=__FILE__;
    public $responseObj;
    public $licenseMessage;
    public $showMessage=false;
    public $slug = "ale";
    function __construct() {
        add_action( 'admin_print_styles', [ $this, 'SetAdminStyle' ] );
        $licenseKey=get_option("Ale_lic_Key","");
        $liceEmail=get_option( "Ale_lic_email","");
        if(AleBase::CheckWPPlugin($licenseKey,$liceEmail,$this->licenseMessage,$this->responseObj,get_template_directory_uri()."/style.css")){
            add_action( 'admin_menu', [$this,'ActiveAdminMenu'],99999);
            add_action( 'admin_post_Ale_el_deactivate_license', [ $this, 'action_deactivate_license' ] );
            //$this->licenselMessage=$this->mess;
/*
            function ale_theme_add_admin_menu() {
                add_theme_page( esc_html__('Demo Install', 'ale'), esc_html__('Demo Install', 'ale'), 'edit_posts', 'aletheme_theme_demos','ale_theme_demos');
            }
            add_action('admin_menu', 'ale_theme_add_admin_menu', 1);
*/
        }else{
            if(!empty($licenseKey) && !empty($this->licenseMessage)){
                $this->showMessage=true;
            }
            update_option("Ale_lic_Key","") || add_option("Ale_lic_Key","");
            add_action( 'admin_post_Ale_el_activate_license', [ $this, 'action_activate_license' ] );
            add_action( 'admin_menu', [$this,'InactiveMenu']);
        }
        }
    function SetAdminStyle() {
        wp_register_style( "AleLic", ALE_PLUGIN_URL . "/assets/css/_lic_style.css", 10);
        wp_enqueue_style( "AleLic" );
    }
    function ActiveAdminMenu(){
            
        add_menu_page (  "Deactivate Ale Theme", "Ale Deactivation", "activate_plugins", $this->slug, [$this,"Activated"], " dashicons-star-filled ");
        //add_submenu_page(  $this->slug, "Ale License", "License Info", "activate_plugins",  $this->slug."_license", [$this,"Activated"] );

    }
    function InactiveMenu() {
        add_menu_page( "Register Ale Theme", "Ale Activation", 'activate_plugins', $this->slug,  [$this,"LicenseForm"], " dashicons-star-filled ",2);
        
    }
    function action_activate_license(){
        check_admin_referer( 'el-license' );
        $licenseKey=!empty($_POST['el_license_key'])?$_POST['el_license_key']:"";
        $licenseEmail=!empty($_POST['el_license_email'])?$_POST['el_license_email']:"";
        update_option("Ale_lic_Key",$licenseKey) || add_option("Ale_lic_Key",$licenseKey);
        update_option("Ale_lic_email",$licenseEmail) || add_option("Ale_lic_email",$licenseEmail);
        wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
    }
    function action_deactivate_license() {
        check_admin_referer( 'el-license' );
        $message="";
        if(AleBase::RemoveLicenseKey(__FILE__,$message)){
            update_option("Ale_lic_Key","") || add_option("Ale_lic_Key","");
        }
            wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
    }
    function Activated(){
        ?>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="Ale_el_deactivate_license"/>
            <div class="el-license-container">
                <h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> <?php _e("Ale License Info",$this->slug);?> </h3>
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
            <input type="hidden" name="action" value="Ale_el_activate_license"/>
            <div class="el-license-container">
                <h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> <?php _e("Ale Theme Licensing",$this->slug);?></h3>
                <hr>
                <?php
                    if(!empty($this->showMessage) && !empty($this->licenseMessage)){
                        ?>
                        <div class="notice notice-error is-dismissible">
                            <p><?php echo $this->licenseMessage; ?></p>
                        </div>
                        <?php
                    }
                ?>
                <p class="welcome_text"><?php _e("In order to get the \"<b>automated one click demo install</b>\" feature, <b>free updates</b>, <b>premium support</b> and other benefits - you must <b>register</b> your copy of Ale Theme.",$this->slug);?></p>
                <ol>
                    <li><?php _e("Copy the <b>purchase code</b> from <b>Your Profile -> <a href='https://themeforest.net/downloads' target='_blank'>Downloads page</a> -> Press <b>Download</b> button -> License certificate & purchase code (text)</b>. (You must be log in)",$this->slug);?></li>
                    <li><?php esc_html_e("Open the downloaded .txt file and find the purchase code. Copy and Paste that purchase code in the field below.",$this->slug);?></li>
                    <li><?php esc_html_e("Enter your Email to get notifications about updates and press Activate button.",$this->slug);?></li>
                    <li><?php _e("That's all. Enjoy the <b>Ale Theme</b>.",$this->slug);?></li>
                    <li><?php _e("In case you have some troubles, get in touch with <a href='https://themeforest.net/user/crik0va' target='_blank'><b>our support</b></a>.",$this->slug);?></li>
                </ol>
                <div class="el-license-field">
                    <label for="el_license_key"><?php _e("License code",$this->slug);?></label>
                    <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
                </div>
                <div class="el-license-field">
                    <label for="el_license_key"><?php _e("Email Address",$this->slug);?></label>
                    <?php
                        $purchaseEmail   = get_option( "Ale_lic_email", get_bloginfo( 'admin_email' ));
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

new Ale();    