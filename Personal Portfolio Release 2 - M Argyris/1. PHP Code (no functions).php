<!-- All almost identical for share house 
(code portions taken from different .php files and simplified to show core workings) -->

<?php // view whole house page
	include('includes/content/topNav.php');
	$result = db_getWHouseDetails($propertyId);
	$propOwner = $result['ownerId'];
	$resultOwner = db_getPropertyOwner($propOwner); //see this function in db.php artefact

	if( strtotime($result['dateAvailable']) < strtotime('now') ) {
		$result['dateAvailable'] = 'Available Now!';
	}
	if( strtotime($result['dateInspection']) < strtotime('now') ) {
		$result['dateInspection'] = 'N/A';
	}
	//check to see if date has passed or not and display appropriate information

	echo '<td>Available on: '. $result['dateAvailable'] .'</td>
			<td>Inspection on: '. $result['dateInspection'] .'</td>'; 
	//Display The date available and Inspection Date on the property page
	echo '<tr><td>Owner: '. $resultOwner['firstName']. ' ' . $resultOwner['lastName'] .'</td>
			<td>Email:'. $resultOwner['email'].'</td></tr>';
	//Display The owner details (full name and email) on the property page of the properties linked owner.

	
	if($propOwner == $ownerId[0]){
		echo "<td><a href='updateWHouse.php?propertyId=".$result['propertyId']."'>Edit</a></td>";
	} /*The owner logged in can only edit a property if their ownerId matches the 
	OwnerId linked to the property*/
?>



<?php // add property page
	if(!$_SESSION){
?>
	<!-- There was a timer here but it was removed due to request of the client -->
		<script type="text/javascript">
			location.href = 'login.php';
		</script>
<?php
		exit();
	}	
?>	<!-- User must be logged in to add a property -->

<?php	
	if (isset($_POST['submit'])){//add property page submit clicked
	
	require 'includes/functions/validate.php'; // form validated
	if (!$errors){ // if there is no errors, proceed
		
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
			//Owner Id of currently logged in owner is passed and automatically linked to this property!
			//user does not see this whatsoever
						);
?>	



<!-- Update wholehouse page-->	
<tr><td>Date Available</td><td> 
<?php ctrl_input_field($errors,'date','REQUIRED','dateAvailable','','',
	$wHouseDetails['dateAvailable'],12); ?></td></tr>
<tr><td>Inspection Date</td><td> 
<?php ctrl_input_field($errors,'date','REQUIRED','dateInspection','','',
	$wHouseDetails['dateInspection'],13); ?></td></tr>
	<!-- input fields for dates to be added/updated. sends to db function db_update_w_house -->



<?php // registration pages
	if($_SESSION){
		echo 'You are logged in. Please log out to register a new account!';
?>		
	<!-- There was a timer here but it was removed due to request of the client -->
		<script type="text/javascript">
			location.href = 'Homepage.php';
		</script> 
<?php
		exit();
	}	
?> <!-- User cannot reach registration page if logged in -->

 
<?php // add property page
if($accountType != 'owner'){
		echo 'Error: Page not Accessible! Please log in as an owner for permission to add property.';
		//user can read why they cant access the page
		?> 
		<p>You will be redirected to the home page in <span id="counter">3</span> second(s).</p>
	<script type="text/javascript">
		function countdown() {	
		var i = document.getElementById('counter');
		if (parseInt(i.innerHTML)<=1) {
			location.href = 'homePage.php'; // redirects to homepage
		}
		i.innerHTML = parseInt(i.innerHTML)-1;
		}
		setInterval(function(){ countdown(); },1000);// timer counts down every second
	</script>
			<?php
		exit();
	}	
?> <!-- User cannot reach registration page if logged in -->



<!-- TOPNAV top navigation bar -->
<?php include('includes/checkAccountType.php') 
	//returns $accountType as Owner or Tenant to determine who is logged in
?>
<link rel="shortcut icon" type="image/png" href="../../images/favicon.png"/>
<nav class="navbar navbar-inverse navbar-fixed-top"> <!-- css classes used in bootstrap to alter look and function of the topnav bar -->
    <div class="container">
		<div class="navbar-header">
          <a class="navbar-brand" href="homePage.php">SMELT</a>
        </div>
        <div id="navbar" class="navbar-inverse">
          <ul class="nav navbar-nav"> <!-- css classes seen in artefact 3 - css topnav -->
            <li><a href="searchProperties.php">Search</a></li>
			<?php
			if($_SESSION['idLogin'] == false){
				echo "<li><a href='registerTenant.php'>Register Tenant</a></li>";
				echo "<li><a href='registerOwner.php'>Register Owner</a></li>";
			}// If there is no session ie not logged in; display the links to register pages
			?>
			
			<?php 
				//if already logged in
				if($_SESSION['idLogin']){
					//show logged in navigation options
					echo " <li><a href='$accountType"."Profile.php'>Edit My Profile </a></li>";
					if($accountType == 'owner'){
						echo "<li><a href='addproperty.php'>Add Wholehouse</a></li>";
						echo "<li><a href='addsHouse.php'>Add Sharehouse</a></li>";
					// Can only see addproperty options if logged in as an owner
						?>
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Favourites <span class="caret"></span></a>
						  <ul class="dropdown-menu">
							<li><a href="favouriteWHouses.php">Whole Houses</a></li>
							<li><a href="favouriteSHouses.php">Share Houses</a></li>
						  </ul>
						</li>
						<?php
						//logged in owner can see a link to the favourite houses pages
					} 
			?>
					<li><a href=''>Logged in as <?php if ($accountType == 'owner'){echo $owner['firstName'];} else {echo $tenant['firstName'];}?> |</a></li><li><?php if (($owner['image']||$tenant['image'])==NULL){
					echo "<img style='max-width: 50px; max-height: 50px;' src='../../image/profile_pic.png'/>";
					} else {?><img style="max-width: 50px; max-height: 50px; padding-top:10px;" src="data:image/jpeg;base64,<?php 
					if ($accountType == 'owner'){echo base64_encode( $owner["image"] );}else{echo base64_encode( $tenant["image"] );}} ?>"/></li>
					<!-- displays the users profile picture in the navbar depending on who is logged in -->
			<?php
					echo "<li><a href='logout.php'>Logout</a></li>";
					//if logged in, show the link to log out.
				}else{
					
					//if not logged in show the login hyperlink
					echo "<li><a href='login.php'>Login</a></li>";
				}	 
			?>
			</ul>
		</div>
	</div>
</nav>
