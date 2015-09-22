<html>

<head>

<title>Property Data</title>

</head>

<body>

<?php
include('topNav.php');
mysql_connect("localhost","admin","admin");//database connection

mysql_select_db("prop");

$id=(isset($_GET["data"])) ? (int)$_GET["data"] : 1;

$sql="SELECT * FROM v_w_house_property_details WHERE `propertyId` = '$id' LIMIT 1";

$result = mysql_query($sql);  
$data = mysql_fetch_row($result)

?>
<table>
<?php echo("<tr><td>Picture</td></tr><tr><td>$data[4]</td></tr><tr><td>$data[5]</td></tr><tr><td>$data[1]</td></tr><tr><td>$data[6]</td></tr>") ?>


</table>





</body>

</html>