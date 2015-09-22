<?php
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');
include('includes/accountSessions.php');

$errors = array();

//may later use login to enforce security one which staff members can edit
$loginId = $_SESSION['idLogin'];

$sHouseId = sent_value('sHouseId');



if (isset($_POST['submit'])){
	
	//switch between update and deleteWHouse
	if (isset($_POST['toDelete'])){
		db_delete_s_house($sHouseId);
		header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/searchProperties.php");
		exit();	
	}else{
		//update
		require 'includes/functions/validate.php';
	
		validateText($errors, $_POST,'address');
		
		if (!$errors){
			
			
			db_update_s_house(	$sHouseId,
								$_POST['address'],
								$_POST['description'],
								$_POST['suburb'],
								$_POST['state'],
								$_POST['postcode'],
								$_POST['numBath'],
								$_POST['numCarParks'],
								/*$_POST['ownerId'],*/					
								$_POST['maxOvernightGuests']
								
							);
							
			$myArray = Array($sHouseId,
								$_POST['address'],
								$_POST['description'],
								$_POST['suburb'],
								$_POST['state'],
								$_POST['postcode'],
								$_POST['numBath'],
								$_POST['numCarParks'],
								/*$_POST['ownerId'],*/					
								$_POST['maxOvernightGuests']);
			
		
			
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
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/theme.css" rel="stylesheet">
<link href="css/global.css" rel="stylesheet">
<title>Update Share House</title>
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
		<form class= 'editForm' action = "updateSHouse.php" method = "POST" name = "updateSHouseName">
		<table class="table">

			<tbody>

<?php

$sHouseDetails = db_getSHouseDetails($sHouseId);

?>


<?php ctrl_input_field($errors,'hidden','REQUIRED','sHouseId','sHouseId','txtsHouseId',$sHouseDetails['sHouseId']);?></td></tr>
<tr><td>Address</td><td> <?php ctrl_input_field($errors,'text','REQUIRED','address','','txtAddress',$sHouseDetails['address']);?></td></tr>
<tr><td>Suburb</td><td><?php ctrl_input_field($errors,'text','REQUIRED','suburb','','',$sHouseDetails['suburb']);?></td></tr>	
<tr><td>State</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','state','','',$sHouseDetails['state']); ?></td></tr>			
<tr><td>Postcode</td><td><?php ctrl_input_field($errors,'number','REQUIRED','postcode','','',$sHouseDetails['postcode']);?></td></tr>		
<tr><td>Description</td><td> <?php ctrl_input_field($errors,'text','OPTIONAL','description','','txtDescription',$sHouseDetails['description']); ?></td></tr>
<tr><td>Number of Bathrooms</td><td><?php ctrl_input_field($errors,'number','REQUIRED','numBath','','txtNumBaths',$sHouseDetails['numBath']);?></td></tr>
<tr><td>Number of Carparks</td><td><?php ctrl_input_field($errors,'number','REQUIRED','numCarParks','','txtNumCarparks',$sHouseDetails['numCarParks']);?></td></tr>
<?php //ownerId *later* ?>
<tr><td>Max Overnight Guests</td><td> <?php ctrl_input_field($errors,'number','REQUIRED','maxOvernightGuests','','txtmaxOvernightGuests',$sHouseDetails['maxOvernightGuests']); ?></td></tr>



<tr><td><?php ctrl_submit('Save'); ?></td></tr>

</tbody>
</table>
</form>
</div>
</div>
<form class='centredEditForm' action = 'updateSHouse.php' method="POST" name="deleteSHouse">
	<?php ctrl_input_field($errors,'hidden','REQUIRED','sHouseId','sHouseId','txtsHouseId',$sHouseDetails['sHouseId']); ?>
	<?php ctrl_input_field($errors,'hidden','REQUIRED','toDelete','toDelete','txtToDelete','YES'); ?>
	<?php ctrl_submit('Delete'); ?>
</form>
</body>
</html>