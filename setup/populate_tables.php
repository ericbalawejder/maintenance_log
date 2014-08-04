<?php
chdir( dirname(__FILE__) ); // so we can call outside this folder

require_once "../include/db.php";

echo "==> populate\n";
/********************* User 1 ***********************/
$user = R::dispense("logusers");
$user->owner = "Eric Balawejder";
$user->phonenumber = "610-565-4421";
R::store($user);

$bike_1 = R::dispense("logbikes");
$bike_1->year = 2011;
$bike_1->make = "Yamaha";
$bike_1->model = "YZ450f";
$bike_1->userid = $user->id;
R::store($bike_1);

$bike_2 = R::dispense("logbikes");
$bike_2->year = 2009;
$bike_2->make = "Yamaha";
$bike_2->model = "YZ250f";
$bike_2->userid = $user->id;
R::store($bike_2);

$entry_1 = R::dispense("logentries");
$entry_1->entrydate = "";
$entry_1->hours = 0.5;
$entry_1->notes = "Quick once over to check for loose bolts";
$entry_1->bikeid = $bike_1->id;
R::store($entry_1);

$entry_2 = R::dispense("logentries");
$entry_2->entrydate = "";
$entry_2->hours = 0.8;
$entry_2->notes = "Tires";
$entry_2->bikeid = $bike_1->id;
R::store($entry_2);

$entry_3 = R::dispense("logentries");
$entry_3->entrydate = "";
$entry_3->hours = 0.8;
$entry_3->notes = "Brakes";
$entry_3->bikeid = $bike_2->id;
R::store($entry_3);

$entry_4 = R::dispense("logentries");
$entry_4->entrydate = "";
$entry_4->hours = 0.8;
$entry_4->notes = "Graphics";
$entry_4->bikeid = $bike_2->id;
R::store($entry_4);

/********************* User 2 ***********************/
$user = R::dispense("logusers");
$user->owner = "Adam Duke";
$user->phonenumber = "610-565-4421";
R::store($user);

$bike_1 = R::dispense("logbikes");
$bike_1->year = 2010;
$bike_1->make = "Honda";
$bike_1->model = "CRF450R";
$bike_1->userid = $user->id;
R::store($bike_1);

$bike_2 = R::dispense("logbikes");
$bike_2->year = 2006;
$bike_2->make = "Honda";
$bike_2->model = "CRF450R";
$bike_2->userid = $user->id;
R::store($bike_2);

$entry_1 = R::dispense("logentries");
$entry_1->entrydate = "";
$entry_1->hours = 1.5;
$entry_1->notes = "Suspension";
$entry_1->bikeid = $bike_1->id;
R::store($entry_1);

$entry_2 = R::dispense("logentries");
$entry_2->entrydate = "";
$entry_2->hours = 3.0;
$entry_2->notes = "Exhaust";
$entry_2->bikeid = $bike_1->id;
R::store($entry_2);

$entry_3 = R::dispense("logentries");
$entry_3->entrydate = "";
$entry_3->hours = 5;
$entry_3->notes = "Engine rebuild";
$entry_3->bikeid = $bike_2->id;
R::store($entry_3);

$entry_4 = R::dispense("logentries");
$entry_4->entrydate = "";
$entry_4->hours = 3;
$entry_4->notes = "Top end";
$entry_4->bikeid = $bike_2->id;
R::store($entry_4);

/********************* User 3 ***********************/
$user = R::dispense("logusers");
$user->owner = "Chris Shifflet";
$user->phonenumber = "610-565-4421";
R::store($user);

$bike_1 = R::dispense("logbikes");
$bike_1->year = 2011;
$bike_1->make = "Kawasaki";
$bike_1->model = "KX250F";
$bike_1->userid = $user->id;
R::store($bike_1);

$bike_2 = R::dispense("logbikes");
$bike_2->year = 2013;
$bike_2->make = "Kawasaki";
$bike_2->model = "KX250F";
$bike_2->userid = $user->id;
R::store($bike_2);

$entry_1 = R::dispense("logentries");
$entry_1->entrydate = "";
$entry_1->hours = 2.5;
$entry_1->notes = "Wheel bearings";
$entry_1->bikeid = $bike_1->id;
R::store($entry_1);

$entry_2 = R::dispense("logentries");
$entry_2->entrydate = "";
$entry_2->hours = 1;
$entry_2->notes = "Fluid change.";
$entry_2->bikeid = $bike_1->id;
R::store($entry_2);

$entry_3 = R::dispense("logentries");
$entry_3->entrydate = "";
$entry_3->hours = 2;
$entry_3->notes = "Broken spokes";
$entry_3->bikeid = $bike_2->id;
R::store($entry_3);

$entry_4 = R::dispense("logentries");
$entry_4->entrydate = "";
$entry_4->hours = 3;
$entry_4->notes = "Top end";
$entry_4->bikeid = $bike_2->id;
R::store($entry_4);
