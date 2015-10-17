<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="css/theme.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArPro5ZN3HT4uc8U6C1Grjv4YB6wGmuLc&sensor=false"></script>
<script type="text/javascript" src="js/map.js"></script>
	<title>Property Data</title>
	<style type= "text/css">
 .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
	  
  }
	div#MapArea { 
		margin: 0 auto 0 auto; 
	}
  </style>
	<link rel='stylesheet' href = 'css/page.css' type = 'text/css'/>
</head>

<body onload="GeneralMap()">
<div class="page-header">
	<h1>Property View</h1>
</div>
<?php

	include('includes/accountSessions.php');
	include('includes/functions/db.php');
	include('includes/content/topNav.php');	
	
if(!$_SESSION){
		echo 'You are not logged in.!';
		?>
		<p>You will be redirected to the home page in <span id="counter">5</span> second(s).</p>
	<script type="text/javascript">
		function countdown() {
		
		var i = document.getElementById('counter');
			
		if (parseInt(i.innerHTML)<=1) {
			location.href = 'login.php';
		}
		
		i.innerHTML = parseInt(i.innerHTML)-1;
		}
		setInterval(function(){ countdown(); },500);
	</script>
	
			<?php
		exit();
	}		
	?>	
	<?php
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
		
		
		
		echo '<div id=Address>'.$result["address"].'</div>';
		?>
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
		<img src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>" alt="Image">
		</div>
			  
		 <?php } else {?>
		<div class="item">
		<img src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>" alt="Image">
		
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
		<!--<div id='Picture'><img style="width: 100%; height: 100%" src="data:image/jpeg;base64,<?php echo base64_encode( $result["image"] ); ?>" /></div>-->
		<?php
		
		echo '<div id=RoomNum>Number of rooms: '. $result["roomCount"].'</div>';
		
		echo '<div id=maxOvernightGuests>Maximum Overnight Guests Allowed: '. $result["maxOvernightGuests"].'</div>';
		
		echo '<div id=suburb>Suburb: '. $result["suburb"].'</div>';
		
		echo '<div id=state>State: '. $result["state"].'</div>';
		
		echo '<div id=postcode>Post Code: '. $result["postcode"].'</div>';
		
		echo '<div id=numCarParks>Number of Car Parks: '. $result["numCarParks"].'</div>';
		
		echo '<div id=numBath>Number of Bathrooms: '. $result["numBath"].'</div>';
		
		echo '<div id=Description>Description: '.$result["description"].'</div>';
		
		echo '<div id=Availability>Available on: '.$result['dateAvailable'].'</div>';
		
		echo '<div id=ownerDetails>Owner: '.$resultOwner['firstName'].' ' . $resultOwner['lastName'] . ': '.$resultOwner['email'].'</div>';
		
		//if($propOwner == $ownerId[0]){
		echo "<td><a href='updateSHouse.php?propertyId=".$result['propertyId']."'>Edit</a></td>";
		//}
		
	echo '</div>';
	?>
	
	<div id="MapArea" style="align:center;width:600px;height:400px;"></div>
	<ul id="roomsList">
	<?php
		$rooms = db_getRooms($sHouseId);
		foreach ($rooms as $room){
			
			?><div class="col-xs-offset-2"><div class="col-sm-9">
					<div class="panel panel-primary">
					<div class="panel-heading"><h3 class="panel-title"><?php echo 'Room Number: '.$room['roomNum'].'';?></h3></div>
					<div class="panel-body">
					<table class="table">
						<?php
					
						echo '<tr><td>Default Rent:'. $room['defaultRent'].'</td>';
						echo '<tr><td>Default Period:'. $room['defaultPeriod'].'</td>';
						echo "<tr><td><div class=\"linediv\"></div></td></tr>";
					?>
					</table></div></div>
					
					</div></div>
					<?php 
		}
	?>
	</ul>



</body>
</html>