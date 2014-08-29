<?php
	ob_start();
	session_start();
	$_SESSION['site_url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

	require_once(dirname(__FILE__).'/functionsCall.php'); //all functions declaration call with this file
	$configFile = dirname(__FILE__).'/config.php';
	$signupFileLink = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'signup.php';
	
	if( !file_exists($configFile) ) {
		redirect( $signupFileLink );
	} else {
		$indexUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'theme/';
		//require_once(dirname(__FILE__).'/theme/index.php');
		redirect( $indexUrl );
	  }
?>