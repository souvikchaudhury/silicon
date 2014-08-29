<?php require_once(dirname(__FILE__).'/header.php'); ?>

		<script type="text/javascript">
			//image function
			function readURL(input) {
			    if (input.files && input.files[0]) {
			        var reader = new FileReader();
			        reader.onload = function(e) {
			            $('#blah').attr('src', e.target.result);
			        }
			        reader.readAsDataURL(input.files[0]);
			    }
			}

			//quantity delete function
			function delete_func(indexno) {
				$.ajax({
		            type: "post",
		            url: adminAjaxVar,
		            data: {
		                action: 'productquantitydeletefunc',
		                'indexNo': indexno
		            },
		            success: function(data) {
		                //window.location.reload();
		                $('#quan'+indexno).remove();
		            }
		        });
			}
		</script>

<?php if( isset($_SESSION['user_logged_in']) ) { ?>
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
						<div class="popCol1">
							<div class="popColWrap"><br>
								<a href="javascript:void(0);" class="addProduct buttonPink"><img src="<?php echo site_url(); ?>admin/images/plus.png" alt="">ADD Product</a>
								<hr>
								<ul>
									<?php
										$catname = $_GET['termslug'];
										$termtaxTable = $table_prefix.'term_taxonomy';
										$termrelationshipTable = $table_prefix.'term_relationships';
										$get_termtaxSql = "SELECT term_taxonomy_id FROM $termtaxTable WHERE taxonomy = '".$catname."'";
										$get_termtaxresult = mysql_query($get_termtaxSql);
										$termtaxid = mysql_fetch_row($get_termtaxresult);
										$termtaxid = $termtaxid[0];
										$get_termrelationSql = "SELECT object_id FROM $termrelationshipTable WHERE term_taxonomy_id = '".$termtaxid."'";
										$get_termrelationresult = mysql_query($get_termrelationSql);
										while($data = mysql_fetch_object($get_termrelationresult)) {
										  $all_objectid[] = $data;
										}
										if( !empty($all_objectid) ) {
											foreach($all_objectid as $object_id) {
									?>
												<li>
													<div class="leftHSide">
														<a class="box showProduct" href="javascript:void(0)" id="<?php echo $object_id->object_id; ?>">
															<span class="imgBox"><img src="<?php echo get_image($object_id->object_id); ?>" alt="" /></span>
														</a>
														<p><?php echo get_the_title($object_id->object_id); ?></p>
													</div>
												</li>
									<?php 
											} 
										}	
									?>
								</ul>
							</div>
						</div>
						<div class="popCol2" style="display:none;" id="product_details_section">
							<form action="" class="uploadForm" method="post" enctype="multipart/form-data">
								<div class="uploadIconArea">
									<div class="popColWrap">
										<div class="uploadPrvBox">
											<a href="javascript:void(0);" class="prvImg"><img id="blah" src="#" height="75" width="39" alt=""></a>
										</div>
										<h4>Upload Product Icon</h4>
											<input type="file" id="my_image_file_field" name="product_image" onchange="readURL(this);" />
											<span>No file selected  |  * Upload 54 x 54 Transparent PNG Icon</span>
									</div>
								</div>
								<div class="addQuantityArea">
									<div class="popColWrap">
											<p>
												<label for="Item">Item Name</label>
												<input type="text" id="Item" name="productItem_name" value="" required="required" />
											</p>
											<p>
												<label for="Description">Description</label>
												<textarea id="Description" name="productItem_desc" required="required"></textarea>
											</p>
											<p>
												<label for="Quantity">Quantity Options</label>
												<input type="number" id="Quantity" name="productItem_quantity" value="" />
											</p>
											<p><a class="buttonPink" href="javascript:void(0);" id="quantity_button"><img src="<?php echo site_url(); ?>admin/images/plus.png" alt="">ADD quantity</a></p>
											<span class="quantity_msg">Quantity can not be blank. Please use valide quantity number</span>
									</div>
								</div>
								<div class="saveProduct" style="display:none;">
									<div class="popColWrap" id="product_add_quan"></div>
									<div class="popColWrap">
										<p><input type="submit" name="save_product" class="buttonPink" value="SAVE PRODUCT" id="saveProductButton" /></p>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>				
			</div>
		</div>
		</div> <!-- bodypannel end -->
		</div> <!-- backend end -->

		<?php
			if( isset($_POST['save_product']) ) {
				extract($_POST);
				$category_slugname = $_GET['termslug'];

				//file upload
				$filename = $_FILES['product_image']['name'];
				$filename_tmp = $_FILES['product_image']['tmp_name'];
				$uploads_dir = substr(dirname(__FILE__), 0, -5).'theme/uploads/'.$filename;
				$moveResult = move_uploaded_file ( $filename_tmp, $uploads_dir );

				$postsTable = $table_prefix.'posts'; //post table

				if(!isset($_SESSION['show_product_id'])) {
					if( count($_SESSION['product_quantity']) > 1 ) {
						foreach($_SESSION['product_quantity'] as $key => $value) {
							$post_name = mysql_real_escape_string( $productItem_name.' '.$value.' qty' );
							$prdct_details_array = array(
												'post_author' => 1,
												'post_date' => date("Y-m-d H:i:s"),
												'post_date_gmt' => date("Y-m-d H:i:s"),
												'post_content' => mysql_real_escape_string( $productItem_desc ),
												'post_title' => mysql_real_escape_string( $productItem_name.' '.$value.' qty' ),
												'post_status' => 'publish',
												'post_name' => strtolower( preg_replace("/[\s_]/", "-", $post_name) ),
												'post_parent' => 0,
												'post_type' => 'product',
												'post_image_url' => site_url().'theme/uploads/'.$filename,
												'qty' => $value,
												'price' => $price_arr[$key],
												'shipping_cost' => $shipping_arr[$key]
						                   );
							add_post($prdct_details_array, $category_slugname);
						}
					} elseif( count($_SESSION['product_quantity']) == 1 ) {
						foreach($_SESSION['product_quantity'] as $key => $value) {
							$prdct_details_array = array(
													'post_author' => 1,
													'post_date' => date("Y-m-d H:i:s"),
													'post_date_gmt' => date("Y-m-d H:i:s"),
													'post_content' => mysql_real_escape_string( $productItem_desc ),
													'post_title' => mysql_real_escape_string( $productItem_name ),
													'post_status' => 'publish',
													'post_name' => strtolower( preg_replace("/[\s_]/", "-", $productItem_name) ),
													'post_parent' => 0,
													'post_type' => 'product',
													'post_image_url' => site_url().'theme/uploads/'.$filename,
													'qty' => $value,
													'price' => $price_arr[$key],
													'shipping_cost' => $shipping_arr[$key]
							                   );
							add_post($prdct_details_array, $category_slugname);
						}
					  }
					unset($_SESSION['product_quantity']); 
				} else {
					$pid = $_SESSION['show_product_id'];
					$prdct_image_url = site_url().'theme/uploads/'.$filename;
					$post_title = mysql_real_escape_string($productItem_name);
					$post_content = mysql_real_escape_string($productItem_desc);

					$prdoct_postSql = "UPDATE $postsTable SET post_title = '".$post_title."', post_content = '".$post_content."' WHERE ID = '".$pid."'";
					mysql_query($prdoct_postSql);
					if(!empty($filename)) {
						update_post_meta($pid, 'post_image_url', $prdct_image_url);
					}
					update_post_meta($pid, 'price', $price_arr);
					update_post_meta($pid, 'shipping_cost', $shipping_arr);
					unset($_SESSION['show_product_id']);
				  }
				$prdctCatalogUrl = site_url().'admin/product.php?termslug='.$category_slugname;
				redirect($prdctCatalogUrl);
			}
		?>

<?php 
	} else {
		$adminUrl = site_url().'admin';
		redirect($adminUrl);
	  } 
require_once(dirname(__FILE__).'/footer.php');
?>