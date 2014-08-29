<?php require_once(dirname(__FILE__).'/header.php'); ?>

<?php if( isset($_SESSION['user_logged_in']) ) { ?>
	<div class="backend"> <!-- backend start -->
		<div class="header"> <!-- header start -->
		<div class="wrap">
			<div class="logo">
				<a href="<?php echo site_url(); ?>" target='_blank'><img src="<?php echo site_url(); ?>admin/images/logo.png" alt="Silikon Graphics"></a>
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
								$prdct_end_array = @end($terms_select_Result);
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
				<hr>
				<div class="pannelWrap">
					<div class="leftPannelOption" id="category_leftPannelOption">
						<h3>Product Category</h3>
						<ul class="selection">
							<?php
								if( !empty($terms_select_Result) ) {
									foreach($terms_select_Result as $term) {
							?>
										<li><label for="business" class="business_cat_class" id="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></label></li>
							<?php 
									} 
								} else {
									echo "No Category";
								  }
							?>
						</ul>
						<a href="javascript:void(0);" class="addCategory buttonPink"> <img src="<?php echo site_url(); ?>admin/images/plus.png" alt="">ADD CATEGORY</a>
					</div>
					<div class="rightPannelOption" style="display:none;" id="category_rightPannelOption">
						<div class="saveCategory">
							<h3>Category Name</h3>
							<form class="printForm">
								<p><input type="text" value="" id="category_name" /></p>
								<p id="category_errormsg" style="display:none;" onkeyup="category_errorfunc();"></p>
								<a href="javascript:void(0);" class="saveCategory buttonPink" id="save_cat"> <img src="<?php echo site_url(); ?>admin/images/save.png" alt="">Save CATEGORY</a>
							</form>
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