<?php require_once(dirname(__FILE__).'/header.php'); ?>

<?php if( isset($_SESSION['user_logged_in']) ) { ?>
	<div class="backend"> <!-- backend start -->
		<div class="header"> <!-- header start -->
		<div class="wrap">
			<div class="logo">
				<a href="<?php echo site_url(); ?>" target="_blank"><img src="<?php echo site_url(); ?>admin/images/logo.png" alt="Silikon Graphics"></a>
			</div>
			<div class="nav">
				<ul>
					<li class="active print2u"><a href="#">Print 2 you</a></li>
					<li class="right"><a href="javascript:void(0)" class="session_logout">Log Out</a></li>
					<li class="right bdr"><a href="javascript:void(0)">Hello <?php echo ucfirst($_SESSION['user_logged_in']); ?></a></li>
				</ul>
			</div>
		</div>
		</div> <!-- header end -->
		<div class="bodyPannel"> <!-- bodypannel start -->
		<div class="wrap">
			<div class="contentSection">
				<div class="uploadArea">
					<ul>
						<li><a href="#">Account Storage</a></li>
						<li><a href="#">1 gb Used 5mb</a></li>
						<li><a href="#">Available 995 mb</a></li>
					</ul>
					<div class="uploadingbox">
					</div>
				</div>
				<hr>
				<?php require_once('menu.php');?>
				<hr>
				<div class="pannelWrap paypalPannel">
					<div class="paypalLeftSec">
						<img src="images/paypal.png" height="42" width="521" alt="">
						<p>Welcome to the payment system setup. The Inkorporativ Websystems Shop Cart utilises the Paypal™ payment gateway system for ease of use, security and functionality to deliver to your buyers a easy and convenient way to buy from you. As Paypal™ allows the buyer to not only pay from their Paypal™ account, Paypal™ linked bank account, or directly from a credit card, all you have to do is set up your paypal account and enter your PayPal™ details on this page and the shopping cart is ready trade on the world wide web. How easy is that ? Real Easy !</p>
					</div>
					<div class="paypalRightSec">
						<h4>FULL MERCHANT SYSTEM</h4>
						<p>Do you require a full merchant system with a private and standalone Payment Gateway and direct transaction processing to a merchant bank account or credit card account with the ease of use of the Inkorporativ Web Systems Shopping Cart ? No Worries, we can do that for you. Please contact us through the Inkorporativ Website and request information on the Mechant Shopping Cart System and we will get back to you pronto !</p>
					</div>
				</div>

				<div class="paypalPaymentPannel">
					<div class="paypalLeftSec">
						<h4>Your PayPal Details</h4>
						<form class="paypalPayment" action="" method="post">
							<?php
								$pay_login = get_option('payment_account_login');
								$pay_url = get_option('payment_account_url');
								$pay_header_img = get_option('paypal_head_img');
								$pay_curr = get_option('paypal_currency');
								// $pay_code = get_option('paypal_payment_code');
								$fast_track_option = get_option('fast_track_order');
							?>
							<p>
								<label for="account">Paypal Account Login</label>
								<input type="email" style="width:70%;" id="account" placeholder="aldo@benzina.com.au" name="payment_login" required="required" <?php if( !empty($pay_login) ) echo "value=".$pay_login; ?> />
							</p>
							<p>
								<label for="password">Paypal Site Url</label>
								<input type="text" id="paypalurl" placeholder="https://www.paypal.com/cgi-bin/webscr" name="payment_url" required="required" <?php if( !empty($pay_url) ) echo "value=".$pay_url; ?> readonly=true/>
							</p>
							<p>
								<label for="password">Paypal Currency</label>
								<input type="text" id="paypalcurrency" placeholder="USD" name="paypalcurrency" required="required" <?php if( !empty($pay_curr) ) echo "value=".$pay_curr; ?> />
								<span>Possible values are "USD", "EUR", "GBP", "CAD", "JPY".</span>
							</p>
							
							<p>
								<label for="password">Paypal Header Image</label>
								<input type="text" id="paypalheaderimage" placeholder="Image Url" name="payment_header_img" required="required" <?php if( !empty($pay_header_img) ) echo "value=".$pay_header_img; ?> />
							</p>
							<!-- <p>
								<label for="payments">Paypal Custom Payments Page Code</label>
								<input type="text" id="payments" placeholder="QXVTYRE6A2D8AP9X" class="paymentArea" name="payment_code" required="required" <?php if( !empty($pay_code) ) echo "value=".$pay_code; ?> />
								<span>Insert PayPal Custom Payment Page button code . What is this ? <a href="#">Download the PayPal SetUp Guide</a></span>
							</p> -->
							<p>
								<label for="track">Fast Track Order ( % )</label>
								<input type="text" id="track" placeholder="Price should be 0 to 100" name="fast_track_order" <?php if( !empty($fast_track_option) ) echo "value=".$fast_track_option; ?> />
								<span>Price should be 0 to 100. It calculated in % of the total order price.</span>
							</p>
							
							<!-- <button class="buttonPink">Save</button> -->
							<input type="submit" name="payment_submit" class="buttonPink" value="SAVE" />
						</form>
					</div>
					<div class="paypalRightSec">
						<a href="#"><img src="images/paypalGuide.png" alt=""></a>
					</div>
				</div>
			</div>
		</div>
		</div> <!-- bodypannel end -->
	</div> <!-- backend end -->

	<?php
		if( isset($_POST['payment_submit']) ) {
			extract($_POST);

			$payment_log = check_option('payment_account_login');
			$payment_url1 = check_option('payment_account_url');
			$payment_head_img = check_option('paypal_head_img');
			$paypal_curr = check_option('paypal_currency');
			
			// $payment_co = check_option('paypal_payment_code');
			$fast_track = check_option('fast_track_order');

			if( empty($payment_log) ) 
				add_option('payment_account_login', $payment_login);
			else 
				update_option('payment_account_login', $payment_login);
			 
			if( empty($payment_url1) ) 
				add_option('payment_account_url', $payment_url);
			else 
				update_option('payment_account_url', $payment_url);
			
			
			if( empty($paypal_curr) ) 
				add_option('paypal_currency', $paypalcurrency);
			else 
				update_option('paypal_currency', $paypalcurrency);


			if( empty($payment_head_img) ) 
				add_option('paypal_head_img', $payment_header_img);
			else 
				update_option('paypal_head_img', $payment_header_img);

			/*if( empty($payment_co) ) 
				add_option('paypal_payment_code', $payment_code);
			else 
				update_option('paypal_payment_code', $payment_code);*/

			if( empty($fast_track) ) 
				add_option('fast_track_order', $fast_track_order);
			else 
				update_option('fast_track_order', $fast_track_order);

			$paymenturl = site_url().'admin/payment.php';
			redirect($paymenturl);
		}
	?>

<?php 
	} else {
		$adminUrl = site_url().'admin';
		redirect($adminUrl);
	  } 
require_once(dirname(__FILE__).'/footer.php');
?>