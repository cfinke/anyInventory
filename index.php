<?php

include("globals.php");

if (!$_REQUEST["c"]) $_REQUEST["c"] = 0;

$category = new category($_REQUEST["c"]);

$num_per_column = ceil($category->num_children / 2);
$output .= '<p>'.$category->get_breadcrumb_links().'</p>';
$output .= '<table style="width: 90%; margin-left: 5%; margin-right: 5%;"><tr><td style="width: 50%;">';

$i = 0;

foreach($category->children as $child){
	if ($i == $num_per_column) $output .= '</td><td style="width: 50%; vertical-align: top;">';
	
	$output .= '<a href="'.$_SERVER["PHP_SELF"].'?c='.$child->id.'">'.$child->name.'</a><br />';
	
	$i++;
}

$output .= '</td></tr></table>';

include("header.php");
echo $output;
include("footer.php");
exit;

?>