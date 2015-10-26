<?php 

include('includes/accountSessions.php');
$loginId = $_SESSION['idLogin'];

?>
<html lang="en">

<head>
	<title>Property Data</title>
	<?php include ('includes/content/bootstrapHead.php'); ?>
	<link href="css/checkbox.css" rel="stylesheet">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArPro5ZN3HT4uc8U6C1Grjv4YB6wGmuLc&sensor=false"></script>
<script type="text/javascript" src="js/map.js"></script>

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
	$propertyId = db_getPropertyIdFromSHouseId($id);
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
				</div>