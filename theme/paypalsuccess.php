<?php
	ob_start();
	session_start();
 
	if( isset($_SESSION['logged_in_user']) ) { 
		// $loggedinuserdetails = get_userdatabylogin($_SESSION['logged_in_user']);

	   	include_once(substr(dirname(__FILE__), 0, -5).'config.php');
		mysql_connect(DBHOST, DBUSER, DBPASS) or die("Error establishing in Database Connection");
		mysql_select_db(DBNAME) or die('Database is not found');
		require_once(substr(dirname(__FILE__), 0, -5).'include/allFunctions.php');

		$table_prefix = PREFIX;

		// extract($_POST);
		$val = unserialize(stripslashes($_REQUEST['orderedlists']));
		$fastrack = end($val);
		array_pop($val);
		$arr = getinventorycosts($val);
		$getvalues = json_decode($arr);
		$getvalues->fasttrackorder = $fastrack;

		// echo ;

		$loggedinuserdetails = get_userdatabylogin($_SESSION['logged_in_user']);

		$orderstatus['userid'] = $loggedinuserdetails->ID;
		$orderstatus['orderdate'] = date("F j, Y");
		$orderstatus['ordertime'] = date("g:i a");
		$orderstatus['orderdesc'] = json_encode($getvalues);

		$saved_order_id = saveorderstatus($orderstatus);

		$_SESSION['orderinfostatus'] = $saved_order_id;
		$indexUrl = site_url().'theme/paymentinvoice.php';
		redirect( $indexUrl );
		
		/*print_r($_SESSION['orderinfostatus']);
		echo '<pre>';
		print_r($orderstatus);
		print_r(getorderbyid($saved_order_id));
		echo $_SESSION['orderinfostatus'];
		echo '</pre>';*/
	}
?>
