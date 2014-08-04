<?php
chdir( dirname(__FILE__) ); // so we can call outside this folder

/************** Straight SQL **********
CREATE TABLE `logusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(45) NOT NULL,
  `phonenumber` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT
***************************************/
$table = "logusers";

echo "==> drop/create\n";

$sql = "drop table if exists $table";
R::exec($sql);

$table_def = "
id int primary key auto_increment not null,
owner varchar(50) not null,
phonenumber varchar(20) not null
";

$sql = "create table $table ($table_def)";
R::exec($sql);
echo "$sql\n";