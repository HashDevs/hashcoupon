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


defined( 'ABSPATH' ) || exit;

class HashCouponMain{

	/*
    |--------------------------------------------------------------------------
    | Class Properties
    |--------------------------------------------------------------------------
     */

    /**
     * Property that holds the single main instance of HashCouponMain.
     *
     * @since 1.0.1
     * @access private
     * @var HashCouponMain
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
     * @param array $dependencies Array of instance objects of all dependencies of HashCouponMain model.
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
	 * @access    private
	 * @since     1.0.1
	 */

	public function __construct() {

		$this->version = '1.0.1';
		add_action( 'woocommerce_init', array( $this, 'hashcoupon_init' ) );
	}

	/**
	 * Init WooCommerce Coupon Model extension once we know WooCommerce is active
	 */
	public function hashcoupon_init(){

		if(get_option('hash_status') == 'on'){
        add_filter( 'woocommerce_locate_template', array( $this, 'hashcoupon_locate_template'), 10, 3 );
		add_action( 'woocommerce_review_order_after_cart_contents', array( $this, 'hashcoupon_checkout_coupon_form' ) );
		}
    
	}
	public function hashcoupon_locate_template( $template, $template_name, $template_path ) {
         $basename = basename( $template );
         if( $basename == 'form-coupon.php' ) {
         $template = trailingslashit( HWC_PLUGIN_PATH ) . 'template/woocommerce/form-coupon.php';
         }
         return $template;
        }

	public function hashcoupon_checkout_coupon_form() {
	    ?>
		<tr class="coupon-form"><td>Coupon Discount</td>
		<td class="product-total">
	    <a href="#" class="btn hashDisBtn" data-bs-toggle="modal" data-bs-target="#couponModel">
		  Apply Coupon
		</a>
	    </td>
	    </tr>
	    <tr class="noCoupon" style="display:none;"><td>No coupons found</td><td></td></tr>
	    <?php
	}

	
}	