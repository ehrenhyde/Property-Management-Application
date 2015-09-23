<?php	
	$loginId = $_SESSION['idLogin'];
	$ownerId = db_getOwnerId($loginId);
	//uses db function to retrieve the owner id of the currently logged in user
	if (!empty($ownerId)){
		$accountType = 'owner';
	} else {
		$accountType = 'tenant';
	}
	//determines what account type is logged in stored in a variable
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
		<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">SPEL</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="searchProperties.php">Search</a></li>
            <li><a href='registerTenant.php'>Register</a></li>
			
            <li><a href='<?php echo $accountType ?>Profile.php'>Edit My Profile </a></li>
	<!-- This embeds the account type into the href link to customize 
	the nav bar to user type. This same method will also be used for other elements-->
			
			<li><a href='login.php'>Login</a></li>
			<li><a href='updateWHouse.php?propertyId=1'>Update Houses</a></li>
			<li><a href='addproperty.php'>Add Houses</a></li>
			<li><a href='addsHouse.php'>Add ShareHouse</a></li>
		  </ul>
		</div>
	</div>
</nav>