<?php
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');
include ('includes/accountSessions.php');
include ('includes/functions/mail.php');

$errors = array();

if (isset($_POST['submit'])){
	
	require 'includes/functions/validate.php';
	require "phpmailer/class.phpmailer.php"; 
	
	validateEmail($errors,$_POST,'email');
	validateText($errors, $_POST,'firstName');
	validateText($errors, $_POST,'lastName');
	validateDOB($errors, $_POST, 'DOB');
	validateText($errors, $_POST, 'password');
	
	if (!$errors){
		
		$isMale = NULL;
		if (isset ($_POST['gender']) && $_POST['gender'] == 'male'){
			$isMale = true;		
		} else {
			$isMale = false;
		}
		$confirmCode=md5(uniqid(rand()));
		
		db_addTenant_temp($confirmCode,$_POST['email'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],$_POST['DOB'],$isMale,$_FILES["user_files"]);	
		
		mail_send_registration_code($confirmCode,$_POST['email'],$_POST['fullname'],$_POST['firstName'],1);
			
		header("location: http://{$_SERVER['HTTP_HOST']}/searchProperties.php");
		exit();	
	}	
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/theme.css" rel="stylesheet">
<title>Register Owner</title>
</head>
<body>
<?php ?>
<div class="page-header">
	<h1>Register - Owner</h1>
</div>
<div class="col-xs-offset-2"><div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Profile</h3>
		</div>
	<div class="panel-body">
<?php include('includes/content/topNav.php'); ?>

<?php
if($_SESSION){
	echo 'You are logged in. Please log out to register a new account!';
?>
		<p>You will be redirected to the home page in <span id="counter">5</span> second(s).</p>
	<script type="text/javascript">
		function countdown() {
		
		var i = document.getElementById('counter');
			
		if (parseInt(i.innerHTML)<=1) {
			location.href = 'homePage.php';
		}
		
		i.innerHTML = parseInt(i.innerHTML)-1;
		}
		setInterval(function(){ countdown(); },1000);
	</script>
	
<?php
		exit();
	}	
?>

<form class= 'regForm' enctype="multipart/form-data" action = "registerOwner.php" method = "POST" name = "registerOwnerAccount">
<table class="table">

	<tbody>
<tr><td>Profile Picture</td><td><input type="file" name="user_files" id="user_files"></td></tr>
<tr><td>Your Email</td><td><?php ctrl_input_field($errors,'text','REQUIRED','email','','txtEmail',$ownerDetails['email']);?></td></tr>
<tr><td>New Password</td><td><?php ctrl_input_field($errors, 'text','REQUIRED','password','','txtPassword',$ownerDetails['password']); ?></td></tr>
<tr><td>First Name</td><td><?php ctrl_input_field($errors,'text','REQUIRED','firstName','','txtFirstName',$ownerDetails['firstName']); ?></td></tr>
<tr><td>Last Name</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','lastName','','txtLastName',$ownerDetails['lastName']); ?></td></tr>
<tr><td>Date of Birth</td><td><?php ctrl_input_field($errors,'date','OPTIONAL','DOB','','dtpDOB',$ownerDetails['DOB']);	?></td></tr>
<?php $genderValues = array('male','female');
$genderLabels = array('Male','Female');?>
<tr><td><?php ctrl_input_radio($errors,'gender',$genderValues,$genderLabels,'classNameNotImplemented',$selectedGender); ?></td></tr>
<tr><td><?php ctrl_submit('Save'); ?></td></tr>
</tbody>
</table>
</form>
</body>
</html>