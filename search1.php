<!--Created and Modified By Lucas and Michael.
Michael: Modification of the forms and tables with controlled CSS
Lucas: Created all forms, tables and in general foundation of page with html, PHP and MySql
    -->
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="css/theme.css" rel="stylesheet">
	<title>Search data</title>
	<link rel='stylesheet' href = 'css/search.css' type = 'text/css'/>
</head>

<body>
<?php include('/includes/content/topNav.php'); ?>
<div class="page-header">
<h1>Property Search</h1>
<form class="searchBox" method="post" action="search1.php">
<fieldset>
	<?php 
		include ('includes/functions/db.php');
		include ('includes/functions/formControls.php');

		$wHouseDetails = db_getWHouseDetails($propertyId);

		ctrl_input_field($errors,'text','REQUIRED','searchinput','Address    ','txtAddress',$wHouseDetails['address']);

		
		$value_propertytype = array('Property Type', 'WholeHouse','ShareHouse');
		$value_bedMin = array('Min Beds','1','2','3','4','5');
		$value_bedMax = array('Max Beds','1','2','3','4','5');
		$value_priceMin = array('Min Price','50000','100000','200000','300000','400000','500000','1000000','10000000');
		$value_priceMax = array('Max Price','50000','100000','200000','300000','400000','500000','1000000','10000000');
		
		ctrl_select($errors,'propertyType',$value_propertytype,'Class_1','');
		ctrl_select($errors,'Min Bed',$value_bedMin,'Class_2','');
		ctrl_select($errors,'Max Bed',$value_bedMax,'Class_3','');
		ctrl_select($errors,'Min Price',$value_priceMin,'Class_4','');
		ctrl_select($errors,'Max Price',$value_priceMax,'Class_5','');
		ctrl_submit('Search','submit');
	?>
</fieldset>
</form>
</div>

<div id=searchResults>
<table class=results>
   
	  
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
								'WHERE Address == '%" . $address .  "%''
								//'OR NumberofRooms BETWEEN '%" . $Minrooms .  "%' AND '%" . $Maxrooms .  "%''.
								//'OR BuyingPrice BETWEEN '%" . $Minprice .  "%' AND '%" . $Maxprice .  "%''
								);
				
			$stmt->execute();
				
			$result = $stmt->fetchAll();
		foreach( $result as $row ){
    
		
		echo "<tr><td style=\"font-size:40px\">Insert Picture Here</td></tr>";
		echo '<tr><td style=\"font-size:20px\>'.$row['Address'].'</td></tr>';
		echo '<tr><td>Number of rooms:'. $row['NumberofRooms'].'</td><td>Buying Price:'. $row['BuyingPrice'].'</td>';
		echo "<td><a href='page.php?data=".$row['propertyId']."'>More Details</a></td></tr>";
		echo "<tr><td><div class=\"linediv\"></div></td></tr>";
		
		}
		}
		
	?>


</table>
</div>

</body>
</html>
