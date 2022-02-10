<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly                           

if(sanitize_text_field(isset($_POST['hash_status']))){
    $status=sanitize_text_field($_POST['hash_status']);
    update_option('hash_status',$status);
}
?>

<section class="hash_section">
	<div class="hash_container">

	 <div class="hash_main">
		<img src="<?php echo HWC_IMG_PATH.'logo.png' ?>" alt="LOGO" style="height: 80px;width: auto;">
		<h1>Welcome to HASHCOUPONS !!!</h1>
		<!--<p>Making shopping experiences better.</p>-->
		<p style="font-size: 17px;">It will helps you to make your coupons ui more beautiful and attractive.</p>
		<form class="hash_status_form" method="post">
			<div style="display: inline-block;margin-top: 10px;" >
				<label>Hash Staus : </label>
			</div>
			 <div class="button b2" id="button-14">
			   <input type="checkbox" name="hash_checkbox" class="hash_checkbox" <?php echo (get_option('hash_status') == 'on') ? 'checked' : ''; ?>>
			   <div class="knobs">
			     <span></span>
			   </div>
			   <div class="layer"></div>
			 </div>		
			<input type="hidden" name="hash_status">
		</form>
		</div>


	 <div class="hash_whychoose">
		
			<h1>What Will We Do</h1>
			<p class="content">Making shopping experiences better</p>
			<div class="hash_whychoose_container">

				<div class="card text-center">
					<div class="card-header">
						<div class="icon icon-lg icon-primary mb-4">
							<span class="fas fa-money-bill-wave"></span>
						 </div>
						 <p class="title">View Better</p>
					 </div>
				 	<div class="card-body">
				 		<p class="content">We will change the traditional look of Woo-commerce Coupons.</p>
				 	</div>
				 </div>
			
				<div class="card text-center">
					<div class="card-header">
						<div class="icon icon-lg icon-primary mb-4">
							<span class="fas fa-money-bill-wave"></span>
						 </div>
						 <p class="title">Track Better</p>
					 </div>
				 	<div class="card-body">
				 		<p class="content">Simple model pop-up for all available coupon list.</p>
				 	</div>
				 </div>
			
				<div class="card text-center">
					<div class="card-header">
						<div class="icon icon-lg icon-primary mb-4">
							<span class="fas fa-money-bill-wave"></span>
						 </div>
						 <p class="title">Shop Better</p>
					 </div>
				 	<div class="card-body">
				 		<p class="content">With best list of coupons will attract customer for shopping more.</p>
				 	</div>
				 </div>

			</div>
							
	</div>
</div>	
</section>

<script>
	jQuery(function($){
		$(document).ready(function () {
		 
		  $(".hash_checkbox").change(function() {
		    if(this.checked) {
		        $("input[name=hash_status]").val('on');
		        $('.hash_status_form').submit();
		       
		    }else{
		    	alert("HashCoupon Will Disable are you sure?");
		    	$("input[name=hash_status]").val('off');
		    	$('.hash_status_form').submit();
		    }
	      });

		});
	});
</script>
