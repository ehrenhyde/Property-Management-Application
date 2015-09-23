<?php

// Creating a function to connect to the database and bind the values

function db_s_House_addProperty($maxOvernightGuests,$address,$description,$suburb,$state,$postcode,$numCarParks,$numBath,$userfile){
	try{
		$pdo = db_connect();
		
		$size = getimagesize($userfile['tmp_name']);
		$type = $size['mime'];
		$image = fopen($userfile['tmp_name'], 'rb');
		
		$stmt = $pdo->prepare(		
		
			// Calling the add_property_s_house stored procedure from the database
		
			'call add_property_s_house(:maxOvernightGuests,:address,:description,:suburb,:state,:postcode,:numCarParks,:numBath,:image,:image_type);'
				);
		
		$stmt->bindValue(':maxOvernightGuests',$maxOvernightGuests);
		$stmt->bindValue(':address',$address);
		$stmt->bindValue(':description',$description);
		$stmt->bindValue(':suburb',$suburb);
		$stmt->bindValue(':state',$state);
		$stmt->bindValue(':postcode',$postcode);
		$stmt->bindValue(':numCarParks',$numCarParks);
		$stmt->bindValue(':numBath',$numBath);	
		
		$stmt->bindParam(':image', $image, PDO::PARAM_LOB);
		$stmt->bindParam(':image_type', $type);
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_s_House_addProperty';
		echo $e->getMessage();
		exit();
	}
}

?>