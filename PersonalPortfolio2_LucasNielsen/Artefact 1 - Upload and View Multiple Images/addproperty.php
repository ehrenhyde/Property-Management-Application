
<html lang="en">
  <head>
    
<title>Add Whole House </title>
<?php include ('includes/content/bootstrapHead.php'); ?>
<?php 
include ('includes/functions/formControls.php');
include ('includes/accountSessions.php');
$errors = array();
$baths = array('0','1','2','3','4','5');
$carParks = array('0','1','2','3','4','5');
$rooms = array('0','1','2','3','4','5');

$loginId = $_SESSION['idLogin'];
$image_type = array("image/gif", "image/jpeg", "image/jpg", "image/png", "image/bmp");
?>
<?php
  include ('/includes/functions/db.php'); 
  ?>
</head>
<body>
<?php include('includes/content/topNav.php'); ?>

<div class="page-header">
	<h1>Property Management</h1>
</div>
<?php
if(!$_SESSION){
		
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
			<h3 class="panel-title">Adding a Property</h3>
		</div>
	<div class="panel-body">
		<form class= 'editForm' enctype="multipart/form-data" action = "addproperty.php" method = "POST" name = "addWHouse">
		<table class="table">

			<tbody>
						
			<tr><td>Address</td><td><?php ctrl_input_field($errors,'text','REQUIRED','address','','',null,1);?></td></tr>
			
			<tr><td>Suburb</td><td><?php ctrl_input_field($errors,'text','REQUIRED','suburb','','',null,2);?></td></tr>
			
			<tr><td>State</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','state','','',null,3); ?></td></tr>
			
			<tr><td>Postcode</td><td><?php ctrl_input_field($errors,'number','REQUIRED','postcode','','',null,4);?></td></tr>		
			
			<tr><td>Description</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','description','','',null,5); ?></td></tr>
			
			<tr><td>Number of Rooms</td><td><?php ctrl_select($errors,'numOfRooms',$rooms,'','',null,6);?></td></tr>
			
			<tr><td>Number of Bathrooms</td><td><?php ctrl_select($errors,'numberofBaths',$baths,'','',null,7);?></td></tr>
			
			<tr><td>Number of Carparks</td><td><?php ctrl_select($errors,'numberOfCarParks',$carParks,'','',null,8);?></td></tr>
			
			<tr><td>DefaultRent</td><td><?php ctrl_input_field($errors,'number','REQUIRED','defaultRent','','',null,9);?></td></tr>
	
			<tr><td>Default Period</td><td><?php ctrl_input_field($errors,'number','REQUIRED','defaultPeriod','','',null,10);?></td></tr>

			<tr><td>Buying Price</td><td><?php ctrl_input_field($errors,'number','REQUIRED','buyingPrice','','',null,11);?></td></tr>
			
			<tr><td>Image 1</td><td><input class="files" name="user_files[]" type="file" multiple="multiple" tabindex='12'></td><td></td></tr><!--Inserted this line-->			
			
			<tr><td></td><td><div align="right"></div> <br><?php ctrl_submit('Save',null,13); ?></td></tr>

		
		</tbody>
		</table>
		</form>
		<?php 

if (isset($_POST['submit'])){
	
	require 'includes/functions/validate.php';
	
	
	
	
	if (!$errors){
		
		
		db_addProperty(
						$_POST['numOfRooms'],
						$_POST['numberofBaths'],
						$_POST['numberOfCarParks'],
						$_POST['defaultRent'],
						$_POST['defaultPeriod'],
						$_POST['buyingPrice'],
						$_POST['address'],
						$_POST['description'],
						$_POST['suburb'],
						$_POST['state'],
						$_POST['postcode'],
						$ownerId[0]
						);
		//Created Code to fetch more than one image starting here
		$results = db_getpropertyId($_POST['numOfRooms'],$_POST['numberofBaths'],$_POST['numberOfCarParks'],$_POST['defaultRent'],$_POST['defaultPeriod'],$_POST['buyingPrice']);
		
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
				db_uploadnewimage($results['propertyId'],$type,$image); // Created the new function db_uploadnewimage in db.php file
			}		
		} 
		//Ending here	
	}
	header("location: http://{$_SERVER['HTTP_HOST']}");
	exit();
}
?>
	</div>
	</div>
</div></div></div>
</body>
</html>