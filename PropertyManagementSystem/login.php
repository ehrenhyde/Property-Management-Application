<?php include('includes/accountSessions.php') ?>
<?php include('includes/functions/db.php') ?>

<html lang="en">
  <head>
   
<title>Login </title>
<?php include ('includes/content/bootstrapHead.php'); ?>

</head>
<body>
<?php include('includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Login</h1>
</div>
<div class="col-xs-offset-2"><div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Login Details</h3>
		</div>
		<div class="panel-body">
<?php

$errors = array();

if (isset($_POST['submit'])){
	//was sent data
	
	$email = $_POST['email'];
	
	require 'includes/functions/validate.php';
	
	validateEmail($errors,$_POST,'email');
	validateText($errors,$_POST,'password');
	
	
	if ($errors){
		
		include('includes/content/loginForm.php');
	}else{
		
		//do login
		if (db_isValidCred($email,$_POST['password'])){
			
			$_SESSION['loggedIn'] = true;
			$_SESSION['idLogin'] = db_getIdLogin($email);
			
			
			header("location: http://{$_SERVER['HTTP_HOST']}");
			
			exit();	
		}else{
			
			$badCredsMsg = 'wrong username or password';
			$errors['password'] = $badCredsMsg;
			include('includes/content/loginForm.php');
		}
	}
}else{
	include('includes/content/loginForm.php');
}

	

?>
</div>
</body>
</html>