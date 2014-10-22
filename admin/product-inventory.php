<?php require_once(dirname(__FILE__).'/header.php'); ?>

<?php if( isset($_SESSION['user_logged_in']) ) { ?>

	<script type="text/javascript">
		//image function
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        indx = input.getAttribute("data-count");

		        reader.onload = function(e) {
		            $('#inventory_img'+indx).attr('src', e.target.result);
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
		$(function() {
			$( ".datepicker" ).each(function(){
				$(this).datepicker({
					// defaultDate: +7,
				  	showOn: "button",
				  	buttonImage: "images/calendar.gif",
				  	buttonImageOnly: true,
				  	buttonText: "Select date",
				  	dateFormat: "dd-mm-yy",
				});

			});
		});
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
				<?php require_once('menu.php');?>
				<div class="productOptionSec">
					<div class="productOptionMenu">
						<ul>
							<li>Customers</li>
							<?php
								foreach($all_customers as $indicustomer) {
									$customer_role = get_user_meta($indicustomer->ID, 'role');
									if($customer_role == 'customer') {
										$cust_url = site_url().'admin/product-inventory.php?customerid='.$indicustomer->ID;
							?>
										<li>
											<a href="<?php echo $cust_url; ?>" class="inventory_customer" id="<?php echo $indicustomer->ID; ?>">
												<?php echo $indicustomer->display_name; ?>
											</a>
										</li>
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
								<a class="buttonPink" href="<?php echo site_url(); ?>admin/customers.php">
									<img alt="" src="<?php echo site_url(); ?>admin/images/plus.png">
									ADD Customer
								</a>
								<hr>
								<ul>
									<?php
										$customerid = isset($_GET['customerid']) ? $_GET['customerid'] : 1;
										$disabled = $customerid ==1 ? 'disabled="disabled"' : '';

										$post_table = $table_prefix.'posts';
										$get_inventoryproductSql = "SELECT * FROM $post_table WHERE post_type = 'inventory-product' AND post_author = '".$customerid."'";
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
															<span class="imgBox"><img src="<?php echo getPostImage($inventoryProduct->ID); ?>" alt="" /></span>
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
										if(isset($customerid)) { 
											$userDetails = get_userdata('id',$customerid); //get user information
											//$_SESSION['inventory_Customer_ID'] = $userDetails->ID;
									?>	
											<p>
												<input type="text" id="CustomerCustomInventory" name="customer_custom_inventory" value="<?php echo $userDetails->display_name; ?>" readonly="readonly" />
											</p>
									<?php } ?>

									<div class="uploadIconArea">
										<div id="artWorkImgPreviewdiv"> </div>
										<div class="uploadaddmore">Add More</div>
										<div class="popColWrap uploadcontainer" id="uploadcontainer">
											<div class="uploadmain">
												<div class="uploadPrvBox">
													<a href="javascript:void(0);" class="prvImg">
															<img id="inventory_img1" src="images/sample.png" height="75" width="39" alt="">
													</a>
												</div>
												<!-- <a href="javascript:void(0);" class="prvImg">
													<img id="inventory_img1" src="images/sample.png" height="75" width="39" alt="">
												</a> -->
												<h4>Upload Product Icon</h4>
												<input type="file" name="uploadedimg[]" class="uploadimg my_image_file_field" data-count="1" onchange="readURL(this)" >
												<!-- <span>No file selected  |  * Upload 54 x 54 Transparent PNG Icon</span> -->
											</div>
										</div>
									</div>
									<div class="addQuantityArea">
										<div class="popColWrap inventorypopColWrap">
												<input type="hidden" id="checkCondition" name="checkCondition" value="additem" />
												<input type="hidden" id="inventoryID" name="inventoryID" value="" />

												<p>
													<label for="Item">Item Name</label>
													<input type="text" id="inventoryItem" name="inventoryproduct_name" value="" required="required" <?php echo $disabled; ?> />
												</p>
												<p>
													<label for="Description">Description</label>
													<textarea id="inventoryDescription" name="inventoryproduct_desc" required="required"<?php echo $disabled; ?> ></textarea>
												</p>
												<p>
													<label for="Quantity">Quantity Options</label>
													<input type="number" id="inventoryQuantity" name="inventoryproduct_quantity" class="invenquan" value="" <?php echo $disabled; ?> />
												</p>
												<p>
													<label for="Price">Price</label>
													<input type="number" value="" name="inventoryproduct_price" class="invenprice" />
												</p>
												<p>
													<label for="Shipping">Shipping</label>
													<input type="number" value="" name="inventoryproduct_shipping" class="invenshipp" />
												</p>												

												<?php /* if($customerid!=1) { ?>
														<p>
															<a class="buttonPink" href="javascript:void(0);" id="inventoryquantity_button">
																<img src="<?php echo site_url(); ?>admin/images/plus.png" alt="">
																ADD quantity
															</a>
														</p>
												<?php } */?>
												<span class="quantity_msg">Quantity can not be blank</span>
												<div class="inventoryappnd"></div>
										</div>
									</div>
									<div class="saveProduct">
										<div class="popColWrap" id="inventoryproduct_add_quan"></div>
										<div class="popColWrap">
											<?php if($customerid!=1){ ?>
											<p><input type="submit" name="inventorysave_product" class="buttonPink"  style="display:inline;" value="SAVE PRODUCT" id="inventorysaveProductButton" /></p>
											<?php } ?>
										</div>
									</div>
								</form>

								<h4>Current Job Orders Status</h4>
								<form action="" class="orderStatus">
									<?php 
										$ordinfo = get_order_by_userid(21); 
										foreach ($ordinfo as $key => $value) {
											?>
											<div class="orderno<?php echo $value->id;?>">
												<h4>Order No. <?php echo $value->id;?></h4>
												<?php 
													$orderdesc = json_decode($value->orderdesc);
													foreach ($orderdesc->itemdesc as $ordervalue) {
														$postsDtls = get_post($ordervalue->id);
														
														$parentitle = get_the_title($postsDtls->post_parent);
														$parentitle = str_replace('<_>', ' ', $parentitle);
														?>
														<p>
															<span><?php echo $ordervalue->productname.' ( '.$parentitle. ' )'; ?></span>
															<label for="production1">
																<input type="radio" id="production1" class="status_<?php echo $ordervalue->id.'_'.$value->id; ?>" name="status_<?php echo $ordervalue->id.'_'.$value->id; ?>" value="production" <?php echo $ordervalue->orderstat=='production'?'checked="true"':''; ?> > Production
															</label>
															<label for="completed1">
																<input type="radio" id="completed1" class="strad status_<?php echo $ordervalue->id.'_'.$value->id; ?>" name="status_<?php echo $ordervalue->id.'_'.$value->id; ?>" value="completed" <?php echo $ordervalue->orderstat=='completed'?'checked="true"':''; ?>> Completed
																<span class="dspan" style="<?php echo $ordervalue->orderstat=='completed' ? 'display:inline-block;width:190px;':'display:none;width:190px;' ?> ">
																	<input type="text" value="<?php echo $ordervalue->orderstat=='completed'? $ordervalue->ordercompleted:date('d-m-Y'); ?>" class="datepicker dclsd date_<?php echo $ordervalue->id.'_'.$value->id; ?>" readonly="true" style="width: 84px; height: 25px; margin-left: 30px; margin-right: 5px;" />
																</span>
															</label>
														</p>
														<?php
													}
												?>
																								
												<p class="halfWidth">
													<!-- <button class="buttonPink">Order Production</button> -->
													<button class="buttonBlack orderstatsave" postids='<?php echo json_encode($orderdesc->postid); ?>' orderid="<?php echo $value->id;?>">Order Save</button>
												</p>
											</div>
											<?php
										}
									?>
								</form>
								
						<?php
						// $userDetails = get_userdata($_SESSION['inventory_Customer_ID']);
						// echo '<pre>';
						// print_r($userDetails);
						
							if(isset($_POST['inventorysave_product'])) {
								extract($_POST);
								$postsTable = $table_prefix.'posts';
								$postmetaTable = $table_prefix.'postmeta';
								$fileUploaded = false;

								//file upload
								foreach($_FILES["uploadedimg"]["error"] as $key => $value){
								    if($value == 0){
								        $fileUploaded = true;
								        break;
								    }
								}

								if($checkCondition == 'additem') {

									$slugName = strtolower( preg_replace("/[\s_]/", "-", $inventoryproduct_name) );
						            $prdctno = postcountbyslug($slugName);
						            if( empty($prdctno) ) {
						                $slug = $slugName;
						            } else {
						                $prdctno = $prdctno + 1;
						                $slug = $slugName.$prdctno;
						              }
						            $postExcerpt = substr($inventoryproduct_desc, 0, 52).'...';

						            $prdct_details_array = array(
						                                        'post_author' => $customerid,
						                                        'post_date' => date("Y-m-d H:i:s"),
						                                        'post_date_gmt' => date("Y-m-d H:i:s"),
						                                        'post_content' => $inventoryproduct_desc,
						                                        'post_title' => $inventoryproduct_name,
						                                        'post_excerpt' => $postExcerpt,
						                                        'post_status' => 'publish',
						                                        'post_name' => $slug,
						                                        'post_parent' => 0,
						                                        'post_type' => 'inventory-product'
						                                   );
						            add_inventory_product($prdct_details_array); //add inventory product
						            $invProduct = get_postbyslug($slug); //post details by slug
						            if( empty($inventoryproduct_quantity) ) //quantity
						                $qty = 1;
						            else
						                $qty = $inventoryproduct_quantity;

						            if($fileUploaded){
										$allimages = reArrayFiles($_FILES['uploadedimg']);
										foreach ($allimages as $key => $value) {
											$RandomNum = rand(0, 9999999999);
											$ImageName = str_replace(' ','-',strtolower($value['name']));
											$ImageType = $value['type']; //"image/png", image/jpeg etc.
											$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
											$ImageExt = str_replace('.','',$ImageExt);
											$ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
											//Create new image name (with random number added).
											$filename = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
											$filename_tmp = $value['tmp_name'];
											$uploads_dir = substr(dirname(__FILE__), 0, -5).'theme/upload/'.$filename;

											$moveResult = move_uploaded_file ( $filename_tmp, $uploads_dir );

											//var_dump($moveResult);
											//die();

											$base_path="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
											
											$base=$base_path.'/'.'upload/'.$filename;
											$base = str_replace('admin', 'theme', $base);
											
											$ks = 'post_image_url_'.$key;
	                						add_post_meta($invProduct->ID, $ks, $base);
										}
									}

						            add_post_meta($invProduct->ID, 'qty', $qty);
						            add_post_meta($invProduct->ID, 'price', $inventoryproduct_price);
					            	add_post_meta($invProduct->ID, 'shipping_cost', $inventoryproduct_shipping);

					        	} else if($checkCondition == 'edititem'){

					        		$postExcerpt = substr($inventoryproduct_desc, 0, 52).'...';
						            $postid = $_POST['inventoryID'];
						            $my_post = array(
						                    'ID'            => $postid,
						                    'post_date'     => date("Y-m-d H:i:s"),
						                    'post_date_gmt' => date("Y-m-d H:i:s"),
						                    'post_content'  => $inventoryproduct_desc,
						                    'post_title'    => $inventoryproduct_name,
						                    'post_excerpt'  => $postExcerpt,
						                    'post_status'   => 'publish',
						              );
						            
						            if($fileUploaded){
										$allimages = reArrayFiles($_FILES['uploadedimg']);
										foreach ($allimages as $key => $value) {
											$RandomNum = rand(0, 9999999999);
											$ImageName = str_replace(' ','-',strtolower($value['name']));
											$ImageType = $value['type']; //"image/png", image/jpeg etc.
											$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
											$ImageExt = str_replace('.','',$ImageExt);
											$ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
											//Create new image name (with random number added).
											$filename = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
											$filename_tmp = $value['tmp_name'];
											$uploads_dir = substr(dirname(__FILE__), 0, -5).'theme/upload/'.$filename;
											$moveResult = move_uploaded_file ( $filename_tmp, $uploads_dir );

											$base_path="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
											$base=$base_path.'/'.'upload/'.$filename;
											$base = str_replace('admin', 'theme', $base);

											$gnumber = getLastPostImageNo($postid);
											$number = $gnumber+$key;
						                    $meta_key = 'post_image_url_'.$number;

	                						add_post_meta($postid, $meta_key, $base);
										}
									}
									$qty = empty($inventoryproduct_quantity) ? 1 : $inventoryproduct_quantity;
									$$inventoryproduct_price = empty($inventoryproduct_price ) ? 0 : $inventoryproduct_price;
									$inventoryproduct_shipping = empty($inventoryproduct_shipping) ? 0 : $inventoryproduct_shipping;

						            $allimages = getPostImage($postid,true);
						            if($allimages){
						                update_post_meta($postid,'qty',$qty);
						                update_post_meta($postid,'price',$inventoryproduct_price);
						                update_post_meta($postid,'shipping_cost',$inventoryproduct_shipping);
						                wp_update_post( $my_post );
						            }
					        	}

					        	$url = site_url().'admin/product-inventory.php';
							    redirect($url);

								/*$userDetails = get_userdata('id',$customerid); //\\
								// if(!isset($_SESSION['invpid'])) {

								// Edit Section

									if( count($_SESSION['inventory_product_quantity']) > 1 ) {
										foreach($_SESSION['inventory_product_quantity'] as $key => $value) {
											$post_name = mysql_real_escape_string( $inventoryproduct_name.' '.$value.' qty' );
											$post_author = $customerid; //\\
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
												$post_author = $customerid; //\\
												$post_date = date("Y-m-d H:i:s");
												$post_date_gmt = date("Y-m-d H:i:s");													
												$post_title = mysql_real_escape_string( $inventoryproduct_name.' '.$value.' qty' );
												$post_content = mysql_real_escape_string( $inventoryproduct_desc );
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

									   unset($_SESSION['inventory_Customer_ID'], $_SESSION['inventory_product_quantity']);*/
								/*} else {
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
							   redirect($url);*/
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