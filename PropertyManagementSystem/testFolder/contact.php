<?php

$to = 'lucas_nielsen1@hotmail.com';
$subject = 'This is your first message';
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$message = <<<EMAIL

Hi, My name is $name.

$message

From $name
My email is $email

EMAIL;
$header = "$email";
if ($_POST){
mail($to, $subject, $message, $header);
$feedback = 'Thank your submitting an email';
}


?>


<html>
<head>
	<title>Welcome to Property Management</title>
	<style type="text/css">
	form {
		width = 400px;
	}
	form ul {
		list-style-type: none;	
	}
	form ul li {
		margin: 15px 0;
	}
	form label {
		display: block;
		font-size: 2em;	
	}
	form input textarea {
		font-size: 2em;
		padding: 5px;
		border: #ccc 3px solid;	
		width: 100%;
	}	
	</style>
</head>
<body>
	<p id="feedback"><?php echo $feedback; ?></p>
	<form action="?" method="post">
		<ul>
			<li>
				<label for="name">Name: </label>
				<input type="text" name="name" id="name" />
			</li>
			<li>
				<label for="email">Email: </label>
				<input type="text" name="email" id="email" />
			</li>
			<li>
				<label for="message">Message: </label>
				<textarea id="message" name="message" cols="42" rows="9"></textarea>
			</li>
			<li><input type="submit" value="submit"></li>
		</ul>
	</form>
</body>
</html>