<?php

$host = 'localhost';
$user = 'admin';
$pass = 'admin';

mysql_connect($host, $user, $pass);

mysql_select_db('world');

$upload_image=$_FILES[" myimage "][ "name" ];

$folder="C:\Users\Public\Pictures\Sample Pictures\";

move_uploaded_file($_FILES[" myimage "][" tmp_name "], "$folder".$_FILES[" myimage "][" name "]);

$insert_path="INSERT INTO propertypic VALUES('$folder','$upload_image')";

$var=mysql_query($inser_path);

?>