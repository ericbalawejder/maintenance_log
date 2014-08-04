<?php
require_once "rb.php";
 
$db = "eb621515";
$user = "eb621515";
$pass = "eb621515";
$url = "mysql:host=localhost;dbname=$db";
 
R::setup( $url, $user, $pass );
R::freeze( true );