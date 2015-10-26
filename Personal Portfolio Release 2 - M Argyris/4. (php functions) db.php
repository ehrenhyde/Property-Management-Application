<!-- All almost identical for share house 
(code portions taken from db.php file) -->

<?php
//add property updated
function db_addProperty($numOfRooms,$numberofBaths,$numberofcarParks,$defaultRent,$defaultPeriod,$buyingPrice,$address,$description,$suburb,$state,$postcode,$ownerId){
	try{
		$pdo = db_connect();
		
		$stmt = $pdo->prepare(		
					'call add_property(:numOfRooms,:numberofBaths,:numberofcarParks,:defaultRent,:defaultPeriod,:buyingPrice,:address,:description,:suburb,:state,:postcode,:ownerId);'
				);
		

		$stmt->bindValue(':numOfRooms',$numOfRooms);
		$stmt->bindValue(':numberofBaths',$numberofBaths);
		$stmt->bindValue(':numberofcarParks',$numberofcarParks);
		$stmt->bindValue(':defaultRent',$defaultRent);
		$stmt->bindValue(':defaultPeriod',$defaultPeriod);
		$stmt->bindValue(':buyingPrice',$buyingPrice);
		$stmt->bindValue(':address',$address);
		$stmt->bindValue(':description',$description);
		$stmt->bindValue(':suburb',$suburb);
		$stmt->bindValue(':state',$state);
		$stmt->bindValue(':postcode',$postcode);		
		$stmt->bindValue(':ownerId',$ownerId);	
		// OwnerId passed automatically to database procedure 
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_addProperty';
		echo $e->getMessage();
	}
}
?>

<?php
//update whole house
function db_update_w_house($propertyId,$address,$description,$suburb,$state,$postcode,$numBaths,$numCarParks,$numRooms,$defaultRent,$defaultPeriod,$buyingPrice,$dateAvailable,$dateInspection){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
		
					'call update_w_house (:propertyId,:address,:description,:suburb,:state,:postcode,:numBaths,:numCarParks,:numRooms,:defaultRent,:defaultPeriod,:buyingPrice,:dateAvailable,:dateInspection);'
				); // Calling the update_w_house stored procedure from the database

		$stmt->bindValue(':propertyId',$propertyId);
		$stmt->bindValue(':address',$address);
		$stmt->bindValue(':description',$description);
		$stmt->bindValue(':suburb',$suburb);
		$stmt->bindValue(':state',$state);
		$stmt->bindValue(':postcode',$postcode);
		$stmt->bindValue(':numBaths',$numBaths);
		$stmt->bindValue(':numCarParks',$numCarParks);
		$stmt->bindValue(':numRooms',$numRooms);
		$stmt->bindValue(':defaultRent',$defaultRent);
		$stmt->bindValue(':defaultPeriod',$defaultPeriod);
		$stmt->bindValue(':buyingPrice',$buyingPrice);
		$stmt->bindValue(':dateAvailable',$dateAvailable); //send date available to the database procedure
		$stmt->bindValue(':dateInspection',$dateInspection); //send inspection date to the database procedure
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
	}							
}
?>

<?php
function db_getOwnerId($loginId){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select ownerId from v_owner_login '.
						'where loginId = :loginId'
						);
// retrieves the ownerId of the owner currently logged in		
		$stmt->bindValue(':loginId',$loginId);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}
?>
<!-- functions above and below are compared in order to determine if a logged in owner 
is the owner of a specific property and should therefor have extra permissions -->
<?php
function db_getPropertyOwner($ownerId){
	$pdo = db_connect();
	try{
		
		$stmt = $pdo->prepare(
						'select * from v_owner_login '.
						'where ownerId = :ownerId'
						);
//retrieves all owner login information which is connected to the ownerID of the property being viewed
		
		$stmt->bindValue(':ownerId',$ownerId);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}
?>

