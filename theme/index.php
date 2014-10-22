<?php require_once(dirname(__FILE__).'/header.php'); ?>
	<!-- mainBody Start -->
	<div class="mainBody">
		<div class="wrapper">
			<div class="contentArea">
				<?php
					include_once('menu.php');

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
												<span class="imgBox imgboxf" style="background-image:url(<?php echo get_image($objectid->object_id);?>);">
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
