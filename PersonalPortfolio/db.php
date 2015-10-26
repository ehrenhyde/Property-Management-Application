<?php 

function db_connect(){
	$pdo = null;
	try{
		$pdo = new PDO('mysql:host=localhost;dbname=prop','admin','admin');
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}catch(Exception $e){
		 echo 'Connection failed: ' . $e->getMessage()."\n";
	}
	return $pdo;
}

function db_addTenant($email,$password,$firstName,$lastName,$DOB,$isMale,$image,$image_type){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call create_tenant_login_details(:email,:password,:salt,:firstName,:lastName,:DOB,:isMale,:image,:image_type);'
				);
		
		$stmt->bindValue(':email',$email);
		
		$salt = str_pad((string) rand(1, 1000), 4, '0', STR_PAD_LEFT);
		
		$stmt->bindValue(':password',$password);
		$stmt->bindValue(':salt',$salt);
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		$stmt->bindParam(':image', $image, PDO::PARAM_LOB);
		$stmt->bindParam(':image_type', $image_type);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_addTenant';
		echo $e->getMessage();
	}
}
function db_addTenant_temp($confirmCode,$email,$password,$firstName,$lastName,$DOB,$isMale,$userfile){
	try{
		$pdo = db_connect();
		$type = $userfile['type'];
		
		$image = fopen($userfile['tmp_name'], 'rb');
		
		$stmt = $pdo->prepare(		
					'INSERT INTO tenant_temp(confirmCode,email,password,firstName,lastName,DOB,isMale,image,image_type) VALUES (:confirmCode,:email,:password,:firstName,:lastName,:DOB,:isMale,:image,:image_type);'
				);
				
		$stmt->bindValue(':confirmCode',$confirmCode);
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':password',$password);
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		$stmt->bindParam(':image', $image, PDO::PARAM_LOB);
		$stmt->bindParam(':image_type', $type);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_addTenant_temp';
		echo $e->getMessage();
	}
}

function db_uploadnewimage($propertyId,$type,$image){
	try{
		$pdo = db_connect();
		
		
		$stmt = $pdo->prepare(		
					'INSERT INTO property_pic(propertyId,image_type,image)VALUES(:propertyId,:image_type,:image);'
				);
		

		$stmt->bindValue(':propertyId',$propertyId);		
		$stmt->bindParam(':image_type', $type);
		$stmt->bindParam(':image', $image, PDO::PARAM_LOB);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_uploadnewimage';
		echo $e->getMessage();
	}
}

function db_addOwner($email,$password,$firstName,$lastName,$DOB,$isMale,$image,$image_type){
	try{
		$pdo = db_connect();
		
		$stmt = $pdo->prepare(		
					'call create_owner_login_details(:email,:password,:salt,:firstName,:lastName,:DOB,:isMale,:image,:image_type);'
				);
		
		$stmt->bindValue(':email',$email);
		
		$salt = str_pad((string) rand(1, 1000), 4, '0', STR_PAD_LEFT);
		
		$stmt->bindValue(':password',$password);
		$stmt->bindValue(':salt',$salt);
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		$stmt->bindParam(':image', $image, PDO::PARAM_LOB);
		$stmt->bindParam(':image_type', $image_type);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_addOwner';
		echo $e->getMessage();
	}
}

function db_isValidCred($email,$password){
	try{
		$pdo = db_connect();

		$stmt = $pdo->prepare('select isValidCred(:email,:password)');
		
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':password',$password);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();	
		$resultVal = $resultArray[0];
		return $resultVal;
	}catch(PDOException $e){
		$e->getMessage();
	}
}

function db_getIdLogin($email){
	try{
		$pdo = db_connect();
		
		$stmt = $pdo->prepare('select getLoginId(:email)');
		
		$stmt->bindValue(':email',$email);
		
		$stmt->execute();
		
		
		$resultArray = $stmt->fetch();
		
		$resultVal = $resultArray[0];
		
		return $resultVal;
	}catch(PDOException $e){
		$e->getMessage();
	}
}

function db_getPropertyPic($propertyPicId){
	try{
		$pdo = db_connect();
		
		$stmt = $pdo->prepare('select image 
								from property_pic
								where propertyPicId = :propertyPicId');
		
		$stmt->bindValue(':propertyPicId',$propertyPicId);
		
		
		$stmt->execute();
		
		
		$resultArray = $stmt->fetch();
		
		$resultVal = $resultArray[0];
		
		return $resultVal;
	}catch(PDOException $e){
		$e->getMessage();
		exit();
	}
}

function db_updateTenant($loginId,$email,$firstName,$lastName,$DOB,$isMale,$userfile){
	try{
		$pdo = db_connect();
		$type = $userfile['type'];
		
		$image = fopen($userfile['tmp_name'], 'rb');
		$stmt = $pdo->prepare(		
					'call update_tenant(:loginId,:email,:firstName,:lastName,:DOB,:isMale,:image,:image_type);'
				);
		
		$stmt->bindValue(':loginId',$loginId);
		$stmt->bindValue(':email',$email);		
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		$stmt->bindParam(':image', $image, PDO::PARAM_LOB);
		$stmt->bindParam(':image_type', $type);
		
		$stmt->execute();	
		
	}catch(PDOException $e){
		$e->getMessage();
	}
}

function db_updatePassword($loginId,$password){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call update_password(:loginId,:password);'
				);
		
		$stmt->bindValue(':loginId',$loginId);
		$stmt->bindValue(':password',$password);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
	}
}

function db_updateOwner($loginId,$email,$firstName,$lastName,$DOB,$isMale,$userfile){
	try{
		
		$pdo = db_connect();
		
		$type = $userfile['type'];
		
		$image = fopen($userfile['tmp_name'], 'rb');
		$stmt = $pdo->prepare(		
					'call update_owner(:loginId,:email,:firstName,:lastName,:DOB,:isMale,:image,:image_type);'
				);
		
		$stmt->bindValue(':loginId',$loginId);
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		$stmt->bindParam(':image', $image, PDO::PARAM_LOB);
		$stmt->bindParam(':image_type', $type);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
		//exit();
	}
}

function db_getTenantDetails($loginId){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select * from v_tenant_details '.
						'where loginId = :loginId'
						);
		
		$stmt->bindValue(':loginId',$loginId);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}

function db_getSuburbs(){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select* from v_suburb '
						);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetchall();
		return $resultArray;
		
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}

function db_getTenantDetails_temp($confirmCode){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select * from tenant_temp '.
						'where confirmCode = :confirmCode'
						);
		
		$stmt->bindValue(':confirmCode',$confirmCode);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		$count=$stmt->rowCount();
		return array($resultArray,$count);
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}

function db_getpropertyId($numRooms,$numBath,$numCarParks,$defaultRent,$defaultRentingPeriod,$buyingPrice){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select * from v_w_house_property_details where numRooms = :numRooms AND numBath = :numBath AND numCarParks = :numCarParks AND defaultRent = :defaultRent AND defaultRentingPeriod = :defaultRentingPeriod AND buyingPrice = :buyingPrice'
						//'AND buyingPrice = :buyingPrice'						
						);
		
		$stmt->bindValue(':numRooms',$numRooms);
		$stmt->bindValue(':numBath',$numBath);
		$stmt->bindValue(':numCarParks',$numCarParks);
		$stmt->bindValue(':defaultRent',$defaultRent);
		$stmt->bindValue(':defaultRentingPeriod',$defaultRentingPeriod);
		$stmt->bindValue(':buyingPrice',$buyingPrice);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}

function db_getsHouseId($maxOvernightGuests,$postcode,$numCarParks,$numBath){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select * from v_s_house_property_details where maxOvernightGuests = :maxOvernightGuests AND postcode = :postcode AND numCarParks = :numCarParks AND numBath = :numBath'
						//'AND buyingPrice = :buyingPrice'						
						);		
		
		$stmt->bindValue(':maxOvernightGuests',$maxOvernightGuests);
		$stmt->bindValue(':postcode',$postcode);
		$stmt->bindValue(':numCarParks',$numCarParks);
		$stmt->bindValue(':numBath',$numBath);		
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}


function db_getallimages($propertyId){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select * from property_pic '.
						'where propertyId = :propertyId'
						);
		
		$stmt->bindValue(':propertyId',$propertyId);
		
		$stmt->execute();
		
		
		$resultArray = $stmt->fetchAll();
		//$resultArray = array_splice($resultArray,0,1);
		$count=$stmt->rowCount();
		
		return array($resultArray,$count);
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}

function db_getOwnerDetails($loginId){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select * from v_owner_details '.
						'where loginId = :loginId'
						);
		
		$stmt->bindValue(':loginId',$loginId);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}

function db_getOwnerId($loginId){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select ownerId from v_owner_login '.
						'where loginId = :loginId'
						);
		
		$stmt->bindValue(':loginId',$loginId);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}

function db_getPropertyIdFromSHouseId($sHouseId){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select propertyId from property '.
						'where sHouseId = :sHouseId'
						);
		
		$stmt->bindValue(':sHouseId',$sHouseId);
		
		$stmt->execute();
		
		$result = $stmt->fetch();
		$propertyId = $result['propertyId'];
		
		return $propertyId;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}


function db_getPropertyOwner($ownerId){
	$pdo = db_connect();
	try{
		
		$stmt = $pdo->prepare(
						'select * from v_owner_login '.
						'where ownerId = :ownerId'
						);
		
		$stmt->bindValue(':ownerId',$ownerId);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}

function db_helper_numOrNull($val){
	if (is_numeric($val)){
		return $val;
	}else{
		return null;
	}
}

function db_search_w_house($address,$minRooms,$maxRooms, $minPrice, $maxPrice, $minBath, $maxBath, $minCarPark, $maxCarPark, $suburb,$offset = 0,$rowsPerPage=99999){
	
	
	$minRooms = db_helper_numOrNull($minRooms);
	$maxRooms = db_helper_numOrNull($maxRooms);
	$minPrice = db_helper_numOrNull($minPrice);
	$maxPrice = db_helper_numOrNull($maxPrice);
	$minBath = db_helper_numOrNull($minBath);
	$maxBath = db_helper_numOrNull($maxBath);
	$minCarPark = db_helper_numOrNull($minCarPark);
	$maxCarPark = db_helper_numOrNull($maxCarPark);
	
	//Ensure min and max don't cross over
	if ($minRooms != 0 && $maxRooms != null && $maxRooms < $minRooms){
		$maxRooms = $minRooms;	
	}
	
	if ($minPrice != 0 && $maxPrice != null && $maxPrice < $minPrice){
		$maxPrice = $minPrice;
	}
	
	if ($minBath != 0 && $maxBath != null && $maxBath < $minBath){
		$maxBath = $minBath;
	}
	
	if ($minCarPark != 0 && $maxCarPark != null && $maxCarPark < $minCarPark){
		$maxCarPark = $minCarPark;
	}
	
	$pdo = db_connect();
	try{
	/*echo($suburb.$address);*/	
		$sSearchAddress = "%".$address."%";
		$sSearchSuburb = "%".$suburb."%";
		
		$toPrepare = 'call search_w_house(:searchVal,:suburbVal,:minRooms,:maxRooms,:minBath,:maxBath,:minCarPark,:maxCarPark,:minPrice,:maxPrice,:offset,:rowsPerPage)';
		
		$stmt = $pdo->prepare($toPrepare);
		
		$stmt->bindValue(':searchVal',$sSearchAddress);
		$stmt->bindValue(':suburbVal',$sSearchSuburb);
		
		
		$stmt->bindValue(':minRooms',$minRooms);
		$stmt->bindValue(':maxRooms',$maxRooms);
		$stmt->bindValue(':minPrice',$minPrice);
		$stmt->bindValue(':maxPrice',$maxPrice);
		$stmt->bindValue(':minBath',$minBath);
		$stmt->bindValue(':maxBath',$maxBath);
		$stmt->bindValue(':minCarPark',$minCarPark);
		$stmt->bindValue(':maxCarPark',$maxCarPark);
		
	
		$stmt->bindValue(':offset',$offset);
		$stmt->bindValue(':rowsPerPage',$rowsPerPage);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetchall();

		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
		exit();
	}
}
// Creating a function to connect to the database and bind the values

function db_search_s_house($address,$minRooms,$maxRooms,$suburb,$offset = 0,$rowsPerPage=99999){
	$pdo = db_connect();
	
	try{
		
		$minRooms = db_helper_numOrNull($minRooms);
		$maxRooms = db_helper_numOrNull($maxRooms);
	
		
		$sSearchAddress = "%".$address."%";
		$sSearchSuburb = "%".$suburb."%";
		
		$stmt = $pdo->prepare('call search_s_house(:searchAddress,:searchSuburb,:minRooms,:maxRooms,:offset,:rowsPerPage);');
		
		$stmt->bindValue(':searchAddress',$sSearchAddress);
		$stmt->bindValue(':searchSuburb',$sSearchSuburb);
		$stmt->bindValue(':minRooms',$minRooms);
		$stmt->bindValue(':maxRooms',$maxRooms);
		$stmt->bindValue(':offset',$offset);
		$stmt->bindValue(':rowsPerPage',$rowsPerPage);
				
		$stmt->execute();
		
		
		$resultArray = $stmt->fetchall();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
		exit();
	}
}

function db_getWHouseDetails($propertyId){
	$pdo= db_connect();
	$stmt = $pdo->prepare(
						'select * from v_w_house_property_details '.
						'where propertyId = :propertyId'
						);
		
	$stmt->bindValue(':propertyId',$propertyId);
		
	$stmt->execute();
		
	$resultArray = $stmt->fetch();
		
	return $resultArray;
	
}

function db_getAddress($propertyId){
	$pdo= db_connect();
	$stmt = $pdo->prepare(
						'select * from v_property_address '.
						'where propertyId = :propertyId'
						);
		
	$stmt->bindValue(':propertyId',$propertyId);
		
	$stmt->execute();
		
	$resultArray = $stmt->fetch();
	
	$result = $resultArray['address'].' '.$resultArray['suburb'].', '.$resultArray['state'].' '.$resultArray['postcode'];
		
	return $result;
	
}

function db_getSAddress($sHouseId){
	$pdo= db_connect();
	$stmt = $pdo->prepare(
						'select * from v_property_saddress '.
						'where sHouseId = :sHouseId'
						);
		
	$stmt->bindValue(':sHouseId',$sHouseId);
		
	$stmt->execute();
		
	$resultArray = $stmt->fetch();
	
	$result = $resultArray['address'].' '.$resultArray['suburb'].', '.$resultArray['state'].' '.$resultArray['postcode'];
		
	return $result;
	
}

function db_updateFavouriteStatus($loginId,$propertyId,$favouriteStatus){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call update_favourite_status (:loginId,:propertyId,:favouriteStatus);'
				);

		$stmt->bindValue(':loginId',$loginId);
		$stmt->bindValue(':propertyId',$propertyId);
		$stmt->bindValue(':favouriteStatus',$favouriteStatus);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
		exit();
	}
}

function db_getIsFavourite($loginId,$propertyId){
	try{
		$pdo = db_connect();

		$stmt = $pdo->prepare('select isFavourite(:loginId,:propertyId)');
		
		$stmt->bindValue(':loginId',$loginId);
		$stmt->bindValue(':propertyId',$propertyId);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();	
		$resultVal = $resultArray[0];
		return $resultVal;
	}catch(PDOException $e){
		$e->getMessage();
		exit();
	}
}

function db_getSPOI($sHouseId){
	$pdo= db_connect();
	
	try{
		$stmt = $pdo->prepare(
						'select * from v_poi_shouse '.
						'where sHouseId = :sHouseId'
						);
		
	$stmt->bindValue(':sHouseId',$sHouseId);
		
	$stmt->execute();
		
	$results = $stmt->fetchall();
		
	$resultArray = array();
	foreach ($results as $row){
	$resultArray[] = $row['address'].' '.$row['suburb'].', '.$row['state'].' '.$row['postcode'];
	}	
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage();
		
	}
}

function db_getPOI($propertyId){
	$pdo= db_connect();
	
	try{
		$stmt = $pdo->prepare(
							'select * from v_poi_whouse '.
							'where propertyId = :propertyId'
							);
			
		$stmt->bindValue(':propertyId',$propertyId);
		
		$stmt->execute();
		
		$results = $stmt->fetchall();
		
	$resultArray = array();
	foreach ($results as $row){
	$resultArray[] = $row['address'].' '.$row['suburb'].', '.$row['state'].' '.$row['postcode'];
	}	
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage();
		
	}
	
}

function db_getSHouseDetails($sHouseId){
	$pdo= db_connect();
	$stmt = $pdo->prepare(
						'select * from v_s_house_property_details '.
						'where sHouseId = :sHouseId'
						);
		
	$stmt->bindValue(':sHouseId',$sHouseId);
		
	$stmt->execute();
		
	$resultArray = $stmt->fetch();
		
	return $resultArray;
	
}

/*Recycle Bin
function db_getSHouseDetails1($sHouseId){
	$pdo= db_connect();
	$stmt = $pdo->prepare(
						'select propertyId from property '.
						'where sHouseId = :sHouseId'
						);
		
	$stmt->bindValue(':sHouseId',$sHouseId);
		
	$stmt->execute();
		
	$resultArray = $stmt->fetch();
		
	return $resultArray;
	
}*/

function db_getRooms($sHouseId){
	try{
		$pdo= db_connect();
		$stmt = $pdo->prepare(
							'select * from v_rooms '.
							'where sHouseId = :sHouseId'
							);
			
		$stmt->bindValue(':sHouseId',$sHouseId);
			
		$stmt->execute();
			
		$resultArray = $stmt->fetchall();
			
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage();
		exit();
	}	
}

// Creating a function to connect to the database and bind the values 

function db_update_w_house($propertyId,$address,$description,$suburb,$state,$postcode,$numBaths,$numCarParks,/*$ownerId,*/$numRooms,$defaultRent,$defaultPeriod,$buyingPrice,$dateAvailable,$dateInspection){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
		
					// Calling the update_w_house stored procedure from the database
		
					'call update_w_house (:propertyId,:address,:description,:suburb,:state,:postcode,:numBaths,:numCarParks,:numRooms,:defaultRent,:defaultPeriod,:buyingPrice,:dateAvailable,:dateInspection);'
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
		$stmt->bindValue(':dateAvailable',$dateAvailable);
		$stmt->bindValue(':dateInspection',$dateInspection);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
	}							
}

function db_update_s_house($sHouseId,$address,$description,$suburb,$state,$postcode,$numBath,$numCarParks,/*$ownerId,*/$maxOvernightGuests,$dateAvailable,$dateInspection){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call update_s_house (:sHouseId,:address,:description,:suburb,:state,:postcode,:numCarParks,:numBath,:maxOvernightGuests,:dateAvailable,:dateInspection);'
				);

		
		$stmt->bindValue(':sHouseId',$sHouseId);
		$stmt->bindValue(':address',$address);
		$stmt->bindValue(':description',$description);
		$stmt->bindValue(':suburb',$suburb);
		$stmt->bindValue(':state',$state);
		$stmt->bindValue(':postcode',$postcode);
		$stmt->bindValue(':numCarParks',$numCarParks);
		$stmt->bindValue(':numBath',$numBath);		
		//$stmt->bindValue(':ownerId',$ownerId);
		$stmt->bindValue(':maxOvernightGuests',$maxOvernightGuests);
		$stmt->bindValue(':dateAvailable',$dateAvailable);
		$stmt->bindValue(':dateInspection',$dateInspection);
		
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
	}							
}

function db_delete_w_house($propertyId){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call delete_w_house (:propertyId);'
				);

		
		$stmt->bindValue(':propertyId',$propertyId);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
	}							
}

function db_delete_tenant_temp($confirmCode){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'delete from tenant_temp '.
					'where confirmCode = :confirmCode'
				);

		
		$stmt->bindValue(':confirmCode',$confirmCode);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
	}							
}

function db_delete_s_house($sHouseId){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call delete_s_house (:sHouseId);'
				);

		
		$stmt->bindValue(':sHouseId',$sHouseId);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
	}							
}

function db_getContactDetails($loginId){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select * from v_contact_details '.
						'where loginId = :loginId'
						);
		
		$stmt->bindValue(':loginId',$loginId);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}


/*Recycle Bin
function db_getPropertyPic($loginId){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select * from propertypic '.
						'where loginId = :loginId'
						);
		
		$stmt->bindValue(':loginId',$loginId);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}*/


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
		
		$stmt->execute();
		

		
	}catch(PDOException $e){
		echo 'exception: db_addProperty';
		echo $e->getMessage();
	}
}

function db_addSHouseRoom($sHouseId,$roomNum,$defaultRent,$defaultPeriod){
	try{
		$pdo = db_connect();
		
		/*
		might add room image later
		$size = getimagesize($userfile['tmp_name']);
		$type = $size['mime'];
		$image = fopen($userfile['tmp_name'], 'rb');*/
		
		$stmt = $pdo->prepare(		
					'call add_s_house_room(:sHouseId,:roomNum,:defaultRent,:defaultPeriod);'
				);
		

		$stmt->bindValue(':sHouseId',$sHouseId);
		$stmt->bindValue(':roomNum',$roomNum);
		$stmt->bindValue(':defaultRent',$defaultRent);
		$stmt->bindValue(':defaultPeriod',$defaultPeriod);

		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_addSHouseRoom';
		echo $e->getMessage();
		exit();
	}
}

// Creating a function to connect to the database and bind the values

function db_s_House_addProperty($maxOvernightGuests,$address,$description,$suburb,$state,$postcode,$numCarParks,$numBath,$ownerId){
	try{
		$pdo = db_connect();	
		
		
		$stmt = $pdo->prepare(		
		
			// Calling the add_property_s_house stored procedure from the database
		
			'call add_property_s_house(:maxOvernightGuests,:address,:description,:suburb,:state,:postcode,:numCarParks,:numBath,:ownerId);'
				);
		
		$stmt->bindValue(':maxOvernightGuests',$maxOvernightGuests);
		$stmt->bindValue(':address',$address);
		$stmt->bindValue(':description',$description);
		$stmt->bindValue(':suburb',$suburb);
		$stmt->bindValue(':state',$state);
		$stmt->bindValue(':postcode',$postcode);
		$stmt->bindValue(':numCarParks',$numCarParks);
		$stmt->bindValue(':numBath',$numBath);
		$stmt->bindValue(':ownerId',$ownerId);		
		
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_s_House_addProperty';
		echo $e->getMessage();
		exit();
	}
}


/*
Recycle Bin
function db_viewimage($propertyId) {

try{
$pdo = db_connect();
$stmt = $pdo->prepare("SELECT mime,image FROM v_w_house_property_details
WHERE propertyId = :propertyId"
);

$stmt->execute(array(":propertyId" => $propertyId));
$stmt->bindColumn(1, $mime);
$stmt->bindColumn(2, $image, PDO::PARAM_LOB);
 
$stmt->fetch(PDO::FETCH_BOUND);
 
return array("mime" => $mime,
     "image" => $image);
 
} catch(PDOException $e){
		echo 'exception: db_viewimage';
		echo $e->getMessage();
	}
} 
*/



?>

































