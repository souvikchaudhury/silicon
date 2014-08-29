<?php require_once(dirname(__FILE__).'/header.php'); ?>

<?php if( isset($_SESSION['user_logged_in']) ) { ?>

	<script type="text/javascript">
		//image function
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        reader.onload = function(e) {
		            $('#inventory_img').attr('src', e.target.result);
		        }
		        reader.readAsDataURL(input.files[0]);
		    }
		}

		//quantity delete function
		function inventorydelete_func(indexno) {
			$.ajax({
	            type: "post",
	            url: adminAjaxVar,
	            data: {
	                action: 'inventoryproductquantitydeletefunc',
	                'indexNo': indexno
	            },
	            success: function(data) {
	                //window.location.reload();
	                $('#inventoryquan'+indexno).remove();
	            }
	        });
		}

		//inventory product delete function 
		function inventoryDelete(pid) {
	        $.ajax({
	            type: "post",
	            url: adminAjaxVar,
	            data: {
	                action: 'inventoryproductdeletefunc',
	                'inventoryProductid': pid
	            },
	            success: function(data) {
	                window.location.reload();
	            }
	        });
		}
	</script>



	<div class="backend"> <!-- backend start -->
		<div class="header"> <!-- header start -->
		<div class="wrap">
			<div class="logo">
				<a href="#"><img src="images/logo.png" alt="Silikon Graphics"></a>
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
							<li>Customers</li>
							<?php
								foreach($all_customers as $indicustomer) {
									$customer_role = get_user_meta($indicustomer->ID, 'role');
									if($customer_role == 'customer') {
							?>
										<li><a href="javascript:void(0);" class="inventory_customer" id="<?php echo $indicustomer->ID; ?>"><?php echo $indicustomer->display_name; ?></a></li>
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
								<a class="buttonPink" href="<?php echo site_url(); ?>admin/customers.php"><img alt="" src="<?php echo site_url(); ?>admin/images/plus.png">ADD Customer</a>
								<hr>
								<ul>
									<?php
										$post_table = $table_prefix.'posts';
										$get_inventoryproductSql = "SELECT * FROM $post_table WHERE post_type = 'inventory-product' AND post_author = '".$_SESSION['inventory_Customer_ID']."'";
										$get_inventoryproduct = mysql_query($get_inventoryproductSql);
										while($data = mysql_fetch_object($get_inventoryproduct)) {
										  $all_inventoryproduct[] = $data;
										}
										if( !empty($all_inventoryproduct) ) {
											foreach($all_inventoryproduct as $inventoryProduct) {
									?>
												<li>
													<div class="leftHSide">
														<a class="box inventoryShowBox" href="javascript:void(0)" id="<?php echo $inventoryProduct->ID; ?>">
															<span class="imgBox"><img src="<?php echo get_image($inventoryProduct->ID); ?>" alt="" /></span>
														</a>
														<p><?php echo get_the_title($inventoryProduct->ID); ?></p>
													</div>
												</li>
									<?php 
											} 
										}	
									?>
								</ul>
							</div>
						</div>

						<div class="popCol5 twoPannelStretch">
							<div class="popColWrap">
								<!-- <h4>Customers Custom Inventory Orders</h4> -->
								<form action="" class="addItem" method="post" enctype="multipart/form-data">
									<h4>Customers Custom Inventory Orders</h4>
									<?php 
										if(isset($_SESSION['inventory_Customer_ID'])) { 
											$userDetails = @get_userdata($_SESSION['inventory_Customer_ID']); //get user information
											//$_SESSION['inventory_Customer_ID'] = $userDetails->ID;
									?>
											<p>
												<input type="text" id="CustomerCustomInventory" name="customer_custom_inventory" value="<?php echo $userDetails->display_name; ?>" readonly="readonly" />
											</p>
									<?php } ?>

									<div class="uploadIconArea">
										<div class="popColWrap">
											<div class="uploadPrvBox">
												<a href="javascript:void(0);" class="prvImg"><img id="inventory_img" src="#" height="75" width="39" alt=""></a>
											</div>
											<h4>Upload Product Icon</h4>
												<input type="file" id="my_image_file_field" name="inventoryproduct_image" onchange="readURL(this);" />
												<span>No file selected  |  * Upload 54 x 54 Transparent PNG Icon</span>
										</div>
									</div>
									<div class="addQuantityArea">
										<div class="popColWrap inventorypopColWrap">
												<p>
													<label for="Item">Item Name</label>
													<input type="text" id="inventoryItem" name="inventoryproduct_name" value="" required="required" />
												</p>
												<p>
													<label for="Description">Description</label>
													<textarea id="inventoryDescription" name="inventoryproduct_desc" required="required"></textarea>
												</p>
												<p>
													<label for="Quantity">Quantity Options</label>
													<input type="number" id="inventoryQuantity" name="inventoryproduct_quantity" value="" />
												</p>
												<?php if(isset($_SESSION['inventory_Customer_ID'])) { ?>
														<p><a class="buttonPink" href="javascript:void(0);" id="inventoryquantity_button"><img src="<?php echo site_url(); ?>admin/images/plus.png" alt="">ADD quantity</a></p>
												<?php } ?>
												<span class="quantity_msg">Quantity can not be blank</span>
										</div>
									</div>
									<div class="saveProduct">
										<div class="popColWrap" id="inventoryproduct_add_quan"></div>
										<div class="popColWrap">
											<?php if(isset($_SESSION['inventory_Customer_ID'])){ ?>
											<p><input type="submit" name="inventorysave_product" class="buttonPink" value="SAVE PRODUCT" id="inventorysaveProductButton" /></p>
											<?php } ?>
										</div>
									</div>
								</form>

						<?php
						// $userDetails = get_userdata($_SESSION['inventory_Customer_ID']);
						// echo '<pre>';
						// print_r($userDetails);

							if(isset($_POST['inventorysave_product'])) {
								extract($_POST);
								$postsTable = $table_prefix.'posts';
								$postmetaTable = $table_prefix.'postmeta';

								//file upload
								$filename = $_FILES['inventoryproduct_image']['name'];
								$filename_tmp = $_FILES['inventoryproduct_image']['tmp_name'];
								$uploads_dir = substr(dirname(__FILE__), 0, -5).'theme/uploads/'.$filename;
								$moveResult = move_uploaded_file ( $filename_tmp, $uploads_dir );

								$userDetails = @get_userdata($_SESSION['inventory_Customer_ID']); //\\
								if(!isset($_SESSION['invpid'])) {
									if( count($_SESSION['inventory_product_quantity']) > 1 ) {
										foreach($_SESSION['inventory_product_quantity'] as $key => $value) {
											$post_name = mysql_real_escape_string( $inventoryproduct_name.' '.$value.' qty' );
											$post_author = $_SESSION['inventory_Customer_ID']; //\\
											//die();
											$post_date = date("Y-m-d H:i:s");
											$post_date_gmt = date("Y-m-d H:i:s");
											$post_content = mysql_real_escape_string( $inventoryproduct_desc );
											$post_title = mysql_real_escape_string( $inventoryproduct_name.' '.$value.' qty' );
											$post_status = 'publish';
											$post_name = strtolower( preg_replace("/[\s_]/", "-", $post_name) );
											$post_parent = 0;
											$post_type = 'inventory-product';
											$post_image_url = site_url().'theme/uploads/'.$filename;
											$qty = $value;
											$price = $price_arr[$key];
											$shipping_cost = $shipping_arr[$key];
											$postsSql = "INSERT INTO $postsTable(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_name, post_parent, post_type) VALUES('".$post_author."', '".$post_date."', '".$post_date_gmt."', '".$post_content."', '".$post_title."', '".$post_status."', '".$post_name."', '".$post_parent."', '".$post_type."')";
											mysql_query($postsSql); //inserting post

											$postsidSql = "SELECT ID FROM $postsTable WHERE post_name = '".$post_name."'";
											$postsidSql_result = mysql_query($postsidSql);
											$post_id = mysql_fetch_row( $postsidSql_result );
											$postid = $post_id[0]; //getting post id

											$postmetaSql = "INSERT INTO $postmetaTable(post_id, meta_key, meta_value) VALUES('".$postid."', 'post_image_url', '".$post_image_url."')"; 
											mysql_query($postmetaSql); //inserting post image in postmeta
											$postmeta_qtySql = "INSERT INTO $postmetaTable(post_id, meta_key, meta_value) VALUES('".$postid."', 'qty', '".$qty."')"; 
											mysql_query($postmeta_qtySql); //inserting post quantity in postmeta
											$postmeta_priceSql = "INSERT INTO $postmetaTable(post_id, meta_key, meta_value) VALUES('".$postid."', 'price', '".$price."')"; 
											mysql_query($postmeta_priceSql); //inserting post price in postmeta
											$postmeta_shippingSql = "INSERT INTO $postmetaTable(post_id, meta_key, meta_value) VALUES('".$postid."', 'shipping_cost', '".$shipping_cost."')"; 
											mysql_query($postmeta_shippingSql); //inserting post shipping cost in postmeta
										}
									} elseif( count($_SESSION['inventory_product_quantity']) == 1 ) {
											foreach($_SESSION['inventory_product_quantity'] as $key => $value) {
												$post_name = mysql_real_escape_string( $inventoryproduct_name.' '.$value.' qty' );
												// $userDetails = get_userdata($_SESSION['inventory_Customer_ID']); //\\
												$post_author = $_SESSION['inventory_Customer_ID']; //\\
												$post_date = date("Y-m-d H:i:s");
												$post_date_gmt = date("Y-m-d H:i:s");													$post_content = mysql_real_escape_string( $inventoryproduct_desc );
												$post_title = mysql_real_escape_string( $inventoryproduct_name.' '.$value.' qty' );
												$post_status = 'publish';
												$post_name = strtolower( preg_replace("/[\s_]/", "-", $post_name) );
												$post_parent = 0;
												$post_type = 'inventory-product';
												$post_image_url = site_url().'theme/uploads/'.$filename;
												$qty = $value;
												$price = $price_arr[$key];
												$shipping_cost = $shipping_arr[$key];

												$postsSql = "INSERT INTO $postsTable(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_name, post_parent, post_type) VALUES('".$post_author."', '".$post_date."', '".$post_date_gmt."', '".$post_content."', '".$post_title."', '".$post_status."', '".$post_name."', '".$post_parent."', '".$post_type."')";
												//die();
												mysql_query($postsSql); //inserting post

												$postsidSql = "SELECT ID FROM $postsTable WHERE post_name = '".$post_name."'";
												$postsidSql_result = mysql_query($postsidSql);
												$post_id = mysql_fetch_row( $postsidSql_result );
												$postid = $post_id[0]; //getting post id

												$postmetaSql = "INSERT INTO $postmetaTable(post_id, meta_key, meta_value) VALUES('".$postid."', 'post_image_url', '".$post_image_url."')"; 
												mysql_query($postmetaSql); //inserting post image in postmeta
												$postmeta_qtySql = "INSERT INTO $postmetaTable(post_id, meta_key, meta_value) VALUES('".$postid."', 'qty', '".$qty."')"; 
												mysql_query($postmeta_qtySql); //inserting post quantity in postmeta
												$postmeta_priceSql = "INSERT INTO $postmetaTable(post_id, meta_key, meta_value) VALUES('".$postid."', 'price', '".$price."')"; 
												mysql_query($postmeta_priceSql); //inserting post price in postmeta
												$postmeta_shippingSql = "INSERT INTO $postmetaTable(post_id, meta_key, meta_value) VALUES('".$postid."', 'shipping_cost', '".$shipping_cost."')"; 
												mysql_query($postmeta_shippingSql); //inserting post shipping cost in postmeta
											}
									   }

									   unset($_SESSION['inventory_Customer_ID'], $_SESSION['inventory_product_quantity']);
								} else {
									$invpid = $_SESSION['invpid'];
									$inv_image_url = site_url().'theme/uploads/'.$filename;
									$post_title = mysql_real_escape_string($inventoryproduct_name);
									$post_content = mysql_real_escape_string($inventoryproduct_desc);

									$inv_postSql = "UPDATE $postsTable SET post_title = '".$post_title."', post_content = '".$post_content."' WHERE ID = '".$invpid."'";
									mysql_query($inv_postSql);
									update_post_meta($invpid, 'post_image_url', $inv_image_url);
									update_post_meta($invpid, 'qty', $invenQuan);
									update_post_meta($invpid, 'price', $invenPrice);
									update_post_meta($invpid, 'shipping_cost', $invenShipp);
									unset($_SESSION['invpid']);
								  }
							   $url = site_url().'admin/product-inventory.php';
							   redirect($url);
							}

						?>
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