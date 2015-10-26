<html>
<body>
<?php

include ('includes/functions/db.php');
include ('includes/accountSessions.php');
$errors = array();
$passcode = $_GET['confirmCode'];


list($result,$count)=db_getTenantDetails_temp($passcode);

		

if ($result & $count ==1){
		$owner = $_GET['owner'];
		$email=$result['email'];
		$password=$result['password'];
		$firstName=$result['firstName'];
		$lastName=$result['lastName'];
		$DOB=$result['DOB'];
		$isMale=$result['isMale'];
		$image=$result['image'];
		$image_type = $result['image_type'];
		
		
		if ($owner ==1){
			db_addOwner($email,$password,$firstName,$lastName,$DOB,$isMale,$image,$image_type);
			
			
		} else{
			echo 1;
			db_addTenant($email,$password,$firstName,$lastName,$DOB,$isMale,$image,$image_type);	
		} 
	
} else {
		echo 'Invalid Code. Please Register Again';
		header("location: http://{$_SERVER['HTTP_HOST']}/registerTenant.php");
		exit();	
	}
	echo 'Your account has been activated by SMELT';
	db_delete_tenant_temp($passcode);
	
	header("location: http://{$_SERVER['HTTP_HOST']}/searchProperties.php");
	exit();	
	








?>
</body>
</html>


