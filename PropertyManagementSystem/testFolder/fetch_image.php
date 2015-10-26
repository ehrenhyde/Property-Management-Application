<?php
$host = 'localhost';
$user = 'admin';
$pass = 'admin';

mysql_connect($host, $user, $pass);

mysql_select_db('world');

$name=$_GET['name'];

$select_image="select * from propertypic where imagename='$name'";

$var=mysql_query($select_image);

if($row=mysql_fetch_array($var))
{
    $image_name=$row["imagename"];
    $image_content=$row["imagecontent"];
}
echo $image;

?>