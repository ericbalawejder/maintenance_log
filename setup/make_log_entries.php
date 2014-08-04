<?php
chdir( dirname(__FILE__) ); // so we can call outside this folder

/************** Straight SQL **********
CREATE TABLE `logentries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entrydate` varchar(45) DEFAULT NULL,
  `hours` decimal(5,2) DEFAULT NULL,
  `notes` varchar(10000) DEFAULT NULL,
  `bikeid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `bikestoentries_idx` (`bikeid`),
  CONSTRAINT `bikestoentries` FOREIGN KEY (`bikeid`) REFERENCES `logbikes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT
***************************************/
$table = "logentries";

echo "==> drop/create\n";

$sql = "drop table if exists $table";
R::exec($sql);

$table_def = "
id int primary key auto_increment not null,
entrydate varchar(50),
hours decimal not null,
notes text not null,
bikeid int not null
";

$sql = "create table $table ($table_def)";
R::exec($sql);
echo "$sql\n";

