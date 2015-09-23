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

function db_addTenant($email,$password,$firstName,$lastName,$DOB,$isMale){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call create_tenant_login_details(:email,:password,:firstName,:lastName,:DOB,:isMale);'
				);
		
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':password',$password);
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_addTenant';
		echo $e->getMessage();
	}
}

function db_addOwner($email,$password,$firstName,$lastName,$DOB,$isMale){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call create_owner_login_details(:email,:password,:firstName,:lastName,:DOB,:isMale);'
				);
		
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':password',$password);
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_addTenant';
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

function db_updateTenant($loginId,$email,$password,$firstName,$lastName,$DOB,$isMale){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call update_tenant(:loginId,:email,:password,:firstName,:lastName,:DOB,:isMale);'
				);
		
		$stmt->bindValue(':loginId',$loginId);
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':password',$password);
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
	}
}

function db_updateOwner($loginId,$email,$password,$firstName,$lastName,$DOB,$isMale){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call update_owner(:loginId,:email,:password,:firstName,:lastName,:DOB,:isMale);'
				);
		
		$stmt->bindValue(':loginId',$loginId);
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':password',$password);
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
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

// Creating a function to connect to the database and bind the values

function db_searchProperties_s_house($address,$minRooms,$maxRooms){
	$pdo = db_connect();
	try{
		
		$sSearchAddress = "%".$address."%";
		$stmt = $pdo->prepare(
		
					// Calling the search_s_house view from the database
						
						'select * from v_search_s_house '.
						'where address like :searchVal '.
						'AND numberOfRooms >= COALESCE(:minRooms,0) '.
						'AND numberOfRooms <= COALESCE(:maxRooms,9999999999);'
						);
		
		$stmt->bindValue(':searchVal',$sSearchAddress);
		$stmt->bindValue(':minRooms',$minRooms);
		$stmt->bindValue(':maxRooms',$maxRooms);
				
		$stmt->execute();
		
		$resultArray = $stmt->fetchall();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
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

// Creating a function to connect to the database and bind the values 

function db_update_w_house($propertyId,$address,$description,$suburb,$state,$postcode,$numBaths,$numCarParks,/*$ownerId,*/$numRooms,$defaultRent,$defaultPeriod,$buyingPrice){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
		
					// Calling the update_w_house stored procedure from the database
		
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

function db_update_s_house($sHouseId,$address,$description,$suburb,$state,$postcode,$numBath,$numCarParks,/*$ownerId,*/$maxOvernightGuests){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call update_s_house (:sHouseId,:address,:description,:suburb,:state,:postcode,:numCarParks,:numBath,:maxOvernightGuests);'
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
}


function db_addProperty($numOfRooms,$numberofBaths,$numberofcarParks,$defaultRent,$defaultPeriod,$buyingPrice,$address,$description,$suburb,$state,$postcode,$userfile){
	try{
		$pdo = db_connect();
		
		$size = getimagesize($userfile['tmp_name']);
		$type = $size['mime'];
		$image = fopen($userfile['tmp_name'], 'rb');
		
		$stmt = $pdo->prepare(		
					'call add_property(:numOfRooms,:numberofBaths,:numberofcarParks,:defaultRent,:defaultPeriod,:buyingPrice,:address,:description,:suburb,:state,:postcode,:image_type,:image);'
				);
		/*echo "Type:*".$type."*";
		echo "Size:*".$size."*";
		echo "Userfile Temp nname thing*".$_FILES['userfile']['tmp_name']."*";
		exit();*/

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
		$stmt->bindParam(':image_type', $type);
		$stmt->bindParam(':image', $image, PDO::PARAM_LOB);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_addProperty';
		echo $e->getMessage();
	}
}

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

function uploadimage(){

   /*** Utilise the getimagesize function to fetch image type    ***/
    $size = getimagesize($_FILES['userfile']['tmp_name']);
    
    $type = $size['mime'];
    $image = fopen($_FILES['userfile']['tmp_name'], 'rb');
   
   /*** Connect to DB ***/
	$pdo=db_connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	/*** Query ***/
	$stmt = $pdo->prepare("INSERT INTO property_pic(propertyId, image_type ,image) VALUES (10,:image_type,:image)");
        
	/*** Bind Params ***/		
	$stmt->bindParam(':image_type', $type);
    $stmt->bindParam(':image', $image, PDO::PARAM_LOB);
       
	/*** Execute ***/
    $stmt->execute();
      
}

function db_updateimage($propertyId,$filePath,$mime) {
 
$blob = fopen($filePath,'rb');

try{
$pdo = db_connect();
$stmt = $pdo->prepare("UPDATE v_w_house_property_details
SET mime = :mime,
image = :image
WHERE propertyId = :propertyId"
);
 
$stmt->bindParam(':mime',$mime);
$stmt->bindParam(':image',$blob,PDO::PARAM_LOB);
$stmt->bindParam(':propertyId',$propertyId);
 
$stmt->execute();
 
} catch(PDOException $e){
		echo 'exception: db_updateimage';
		echo $e->getMessage();
	}
}

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


?>

































