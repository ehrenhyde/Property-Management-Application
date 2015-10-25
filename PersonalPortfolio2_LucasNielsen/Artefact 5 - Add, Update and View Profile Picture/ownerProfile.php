
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
		if (isset ($_POST['gender']) && $_POST['gender'] == 'male'){
			$isMale = 1;		
		} else {
			$isMale = 0;
		}
		
		
		db_updateOwner($loginId,$_POST['email'],$_POST['firstName'],$_POST['lastName'],$_POST['DOB'],$isMale,$_FILES["user_files"]);
		
		
		header("location: http://{$_SERVER['HTTP_HOST']}/ownerProfile.php");
		exit();	
	}	
}
?>
<html lang="en">
  <head>
    
<title>Owner Profile</title>
<?php include ('includes/content/bootstrapHead.php'); ?>
<?php include('includes/content/DOBCheck.php'); ?>
</head>
<body>
<?php include('includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Owner Profile</h1>
</div>

<?php
if(!$_SESSION){
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
<form class= 'editForm' enctype="multipart/form-data" action = "ownerProfile.php" method = "POST" name = "updateOwnerAccount">
<?php

$ownerDetails = db_getOwnerDetails($loginId);

$selectedGender;
if ($ownerDetails['isMale'] == "1"){
	$selectedGender = 'male';
}else{
	$selectedGender = 'female';
}?>
<table class="table">

			<tbody>
<tr><td>Update Profile Picture</td><td><input type="file" name="user_files" id="user_files" tabindex='1'></td></tr>
<tr><td>Your Email</td><td><?php ctrl_input_field($errors,'text','REQUIRED','email','','txtEmail',$ownerDetails['email'],2);?></td></tr>

<?php echo "<tr><td><a href='updatePassword.php?loginId=$loginId'>Update Password</a></td></tr>"; ?>
<tr><td>First Name</td><td><?php ctrl_input_field($errors,'text','REQUIRED','firstName','','txtFirstName',$ownerDetails['firstName'],3); ?></td></tr>
<tr><td>Last Name</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','lastName','','txtLastName',$ownerDetails['lastName'],4); ?></td></tr>
<tr><td>Date of Birth</td><td><?php ctrl_input_field($errors,'date','OPTIONAL','DOB','','dtpDOB',$ownerDetails['DOB'],5);	?><span id ='dateWarning'>Not Over 18!</span></td></tr>
<?php $genderValues = array('male','female');
$genderLabels = array('Male','Female');?>
<tr><td>Gender</td><td><?php ctrl_input_radio($errors,'gender',$genderValues,$genderLabels,'classNameNotImplemented',$selectedGender,6); ?></td></tr>
<tr><td></td><div align="right"><td><?php ctrl_submit('Save','btnSubmit',7); ?></div></td></tr>
</tbody>
</table>
</form>
</body>
</html>