<?php

include("globals.php");

$item = new item($_REQUEST["i"]);

$im = imagecreate(400, 400);
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);

// Replace path by your own font path
$boundary = imagettftext($im, 12, 0, 0, 50, $black, realpath("fonts/IDAutomationHC39M.ttf"),"!".$item->fields[$_REQUEST["f"]]."!");

$width = $boundary[2];
$height = $boundary[1];
$offset = 37;

$char_width = 5;

$offset = ($width - (strlen($item->name) * $char_width)) / 2;

imagestring($im, 1, $offset, 0, $item->name, $black);

$new_image = imagecreate($width, $height);
imagecopyresized($new_image, $im, 0, 0, 0, 0, $width, $height, $width, $height);

imagedestroy($im);	

header("Content-type: image/png");
imagepng($new_image);

imagedestroy($new_image);

exit;

?>