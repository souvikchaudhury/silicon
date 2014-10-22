<?php require_once(dirname(__FILE__).'/header.php'); ?>
	<!-- mainBody Start -->

	<?php if( !isset($_SESSION['logged_in_user']) ) { ?>
			<div class="mainBody">
				<div class="wrapper">
					<div class="contentArea">
						<h3>Customer contact &amp; Shipping Details </h3>
						<form action="" class="customerContact" method="post" autocomplete="off">
							<p>
								<input type="text" placeholder="Name" id="CustomerName" name="customer_name" value="" />
								<input type="text" placeholder="Email" id="CustomerEmail" name="customer_email" value="" />
								<input type="password" placeholder="Account Password" id="CustomerPassword" name="customer_password" value="" />
							</p>
							<p>
								<input type="text" placeholder="Business Name" id="CustomerBusinessname" name="customer_businessname" value="" />
								<input type="text" placeholder="Mobile / Cell No." id="CustomerMobileno" name="customer_mobileno" value="" />
								<input type="text" placeholder="Phone Number" id="CustomerPhoneno" name="customer_phoneno" value="" />
							</p>
							<p>
								<textarea id="Customeraddress" placeholder="Address" name="customer_address" style="margin: 2px;width: 514px;height: 123px;"></textarea>
							</p>
							<p>
								<span>Please check your contact details throughly to ensure that you receive your printed jobs on time and in convenience.</span>
								<span>** You email &amp; account password will be emailed to you which you can use to login to check your order status and re order items.</span>
								<span>*** Account registration is required when placing orders</span>
							</p>
							<div class="createAccount">
								<a href="javascript:void(0)" class="largeButton" id="CustomerCreateaccountSubmit">Create Account</a>
							</div>
							<p id="theme_error_registration" style="display:none;"></p>
						</form> 
						<!-- popup Box Start -->
						<?php if(isset($_GET['stat']) == 'active') { ?>
								<div class="popUpBoxregister popupMode2 registerinventory" id="appspageinventoryimg">
									<!-- <a href="javascript:void(0)" class="closeBtn"></a> -->
									<img src="<?php echo THEMEPATH(); ?>/images/ss.jpg" height="1007" width="962" alt="" />
								</div>
						<?php } ?>
						<!-- popup Box End -->
					</div>
				</div>
			</div>
	<?php 
		} else {
			redirect( THEMEPATH() );
		  }
	?>
	<!-- mainBody End -->
<?php require_once(dirname(__FILE__).'/footer.php'); ?>
