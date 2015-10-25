CREATE DEFINER=`root`@`localhost` PROCEDURE `update_tenant`(in pLoginId integer,in pEmail varchar(45),in pFirstName varchar(45),in pLastName varchar(45), in pDOB date, in pIsMale tinyint(2), in pImage longblob, in pImage_type varchar(45))
BEGIN
	SET @tenantId = (	select tenantId
						from tenant t
                        where t.loginId = pLoginId);
	
   UPDATE login
    SET email = pEmail
    where loginId = pLoginId;
    
    UPDATE tenant
    SET firstName = pFirstName,
    lastName = pLastName,
    DOB = pDOB,
    isMale = pIsMale,  
    image = pImage,
    image_type = pImage_type
    where loginId = pLoginId;    
    
    
END