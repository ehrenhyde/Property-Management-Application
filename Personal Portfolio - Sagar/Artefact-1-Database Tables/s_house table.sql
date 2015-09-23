CREATE TABLE `s_house` (
  `sHouseId` int(11) NOT NULL AUTO_INCREMENT,
  `maxOvernightGuests` int(11) DEFAULT NULL,
  PRIMARY KEY (`sHouseId`),
  UNIQUE KEY `sHouseId_UNIQUE` (`sHouseId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='sharehouse';
