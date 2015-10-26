<?php include('includes/accountSessions.php') ?>
<?php include('includes/functions/db.php') ?>

<html lang="en">
  <head>
    
<title>Logout </title>
<?php include ('includes/content/bootstrapHead.php'); ?>
</head>
<body>
	
<body>

	<?php
	if($_SESSION){
	
	
	
	// Unset all of the session variables.
	$_SESSION = array();
	
	// Destroy the session, and not just the session data!
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
		);
	}
	
	// Destroy the session
	session_destroy();
	
	}else{
		
	}
?>


	<p style="visibility: hidden;">You will be redirected to the home page in <span id="counter">1</span> second(s).</p>
	<script type="text/javascript">
		function countdown() {
		
			var i = document.getElementById('counter');
			if (parseInt(i.innerHTML)==1) {
				location.href = 'homePage.php';
			}		
		}
		setInterval(function(){ countdown(); },300);
	</script>
</body>
</html>
