
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
<<<<<<< HEAD
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/theme.css" rel="stylesheet">
<title>Tenant Profile</title>
</head>
<body>
<?php include('/includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Tenant Profile</h1> <!-- We could use the name variable as this title -->
</div>
<div class="col-xs-offset-2"><div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Edit Profile</h3>
		</div>
	<div class="panel-body">
<?php include('/includes/content/topNav.php'); ?>
=======
<html>
<title>Tenant Profile</title>
<head>
<link rel='stylesheet' href = 'css/global.css' type = 'text/css'/>
<link rel='stylesheet' href = 'css/tenantProfile.css' type = 'text/css'/>
</head>
<body>
<?php include('/includes/content/topNav.php'); ?>
>>>>>>> origin/master
<form class= 'editForm' action = "tenantProfile.php" method = "POST" name = "updateTenantAccount">
<?php

$tenantDetails = db_getTenantDetails($loginId);

$selectedGender;
if ($tenantDetails['isMale'] == "1"){
	$selectedGender = 'male';
}else{
	$selectedGender = 'female';
<<<<<<< HEAD
}?>
<table class="table">

			<tbody>
	
<tr><td>Your Email</td><td><?php ctrl_input_field($errors,'text','REQUIRED','email','','txtEmail',$tenantDetails['email']);?></td></tr>
<tr><td>New Password</td><td><?php ctrl_input_field($errors, 'text','REQUIRED','password','','txtPassword',$tenantDetails['password']); ?></td></tr>
<tr><td>First Name</td><td><?php ctrl_input_field($errors,'text','REQUIRED','firstName','','txtFirstName',$tenantDetails['firstName']); ?></td></tr>
<tr><td>Last Name</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','lastName','','txtLastName',$tenantDetails['lastName']); ?></td></tr>
<tr><td>Date of Birth</td><td><?php ctrl_input_field($errors,'date','OPTIONAL','DOB','','dtpDOB',$tenantDetails['DOB']);	?></td></tr>
<?php $genderValues = array('male','female');
$genderLabels = array('Male','Female');?>
<tr><td><?php ctrl_input_radio($errors,'gender',$genderValues,$genderLabels,'classNameNotImplemented',$selectedGender); ?></td></tr>
<tr><td><?php ctrl_submit('Save'); ?></td></tr>
</tbody>
</table>
=======
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
>>>>>>> origin/master
</form>
</body>
</html>