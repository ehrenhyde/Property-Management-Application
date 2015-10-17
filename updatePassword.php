
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/theme.css" rel="stylesheet">
<title>Password Reset</title>

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

window.onload = function(){
	
	var p1Field = document.getElementById('password1');
	var p2Field = document.getElementById('password2');
	var btnSubmit = document.getElementById('btnPasswordSubmit');
	
	btnSubmit.disabled=true;
	
	p1Field.onpaste = checkPasswords;
	p1Field.oninput = checkPasswords;
	
	p2Field.onpaste = checkPasswords;
	p2Field.oninput = checkPasswords;
};

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
		<p>You will be redirected to the home page in <span id="counter">5</span> second(s).</p>
	<script type="text/javascript">
		function countdown() {
		
		var i = document.getElementById('counter');
			
		if (parseInt(i.innerHTML)<=1) {
			location.href = 'login.php';
		}
		
		i.innerHTML = parseInt(i.innerHTML)-1;
		}
		setInterval(function(){ countdown(); },500);
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
	
<tr><td>New Password</td><td><?php ctrl_input_field($errors,'password','REQUIRED','password1','','txtPassword');?></td></tr>
<tr><td>Type Again</td><td><?php ctrl_input_field($errors,'password','REQUIRED','password2','','txtPassword');?></td></tr>
<tr><td><?php ctrl_submit('Save','btnPasswordSubmit'); ?></td></tr>
</tbody>
</table>
</form>
</body>
</html>