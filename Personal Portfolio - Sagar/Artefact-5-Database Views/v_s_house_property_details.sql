CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `admin`@`%` 
    SQL SECURITY DEFINER
VIEW `v_s_house_property_details` AS
    SELECT DISTINCT
        `s`.`sHouseId` AS `sHouseId`,
        MAX(`r`.`roomNum`) AS `numberOfRooms`,
        `s`.`maxOvernightGuests` AS `maxOvernightGuests`,
        `p`.`address` AS `address`,
        `p`.`description` AS `description`,
        `p`.`suburb` AS `suburb`,
        `p`.`state` AS `state`,
        `p`.`postcode` AS `postcode`,
        `p`.`numCarParks` AS `numCarParks`,
        `p`.`numBath` AS `numBath`,
        `pp`.`image` AS `image`,
        `pp`.`image_type` AS `image_type`
    FROM
        (((`s_house` `s`
        JOIN `room` `r` ON ((`s`.`sHouseId` = `r`.`sHouseId`)))
        JOIN `property` `p` ON ((`r`.`sHouseId` = `p`.`sHouseId`)))
        JOIN `property_pic` `pp` ON ((`p`.`propertyId` = `pp`.`propertyId`)))