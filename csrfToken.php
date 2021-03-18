<?php

    // get random string
    function csrf_token() {
        return bin2hex(random_bytes(64));
    }
    
    //create csrf token and add it to the session
    // need to update to generate unique token for each form
    function generate_csrf_token(){
        if(!isset($_SESSION["csrf_token"])) {
            // No token present, generate a new one
            $token = csrf_token();
            $_SESSION['csrf_token'] = $token;
        } else {
            // Reuse the token
            $token = $_SESSION["csrf_token"];
        }
        return $token;
    }

    // validate the csrf token
    function csrf_token_is_valid() {
        if(!isset($_POST['csrf_token'])) return false; 
        if(!isset($_SESSION['csrf_token']))  return false; 
        // echo $_POST['csrf_token'];
        // echo "\n";
        // echo $_SESSION['csrf_token'];
        return ($_POST['csrf_token'] === $_SESSION['csrf_token']);
    }