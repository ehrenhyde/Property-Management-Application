CREATE DEFINER=`root`@`localhost` PROCEDURE `update_s_house`(in psHouseId int,in pAddress varchar(150),in pDescription varchar(250), in psuburb varchar(75), in pstate varchar(45), in ppostcode int(11), in pnumCarParks int(11), in pnumBath int(11), in pmaxOvernightGuests int(11),in pDateAvailable date,in pDateInspection date)
BEGIN
	SET @sHouseId = (	select sHouseId
						from property p
                        where p.sHouseId = psHouseId);
	
    UPDATE property
    SET address = pAddress,
    description = pDescription,/*,
    ownerId = pOwnerId*/
    suburb = psuburb,
    state = pstate,
    postcode = ppostcode,
    numCarParks = pnumCarParks,
    numBath = pnumBath,
    dateAvailable = pDateAvailable,
    dateInspection = pDateInspection
    where sHouseId = psHouseId;
    
    UPDATE s_house
    SET maxOvernightGuests = pmaxOvernightGuests
    where sHouseId = @sHouseId;
END