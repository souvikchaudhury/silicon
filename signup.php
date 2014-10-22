<?php 
	ob_start();
	session_start();
	require_once(dirname(__FILE__).'/functionsCall.php'); 
	$configFile = dirname(__FILE__).'/config.php';
	if( !file_exists($configFile) ) {
?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
<style>
	*{
		padding: 0;
		margin: 0;
	}
	body{
		background: #f1f1f1;
		font-family: 'Open Sans', sans-serif;
		padding-bottom: 50px;
	}
	.packet {
    margin: 0 auto;
    max-width: 550px;
	}
	.logo {
    display: block;
    padding-bottom: 30px;
    padding-top: 50px;
    text-align: center;
}
.signup_file h2{
	color: #f00;
    font-size: 22px;
    font-weight: 600;
    padding-bottom: 15px;
    letter-spacing: -1px;
}
.signup_file {
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #dbdbdb;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
    margin-bottom: 30px;
    padding: 2em 3em 3.5em;
}
.db_details {
    border-bottom: 1px dashed #b2b2b2;
    margin-bottom: 20px;
    padding-bottom: 35px;
}
.db_details label, .site_details label{
    display: inline-block;
    font-size: 15px;
    width: 160px;
    font-weight: 600;
}
.signup_file input[type=text], .signup_file input[type=password], .signup_file input[type=email]{
	border: 1px solid #d7d7d7;
  display: inline-block;
  height: 34px;
  line-height: 34px;
  padding: 5px;
  width: 286px;
}
.db_details p, .site_details p{
	padding-bottom: 10px;
}
.signup_file input[type=submit]{
	background: #37539F;
	border:none;
	padding: 7px 14px;
	color: #fff;
	cursor: pointer;
	text-transform: uppercase;
	font-size: 14px;
	border-right: 4px solid #222;
	margin-right: 5px;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}
.signup_file input[type=submit]:hover{
	background: #222;
	border-right: 4px solid #37539F;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}
.signup_file input[type=reset]{
	background: #F57900;
	border:none;
	padding: 7px 14px;
	color: #fff;
	cursor: pointer;
	text-transform: uppercase;
	font-size: 14px;
	border-right: 4px solid #222;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}
.signup_file input[type=reset]:hover{
	background: #222;
	border-right: 4px solid #F57900;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}
.submission {
    margin-top: 30px;
    text-align: center;
}
</style>

<div class="packet">
	<span class="logo"><img src="admin/images/logo.png" alt="Logo"></span>
		<div class="signup_file">
			<form method="post" action="">
				<div class="db_details">
					<h2>Database Details</h2>
					<p>
						<label>Database Name: </label>
						<input type="text" name="db_name" value="" autocomplete="off"required="required" />
					</p>
					<p>
						<label>Database Host: </label>
						<input type="text" name="db_host" value="" autocomplete="off"required="required" />
					</p>
					<p>
						<label>User Name: </label>
						<input type="text" name="user_name" value="" autocomplete="off" required="required" />
					</p>
					<p>
						<label>Password: </label>
						<input type="password" name="password" value="" autocomplete="off"required="required" />
					</p>
					<!-- <p> -->
						<!-- <label>Table Prefix: </label> -->
						<input type="hidden" name="table_prefix" value="printapps_" />
					<!-- </p> -->
				</div>
				<div class="site_details" style="border-bottom: 1px dashed #b2b2b2; margin-bottom: 20px; padding-bottom: 35px;">
					<h2>Site Information</h2>
					<p>
						<label>Site Title: </label>
						<input type="text" name="site_title" value="" required="required" autocomplete="off"/>
					</p>
					<p>
						<label>Admin Username: </label>
						<input type="text" name="admin_username" value="" required="required" autocomplete="off"/>
					</p>
					<p>
						<label>Admin Password: </label>
						<input type="password" name="admin_password" value="" required="required" />
					</p>
					<p>
						<label>Admin Email: </label>
						<input type="email" name="admin_email" value="" required="required" autocomplete="off"/>
					</p>
				</div>
				<div class="site_details">
					<h2>Administration Profile</h2>
					<p>
						<label>Company License Number: </label>
						<input type="text" name="cmplicnse" value="" placeholder="Company License Number" required="required" autocomplete="off"/>
					</p>
					<p>
						<label>Company Name: </label>
						<input type="text" name="cmpName" value="" placeholder="Your License Company Name" required="required" autocomplete="off"/>
					</p>
					<p>
						<label>Address: </label>
						<input type="text" name="cmpAddr" placeholder="Example: Street Name" value="" required="required" autocomplete="off"/>
					</p>
					<p>
						<label>State: </label>
						<input type="text" name="cmpState" placeholder="Give Your State Name" value="" required="required" autocomplete="off"/>
					</p>
					<p>
						<label>Zip Code: </label>
						<input type="text" name="cmpZip" value="" required="required" placeholder="Give Your Zip Code" autocomplete="off"/>
					</p>
					<p>
						<label>Country: </label>
						<input type="text" name="cmpCountry" value="" required="required" placeholder="Give Your Country Name" autocomplete="off"/>
					</p>
					<p>
						<label>Phone No: </label>
						<input type="email" name="cmpPhone" placeholder="Use Country Extention Before Ph. No." value="" required="required" autocomplete="off"/>
					</p>
					<p>
						<label>Company Website: </label>
						<input type="text" name="cmpWebsite" value="" placeholder="Give Your Company Website" required="required" autocomplete="off"/>
					</p>
				</div>
				<div class="submission">
					<input type="submit" name="signup_submit" value="Submit" />
					<input type="reset" name="signup_reset" value="Cancel" />
				</div>
				
			</form>
		</div>
<?php 
	} else {
		redirect(site_url());
      } 
?>		

<?php
	if( @$_POST['signup_submit'] ) {
		extract($_POST);

		/********** Database Connection **********/
		@mysql_connect($db_host, $user_name, $password) or die("Error establishing in Database Connection");
		@mysql_select_db($db_name) or die('Database is not found');


		/********** Config File Creation *********/
		$configFileCreate = fopen("config.php", "w") or die("Unable to open file!");
$configtxt = <<<EOD
<?php
	define("DBNAME", "$db_name");
	define("DBUSER", "$user_name");
	define("DBPASS", "$password");
	define("DBHOST", "$db_host");
	define("PREFIX", "$table_prefix");
?>
EOD;
		fwrite($configFileCreate, $configtxt);
		fclose($configFileCreate);
		@chmod($configFileCreate, 0777); 

		require_once(dirname(__FILE__).'/necessary.php'); //table creation

		/************* Insert Details *************/
		$usersTable = $table_prefix.'users';
		$usermetaTable = $table_prefix.'usermeta';
		$admin_username = mysql_real_escape_string($admin_username);
		$adminUserSql = "INSERT INTO $usersTable(user_login, user_pass, user_nicename, user_email, user_registered, display_name) VALUES('".$admin_username."', '".md5($admin_password)."', '".$admin_username."', '".$admin_email."', '".date("Y-m-d H:i:s")."', '".$admin_username."')";
		$adminUserMetaSql = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('1', 'role', 'administrator')";

		$adminUserMetaSql0 = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('1', 'companylicenseno', '".$cmplicnse."')";
		$adminUserMetaSql1 = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('1', 'companyname', '".$cmpName."')";
		$adminUserMetaSql2 = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('1', 'address', '".$cmpAddr."')";
		$adminUserMetaSql3 = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('1', 'state', '".$cmpState."')";
		$adminUserMetaSql4 = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('1', 'zipcode', '".$cmpZip."')";
		$adminUserMetaSql5 = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('1', 'country', '".$cmpCountry."')";
		$adminUserMetaSql6 = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('1', 'phoneno', '".$cmpPhone."')";
		$adminUserMetaSql7 = "INSERT INTO $usermetaTable(user_id, meta_key, meta_value) VALUES('1', 'companywebsite', '".$cmpWebsite."')";

		mysql_query($adminUserSql);
		mysql_query($adminUserMetaSql);
		
		mysql_query($adminUserMetaSql0);
		mysql_query($adminUserMetaSql1);
		mysql_query($adminUserMetaSql2);
		mysql_query($adminUserMetaSql3);
		mysql_query($adminUserMetaSql4);
		mysql_query($adminUserMetaSql5);
		mysql_query($adminUserMetaSql6);
		mysql_query($adminUserMetaSql7);

		$optionTable = $table_prefix.'options';
		$siteOptionUrl = "INSERT INTO $optionTable(option_name, option_value) VALUES('site_url', '".$_SESSION['site_url']."')";
		$siteOptionTitle = "INSERT INTO $optionTable(option_name, option_value) VALUES('site_title', '".$site_title."')";
		mysql_query($siteOptionUrl);
		mysql_query($siteOptionTitle);

		unset( $_SESSION['site_url'] ); 
		redirect(site_url());
	} 
?>
</div>