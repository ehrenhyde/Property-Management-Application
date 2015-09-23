DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_w_house`(in pPropertyId int,in pAddress varchar(150),in pDescription varchar(250), in psuburb varchar(75), in pstate varchar(45), in ppostcode int(11), in pnumCarParks int(11), in pnumBath int(11), in pNumRooms int,in pDefaultRent int,in pDefaultPeriod int, in pBuyingPrice int)
BEGIN
	SET @wHouseId = (	select wHouseId
						from property p
                        where p.propertyId = pPropertyId);
	
    UPDATE property
    SET address = pAddress,
    description = pDescription,/*,
    ownerId = pOwnerId*/
    suburb = psuburb,
    state = pstate,
    postcode = ppostcode,
    numCarParks = pnumCarParks,
    numBath = pnumBath
    where propertyId = pPropertyId;
    
    UPDATE w_house
    SET numRooms = pNumRooms,
    defaultRent = pDefaultRent,
	defaultPeriod = pDefaultPeriod,
    buyingPrice = pBuyingPrice
    where wHouseId = @wHouseId;
END$$
DELIMITER ;
