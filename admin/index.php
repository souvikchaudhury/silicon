<?php
	require_once(dirname(__FILE__).'/header.php');
		/******** login section **********/
		if($_POST['submit_login']) {
			extract($_POST);
			unset($_SESSION['user_logged_in']);

			$userTable = PREFIX."users";
			$adminSql = "SELECT * FROM $userTable WHERE user_login = '".$user_login."'";
			$admin_Result = mysql_query($adminSql);
			$completeAdminResult = mysql_fetch_object($admin_Result);
			if(!empty($completeAdminResult)) {
				if(md5($user_pass) == $completeAdminResult->user_pass) {
					$_SESSION['user_logged_in'] = $completeAdminResult->user_login;
					$dashboard_url = site_url().'admin/category.php';
					redirect($dashboard_url);
				} else {
					echo 'Please provide correct password';
				}
			} else {
				echo 'No user found for this username';
			  }
		}
	?>
	<div class="backend"> <!-- backend start -->
		<?php if( !isset($_SESSION['user_logged_in']) ) { ?>
			<div class="header"> <!-- header start --> 
				<div class="wrap">
					<div class="logo">
						<a href="<?php echo site_url(); ?>" target='_blank'><img src="<?php echo site_url()?>admin/images/logo.png" alt="Silikon Graphics"></a>
					</div>
				</div>
			</div> <!-- header end -->

			<div class="bodyPannel"> <!-- bodypannel start -->
				<div class="wrap">
					<div class="loginSection">
						<h2>Welcome</h2>
						<form action="" method="post">
							<p>
								<input type="text" placeholder="Login" name="user_login" value="" required="required" autocomplete="off" />
								<input type="password" placeholder="Password" name="user_pass" value="" required="required" autocomplete="off" />
							</p>
							<p class="forgetPass"><a href="javascript:void(0)" class="blackBtn">Forgot Login / Password</a> <!-- <a href="javascript:void(0)" class="blackBtn">Resend now</a> --></p>

							<!-- <a href="#" class="pinkBtn loginButton">LOGIN</a> -->
							<input type="submit" name="submit_login" class="pinkBtn loginButton" value="LOGIN" />
						</form>
					
						<div class="passwordContainer">
							<div class="passReset">
								<form action="" method="post">
									<a href="javascript:void(0)" id="close_button"><img src="<?php echo site_url(); ?>admin/images/closeBtn.png" alt="close" /></a>
									<input type="email" placeholder="type email here" id="forgetpassEmail" value="" />
									<a href="javascript:void(0)" class="loginButton" id="forgetpassSubmit">Submit</a>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- bodypannel end -->
		<?php 
			} else { 
				$Dashboard_url = site_url().'admin/category.php';
				redirect($Dashboard_url);
				//echo "<meta http-equiv='refresh' content='0;url=".$Dashboard_url."'>";
		      } 
		?>
	</div> <!-- backend end -->
<?php require_once(dirname(__FILE__).'/footer.php'); ?>