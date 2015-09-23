
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	
<!-- Referencing the CSS files which will be used in this page -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/theme.css" rel="stylesheet">
<title>Add Whole House </title>
<?php 

// Including the requierd libraries.

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
		<form class= 'editForm' enctype="multipart/form-data" action = "addsHouse.php" method = "POST" name = "addSHouse">
		<table class="table">

			<tbody>
			
			<!-- Creating the required fields -->
						
			<tr><td>Address</td><td><?php ctrl_input_field($errors,'text','REQUIRED','address','','');?></td></tr>
			
			<tr><td>Suburb</td><td><?php ctrl_input_field($errors,'text','REQUIRED','suburb','','');?></td></tr>
			
			<tr><td>State</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','state','',''); ?></td></tr>
			
			<tr><td>Postcode</td><td><?php ctrl_input_field($errors,'number','REQUIRED','postcode','','');?></td></tr>		
			
			<tr><td>Description</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','description','',''); ?></td></tr>
			
			<tr><td>Number of Bathrooms</td><td><?php ctrl_select($errors,'numBath',$baths,'','');?></td></tr>
			
			<tr><td>Number of Carparks</td><td><?php ctrl_select($errors,'numCarParks',$carParks,'','');?></td></tr>
			
			<tr><td>Max Overnight Guests</td><td><?php ctrl_input_field($errors,'number','REQUIRED','maxOvernightGuests','','');?></td></tr>
	
			<tr><td>Image</td><td><?php ctrl_input_field($errors,'file','REQUIRED','userfile','','');?></td></tr>			
			
			

			<tr><td></td><td><div align="right"><?php ctrl_submit('Save'); ?><!--<button class="btn btn-sm btn-primary" type="submit" value="Send" id="submit" >Save</button>--></div> <br></td></tr>

		
		</tbody>
		</table>
		</form>
		<?php 

if (isset($_POST['submit'])){

	require 'includes/functions/validate.php';
	
	
	validateText($errors, $_POST,'address');
	
	if (!$errors){
	
		// Using the function created in db.php file.

		db_s_House_addProperty(
						$_POST['maxOvernightGuests'],
						$_POST['address'],
						$_POST['description'],
						$_POST['suburb'],
						$_POST['state'],
						$_POST['postcode'],
						$_POST['numCarParks'],
						$_POST['numBath'],					
						$_FILES['userfile']
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