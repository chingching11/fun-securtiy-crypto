<?php 
	require_once "access.php";
	require_once "verifyReferer.php";
	
	function mysql_fatal_error($msg){
		echo "$msg"; 
	}	

	// mysql connection
	$connection = new mysqli($hn, $un, $pw, $db);
	if ($connection->connect_error) die(mysql_fatal_error("Sorry"));

	
    //adding record
	if ( isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) ) {

		// check request domain
		if(!same_domain()) die("The request is not made from same domain.");	

        $username = $connection->real_escape_string($_POST['username']);
		$email = $connection->real_escape_string($_POST['email']);
        $password = $connection->real_escape_string($_POST['password']); 
       
        $salt = random_bytes(10);
		$token = hash('ripemd128',"$salt$password");
		
		// prepare sql statement
		$sql = "INSERT INTO UsersInfo VALUES (?, ?, ?, ?)";
		$stmt = $connection->prepare($sql);

		//bind 
		$stmt->bind_param("ssss", $username, $email, $salt, $token);
		
		// execute the statement
		if($stmt->execute()){
			echo "Please <a href='Login.php'>click here </a> to log in.";
		} else {
			echo "Register failed. Try again.";
		}
	}

    echo <<<_END
    <form method="post" action="Register.php" enctype="multipart/form-data">
		
			Username:<input type="text" maxlength="16" name="username">
			Password:<input type="password" maxlength="12" name="password">
			Email: <input type="text" maxlength="64" name="email">
			<input type="submit" value="Signup">
		
    </form>
_END;
        
	$stmt->close();
	$connection->close();
