<?php	
include ($_SERVER['DOCUMENT_ROOT'].'PropertyManagementSystem/includes/functions/db.php');
	$loginId = $_SESSION['idLogin'];
	$ownerId = db_getOwnerId($loginId);
	if (!empty($ownerId)){
		$accountType = 'owner';
		$owner = db_getOwnerDetails($loginId);	//Modified this
		
	} else {
		$accountType = 'tenant';
		$tenant = db_getTenantDetails($loginId);//Modified this	 	
	}
	
?>