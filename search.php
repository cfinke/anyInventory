<?php

include("globals.php");

$title = "anyInventory: Search Results";

if ($_GET["action"] == "quick_search"){
	$breadcrumbs = "Search Results: ".stripslashes($_GET["q"]);
	
	$search_terms = explode(" ",$_GET["q"]);
	$search_fields = array("name");
	
	$output .= '<table>';
	
	if ($_GET["q"] != ''){
		$query = "SELECT `name` FROM `anyInventory_fields` WHERE `input_type` NOT IN ('file','divider','item')";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$search_fields[] = $row["name"];
		}
		
		$search_query = "SELECT `id`,`item_category` FROM `anyInventory_items` WHERE 1 AND ((( ";
		
		if ((count($search_terms) == 1) && (is_numeric($search_terms[0]))){
			$search_query .= " `id`='".$search_terms[0]."')) OR (( ";
		}
		
		foreach($search_terms as $search_term){
			foreach($search_fields as $search_field){
				$search_query .= " `".$search_field."` LIKE '%".$search_term."%' OR ";
			}
			
			$search_query = substr($search_query,0,strlen($search_query) - 3).") AND (";
		}
		
		$search_query = substr($search_query,0,strlen($search_query) - 6).")) ORDER BY `item_category`";
		$search_result = mysql_query($search_query) or die(mysql_error() . '<br /><br />' . $search_query);
		
		$cat_id = -1;
		
		if (mysql_num_rows($search_result) > 0){
			while($row = mysql_fetch_array($search_result)){
				$item = new item($row["id"]);
				
				if ($view_user->can_view($item->category->id)){
					if ($cat_id != $row["item_category"]){
						$cat_id = $row["item_category"];
						$output .= '
							<tr class="tableHeader">
								<td colspan="2">In '.$item->category->get_breadcrumb_links().'</td>
							</tr>';
					}
					
					$output .= '<tr>';
					
					if ($item->category->auto_inc_field){
						$output .= '<td>'.$item->id.'</td>';
					}
					else{
						$output .= '<td>&nbsp;</td>';
					}
					
					$output .= '<td>'.$item->export_teaser().'</td></tr>';
				}
			}
		}
		else{
			$output .= '<tr class="tableHeader"><td>No matching results</td></tr><tr><td class="tableData">There were no items that matched your search conditions.</td></tr>';
		}
	}
	else{
		$output .= '<tr class="tableHeader"><td>No matching results</td></tr><tr><td class="tableData">There were no items that matched your search conditions.</td></tr>';
	}
	
	$output .= '</table>';
}

display($output);

?>