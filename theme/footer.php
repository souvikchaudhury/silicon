		<!-- popup Box Start -->
		<?php 
			if( is_theme_home_page() ) { 
				if( isset($_SESSION['logged_in_user']) ) {
		?>
					<script type="text/javascript">
						function readURL(input) {
		                    if (input.files && input.files[0]) {
		                        var reader = new FileReader();
		                        reader.onload = function (e) {
		                            $('#artWorkImgPreview').attr('src', e.target.result);
		                            $('.artWorkPreview').show();
		                        }
		                        reader.readAsDataURL(input.files[0]);
		                        $('#SubmitButton').show();
		                    }
		                }
					</script>

					<div class="conBoxPopUp" style="display:none;">
						<div class="popUpBox" id="homepagepopup" style="display:block">
							<a href="javascript:void(0)" class="closeBtn"></a>
							<div class="popCol1">
								<div class="popColWrap">
									<h3>Your Inventory</h3>
									<p class="subTitle">
										<span>Click | Tap product to edit &amp; upload</span> your art work  | Max file size 32mb
									</p>
										<span class="imgBox"><img src="#" alt="" id="inventorymainprdct_img" /></span>
										<span class="title" id="inventorymainprdct_title"></span>
									<p>
									</p>
									<hr>
									<ul id="inventoryProductImgul" style="display:none;"><ul>
								</div>
							</div>

							<div class="popCol2">
								
								<div class="popColWrap">									
									<h3>Artwork Upload</h3>
									<div class="artUpload">
										<div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div ></div>
										<div id="output"></div>
									</div>

									<form action="processupload.php" method="post" enctype="multipart/form-data" id="UploadForm">
										<div class="artWorkPreview" style="display:none;">
											<img id="artWorkImgPreview" src="images/black/box.png" height="223" width="347" alt="" />
											<!-- <span class="previewBtn"><a href="#">Artwork</a> | <a href="#">Preview</a></span> -->
										</div>

										<div class="artWorkControl">
											<span class="artWorkTitle" id="artworktitle" style="display:none;"></span><!--  | <a href="#">Delete</a> -->
											<input name="openprdct" type="hidden" id="openprdctid" value="" />
											<input name="userlogin" type="hidden" id="userloginid" value="<?php echo $LoginuserDetails->ID; ?>" />
										</div>

										<div class="artUpload" id="browseInventory" style="display:none;">
											<input name="ImageFile" type="file" id="imgFile" onchange="readURL(this);" />
											<p>Title<input name="inventoryname" type="text" id="inventoryprdctname" required="required" /></p>
											<p>Description<textarea name="inventorydesc" id="inventoryprdctdesc" required="required"></textarea></p>
											<p>Quantity<input name="quantity" type="text" id="inventoryquantity" /></p>
										</div> 
										
										<div class="artControlBtn">
											<a href="javascript:void(0)" id="addInventory">Add to Inventory</a> 
											<input type="submit"  id="SubmitButton" value="Upload Artwork" style="display:none;" /> 
											<a href="javascript:void(0)" id="updateInventory" style="display:none;">Update Inventory</a>
											<a href="javascript:void(0)" id="deleteInventory" style="display:none;">Delete Inventory</a>
										</div>
									</form>
								</div>
								
							</div>

							<div class="popCol3">
								<div class="popColWrap">
									<h3>Order</h3>

									<div class="orderCost">
										<h3 class="title">Order Costs</h3>
										<p><span>Products:</span>$0.00</p>
										<p><span>Delivery:</span>$0.00</p>
										<p><span>Subtotal:</span>$0.00</p>
										<p><span>GST:</span>$0.00</p>
										<p><span>Total:</span>$0.00</p>
									</div>
									
									<div class="payOption">
										<a href="#" class="largeButton">Send &amp; Pay Order</a>
									</div>
									
									<div class="payPal">
										<div class="paypalInfo">
											<p>We accept payments from PayPal only. No PayPal Account ? No problems! Just use your credit card to pay instead. <strong>PayPal accepts payments from all majorcredit cards.</strong></p>
										</div>

										<div class="papalLogo">
											<img src="images/paypal.png"  alt="">
										</div>
										
										<div class="payOption">
											<a href="#" class="largeButton">Fast Track Order</a>
										</div>

									</div>

								</div>
							</div>

						</div>
					</div>
		<?php 
				} 
			}
		?>
		<!-- popup Box End -->
	</body>
</html>