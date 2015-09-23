CREATE TABLE `lease_signature` (
  `leaseSignatureId` int(11) NOT NULL AUTO_INCREMENT,
  `tenantId` int(11) DEFAULT NULL,
  `leaseDocId` int(11) DEFAULT NULL,
  `dateSigned` date DEFAULT NULL,
  PRIMARY KEY (`leaseSignatureId`),
  UNIQUE KEY `leaseSignatureId_UNIQUE` (`leaseSignatureId`),
  KEY `tennantId_idx` (`tenantId`),
  KEY `leaseId_idx` (`leaseDocId`),
  CONSTRAINT `leaseSignature-leaseId` FOREIGN KEY (`leaseDocId`) REFERENCES `lease_doc` (`leaseDocId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `leaseSignature-tennantId` FOREIGN KEY (`tenantId`) REFERENCES `tenant` (`tenantId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='records that a tennant has signed a lease and is now renting a property';
