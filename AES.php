<?php

    require_once "session.php";
    
echo <<<_END
		
    <h1> Symmetric Key Crypto </h1>

    <p> The demo uses Advanced Encryption Standard (AES). </p>
		<form method="post" action="AES.php" enctype="multipart/form-data"> 
            Please select option: 
			<input type="radio" name="option" value="encrypt"> Encrypt 
			<input type="radio" name="option" value="decrypt"> Decrypt		
			Message: <input type="text" name="input">
            Key: <input type="text" name="key">
			<input type="submit" value="Submit"> 		
		</form>
_END;

    if(isset($_POST['option']) && isset($_POST['input']) && isset($_POST['key'])){
        $cipher = 'aes-128-gcm';
        $message = $_POST['input'];
        $key = $_POST['key'];

        if($_POST['option']=='encrypt') {
            $key = base64_decode($key);
            $ivlen = openssl_cipher_iv_length($cipher);
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext = openssl_encrypt($message, $cipher, $key, OPENSSL_RAW_DATA , $iv , $tag , "" , 16);
            echo base64_encode( $iv.$tag.$ciphertext);
        }
        
        if($_POST['option']=='decrypt'){
            $data = base64_decode($message);
            $key = base64_decode($key);
            $ivLength = openssl_cipher_iv_length($cipher);
            $iv = substr( $data , 0 , $ivLength );
            $tag = substr( $data , $ivLength , 16 );
            $text = substr( $data , $ivLength+16 );
            echo openssl_decrypt( $text , $cipher , $key , OPENSSL_RAW_DATA , $iv , $tag );
        }
    }
    
?>