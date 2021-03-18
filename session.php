<?php

	session_start([
		'use_only_cookies' => 1, 
		'cookie_lifetime' => 0,
		'cookie_secure' => 1,
		'cookie_httponly' => 1,
	]);

	

	//prevent hijacking 
	if(isset($_SESSION['check'])) {
		if ($_SESSION['check'] != hash('ripemd128', $_SERVER['HTTP_USER_AGENT']))  {
			different_user();
		}
	}

	//prevent session fixation
	if (!isset($_SESSION['initiated'])) {
		session_regenerate_id();
		$_SESSION['initiated'] = 1;
	}	

	function different_user(){
		destroy_session_and_data();
		die ("Please <a href='login.php'>click here </a> to log in. ");
	}

	//session expire after 10 minutes
	if(time()- $_SESSION['timestamp'] > 600 ){
		destroy_session_and_data();
		header('Location:Login.php');
		die();
	}

    if(isset($_POST['logout'])) {
		destroy_session_and_data();
		header('Location:Login.php');
		die();
	}

    function destroy_session_and_data(){
		$_SESSION = array();
		setcookie(session_name(),'', time() - 2592000, '/');
		session_unset();
		session_destroy();
	}

