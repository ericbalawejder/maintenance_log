<?php
require_once "include/Session.php";
$session = new Session();

$params = (object) $_REQUEST;

define("PASS","eb2079778"); // simple plain-text password

if ($params->password === PASS) {  // password is correct
  $session->valid = 1;
  $target = ".";
} 
else {
  $session->message = "Failed";
  $target = "login.php";
} 

header( "location: $target" ); 
