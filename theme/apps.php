<?php require_once(dirname(__FILE__).'/header.php'); ?>
	<!-- mainBody Start -->
	<?php if( !isset($_SESSION['logged_in_user']) ) { ?>
			<div class="mainBody">
				<div class="wrapper">
					<div class="contentArea smallGap">
						
						<div class="createAccount">
							<span class="caption"> Don’t have an account ?</span>
							<a class="button" href="<?php echo THEMEPATH(); ?>/registration.php?stat=active">Register</a>
							<a class="button" href="<?php echo THEMEPATH(); ?>/signin.php?stat=active">Log in</a>
						</div>
						
						<div class="inventory">
								<p>
									<a href="javascript:void(0)" class="option1" id="appspageoption1inventory">Click</a>
									<a href="#" class="option2">Tap Reorder to add to a new order</a>
								</p>
								<p>
									<a href="javascript:void(0)" class="option1 accountInfo" id="appspageoption2inventory">Click</a>
									<a href="#" class="option2">Tap to edit and upload new art work</a>
									<a href="#" class="option3">Max file size 32mb</a>
								</p>
								<!-- popup Box Start -->
								<div class="popUpBox popupMode2" id="appspageinventoryimg">
									<a href="javascript:void(0)" class="closeBtn"></a>
									<img src="<?php echo THEMEPATH(); ?>/images/ss.jpg" alt="" />
								</div>
								<!-- popup Box End -->
						</div>
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