<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
  return;
}
global $wpdb;
$coupon_codes =$wpdb->get_results(" SELECT p.`ID` AS id,
    p.`post_title`   AS code,
    p.`post_excerpt` AS description,
    Max(CASE WHEN pm.meta_key = 'date_expires' AND p.`ID` = pm.`post_id` THEN pm.`meta_value` END) AS expiry_date
    FROM `wp_posts` AS p
    INNER JOIN `wp_postmeta` AS pm ON  p.`ID` = pm.`post_id`
    WHERE  p.`post_type` = 'shop_coupon'
    AND p.`post_status` = 'publish'
    AND pm.meta_key = 'date_expires'
    AND FROM_UNIXTIME(pm.meta_value) > CURRENT_TIMESTAMP
    GROUP  BY p.`ID`
    ORDER  BY p.`ID` ASC ");

    if($coupon_codes==null){
      ?>
        <style type="text/css">
          .coupon-form{
            display: none !important;
          }
          .noCoupon{
            display: table !important;
          }
        </style>
      <?php
    }
?>
<div class="modal fade" id="couponModel" tabindex="-1" aria-labelledby="couponModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Apply Coupon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <p style="margin-bottom:10px;"><?php esc_html_e( 'Here are some coupons for you.', 'woocommerce' ); ?></p>
          <div class="form-row form-row-first w-100">
            <ul class="couponList">
              <?php
                  foreach ( $coupon_codes as $coupon_details){
                    //foreach start
                    $coupon = new WC_Coupon( $coupon_details->id );
                    echo "<li class=".esc_html($coupon->code).">";
                    echo "<div class='couponCode'><div class='hashCouponName'>".esc_html(substr($coupon->code,0,15))."</div>";
                    ?>
                    <div class="submitBtn" style="float:right;">
                      <form class="checkout_coupon woocommerce-form-coupon" id="<?php echo esc_html($coupon->code);?>" method="post" style="display: block !important;">
                        <input type="hidden" name="<?php echo esc_html($coupon->code);?>" class="input-text coupon_code" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" value="<?php echo $coupon->code;?>" />
                        <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
                      </form>
                    </div>
                    <?php
                    echo"</div>";
                    if(isset($coupon_details->description) && $coupon_details->description != null && $coupon_details->description != ''){
                      echo "<div class='couponDesc'>".esc_html($coupon_details->description)."</div>";
                    }
                    echo "<a href='javascript:void(0)' class='coupon-view-more-wrap accordion'><label for='' class='coupon-view-more' data-more='+ More' data-less='- Less'></label></a>";
                    echo "<div class='panel'>";
                     echo "<div class='couponDate'>".esc_html($coupon->code)."</div>";
                      echo "<div class='couponDate'>Valid till ".esc_html(date('d-M-Y',strtotime($coupon->expiry_date)))."</div>";
                      echo "<div class='couponType'>Coupon Type : ".esc_html($coupon->type)."</div>";
                      if(isset($coupon->minimum_amount) && $coupon->minimum_amount != null && $coupon->minimum_amount != ''){
                          echo "<div class='couponMinSpent'>Spend minimum Amount is ".esc_html($coupon->minimum_amount)."</div>";
                      }
                      if(isset($coupon->maximum_amount) && $coupon->maximum_amount != null && $coupon->maximum_amount != ''){
                          echo "<div class='couponMinSpent'>Spend Maximum Amount is ".esc_html($coupon->maximum_amount)."</div>";
                      }
                      if(isset($coupon->usage_limit_per_user) && $coupon->usage_limit_per_user != null && $coupon->usage_limit_per_user != ''){
                          echo "<div class='couponUsagePerUser'>The Usage Limit Per User is ".esc_html($coupon->usage_limit_per_user)."</div>";
                      }
                    echo "</div>";
                  echo "</li>";
                  } // foreach end
              ?>
            </ul>
          </div>
          <div class="clear"></div>
      </div>
    </div>
  </div>
</div>

<script>
  var acc = document.getElementsByClassName("accordion");
  var i;
  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      /* Toggle between hiding and showing the active panel */
      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
        panel.style.display = "none";
      } else {
        panel.style.display = "block";
      }
    });
  }
</script>