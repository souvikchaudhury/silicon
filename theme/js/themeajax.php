<?php
	ob_start();
	session_start();
	include_once(substr(dirname(__FILE__), 0, -8).'config.php');
	include_once(substr(dirname(__FILE__), 0, -8).'include/allFunctions.php');
	mysql_connect(DBHOST, DBUSER, DBPASS) or die("Error establishing in Database Connection");
	mysql_select_db(DBNAME) or die('Database is not found');
	$table_prefix = PREFIX;

	extract($_POST);

	if($action == 'userregisterfunc') {
		$check_user = get_userdata('email', $CustomerEmail);
		if( empty($check_user) ) {
			$usersTable = $table_prefix.'users'; //users table
			$usermetaTable = $table_prefix.'usermeta'; //user meta table
			$customer_login_name = preg_replace("/[\s_]/", "-", $CustomerName);
			$customer_login_name = strtolower($customer_login_name);
			$user_array = array(
							'user_login' => $customer_login_name,
							'user_pass' => $CustomerPassword,
							'user_nicename' => $CustomerName,
							'user_email' => $CustomerEmail,
							'display_name' => $CustomerName
				          );
			add_user($user_array,'customer'); //creating customer
			$useridSql = "SELECT ID FROM $usersTable WHERE user_login = '".mysql_real_escape_string($customer_login_name)."'";
			$useridSql_result = mysql_query( $useridSql );
			$userid = mysql_fetch_row( $useridSql_result );
			$user_id = $userid[0];
			$userPass = mysql_real_escape_string($CustomerPassword);
			add_user_meta($user_id, 'customer_business_name', $CustomerBusinessname);
			add_user_meta($user_id, 'customer_user_mobile', $CustomerMobileno);
			add_user_meta($user_id, 'customer_user_phone', $CustomerPhoneno);
			add_user_meta($user_id, 'customer_user_password', $userPass);
			if( !isset($_SESSION['logged_in_user']) )
				$_SESSION['logged_in_user'] = mysql_real_escape_string($customer_login_name);

			//user name and password mail section
			$to = $CustomerEmail;
			$subject = "Login Details"."\r\n";
			$message = "Welcome to Printapps. Thank you for signing in. Following are the login details of yours:"."\r\n";
			$message .= "Username:  ".$customer_login_name."\r\n";
			$message .= "Password:  ".$CustomerPassword."\r\n";
			mail($to, $subject, $message);

		} else {
			echo 'You have already registered. Please try by another details';
		  }
		die();
	}

	if($action == 'themelogoutfunc') {
		unset($_SESSION['logged_in_user']);
		die();
	}

	if($action == 'usersigninfunc') {
		$signin_email = mysql_real_escape_string($Themesignin_email);
		$signin_pass = mysql_real_escape_string($Themesignin_password);
		$usersigninDetails = get_userdata('email', $signin_email);
		if( !empty($usersigninDetails) ) {
			if(md5($signin_pass) == $usersigninDetails->user_pass) {
				echo 'All Good';
				$_SESSION['logged_in_user'] = $usersigninDetails->user_login;
			} else {
				echo 'You have entered wrong password';
			  }
		} else {
			echo 'This email id is not registered';
		  }
		die();
	}

	if($action == 'inventoryprdctshowfunc') {
		$allinventoryproducts = get_post_children($parentprdctid, 'inventory-product');
		if( !empty($allinventoryproducts) ) {
			foreach($allinventoryproducts as $inventoryproduct) {
				$imageurl = getPostImage($inventoryproduct->ID);
				$qty = get_post_meta($inventoryproduct->ID, 'qty');
?>
				<li>
					<div class="leftHSide">
						<a href="javascript:void(0)" class="box inventoryImgClass" id="<?php echo $inventoryproduct->ID; ?>">
							<span class="imgBox inventoryproductimgbox" style="padding:0px;">
								<img src="<?php echo $imageurl; ?>" height="146px" width="135px">
							</span>
						</a>
						<p>
							<input type="checkbox" name="inventoryOrder[]" class="inventoryOrder" value="<?php echo $inventoryproduct->ID; ?>">
							Order
						</p>
						<p><?php echo $inventoryproduct->post_title." $qty qty."; ?></p>
					</div>
				</li>
<?php
			}
		}
		die();
	}

	if($action == 'inventoryprdcteditfunc') {	
		$editproductDetails = get_post($inventoryImgID);
		$editproductImgUrlarr = array();
		if( !empty($editproductDetails) ) {

			$postmetaTable = PREFIX.'postmeta';
			$post_metaSql = "SELECT meta_key,meta_value  FROM printapps_postmeta WHERE post_id = '".$editproductDetails->ID."' and meta_key LIKE 'post_image_url_%' ORDER BY meta_id ASC";
			$post_metaSql_result = mysql_query( $post_metaSql );
			$i=0;
			while($row = mysql_fetch_array($post_metaSql_result)) {
			  $editproductImgUrlarr[$i]['meta_value'] = $row['meta_value'];
			  $editproductImgUrlarr[$i]['meta_key'] = $row['meta_key'];
			  $i++;
			}
			// var_dump($editproductImgUrlarr);
			$editproductqty = get_post_meta($editproductDetails->ID, 'qty');
			$inventoryprdcteditarr = array(
										'ID'			=> $editproductDetails->ID,
										'post_title' 	=> $editproductDetails->post_title,
										'post_content' 	=> $editproductDetails->post_content,
										'post_image_url'=> $editproductImgUrlarr,
										'qty' => $editproductqty
				                     );
			echo json_encode($inventoryprdcteditarr);
		}
		die();
	}

	if($action == 'updatedeletefunc') {
		unlink($file);
		$editproductqty = delete_post_meta($inventoryImgID, $meta_key);	
		die();
	}

	if($action == 'changeinventoryordercosts'){
		if(isset($allcheckedpostid)){
			
			$shipping_cost = 0;
			$price = 0;
			$total_shipping_cost=0;
			$totprodprice =0;

			foreach ($allcheckedpostid as $key => $value) {
				$shipping_cost 	= get_post_meta($value,'shipping_cost');
				$shipping_cost = $shipping_cost ? $shipping_cost : 0;

				$price= get_post_meta($value,'price');
				$price = $price ? $price : 0;
				
				$postval = get_post($value);
				$postparent = $postval->post_parent;

				if($postparent == 0){
					$totprodprice = $totprodprice + $price;
					$total_shipping_cost = $total_shipping_cost + $shipping_cost;
				} else {
					$catalog_quantity =  get_post_meta($postparent,'qty');

					$prodquantity= get_post_meta($value,'qty');
					$unitPrice = floatval($price / $catalog_quantity);

					$prodprice = $unitPrice * $prodquantity;
					$total_shipping_cost = $total_shipping_cost + $shipping_cost;
					$totprodprice = $totprodprice + $prodprice;
				}
			}
			$total_price = $total_shipping_cost + $totprodprice;

			$arr['product_price'] = "$".$totprodprice;
			$arr['total_price'] = "$".$total_price;
			$arr['total_shipping_cost'] = "$".$total_shipping_cost;
			echo json_encode($arr);
		}
		die();
	}
	if($action == 'myinventory'){
		?>
		<a class="closeBtn" href="javascript:void(0)"></a>
		<div class="wrap">
			<div class="popCol1">
				<div class="popColWrap">
					<h3>Your Inventory</h3>
					<p class="subTitle">
						<span>Click | Tap product to edit &amp; upload</span> your art work  | Max file size 32mb
					</p>
					<hr>
					<ul>
						<?php
							$post_table = PREFIX.'posts';
							$get_inventoryproductSql = "SELECT * FROM $post_table WHERE post_type = 'inventory-product' AND post_author = '".$currentuserid."'";
							$get_inventoryproduct = mysql_query($get_inventoryproductSql);
							while($data = mysql_fetch_object($get_inventoryproduct)) {
							  $all_inventoryproduct[] = $data;
							}
							if( !empty($all_inventoryproduct) ) {
								foreach($all_inventoryproduct as $inventoryProduct) {
									if($inventoryProduct->post_parent > 0){
										$title = get_the_title($inventoryProduct->post_parent);
										$title_arr = explode('<_>',$title);
										$dispTitle = $title_arr[0];
										$parentpost_title = str_replace('<_>', ' ', $title);
									}else{
										$parentpost_title = '';
									}
						?>
							<li>
								<div class="leftHSide">
									<a class="box" href="javascript:void(0)" id="<?php echo $inventoryProduct->ID; ?>">
										<span class="imgBox" style="padding:0px;">
											<img src="<?php echo getPostImage($inventoryProduct->ID); ?>" alt="" style="height:100px;width:100px;"/>
										</span>
										<span class="title"><?php  echo $parentpost_title; ?></span>
									</a>
									<p><?php echo get_the_title($currentuserid); ?></p>
								</div>
								<div class="rightHSide">
									<p>
										<input type="checkbox" name="inventoryOrder[]" class="inventoryOrder" value="<?php echo $inventoryProduct->ID; ?>">
										<label for="order">Order</label>
									</p>
								</div>
							</li>
						<?php 
								} 
							}	
						?>
					</ul>
				</div>
			</div>
			<div class="popCol3">
				<div class="popColWrap">
					<h3>Order</h3>

					<div class="orderCost">
						<h3 class="title">Order Costs</h3>
						<p><span>Products:</span><label id="tot_prod_price">$0.00</label></p>
						<p><span>Delivery:</span><label id="tot_ship_price">$0.00</label></p>
						<!-- <p><span>Subtotal:</span>$0.00</p>
						<p><span>GST:</span>$0.00</p> -->
						<p><span>Total:</span><label id="total_prod_ship_price">$0.00</label></p>
					</div>
					
					<div class="payOption">
						<a href="#" class="largeButton">Send &amp; Pay Order</a>
					</div>
					
					<div class="payPal">
						<div class="paypalInfo">
							<p>We accept payments from PayPal only. No PayPal Account ? No problems! Just use your credit card to pay instead. <strong>PayPal accepts payments from all majorcredit cards.</strong></p>
						</div>

						<div class="papalLogo">
							<img src="images/paypal.png"  alt="">
						</div>
						
						<div class="payOption">
							<a href="#" class="largeButton">Fast Track Order</a>
						</div>

					</div>

				</div>
			</div>
		<!-- <div class="invenControl">
			<a href="#" class="prev">prev</a>
			<a href="#" class="next">next</a>
		</div> -->
		<?php
	}