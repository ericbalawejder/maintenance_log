<?php
chdir( dirname(__FILE__) ); // so we can call outside this folder

/************** Straight SQL **********
CREATE TABLE `logbikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `make` varchar(45) NOT NULL,
  `model` varchar(45) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `biketouser_idx` (`userid`),
  CONSTRAINT `biketouser` FOREIGN KEY (`userid`) REFERENCES `logusers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT
***************************************/
$table = "logbikes";

echo "==> drop/create\n";

$sql = "drop table if exists $table";
R::exec($sql);

$table_def = "
id int primary key auto_increment not null,
year int not null,
make varchar(50) not null,
model varchar(50) not null,
userid int not null
";

$sql = "create table $table ($table_def)";
R::exec($sql);
echo "$sql\n";