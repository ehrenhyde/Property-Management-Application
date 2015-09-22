<html>

<head>
<title>Property Data</title>
</head>

<body>


<table>

<?php 


include ('/includes/functions/db.php');


$id=(isset($_GET["data"])) ? (int)$_GET["data"];

$pdo=db_connect();
$stmt = $pdo->prepare(
						"SELECT * FROM v_w_house_property_details");						
		
	$stmt->execute();
		
	$result = $stmt->fetch(PDO::FETCH_OBJ);
	echo($result);



echo("<tr><td>Picture</td></tr><tr><td>$result->Address</td></tr><tr><td>$result->NumberofRooms</td></tr><tr><td>$result->BuyingPrice</td></tr><tr><td>$result->Description</td></tr>"); 
?>


</table>





</body>

</html>