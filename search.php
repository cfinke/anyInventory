<?php

include("globals.php");

$title = SEARCH_RESULTS;

if ($_GET["action"] == "quick_search"){
	$breadcrumbs = SEARCH_RESULTS.": ".stripslashes($_GET["q"]);
	
	$search_terms = explode(" ",$_GET["q"]);
	$search_fields = array("name");
	
	$output .= '<table>';
	
	if ($_GET["q"] != ''){
		$search_query = "SELECT `item_id` FROM `anyInventory_values` LEFT JOIN `anyInventory_items` USING `anyInventory_values`.`item_id`=`anyInventory_items`.`id` WHERE 1 AND ((( ";
		
		if ((count($search_terms) == 1) && (is_numeric($search_terms[0]))){
			$search_query .= " `item_id`='".$search_terms[0]."')) OR (( ";
		}
		
		foreach($search_terms as $search_term){
				$search_query .= " `value` LIKE '%".$search_term."%' OR ";
			}
			
			$search_query = substr($search_query,0,strlen($search_query) - 3).") AND (";
		}
		
		$search_query = substr($search_query,0,strlen($search_query) - 6).")) GROUP BY `item_id` ORDER BY `item_category`";
		$search_result = $db->query($search_query);
		
		$cat_id = -1;
		
		if ($search_result->numRows() > 0){
			while($row = $search_result->fetchRow()){
				$item = new item($row["id"]);
				
				if ($view_user->can_view($item->category->id)){
					if ($cat_id != $row["item_category"]){
						$cat_id = $row["item_category"];
						$output .= '
							<tr class="tableHeader">
								<td colspan="2">'.IN.' '.$item->category->get_breadcrumb_links().'</td>
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
			$output .= '<tr class="tableHeader"><td>'.NO_RESULTS.'</td></tr><tr><td class="tableData">'.NO_MATCHING_ITEMS.'</td></tr>';
		}
	}
	else{
		$output .= '<tr class="tableHeader"><td>'.NO_RESULTS.'</td></tr><tr><td class="tableData">'.NO_MATCHING_ITEMS.'</td></tr>';
	}
	
	$output .= '</table>';
}

display($output);

?>
