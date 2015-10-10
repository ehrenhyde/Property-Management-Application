<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	
	
	<link href="css/theme.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <style type= "text/css">
 .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
  </style>
	<title>Property Data</title>
	<!---<link rel='stylesheet' href = 'css/page.css' type = 'text/css'/>-->
</head>

<body>
<div class="page-header">
	<h1>Property View</h1>
</div>
<?php
	include('includes/accountSessions.php');
	include('includes/functions/db.php');
	include('includes/content/topNav.php');
	include ('includes/functions/formControls.php');

	$id=$_GET["propertyId"];


	$result = db_getWHouseDetails($id);

	
	list($result2,$count)= db_getallimages($id);
    echo '<div id=content>';
		
		
		
		?><div class="col-xs-offset-2"><div class="col-sm-9">
		<div class="panel panel-primary">
				<div class="panel-heading"><h3 class="panel-title"><?php echo ''.$result['address'].'';?></h3></div>
				<div class="panel-body">
				
				<form class= 'editForm' enctype="multipart/form-data" action = "<?php echo "wHouseProperty.php?propertyId=$id"?>" method = "POST" name = "WHouse">
				<div class="container">
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">	 
      <li data-target='#myCarousel' data-slide-to="0" class="active"></li>
	  <?php 
		for ($i = 0; $i < $count -1; $i++){
		echo "<li data-target=''.#myCarousel.'data-slide-to='.$i+1.'></li>";
		}
		echo '</ol>';
		?>
		<div class="carousel-inner" role="listbox">
      <?php 
	  
	  foreach($result2 as $row){
		if ($counter == 0){$counter++;?>
		<div class="item active">
		<img src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>" alt="Image" width="460" height="345">
		</div>
			  
		 <?php } else {?>
		<div class="item">
		<img src="data:image/jpeg;base64,<?php echo base64_encode( $row["image"] ); ?>" alt="Image" width="460" height="345">
		
		</div>
	  <?php }} ?>
    </div>

   
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

				<table class="table"><?php
		
		echo '<tr><td>Number of rooms:'. $result['numRooms'].'</td><td>Suburb:'. $result['suburb'].'</td>';
				echo '<tr><td>Number of carparks:'. $result['numCarParks'].'</td><td>State:'. $result['state'].' '.$result['postcode'].'</td>';
				echo '<tr><td>Number of bathrooms:'. $result['numBath'].'</td><td>Buying Price: $'. $result['buyingPrice'].'</td></tr>';
				echo "<td><a href='updateWHouse.php?propertyId=".$result['propertyId']."'>Edit</a></td>";?>
				
				<td>Add Another Image<?php ctrl_input_field($errors,'file','REQUIRED','userfile1','','');?><?php ctrl_submit('Upload Image'); ?></td></tr>
				<?php echo "<tr><td><div class=\"linediv\"></div></td></tr></table></div></div>";
				
				//if(isset($_POST['submit'])){		
				//	db_uploadnewimage($id,$_FILES['userfile1']);				
				//}			
		?>
	</form></div></div></div>
	
</body>
</html>

