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
				<div class="userOptions">
					<ul>
						<li>
							<a href="<?php echo site_url(); ?>admin/category.php">
								<span class="image">
								<img src="<?php echo site_url(); ?>admin/images/category.png" height="35" width="44" alt="">
								</span>
								<span class="text">Product Category</span>
							</a>
						</li>
						<li>
							<?php
								$prdct_end_array = end($terms_select_Result);
								$prdct_catalog_url = site_url().'admin/product.php?termslug='.$prdct_end_array->slug;
							?>
							<a href="<?php echo $prdct_catalog_url; ?>">
								<span class="image">
								<img src="<?php echo site_url(); ?>admin/images/catalog.png" height="30" width="24" alt="">
								</span>
								<span class="text">Product Catalog</span>
							</a>
						</li>
						<li>
							<a href="<?php echo site_url(); ?>admin/customers.php">
								<span class="image">
								<img src="<?php echo site_url(); ?>admin/images/customers.png" height="26" width="34" alt="">
								</span>
								<span class="text">Customers</span>
							</a>
						</li>
						<li>
							<a href="<?php echo site_url(); ?>admin/payment.php">
								<span class="image">
								<img src="<?php echo site_url(); ?>admin/images/paymentSetup.png" height="34" width="45" alt="">
								</span>
								<span class="text">Payment Setup</span>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<span class="image">
								<img src="<?php echo site_url(); ?>admin/images/website.png" height="28" width="35" alt="">
								</span>
								<span class="text">Website Integration</span>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<span class="image">
								<img src="<?php echo site_url(); ?>admin/images/setup.png" height="28" width="28" alt="">
								</span>
								<span class="text">Setup Guide</span>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<span class="image">
								<img src="<?php echo site_url(); ?>admin/images/admin.png" height="32" width="47" alt="">
								</span>
								<span class="text">Admin Branding</span>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<span class="image">
								<img src="<?php echo site_url(); ?>admin/images/contact.png" height="23" width="23" alt="">
								</span>
								<span class="text">Contact</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="productOptionSec">
					<div class="productOptionMenu">
						<ul>
							<li>Product Categories</li>
							<?php
								if( !empty($terms_select_Result) ) {
									foreach($terms_select_Result as $term) {
							?>
										<li><a href="<?php echo site_url(); ?>admin/product.php?termslug=<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li>
							<?php
									}
								}
							?>
						</ul>
					</div>

					<div class="proOptionArea">
						<div class="popCol3">
							<div class="popColWrap">
								<br>
								<a class="buttonPink" href="<?php echo site_url(); ?>admin/product-inventory.php"><img alt="" src="<?php echo site_url(); ?>admin/images/plus.png">ADD Product</a>
								<hr>
								<ul class="customer">
									<?php
										foreach($all_customers as $indicustomer) {
											$customer_role = get_user_meta($indicustomer->ID, 'role');
											if($customer_role == 'customer') {
									?>
												<li><a href="javascript:void(0)" class="customerNames" id="<?php echo $indicustomer->ID; ?>"><?php echo $indicustomer->display_name; ?></a></li>
									<?php 
											} 
										}
									?>
								</ul>
							</div>
						</div>

						<div class="popCol4 customer_popCol4 twoPannelStretch">
							<div class="popColWrap">
								<h4>Customer contact &amp; Shipping Details</h4>
								<form action="" class="customerContact" method="post">
									<p>
										<label for="Name">Name</label>
										<input type="text" id="Name" class="CustomerfullName" placeholder="Name" name="full_name" value="" />
									</p>

									<p>
										<label for="Business Name">Business Name</label>
										<input type="text" id="Business Name" class="CustomerBusinessName" placeholder="Business Name" value="" name="business_name" />
									</p>

									<p>
										<label for="Email">Email</label>
										<input type="text" id="Email" class="CustomerUserEmail" placeholder="Email" name="user_email" value="" />
									</p>

									<p>
										<label for="Mobile / Cell No.">Mobile / Cell No.</label>
										<input type="text" id="Mobile / Cell No." class="CustomerUserMobile" placeholder="Mobile / Cell No." name="user_mobile" value="" />
									</p>

									<p>
										<label for="Phone Number">Phone Number</label>
										<input type="text" id="Phone Number" class="CustomerUserPhone" placeholder="Phone Number" name="user_phone" value="" />
									</p>

									<p>
										<label for="Account Password">Account Password</label>
										<input type="text" id="Account Password" class="CustomerUserPassword" placeholder="Account Password" name="user_password" value="" />
									</p>

									<p>
										<a class="buttonPink" href="javascript:void(0)" id="save_customer_button"><img src="<?php echo site_url(); ?>admin/images/save.png" alt="">SAVE CUSTOMER</a>
										<a class="blackBtn delete_customer_button" href="javascript:void(0)" style="display:none;">DELETE CUSTOMER</a>
									</p>
								</form>
							</div>
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
		</div> <!-- bodypannel end -->
	</div> <!-- backend end -->
<?php 
	} else {
		$adminUrl = site_url().'admin';
		redirect($adminUrl);
	  } 
require_once(dirname(__FILE__).'/footer.php');
?>