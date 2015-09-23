CREATE TABLE `room` (
  `roomId` int(11) NOT NULL AUTO_INCREMENT,
  `roomNum` varchar(6) DEFAULT NULL,
  `sHouseId` int(11) NOT NULL,
  `defaultRent` int(11) NOT NULL COMMENT 'It should be $AUD/week',
  `defaultPeriod` int(11) NOT NULL COMMENT 'Default rental period in number of weeks.',
  PRIMARY KEY (`roomId`),
  UNIQUE KEY `roomId_UNIQUE` (`roomId`),
  KEY `room-SHouseId_idx` (`sHouseId`),
  CONSTRAINT `room-sHouseId` FOREIGN KEY (`sHouseId`) REFERENCES `s_house` (`sHouseId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='room in a sharehouse';
