CREATE TABLE `property_management` (
  `propertyManagementId` int(11) NOT NULL,
  `propertyId` int(11) NOT NULL,
  `staffId` int(11) NOT NULL,
  PRIMARY KEY (`propertyManagementId`),
  UNIQUE KEY `s_house_managementId_UNIQUE` (`propertyManagementId`),
  KEY `sHouseManagement-sHouseId_idx` (`propertyId`),
  KEY `sHouseManagement-staffId_idx` (`staffId`),
  CONSTRAINT `property_management-propertyId` FOREIGN KEY (`propertyManagementId`) REFERENCES `property` (`propertyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `property_management-staffId` FOREIGN KEY (`staffId`) REFERENCES `staff` (`staffId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='which staff members manage which properties';
