
<html>
<title>Search data</title>
<head>
<link rel='stylesheet' href = 'css/global.css' type = 'text/css'/>
</head>

<body>
<?php include('/includes/content/topNav.php'); ?>

<form method="post" action="search1.php">
<fieldset>
<?php 
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');

$wHouseDetails = db_getWHouseDetails($propertyId);

ctrl_input_field($errors,'text','REQUIRED','address','Address<br>','txtAddress',$wHouseDetails['address']);


	?>		
		
		<table>
			<tr><td>Property Type</td><td>Min Bed</td><td>Max Bed</td><td>Min Price</td><td>Max Price</td></tr>
		</table>
		<?php
		$value_propertytype = array('Any', 'WholeHouse','ShareHouse');
		$value_bed = array('Any','1','2','3','4','5');
		$value_price = array('Any','50000','100000','200000','300000','400000','500000','1000000');
		
		ctrl_select($errors,'propertyType',$value_propertytype,'Class_1','');
		ctrl_select($errors,'Min Bed',$value_bed,'Class_2','');
		ctrl_select($errors,'Max Bed',$value_bed,'Class_3','');
		ctrl_select($errors,'Min Price',$value_price,'Class_4','');
		ctrl_select($errors,'Max Price',$value_price,'Class_5','');
		ctrl_submit('Search','submit');
		?>
		
		
		
	</fieldset>
</form>

<table>

  <tr>

    <td align="center">Property Data</td>

  </tr>

  <tr>

    <td>

      <table border="0">      
<?php


if(isset($_POST['submit'])){


	
$address=$_POST['searchinput'];
$Minrooms=$_POST['Min Bed'];
$Maxrooms=$_POST['Max Bed'];
$Minprice=$_POST['Min Price'];
$Maxprice=$_POST['Max Price'];

$pdo=db_connect();
$stmt = $pdo->prepare(
						'SELECT propertyId,NumberofRooms,BuyingPrice,Address FROM v_w_house_property_details '.
						'WHERE Address LIKE '%" . $address .  "%''
						);
		
	$stmt->execute();
		
	$result = $stmt->fetch(PDO::FETCH_OBJ);
	echo "<tr><td>Picture</td></tr><tr><td>$result->Address</td></tr>";
echo "<tr><td>$result->NumberofRooms</td></tr><tr><td>$result->BuyingPrice</td></tr>";
echo("<tr><td><a href='page.php?data=".$result->propertyId."'>Details</a></td></tr>");
}
?>




    </table>

  </td>

</tr>

</table>

</body>