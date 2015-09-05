<html>

<head>

<title>Property Data</title>

</head>

<body>

<?php
include('includes/content/topNav.php');
include ('/includes/functions/db.php');
$pdo=db_connect();

$id=(isset($_GET["data"])) ? (int)$_GET["data"] : 1;

$stmt = $pdo->prepare(
						"SELECT * FROM v_w_house_property_details WHERE propertyId = '.$id.'");					
		
	$stmt->execute();
		
		
	$result = $stmt->fetch(PDO::FETCH_OBJ);
	



?>
<table>
<?php 
echo("<tr><td>Picture</td></tr><tr><td>$result->Address</td></tr><tr><td>$result->NumberofRooms</td></tr><tr><td>$result->BuyingPrice</td></tr><tr><td>$result->Description</td></tr>"); 


?>
</table>

</body>

</html>