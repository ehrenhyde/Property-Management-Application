<?php	
	$loginId = $_SESSION['idLogin'];
	$ownerId = db_getOwnerId($loginId);
	if (!empty($ownerId)){
		$accountType = 'owner';
	} else {
		$accountType = 'tenant';
	}
	
?>