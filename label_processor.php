<?php

include("globals.php");

if (!function_exists('imagecreate') ||
    !function_exists('imagecolorallocate') ||
	!function_exists('imagettftext') ||
	!function_exists('imagestring') ||
	!function_exists('imagecopyresized') ||
	!function_exists('imagedestroy') ||
	!function_exists('imagepng')){
	
	$output .= '<p>'.LABEL_ERROR.'</p>';
	
	display($output);
}

// Create the item object
$item = new item($_GET["i"]);

if ($view_user->can_view($item->category->id)){
	
	// Create the image.
	$im = imagecreate(600, 70);
	
	// Color the background white
	$white = imagecolorallocate($im, 255, 255, 255);
	
	// Set the color for the text.
	$black = imagecolorallocate($im, 0, 0, 0);
	
	// Write the barcode.
	$boundaries = imagettftext($im, 12, 0, 0, 50, $black, realpath("fonts/IDAutomationHC39M.ttf"),"!".$item->fields[$_GET["f"]]."!");
	
	// This is the width of one character in pixels.
	$char_width = 5;
	
	// Figure the offset for centering the text
	$offset = ($boundaries[2] - (strlen($item->name) * $char_width)) / 2;
	
	// Write the item name to the label.
	imagestring($im, 1, $offset, 0, $item->name, $black);
	
	// Crop the image
	$new_image = imagecreate($boundaries[2], $boundaries[1] + 10);
	imagecopyresized($new_image, $im, 0, 0, 0, 0, $boundaries[2], $boundaries[1] + 10, $boundaries[2], $boundaries[1] + 10);
	
	// Delete the old image.
	imagedestroy($im);
	
	// Send the new image to the browser
	header("Content-type: image/png");
	imagepng($new_image);
	
	// Delete the new image.
	imagedestroy($new_image);
}

exit;

?>