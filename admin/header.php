<?php
	// ob_flush();
	// ob_clean();
	ob_start();
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<?php 
		include_once(substr(dirname(__FILE__), 0, -5).'/config.php');
		mysql_connect(DBHOST, DBUSER, DBPASS) or die("Error establishing in Database Connection");
		mysql_select_db(DBNAME) or die('Database is not found');
		require_once(substr(dirname(__FILE__), 0, -5).'include/allFunctions.php');
		
		//include(substr(dirname(__FILE__), 0, -5).'include/class/dbclassmethod.php'); //\\
		//SCRIPT_FILENAME

		$table_prefix = PREFIX;
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login | Silikon Graphics</title>
	<!-- Style Sheets -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo site_url()?>admin/css/reset.css">
	<link rel="stylesheet" href="<?php echo site_url()?>admin/css/backend.css">
	<link rel="stylesheet" href="<?php echo site_url()?>admin/css/common.css">
	<link rel="stylesheet" href="<?php echo site_url()?>admin/css/jquery_ui-v1.11.2.css">

	<script>
	var themeAjaxVar = '<?php echo THEMEPATH(); ?>/js/themeajax.php';
	var relativepath = '<?php echo str_replace('\\', '/', dirname(__FILE__)); ?>';
	</script>
	
	<!-- jQuery Library  -->
	<script>var adminAjaxVar = '<?php echo site_url(); ?>admin/js/adminajax.php'</script>
	<script src="<?php echo site_url()?>admin/js/jquery-1.9.1.min.js"></script>
	<script src="<?php echo site_url()?>admin/js/jquery-ui-1.11.2.js"></script>
	<script src="<?php echo site_url()?>admin/js/custom.js"></script>

</head>
<body>
	<?php
		$terms_table = $table_prefix.'terms';
		$terms_select = "SELECT * FROM $terms_table ORDER BY term_id ASC";
		$terms_select_query = mysql_query($terms_select);
		while($data = mysql_fetch_object($terms_select_query)) {
		  $terms_select_Result[] = $data;
		}

		$user_table = $table_prefix.'users';
		$user_metatable = $table_prefix.'usermeta';
		$customerSql = "SELECT * FROM $user_table";
		$data_customers = mysql_query($customerSql);
		while ($datacus = mysql_fetch_object($data_customers)) {
			$all_customers[] = $datacus;
		}
	?>