<form class= 'loginForm' action = "login.php" method = "POST" name = "login">
<?php

	require 'includes/functions/formControls.php';
	ctrl_input_field($errors,'text','REQUIRED','email','Username (Email)', 'txtInput');
	ctrl_input_field($errors,'password','REQUIRED','password','Password','txtInput');
	ctrl_submit('Login');
?>
</form>