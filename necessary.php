<?php
	require_once(dirname(__FILE__).'/config.php');
	$link = mysql_connect(DBHOST, DBUSER, DBPASS);
	$db = mysql_select_db(DBNAME);
	$tablePrefix = PREFIX;

	$comments_sql = "CREATE TABLE IF NOT EXISTS ".$tablePrefix."comments(
		comment_ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		comment_post_ID bigint(20) UNSIGNED NOT NULL,
		comment_author tinytext NOT NULL,
		comment_author_email varchar(100) NOT NULL,
		comment_author_url varchar(200) NOT NULL,
		comment_author_IP varchar(100) NOT NULL,
		comment_date datetime NOT NULL,
		comment_date_gmt datetime NOT NULL,
		comment_content text NOT NULL,
		comment_karma int(11) NOT NULL,
		comment_approved varchar(20) NOT NULL,
		comment_agent varchar(255) NOT NULL,
		comment_type varchar(20) NOT NULL,
		comment_parent bigint(20) UNSIGNED NOT NULL,
		user_id bigint(20) UNSIGNED NOT NULL,
		PRIMARY KEY (comment_ID)
		)";
	mysql_query($comments_sql, $link);

	$commentmeta_sql = "CREATE TABLE IF NOT EXISTS ".$tablePrefix."commentmeta(
		meta_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		comment_id bigint(20) UNSIGNED NOT NULL,
		meta_key varchar(255),
		meta_value longtext,
		PRIMARY KEY(meta_id)
		)";
	mysql_query($commentmeta_sql, $link);

	$links_sql = "CREATE TABLE IF NOT EXISTS ".$tablePrefix."links(
		link_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		link_url varchar(255) NOT NULL,
		link_name varchar(255) NOT NULL,
		link_image varchar(255) NOT NULL,
		link_target varchar(25) NOT NULL,
		link_description varchar(255) NOT NULL,
		link_visible varchar(20) NOT NULL,
		link_owner bigint(20) UNSIGNED NOT NULL,
		link_rating int(11) NOT NULL,
		link_updated datetime NOT NULL,
		link_rel varchar(255) NOT NULL,
		link_notes mediumtext NOT NULL,
		link_rss varchar(255) NOT NULL,
		PRIMARY KEY(link_id)
		)";
	mysql_query($links_sql, $link);

	$options_sql = "CREATE TABLE IF NOT EXISTS ".$tablePrefix."options(
		option_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		option_name varchar(64) NOT NULL,
		option_value longtext NOT NULL,
		autoload varchar(20) NOT NULL,
		PRIMARY KEY (option_id)
		)";
	mysql_query($options_sql, $link);

	$posts_sql = "CREATE TABLE IF NOT EXISTS IF NOT EXISTS IF NOT EXISTS IF NOT EXISTS ".$tablePrefix."posts(
		ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		post_author bigint(20) UNSIGNED NOT NULL,
		post_date datetime NOT NULL,
		post_date_gmt datetime NOT NULL,
		post_content longtext NOT NULL,
		post_title text NOT NULL,
		post_excerpt text NOT NULL,
		post_status varchar(20) NOT NULL,
		comment_status varchar(20) NOT NULL,
		ping_status varchar(20) NOT NULL,
		post_password varchar(20) NOT NULL,
		post_name varchar(200) NOT NULL,
		to_ping text NOT NULL,
		pinged text NOT NULL,
		post_modified datetime NOT NULL,
		post_modified_gmt datetime NOT NULL,
		post_content_filtered longtext NOT NULL,
		post_parent bigint(20) UNSIGNED NOT NULL,
		guid varchar(255) NOT NULL,
		menu_order int(11) NOT NULL,
		post_type varchar(20) NOT NULL,
		post_mime_type varchar(100) NOT NULL,
		comment_count bigint(20) NOT NULL,
		PRIMARY KEY (ID)
		)";
	mysql_query($posts_sql, $link);

	$postmeta_sql = "CREATE TABLE IF NOT EXISTS IF NOT EXISTS IF NOT EXISTS ".$tablePrefix."postmeta(
		meta_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		post_id bigint(20) NOT NULL,
		meta_key varchar(255),
		meta_value longtext,
		PRIMARY KEY(meta_id)
		)";
	mysql_query($postmeta_sql, $link);

	$terms_sql = "CREATE TABLE IF NOT EXISTS IF NOT EXISTS ".$tablePrefix."terms(
		term_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		name varchar(200) NOT NULL,
		slug varchar(200) NOT NULL,
		term_group bigint(10) NOT NULL,
		PRIMARY KEY(term_id)
		)";
	mysql_query($terms_sql, $link);

	$term_taxonomy_sql = "CREATE TABLE IF NOT EXISTS IF NOT EXISTS ".$tablePrefix."term_taxonomy(
		term_taxonomy_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		term_id bigint(20) UNSIGNED NOT NULL,
		taxonomy varchar(32) NOT NULL,
		description longtext NOT NULL,
		parent bigint(20) NOT NULL,
		count bigint(20) NOT NULL,
		PRIMARY KEY(term_taxonomy_id)
		)";
	mysql_query($term_taxonomy_sql, $link);

	$term_relationships_sql = "CREATE TABLE IF NOT EXISTS IF NOT EXISTS ".$tablePrefix."term_relationships(
		ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		object_id bigint(20) UNSIGNED NOT NULL,
		term_taxonomy_id bigint(20) UNSIGNED NOT NULL,
		term_order int(11) NOT NULL,
		PRIMARY KEY(ID)
		)";
	mysql_query($term_relationships_sql, $link);

	$users_sql = "CREATE TABLE IF NOT EXISTS ".$tablePrefix."users(
		ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		user_login varchar(60) NOT NULL,
		user_pass varchar(64) NOT NULL,
		user_nicename varchar(50) NOT NULL,
		user_email varchar(100) NOT NULL,
		user_url varchar(100) NOT NULL,
		user_registered datetime NOT NULL,
		user_activation_key varchar(60) NOT NULL,
		user_status int(11) NOT NULL,
		display_name varchar(250) NOT NULL,
		PRIMARY KEY(ID)
		)";
	mysql_query($users_sql, $link);

	$usermeta_sql = "CREATE TABLE IF NOT EXISTS ".$tablePrefix."usermeta(
		umeta_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		user_id bigint(20) UNSIGNED NOT NULL,
		meta_key varchar(255),
		meta_value longtext,
		PRIMARY KEY(umeta_id)
		)";
	mysql_query($usermeta_sql, $link);

	$order_sql = "CREATE TABLE IF NOT EXISTS ".$tablePrefix."order(
		  id int(11) NOT NULL AUTO_INCREMENT,
		  userid int(11) NOT NULL,
		  orderdate varchar(250) NOT NULL,
		  ordertime varchar(250) NOT NULL,
		  orderdesc longtext NOT NULL,
		  PRIMARY KEY (id)
		)";
	mysql_query($order_sql, $link);
?>