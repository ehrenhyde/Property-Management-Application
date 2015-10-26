CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `prop`.`v_poi_shouse` AS
    SELECT 
        `p`.`propertyId` AS `propertyId`,
        `p`.`sHouseId` AS `sHouseId`,
        `poi`.`address` AS `address`,
        `poi`.`suburb` AS `suburb`,
        `poi`.`state` AS `state`,
        `poi`.`postcode` AS `postcode`
    FROM
        (`prop`.`property` `p`
        JOIN `prop`.`points_of_interest` `poi` ON ((`p`.`suburb` = `poi`.`suburb`)))
    WHERE
        (`p`.`sHouseId` > 0)
		
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `prop`.`v_poi_whouse` AS
    SELECT 
        `p`.`propertyId` AS `propertyId`,
        `p`.`wHouseId` AS `wHouseId`,
        `poi`.`address` AS `address`,
        `poi`.`suburb` AS `suburb`,
        `poi`.`state` AS `state`,
        `poi`.`postcode` AS `postcode`
    FROM
        (`prop`.`property` `p`
        JOIN `prop`.`points_of_interest` `poi` ON ((`p`.`suburb` = `poi`.`suburb`)))
    WHERE
        (`p`.`wHouseId` > 0)
		
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `prop`.`v_property_address` AS
    SELECT 
        `p`.`propertyId` AS `propertyId`,
        `p`.`address` AS `address`,
        `p`.`suburb` AS `suburb`,
        `p`.`state` AS `state`,
        `p`.`postcode` AS `postcode`
    FROM
        `prop`.`property` `p`
		
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `prop`.`v_property_saddress` AS
    SELECT 
        `p`.`propertyId` AS `propertyId`,
        `p`.`sHouseId` AS `sHouseId`,
        `p`.`address` AS `address`,
        `p`.`suburb` AS `suburb`,
        `p`.`state` AS `state`,
        `p`.`postcode` AS `postcode`
    FROM
        `prop`.`property` `p`