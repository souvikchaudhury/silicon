<?php
	ob_start();
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		include_once(substr(dirname(__FILE__), 0, -5).'config.php');
		mysql_connect(DBHOST, DBUSER, DBPASS) or die("Error establishing in Database Connection");
		mysql_select_db(DBNAME) or die('Database is not found');
		require_once(substr(dirname(__FILE__), 0, -5).'include/allFunctions.php');

		$table_prefix = PREFIX;

		/********** htaccess file creation *********/
// 		$htaccessFile = dirname(__FILE__).'/.htaccess';
// 		if( !file_exists($htaccessFile) ) {
// 			// die('htaccess file can not create');
// 			$site_url = site_url();
// 			$htaccessFileCreate = fopen(".htaccess", "w") or die("Unable to open htaccess file!");
// $htaccesstxt = <<<EOD
// Options +FollowSymlinks
// RewriteEngine on
// RewriteRule ^theme/(.*)$ $site_url$1 [R=301,L]
// RewriteCond /%{REQUEST_FILENAME}.php -f
// RewriteRule ^([a-zA-Z0-9_-\s]+)/$ /$1.php
// EOD;
// 		fwrite($htaccessFileCreate, $htaccesstxt);
// 		fclose($htaccessFileCreate);
// 		@chmod($htaccessFileCreate, 0777);
// 		}
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo blog_pagename(); ?> | Silikon Graphics</title>

	<!-- styles -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo THEMEPATH(); ?>/css/style.css">
	<link rel="stylesheet" id="switch_style" href="<?php echo THEMEPATH(); ?>/css/black.css"> 

	<!-- Scripts  -->
	<script src="<?php echo THEMEPATH(); ?>/js/jquery-1.9.1.min.js"></script>
	<script src="<?php echo THEMEPATH(); ?>/js/jquery.cookie.js"></script>

	<script type="text/javascript" src="<?php echo THEMEPATH(); ?>/js/jquery.form.js"></script>

	<script src="<?php echo THEMEPATH(); ?>/js/core.js"></script>
	<script>
	var themeAjaxVar = '<?php echo THEMEPATH(); ?>/js/themeajax.php';
	var relativepath = '<?php echo str_replace('\\', '/', dirname(__FILE__)); ?>';
	</script>
	<script src="<?php echo THEMEPATH(); ?>/js/custom.js"></script>

</head>
<body>
	<!-- header start -->
	<div class="header">  
		<div class="wrapper">
			<div class="logo">
				<a href="<?php echo THEMEPATH(); ?>"><img src="<?php echo THEMEPATH(); ?>/images/logo.png" alt=""></a>
			</div>
			<div class="nav">
				<ul>
					<li class="active print2u"><a href="<?php echo THEMEPATH(); ?>">Print 2 you</a></li>

					<?php 
						 $LoginuserDetails = isset($_SESSION['logged_in_user']) ? get_userdatabylogin($_SESSION['logged_in_user']) : '';
						if( !isset($_SESSION['logged_in_user']) ) { 
					?>
							<li class="right"><a href="<?php echo THEMEPATH(); ?>/registration.php">Register</a></li>
							<li class="right bdr"><a href="<?php echo THEMEPATH(); ?>/signin.php">Sign In</a></li>
				<?php   } elseif( empty($LoginuserDetails) ) { ?>
							<li class="right"><a href="<?php echo THEMEPATH(); ?>/registration.php">Register</a></li>
							<li class="right bdr"><a href="<?php echo THEMEPATH(); ?>/signin.php">Sign In</a></li>
					<?php 
							unset($_SESSION['logged_in_user']);
						  } else { 
					?>
								<li class="active user"><a href="javascript:void(0);">Welcome <?php echo $LoginuserDetails->display_name; ?></a></li>
								<li class="right signOut"><a href="javascript:void(0);">Sign out</a></li>
					<?php   }  ?>
				</ul>
			</div>
		</div>
	</div>
	<!-- header end -->
<?php
	$terms_table = $table_prefix.'terms';
	$terms_select = "SELECT * FROM $terms_table ORDER BY term_id ASC";
	$terms_select_query = mysql_query($terms_select);
	while($data = mysql_fetch_object($terms_select_query)) {
	  $terms_select_Result[] = $data;
	}
?>