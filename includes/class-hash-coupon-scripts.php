<?php 
/**
 * The primary class for the plugin
 *
 * Stores the plugin version, loads and enqueues dependencies
 * for the plugin.
 *
 * @since    1.0.1
 *
 * @package   HashCoupon
 * @author    Hashcrypt Technology
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt
 * @link      https://hashcrypt.com/
 */

if (!defined('ABSPATH')) {
    exit;
}


/**
 * Model that houses the logic of loading in scripts to various pages of the plugin.
 *
 * @since 1.0.1
 */
class HashCouponScript
{

    /*
    |--------------------------------------------------------------------------
    | Class Properties
    |--------------------------------------------------------------------------
     */

    /**
     * Property that holds the single main instance of HashCouponScript.
     *
     * @since 1.0.1
     * @access private
     * @var HashCouponScript
     */
    private static $_instance;

    /**
     * Current HashCoupon version.
     *
     * @since 1.0.1
     * @access private
     * @var int
     */
    private $version;

    /*
    |--------------------------------------------------------------------------
    | Class Methods
    |--------------------------------------------------------------------------
     */

    /**
     * HashCouponScript constructor.
     *
     * @since 1.0.1
     * @access public
     *
     * @param array $dependencies Array of instance objects of all dependencies of HashCouponScript model.
     */
    public function __construct()
    {

        $this->version = '1.0.1';
       add_action('wp_enqueue_scripts',array($this,'enqueue_hashcoupon'));
       add_action('admin_enqueue_scripts', array($this,'hashcoupon_admin_css_and_js'));
    }

    /**
     * Ensure that only one instance of HashCouponScript is loaded or can be loaded (Singleton Pattern).
     *
     * @since 1.0.1
     * @access public
     *
     * @return HashCouponScript
     */
    public static function getInstance()
    {

        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }

        return self::$_instance;

    }

    function enqueue_hashcoupon() {
        wp_register_style( 'hashcoupon-bootstrap-css', HWC_BOOTSTRAP_PATH.'bootstrap.min.css' );
        wp_enqueue_style('hashcoupon-bootstrap-css');
        wp_register_script( 'hashcoupon-bootstrap-popper-js', HWC_BOOTSTRAP_PATH.'popper.min.js' );
        wp_enqueue_script('hashcoupon-bootstrap-popper-js');
        wp_register_script('hashcoupon-bootstrap-min-js',HWC_BOOTSTRAP_PATH.'bootstrap.min.js' );
        wp_enqueue_script('hashcoupon-bootstrap-min-js');
      if(get_option('hash_status') == 'on'){
        wp_deregister_script('wc-checkout');
        wp_deregister_script('wc-checkout-js');
       // wp_enqueue_script('hashcoupon-wc-checkout',plugins_url('template/woocommerce/js/checkout.js', __FILE__), array('jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n'), null, true);
       
       wp_enqueue_script('hashcoupon-wc-checkout',HWC_TEMPLATE_PATH.'woocommerce/js/checkout.js', array('jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n'), null, true);
       }

       if ( is_checkout() ) {
           //echo 'It is checkout page';
           wp_enqueue_style('hash-checkout-styles', HWC_CSS_PATH.'hashcoupon_woo.css');
       }
    }

    function hashcoupon_admin_css_and_js() { 
        wp_enqueue_style('hash-admin-styles', HWC_CSS_PATH.'hashcoupon.css');
    }

}