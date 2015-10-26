

<?php

// Including the requierd libraries.

 include ('includes/functions/db.php'); ?>
<?php include('includes/accountSessions.php') ?>


<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- Referencing the required CSS files -->
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
<form class="searchBox" method="post" action="searchProperties.php">
<fieldset>
	<?php 
		
		include ('includes/functions/formControls.php');

		$wHouseDetails = db_getWHouseDetails($propertyId);

		ctrl_input_field($errors,'text','REQUIRED','searchinput','Address    ','txtAddress',$wHouseDetails['address']);

		
		$value_propertytype = array('Property Type', 'WholeHouse','ShareHouse');
		$value_bedMin = array('Min Beds','1','2','3','4','5');
		$value_bedMax = array('Max Beds','1','2','3','4','5');
		$value_priceMin = array('Min Price','50000','100000','200000','300000','400000','500000','1000000','10000000');
		$value_priceMax = array('Max Price','50000','100000','200000','300000','400000','500000','1000000','10000000');
		
		ctrl_select($errors,'propertyType',$value_propertytype,'Class_1','');
		ctrl_select($errors,'MinBed',$value_bedMin,'Class_2','');
		ctrl_select($errors,'MaxBed',$value_bedMax,'Class_3','');
		ctrl_select($errors,'MinPrice',$value_priceMin,'Class_4',true);
		ctrl_select($errors,'MaxPrice',$value_priceMax,'Class_5',true);
		ctrl_submit('Search','submit');
	?>
</fieldset>
</form>
</div>
   
	  
	<?php
		if(isset($_POST['submit'])){
			if ($_POST['propertyType'] == 2){
				$results = db_searchProperties_s_house($_POST['searchinput'],$_POST['MinBed'],$maxBed);				
				foreach( $results as $row ){
		
				?><div class="col-xs-offset-2"><div class="col-sm-9">
				<div class="panel panel-primary">
				<div class="panel-heading"><h3 class="panel-title"><?php echo ''.$row['address'].'';?></h3></div>
				<div class="panel-body">
				<table class="table"><tr><td><div id=Picture><img style="max-width: 250px; max-height: 250px" src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>"/></div></td></tr><?php
				
				echo '<tr><td>Number of rooms:'. $row['numberOfRooms'].'</td>';
				echo "<td><a href='sHouseProperty.php?data=".$row['sHouseId']."'>More Details</a></td></tr>";
				echo "<td><a href='updateSHouse.php?sHouseId=".$row['sHouseId']."'>Edit</a></td></tr>";
				echo "<td><a href='addSHouseRoom.php?sHouseId=".$row['sHouseId']."'>Add Room</a></td></tr>";
				echo "<tr><td><div class=\"linediv\"></div></td></tr></table></div></div>";
				echo "</div></div>";
			}
			} else{
				$maxBed;
			if ($_POST['MaxBed'] == 0){
				$maxBed = null;
			}else{
				$maxBed = $_POST['MaxBed'];
			}
			
			$maxPrice;
			if ($_POST['MaxPrice'] == 0){
				$maxPrice = null;
			}else{
				$maxPrice =$_POST['MaxPrice'];
			}
				$results = db_searchProperties($_POST['searchinput'],$_POST['MinBed'],$maxBed,$_POST['MinPrice'],$maxPrice);
				foreach( $results as $row ){
		
				?><div class="panel panel-primary">
				<div class="panel-heading"><h3 class="panel-title"><?php echo ''.$row['Address'].'';?></h3></div>
				<div class="panel-body">
				<table class="table"><tr><td><div id=Picture><img style="max-width: 250px; max-height: 250px" src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>"/></div></td><?php
				
				echo '<tr><td>Number of rooms:'. $row['NumberofRooms'].'</td><td>Suburb:'. $row['suburb'].'</td>';
				echo '<tr><td>Number of carparks:'. $row['NumberofCarParks'].'</td><td>State:'. $row['state'].' '.$row['postcode'].'</td>';
				echo '<tr><td>Number of bathrooms:'. $row['NumberofBathrooms'].'</td><td>Buying Price:'. $row['BuyingPrice'].'</td>';
				echo "<td><a href='wHouseProperty.php?data=".$row['propertyId']."'>More Details</a></td></tr>";
				echo "<td><a href='updateWHouse.php?propertyId=".$row['propertyId']."'>Edit</a></td></tr>";
				echo "<tr><td><div class=\"linediv\"></div></td></tr></table></div></div></div></div>";
			}
				
			}
		}			
		
	?>





</body>
</html>
