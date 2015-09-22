CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `prop`.`v_owner_details` AS
    SELECT 
        `l`.`email` AS `email`,
        `l`.`password` AS `password`,
        `o`.`firstName` AS `firstName`,
        `o`.`lastName` AS `lastName`,
        `o`.`DOB` AS `DOB`,
        `o`.`isMale` AS `isMale`,
        `o`.`loginId` AS `loginId`
    FROM
        (`prop`.`owners` `o`
        JOIN `prop`.`login` `l` ON ((`l`.`loginId` = `o`.`loginId`)))
		
		
------------------------------------------------------------------------
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
		
		
-----------------------------------------------------------------------
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_owner_login_details`(in email varchar(50), in password varchar(25), in firstName varchar(25), in lastName varchar(25), in DOB date, in isMale tinyint(2))
BEGIN

start transaction;

insert into login(loginId,email,password)
values(NULL,email,password);

Set @loginId = last_insert_id();

insert into owners(ownerId,firstName,lastName,loginId,DOB,isMale)
values(NULL,firstName,lastName,@loginId,DOB,isMale);

commit;

END


----------------------------------------------------------------
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_owner`(in pLoginId integer,in pEmail varchar(45),in pPassword varchar(45), in pFirstName varchar(45),in pLastName varchar(45), in pDOB date, in pIsMale tinyint(2))
BEGIN
	SET @ownerId = (	select ownerId
						from owners o
                        where o.loginId = pLoginId);
	
    UPDATE login
    SET email = pEmail,
    password = pPassword
    where loginId = pLoginId;
    
    UPDATE owners
    SET firstName = pFirstName,
    lastName = pLastName,
    DOB = pDOB,
    isMale = pIsMale
    where loginId = pLoginId;
    
END
----------------------------------------------------------------