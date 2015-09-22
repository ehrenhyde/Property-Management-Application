<?php
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');

if(isset($_POST['submit'])){


	
$address=$_POST['searchinput'];
$Minrooms=$_POST['Min Bed'];
$Maxrooms=$_POST['Max Bed'];
$Minprice=$_POST['Min Price'];
$Maxprice=$_POST['Max Price'];

mysql_connect("localhost","admin","admin");//database connection
mysql_select_db("prop");


$order = 'SELECT propertyId,NumberofRooms,BuyingPrice,Address FROM v_w_house_property_details WHERE Address LIKE '%" . $address .  "%''; 

$result = mysql_query($order);  


while($data = mysql_fetch_row($result)){
echo hello;
	echo("<tr><td>Picture</td>   </tr><td>$data[0]</td></tr>   <tr><td>$data[1]</td></tr>  <tr><td>Bedrooms:$data[1]</td></tr> ");
	echo("<tr><td><a href='page.php?data=".$data[0]."'>Details</a></td></tr>");
}
	

		

}
?>
<html>
<title>Search data</title>
<head>
<link rel='stylesheet' href = 'css/global.css' type = 'text/css'/>
</head>

<body>
<?php include('/includes/content/topNav.php'); ?>

<form method="post" action="search1.php">
<fieldset>
<?php 

$wHouseDetails = db_getWHouseDetails($propertyId);

ctrl_input_field($errors,'text','REQUIRED','address','Address','txtAddress',$wHouseDetails['address']);
ctrl_submit('submit','submit');
	?>
		
		<input type="submit" name="submit" value="Search"/><br>
		<table>
			<tr><td>Property Type</td><td>Min Bed</td><td>Max Bed</td><td>Min Price</td><td>Max Price</td></tr>
		</table>
		<select id="propertytype" name="propertytype">
			<option value="any">Any</option>
			<option value="wholehouse">Whole House</option>
			<option value="sharehouse">Share House</option>
		</select>
		<select name="Min Bed">
			<option value="Any">Any</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
		<select name="Max Bed">
			<option value="Any">Any</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
		<select name="Min Price">
			<option value="Any">Any</option>
			<option value="50000">50000</option>
			<option value="100000">100000</option>
			<option value="200000">200000</option>
			<option value="300000">300000</option>
			<option value="400000">400000</option>
			<option value="500000">500000</option>
			<option value="1000000">1000000</option>
		</select>
		<select name="Max Price">
			<option value="Any">Any</option>
			<option value="50000">50000</option>
			<option value="100000">100000</option>
			<option value="200000">200000</option>
			<option value="300000">300000</option>
			<option value="400000">400000</option>
			<option value="500000">500000</option>
			<option value="1000000">1000000</option>
		</select>
		
	</fieldset>
</form>

<table>

  <tr>

    <td align="center">Property Data</td>

  </tr>

  <tr>

    <td>

      <table border="1">      





    </table>

  </td>

</tr>

</table>

</body>

</html>
