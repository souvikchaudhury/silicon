<?php require_once(dirname(__FILE__).'/header.php'); ?>
<!-- mainBody Start -->
	<div class="mainBody">
		<div class="wrapper">
			<div class="contentArea">
				
				<?php
					include_once('menu.php');
				?>
				Yours Order Is Canceled. You will redirect after few second.

				<?php 
				// echo ;
				echo "<meta http-equiv='refresh' content='2;".site_url()."' />"?>
			</div>
		</div>
	</div>
	<!-- mainBody End -->
<?php require_once(dirname(__FILE__).'/footer.php'); ?>