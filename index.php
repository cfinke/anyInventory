<?php

include("globals.php");

// The default category is the top level.
if (!$_REQUEST["c"]) $_REQUEST["c"] = 0;

// Create a category object for the current category.
$category = new category($_REQUEST["c"]);

$title = "anyInventory: ".$category->breadcrumb_names;

// Set the number of categories to appear in the two-column layout.
$num_per_column = ceil($category->num_children / 2);

// Display the breadcrumb links to this category.
$output .= '<p style="padding-bottom: 5px; padding-top: 0px; padding-left: 0; padding-right: 0; margin-bottom: 10px;border-width: 0px 0px 1px 0px; border-style: solid; border-color: #000000;">'.$category->get_breadcrumb_links().'</p>';

if ($_REQUEST["id"]){
	// A specific item has been requested.
	$item = new item($_REQUEST["id"]);
	$output .= $item->export_description();
}
else{
	// We are in a specific category.
	if ($_REQUEST["c"] == 0){
		// Display introductory text, check for alerts
		
		$query = "SELECT * FROM `anyInventory_alerts` WHERE `time` <= NOW()";
		$result = query($query);
		
		while ($row = mysql_fetch_array($result)){
			$items = unserialize($row["item_ids"]);
			
			foreach ($items as $item_id){
				$item = new item($item_id);
				$field = new field($row["field_id"]);
				
				$trip_alert = eval('return ($item->fields[$field->name] '.$row["condition"].' $row["value"]);');
				
				if ($trip_alert){
					if (!$tripped){
						$output .= '<table><tr><td>';
						$tripped = true;
					}
					
					$output .= '
						<table cellspacing="1" cellpadding="2" style="background: #000000; width: 25ex; margin-bottom: 10px;" border="0">
							<tr style="background: #000000; color: #D3D3A6;">
								<td>
									Alert
								</td>
							</tr>
							<tr style="background: #D3D3A6;">
								<td style="text-align: center;">
									<b>'.$item->name.'</b><br /> '.$row["title"].'<br />
								</td>
							</tr>
						</table>';
				}
			}
		}
		
		if ($tripped) $output .= '</td><td>';
		
		$output .= '<p style="padding: 15px;">This is the front page and top-level category of anyInventory.  You can <a href="docs/">read the documentation</a> for instructions on using anyInventory, or you can navigate the inventory by clicking on any of the subcategories below; any items in a category will appear below the subcategories.  You can tell where you are in the inventory by the breadcrumb links at the top of each category page.</p>';
	}
	
	// If this category has subcategories, display them.
	if (is_array($category->children) && (count($category->children) > 0)){
		$output .= '<table style="width: 90%; margin-left: 5%; margin-right: 5%;"><tr><td style="width: 50%;">';
		
		$i = 0;
		
		foreach($category->children as $child){
			if ($i == $num_per_column) $output .= '</td><td style="width: 50%; vertical-align: top;">';
			
			$output .= '<p><a href="'.$_SERVER["PHP_SELF"].'?c='.$child->id.'"><b>'.$child->name.'</b></a></p>';
			
			$i++;
		}
		
		$output .= '</td></tr></table>';
	}
	
	// Display any items in this category.
	$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`='".$category->id."' ORDER BY `name` ASC";
	$result = query($query);
	
	if (mysql_num_rows($result) > 0){
		$output .= '
			<table style="width: 100%; margin-top: 20px;">
				<tr>
					<td style="white-space: nowrap; width: 5%; border-width: 0px 0px 1px 0px; border-style: solid; border-color: #000000; font-weight: bold;">ID #</td>
					<td style="border-width: 0px 0px 1px 0px; border-style: solid; border-color: #000000;">Name</td>
				</tr>';
		
		while ($row = mysql_fetch_array($result)){
			$item = new item($row["id"]);
			
			$output .= '<tr><td style="vertical-align: top;">'.$item->id.'</td><td style="vertical-align: top;">'.$item->export_teaser().'</td></tr>';
		}
		
		$output .= '</table>';
	}
	
	if ($tripped) $output .= '</td></tr></table>';
}

display($output);

?>