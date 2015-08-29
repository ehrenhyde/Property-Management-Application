
<?php
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');
include('includes/accountSessions.php');


$errors = array();
$loginId = $_SESSION['idLogin'];

if (isset($_POST['submit'])){
	
	require 'includes/functions/validate.php';
	
	validateEmail($errors,$_POST,'email');
	validateText($errors, $_POST,'firstName');
	validateText($errors, $_POST,'lastName');
	validateDOB($errors, $_POST, 'DOB');
	validateText($errors, $_POST, 'password');
	
	if (!$errors){
		
		$isMale = NULL;
		if (isset ($_POST['gender']) && $_POST['gender'] == 'male'){
			$isMale = 1;		
		} else {
			$isMale = 0;
		}
		db_updateTenant($loginId,$_POST['email'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],$_POST['DOB'],$isMale);
		
		
		header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/tenantProfile.php");
		exit();	
	}	
}
?>
<html>
<title>Tenant Profile</title>
<head>
<link rel='stylesheet' href = 'css/global.css' type = 'text/css'/>
<link rel='stylesheet' href = 'css/tenantProfile.css' type = 'text/css'/>
</head>
<body>
<?php include('/includes/content/topNav.php'); ?>
<form class= 'editForm' action = "tenantProfile.php" method = "POST" name = "updateTenantAccount">
<?php

$tenantDetails = db_getTenantDetails($loginId);

$selectedGender;
if ($tenantDetails['isMale'] == "1"){
	$selectedGender = 'male';
}else{
	$selectedGender = 'female';
}
	
ctrl_input_field($errors,'text','REQUIRED','email','Your Email','txtEmail',$tenantDetails['email']);
ctrl_input_field($errors, 'text','REQUIRED','password','New Password','txtPassword',$tenantDetails['password']);
ctrl_input_field($errors,'text','REQUIRED','firstName','First Name','txtFirstName',$tenantDetails['firstName']);
ctrl_input_field($errors,'text','OPTIONAL','lastName','Last Name','txtLastName',$tenantDetails['lastName']);
ctrl_input_field($errors,'date','OPTIONAL','DOB','Date of Birth','dtpDOB',$tenantDetails['DOB']);	
$genderValues = array('male','female');
$genderLabels = array('Male','Female');
ctrl_input_radio($errors,'gender',$genderValues,$genderLabels,'classNameNotImplemented',$selectedGender);
ctrl_submit('Save');
?>
</form>
</body>
</html>