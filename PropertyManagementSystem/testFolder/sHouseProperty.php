<?php 

include('includes/accountSessions.php');
$loginId = $_SESSION['idLogin'];

?>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="css/theme.css" rel="stylesheet">	
	<link href="css/checkbox.css" rel="stylesheet">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArPro5ZN3HT4uc8U6C1Grjv4YB6wGmuLc&sensor=false"></script>
<script type="text/javascript" src="js/map.js"></script>
	<title>Property Data</title>
	<style type= "text/css">
 .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      max-width: 70%;
      margin: auto;
	  
  }
	div#MapArea { 
		margin: 0 auto 0 auto; 
	}
  </style>
		  <script src='js/jquery-2.1.4.min.js'></script>
		<script>
	  
		function sendFavouriteStatus(loginId,sHouseId,isFavourite){
			console.log('sending favourite status');
			if (!loginId){
				console.log('no login id');
				return;
			}
			$.ajax({
				method: "POST",
				url: "webservices/updateFavouriteStatus.php",
				data: {
					loginId:loginId,
					sHouseId:sHouseId,
					isFavourite:isFavourite
				}
			}).done(function( msg ) {
				console.log('successful ajax to updateFavouriteStatus.php');
			})
			.fail(function(jqXHR,textStatus) {
				console.log('ajax failed');
				console.log(textStatus);
			});
		}
		$(document).ready(function(){
			console.log('document ready');
			$('#chkIsFavourite').change(function(){
				console.log('found check event');
				if($(this).is(':checked')) {
					console.log('check');
					sendFavouriteStatus(<?php if (isset($_SESSION['idLogin'])){echo $_SESSION['idLogin'];}else{echo 'null';} ?>,<?php echo $_GET["sHouseId"] ?>,1);
				} else {
					console.log('uncheck');
					sendFavouriteStatus(<?php if (isset($_SESSION['idLogin'])){echo $_SESSION['idLogin'];}else{echo 'null';} ?>,<?php echo $_GET["sHouseId"] ?>,0);
				}
			});
		});
	  </script>
</head>
<?php
	$id=$_GET["sHouseId"];
	include('includes/accountSessions.php');
	include('includes/functions/db.php');
	$addressMap = db_getSAddress($id);
	$poi = db_getSPOI($id);
?>
<body onload="GeneralMap('<?php echo($addressMap)?>', <?php echo('[');
															foreach($poi as $poiresult) {
																echo ("'".$poiresult."', ");
															} 
															echo("'Test']");?>)">
	<div class="page-header">
		<h1>Property View</h1>
	</div>
<?php
	
	include('includes/content/topNav.php');	
	include('includes/functions/formControls.php');
	

	$sHouseId=(isset($_GET["sHouseId"])) ? (int)$_GET["sHouseId"] : 1;


	$result = db_getSHouseDetails($sHouseId);

	//check to see if date has passed or not
	if( strtotime($result['dateAvailable']) < strtotime('now') ) {
		$result['dateAvailable'] = 'Available Now!';
	}
	
	$propOwner = $result['ownerId'];
	$resultOwner = db_getPropertyOwner($propOwner);
	
	list($result2,$count)= db_getallimages($sHouseId);
			
    echo '<div id=content>';

		?><div class="col-xs-offset-2"><div class="col-sm-9">
		<div class="panel panel-primary">
				<div class="panel-heading"><h3 class="panel-title"><?php echo ''.$result['address'].'';?></h3>
				
				<?php
					if(isset($_SESSION['idLogin'])){
						$propertyId = db_getPropertyIdFromSHouseId($sHouseId);
						$isFavourite = db_getIsFavourite($loginId,$propertyId);
						if ($isFavourite){
							echo "<input id='chkIsFavourite' name='chkIsFavourite' type='checkbox' class='css-checkbox' checked = 'checked'/>";
							echo"<label for='chkIsFavourite' class='css-label'>Favourite</label>";
						}else{
							echo "<input id='chkIsFavourite' type='checkbox'  name='chkIsFavourite' class='css-checkbox'></input>";
							echo"<label for='chkIsFavourite' class='css-label'>Favourite</label>";
						}					
					}
					?>				
				</div>
				<div class="panel-body">
				
				<form class= 'editForm' enctype="multipart/form-data" action = "<?php echo "wHouseProperty.php?propertyId=$id"?>" method = "POST" name = "WHouse">
				<div class="container">
  <br>
  <div class="col-sm-8">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">	 
      <li data-target='#myCarousel' data-slide-to="0" class="active"></li>
	  <?php 
		for ($i = 0; $i < $count -1; $i++){
		echo "<li data-target=''.#myCarousel.'data-slide-to='.$i+1.'></li>";
		}
		echo '</ol>';
		?>
		<div class="carousel-inner" role="listbox">
      <?php 
	  
	  foreach($result2 as $row){
		if ($counter == 0){$counter++;?>
		<div class="item active">
		<img style="height:300px" src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>" alt="Image">
		</div>
			  
		 <?php } else {?>
		<div class="item">
		<img style="height:300px" src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>" alt="Image">
		
		</div>
	  <?php }} ?>
    </div>
	</div>
   
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
<br>
		<table class="table"><?php
		
		echo '<tr><td>Number of rooms: '. $result["numRooms"].'</td><td>Suburb: '. $result["suburb"].'</td></tr>';
		
		echo '<tr><td>Number of Bathrooms: '. $result["numBath"].'</td><td>State: '. $result["state"].'</td></tr>';
		
		echo '<tr><td>Number of Car Parks: '. $result["numCarParks"].'</td><td>Post Code: '. $result["postcode"].'</td></tr>';
		
		echo '<tr><td>Maximum Overnight Guests Allowed: '. $result["maxOvernightGuests"].'</td><td>Available on: '.$result['dateAvailable'].'</td></tr>';
		
		echo '<tr><td>Owner: '.$resultOwner['firstName'].' ' . $resultOwner['lastName'] . '</td><td>Email: '.$resultOwner['email'].'</td></tr>';

		
		if($propOwner == $ownerId[0]){
		echo "<tr><td><a href='updateSHouse.php?propertyId=".$result['propertyId']."'>Edit</a></td><td></td></tr>";
		}
		echo '<tr><td style="width=100%;">Description: '.$result["description"].'</td></tr>';
	echo '</table></div>';
	?>
	
	<div id="MapArea" style="align:center;width:600px;height:400px;"></div></div>
	<?php
		$rooms = db_getRooms($sHouseId);
		foreach ($rooms as $room){
			
			?>
					<div class="panel panel-primary" align="center">
						<div class="panel-heading">
							<h3 class="panel-title"><?php echo 'Room Number: '.$room['roomNum'].'';?></h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<?php
							
								echo '<tr><td>Default Rent:'. $room['defaultRent'].'</td>';
								echo '<tr><td>Default Period:'. $room['defaultPeriod'].'</td>';
								echo "<tr><td><div class=\"linediv\"></div></td></tr>";
							?>
							</table>
						</div>
					</div>
					
					
					<?php 
		}
	?>
	</div></div>



</body>
</html>