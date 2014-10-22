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
													<!-- <input class="showEdit" type="button"> -->
													<!-- <a href="javascript:void(0);" class="editbtnsave" data-status="name" style="display:none;">Save</a> -->
													<!-- <input class="editBox" type="text" placeholder="Put your name" value="<?php echo $loggedinuserdetails->display_name; ?>" /> -->
												</p>
												<p>
													<label>Email</label>
													<span><?php echo $loggedinuserdetails->user_email; ?></span>
													<!-- <input class="showEdit" type="button"> -->
													<!-- <a href="javascript:void(0);" class="editbtnsave" data-status="email" style="display:none;">Save</a> -->
													<!-- <input class="editBox" type="text" placeholder="Put your email" value="<?php echo $loggedinuserdetails->user_email; ?>" readonly="readonly" /> -->
												</p>
												<p>
													<label>Password</label>
													<span>XXXXXXXX</span>
													<!-- <input class="showEdit" type="button"> -->
													<!-- <a href="javascript:void(0);" class="editbtnsave" data-status="password" style="display:none;">Save</a> -->
													<!-- <input class="editBox" type="password" placeholder="Put your password" value="<?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_password'); ?>" /> -->
												</p>
												<p>
													<label>Business Name</label>
													<span class="bcna"><?php echo get_user_meta($loggedinuserdetails->ID, 'customer_business_name'); ?></span>
													<input class="showEdit" type="button">
													<a href="javascript:void(0);" class="editbtnsave" data-status="buisnessName" style="display:none;">Save</a>
													<input class="editBox bcnb" type="text" placeholder="Put your business name" value="<?php echo get_user_meta($loggedinuserdetails->ID, 'customer_business_name'); ?>" />
												</p>
												<p>
													<label>Mobile / Cell no.</label>
													<span class="mcna"><?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_mobile'); ?></span>
													<input class="showEdit" type="button">
													<a href="javascript:void(0);" class="editbtnsave" data-status="mobile" style="display:none;">Save</a>
													<input class="editBox mcnb	" type="text" placeholder="Put your mobile / cell no." value="<?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_mobile'); ?>" />
												</p>
												<p>
													<label>Phone no.</label>
													<span class="pcna"><?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_phone'); ?></span>
													<input class="showEdit" type="button">
													<a href="javascript:void(0);" class="editbtnsave" data-status="phone" style="display:none;">Save</a>
													<input class="editBox pcnb" type="text" placeholder="Put your phone no." value="<?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_phone'); ?>" />
												</p>
												<p>
													<label>Address</label>
													<span class="acna"><?php echo get_user_meta($loggedinuserdetails->ID, 'customer_address'); ?></span>
													<input class="showEdit" type="button">
													<a href="javascript:void(0);" class="editbtnsave" data-status="address" style="display:none;">Save</a>
													<textarea class="editBox acnb" style="float:right; display:none;margin-left: 130px; width: 250px;height: 60px;" placeholder="Address"><?php echo get_user_meta($loggedinuserdetails->ID, 'customer_address'); ?></textarea>
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
										<a href="javascript:void(0)" data-chk="orderstatus" data-userid="<?php echo $loggedinuserdetails->ID; ?>">Order Status</a>

										<div class="userMenuOptions orderStatus">
											<a class="closeBtn" href="javascript:void(0)"></a>
											<div class="ordercontent">
												
											</div>

										</div>
									</li>
								</ul>
								<div class="clear"></div>
							</div>
				<?php  	
						} 
				?>