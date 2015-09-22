<form class= 'loginForm' action = "login.php" method = "POST" name = "login">
<?php

	require 'includes/functions/formControls.php'; ?>
	<table class="table">

		<tbody>
			
			<tr><td>Username (Email)</td><td><?php ctrl_input_field($errors,'text','REQUIRED','email','', 'txtInput'); ?></td></tr>
			<tr><td>Password</td><td><?php ctrl_input_field($errors,'password','REQUIRED','password','','txtInput'); ?></td></tr>
			<tr><td><?php ctrl_submit('Login'); ?></td></tr>
		</tbody>
			
	</table>
	
</form>