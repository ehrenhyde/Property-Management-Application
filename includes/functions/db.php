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

function db_update_w_house($propertyId,$address,$description,$suburb,$state,$postcode,/*$ownerId,*/$numRooms,$defaultRent,$defaultPeriod,$buyingPrice){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call update_w_house (:propertyId,:address,:description,:suburb,:state,:postcode,:numRooms,:defaultRent,:defaultPeriod,:buyingPrice);'
				);

		
		$stmt->bindValue(':propertyId',$propertyId);
		$stmt->bindValue(':address',$address);
		$stmt->bindValue(':description',$description);
		$stmt->bindValue(':suburb',$suburb);
		$stmt->bindValue(':state',$state);
		$stmt->bindValue(':postcode',$postcode);
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


function db_addProperty($numOfRooms,$defaultRent,$defaultPeriod,$buyingPrice,$address,$description,$image){
	try{
		$pdo = db_connect();
		$image = fopen($image,'rb');
		$stmt = $pdo->prepare(		
					'call add_property(:numOfRooms,:defaultRent,:defaultPeriod,:buyingPrice,:address,:description,:suburb,:state,:postcode,:image);'
				);
		
		

		$stmt->bindValue(':numOfRooms',$numOfRooms);
		$stmt->bindValue(':defaultRent',$defaultRent);
		$stmt->bindValue(':defaultPeriod',$defaultPeriod);
		$stmt->bindValue(':buyingPrice',$buyingPrice);
		$stmt->bindValue(':address',$address);
		$stmt->bindValue(':description',$description);
		$stmt->bindValue(':suburb',$suburb);
		$stmt->bindValue(':state',$state);
		$stmt->bindValue(':postcode',$postcode);
		$stmt->bindValue(':image',$image,PDO::PARAM_LOB);
		
		$stmt->execute();
		echo 1;
	}catch(PDOException $e){
		echo 'exception: db_addProperty';
		echo $e->getMessage();
	}
}

function db_addimage($filePath,$mime){

$blob = fopen($filePath,'rb');

try{
$pdo = db_connect();
$stmt =  $pdo-> prepare("INSERT INTO v_w_house_property_details(image,mime) VALUES(:image,:mime)"
				);

$stmt->bindParam(':mime',$mime);
$stmt->bindParam(':image',$blob,PDO::PARAM_LOB);
 
$stmt->execute();

} catch(PDOException $e){
		echo 'exception: db_addimage';
		echo $e->getMessage();
	}
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

function data_uri($file, $mime) 
{  
  $contents = file_get_contents($file);
  $base64   = base64_encode($contents); 
  return ('data:' . $mime . ';base64,' . $base64);
}

?>

































