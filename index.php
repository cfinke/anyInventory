<?php

include("globals.php");

if (!$_REQUEST["c"]) $_REQUEST["c"] = 0;

$category = new category($_REQUEST["c"]);

$num_per_column = ceil($category->num_children / 2);
$output .= '<p style="padding-bottom: 5px; padding-top: 0px; padding-left: 0; padding-right: 0; margin-bottom: 10px;border-width: 0px 0px 1px 0px; border-style: solid; border-color: #000000;">'.$category->get_breadcrumb_links().'</p>';

if ($_REQUEST["id"]){
	$item = new item($_REQUEST["id"]);
	$output .= $item->export_description();
}
else{
	$output .= '<p><a href="add_item.php?c='.$_REQUEST["c"].'">Add an item here.</a></p>';
	$output .= '<table style="width: 90%; margin-left: 5%; margin-right: 5%;"><tr><td style="width: 50%;">';
	
	$i = 0;
	
	foreach($category->children as $child){
		if ($i == $num_per_column) $output .= '</td><td style="width: 50%; vertical-align: top;">';
		
		$output .= '<a href="'.$_SERVER["PHP_SELF"].'?c='.$child->id.'">'.$child->name.'</a><br />';
		
		$i++;
	}
	
	$output .= '</td></tr></table>';
	
	$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`='".$category->id."' ORDER BY `name`";
	$result = query($query);
	
	$output .= '
		<table style="width: 100%; margin-top: 20px;">
			<tr>
				<td style="white-space: nowrap; width: 5%; border-width: 0px 0px 1px 0px; border-style: solid; border-color: #000000;"font-weight: bold;">aI ID #</td>
				<td style="border-width: 0px 0px 1px 0px; border-style: solid; border-color: #000000;">Item Name</td>
			</tr>';
	while ($row = mysql_fetch_array($result)){
		$item = new item($row["id"]);
		
		$output .= '<tr><td>'.$item->id.'</td><td>'.$item->export_teaser().'</td></tr>';
	}
	$output .= '</table>';
}

display($output);

?>