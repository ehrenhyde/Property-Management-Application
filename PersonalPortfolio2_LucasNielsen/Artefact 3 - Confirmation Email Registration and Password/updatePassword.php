
<?php
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');
include('includes/accountSessions.php');
include ('includes/functions/mail.php');


$errors = array();
$loginId = $_SESSION['idLogin'];


if (isset($_POST['submit'])){
	require 'includes/functions/validate.php';
	require "phpmailer/class.phpmailer.php";
	
	validateText($errors, $_POST,'password1');
	validateText($errors, $_POST,'password2');
	
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	
	if (!$errors && $password1 == $password2){
	
		db_updatePassword($loginId,$password1);
		
		$contactDetails = db_getContactDetails($loginId);
		//Included this line
		mail_acknowledge_password_reset($contactDetails['email'],$contactDetails['firstName'],$contactDetails['lastName']);
		
		
		header("location: http://{$_SERVER['HTTP_HOST']}");
		exit();	
	}	
}else{
	//echo "<h1>NOTHING SUBMITTED</h1>";
}
?>
<html lang="en">
  <head>
    
<title>Password Reset</title>
<?php include ('includes/content/bootstrapHead.php'); ?>


<script>

function checkPasswords(){
	
	var p1Field = document.getElementById('password1');
	var p2Field = document.getElementById('password2');
	var btnSubmit = document.getElementById('btnPasswordSubmit');
	
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
		btnSubmit.disabled=false;
	}
}

$(document).ready(function(){
	
	var p1Field = document.getElementById('password1');
	var p2Field = document.getElementById('password2');
	var btnSubmit = document.getElementById('btnPasswordSubmit');
	
	btnSubmit.disabled=true;
	
	p1Field.onpaste = checkPasswords;
	p1Field.oninput = checkPasswords;
	
	p2Field.onpaste = checkPasswords;
	p2Field.oninput = checkPasswords;
});

</script>

</head>
<body>
<?php 
	?>
		<div class="page-header">
	<h1>Password Reset</h1>
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
			<h3 class="panel-title">Type New Password</h3>
		</div>
	<div class="panel-body">
<?php include('includes/content/topNav.php'); ?>
<form class= 'editForm' action = "updatePassword.php" method = "POST" name = "updatePassword" onsubmit = 'checkPasswords'>


<table class="table">

			<tbody>
	
<tr><td>New Password</td><td><?php ctrl_input_field($errors,'password','REQUIRED','password1','','txtPassword',null,1);?></td></tr>
<tr><td>Type Again</td><td><?php ctrl_input_field($errors,'password','REQUIRED','password2','','txtPassword',null,2);?></td></tr>
<tr><td><?php ctrl_submit('Save','btnPasswordSubmit'); ?></td></tr>
</tbody>
</table>
</form>
</body>
</html>