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

create_label($_GET["i"],$_GET["f"]);
exit;

?>
