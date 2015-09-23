<?php

// Creating a function to connect to the database and bind the values

function db_searchProperties_s_house($address,$minRooms,$maxRooms){
	$pdo = db_connect();
	try{
		
		$sSearchAddress = "%".$address."%";
		$stmt = $pdo->prepare(
		
					// Calling the search_s_house view from the database
		
						'select * from search_s_house '.
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

?>