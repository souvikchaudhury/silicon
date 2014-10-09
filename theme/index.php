<?php require_once(dirname(__FILE__).'/header.php'); ?>
	<!-- mainBody Start -->
	<div class="mainBody">
		<div class="wrapper">
			<div class="contentArea">
				<?php 
					if( isset($_SESSION['logged_in_user']) ) { 
						$loggedinuserdetails = get_userdatabylogin($_SESSION['logged_in_user']);
				?>
							<div class="userMenu">
								<ul>
									<li>
										<a href="javascript:void(0)">My Account Details</a>
										<div class="accountDetails userMenuOptions">
											<a class="closeBtn" href="javascript:void(0)"></a>
											<h3>Your account details</h3>
											<form action="" class="accDetail" method="post">
												<p>
													<label>Name</label>
													<span><?php echo $loggedinuserdetails->display_name; ?></span>
													<input class="showEdit" type="button">
													<input class="editBox" type="text" placeholder="Put your name" value="<?php echo $loggedinuserdetails->display_name; ?>" />
												</p>
												<p>
													<label>Email</label>
													<span><?php echo $loggedinuserdetails->user_email; ?></span>
													<input class="showEdit" type="button">
													<input class="editBox" type="text" placeholder="Put your email" value="<?php echo $loggedinuserdetails->user_email; ?>" readonly="readonly" />
												</p>
												<p>
													<label>Password</label>
													<span>XXXXXXXX</span>
													<input class="showEdit" type="button">
													<input class="editBox" type="text" placeholder="Put your password" value="<?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_password'); ?>" />
												</p>
												<p>
													<label>Business Name</label>
													<span><?php echo get_user_meta($loggedinuserdetails->ID, 'customer_business_name'); ?></span>
													<input class="showEdit" type="button">
													<input class="editBox" type="text" placeholder="Put your business name" value="<?php echo get_user_meta($loggedinuserdetails->ID, 'customer_business_name'); ?>" />
												</p>
												<p>
													<label>Mobile / Cell no.</label>
													<span><?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_mobile'); ?></span>
													<input class="showEdit" type="button">
													<input class="editBox" type="text" placeholder="Put your mobile / cell no." value="<?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_mobile'); ?>" />
												</p>
												<p>
													<label>Phone no.</label>
													<span><?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_phone'); ?></span>
													<input class="showEdit" type="button">
													<input class="editBox" type="text" placeholder="Put your phone no." value="<?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_phone'); ?>" />
												</p>
											</form>
										</div>
									</li>
						<li>
							<a href="javascript:void(0)" data-chk="myinventory" data-userid="<?php echo $loggedinuserdetails->ID; ?>">My Inventory</a>
							<div class="userMenuOptions myInvenTory">
								
							</div>
						</li>
						<li>
							<a href="javascript:void(0)">Order Status</a>
							<div class="userMenuOptions orderStatus">
								<a class="closeBtn" href="javascript:void(0)"></a>
								<div class="wrap">
									<div class="popCol1">
										<div class="popColWrap">
											<h3>ORDER STATUS</h3>
											<p class="subTitle">
												Products &amp; Qunatity Ordered
											</p>
											<hr>

											<ul>
												<li>
													<div class="leftHSide">
														<a class="box" href="#"><span class="imgBox business1"></span><span class="title">Business Cards</span></a>
														<p>Business Cards 500 qty.</p>
													</div>
													<div class="rightHSide">
														<p class="infoService"><span class="production"></span><span class="infoProduction">Production</span></p>
														<p class="infoService"><span class="complete"></span><span class="infoComplete">Complete</span></p>
													</div>
												</li>

												<li>
													<div class="leftHSide">
														<a class="box" href="#"><span class="imgBox business2"></span><span class="title">Letter Heads</span></a>
														<p>Letter Heads 500 qty.</p>
													</div>
													<div class="rightHSide">
														<p class="infoService"><span class="production"></span><span class="infoProduction">Production</span></p>
														<p class="infoService"><span class="complete"></span><span class="infoComplete">Complete</span></p>
													</div>
												</li>

												<li>
													<div class="leftHSide">
														<a class="box" href="#"><span class="imgBox business4"></span><span class="title">Presentation Folders</span></a>
														<p>Presentation Folders 100 qty.</p>
													</div>
													<div class="rightHSide">
														<p class="infoService"><span class="production"></span><span class="infoProduction">Production</span></p>
														<p class="infoService"><span class="complete"></span><span class="infoComplete">Complete</span></p>
													</div>
												</li>

												<li>
													<div class="leftHSide">
														<a class="box" href="#"><span class="imgBox business3"></span><span class="title">With Compliments Slips</span></a>
														<p>With Compliments Slips 50 qty.</p>
													</div>
													<div class="rightHSide">
														<p class="infoService"><span class="production"></span><span class="infoProduction">Production</span></p>
														<p class="infoService"><span class="complete"></span><span class="infoComplete">Complete</span></p>
													</div>
												</li>
											</ul>

										</div>
									</div>
									<div class="popCol6">
										<div class="popCol6Wrap">
											<h3>Order Number 000187</h3>
											<p class="subTitle"> &nbsp; </p>
											<hr>
											<div class="priceSection">
												<p><span>Products:</span><label>$0.00</label></p>
												<p><span>Delivery:</span>$0.00</p>
												<p><span>Subtotal:</span>$0.00</p>
												<p><span>GST:</span>$0.00</p>
												<p><strong><span>Total:</span>$0.00</strong></p>
											</div>
										</div>
									</div>
									<div class="popCol6">
										<div class="popCol6Wrap">
											<h3>Estimated Delivery Time</h3>
											<p class="subTitle"> &nbsp; </p>
											<hr>
											<div class="deleveryTime">
												<p>Standard Delivary</p>
												<p><span>Monday, 22 July</span></p>
											</div>

											<div class="deleveryTime">
												<p>Standard Delivary</p>
												<p><span>Monday, 22 July</span></p>
											</div>

										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>


					<div class="clear"></div>
				</div>
				<?php } ?>
				<?php
					if( !empty($terms_select_Result) ) {
						foreach($terms_select_Result as $term) {
				?>
							<div class="items">
								<h2><?php echo $term->name; ?></h2>
								<?php
									$catname = $term->slug;
									$termtaxTable = $table_prefix.'term_taxonomy';
									$termrelationshipTable = $table_prefix.'term_relationships';
									$get_termtaxSql = "SELECT term_taxonomy_id FROM $termtaxTable WHERE taxonomy = '".$catname."'";
									$get_termtaxresult = mysql_query($get_termtaxSql);
									$termtaxid = mysql_fetch_row($get_termtaxresult);
									$termtaxid = $termtaxid[0];
									$get_termrelationSql = "SELECT object_id FROM $termrelationshipTable WHERE term_taxonomy_id = '".$termtaxid."'";
									$get_termrelationresult = mysql_query($get_termrelationSql);
									unset($all_objectid);
									while($data = mysql_fetch_object($get_termrelationresult)) {
									  $all_objectid[] = $data;
									}
									$all_objectid = @array_reverse($all_objectid);
									if( !empty($all_objectid) ) {
										foreach($all_objectid as $objectid) {
											$title = get_the_title($objectid->object_id);
											$title_arr = explode('<_>',$title);
											$dispTitle = $title_arr[0];
											$title = str_replace('<_>', ' ', $title);
											?>
											<a id="<?php echo $objectid->object_id; ?>" href="<?php if( !isset($_SESSION['logged_in_user']) ) {echo THEMEPATH(); ?>/apps.php<?php } else {echo 'javascript:void(0)';}?>" class="box <?php if( isset($_SESSION['logged_in_user']) ) {echo 'homepagepopupBox';} ?>" data-id="<?php echo $objectid->object_id; ?>" data-image="<?php echo get_image($objectid->object_id); ?>" data-title="<?php echo $title; ?>">
												<span class="imgBox" style="background-image:url(<?php echo get_image($objectid->object_id);?>);">
													<!-- <img src="<?php echo get_image($objectid->object_id); ?>" alt="" /> -->
												</span>
												<span class="title">
													<?php echo $title; ?>
												</span>
											</a>
											<?php 
										}
									}
								?>
								<div class="clear"></div>
							</div>
				<?php 
						}
					}
				?>

			</div>
		</div>
	</div>
	<!-- mainBody End -->
<?php require_once(dirname(__FILE__).'/footer.php'); ?>
