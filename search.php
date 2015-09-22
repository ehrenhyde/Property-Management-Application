<html>

<head>

<title>Search data</title>

</head>

<body>
<?php include('topNav.php'); ?>
<?php include('searchform.php'); ?>

<table>

  <tr>

    <td align="center">Property Data</td>

  </tr>

  <tr>

    <td>

      <table border="1">      

<?php



mysql_connect("localhost","admin","admin");//database connection

mysql_select_db("prop");



$order = 'SELECT * FROM v_w_house_property_details';




$result = mysql_query($order);  


while($data = mysql_fetch_row($result)){

	echo("<tr><td>Picture</td>   </tr><td>$data[4]</td></tr>   <tr><td>$data[5]</td></tr>  <tr><td>Bedrooms:$data[1]</td></tr> ");
	echo("<tr><td><a href='page.php?data=".$data[0]."'>Details</a></td></tr>");
}

?>

    </table>

  </td>

</tr>

</table>

</body>

</html>
