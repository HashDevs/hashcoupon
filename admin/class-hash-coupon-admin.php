<?php 
/**
 * The admin class for the plugin
 *
 * Managing Admin Panel Changes
 *
 * @since    1.0.1
 *
 * @package   HashCoupon
 * @author    Hashcrypt Technology
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt
 * @link      https://hashcrypt.com/
 */

defined( 'ABSPATH' ) || exit;

class HashCouponAdmin{

    /**
     * Property that holds the single main instance of HashCouponAdmin.
     *
     * @since 1.0.1
     * @access private
     * @var HashCouponAdmin
     */
    private static $_instance;

	/**
	 * Represents the current version of this plugin.
	 *
	 * @access    private
	 * @since     1.0.1
	 * @var       string
	 */
	private $version;

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.1
	 */
	public function __clone() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'hashcoupon' ), '1.0.1' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.1
	 */
	public function __wakeup() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'hashcoupon' ), '1.0.1' );
	}

	/**
     * Ensure that only one instance of HashCouponMain is loaded or can be loaded (Singleton Pattern).
     *
     * @since 1.0.1
     * @access public
     * @deprecated: Will be remove on future versions
     *
     * @return HashCouponMain
     */
    public static function getInstance() {

        if( !self::$_instance instanceof self )
            self::$_instance = new self;

        return self::$_instance;

    }

	/**
	 * Initializes the properties of the class.
	 *
	 * @access    public
	 * @since     1.0.1
	 */

	public function __construct() {

		$this->version = '1.0.1';
		add_action('admin_menu',array( $this, 'hashcoupon_add_menu'));
		add_action( 'wp_dashboard_setup',array( $this, 'hashcoupon_dashboard_widget'));
	}


	public function hashcoupon_add_menu() {
	    add_menu_page(
	            'Hash Coupon', // page_title
	            'Hash Coupon', // menu_title
	            'manage_options', // capability
	            'hash-coupon', // menu_slug
	            array( $this, 'hashcoupon_home') , // function
	            'dashicons-tickets', // icon_url
	            //HWC_IMG_PATH.'hashcoupon.svg',
	            48 // position
	        );
	}

	public function hashcoupon_home() {
	    include HWC_PLUGIN_PATH.'admin/hash_admin_dashboard.php';
	}

	public static function hashcoupon_admin_notice_error() {
        $class = 'notice notice-error';
        $message = __('It seems WooCommerce is not installed or activated. HashCoupon works only with active Woocommerce plugin.', 'hashcoupon');
        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
    }

    public static function hashcoupon_admin_notice_active_status() {
    	$path = 'admin.php?page=hash-coupon';
    	$url = '<a href="'.admin_url($path).'"Here</a>';
        $class = 'notice notice-error';
        $message = __("It's Looks like HashCoupon is not Activated, Starts HashCoupon Status ", "hashcoupon");
        printf('<div class="%1$s"><p>%2$s<a href="%3$s">Here</a></p></div>', esc_attr($class), esc_html($message),esc_html($path));
    }


    public function hashcoupon_dashboard_widget() {
        wp_add_dashboard_widget( 'dashboard_widget', 'HashCoupon Status : '.get_option('hash_status'), array($this,'hashcoupon_dashboard_widget_function') );
    }
     
    public function hashcoupon_dashboard_widget_function() {
     echo '<h3>Welcome to HASHCOUPONS !!!</h3><p>It will helps you to make your coupons ui more beautiful and attractive.</p>';

    }
}
?>