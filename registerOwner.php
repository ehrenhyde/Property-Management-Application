<?php
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');
include ('includes/accountSessions.php');

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
		db_addTenant_temp($confirmCode,$_POST['email'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],$_POST['DOB'],$isMale);	
		// Your message
		$message="Hi ". $_POST['firstName']." <p>\n";
		$message.="<br>Welcome to the Property Management Application (SPEL) Community <br>\n";
		$message.="<br>To Activate your Account, Click on the link below: <br>\n";
		$message.="http://52.26.240.26/property-management-application/confirmation.php?confirmCode=$confirmCode&owner=1<br>";
		$message.="<br>From the SPEL Management Team";
		$mail = new PHPMailer();  
		
		
     
		$mail->IsSMTP();   
		$mail->IsHTML(); 
		$mail->SMTPAuth = true;       
		$mail->SMTPDebug = 2;  
		$mail->SMTPSecure = "ssl";       
		$mail->Host = "smtp.gmail.com";  
		$mail->Port = 465;  
	  
		
		
		$mail->Username   = "lucas.nielsen459@gmail.com"; 
		$mail->Password   = "F22Raptor"; 
		  
	   
		$mail->From='lucas.nielsen459@gmail.com';
		$mail->FromName='SPEL Management';
		$mail->AddReplyTo("lucas.nielsen459@gmail.com", $_POST['fullname']);
		$mail->Subject = "Activate Your Account to SPEL";        
		$mail->MsgHTML($message);
	 
	   
		$mail->AddAddress($_POST['email'],$_POST['firstName']); 
		if($mail->Send()){
			echo 'Your Confirmation has been sent!';
			
		}else {
			echo'Email Not sent! Please Try again';
			
		};	// Send!  
			
		header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/searchProperties.php");
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
<?php include('/includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Register - Owner</h1>
</div>
<div class="col-xs-offset-2"><div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Profile</h3>
		</div>
	<div class="panel-body">
<?php include('/includes/content/topNav.php'); ?>
<form class= 'regForm' action = "registerOwner.php" method = "POST" name = "registerOwnerAccount">
<table class="table">

	<tbody>
	
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