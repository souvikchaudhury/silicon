<?php
	// ob_flush();
	// ob_clean();
	ob_start();
	session_start();
	include_once(substr(dirname(__FILE__), 0, -8).'/config.php');
	include_once(substr(dirname(__FILE__), 0, -8).'include/allFunctions.php');
	mysql_connect(DBHOST, DBUSER, DBPASS) or die("Error establishing in Database Connection");
	mysql_select_db(DBNAME) or die('Database is not found');
	$table_prefix = PREFIX;

	extract($_POST);

	if($action == 'logoutfunc') {
		unset($_SESSION['user_logged_in']);
		die();
	}

	if($action == 'categoryaddfunc') {
		$terms_table = $table_prefix.'terms';
		if( !empty($datacatid) ) {
			$updateterms_tableSql = "UPDATE $terms_table SET name='".$cat_name."' WHERE term_id = '".$datacatid."'";
			mysql_query($updateterms_tableSql);
		} else {
			$termSlug = strtolower( preg_replace("/[\s_]/", "-", $cat_name) );
			$terms_tableSql = "INSERT INTO $terms_table(name, slug) VALUES('".$cat_name."', '".$termSlug."')";
			mysql_query($terms_tableSql);
			$term_taxonomy_table = $table_prefix.'term_taxonomy';
			$terms_select = "SELECT * FROM $terms_table WHERE slug = '".$termSlug."'";
			$terms_select_query = mysql_query($terms_select);
			$terms_select_Result = mysql_fetch_object($terms_select_query);
			$term_taxonomySql = "INSERT INTO $term_taxonomy_table(term_id, taxonomy, parent) VALUES('".$terms_select_Result->term_id."', '".$termSlug."', '0')";
			mysql_query($term_taxonomySql);
			echo $cat_name;
		  }
		die();
	}

	if($action == 'productquantityaddfunc') {
		/*if( !isset($_SESSION['product_quantity']) ) {
			unset( $_SESSION['product_quantity'] );
			$_SESSION['product_quantity'] = array($quantityno);
		} else {
			array_push($_SESSION['product_quantity'], $quantityno);
		  }

		  $key = count( $_SESSION['product_quantity'] )-1;
		  $value = end( $_SESSION['product_quantity'] );*/
?>
			<p class="smlVer" id="quan<?php echo $previndex; ?>">
				<span><?php echo $quantityno; ?></span>
				<input type="hidden" value="<?php echo $quantityno; ?>" name="quantity[<?php echo $previndex;?>][qnumbr]"/>
				<span>Price $</span>
				<input type="text" value="" name="quantity[<?php echo $previndex;?>][qprice]" required="required" />
				<span class="lastOne">Shipping $</span>
				<input type="text" value="" name="quantity[<?php echo $previndex;?>][qshipping]" required="required" />
				<a href="javascript:void(0);" class="delete" onclick="delete_func(<?php echo $previndex; ?>)">
					<img src="<?php echo site_url(); ?>admin/images/delete.png" alt="">
				</a>
			</p>
<?php
		die();
	}

	if($action == 'showproductfunc') {
		// unset($_SESSION['show_product_id']);
		// $_SESSION['show_product_id'] = $showProductId;
		$productDetails = get_post($showProductId);
		$qty = get_post_meta($showProductId, 'qty');
		$price = get_post_meta($showProductId, 'price');
		$shipping_cost = get_post_meta($showProductId, 'shipping_cost');
		$post_image_url = get_post_meta($showProductId, 'post_image_url');
		$productDetails_arr = array(
								'productId' => $showProductId,
								'itemname' => $productDetails->post_title,
								'itemdesc' => $productDetails->post_content,
								'qty' => $qty,
								'price' => $price,
								'shipping_cost' => $shipping_cost,
								'post_image_url' => $post_image_url
							  );
		echo json_encode($productDetails_arr);
		die();
	}

	if($action == 'deleteproductfunc') {
		delete_post($deleteProductid);
		die();
	}

	if($action == 'productquantitydeletefunc') {
		unset($_SESSION['product_quantity'][$indexNo]);
		die();
	}

	if($action == 'customeraddfunc') {
		$usersTable = PREFIX.'users'; //users table
		$usermetaTable = PREFIX.'usermeta'; //user meta table
		$customer_fullName = explode(' ', $customer_full_name);
		$customer_fullName = implode('_', $customer_fullName);
		$customer_fullName = strtolower($customer_fullName);
		$user_array = array(
						'user_login' => $customer_fullName,
						'user_pass' => $customer_user_password,
						'user_nicename' => $customer_full_name,
						'user_email' => $customer_user_email,
						'display_name' => $customer_full_name,
			          );
		if( empty($datacusid) ) {
			add_user($user_array,'customer'); //creating customer
			$useridSql = "SELECT ID FROM $usersTable WHERE user_login = '".mysql_real_escape_string($customer_fullName)."'";
			$useridSql_result = mysql_query( $useridSql );
			$userid = mysql_fetch_row( $useridSql_result );
			$user_id = $userid[0];
			$userPass = mysql_real_escape_string($customer_user_password);
			add_user_meta($user_id, 'customer_business_name', $customer_business_name);
			add_user_meta($user_id, 'customer_user_mobile', $customer_user_mobile);
			add_user_meta($user_id, 'customer_user_phone', $customer_user_phone);
			add_user_meta($user_id, 'customer_user_password', $userPass);
	    } else {
	    	$updateuser_array = array(
						'user_pass' => $customer_user_password,
						'user_nicename' => $customer_full_name,
						'user_email' => $customer_user_email,
						'display_name' => $customer_full_name,
			          );
	    	$user_Pass = mysql_real_escape_string($customer_user_password);
	    	update_user($datacusid, $updateuser_array); //update customer
	    	update_user_meta($datacusid, 'customer_business_name', $customer_business_name);
			update_user_meta($datacusid, 'customer_user_mobile', $customer_user_mobile);
			update_user_meta($datacusid, 'customer_user_phone', $customer_user_phone);
			update_user_meta($datacusid, 'customer_user_password', $user_Pass);
	      }
		die();
	}

	if($action == 'customershowfunc') {
		$userTable = PREFIX.'users'; //users table
		$userMetaTable = PREFIX.'usermeta'; //user meta table
		$userdetailsSql = "SELECT * FROM $userTable WHERE ID = '".$customerid."'";
		$userdetails = mysql_query($userdetailsSql);
		while ($datauser = mysql_fetch_object($userdetails)) {
			$allDetails[] = $datauser;
		}
		$user_business = get_user_meta($allDetails[0]->ID, 'customer_business_name'); //customer business name
		$user_mobile = get_user_meta($allDetails[0]->ID, 'customer_user_mobile'); //customer mobile no
		$user_phone = get_user_meta($allDetails[0]->ID, 'customer_user_phone'); //customer phone no
		$user_password = get_user_meta($allDetails[0]->ID, 'customer_user_password'); //original password
		$userdetails_arr = array(
							  'display_name' => $allDetails[0]->display_name,
							  'business_name' => $user_business,
							  'user_email' => $allDetails[0]->user_email,
							  'mobile_number' => $user_mobile,
							  'phone_number' => $user_phone,
							  'account_password' => $user_password
			               );
		echo json_encode($userdetails_arr);
		die();
	}

	if($action == 'customerdeletefunc') {
		delete_user($deleteuserid);
		die();
	}

	if($action == 'forgetPasssubmitfunc') {
		$usertable = $table_prefix.'users';
		$forgetpassSql = "SELECT user_login FROM $usersTable WHERE ID = 1 AND user_email = '".$forgetpassEmail."'";
		$forgetpassSql_result = mysql_query( $forgetpassSql );
		// $forgetpassUser = mysql_fetch_row( $forgetpassSql_result );
		// $forgetpass_user = $forgetpassUser[0];
		if(!$forgetpassSql_result) {
			die('The given email id is not registered for administrator');
		} else {
			$forgetpassUser = mysql_fetch_row( $forgetpassSql_result );
			$forgetpass_user = $forgetpassUser[0];
			$pass = uniqid();
			$userUpdateSql = "UPDATE $usertable SET user_pass = '".md5($pass)."' WHERE ID = '1'";
			mysql_query($userUpdateSql);
			$to = $forgetpassEmail;
			$subject = 'Please find the below password:';
			$message = '<p>Username:'.$forgetpass_user.'</p>';
			$message .= '<p>Password:'.$pass.'</p>';
			mail($to, $subject, $message);
		  }
		die();
	}

	if($action == 'inventoryproductquantityaddfunc') {
		/*if( !isset($_SESSION['inventory_product_quantity']) ) {
			unset( $_SESSION['inventory_product_quantity'] );
			$_SESSION['inventory_product_quantity'] = array($inventoryquantityno);
		} else {
			array_push($_SESSION['inventory_product_quantity'], $inventoryquantityno);
		  }
		$key = count( $_SESSION['inventory_product_quantity'] )-1;
		$value = end( $_SESSION['inventory_product_quantity'] );*/
?>
			<p class="smlVer" id="inventoryquan<?php echo $quantityindex; ?>">
				<span><?php echo $inventoryquantityno; ?></span>
				<span>Price $</span>
				<input type="text" value="" name="price_arr[]" required="required" />
				<span class="lastOne">Shipping $</span>
				<input type="text" value="" name="shipping_arr[]" required="required" />
				<a href="javascript:void(0);" class="delete" onclick="inventorydelete_func(<?php echo $quantityindex; ?>)"><img src="<?php echo site_url(); ?>admin/images/delete.png" alt=""></a>
			</p>

<?php
		die();
	}

	if($action == 'inventoryproductquantitydeletefunc') {
		unset($_SESSION['inventory_product_quantity'][$indexNo]);
		die();
	}

	if($action == 'inventoryproductshowfunc') {
		/*$postsTable = $table_prefix.'posts'; //posts table
		$ineventoryproductdetailsSql = "SELECT * FROM $postsTable WHERE ID = '".$inventoryProductid."'";
		$ineventoryproductdetails = mysql_query($ineventoryproductdetailsSql);
		while ($datainventoryproduct = mysql_fetch_object($ineventoryproductdetails)) {
			$allDetails[] = $datainventoryproduct;
		}

		$inventoryQuantity = get_post_meta($allDetails[0]->ID, 'qty'); //inventory product quantity
		$inventoryPrice = get_post_meta($allDetails[0]->ID, 'price'); //inventory product price
		$inventoryShipping = get_post_meta($allDetails[0]->ID, 'shipping_cost'); //inventory product shipping
		// $inventory_img = getPostImage($allDetails[0]->ID); //inventory product image
		$inventoryProductdetails_arr = array(
							  'inventoryItem' => $allDetails[0]->post_title,
							  'inventoryDescription' => $allDetails[0]->post_content,
							  'inventoryQuantity' => $inventoryQuantity,
							  'inventoryPrice' => $inventoryPrice,
							  'inventoryShipping' => $inventoryShipping,
							  'inventory_img' => $inventory_img
			               );
		// $_SESSION['invpid'] = $inventoryProductid; //stores inventory product id
		echo json_encode($inventoryProductdetails_arr);*/
		

		$editproductDetails = get_post($inventoryProductid);
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
			$inventoryPrice = get_post_meta($editproductDetails->ID, 'price'); //inventory product price
			$inventoryShipping = get_post_meta($editproductDetails->ID, 'shipping_cost'); //inventory product shipping

			$inventoryprdcteditarr = array(
										'ID'			=> $editproductDetails->ID,
										'inventoryItem' 	=> $editproductDetails->post_title,
										'inventoryDescription' 	=> $editproductDetails->post_content,
										'inventory_img'=> $editproductImgUrlarr,
										'inventoryQuantity' => $editproductqty,
										'inventoryPrice'	=>$inventoryPrice,
										'inventoryShipping' => $inventoryShipping
				                     );
			echo json_encode($inventoryprdcteditarr);
		}
		die();
	}

	if($action == 'inventoryproductdeletefunc') {
		delete_post($inventoryProductid); //delete inventory product
		die();
	}

	if($action == 'inventorycustomershowfunc') {
		/*unset($_SESSION['inventory_Customer_ID']);
		$userDetails = get_userdata($inventory_Customer_ID); //get user information
		$_SESSION['inventory_Customer_ID'] = $userDetails->ID;
		// $userarr = array($userDetails->ID, $userDetails->display_name);
		// echo json_encode($userarr);
		die();*/
	}
	if($action == 'deletetype'){
		unlink($_GET['file']);
	}

	if($action == 'updatedeletefunc') {
		unlink($file);
		$editproductqty = delete_post_meta($inventoryImgID, $meta_key);	
		die();
	}