CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `search_s_house` AS
    SELECT 
        `s`.`sHouseId` AS `sHouseId`,
        `r`.`roomId` AS `roomId`,
        MAX(`r`.`roomNum`) AS `numberOfRooms`,
        `p`.`address` AS `address`,
        `p`.`description` AS `description`,
        `p`.`suburb` AS `suburb`,
        `p`.`state` AS `state`,
        `p`.`postcode` AS `postcode`,
        `pp`.`image` AS `image`
    FROM
        (((`s_house` `s`
        JOIN `room` `r` ON ((`s`.`sHouseId` = `r`.`sHouseId`)))
        JOIN `property` `p` ON ((`r`.`sHouseId` = `p`.`sHouseId`)))
        JOIN `property_pic` `pp` ON ((`p`.`propertyId` = `pp`.`propertyId`)))