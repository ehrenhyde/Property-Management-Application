<form class= 'loginForm' action = "login.php" method = "POST" name = "login">
<?php

	require 'includes/functions/formControls.php'; ?>
	<table class="table">

		<tbody>
			
			<tr><td>Username (Email)</td><td><?php ctrl_input_field($errors,'text','REQUIRED','email','', 'txtInput',null,1); ?></td></tr>
			<tr><td>Password</td><td><?php ctrl_input_field($errors,'password','REQUIRED','password','','txtInput',null,2); ?></td></tr>
			<tr><td><?php ctrl_submit('Login',null,3); ?></td></tr>
		</tbody>
			
	</table>
	
</form>