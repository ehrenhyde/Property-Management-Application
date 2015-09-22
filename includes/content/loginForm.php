<form class= 'loginForm' action = "login.php" method = "POST" name = "login">
<?php

<<<<<<< HEAD
	require 'includes/functions/formControls.php'; ?>
	<table class="table">

		<tbody>
			
			<tr><td>Username (Email)</td><td><?php ctrl_input_field($errors,'text','REQUIRED','email','', 'txtInput'); ?></td></tr>
			<tr><td>Password</td><td><?php ctrl_input_field($errors,'password','REQUIRED','password','','txtInput'); ?></td></tr>
			<tr><td><?php ctrl_submit('Login'); ?></td></tr>
		</tbody>
			
	</table>
	
=======
	require 'includes/functions/formControls.php';
	ctrl_input_field($errors,'text','REQUIRED','email','Username (Email)', 'txtInput');
	ctrl_input_field($errors,'password','REQUIRED','password','Password','txtInput');
	ctrl_submit('Login');
?>
>>>>>>> origin/master
</form>