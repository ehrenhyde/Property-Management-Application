CREATE TABLE `tenant` (
  `tenantId` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `loginId` int(11) DEFAULT NULL,
  `DOB` date DEFAULT NULL COMMENT 'php takes care of formatting',
  `isMale` tinyint(2) DEFAULT NULL COMMENT 'sexist because Cass scares me',
  PRIMARY KEY (`tenantId`),
  UNIQUE KEY `tennantId_UNIQUE` (`tenantId`),
  KEY `tennant-loginId_idx` (`loginId`),
  CONSTRAINT `tennant-loginId` FOREIGN KEY (`loginId`) REFERENCES `login` (`loginId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
