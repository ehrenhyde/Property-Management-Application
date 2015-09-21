<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="css/theme.css" rel="stylesheet">
	<title>Property Data</title>
	<link rel='stylesheet' href = 'css/page.css' type = 'text/css'/>
</head>

<body>
<div class="page-header">
	<h1>Property View</h1>
</div>
<?php
	include('includes/accountSessions.php');
	include('includes/functions/db.php');
	include('includes/content/topNav.php');

	$id=(isset($_GET["data"])) ? (int)$_GET["data"] : 1;


	$result = db_getWHouseDetails($id);

			
    echo '<div id=content>';
		
		
		
		echo '<div id=Address>'.$result["Address"].'</div>';
		?>
		<div id=Picture><img src="data:image/jpeg;base64,<?php echo base64_encode( $result["image"] ); ?>" /></div>
		<?php
		
		echo '<div id=RoomNum>Number of rooms: '. $result["NumberofRooms"].'</div>';
		echo '<div id=Price>Buying Price: $'. $result["BuyingPrice"].'</div>';
		echo '<div id=Description>Description: '.$result["Description"].'</div>';
		echo '</div>';
		?>

	





</body>
</html>

