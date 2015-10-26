<?php	
include ($_SERVER['DOCUMENT_ROOT'].'PropertyManagementSystem/includes/functions/db.php');
	$loginId = $_SESSION['idLogin'];
	$ownerId = db_getOwnerId($loginId);
	if (!empty($ownerId)){
		$accountType = 'owner';
		$owner = db_getOwnerDetails($loginId);	
		
	} else {
		$accountType = 'tenant';
		$tenant = db_getTenantDetails($loginId);		
	}
	
?>