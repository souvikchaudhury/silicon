<?php require_once(dirname(__FILE__).'/header.php'); ?>
	<!-- mainBody Start -->
	<?php if( !isset($_SESSION['logged_in_user']) ) { ?>
		<div class="mainBody">
			<div class="wrapper">
				<div class="contentArea">
					<h3>Customer Log in </h3>
					<form action="" class="customerLogIn" method="post" autocomplete="off">
						<p>
							<input type="email" placeholder="Email" id="Themesignin_email" value="" />
							<input type="password" placeholder="Password" id="Themesignin_password" value="" />
							<a href="javascript:void(0);" class="largeButton Themelogin_button">Log in</a>
						</p>
						<p id="theme_error" style="display:none;"></p>
					</form>
					<!-- popup Box Start -->
					<?php if(isset($_GET['stat']) == 'active') { ?>
							<div class="popUpBoxregister popupMode2 registerinventory" id="appspageinventoryimg">
								<!-- <a href="javascript:void(0)" class="closeBtn"></a> -->
								<img src="<?php echo THEMEPATH(); ?>/images/ss.jpg" height="1007" width="962" alt="" />
							</div>
					<?php } ?>
					<!-- popup Box End -->
				</div>
			</div>
		</div>
	<?php 
		} else {
			redirect( THEMEPATH() );
		  }
	?>
	<!-- mainBody End -->
<?php require_once(dirname(__FILE__).'/footer.php'); ?>
