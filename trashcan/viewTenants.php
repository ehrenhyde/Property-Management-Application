<!doctype html>
<html>
<head>
</head>
<body>

<?php


//db_viewTenantDetails();
$tenants = array(
    array("email" => "john@email.com", "firstName" => "John", "lastName" => "Doe"),
    array("email" => "fred@email.com", "firstName" => "Fred", "lastName" => "Smith"),
	array("email" => "sally@email.com", "firstName" => "Sally", "lastName" => "Parker")
);

echo '<ul id = tenantsList>';

foreach ($tenants as $tenant){
	$email = $tenant['email'];
	$firstName = $tenant['firstName'];
	$lastName = $tenant['lastName'];
	echo "<li><span class='tenantName'>$email</span>";
	echo "<span class='firstName'>$firstName</span>";
	echo "<span class='lastName'>$lastName</span></li>";
}

echo '</ul>';


?>

</body>
</html>