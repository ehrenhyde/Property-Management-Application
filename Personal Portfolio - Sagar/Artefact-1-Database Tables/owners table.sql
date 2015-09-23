CREATE TABLE `owners` (
  `ownerId` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `loginId` int(11) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `isMale` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`ownerId`),
  UNIQUE KEY `ownerId_UNIQUE` (`ownerId`),
  UNIQUE KEY `personId_UNIQUE` (`firstName`),
  KEY `owner-loginId_idx` (`loginId`),
  CONSTRAINT `owner-loginId` FOREIGN KEY (`loginId`) REFERENCES `login` (`loginId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Owns a property';
