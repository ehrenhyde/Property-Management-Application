<?php
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');
include ('includes/accountSessions.php');
include ('includes/functions/mail.php');

$errors = array();

if (isset($_POST['submit'])){
	
	require 'includes/functions/validate.php';
	require "phpmailer/class.phpmailer.php"; 
	
	validateEmail($errors,$_POST,'email',true);
	validateText($errors, $_POST,'firstName',true);
	validateText($errors, $_POST,'lastName');
	validateDOB($errors, $_POST, 'DOB',true);
	validateText($errors, $_POST, 'password',true);
	
	if (!$errors){
		
		$isMale = NULL;
		if (isset ($_POST['gender']) && $_POST['gender'] == 'male'){
			$isMale = true;		
		} else {
			$isMale = false;
		}
		$confirmCode=md5(uniqid(rand()));
		
		db_addTenant_temp($confirmCode,$_POST['email'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],$_POST['DOB'],$isMale,$_FILES["user_files"]);	
		
		mail_send_registration_code($confirmCode,$_POST['email'],$_POST['fullname'],$_POST['firstName'],1);//Inserted this line
			
		header("location: http://{$_SERVER['HTTP_HOST']}/searchProperties.php");
		exit();	
	}	
}
?>
<html lang="en">
<head>
    
<title>Register Owner</title>
<?php include ('includes/content/bootstrapHead.php'); ?>
<script src='js/jquery-2.1.4.min.js'></script>
<?php include('includes/content/DOBCheck.php'); ?>
<script>

function checkValid(){
	
	var p1Field = document.getElementById('password');
	var p2Field = document.getElementById('password2');
	var Check = document.getElementById('T&C').checked;
	var btnSubmit = document.getElementById('btnSubmit');
	
	var p1 = p1Field.value;	
	var p2 = p2Field.value;
	
	
	if (p1 != p2 || p1==''){
		console.log('setting red');
		p2Field.style.background = 'red';
		btnSubmit.disabled=true;
		return false;
	}else{
		console.log('setting green');
		p2Field.style.background = 'green';
		if (Check == true){
			btnSubmit.disabled=false;
		}
	}
}

$(document).ready(function(){
	
	var p1Field = document.getElementById('password');
	var p2Field = document.getElementById('password2');
	var btnSubmit = document.getElementById('btnSubmit');
	var chk = document.getElementById('T&C');
	
	btnSubmit.disabled=true;
	
	p1Field.onpaste = checkValid;
	p1Field.oninput = checkValid;
	
	p2Field.onpaste = checkValid;
	p2Field.oninput = checkValid;
	
	chk.onchange = checkValid;
});

</script>
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
		
	<script type="text/javascript">
		location.href = 'login.php';
	</script>
	
<?php
		exit();
	}	
?>

<form class= 'regForm' enctype="multipart/form-data" action = "registerOwner.php" method = "POST" name = "registerOwnerAccount">
<table class="table">

	<tbody>
<tr><td>Profile Picture</td><td><input type="file" name="user_files" id="user_files" tabindex='1'></td></tr>
<tr><td>Your Email</td><td><?php ctrl_input_field($errors,'text','REQUIRED','email','','txtEmail',$ownerDetails['email'],2);?></td></tr>
<tr><td>Password</td><td><?php ctrl_input_field($errors,'password','REQUIRED','password','','txtPassword',null,1);?></td></tr>
<tr><td>Verify Password</td><td><?php ctrl_input_field($errors,'password','REQUIRED','password2','','txtPassword',null,2);?></td></tr>
<tr><td>First Name</td><td><?php ctrl_input_field($errors,'text','REQUIRED','firstName','','txtFirstName',$ownerDetails['firstName'],4); ?></td></tr>
<tr><td>Last Name</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','lastName','','txtLastName',$ownerDetails['lastName'],5); ?></td></tr>
<tr><td>Date of Birth</td><td><?php ctrl_input_field($errors,'date','OPTIONAL','DOB','','dtpDOB',$ownerDetails['DOB'],6);	?><span id ='dateWarning'>Not Over 18!</span></td></tr>
<?php $genderValues = array('male','female');
$genderLabels = array('Male','Female');?>
<tr><td><?php ctrl_input_radio($errors,'gender',$genderValues,$genderLabels,'classNameNotImplemented',$selectedGender,7); ?></td></tr>
<tr><td></td><td><div style="align:center; height:310px;width:640px;overflow:auto;
background-color:lightgrey;color:black;scrollbar-base-color:gold;
font-family:sans-serif;padding:10px;">
<h3>Terms and Conditions</h3><br>
<p>Last updated: 22/10/2015.<br>
Please read these Terms and Conditions carefully before using<br>
the <a href="52.26.240.26">52.26.240.26</a> website the Real Estate Service operated by SMELT Pty. Ltd.<br>
Your access to and use of the Service is conditioned on your acceptance of and compliance with<br>
these Terms. These Terms apply to all visitors, users and others who access or use the Service.<br>
By accessing or using the Service you agree to be bound by these Terms. If you disagree with any<br>
part of the terms then you may not access the Service.<br>
Termination clause for websites that do not have accounts. If your website or mobile app allows<br>
users to register and have an account, create your own Terms and Conditions.<br>
Termination<br>
We may terminate or suspend access to our Service immediately, without prior notice or liability, for<br>
any reason whatsoever, including without limitation if you breach the Terms.<br>
All provisions of the Terms which by their nature should survive termination shall survive<br>
termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and<br>
limitations of liability.<br>
Disclaimer: Legal information is not legal advice. Read the disclaimer.<br>
Links To Other Web Sites<br>
Our Service may contain links to third­party web sites or services that are not owned or controlled<br>
by SMELT Pty. Ltd.<br>
SMELT Pty. Ltd. has no control over, and assumes no responsibility for, the content,<br>
privacy policies, or practices of any third party web sites or services. You further acknowledge and<br>
agree that SMELT Pty. Ltd. shall not be responsible or liable, directly or indirectly, for<br>
any damage or loss caused or alleged to be caused by or in connection with use of or reliance on<br>
any such content, goods or services available on or through any such web sites or services.<br>
We strongly advise you to read the terms and conditions and privacy policies of any third­party web<br>
sites or services that you visit.<br>
Governing Law<br>
These Terms shall be governed and construed in accordance with the laws of Australia, <br>
without regard to its conflict of law provisions.<br>
Our failure to enforce any right or provision of these Terms will not be considered a waiver of those<br>
rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the<br>
remaining provisions of these Terms will remain in effect. These Terms constitute the entire<br>
agreement between us regarding our Service, and supersede and replace any prior agreements we<br>
might have between us regarding the Service.<br>
Changes<br>
We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a<br>
revision is material we will try to provide at least 30 days notice prior to any new terms<br>
taking effect. What constitutes a material change will be determined at our sole discretion.<br>
Create your own Terms and Conditions<br>
Contact Us<br>
If you have any questions about these Terms, please contact us.<br>
Disclaimer: Legal information is not legal advice. Read the disclaimer.<br></p></div></td></tr>
<tr><td></td><td><input id="T&C"type="checkbox">&nbsp;I agree to the Terms and Conditions</td></tr>
<tr><td><?php ctrl_submit('Save','btnSubmit',8); ?></td></tr>
</tbody>
</table>
</form>
</body>
</html>