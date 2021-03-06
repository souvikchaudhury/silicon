<?php
	//Redirect function
	function redirect($url) {
		ob_start();
		@header("Location:".$url);
		//echo "<meta http-equiv='refresh' content='0;url=".$url."'>";
	} 

	//site url function
	function site_url() {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$table = PREFIX.'options';
		$site_urlSql = "SELECT option_value FROM $table WHERE option_name = 'site_url'";
		$result = mysql_query($site_urlSql, $link);
		$_url = mysql_fetch_row($result);
		return $site_url = $_url[0];
	}

	//theme path function
	function THEMEPATH() {
		return site_url().'theme';
	}

	//add option function
	function add_option($option_name, $option_value) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$optionTable = PREFIX.'options';
		$option_name = mysql_real_escape_string($option_name); //option name
		$option_value = mysql_real_escape_string($option_value); //option value
		$optionquery = "INSERT INTO $optionTable(option_name, option_value) VALUES('".$option_name."', '".$option_value."')";
		mysql_query($optionquery, $link);
	}

	//get option function
	function get_option($option_name) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$optionTable = PREFIX.'options';
		$getoptionquery = "SELECT option_value FROM $optionTable WHERE option_name = '".$option_name."'";
		$result = mysql_query($getoptionquery, $link);
		$option_value = mysql_fetch_row($result);
		return $option_value[0];
	}

	//check option function
	function check_option($option_name) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$optionTable = PREFIX.'options';
		$checkoptionquery = "SELECT * FROM $optionTable WHERE option_name = '".$option_name."'";
		$result = mysql_query($checkoptionquery, $link);
		$option_value = mysql_fetch_row($result);
		return $option_value[0];
	}

	//update option function
	function update_option($option_name, $option_value) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$optionTable = PREFIX.'options';
		$checkoptionquery = "UPDATE $optionTable SET option_value='".$option_value."' WHERE option_name = '".$option_name."'";
		$result = mysql_query($checkoptionquery, $link);
		$option_result = mysql_fetch_row($result);
		return $option_result[0];
	}

	//get post function
	function get_post($productid) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postsTable = PREFIX.'posts';
		$postsSql = "SELECT * FROM $postsTable WHERE ID = '".$productid."'";
		$postsSql_result = mysql_query($postsSql);
		return mysql_fetch_object( $postsSql_result );
	}

	//add post function
	function add_post($prdct_details_arr, $categoryslug, $fromadmin=false) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);

		$postsTable = PREFIX.'posts';
		$postmetaTable = PREFIX.'postmeta';
		$term_taxonomyTable = PREFIX.'term_taxonomy';
		$term_relationshipsTable = PREFIX.'term_relationships';

		extract($prdct_details_arr);
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
		$term_taxonomySql = "SELECT term_taxonomy_id FROM $term_taxonomyTable WHERE taxonomy = '".$categoryslug."'";
		$term_taxonomySql_result = mysql_query( $term_taxonomySql );
		$term_taxonomyid = mysql_fetch_row( $term_taxonomySql_result );
		$term_taxonomy_id = $term_taxonomyid[0]; //getting term taxonomy id
		$term_relationshipsSql = "INSERT INTO $term_relationshipsTable(object_id, term_taxonomy_id) VALUES('".$postid."', '".$term_taxonomy_id."')"; 
		mysql_query($term_relationshipsSql); //adding the relationship between post and term taxonomy
		$postcountSql = "SELECT COUNT(*) FROM $term_relationshipsTable WHERE term_taxonomy_id = '".$term_taxonomy_id."'";
		$postcountresult = mysql_query( $postcountSql );
		$postcount = mysql_fetch_row( $postcountresult );
		$postcountnum = $postcount[0]; //get post number of particular category
		$updatecountSql = "UPDATE $term_taxonomyTable SET count = $postcountnum WHERE taxonomy = '".$categoryslug."'";
		mysql_query($updatecountSql); //post count updated
	}

	//delete post function
	function delete_post($postid) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postsTable = PREFIX.'posts';
		$postmetaTable = PREFIX.'postmeta';
		$term_taxonomyTable = PREFIX.'term_taxonomy';
		$term_relationshipsTable = PREFIX.'term_relationships';
		$deletepostSql = "DELETE FROM $postsTable WHERE ID = '".$postid."'";
		mysql_query($deletepostSql);
		$deletepostmetaSql = "DELETE FROM $postmetaTable WHERE post_id = '".$postid."'";
		mysql_query($deletepostmetaSql);
		$term_taxonomySql = "SELECT term_taxonomy_id FROM $term_relationshipsTable WHERE object_id = '".$postid."'";
		$term_taxonomySql_result = mysql_query( $term_taxonomySql );
		$term_taxonomyid = mysql_fetch_row( $term_taxonomySql_result );
		$term_taxonomy_id = $term_taxonomyid[0]; //getting term taxonomy id
		$term_relationshipsSql = "DELETE FROM $term_relationshipsTable WHERE object_id = '".$postid."'";
		mysql_query($term_relationshipsSql);
		$postcountSql = "SELECT COUNT(*) FROM $term_relationshipsTable WHERE term_taxonomy_id = '".$term_taxonomy_id."'";
		$postcountresult = mysql_query( $postcountSql );
		$postcount = mysql_fetch_row( $postcountresult );
		$postcountnum = $postcount[0]; //get post number of particular category
		$updatecountSql = "UPDATE $term_taxonomyTable SET count = $postcountnum WHERE term_taxonomy_id = '".$term_taxonomy_id."'";
		mysql_query($updatecountSql); //post count updated
	}
	
	function wp_update_post( $postarr = array(), $wp_error = false ) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postsTable = PREFIX.'posts';

		$getpostarr = array();
		$post_ID = $postarr['ID'];
		$setsql = '';
		// First, get all of the original fields
		$post = get_post($post_ID);

		if ($post) {
			//Convert object to array.
			foreach ($post as $key => $value) {
				$getpostarr[$key] = $value;
			}

			foreach ($postarr as $key => $value) {
				if($key!='ID')
					$setsql .= " $key = '".$value."', ";
			}

			$setsql = rtrim(trim($setsql), ",");
			$updateSql = "UPDATE $postsTable SET $setsql WHERE ID=$post_ID";

			return mysql_query($updateSql);

		} else{

			return 'Invalid PostId';

		}	
	}
	//add post meta function
	function add_post_meta($post_id, $meta_key, $meta_value) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postmetaTable = PREFIX.'postmeta';
		$postmetaquery = "INSERT INTO $postmetaTable(post_id, meta_key, meta_value) VALUES('".$post_id."', '".$meta_key."', '".$meta_value."')";
		mysql_query($postmetaquery);
	}

	//get post meta function
	function get_post_meta($postid, $meta_key) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postmetaTable = PREFIX.'postmeta';
		$post_metaSql = "SELECT meta_value FROM $postmetaTable WHERE post_id = '".$postid."' AND meta_key = '".$meta_key."'" ;
		$post_metaSql_result = mysql_query( $post_metaSql );
		$post_meta = mysql_fetch_row( $post_metaSql_result );
		return $post_meta[0];
	}

	//delete post meta function
	function delete_post_meta($postid, $meta_key){
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postmetaTable = PREFIX.'postmeta';
		$post_metaSql = "DELETE FROM $postmetaTable WHERE post_id = '".$postid."' AND meta_key = '".$meta_key."'" ;
		$post_metaSql_result = mysql_query( $post_metaSql );
		return $post_metaSql_result;
	}

	//Get Active Image from postmeta table
	function getPostImage($postid,$isPostArray=false){
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postmetaTable = PREFIX.'postmeta';
		$post_metaSql = "SELECT *  FROM $postmetaTable WHERE post_id = '".$postid."' and meta_key LIKE 'post_image_url_%' ORDER BY meta_id ASC";
		$post_metaSql_result = mysql_query( $post_metaSql );
		$postcount = mysql_num_rows($post_metaSql_result);
		if($postcount){
			if($isPostArray){
				$i=0; $value=array();
				while($row = mysql_fetch_array($post_metaSql_result)) {
				  	$value[$row['meta_key']] = $row['meta_value'];
				  	$i++;
				}

			}else{
				$i=0; $value='';
				while($row = mysql_fetch_array($post_metaSql_result)) {
				  	if($i==0){
				  		$value = $row['meta_value'];
				  	}
				  	$i++;
				}
			}
			return $value;
		}else{
			return 0;
		}
	}
	
	//Get Last postimage Function
	function getLastPostImageNo($post_id){
		$dbImages = getPostImage($post_id,true);
		if($dbImages){
	        ksort($dbImages);
	        end($dbImages);
	        $key = key($dbImages);
	        $get_number = explode("_",$key);
	        array_flip($get_number);
	        $get_number = array_reverse($get_number);
	        $number = $get_number[0]+1;
	        return $number;
    	}else{
    		return 0;
    	}
	}

	//update post meta function
	function update_post_meta($postid, $meta_key, $meta_value) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postmetaTable = PREFIX.'postmeta';
		$post_metaSql = "UPDATE $postmetaTable SET meta_value='".$meta_value."' WHERE post_id = '".$postid."' AND meta_key = '".$meta_key."'";
		$post_metaSql_result = mysql_query( $post_metaSql );
		// $post_meta = mysql_fetch_row( $post_metaSql_result );
		return $post_metaSql_result;
	}

	//post count by slug function
	function postcountbyslug($slugName) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postsTable = PREFIX.'posts';
		$slug = mysql_real_escape_string($slugName);
		$postsSql = "SELECT COUNT(*) FROM $postsTable WHERE post_name LIKE '".$slug."%'";
		$postsSql_value = mysql_query($postsSql);
		$postsSql_result = mysql_fetch_row($postsSql_value);
		return $postsSql_result[0];
	}

	//get post by slug function
	function get_postbyslug($slugName) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postsTable = PREFIX.'posts';
		$slug = mysql_real_escape_string($slugName);
		$postsSql = "SELECT * FROM $postsTable WHERE post_name = '".$slug."'";
		$postsSql_result = mysql_query($postsSql);
		return mysql_fetch_object( $postsSql_result );
	}

	//add inventory product function
	function add_inventory_product($prdct_details_arr) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postsTable = PREFIX.'posts';
		extract($prdct_details_arr);
		$postContent = mysql_real_escape_string($post_content);
		$postTitle = mysql_real_escape_string($post_title);
		$postStatus = mysql_real_escape_string($post_status);
		$postName = mysql_real_escape_string($post_name);
		$postType = mysql_real_escape_string($post_type);
		$postExcerpt = mysql_real_escape_string($post_excerpt);
		$postsSql = "INSERT INTO $postsTable(post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, post_name, post_parent, post_type) VALUES('".$post_author."', '".$post_date."', '".$post_date_gmt."', '".$postContent."', '".$postTitle."', '".$postExcerpt."', '".$postStatus."', '".$postName."', '".$post_parent."', '".$postType."')";
		mysql_query($postsSql); //inserting post
	}

	//get post children function
	function get_post_children($post_parent, $post_type) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$posts_Result = array();
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postsTable = PREFIX.'posts';
		$postType = mysql_real_escape_string($post_type);
		$postsSql = "SELECT * FROM $postsTable WHERE post_parent = '".$post_parent."' AND post_type = '".$post_type."'";
		$postsSql_result = mysql_query($postsSql);
		$num_rows = mysql_num_rows($postsSql_result);
		if($num_rows){
			while($data = mysql_fetch_object($postsSql_result)) {
			  $posts_Result[] = $data;
			}
		}
		return $posts_Result;
	}

	//get post title function
	function get_the_title($postid) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postsTable = PREFIX.'posts';
		$post_titleSql = "SELECT post_title FROM $postsTable WHERE ID = '".$postid."'";
		$post_titleSql_result = mysql_query( $post_titleSql );
		$post_title = mysql_fetch_row( $post_titleSql_result );
		return $post_title[0];
	}

	//get image function
	function get_image($postid) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$postmetaTable = PREFIX.'postmeta';
		$post_metaSql = "SELECT meta_value FROM $postmetaTable WHERE post_id = '".$postid."' AND meta_key = 'post_image_url'" ;
		$post_metaSql_result = mysql_query( $post_metaSql );
		$post_meta = mysql_fetch_row( $post_metaSql_result );
		return $post_meta[0];
	}

//add user function
function add_user($user_details_arr, $role) {
	require_once(substr(dirname(__FILE__), 0, -7).'config.php');
	$link = mysql_connect(DBHOST, DBUSER, DBPASS);
	$db = mysql_select_db(DBNAME);
	$usersTable = PREFIX.'users';
	$usermetaTable = PREFIX.'usermeta';
	extract($user_details_arr);
	$user_login = mysql_real_escape_string($user_login);
	$user_pass = md5($user_pass);
	$user_nicename = mysql_real_escape_string($user_nicename);
	$user_email = mysql_real_escape_string($user_email);
	$user_registered = date("Y-m-d H:i:s");
	$display_name = mysql_real_escape_string($display_name);
	$UserSql = "INSERT INTO $usersTable(user_login, user_pass, user_nicename, user_email, user_registered, display_name) VALUES('".$user_login."', '".$user_pass."', '".$user_nicename."', '".$user_email."', '".$user_registered."', '".$display_name."')";
	mysql_query($UserSql);
	$useridSql = "SELECT ID FROM $usersTable WHERE user_login = '".$user_login."'";
	$useridSql_result = mysql_query( $useridSql );
	$userid = mysql_fetch_row( $useridSql_result );
	$user_id = $userid[0];
	$UserMetaSql = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('".$user_id."', 'role', '".$role."')";
	mysql_query($UserMetaSql);
}

//delete user function
function delete_user($user_id) {
	require_once(substr(dirname(__FILE__), 0, -7).'config.php');
	$link = mysql_connect(DBHOST, DBUSER, DBPASS);
	$db = mysql_select_db(DBNAME);
	$usersTable = PREFIX.'users';
	$usermetaTable = PREFIX.'usermeta';
	$deleteuserSql = "DELETE FROM $usersTable WHERE ID = '".$user_id."'";
	mysql_query($deleteuserSql);
	$deleteusermetaSql = "DELETE FROM $usermetaTable WHERE user_id = '".$user_id."'";
	mysql_query($deleteusermetaSql);
}

//update user function
function update_user($user_id, $updateuser_arr) {
	require_once(substr(dirname(__FILE__), 0, -7).'config.php');
	$link = mysql_connect(DBHOST, DBUSER, DBPASS);
	$db = mysql_select_db(DBNAME);
	$usersTable = PREFIX.'users';
	extract($updateuser_arr);
	$user_pass = md5($user_pass);
	$user_nicename = mysql_real_escape_string($user_nicename);
	$user_email = mysql_real_escape_string($user_email);
	$user_registered = date("Y-m-d H:i:s");
	$display_name = mysql_real_escape_string($display_name);
	$updateuserSql = "UPDATE $usersTable SET user_pass = '".$user_pass."', user_nicename = '".$user_nicename."', user_email = '".$user_email."', user_registered = '".$user_registered."', display_name = '".$display_name."' WHERE ID = '".$user_id."'";
	$updateuserResult = mysql_query($updateuserSql);
	$updateuser_result = mysql_fetch_row($updateuserResult);
	return $updateuser_result[0];
}

//check user meta function
function get_user_meta($user_id, $meta_key) {
	require_once(substr(dirname(__FILE__), 0, -7).'config.php');
	$link = mysql_connect(DBHOST, DBUSER, DBPASS);
	$db = mysql_select_db(DBNAME);
	$usermetaTable = PREFIX.'usermeta';
	$checkmetaquery = "SELECT meta_value FROM $usermetaTable WHERE user_id = '".$user_id."' AND meta_key = '".$meta_key."'";
	$result = mysql_query($checkmetaquery, $link);
	$usermeta_value = mysql_fetch_row($result);
	return $usermeta_value[0];
}

//add user meta function
function add_user_meta($user_id, $meta_key, $meta_value) {
	require_once(substr(dirname(__FILE__), 0, -7).'config.php');
	$link = mysql_connect(DBHOST, DBUSER, DBPASS);
	$db = mysql_select_db(DBNAME);
	$usermetaTable = PREFIX.'usermeta';
	$addusermetaquery = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('".$user_id."', '".$meta_key."', '".$meta_value."')";
	mysql_query($addusermetaquery);
}

//add update user meta function
function update_user_meta($user_id, $meta_key, $meta_value) {
	require_once(substr(dirname(__FILE__), 0, -7).'config.php');
	$link = mysql_connect(DBHOST, DBUSER, DBPASS);
	$db = mysql_select_db(DBNAME);
	$usermetaTable = PREFIX.'usermeta';
	$updateusermetaquery = "UPDATE $usermetaTable SET meta_value='".$meta_value."' WHERE user_id = '".$user_id."' AND meta_key = '".$meta_key."'";
	$updateusermetaResult = mysql_query($updateusermetaquery);
	@$updateusermeta_result = mysql_fetch_row($updateusermetaResult);
	return $updateusermeta_result[0];
}

	//get user by login function
	function get_userdatabylogin($user_login) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$usersTable = PREFIX.'users';
		$usersSql = "SELECT * FROM $usersTable WHERE user_login = '".$user_login."'";
		$usersSql_result = mysql_query($usersSql);
		return mysql_fetch_object( $usersSql_result );
	}

	//get user data function
	function get_userdata($string, $value) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$usersTable = PREFIX.'users';
		$value = mysql_real_escape_string($value);
		if($string == 'login') {
			$usersSql = "SELECT * FROM $usersTable WHERE user_login = '".$value."'";
		} elseif ($string == 'email') {
			  $usersSql = "SELECT * FROM $usersTable WHERE user_email = '".$value."'";
		  } else if($string == 'id') {
		  		$usersSql = "SELECT * FROM $usersTable WHERE ID = '".$value."'";
		    }
		$usersSql_result = mysql_query($usersSql);
		return mysql_fetch_object( $usersSql_result );
	}

	//blog page name function
	function blog_pagename() {
		$filearray = explode('/', $_SERVER['SCRIPT_FILENAME']);
		$filename = end($filearray);
		$namearray = explode('.', $filename);
		$name = reset($namearray);
		echo ucfirst($name);
	}

	//is theme home page function
	function is_theme_home_page() {
		$filearray = explode('/', $_SERVER['SCRIPT_FILENAME']);
		$filename = end($filearray);
		if($filename == 'index.php') 
			return true;
		else
			return false;
	}

	function reArrayFiles(&$file_post) {

	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }

	    return $file_ary;
	}

	function getinventorycosts($allcheckedpostid,$fasttrackorder='no'){

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
					$arr['itemdesc'][$i]['orderstat'] = 'production';
					$arr['itemdesc'][$i]['ordercompleted'] = '';

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
					$arr['itemdesc'][$i]['orderstat'] = 'production';
					$arr['itemdesc'][$i]['ordercompleted'] = '';
				}
				$i++;
			}
			$total_price = $total_shipping_cost + $totprodprice;

			$fast_track_option = get_option('fast_track_order');        	
        	$fastTrackPriceAdd = (($total_price*$fast_track_option)/100);
        	$fasttrackorderprice = floatval($total_price + $fastTrackPriceAdd);
        	 

			$arr['postid'] = $allcheckedpostid;
			$arr['product_price'] = "$".$totprodprice;
			$arr['total_shipping_cost'] = "$".$total_shipping_cost;
			$arr['total_price'] = "$".$total_price;
			$arr['fasttrackorder'] =$fasttrackorder;
			$arr['fasttrackorder_charge'] =$fast_track_option;
			$arr['fasttrackorder_charge_apply'] =$fastTrackPriceAdd;
			$arr['fasttrackorder_price'] =$fasttrackorderprice;
			
			$fullarr = json_encode($arr);
			return $fullarr;
	}

	function saveorderstatus($orderstatus){
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$orderTable = PREFIX.'order';

		// $orderstatus = mysql_real_escape_string($orderstatus); //option value
		$orderstatusquery = "INSERT INTO $orderTable (userid,orderdate,ordertime,orderdesc) VALUES('".$orderstatus['userid']."','".$orderstatus['orderdate']."','".$orderstatus['ordertime']."','".$orderstatus['orderdesc']."')";
		mysql_query($orderstatusquery, $link);
		$id =  mysql_insert_id();
		return $id;
	}
	function getorderbyid($orderid){
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$orderTable = PREFIX.'order';

		$order_fetch_Sql = "SELECT * FROM $orderTable WHERE id = '".$orderid."' ";
		$order_fetch_result = mysql_query($order_fetch_Sql, $link);
		return mysql_fetch_object( $order_fetch_result );
	}

	function get_order_by_userid($userid){
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$orderTable = PREFIX.'order';

		$order_fetch_Sql = "SELECT * FROM $orderTable WHERE userid = '".$userid."' ";
		$order_fetch_result = mysql_query($order_fetch_Sql, $link);
		while ($row = mysql_fetch_object($order_fetch_result)) {
		    $arr[] = $row;
		}
		return $arr;
		// return mysql_fetch_object( $order_fetch_result );
	}

	
	function update_order_table($orderid, $option_name, $option_value) {
		require_once(substr(dirname(__FILE__), 0, -7).'config.php');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		$db = mysql_select_db(DBNAME);
		$orderTable = PREFIX.'order';

		$checkorderquery = "UPDATE $orderTable SET $option_name='".$option_value."' WHERE id = '".$orderid."'";
		mysql_query($checkorderquery, $link);
		// $order_result = mysql_fetch_row($result);
		// return $order_result[0];
	}