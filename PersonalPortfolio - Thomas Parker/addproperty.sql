CREATE DEFINER=`root`@`localhost` PROCEDURE `add_property`( in pnumRooms int(11), in pnumBath int(11), in pnumCarParks int(11), in pdefaultRent int(11), in pdefaultPeriod int(11), in pbuyingPrice int(15),in paddress varchar(150), in pdescription varchar(250), in psuburb varchar(75), in pstate varchar(45), in ppostcode int(11), in pimage_type varchar(45), in pimage LONGBLOB)
BEGIN

start transaction;

insert into w_house(numRooms,defaultRent,defaultPeriod,buyingPrice)
values(pnumRooms,pdefaultRent,pdefaultPeriod,pbuyingPrice);
set @wHouseId = last_insert_id();

insert into property(propertyId, wHouseId,address,description, suburb, state, postcode, numCarParks, numBath)
values(NULL,@wHouseId,paddress,pdescription,psuburb,pstate,ppostcode,pnumCarParks,pnumBath);
set @propertyId = last_insert_id();

insert into property_pic(propertyId, image, image_type)
values(@propertyId,pimage,pimage_type);

commit;

END