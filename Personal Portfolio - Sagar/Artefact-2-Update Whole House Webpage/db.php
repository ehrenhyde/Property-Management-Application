<?php 

// Creating a function to connect to the database and bind the values

function db_update_w_house($propertyId,$address,$description,$suburb,$state,$postcode,$numBaths,$numCarParks,/*$ownerId,*/$numRooms,$defaultRent,$defaultPeriod,$buyingPrice){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call update_w_house (:propertyId,:address,:description,:suburb,:state,:postcode,:numBaths,:numCarParks,:numRooms,:defaultRent,:defaultPeriod,:buyingPrice);'
				);

		
		$stmt->bindValue(':propertyId',$propertyId);
		$stmt->bindValue(':address',$address);
		$stmt->bindValue(':description',$description);
		$stmt->bindValue(':suburb',$suburb);
		$stmt->bindValue(':state',$state);
		$stmt->bindValue(':postcode',$postcode);
		$stmt->bindValue(':numBaths',$numBaths);
		$stmt->bindValue(':numCarParks',$numCarParks);
		//$stmt->bindValue(':ownerId',$ownerId);
		$stmt->bindValue(':numRooms',$numRooms);
		$stmt->bindValue(':defaultRent',$defaultRent);
		$stmt->bindValue(':defaultPeriod',$defaultPeriod);
		$stmt->bindValue(':buyingPrice',$buyingPrice);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
	}							
}

?>