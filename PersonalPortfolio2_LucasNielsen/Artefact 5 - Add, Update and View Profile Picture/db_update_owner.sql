CREATE DEFINER=`root`@`localhost` PROCEDURE `update_owner`(in pLoginId integer, in pEmail varchar(45),in pFirstName varchar(45),in pLastName varchar(45), in pDOB date, in pIsMale tinyint(2), in pimage longblob, in pimage_type varchar(45))
BEGIN
	SET @ownerId = (	select ownerId
						from owners o
                        where o.loginId = pLoginId);
	
	UPDATE login
    SET email = pEmail
    where loginId = pLoginId;
    
    UPDATE owners
    SET firstName = pFirstName,
    lastName = pLastName,
    DOB = pDOB,
    isMale = pIsMale,
    image = pimage,
    image_type = pimage_type    
    where loginId = pLoginId;
    
END