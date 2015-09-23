<?php
function db_addProperty($numOfRooms,$numberofBaths,$numberofcarParks,$defaultRent,$defaultPeriod,$buyingPrice,$address,$description,$suburb,$state,$postcode,$userfile){
	try{
		$pdo = db_connect();
		//Included these parameters to fetch image type and image data
		$size = getimagesize($userfile['tmp_name']);
		$type = $size['mime'];
		$image = fopen($userfile['tmp_name'], 'rb');
		
		//Included the insertion of the image type and image data into the stored procedure
		$stmt = $pdo->prepare(		
					'call add_property(:numOfRooms,:numberofBaths,:numberofcarParks,:defaultRent,:defaultPeriod,:buyingPrice,:address,:description,:suburb,:state,:postcode,:image_type,:image);'
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
		$stmt->bindParam(':image_type', $type); //Included this binding parameter
		$stmt->bindParam(':image', $image, PDO::PARAM_LOB); //Included this binding parameter
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_addProperty';
		echo $e->getMessage();
	}
}

function db_getWHouseDetails($propertyId){ // get whole house details from propertyId
	//connect to database
	$pdo= db_connect();
	//sql query
	$stmt = $pdo->prepare(
						'select * from v_w_house_property_details '.
						'where propertyId = :propertyId'
						);
	//bind propertyId value
	$stmt->bindValue(':propertyId',$propertyId);
		
	$stmt->execute();
		
	$resultArray = $stmt->fetch();
	//create array from query that is returned
	return $resultArray;
	
}

function db_searchProperties($address,$minRooms,$maxRooms, $minPrice, $maxPrice){
	$pdo = db_connect();
	try{
		
		$sSearchAddress = "%".$address."%";
		$stmt = $pdo->prepare(
						'select * from v_w_house_property_details '.
						'where address like :searchVal '.
						'AND numberOfRooms >= COALESCE(:minRooms,0) '.
						'AND numberOfRooms <= COALESCE(:maxRooms,9999999999) '.
						'AND buyingPrice >= COALESCE(:minPrice,0) '.
						'AND buyingPrice <= COALESCE(:maxPrice,999999999999999) '
						);
		
		$stmt->bindValue(':searchVal',$sSearchAddress);
		$stmt->bindValue(':minRooms',$minRooms);
		$stmt->bindValue(':maxRooms',$maxRooms);
		$stmt->bindValue(':minPrice',$minPrice);
		$stmt->bindValue(':maxPrice',$maxPrice);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetchall();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}

?>