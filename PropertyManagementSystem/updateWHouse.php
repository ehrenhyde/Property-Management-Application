<?php

// Including the requierd libraries.

include ('includes/functions/db.php');
include ('includes/functions/formControls.php');
include('includes/accountSessions.php');


$errors = array();

//may later use login to enforce security one which staff members can edit

$loginId = $_SESSION['idLogin'];

$propertyId = sent_value('propertyId');


if (isset($_POST['submit'])){
	
	//switch between update and deleteWHouse

	if (isset($_POST['toDelete'])){
		db_delete_w_house($propertyId);
		header("location: http://{$_SERVER['HTTP_HOST']}/searchProperties.php");
		exit();	
	}else{
		
		//update

		require 'includes/functions/validate.php';
	
		validateText($errors, $_POST,'address');
		
		if (!$errors){
			
			// Using the function created in db.php file.
			
			db_update_w_house(	$propertyId,
								$_POST['address'],
								$_POST['description'],
								$_POST['suburb'],
								$_POST['state'],
								$_POST['postcode'],
								$_POST['numBaths'],
								$_POST['numCarParks'],
								/*$_POST['ownerId'],*/
								$_POST['numRooms'],
								$_POST['defaultRent'],
								$_POST['defaultPeriod'],
								$_POST['buyingPrice'],
								$_POST['dateAvailable'],
								$_POST['dateInspection']
							);
		
			
			header("location: http://{$_SERVER['HTTP_HOST']}/searchProperties.php");
			exit();	
		}
	}		
}
?>

<html lang="en">
  <head>
    
<link href="css/global.css" rel="stylesheet">
<title>Update Whole House</title>
<?php include ('includes/content/bootstrapHead.php'); ?>
<link href="css/global.css" rel="stylesheet">
</head>
<body>
<?php include('includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Property Management</h1>
</div>


	<?php
if(!$_SESSION){
		echo 'You are not logged in.!';
		?>
		<script type="text/javascript">
		location.href = 'login.php';
	</script>
	
			<?php
		exit();
	}		
	?>


<div class="col-xs-offset-2"><div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Updating a Property</h3>
		</div>
	<div class="panel-body">
		<form class= 'editForm' action = "updateWHouse.php" method = "POST" name = "updateWHouseName">
		<table class="table">

			<tbody>

<?php

$wHouseDetails = db_getWHouseDetails($propertyId);

?>

<!-- Creating the required fields -->

<?php ctrl_input_field($errors,'hidden','REQUIRED','propertyId','propertyId','txtPropertyId',$wHouseDetails['propertyId']);?></td></tr>
<tr><td>Address</td><td> <?php ctrl_input_field($errors,'text','REQUIRED','address','','txtAddress',$wHouseDetails['address'],1);?></td></tr>
<tr><td>Suburb</td><td><?php ctrl_input_field($errors,'text','REQUIRED','suburb','','',$wHouseDetails['suburb'],2);?></td></tr>	
<tr><td>State</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','state','','',$wHouseDetails['state'],3); ?></td></tr>			
<tr><td>Postcode</td><td><?php ctrl_input_field($errors,'number','REQUIRED','postcode','','',$wHouseDetails['postcode'],4);?></td></tr>		
<tr><td>Description</td><td> <?php ctrl_input_field($errors,'text','OPTIONAL','description','','txtDescription',$wHouseDetails['description'],5); ?></td></tr>
<tr><td>Number of Bathrooms</td><td><?php ctrl_input_field($errors,'number','REQUIRED','numBaths','','txtNumBaths',$wHouseDetails['numBath'],6);?></td></tr>
<tr><td>Number of Carparks</td><td><?php ctrl_input_field($errors,'number','REQUIRED','numCarParks','','txtNumCarparks',$wHouseDetails['numCarParks'],7);?></td></tr>
<?php //ownerId *later* ?>
<tr><td>Number of Rooms</td><td> <?php ctrl_input_field($errors,'number','REQUIRED','numRooms','','txtNumRooms',$wHouseDetails['numRooms'],8); ?></td></tr>
<tr><td>Default Rent (Weekly)</td><td> <?php ctrl_input_field($errors,'number','REQUIRED','defaultRent','','txtDefaultRent',$wHouseDetails['defaultRent'],9); ?></td></tr>
<tr><td>Default Rental Period</td><td> <?php ctrl_input_field($errors,'number','REQUIRED','defaultPeriod','','txtDefaultRentalPeriod',$wHouseDetails['defaultRentingPeriod'],10); ?></td></tr>
<tr><td>Buying Price</td><td> <?php ctrl_input_field($errors,'number','REQUIRED','buyingPrice','','txtBuyingPrice',$wHouseDetails['buyingPrice'],11); ?></td></tr>
<tr><td>Date Available</td><td> <?php ctrl_input_field($errors,'date','REQUIRED','dateAvailable','','',$wHouseDetails['dateAvailable'],12); ?></td></tr>
<tr><td>Inspection Date</td><td> <?php ctrl_input_field($errors,'date','REQUIRED','dateInspection','','',$wHouseDetails['dateInspection'],13); ?></td></tr>

<tr><td><?php ctrl_submit('Save'); ?></td></tr>

</tbody>
</table>
</form>
</div>
</div>
<form class='centredEditForm' action = 'updateWHouse.php' method="POST" name="deleteWHouse">
	<?php ctrl_input_field($errors,'hidden','REQUIRED','propertyId','propertyId','txtPropertyId',$wHouseDetails['propertyId']); ?>
	<?php ctrl_input_field($errors,'hidden','REQUIRED','toDelete','toDelete','txtToDelete','YES'); ?>
	<?php ctrl_submit('Delete'); ?>
</form>
</body>
</html>