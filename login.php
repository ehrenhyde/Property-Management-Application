<?php include('includes/accountSessions.php') ?>
<?php include('includes/functions/db.php') ?>

<html>
<head>
	<title>Login</title>
	<link rel='stylesheet' href='css/global.css' type='text/css'/>
	<link rel='stylesheet' href='css/login.css' type='text/css'/>
</head>
<body>
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