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
				$imageurl = get_post_meta($inventoryproduct->ID, 'post_image_url_0');
				$qty = get_post_meta($inventoryproduct->ID, 'qty');
?>
				<li>
					<div class="leftHSide">
						<a href="javascript:void(0)" class="box inventoryImgClass" id="<?php echo $inventoryproduct->ID; ?>">
							<span class="imgBox inventoryproductimgbox" style="padding:0px;">
								<img src="<?php echo $imageurl; ?>" height="146px" width="135px">
							</span>

						</a>
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
			$post_metaSql = "SELECT meta_value  FROM printapps_postmeta WHERE post_id = '".$editproductDetails->ID."' and meta_key LIKE 'post_image_url_%' ORDER BY meta_id ASC";
			$post_metaSql_result = mysql_query( $post_metaSql );
			while($row = mysql_fetch_array($post_metaSql_result)) {
			  $editproductImgUrlarr[] = $row['meta_value'];
			}
			// var_dump($editproductImgUrlarr);
			$editproductqty = get_post_meta($editproductDetails->ID, 'qty');
			$inventoryprdcteditarr = array(
										'post_title' => $editproductDetails->post_title,
										'post_content' => $editproductDetails->post_content,
										'post_image_url' => $editproductImgUrlarr,
										'qty' => $editproductqty
				                     );
			echo json_encode($inventoryprdcteditarr);
		}
		die();
	}
	if($action == 'updatedeletefunc') {

		/*arrange_post_meta_images($inventoryImgID)
		$metakey = 'post_image_url_'.$index;
		$editproductqty = delete_post_meta($inventoryImgID, $metakey);*/
		
		var_dump(arrange_post_meta_images($inventoryImgID));
	}