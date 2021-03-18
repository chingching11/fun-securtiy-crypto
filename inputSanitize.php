<?php


//sanitize users input

function sanitize_string($string){
    return filter_var($string, FILTER_SANITIZE_STRING);
}