<?php

	require_once "access.php";
	require_once "verifyReferer.php";

	function mysql_fatal_error($msg){
		echo "$msg"; 
	}	

	$connection = new mysqli($hn, $un, $pw, $db);
	if ($connection->connect_error) die(mysql_fatal_error("Sorry"));

	if(isset($_POST['username']) && isset($_POST['password'])){

		// check request domain
		if(!same_domain()) die("The request is not made from same domain.");

		$username = $connection->real_escape_string($_POST['username']);
		$password = $connection->real_escape_string($_POST['password']);
		
		//prepared select statement with ? placeholder
		$sql = "SELECT * FROM UsersInfo WHERE username = ?";
		$stmt = $connection->prepare($sql);

		// Bind the value to the placeholder
  		// The type declaration is "s" for string.
		$stmt->bind_param("s", $username);

		// Execute the statement
		$stmt->execute();

		// get the result
		// get_result() returns true to successful for SELECT, SHOW, DESCRIBE or EXPLAIN queries.
		// it returns false to other successful queries.
		$result = $stmt->get_result(); 
		$stmt->close();
		if(!$result) die(mysql_fatal_error("user not found."));
		
		else {
			$row = $result->fetch_assoc();
			$result->close();
			
			$salt = $row["salt"];
			$token = hash('ripemd128',"$salt$password");
			$hash = $row["token"];

			if($token == $hash){
				// assign session
				session_start([
					'use_only_cookies' => 1,
					'cookie_lifetime' => 0,
					'cookie_secure' => 1,
					'cookie_httponly' => 1,
				]);
				$_SESSION['username'] = $username;
				$_SESSION['check'] = hash('ripemd128', $_SERVER['HTTP_USER_AGENT']);
				$_SESSION['timestamp'] = time();
				
				// close sql connection
				$connection->close();

				//redierct to homepage
				header("Location:MainPage.php");
				die();
			} else {
				echo "Invalid username/password combination";
			}
		}
	}

echo <<<_END
		
		<form method="post" action="Login.php" enctype="multipart/form-data"> 
		<pre>
			To Login 
				Enter username: <input type="text" name="username">
				Enter password: <input type="password" name="password">
				<input type="submit" value="LOG IN"> 
		</pre></form>
_END;

echo <<<_END
		
		<form method="post" action="Register.php" enctype="multipart/form-data"> <pre>
		To Register 
			<input type="submit" value="Sign up"> 
		</pre></form>
_END;

	$connection->close();

