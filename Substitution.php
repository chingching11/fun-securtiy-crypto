<?php

  require_once "session.php";
  require_once "csrfToken.php";

  $token = 'generate_csrf_token';

  echo <<<_END
		
    <h1> Simple Substitution Cryptography </h1>
		<form method="post" action="Substitution.php" enctype="multipart/form-data"> 	
            Please select option: 
			<input type="radio" name="option" value="encrypt"> Encrypt 
			<input type="radio" name="option" value="decrypt"> Decrypt		
			Message: <input type="text" name="input">
      <input type="hidden" name="csrf_token" value="{$token()}" />
			<input type="submit" value="Submit"> 	
		</form>
_END;

    if(isset($_POST['option']) && isset($_POST['input'])){

      if(!csrf_token_is_valid()) die("csrf token not match");

      $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $codemap = 'UMRSQPBOLEXTZYAKJVCNHDWGIF';

      $inputText = filter_var($_POST['input'], FILTER_SANITIZE_STRING);
      $uppercase = strtoupper($inputText);
      if($_POST['option']=='encrypt') {
        echo strtr($uppercase, $letters, $codemap);
      }
      if($_POST['option']=='decrypt') {
        echo strtr($uppercase, $codemap, $letters);
      }
    } 
    
    // echo sub_encrypt('TO BE OR NOT TO BE.');
    // NA MQ AV YAN NA MQ.
    // echo sub_decrypt('NA MQ AV YAN NA MQ.');
    // TO BE OR NOT TO BE.

    