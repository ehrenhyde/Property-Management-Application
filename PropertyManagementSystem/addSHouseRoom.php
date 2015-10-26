<?php
/*enable calling database access functions*/
include ('includes/functions/db.php');
/*makes building forms easier*/
include ('includes/functions/formControls.php');
/*Utilse the user's login sesion*/
include ('includes/accountSessions.php');

$errors = array();

/*Only try to insert if the page is being posted to*/
if (isset($_POST['submit'])){
	
	require 'includes/functions/validate.php';
	
	/*Check the field values are legitmate*/
	/*validateEmail($errors,$_POST,'email');
	validateText($errors, $_POST,'firstName');
	validateText($errors, $_POST,'lastName');
	validateDOB($errors, $_POST, 'DOB');
	validateText($errors, $_POST, 'password');*/
	
	if (!$errors){
		
		
		/*insert into the db*/
		db_addSHouseRoom($_POST['sHouseId'],$_POST['roomNum'],$_POST['defaultRent'],$_POST['defaultPeriod']);
		
		
		header("location: http://{$_SERVER['HTTP_HOST']}/searchProperties.php");
		exit();	
	}	
}
?>
<!--The bulk of the HTML Page itself-->
<html lang="en">
  <head>
   
<title>Add Sharehouse Room</title>
<?php include ('includes/content/bootstrapHead.php'); ?>
</head>
<body>
<!--Top Nav is the menu bar at the top-->
<?php include('includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Add Sharehouse Room</h1> <!-- We could use the name variable as this title -->
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
	<div class="panel panel-primary"><!--Extra divs are for bootstrap-->
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
	<div class="panel-body">
<form class= 'regForm' action = "addSHouseRoom.php" method = "POST" name = "addSHouseRoom">
<table class="table">

	<tbody>
<!--Use formControls library to construct the form-->
<tr><td>Room Number</td><td><?php ctrl_input_field($errors,'text','REQUIRED','roomNum','','txtRoomNum','',1);?></td></tr>
<tr><td>Default Rent</td><td><?php ctrl_input_field($errors, 'number','OPTIONAL','defaultRent','','txtDefaultRent','',2); ?></td></tr>
<tr><td>Default Period</td><td><?php ctrl_input_field($errors,'number','OPTIONAL','defaultPeriod','','txtDefaultPeriod','',3); ?></td></tr>
<?php ctrl_input_field($errors,'hidden','OPTIONAL','sHouseId','','txtSHouseId','',4); ?>

<tr><td><?php ctrl_submit('Save',null,5); ?></td></tr>
</tbody>
</table>
</form>
</body>
</html>