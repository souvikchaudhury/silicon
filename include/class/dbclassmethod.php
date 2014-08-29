<?php
	// require_once(substr(dirname(__FILE__), 0, -13).'config.php');
	// mysql_connect(DBHOST, DBUSER, DBPASS);
	// mysql_select_db(DBNAME);

	//echo substr(dirname(__FILE__), 0, -13).'config.php';
	//die();
	
	//$dbobj = new DB_Function(); //database object
	//$dbObj = clone $dbobj;
	class DB_Function {
		//public $rick = 'rick';
		//require_once(substr(dirname(__FILE__), 0, -13).'config.php');
		// public $link = mysql_connect(DBHOST, DBUSER, DBPASS);
		// public $db = mysql_select_db(DBNAME);
		// public $posts_table = PREFIX.'posts'; //post table

		function db_connector() {
			require_once(substr(dirname(__FILE__), 0, -13).'config.php');
			$link = mysql_connect(DBHOST, DBUSER, DBPASS);
			$db = mysql_select_db(DBNAME);
			$table_prefix = PREFIX; //table prefix
		}

		public function insert_post($postarg) { //insert post
			// $postsSql = "INSERT INTO $posts_table(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_name, post_parent, post_type) VALUES('".$post_author."', '".$post_date."', '".$post_date_gmt."', '".$post_content."', '".$post_title."', '".$post_status."', '".$post_name."', '".$post_parent."', '".$post_type."')";
			// mysql_query($postsSql);

			$this->db_connector();

			extract($postarg);

			// echo '<pre>';
			// print_r($postarg);

			//echo $post_author;
			echo $posts_table = $this->table_prefix.'posts';
			$postsSql = "INSERT INTO $posts_table(post_author) VALUES('".$post_author."', '".$post_date."')";
			mysql_query($postsSql);
		}
	}
?>