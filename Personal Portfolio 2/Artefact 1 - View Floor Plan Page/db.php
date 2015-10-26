<?php 


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




?>

































