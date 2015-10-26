<?php
 // Including the requierd libraries.
include ('includes/functions/db.php'); ?>
<?php  include('includes/accountSessions.php')    ?>
<html lang="en">
<head>
	<title>Favourite Share Houses</title>
	<?php  include ('includes/content/bootstrapHead.php'); ?>
	<link async href="css/checkbox.css" rel="stylesheet">
	<link async rel='stylesheet' href = 'css/search.css' type = 'text/css'/>
	<script>
		function sendFavouriteStatus(loginId,propertyId,isFavourite){
			console.log('sending favourite status');
			if (!loginId){
				console.log('no login id');
				return;
			}
			$.ajax({
				method: "POST",
				url: "webservices/updateFavouriteStatus.php",
				data: {
					loginId:loginId,
					propertyId:propertyId,
					isFavourite:isFavourite
				}
			}).done(function( msg ) {
				console.log('successful ajax to updateFavouriteStatus.php');
			})
			.fail(function(jqXHR,textStatus) {
				console.log('ajax failed');
				console.log(textStatus);
			});
		}
		$(document).ready(function(){
			console.log('document ready');
			$('[webcmd-updateFavouriteStatus]').each(function(){
				//console.log('looping over a checkbox');
				//console.log($(this).is(':checked'));
				$(this).change(function(){
					var propertyId = $(this).attr('propertyId');
					console.log('found check event' + propertyId);
					if($(this).is(':checked')) {
						console.log('check');
						sendFavouriteStatus(<?php 
	
	if (isset($_SESSION['idLogin'])){
		echo $_SESSION['idLogin'];
	} else {
		echo 'null';
	}

	?>,propertyId,1);
					} else {
						console.log('uncheck');
						sendFavouriteStatus(<?php 
	
	if (isset($_SESSION['idLogin'])){
		echo $_SESSION['idLogin'];
	} else {
		echo 'null';
	}

	?>,propertyId,0);
					}
				});
			});
		});
	  </script>
</head>
<body>
<?php
 include('includes/content/topNav.php'); ?>
<div class="page-header">
<center>
	<h1>Favourite Share Houses</h1>
</center>
</div>
	<?php
	$loginId = $_SESSION['idLogin'];
	$rowsPerPage = 5;
	//get page number but default to 1
	$pageNum = 1;
	
	if (isset($_GET['page'])){
		$pageNum = $_GET['page'];
	}

	$offset = ($pageNum - 1) * $rowsPerPage;
	//create a url which will get us back to where we are now, ignoring the page
	$baseSearchURL = "searchProperties.php?";
	foreach($_GET as $getParam => $value){
		
		if ($getParam != 'page'){
			$baseSearchURL = $baseSearchURL . $getParam . '='.$value . '&';
		}

	}

	
	
	$numRowsTotal = count(db_getFavouriteSHouses($loginId,0,99999));
	

	/*Maximum page number = total number of results divided by how many results each page has rounded up*/
	$maxPage = ceil($numRowsTotal/$rowsPerPage);
	?><div class="col-xs-offset-2"><div class="col-sm-9"><?php 
	
	$results = db_getFavouriteSHouses($loginId,$offset,$rowsPerPage);
		foreach( $results as $row ){
			?>
					<div class="panel panel-primary">
					<div class="panel-heading clearfix">
							<h3 class="panel-title pull-left"><?php echo ''.$row['address'].'';?></h3>
							<div class="pull-right">
								<?php
									if(isset($_SESSION['idLogin'])){
										$propertyId = $row['propertyId'];
										$isFavourite = db_getIsFavourite($loginId,$propertyId);
										if ($isFavourite){
											echo "<input id ='chkIsFavourite-$propertyId' name='chkIsFavourite' type='checkbox' propertyId = '$propertyId' webcmd-updateFavouriteStatus class='css-checkbox' checked = 'checked'/>";
											echo"<label for='chkIsFavourite-$propertyId' class='css-label'>Favourite</label>";
										}else{
											echo "<input id = 'chkIsFavourite-$propertyId' type='checkbox'  name='chkIsFavourite' propertyId = '$propertyId' webcmd-updateFavouriteStatus class='css-checkbox'></input>";
											echo"<label for='chkIsFavourite-$propertyId' class='css-label'>Favourite</label>";
										}
										
									}
								?>
							</div>
						</div>
					<div class="panel-body">
					<table class="table">
						<tr><td><div id=Picture>
						<img async style="max-width: 250px; max-height: 250px" src="data:image/jpeg;base64,<?php  echo base64_encode( $row["image"] ); ?>"/>
						</div></td></tr><?php
			echo '<tr><td>Number of rooms:'. $row['numRooms'].'</td><td>Suburb:'. $row['suburb'].'</td>';
			echo '<tr><td>Number of carparks:'. $row['numCarParks'].'</td><td>State:'. $row['state'].' '.$row['postcode'].'</td>';
			echo '<tr><td>Number of bathrooms:'. $row['numBath'].'</td>';
			echo "<td><a href='sHouseProperty.php?sHouseId=".$row['sHouseId']."'>More Details</a></td></tr>";
			echo "<tr><td><div class=\"linediv\"></div></td></tr>";
			?>
					</table></div></div>
					<?php 


	}

	//Delcare in broad scope
	$first;
	$prev;
	$nav = "";
	$next;
	$last;
	//build the nav links for the numeric pages (ie, not first or last)
	for($page = 1;$page<=$maxPage;$page++){
		//don't have a hyperlink for the page we're currently on
		
		if($page==$pageNum){
			$nav .= "$page";
		} else {
			$xPageURL = $baseSearchURL.'page='.$page;
			$nav .= "| <a href=\"$xPageURL\">$page</a> |";
		}

	}

	//create first and previous links only if not on the first page
	
	if ($pageNum >1){
		//page linked to is the previous page
		$page = $pageNum -1;
		$prevPageURL = $baseSearchURL . 'page='.$page;
		//page linked to is the first page ie page 1
		$firstPageURL = $baseSearchURL. 'page=1';
		$prev =  "| <a href=\"$prevPageURL\">[Prev]</a> |";
		$first = "<a href=\"$firstPageURL\">[First]</a> |";
	} else {
		$prev='&nbsp;';
		$first='&nbsp;';
	}

	//if we're not on the last page make next and last links
	
	if ($pageNum < $maxPage){
		$page = $pageNum +1;
		$nextPageURL = $baseSearchURL . 'page='.$page;
		$lastPageURL = $baseSearchURL . 'page='.$maxPage;
		$next = "| <a href=\"$nextPageURL\">[Next]</a> |";
		$last =  "| <a href=\"$lastPageURL\">[Last]</a>";
	} else {
		$next = "&nbsp;";
		$last =  "&nbsp;";
	}

	?>
			<center>
			<?php
 echo $first.$prev.$nav.$next.$last; ?>
			</center>
			</div></div>
</body>
</html>