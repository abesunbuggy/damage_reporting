CREATE TABLE IF NOT EXISTS `newParts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`prefix` int(11) NOT NULL,
    `partName` VARCHAR(255) NOT NULL,
  `partNumber` INT NOT NULL,
  `quantity` INT NOT NULL,
  `laborHours` INT NOT NULL,
  `shopRate` INT NOT NULL,
  `totalCost` INT NOT NULL,
  `updated_at` timestamp default now() on update now(),
  `created_at` timestamp default now(), 
	PRIMARY KEY (`id`),
    FOREIGN KEY (`prefix`) REFERENCES `FleetType`(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO `newParts`(`prefix`, `partName`,`partNumber`,`quantity`,`laborHours`,`shopRate`,`totalCost`) VALUES (1, "some part name", 488858, 88, 2, 33.3, 4885),( 1, "some part name", 88858, 838, 2, 133.3, 4444)