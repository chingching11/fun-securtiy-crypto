<?php 
 	
	require_once "access.php";
	require_once "session.php";
	
	$conn = new mysqli($hn, $un, $pw, $db);
	if($conn->connect_error) die(mysql_fatal_error("Sorry"));
	
	function mysql_fatal_error($msg){
		echo "$msg"; 
	}	


	if(isset($_SESSION['username'])){
		
		// generate new session id after successful login and everytime user go back to main page
		session_regenerate_id();
		
		echo "Hello " . $_SESSION['username'] . "!";
		echo <<<_END
		
		<h1>Contents</h1>

		<ul>
			<li><a href=Substitution.php>Simple Subtitution Cryptography</a></li>
			<li><a href=AES.php>Symmetric Key Cryptography</a></li>
			<li><a href=PublicKeyCrypt.php>Asymmetric Key Cryptography or Public Key Cryptography</a></li>
		</ul>
_END;

//log out 
	echo <<<_END
		
	<form method="post" action="MainPage.php" enctype="multipart/form-data"> 
	<input type="submit" name = "logout" value="Log out"> 
	</form>
_END;

	}
