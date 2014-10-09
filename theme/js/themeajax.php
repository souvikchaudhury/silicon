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

				$title = get_the_title($parentprdctid);
				$title_arr = explode('<_>',$title);
				$dispTitle = $title_arr[0];
				$parentpost_title = str_replace('<_>', ' ', $title);
				

				$imageurl = getPostImage($inventoryproduct->ID);
				$qty = get_post_meta($inventoryproduct->ID, 'qty');
?>
				<li>
					<div class="leftHSide">
						<a class="box inventoryImgClass" href="javascript:void(0)" id="<?php echo $inventoryproduct->ID; ?>">
							<span class="imgBox inventoryproductimgbox" style="padding:5px 0 0 0;">
								<img src="<?php echo $imageurl; ?>" alt="" style="height:100px;width:100px;"/>
							</span>
							<span class="title"><?php  echo $inventoryproduct->post_title; ?></span>
						</a>
						<p><?php echo $parentpost_title; ?></p>
					</div>
					<div class="rightHSide">
						<p>
							<input type="checkbox" name="inventoryOrder[]" class="inventoryOrder" value="<?php echo $inventoryproduct->ID; ?>">
							<label for="order">Order</label>
						</p>
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
	function getinventorycosts($allcheckedpostid){

			$shipping_cost = 0;
			$price = 0;
			$total_shipping_cost=0;
			$totprodprice =0;
			$i=0;
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
					
					$prodquantity= get_post_meta($value,'qty');
					$unitPrice = floatval($price / $prodquantity);

					$arr['itemdesc'][$i]['id'] = $value;
					$arr['itemdesc'][$i]['productname'] = get_the_title($value);

					$arr['itemdesc'][$i]['quantity'] = $prodquantity;
					$arr['itemdesc'][$i]['unitprice'] = $unitPrice;
					$arr['itemdesc'][$i]['amount'] = $price;
					$arr['itemdesc'][$i]['shipping'] = $shipping_cost;

				} else {
					$catalog_quantity =  get_post_meta($postparent,'qty');
					$unitPrice = floatval($price / $catalog_quantity);

					$prodquantity= get_post_meta($value,'qty');
					$prodprice = $unitPrice * $prodquantity;
					
					$totprodprice = $totprodprice + $prodprice;
					$total_shipping_cost = $total_shipping_cost + $shipping_cost;

					$arr['itemdesc'][$i]['id'] = $value;
					$arr['itemdesc'][$i]['productname'] = get_the_title($value);
					$arr['itemdesc'][$i]['quantity'] = $prodquantity;
					$arr['itemdesc'][$i]['unitprice'] = $unitPrice;
					$arr['itemdesc'][$i]['amount'] = $prodprice;
					$arr['itemdesc'][$i]['shipping'] = $shipping_cost;
				}
				$i++;
			}
			$total_price = $total_shipping_cost + $totprodprice;

			$arr['postid'] = json_encode($allcheckedpostid);
			$arr['product_price'] = "$".$totprodprice;
			$arr['total_shipping_cost'] = "$".$total_shipping_cost;
			$arr['total_price'] = "$".$total_price;
			
			$fullarr = json_encode($arr);
			return $fullarr;
	}

	if($action == 'changeinventoryordercosts'){
		if(isset($allcheckedpostid)){
			$arr = getinventorycosts($allcheckedpostid);
			echo $arr;
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
										<span class="title"><?php  echo $inventoryProduct->post_title; ?></span>
									</a>
									<p><?php echo $parentpost_title; ?></p>
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
						<a href="javascript:void(0)" class="largeButton sendpaypal">Send &amp; Pay Order</a>
					</div>
					
					<div class="payPal">
						<div class="paypalInfo">
							<p>We accept payments from PayPal only. No PayPal Account ? No problems! Just use your credit card to pay instead. <strong>PayPal accepts payments from all majorcredit cards.</strong></p>
						</div>

						<div class="papalLogo">
							<img src="images/paypal.png"  alt="">
						</div>
						
						<div class="payOption">
							<a href="javascript:void(0)" class="largeButton sendpaypalfast">Fast Track Order</a>
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
	if($action == 'sendpaypalform'){
		if(isset($allcheckedpostid)){
			$arr = getinventorycosts($allcheckedpostid);
			$getvalues = json_decode($arr);
		}
		$LoginuserDetails = isset($_SESSION['logged_in_user']) ? get_userdatabylogin($_SESSION['logged_in_user']) : '';
		$pay_curr = get_option('paypal_currency');
		?>
		<div class="paypalPaymentFront">
					<div class="billingInfo">
						<div class="popColWrap">
							<?php 
					        	$fast_track_option = get_option('fast_track_order');
					        	$totprice = $getvalues->total_price;
					        	$totpricetrim = ltrim ($totprice, '$');
					        	$fastTrackPriceAdd = (($totpricetrim*$fast_track_option)/100);
					        	$totprice = floatval($totpricetrim + $fastTrackPriceAdd);
					        	$showtotprice = $fasttrackorder=='yes' ? $totprice : $totpricetrim;
					        ?>

							<h2>Total $<?php echo $showtotprice.' '.$pay_curr; ?></h2>
							<h3>Your Order summary of <?php echo $LoginuserDetails->display_name; ?> </h3>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<thead>
									<tr>
										<th style="width:25%">Decription </th>
										<th style="width:25%">Amount </th>
										<th style="background-color:#e8e8e8;width:25%">Shipping Charge</th>
										<th style="width:25%">Total Amount</th>
									</tr>
								</thead>
							    <tbody>
							      	<?php
							      		$fasttrack = 10;
							      		$paypalitems = '';
							      		$k=0;
							      		foreach ($getvalues->itemdesc as $key => $value) {
							      			$k++;
							      			?>
							      			<tr>
										        <td align="left" valign="middle" style="width:25%">
										        	<strong class="underLine"><?php echo $value->quantity; ?> x  <?php echo $value->productname; ?> </strong>
										        	Item Price : $<?php echo $value->unitprice; ?> Quantity 1
										        </td>
										        <td align="left" valign="middle" style="width:25%">
										        	<strong>$<?php echo $value->amount; ?></strong>
										        </td>
										        <td align="left" valign="middle" style="width:25%">
										        	<strong>$<?php echo $value->shipping; ?></strong>
										        </td>
										        <td align="left" valign="middle" style="width:25%">
										        	<strong>$<?php echo floatval($value->amount+$value->shipping); ?></strong>
										        </td>
										    </tr>
										    <?php
							$paypalitems.=' <input type="hidden" name="item_name_'.$k.'" value="'.$value->productname.'">
											<input type="hidden" name="amount_'.$k.'" value="'.$value->unitprice.'">
											<input type="hidden" name="quantity_'.$k.'" value="'.$value->quantity.'">
											<input type="hidden" name="handling_'.$k.'" value="'.$value->shipping.'">';
							      		}

							      	?>
							    </tbody>
							</table>

							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="totalPrice">
								<tbody>
							      <tr>
							        <td align="left" valign="middle" style="width:25%"><strong>Item total</strong></td>
							        <td align="left" valign="middle" style="width:25%"><strong><?php echo $getvalues->product_price; ?></strong></td>
							        <td align="left" valign="middle" style="width:25%"><strong><?php echo $getvalues->total_shipping_cost; ?></strong></td>
							        <td align="left" valign="middle" style="width:25%"><strong><?php echo $getvalues->total_price; ?></strong></td>
							      </tr>
							   </tbody>
							</table>

							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							    <tbody>
							      <tr>
							        <td align="left" valign="middle" style="width:50%"></td>
							        <td align="left" valign="middle" style="width:25%"><strong>Total</strong></td>
							        <td align="left" valign="middle" style="width:25%"><strong>$<?php echo $totpricetrim.' '.$pay_curr; ?></strong></td>
							      </tr>
							      <?php if($fasttrackorder=='yes') { ?>
								      <tr>
								        <td align="left" valign="middle" style="width:50%"></td>
								        <td align="left" valign="middle" style="width:25%"><strong>Fast Track Order Charge ( <?php echo $fast_track_option; ?>% ) </strong></td>
								        <td align="left" valign="middle" style="width:25%"><strong>$<?php echo $fastTrackPriceAdd.' '.$pay_curr; ?></strong></td>
								      </tr>
								      <tr style="border-top: 1px solid #c2c2c2;border-bottom: 1px solid #c2c2c2;">
								        <td align="left" valign="middle" style="width:50%"></td>
								        <td align="left" valign="middle" style="width:25%"><strong>Total </strong></td>
								        <td align="left" valign="middle" style="width:25%"><strong>$<?php echo $showtotprice.' '.$pay_curr; ?></strong></td>
								      </tr>
							      <?php } ?>
							    </tbody>
							</table>
						</div>
					</div>

					<div class="paypalLoginInfo">

						<?php
							$pay_login = get_option('payment_account_login');
							$pay_url = get_option('payment_account_url');
							$pay_header_img = get_option('paypal_head_img');
							
							// $paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
						?>
						<!-- <img src="images/paypalLogin.jpg" height="399" width="490" alt="">	 -->
						<form action="<?php echo $pay_url; ?>" method="post">
							<!-- <input type="hidden" name="cmd" value="_cart"> -->
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="upload" value="1">
							<input type="hidden" name="business" value="<?php echo $pay_login; ?>">
							<input type="hidden" name="cpp_header_image" value="<?php echo $pay_header_img; ?>">
							<input type="hidden" name="currency_code" value="<?php echo $pay_curr;?>">
							<?php
					      		// echo $paypalitems;
					      	?>
							<input type="hidden" name="item_name" value="Total Costs">
							<input type="hidden" name="amount" value="<?php echo $showtotprice; ?>">
							<!-- <input type="hidden" name="quantity_1" value="2">
							<input type="hidden" name="shipping_1" value="6">

							<input type="hidden" name="item_name_2" value="towel">
							<input type="hidden" name="amount_2" value="20">
							<input type="hidden" name="quantity_2" value="4">
							<input type="hidden" name="shipping_2" value="6"> -->

							<input type="hidden" name="cancel_return" value="http://demo.phpgang.com/payment_with_paypal/cancel.php">
						    <input type="hidden" name="return" value="http://demo.phpgang.com/payment_with_paypal/success.php">

						    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">

							<!-- <input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"> -->
						</form>
					</div>

				</div>
		<?php
		die();
	}