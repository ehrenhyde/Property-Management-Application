<?php

// configuration



$dbhost     = "localhost";

$dbname     = "world";

$dbuser     = "admin";

$dbpass     = "admin";

 

// database connection

$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);

 

// query

$sql = "SELECT Id,Picture FROM propertypic";

$q = $conn->prepare($sql);

$q->execute();

 

$q->bindColumn(1, $Id);

$q->bindColumn(2, $Picture, PDO::PARAM_LOB);

 

while($q->fetch())

{



echo "<img src='".$Id.".bmp'> <br/>";

}

 

?>
