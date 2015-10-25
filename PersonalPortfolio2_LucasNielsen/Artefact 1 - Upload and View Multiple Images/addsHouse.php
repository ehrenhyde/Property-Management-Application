
<html lang="en">
  <head>
   
<title>Add Share House </title>
<?php include ('includes/content/bootstrapHead.php'); ?>
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

<?php
if(!$_SESSION){
		echo 'You are not logged in.!';
		?>
		
	
	
			<?php
		exit();
	}		
	?>
	


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
						
			<tr><td>Address</td><td><?php ctrl_input_field($errors,'text','REQUIRED','address','','',null,1);?></td></tr>
			
			<tr><td>Suburb</td><td><?php ctrl_input_field($errors,'text','REQUIRED','suburb','','',null,2);?></td></tr>
			
			<tr><td>State</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','state','','',null,3); ?></td></tr>
			
			<tr><td>Postcode</td><td><?php ctrl_input_field($errors,'number','REQUIRED','postcode','','',null,4);?></td></tr>		
			
			<tr><td>Description</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','description','','',null,5); ?></td></tr>
			
			<tr><td>Number of Bathrooms</td><td><?php ctrl_select($errors,'numBath',$baths,'','',null,6);?></td></tr>
			
			<tr><td>Number of Carparks</td><td><?php ctrl_select($errors,'numCarParks',$carParks,'','',null,7);?></td></tr>
			
			<tr><td>Max Overnight Guests</td><td><?php ctrl_input_field($errors,'number','REQUIRED','maxOvernightGuests','','',null,8);?></td></tr>					
			
			<tr><td>Image 1</td><td><input class="files" name="user_files[]" type="file" multiple="multiple" tabindex='9'></td><td></td></tr><!--Incorporated this line of code-->	

			<tr><td></td><td><div align="right"><?php ctrl_submit('Save',null,10); ?></div> <br></td></tr>

		
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
						$_POST['numBath']						
						);
		//Created Code to fetch more than one image starting here
		$sHouseId = db_getsHouseId($_POST['maxOvernightGuests'],$_POST['postcode'],$_POST['numCarParks'],$_POST['numBath']);
		
		$files = array();
		if (count($_FILES["user_files"]) > 0) {	
			for ($i = 0; $i < count($_FILES["user_files"]["name"]); $i++) {				
				$filearray[] = array(
					'name' => $_FILES["user_files"]['name'][$i],
					'type' => $_FILES["user_files"]['type'][$i],
					'tmp_name' => $_FILES["user_files"]['tmp_name'][$i],
					'image' =>  file_get_contents($_FILES["user_files"]['tmp_name'][$i]),
				);		
			}
			foreach ($filearray as $row){
				$image = file_get_contents($row['tmp_name']);
				$type = $row['type'];	
				db_uploadnewimage($sHouseId['propertyId'],$type,$image); // Created the new function db_uploadnewimage in db.php file
			}		
		} 
		//Ending here
		header("location: http://{$_SERVER['HTTP_HOST']}");
		exit();	
	}
}
?>
	
	</div>
	</div>
</div></div>
</body>
</html>