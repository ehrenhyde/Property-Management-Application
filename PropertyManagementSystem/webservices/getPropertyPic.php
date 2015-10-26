<?php


include('../includes/functions/db.php');

$propertyPicId = $_GET['propertyPicId'];


$propertyPic = db_getPropertyPic($propertyPicId);




/*$file = 'plant.png';
$image = imagecreatefrompng($file);
imagepng($image);*/

header("Content-Type: image/jpeg");

$im = imagecreatefromstring($propertyPic);
imagejpeg($im);
imagedestroy($im);
//echo $propertyPic;

?>