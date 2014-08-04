<?php
chdir( dirname(__FILE__) ); // so we can call outside this folder

require_once "../include/db.php";

require_once "make_log_users.php";
require_once "make_log_bikes.php";
require_once "make_log_entries.php";

//exit(); // if you want to omit populating

require_once "populate_tables.php";