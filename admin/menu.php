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
				// $prdct_end_array = end($terms_select_Result);
				// $prdct_catalog_url = site_url().'admin/product.php?termslug='.$prdct_end_array->slug;
				$prdct_catalog_url = site_url().'admin/product.php?termslug=prod_slug';
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
				<img src="images/customers.png" height="26" width="34" alt="">
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
				<img src="images/website.png" height="28" width="35" alt="">
				</span>
				<span class="text">Website Integration</span>
			</a>
		</li>
		<li>
			<a href="javascript:void(0)">
				<span class="image">
				<img src="images/setup.png" height="28" width="28" alt="">
				</span>
				<span class="text">Setup Guide</span>
			</a>
		</li>
		<li>
			<a href="javascript:void(0)">
				<span class="image">
				<img src="images/admin.png" height="32" width="47" alt="">
				</span>
				<span class="text">Admin Branding</span>
			</a>
		</li>
		<li>
			<a href="javascript:void(0)">
				<span class="image">
				<img src="images/contact.png" height="23" width="23" alt="">
				</span>
				<span class="text">Contact</span>
			</a>
		</li>
	</ul>
</div>
				