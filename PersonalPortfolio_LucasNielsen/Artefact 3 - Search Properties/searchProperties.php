<?php include ('includes/functions/db.php'); ?>
<?php include('includes/accountSessions.php') ?>


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
	<!-- <link rel='stylesheet' href = 'css/search.css' type = 'text/css'/> -->
</head>

<body>
<?php include('/includes/content/topNav.php'); ?>
<div class="page-header">
<h1>Property Search</h1>
<form class="searchBox" method="post" action="searchProperties.php">
<fieldset>
	<?php 
		//Created the search form - Lucas
		include ('includes/functions/formControls.php');
		//fetch whole house property details
		$wHouseDetails = db_getWHouseDetails($propertyId);
		//create address input 
		ctrl_input_field($errors,'text','REQUIRED','searchinput','Address    ','txtAddress',$wHouseDetails['address']);

		//all values for select inputs
		$value_propertytype = array('Property Type', 'WholeHouse','ShareHouse');
		$value_bedMin = array('Min Beds','1','2','3','4','5');
		$value_bedMax = array('Max Beds','1','2','3','4','5');
		$value_priceMin = array('Min Price','50000','100000','200000','300000','400000','500000','1000000','10000000');
		$value_priceMax = array('Max Price','50000','100000','200000','300000','400000','500000','1000000','10000000');
		//select inputs in search form
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

<div id=searchResults>
   
	  
	<?php
		if(isset($_POST['submit'])){
			if ($_POST['propertyType'] == 2){ // if sharehouse input for propertytype
				$results = db_searchProperties_s_house($_POST['searchinput'],$_POST['MinBed'],$maxBed); //select values where search conditions met		
				foreach( $results as $row ){
		
				?><div class="panel panel-primary">
				<div class="panel-heading"><h3 class="panel-title"><?php echo ''.$row['address'].'';?></h3></div>
				<div class="panel-body">
				<table class="table"><tr><td><div id=Picture><img style="max-width: 250px; max-height: 250px" src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>"/></div></td></tr><?php
				
				echo '<tr><td>Number of rooms:'. $row['numberOfRooms'].'</td>'; // Display number of rooms
				echo "<td><a href='sHouseProperty.php?data=".$row['sHouseId']."'>More Details</a></td></tr>"; //pass sharehouse id to view sharehouse property page
				echo "<td><a href='updateSHouse.php?sHouseId=".$row['sHouseId']."'>Edit</a></td></tr>"; // pass sharehouse id to update sharehouse property page
				echo "<tr><td><div class=\"linediv\"></div></td></tr></table></div></div>";
			}
			} else{ //if wholehouse propertytype input
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
				foreach( $results as $row ){ //return all results to searchpage
		
				?><div class="panel panel-primary">
				<div class="panel-heading"><h3 class="panel-title"><?php echo ''.$row['Address'].'';?></h3></div>
				<div class="panel-body">
				<table class="table"><tr><td><div id=Picture><img style="max-width: 250px; max-height: 250px" src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>"/></div></td></tr><?php
				
				echo '<tr><td>Number of rooms:'. $row['NumberofRooms'].'</td><td>Buying Price:'. $row['BuyingPrice'].'</td>';
				echo "<td><a href='wHouseProperty.php?data=".$row['propertyId']."'>More Details</a></td></tr>";
				echo "<td><a href='updateWHouse.php?propertyId=".$row['propertyId']."'>Edit</a></td></tr>";
				echo "<tr><td><div class=\"linediv\"></div></td></tr></table></div></div>";
			}
				
			}
		}			
		
	?>



</div>

</body>
</html>
