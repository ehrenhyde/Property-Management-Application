<?php include('includes/accountSessions.php') ?>
<?php include('includes/functions/db.php') ?>

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
<title>Login </title>
</head>
<body>
<?php include('/includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Login</h1>
</div>
<div class="col-xs-offset-2"><div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Login Details</h3>
		</div>
	<div class="panel-body">
<body>
=======
<html>
<head>
	<title>Login</title>
	<link rel='stylesheet' href='css/global.css' type='text/css'/>
	<link rel='stylesheet' href='css/login.css' type='text/css'/>
</head>
<body>
>>>>>>> origin/master
<?php include('includes/content/topNav.php'); ?>

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
			
			header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/searchProperties.php");
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
</body>
</html>