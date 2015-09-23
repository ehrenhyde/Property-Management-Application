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
		header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/searchProperties.php");
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
								$_POST['buyingPrice']
							);
		
			
			header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/searchProperties.php");
			exit();	
		}
	}		
}
?>

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
<link href="css/global.css" rel="stylesheet">
<title>Update Whole House</title>
</head>
<body>
<?php include('/includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Property Management</h1>
</div>
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
<tr><td>Address</td><td> <?php ctrl_input_field($errors,'text','REQUIRED','address','','txtAddress',$wHouseDetails['Address']);?></td></tr>
<tr><td>Suburb</td><td><?php ctrl_input_field($errors,'text','REQUIRED','suburb','','',$wHouseDetails['suburb']);?></td></tr>	
<tr><td>State</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','state','','',$wHouseDetails['state']); ?></td></tr>			
<tr><td>Postcode</td><td><?php ctrl_input_field($errors,'number','REQUIRED','postcode','','',$wHouseDetails['postcode']);?></td></tr>		
<tr><td>Description</td><td> <?php ctrl_input_field($errors,'text','OPTIONAL','description','','txtDescription',$wHouseDetails['Description']); ?></td></tr>
<tr><td>Number of Bathrooms</td><td><?php ctrl_input_field($errors,'number','REQUIRED','numBaths','','txtNumBaths',$wHouseDetails['NumberofBathrooms']);?></td></tr>
<tr><td>Number of Carparks</td><td><?php ctrl_input_field($errors,'number','REQUIRED','numCarParks','','txtNumCarparks',$wHouseDetails['NumberofCarParks']);?></td></tr>
<?php //ownerId *later* ?>
<tr><td>Number of Rooms</td><td> <?php ctrl_input_field($errors,'number','REQUIRED','numRooms','','txtNumRooms',$wHouseDetails['NumberofRooms']); ?></td></tr>
<tr><td>Default Rent (Weekly)</td><td> <?php ctrl_input_field($errors,'number','REQUIRED','defaultRent','','txtDefaultRent',$wHouseDetails['DefaultRent']); ?></td></tr>
<tr><td>Default Rental Period</td><td> <?php ctrl_input_field($errors,'number','REQUIRED','defaultPeriod','','txtDefaultRentalPeriod',$wHouseDetails['DefaultRentingPeriod']); ?></td></tr>
<tr><td>Buying Price</td><td> <?php ctrl_input_field($errors,'number','REQUIRED','buyingPrice','','txtBuyingPrice',$wHouseDetails['BuyingPrice']); ?></td></tr>


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