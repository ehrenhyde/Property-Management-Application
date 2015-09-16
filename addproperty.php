
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/theme.css" rel="stylesheet">
<title>Add Whole House </title>
<?php 
include ('includes/functions/formControls.php');
include ('includes/accountSessions.php');
$errors = array();
$baths = array('0','1','2','3','4','5');
$carParks = array('0','1','2','3','4','5');
$rooms = array('0','1','2','3','4','5');
//may later use login to enforce security one which staff members can edit
$loginId = $_SESSION['idLogin'];
?>
<?php
  include ('/includes/functions/db.php'); 
  ?>
</head>
<body>
<?php include('/includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Property Management</h1>
</div>
<div class="col-xs-offset-2"><div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Adding a Property</h3>
		</div>
	<div class="panel-body">
		<form class= 'editForm' enctype="multipart/form-data" action = "addproperty.php" method = "POST" name = "addWHouse">
		<table class="table">

			<tbody>
						
			<tr><td>Address</td><td><?php ctrl_input_field($errors,'text','REQUIRED','address','','');?></td></tr>
			
			<tr><td>Suburb</td><td><?php ctrl_input_field($errors,'text','REQUIRED','suburb','','');?></td></tr>
			
			<tr><td>State</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','state','',''); ?></td></tr>
			
			<tr><td>Postcode</td><td><?php ctrl_input_field($errors,'number','REQUIRED','postcode','','');?></td></tr>		
			
			<tr><td>Description</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','description','',''); ?></td></tr>
			
			<tr><td>Number of Rooms</td><td><?php ctrl_select($errors,'numOfRooms',$rooms,'','');?></td></tr>
			
			<tr><td>Number of Bathrooms</td><td><?php ctrl_select($errors,'numberofBaths',$baths,'','');?></td></tr>
			
			<tr><td>Number of Carparks</td><td><?php ctrl_select($errors,'numberofCarparks',$carParks,'','');?></td></tr>
			
			<tr><td>DefaultRent</td><td><?php ctrl_input_field($errors,'number','REQUIRED','defaultRent','','');?></td></tr>
	
			<tr><td>Default Period</td><td><?php ctrl_input_field($errors,'number','REQUIRED','defaultPeriod','','');?></td></tr>

			<tr><td>Buying Price</td><td><?php ctrl_input_field($errors,'number','REQUIRED','buyingPrice','','');?></td></tr>
			
			<tr><td>Image</td><td><?php ctrl_input_field($errors,'file','REQUIRED','userfile','','');?></td></tr>			
			
			  <?php
			if(isset($_FILES['userfile']))
			{
				uploadimage(); 
			}  
  ?>

			<tr><td><?php ctrl_submit('Save'); ?> </td></tr>

		
		</tbody>
		</table>
		</form>
		<?php 

if (isset($_POST['submit'])){
	
	require 'includes/functions/validate.php';
	
	
	validateText($errors, $_POST,'address');
	
	if (!$errors){
		
		// echo "The number of rooms is *". $_POST['description'].'*';
		db_addProperty(
						$_POST['numOfRooms'],
						$_POST['defaultRent'],
						$_POST['defaultPeriod'],
						$_POST['buyingPrice'],
						$_POST['address'],
						$_POST['description'],
						$_POST['suburb'],
						$_POST['state'],
						$_POST['postcode'],
						$_POST['numberofCarparks'],
						$_POST['numberofBaths']										
						);
  
  
		header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/searchProperties.php");
		exit();	
	}
}
?>
	</div>
	</div>
</div></div>
</body>
</html>