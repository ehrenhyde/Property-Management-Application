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
		
		if ($owner ==1){
			db_addOwner($email,$password,$firstName,$lastName,$DOB,$isMale);
			
			
		} else{
			echo hi;
			db_addTenant($email,$password,$firstName,$lastName,$DOB,$isMale);	
		} 
	
} else {
		echo 'Invalid Code. Please Register Again';
		header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/registerTenant.php");
		exit();	
	}
	echo 'Your account has been activated by SPEL';
	db_delete_tenant_temp($passcode);
	
	header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/searchProperties.php");
	exit();	
	








?>
</body>
</html>


