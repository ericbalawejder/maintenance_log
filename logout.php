<?php
require_once "include/Session.php";
$session = new Session();
unset($session->valid);
header( "location: ." );
