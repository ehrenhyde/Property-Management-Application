DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_property_s_house`( in pmaxOvernightGuests int(11), in paddress varchar(150),in pdescription varchar(250),in psuburb varchar(75), in pstate varchar(45), in ppostcode int(11),in pnumCarParks int(11),in pnumBath int(11), in pimage LONGBLOB, in pimage_type varchar(45))
BEGIN

start transaction;

insert into s_house(maxOvernightGuests)
values(pmaxOvernightGuests);
set @sHouseId = last_insert_id();

insert into property(propertyId,sHouseId,address,description, suburb, state, postcode, numCarParks, numBath)
values(NULL,@sHouseId,paddress,pdescription,psuburb,pstate,ppostcode,pnumCarParks,pnumBath);
set @propertyId = last_insert_id();

insert into property_pic(propertyId, image, image_type)
values(@propertyId,pimage,pimage_type);

commit;

END$$
DELIMITER ;
