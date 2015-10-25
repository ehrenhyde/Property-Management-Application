
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
	
	if ($errors){
		
		$isMale = NULL;
		if (isset ($_POST['gender']) && $_POST['gender'] = 'male'){
			$isMale = true;		
		} else {
			$isMale = false;
		}
		
		db_updateTenant($loginId,$_POST['email'],$_POST['firstName'],$_POST['lastName'],$_POST['DOB'],$isMale,$_FILES["user_files"]);
		
		
		header("location: http://{$_SERVER['HTTP_HOST']}/tenantProfile.php");
		exit();	
	}	
}else{
	//echo "<h1>NOTHING SUBMITTED</h1>";
}
?>
<html lang="en">
  <head>
   
<title>Tenant Profile</title>
<?php include ('includes/content/bootstrapHead.php'); ?>

<?php include('includes/content/DOBCheck.php'); ?>
</head>
<body>
<?php 
	?>
		<div class="page-header">
	<h1>Tenant Profile</h1> <!-- We could use the name variable as this title -->
</div>

<?php
if(!$_SESSION || $loginId ==null){
		echo 'You are not logged in.!';
		?>
		
	<script type="text/javascript">
		location.href = 'login.php';
	</script>
	
			<?php
		exit();
	}		
	?>

<div class="col-xs-offset-2"><div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Edit Profile</h3>
		</div>
	<div class="panel-body">
<?php include('includes/content/topNav.php');?>
<form class= 'editForm' enctype="multipart/form-data" action = "tenantProfile.php" method = "POST" name = "updateTenantAccount">
<?php

$tenantDetails = db_getTenantDetails($loginId);


$selectedGender;
if ($tenantDetails['isMale'] == "1"){
	$selectedGender = 'male';
}else{
	$selectedGender = 'female';
}?>
<table class="table">

			<tbody>
<tr><td>Profile Picture</td><td><input type="file" name="user_files" id="user_files" tabindex='1'></td></tr>
<tr><td>Your Email</td><td><?php ctrl_input_field($errors,'text','REQUIRED','email','','txtEmail',$tenantDetails['email'],2);?></td></tr>
<?php echo "<tr><td><a href='updatePassword.php?loginId=$loginId'>Update Password</a></td></tr>"; ?>
<tr><td>First Name</td><td><?php ctrl_input_field($errors,'text','REQUIRED','firstName','','txtFirstName',$tenantDetails['firstName'],3); ?></td></tr>
<tr><td>Last Name</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','lastName','','txtLastName',$tenantDetails['lastName'],4); ?></td></tr>
<tr><td>Date of Birth</td><td><?php ctrl_input_field($errors,'date','OPTIONAL','DOB','','dtpDOB',$tenantDetails['DOB'],5);	?><span id ='dateWarning'>Not Over 18!</span></td></tr>
<?php $genderValues = array('male','female');
$genderLabels = array('Male','Female');?>
<tr><td>Gender</td><td><?php ctrl_input_radio($errors,'gender',$genderValues,$genderLabels,'classNameNotImplemented',$selectedGender,6); ?></td></tr>
<tr><td></td><td><div align="right"><?php ctrl_submit('Save','btnSubmit',7); ?></div></td></tr>
</tbody>
</table>
</form>
</body>
</html>