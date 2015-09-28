<?php
/*enable calling database access functions*/
include ('includes/functions/db.php');
/*makes building forms easier*/
include ('includes/functions/formControls.php');
/*Utilse the user's login sesion*/
include ('includes/accountSessions.php');

$errors = array();

/*Only try to insert if the page is being posted to*/
if (isset($_POST['submit'])){
	
	require 'includes/functions/validate.php';
	require "phpmailer/class.phpmailer.php"; 
	
	/*Check the field values are legitmate*/
	validateEmail($errors,$_POST,'email');
	validateText($errors, $_POST,'firstName');
	validateText($errors, $_POST,'lastName');
	validateDOB($errors, $_POST, 'DOB');
	validateText($errors, $_POST, 'password');
	
	if (!$errors){
		
		/*get a bool value of gender*/
		$isMale = NULL;
		if (isset ($_POST['gender']) && $_POST['gender'] = 'male'){
			$isMale = true;		
		} else {
			$isMale = false;
		}
		
		$confirmCode=md5(uniqid(rand())); 
		/*insert into the db*/
		db_addTenant_temp($confirmCode,$_POST['email'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],$_POST['DOB'],$isMale);		
		
		// Your message
		$message="Hi ". $_POST['firstName']." <p>\n";
		$message.="<br>Welcome to the Property Management Application (SPEL) Community <br>\n";
		$message.="<br>To Activate your Account, Click on the link below: <br>\n";
		$message.="http://52.26.240.26/property-management-application/confirmation.php?confirmCode=$confirmCode<br>";
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
<!--The bulk of the HTML Page itself-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/theme.css" rel="stylesheet">
<title>Register Tenant</title>
</head>
<body>
<!--Top Nav is the menu bar at the top-->
<?php include('/includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Register</h1> <!-- We could use the name variable as this title -->
</div>
<div class="col-xs-offset-2"><div class="col-sm-9">
	<div class="panel panel-primary"><!--Extra divs are for bootstrap-->
		<div class="panel-heading">
			<h3 class="panel-title">Profile</h3>
		</div>
	<div class="panel-body">
<?php include('/includes/content/topNav.php'); ?>
<form class= 'regForm' action = "registerTenant.php" method = "POST" name = "registerTenantAccount">
<table class="table">

	<tbody>
<!--Use formControls library to construct the form-->
<tr><td>Your Email</td><td><?php ctrl_input_field($errors,'text','REQUIRED','email','','txtEmail',$tenantDetails['email']);?></td></tr>
<tr><td>New Password</td><td><?php ctrl_input_field($errors, 'text','REQUIRED','password','','txtPassword',$tenantDetails['password']); ?></td></tr>
<tr><td>First Name</td><td><?php ctrl_input_field($errors,'text','REQUIRED','firstName','','txtFirstName',$tenantDetails['firstName']); ?></td></tr>
<tr><td>Last Name</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','lastName','','txtLastName',$tenantDetails['lastName']); ?></td></tr>
<tr><td>Date of Birth</td><td><?php ctrl_input_field($errors,'date','OPTIONAL','DOB','','dtpDOB',$tenantDetails['DOB']);	?></td></tr>
<!--setup the possible values for gender. IsMale checkbox is not politacally correct-->
<?php $genderValues = array('male','female');
$genderLabels = array('Male','Female');?>
<tr><td><?php ctrl_input_radio($errors,'gender',$genderValues,$genderLabels,'classNameNotImplemented',$selectedGender); ?></td></tr>
<tr><td><?php ctrl_submit('Save'); ?></td></tr>
</tbody>
</table>
</form>
</body>
</html>