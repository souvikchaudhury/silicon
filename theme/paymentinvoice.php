<?php require_once(dirname(__FILE__).'/header.php'); ?>
	<!-- mainBody Start -->
	<div class="mainBody">
		<div class="wrapper">
			<div class="contentArea">
				
				<?php
					include_once('menu.php');
				?>
				
				<div class="userAddress">
					<div class="userAddressInfo">
						
						<?php $admndtls = get_userdata('id',1); ?>
						
						<p><?php echo get_user_meta(1,'companylicenseno'); ?></p>
						<p><?php echo get_user_meta(1,'companyname'); ?></p>
						<p><?php echo get_user_meta(1,'address').' '.get_user_meta(1,'state').' '.get_user_meta(1,'zipcode').' '.get_user_meta(1,'country').' P: '. get_user_meta(1,'phoneno'); ?></p>
						<p>E. <?php echo $admndtls->user_email; ?> W. <?php echo get_user_meta(1,'companywebsite'); ?></p>
					</div>
					<hr>
					<?php
						// var_dump($_SESSION['orderinfostatus']);
						if(isset($_SESSION['orderinfostatus']) && isset($_SESSION['logged_in_user'])) {

							$loggedinuserdetails = get_userdatabylogin($_SESSION['logged_in_user']);
							$orderinfostatus = getorderbyid($_SESSION['orderinfostatus']);
							$orderlists = json_decode($orderinfostatus->orderdesc);
							
					?>	
							<div class="orderFinalInfo">
								<table class="addressTable">
									<tbody>
										<tr>
											<td>PRODUCT ORDER NUMBER</td>
											<td><?php echo $orderinfostatus->id; ?></td>
										</tr>

										<tr>
											<td>CLIENT</td>
											<td><?php echo $loggedinuserdetails->display_name; ?></td>
										</tr>

										<tr>
											<td>ADDRESS</td>
											<td>123 Chiefly Drive, Preston, 3072</td>
										</tr>

										<tr>
											<td>CONTACT</td>
											<td><?php echo get_user_meta($loggedinuserdetails->ID, 'customer_business_name'); ?></td>
										</tr>

										<tr>
											<td>EMAIL</td>
											<td><?php echo $loggedinuserdetails->user_email; ?></td>
										</tr>

										<tr>
											<td>PHONE</td>
											<td><?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_phone'); ?> Mobile: <?php echo get_user_meta($loggedinuserdetails->ID, 'customer_user_mobile'); ?></td>
										</tr>

									</tbody>
								</table>
								<hr>
								<div class="orderStatus">
									<div class="wrap">
										<div class="popCol1">
											<div class="popColWrap">
												<h3>ORDER STATUS</h3>
												<p class="subTitle">
													Products &amp; Qunatity Ordered
												</p>
												<hr>

												<ul>
													<?php 
														$pay_curr = get_option('paypal_currency');
														foreach ($orderlists->postid as $key => $value) {

															$post_info = get_post($value);
															$p_title = get_the_title($post_info->post_parent);
															$parentpost_title = str_replace('<_>', ' ', $p_title);

															$title = get_the_title($value);
															$title_arr = explode('<_>',$title);
															$dispTitle = $title_arr[0];

															$imageurl = getPostImage($value);
															$qty = get_post_meta($value, 'qty');
															?>
															<li>
																<div class="leftHSide">
																	<a href="javascript:void(0)" class="box">
																		<span class="imgBox" style="padding:5px 0 0 0;">
																			<img src="<?php echo $imageurl; ?>" alt="" style="height:100px;width:100px;"/>
																		</span>
																		<span class="title"><?php  echo $dispTitle; ?></span>
																	</a>
																	<div class="clear"></div>
																	<p><?php echo $parentpost_title; ?></p>
																	<!-- <p><a href="#" class="dornloadArt">Download Art</a></p> -->
																</div>
															</li>
															<?php
														}
													?>
													
												</ul>

											</div>
										</div>
										<div class="popCol6">
											<div class="popCol6Wrap">
												<h3>&nbsp;</h3>
												<p class="subTitle">Order Number <?php echo $orderinfostatus->id; ?></p>
												<hr>
												<div class="detailOrderInfo">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
													  <tr>
													    <td align="left" valign="middle">Products:</td>
													    <td align="right" valign="middle"><?php echo $orderlists->product_price.' '.$pay_curr; ?></td>
													  </tr>
													  <tr>
													    <td align="left" valign="middle">Delivery:</td>
													    <td align="right" valign="middle"><?php echo $orderlists->total_shipping_cost.' '.$pay_curr; ?></td>
													  </tr>
													  <tr>
													    <td align="left" valign="middle">Total :</td>
													    <td align="right" valign="middle"><?php echo $orderlists->total_price.' '.$pay_curr; ?></td>
													  </tr>
													  <?php if($orderlists->fasttrackorder == 'yes') { ?>
													  <tr>
													    <td align="left" valign="middle">FastTrack Order<br> Charge ( <?php echo $orderlists->fasttrackorder_charge; ?> ) :</td>
													    <td align="right" valign="middle"><?php echo $orderlists->fasttrackorder_charge_apply.' '.$pay_curr; ?></td>
													  </tr>
													  <tr>
													    <td align="left" valign="middle">Total</td>
													    <td align="right" valign="middle"><?php echo $orderlists->fasttrackorder_price.' '.$pay_curr; ?></td>
													  </tr>
													  <?php } ?>
													</table>
												</div>
											</div>
										</div>
										<div class="popCol6">
											<div class="popCol6Wrap">
												<h3>&nbsp; </h3>
												<p class="subTitle">Estimated Delivery Time</p>
												<?php 
													$standard_delivery = strtotime($orderinfostatus->orderdate.' + 15 days'); 
													$fasttrack_delivery = strtotime($orderinfostatus->orderdate.' + 7 days'); 
													
												?>
												<hr>
												<div class="estimateDeliveryInfo">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
													  <tr>
													    <td align="left" valign="middle"><b>Order Date:</b></td>
													    <td align="right" valign="middle"><?php echo $orderinfostatus->orderdate.' '.$orderinfostatus->ordertime; ?></td>
													  </tr>
													  <tr>
													    <td align="left" valign="middle"><b>Standard Delivery:</b></td>
													    <td align="right" valign="middle"><?php echo date("F j, Y", $standard_delivery); ?></td>
													  </tr>
													  <?php if($orderlists->fasttrackorder == 'yes') { ?>
														  <tr>
														    <td align="left" valign="middle"><b>Fast Tracked Delivery:</b></td>
														    <td align="right" valign="middle"><?php echo date("F j, Y", $fasttrack_delivery); ?></td>
														  </tr>
													  <?php } ?>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
				<?php 	} ?>
				</div>

			</div>
		</div>
	</div>
	<!-- mainBody End -->

<?php require_once(dirname(__FILE__).'/footer.php'); ?>