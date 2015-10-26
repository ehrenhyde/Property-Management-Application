<?php
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');
include('includes/accountSessions.php');

$errors = array();

//may later use login to enforce security one which staff members can edit
$loginId = $_SESSION['idLogin'];

$sHouseId = $_GET["propertyId"];
echo $sHouseId;



if (isset($_POST['submit'])){
	
	//switch between update and deleteWHouse
	if (isset($_POST['toDelete'])){
		db_delete_s_house($sHouseId);
		header("location: http://{$_SERVER['HTTP_HOST']}/searchProperties.php");
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
								$_POST['maxOvernightGuests'],
								$_POST['dateAvailable'],
								$_POST['dateInspection']
								
							);
							
			/*Recycle Bin
			$myArray = Array($sHouseId,
								$_POST['address'],
								$_POST['description'],
								$_POST['suburb'],
								$_POST['state'],
								$_POST['postcode'],
								$_POST['numBath'],
								$_POST['numCarParks'],
								$_POST['ownerId'],			
								$_POST['maxOvernightGuests']);*/
			
		
			
			header("location: http://{$_SERVER['HTTP_HOST']}/searchProperties.php");
			exit();	
		}
	}		
}
?>

<?php

$sHouseDetails = db_getSHouseDetails($sHouseId);

?>

<html lang="en">
  <head>
    

<title>Update Share House</title>
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
		<div class="panel-heading clearfix">
			<h3 class="panel-title pull-left">Updating a Property</h3>
			
			<div class="btn-group pull-right">
				
				<?php echo "<a href='addSHouseRoom.php?sHouseId=".$sHouseId."' class='btn btn-default btn-sm'>Add Room</a>"; ?>
			</div>
		</div>
	<div class="panel-body">
		<form class= 'editForm' action = "updateSHouse.php" method = "POST" name = "updateSHouseName">
		<table class="table">

			<tbody>


<?php ctrl_input_field($errors,'hidden','REQUIRED','sHouseId','sHouseId','txtsHouseId',$sHouseId);?></td></tr>
<tr><td>Address</td><td> <?php ctrl_input_field($errors,'text','REQUIRED','address','','txtAddress',$sHouseDetails['address'],1);?></td></tr>
<tr><td>Suburb</td><td><?php ctrl_input_field($errors,'text','REQUIRED','suburb','','',$sHouseDetails['suburb'],2);?></td></tr>	
<tr><td>State</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','state','','',$sHouseDetails['state'],3); ?></td></tr>			
<tr><td>Postcode</td><td><?php ctrl_input_field($errors,'number','REQUIRED','postcode','','',$sHouseDetails['postcode'],4);?></td></tr>		
<tr><td>Description</td><td> <?php ctrl_input_field($errors,'text','OPTIONAL','description','','txtDescription',$sHouseDetails['description'],5); ?></td></tr>
<tr><td>Number of Bathrooms</td><td><?php ctrl_input_field($errors,'number','REQUIRED','numBath','','txtNumBaths',$sHouseDetails['numBath'],6);?></td></tr>
<tr><td>Number of Carparks</td><td><?php ctrl_input_field($errors,'number','REQUIRED','numCarParks','','txtNumCarparks',$sHouseDetails['numCarParks'],7);?></td></tr>
<?php //ownerId *later* ?>
<tr><td>Max Overnight Guests</td><td> <?php ctrl_input_field($errors,'number','REQUIRED','maxOvernightGuests','','txtmaxOvernightGuests',$sHouseDetails['maxOvernightGuests'],8); ?></td></tr>
<tr><td>Date Available</td><td> <?php ctrl_input_field($errors,'date','REQUIRED','dateAvailable','','',$sHouseDetails['dateAvailable'],9); ?></td></tr>
<tr><td>Inspection Date</td><td> <?php ctrl_input_field($errors,'date','REQUIRED','dateInspection','','',$sHouseDetails['dateInspection'],10); ?></td></tr>



<tr><td><?php ctrl_submit('Save',null,11); ?></td></tr>


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