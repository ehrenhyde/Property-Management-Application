CREATE 
	ALGORITHM=UNDEFINED 
	DEFINER=`root`@`localhost` 
	SQL SECURITY DEFINER 
VIEW `v_w_house_property_details` AS 
	select 
		`p`.`propertyId` AS `propertyId`,
		`w`.`numRooms` AS `numRooms`,
		`p`.`numCarParks` AS `numCarParks`,
		`p`.`numBath` AS `numBath`,
		`w`.`defaultRent` AS `defaultRent`,
		`w`.`defaultPeriod` AS `defaultRentingPeriod`,
		`w`.`buyingPrice` AS `buyingPrice`,
		`p`.`address` AS `address`,
		`p`.`description` AS `description`,
		`p`.`suburb` AS `suburb`,
		`p`.`state` AS `state`,
		`p`.`postcode` AS `postcode`,
		`p`.`dateAvailable` AS `dateAvailable`,
		`p`.`dateInspection` AS `dateInspection`,
		`p`.`floorplan` AS `floorPlan`,
		`p`.`floorplanImageType` AS `floorPlanImageType`,
		`vbpp`.`image` AS `image`,
		`vbpp`.`image_type` AS `image_type`,
		`p`.`ownerId` AS `ownerId`,
		`p`.`wHouseId` AS `wHouseId`,
		`vol`.`email` AS `ownerEmail` 
	from 
		(((`w_house` `w` join `property` `p` on((`w`.`wHouseId` = `p`.`wHouseId`)))
		 left join `v_best_property_pic` `vbpp` on((`vbpp`.`propertyId` = `p`.`propertyId`))) 
		 left join `v_owner_login` `vol` on((`vol`.`ownerId` = `p`.`ownerId`)));
