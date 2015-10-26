

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
<?php
include('includes/content/topNav.php');
?>
<div class="page-header">
<center>
	<h1>Property Search</h1>
</center>
<form class="searchBox" method="get" action="searchProperties.php">
<fieldset>
	<?php 
		
		include ('includes/functions/formControls.php');

		$wHouseDetails = db_getWHouseDetails($propertyId);
		$suburb = db_getSuburbs();
		$suburbs = array ('%%'=>'Suburb');
		foreach ($suburb as $row2){
			$suburbs[$row2['suburb']]=$row2['suburb'];
			
		}
		ctrl_input_field($errors,'text','REQUIRED','Searchinput','Address    ','txtAddress',$wHouseDetails['address'],1);

		
		$value_propertytype = array(0=>'Property Type', 1=>'WholeHouse',2=>'ShareHouse');
		$value_bedMin = array(null=>'Min Beds',1=>'1',2=>'2',3=>'3',4=>'4',5=>'5');
		$value_bedMax = array(null=>'Max Beds',1=>'1',2=>'2',3=>'3',4=>'4',5=>'5');
		$value_bathMin = array(null=>'Min Baths',1=>'1',2=>'2',3=>'3',4=>'4',5=>'5');
		$value_bathMax = array(null=>'Max Baths',1=>'1',2=>'2',3=>'3',4=>'4',5=>'5');
		$value_carParkMin = array(null=>'Min CarParks',1=>'1',2=>'2',3=>'3',4=>'4',5=>'5');
		$value_carParkMax = array(null=>'Max CarParks',1=>'1',2=>'2',3=>'3',4=>'4',5=>'5');
		array_unshift($suburb,'Suburb');
		$value_priceMin = array(null=>'Min Price',50000=>'$50,000',100000=>'$100,000',200000=>'$200,000',300000=>'$300,000',400000=>'$400,000',500000=>'$500,000',1000000=>'$1,000,000',10000000=>'$10,000,000');
		$value_priceMax = array(null=>'Max Price',50000=>'$50,000',100000=>'$100,000',200000=>'$200,000',300000=>'$300,000',400000=>'$400,000',500000=>'$500,000',1000000=>'$1,000,000',10000000=>'$10,000,000');
		
		ctrl_select($errors,'PropertyType',$value_propertytype,'Class_1');
		ctrl_select($errors,'MinBed',$value_bedMin,'Class_2');
		ctrl_select($errors,'MaxBed',$value_bedMax,'Class_3');
		ctrl_select($errors,'MinBath',$value_bathMin,'Class_4');
		ctrl_select($errors,'MaxBath',$value_bathMax,'Class_5');
		ctrl_select($errors,'MinCarPark',$value_carParkMin,'Class_6');
		ctrl_select($errors,'MaxCarPark',$value_carParkMax,'Class_7');
		ctrl_select($errors,'Suburb',$suburbs,'Class_8');
		ctrl_select($errors,'MinPrice',$value_priceMin,'Class_9');
		ctrl_select($errors,'MaxPrice',$value_priceMax,'Class_10');
		ctrl_submit('Search','submit');
	?>
</fieldset>
</form>
</div>
   
	  
	<?php
		if(isset($_GET['submit'])){
			
			$rowsPerPage = 5;
			
			
			//get page number but default to 1
			$pageNum = 1;
			if (isset($_GET['page'])){
				$pageNum = $_GET['page'];
			}
			
			$offset = ($pageNum - 1) * $rowsPerPage;
			
			//create a url which will get us back to where we are now, ignoring the page
			$baseSearchURL = "searchProperties.php?";
			foreach($_GET as $getParam => $value){
				if ($getParam != 'page'){
					$baseSearchURL = $baseSearchURL . $getParam . '='.$value . '&';
				}
			}

			//get the total number of results, either from the wHouse search or the sHouse search
			$numRowsTotal;
			if ($_GET['PropertyType'] == 1){
				$numRowsTotal = count(db_search_w_house($_GET['Searchinput'],$_GET['MinBed'],$_GET['MaxBed'],$_GET['MinPrice'],$_GET['MaxPrice'],$_GET['MinBath'],$_GET['MaxBath'],$_GET['MinCarPark'],$_GET['MaxCarPark'],$_GET['Suburb'],0,99999));
			}else{
				$numRowsTotal = count(db_search_s_house($_GET['Searchinput'],$_GET['MinBed'],$_GET['MaxBed'],$_GET['Suburb'],0,99999));
				
			}
			
			/*Maximum page number = total number of results divided by how many results each page has rounded up*/
			$maxPage = ceil($numRowsTotal/$rowsPerPage);
			
			?><div class="col-xs-offset-2"><div class="col-sm-9"><?php 
			if ($_GET['PropertyType'] == 1 || $_GET['PropertyType'] == 0){
				/*WholeHouse*/
				
				$results = db_search_w_house($_GET['Searchinput'],$_GET['MinBed'],$_GET['MaxBed'],$_GET['MinPrice'],$_GET['MaxPrice'],$_GET['MinBath'],$_GET['MaxBath'],$_GET['MinCarPark'],$_GET['MaxCarPark'],$_GET['Suburb'],$offset,$rowsPerPage);
				foreach( $results as $row ){
		
					?>
					<div class="panel panel-primary">
					<div class="panel-heading"><h3 class="panel-title"><?php echo ''.$row['address'].'';?></h3></div>
					<div class="panel-body">
					<table class="table"><tr><td><div id='Picture'><img async style="max-width: 250px; max-height: 250px" src="data:image/jpeg;base64,<?php  echo base64_encode( $row["image"] ); ?>"/></div></td></tr><?php
					
					echo '<tr><td>Number of rooms: '. $row['numRooms'].'</td><td>Suburb: '. $row['suburb'].'</td>';
					echo '<tr><td>Number of carparks: '. $row['numCarParks'].'</td><td>State: '. $row['state'].' '.$row['postcode'].'</td>';
					echo '<tr><td>Number of bathrooms: '. $row['numBath'].'</td><td>Buying Price: $'. $row['buyingPrice'].'</td>';
					echo "<td><a href='wHouseProperty.php?propertyId=".$row['propertyId']."'>More Details</a></td></tr>";
					?>
					</table></div></div>
					<?php 
				}
		
				
			} else{
				$results = db_search_s_house($_GET['Searchinput'],$_GET['MinBed'],$_GET['MaxBed'],$_GET['Suburb'],$offset,$rowsPerPage);
				

				
				foreach( $results as $row ){
		
					?>
					<div class="panel panel-primary">
					<div class="panel-heading"><h3 class="panel-title"><?php echo ''.$row['address'].'';?></h3></div>
					<div class="panel-body">
					<table class="table">
						<tr><td><div id=Picture>
						<img async style="max-width: 250px; max-height: 250px" src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>"/>
						</div></td></tr><?php
					
						echo '<tr><td>Number of rooms:'. $row['numRooms'].'</td><td>Suburb:'. $row['suburb'].'</td>';
						echo '<tr><td>Number of carparks:'. $row['numCarParks'].'</td><td>State:'. $row['state'].' '.$row['postcode'].'</td>';
						echo '<tr><td>Number of bathrooms:'. $row['numBath'].'</td>';
						echo "<td><a href='sHouseProperty.php?sHouseId=".$row['sHouseId']."'>More Details</a></td></tr>";						
						echo "<tr><td><div class=\"linediv\"></div></td></tr>";
					?>
					</table></div></div>
					<?php 
				}
				
			}
			
			//Delcare in broad scope
			$first;
			$prev;
			$nav = "";
			$next;
			$last;
			
			//build the nav links for the numeric pages (ie, not first or last)
			for($page = 1;$page<=$maxPage;$page++){
				//don't have a hyperlink for the page we're currently on
				if($page==$pageNum){
					$nav .= "$page";
				}else{
					$xPageURL = $baseSearchURL.'page='.$page;
					$nav .= "| <a href=\"$xPageURL\">$page</a> |";
				}
			}
			
			//create first and previous links only if not on the first page
			if ($pageNum >1){
				//page linked to is the previous page
				$page = $pageNum -1;
				$prevPageURL = $baseSearchURL . 'page='.$page;
				//page linked to is the first page ie page 1
				$firstPageURL = $baseSearchURL. 'page=1';
				
				$prev =  "| <a href=\"$prevPageURL\">[Prev]</a> |";
				$first = "<a href=\"$firstPageURL\">[First]</a> |";
			}else{
				$prev='&nbsp;';
				$first='&nbsp;';
			}
			
			//if we're not on the last page make next and last links
			if ($pageNum < $maxPage){
				$page = $pageNum +1;
				$nextPageURL = $baseSearchURL . 'page='.$page;
				$lastPageURL = $baseSearchURL . 'page='.$maxPage;
				$next = "| <a href=\"$nextPageURL\">[Next]</a> |";
				$last =  "| <a href=\"$lastPageURL\">[Last]</a>";
			}else{
				$next = "&nbsp;";
				$last =  "&nbsp;";
			}
			?>
			<center>
			<?php
				echo $first.$prev.$nav.$next.$last;
			?>
			</center>
			</div></div>
			<?php 
		}	

		
	?>





</body>
</html>
