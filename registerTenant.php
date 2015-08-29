<?php
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');

include ('includes/accountSessions.php');

$errors = array();

if (isset($_POST['submit'])){
	
	require 'includes/functions/validate.php';
	
	validateEmail($errors,$_POST,'email');
	validateText($errors, $_POST,'firstName');
	validateText($errors, $_POST,'lastName');
	validateDOB($errors, $_POST, 'DOB');
	validateText($errors, $_POST, 'password');
	
	if (!$errors){
		
		$isMale = NULL;
		if (isset ($_POST['gender']) && $_POST['gender'] = 'male'){
			$isMale = true;		
		} else {
			$isMale = false;
		}
		db_addTenant($_POST['email'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],$_POST['DOB'],$isMale);
		
		
		header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/searchProperties.php");
		exit();	
	}	
}
?>
<html>
<title>Register Tenant</title>
<head>
<link rel='stylesheet' href = 'css/global.css' type = 'text/css'/>
<link rel='stylesheet' href = 'css/registerTenant.css' type = 'text/css'/>
</head>
<body>
<?php include('/includes/content/topNav.php'); ?>
<form class= 'regForm' action = "register.php" method = "POST" name = "registerTenantAccount">
<?php
	
ctrl_input_field($errors,'text','REQUIRED','email','Your Email','txtEmail');
ctrl_input_field($errors, 'text','REQUIRED','password','New Password','txtPassword');
ctrl_input_field($errors,'text','REQUIRED','firstName','First Name','txtFirstName');
ctrl_input_field($errors,'text','OPTIONAL','lastName','Last Name','txtLastName');
ctrl_input_field($errors,'date','OPTIONAL','DOB','Date of Birth','dtpDOB');	
$genderValues = array('male','female');
$genderLabels = array('Male','Female');
ctrl_input_radio($errors,'gender',$genderValues,$genderLabels,'classNameNotImplemented','male');
ctrl_submit('Register');
?>
</form>
</body>
</html>