<?php

include('../includes/functions/db.php');

$loginId = $_POST['loginId'];
$propertyId;
$isFavourite = $_POST['isFavourite'];

if (isset($_POST['propertyId'])){
	$propertyId = $_POST['propertyId'];
	echo "got propertyId *$propertyId* directly";
}else if (isset($_POST['sHouseId'])){
	$propertyId = db_getPropertyIdFromSHouseId($_POST['sHouseId']);
	echo "got propertyId *$propertyId* from sHouse";
}else{
	echo "could not get propertyId";
	exit();
}

db_updateFavouriteStatus($loginId,$propertyId,$isFavourite);

?>