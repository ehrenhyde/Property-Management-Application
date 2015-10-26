-- All almost identical for share house no need to repeat
--(code portions taken from sql on the server)

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_property`( in pnumRooms int(11), in pnumBath int(11), in pnumCarParks int(11), in pdefaultRent int(11), in pdefaultPeriod int(11), in pbuyingPrice int(15),in paddress varchar(150), in pdescription varchar(250), in psuburb varchar(75), in pstate varchar(45), in ppostcode int(11), in pownerId int(11))
BEGIN

start transaction;

insert into w_house(numRooms,defaultRent,defaultPeriod,buyingPrice)
values(pnumRooms,pdefaultRent,pdefaultPeriod,pbuyingPrice);
set @wHouseId = last_insert_id();

insert into property(propertyId, wHouseId,address,description, suburb, state, postcode, numCarParks, numBath, ownerId)
values(NULL,@wHouseId,paddress,pdescription,psuburb,pstate,ppostcode,pnumCarParks,pnumBath,pownerId);
set @propertyId = last_insert_id();

commit;

END-- Add property procedure has been altered to include ownerId and pass this back to the php file
-------------------------------------------------------------------

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_w_house`(in pPropertyId int,in pAddress varchar(150),in pDescription varchar(250), in psuburb varchar(75), in pstate varchar(45), in ppostcode int(11), in pnumCarParks int(11), in pnumBath int(11), in pNumRooms int,in pDefaultRent int,in pDefaultPeriod int, in pBuyingPrice int,in pDateAvailable date,in pDateInspection date)
BEGIN
	SET @wHouseId = (	select wHouseId
						from property p
                        where p.propertyId = pPropertyId);
	
UPDATE property 
SET 
    address = pAddress,
    description = pDescription,
    suburb = psuburb,
    state = pstate,
    postcode = ppostcode,
    numCarParks = pnumCarParks,
    numBath = pnumBath,
    dateAvailable = pDateAvailable,
    dateInspection = pDateInspection
WHERE
    propertyId = pPropertyId;
    
UPDATE w_house 
SET 
    numRooms = pNumRooms,
    defaultRent = pDefaultRent,
    defaultPeriod = pDefaultPeriod,
    buyingPrice = pBuyingPrice
WHERE
    wHouseId = @wHouseId;
END-- update whole house procuder has been altered to include date available and date inspection into the property tables.
-------------------------------------------------------------------

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `prop`.`v_owner_login` AS
    SELECT 
        `o`.`ownerId` AS `ownerId`,
        `o`.`firstName` AS `firstName`,
        `o`.`lastName` AS `lastName`,
        `l`.`email` AS `email`,
        `l`.`password` AS `password`,
        `l`.`loginId` AS `loginId`
    FROM
        (`prop`.`owners` `o`
        LEFT JOIN `prop`.`login` `l` ON ((`l`.`loginId` = `o`.`loginId`)))
-- This view was used to retrieve ownerId of logged in user
-- This view was also used to retrieve the owner details of 
--the user that is linked as the owner of the property being viewed

-------------------------------------------------------------------