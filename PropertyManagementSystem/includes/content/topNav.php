<?php include('includes/checkAccountType.php') ?>
<link rel="shortcut icon" type="image/png" href="../../images/favicon.png"/>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
		<div class="navbar-header">
		<!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">-->
            <!--<span class="sr-only">Toggle navigation</span>-->
            <!--<span class="icon-bar"></span>-->
            <!--<span class="icon-bar"></span>-->
            <!--<span class="icon-bar"></span>-->
          <!--</button>-->
          <a class="navbar-brand" href="homePage.php">SMELT</a>
        </div>
        <div id="navbar" class="navbar-inverse">
          <ul class="nav navbar-nav">
            <li><a href="searchProperties.php">Search</a></li>
			<?php
			if($_SESSION['idLogin'] == false){
				echo "<li><a href='registerTenant.php'>Register Tenant</a></li>";
				echo "<li><a href='registerOwner.php'>Register Owner</a></li>";
			}
			?>
			
			<?php 
				//if already logged in
				if($_SESSION['idLogin']){
					//show logged in navigation options
					echo " <li><a href='$accountType"."Profile.php'>Edit My Profile </a></li>";
					if($accountType == 'owner'){
						echo "<li><a href='addproperty.php'>Add Wholehouse</a></li>";
						echo "<li><a href='addsHouse.php'>Add Sharehouse</a></li>";
					} 
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Favourites <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="favouriteWHouses.php">Whole Houses</a></li>
					<li><a href="favouriteSHouses.php">Share Houses</a></li>
				  </ul>
				</li>
				<?php
			?>
					<li><a href=''>Logged in as <?php if ($accountType == 'owner'){echo $owner['firstName'];} else {echo $tenant['firstName'];}?> |</a></li><li><?php if (($owner['image']||$tenant['image'])==NULL){
					echo "<img style='max-width: 50px; max-height: 50px;' src='../../image/profile_pic.png'/>";
					} else {?><img style="max-width: 50px; max-height: 50px; padding-top:10px;" src="data:image/jpeg;base64,<?php 
					if ($accountType == 'owner'){echo base64_encode( $owner["image"] );}else{echo base64_encode( $tenant["image"] );}} ?>"/></li>
			<?php
					echo "<li><a href='logout.php'>Logout</a></li>";					
				}else{
					//show not logged in navigation options
					echo "<li><a href='login.php'>Login</a></li>";
				}	 
			?>
			
			</ul>
		</div>
	</div>
</nav>