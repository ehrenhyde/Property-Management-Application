<?php 

include('includes/accountSessions.php');
$loginId = $_SESSION['idLogin'];

?>
<html>

<head>
<title>Property Data</title>
	<?php include ('includes/content/bootstrapHead.php'); ?>
	<link href="css/checkbox.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArPro5ZN3HT4uc8U6C1Grjv4YB6wGmuLc&sensor=false"></script>
	<script src='js/jquery-2.1.4.min.js'></script>
	<script type="text/javascript" src="js/map.js"></script>
		
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
	 
		<script>
	  
		function sendFavouriteStatus(loginId,propertyId,isFavourite){
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
					propertyId:propertyId,
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
					/*write out custom paramters for the function call, based on php variables*/
					/*In this case, the user's loginIn and the id of the property being viewed*/
					sendFavouriteStatus(<?php if (isset($_SESSION['idLogin'])){echo $_SESSION['idLogin'];}else{echo 'null';} ?>,<?php echo $_GET["propertyId"] ?>,1);
				} else {
					console.log('uncheck');
					sendFavouriteStatus(<?php if (isset($_SESSION['idLogin'])){echo $_SESSION['idLogin'];}else{echo 'null';} ?>,<?php echo $_GET["propertyId"] ?>,0);
				}
			});
		});
	  </script>
	
	
</head>
<?php
	$propertyId=$_GET["propertyId"];
	include('includes/functions/db.php');
	$addressMap = db_getAddress($propertyId);
	$poi = db_getPOI($propertyId);
	
	//include ('js/map.php');
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
	

	$result = db_getWHouseDetails($propertyId);

	

	//include ('js/map.php');
	//check to see if date has passed or not
	if( strtotime($result['dateAvailable']) < strtotime('now') ) {
		$result['dateAvailable'] = 'Available Now!';
	}
	if( strtotime($result['dateInspection']) < strtotime('now') ) {
		$result['dateInspection'] = 'N/A';
	}
	
	$propOwner = $result['ownerId'];
	$resultOwner = db_getPropertyOwner($propOwner);
	
	list($result2,$count)= db_getallimages($propertyId); // inserted this line of code
    echo '<div id=content>';
		?>
				
	<div class="col-xs-offset-2"><div class="col-sm-9">
		<div class="panel panel-primary">
				<div class="panel-heading clearfix">
					<h3 class="panel-title pull-left"><?php echo ''.$result['address'].'';?></h3>
					<div class='pull-right'>
						<?php
						if(isset($_SESSION['idLogin'])){
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
				</div><!--Inserted Code starting here to present multiple images-->
				<div class="panel-body">
				
				<form class= 'editForm' enctype="multipart/form-data" action = "<?php echo "wHouseProperty.php?propertyId=$propertyId"?>" method = "POST" name = "WHouse">
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
<br><!--Ending Here-->
				<table class="table"><?php
		
				echo '<tr><td>Number of rooms:'. $result['numRooms'].'</td><td>Suburb:'. $result['suburb'].'</td></tr>';
				echo '<tr><td>Number of carparks:'. $result['numCarParks'].'</td><td>State:'. $result['state'].' '.$result['postcode'].'</td>';
				echo '<tr><td>Number of bathrooms:'. $result['numBath'].'</td><td>Buying Price: $'. $result['buyingPrice'].'</td></tr>';
				echo '<td>Available on: '. $result['dateAvailable'] .'</td><td>Inspection on: '. $result['dateInspection'] .'</td>';
				echo '<tr><td>Owner: '. $resultOwner['firstName']. ' ' . $resultOwner['lastName'] .'</td><td>Email:'. $resultOwner['email'].'</td></tr>';
				
				if($propOwner == $ownerId[0]){
					echo "<td><a href='updateWHouse.php?propertyId=".$result['propertyId']."'>Edit</a></td>";
				}
				?>
				
				<!--<td>Add Another Image<?php ctrl_input_field($errors,'file','REQUIRED','userfile1','','');?><?php ctrl_submit('Upload Image'); ?></td></tr>--><!--Incorporated this line of code-->
				<?php echo "<tr><td><a href='floorplan.php?propertyId=".$result['propertyId']."' target='_blank' >View Floorplan</a></td></tr>";
			
				
				echo "<div class=\"linediv\"></div></td></tr></table>";
				
				
		?>
	</form><div id="MapArea" style="align:center;width:600px;height:400px;"></div></div></div></div></div>
	
	
</body>
</html>

