<?php
/**
 * This plugin for simple Model for Checkout coupon.
 *
 * @package           HashCoupon
 *
 * @wordpress-plugin
 * Plugin Name:       Hash Coupon
 * Description:       A Simple Model for WooCommerce Checkout Coupons.
 * Version:           1.0.1
 * Author:            Hashcrypt Technology
 * Author URI:        https://hashcrypt.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined( 'ABSPATH' ) || exit;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
     die;
}

if ( ! defined( 'HWC_PLUGIN_FILE' ) ) {
    define( 'HWC_PLUGIN_FILE', __FILE__ );
}

define( 'HWC_PLUGIN_BASE_PATH' ,    basename( dirname( __FILE__ ) ) . '/' );
define( 'HWC_PLUGIN_PATH',          plugin_dir_path( __FILE__ ) );
define( 'HWC_PLUGIN_URL',           plugin_dir_url(__FILE__ ));
define( 'HWC_IMG_PATH',              HWC_PLUGIN_URL . 'assets/img/' );
define( 'HWC_BOOTSTRAP_PATH',              HWC_PLUGIN_URL . 'assets/bootstrap/' );
define( 'HWC_CSS_PATH',              HWC_PLUGIN_URL . 'assets/css/' );
define( 'HWC_JS_PATH',              HWC_PLUGIN_URL . 'assets/js/' );
define( 'HWC_TEMPLATE_PATH',              HWC_PLUGIN_URL . 'template/' );
define( 'HWC_ADMIN_PATH',              HWC_PLUGIN_URL . 'admin/' );


include_once HWC_PLUGIN_PATH . 'admin/class-hash-coupon-admin.php';
include_once HWC_PLUGIN_PATH . 'includes/class-hash-coupon-main.php';
include_once HWC_PLUGIN_PATH . 'includes/class-hash-coupon-scripts.php';


if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}


if (!is_plugin_active( 'woocommerce/woocommerce.php' )){
    add_action('admin_notices',array('HashCouponAdmin','hashcoupon_admin_notice_error'));
}else{   
    HashCoupon::getInstance();
}


if(get_option('hash_status') == 'off'){

    add_action('admin_notices',array('HashCouponAdmin','hashcoupon_admin_notice_active_status'));
}


/**
 * This is the main plugin class. It's purpose generally is for "ALL PLUGIN RELATED STUFF ONLY".
 *
 * Class HashCoupon
 */
class HashCoupon
{

    private static $_instance;
    private $_hashcoupon;

    public $hash_main;
    public $hash_admin;
    public $hash_script_loader;

    const VERSION = '1.0.1';


    /**
     * HashCoupon constructor.
     *
     * @since 1.0.1
     * @access public
     */
    public function __construct()
    {

        $this->hash_script_loader  = HashCouponScript::getInstance();
        $this->hash_admin  = HashCouponAdmin::getInstance();
        $this->hash_main  = HashCouponMain::getInstance();
        if(get_option('hash_status') == false){
            add_option('hash_status','off');
        }
        register_deactivation_hook( __FILE__,array($this,'hashcoupon_deactivate'));
        register_uninstall_hook(__FILE__,array($this,'hashcoupon_uninstall'));
    }

    /**
     * Singleton Pattern.
     * Ensure that only one instance of HashCoupon is loaded or can be loaded (Singleton Pattern).
     *
     * @since 1.0.1
     * @access public
     *
     * @return HashCoupon
     */
    public static function getInstance()
    {

        if (!self::$_instance instanceof self)
            self::$_instance = new self;
        return self::$_instance;
    }

    /**
     * Deactivation hook.
     */
    public static function hashcoupon_deactivate() {
        update_option('hash_status','off');
    }

    /**
     * Deactivation hook.
     */
    public static function hashcoupon_uninstall() {
        delete_option( 'hash_status');
    }
    
 }
?>