<html>
<head></head>
<?php
	$id=$_GET["propertyId"];
	include('includes/accountSessions.php');
	include('includes/functions/db.php');
	$addressMap = db_getAddress($id);
?>
<body>
<?php
$result = db_getWHouseDetails($id); ?>
		<img style="height:300px" src="data:<?php echo $result['floorPlanImageType'] ?>;base64,<?php echo base64_encode( $result["floorPlan"] ); ?>" alt="Sorry no floor plan available!">
</body>
</html>