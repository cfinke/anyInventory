<?php

require_once("globals.php");

$title = SEARCH_RESULTS;

$breadcrumbs = SEARCH_RESULTS.": ".stripslashes($_GET["q"]);

$search_terms = explode(" ",$_GET["q"]);
$search_fields = array("name");

$output .= '<table>';

if (is_array($search_terms)){
	if ((count($search_terms) == 1) && (is_numeric($search_terms[0]))){
		$search_query = "SELECT `id` FROM `anyInventory_items` WHERE `id`='".$search_terms[0]."'";
		$search_result = $db->query($search_query);
		
		if ($search_result->numRows() > 0){
			$row = $search_result->fetchRow();
			
			$item = new item($row["id"]);
			
			if ($view_user->can_view($item->category->id)){
				$output .= '
					<tr class="tableHeader">
						<td colspan="2">'.ID_MATCH.'</td>
					</tr>';
				
				$output .= '
					<tr>
						<td>'.$item->id.'</td>
						<td>'.$item->export_teaser().'</td>
					</tr>';
			}
		}
	}
	
	$search_query = "SELECT `id` FROM `anyInventory_items` WHERE 1 AND ";
	foreach($search_terms as $search_term){
		$search_query .= " `name` LIKE '%".$search_term."%' AND ";
	}
	$search_query = substr($search_query,0,strlen($search_query) - 5);
	$search_result = $db->query($search_query);
	
	if ($search_result->numRows() > 0){
		$row = $search_result->fetchRow();
		
		$item = new item($row["id"]);
		
		if ($view_user->can_view($item->category->id)){
			$output .= '
				<tr class="tableHeader">
					<td colspan="2">'.NAME_MATCH.'</td>
				</tr>';
			
			$output .= '
				<tr>
					<td>'.$item->id.'</td>
					<td>'.$item->export_teaser().'</td>
				</tr>';
		}
	}
	
	$search_query = "SELECT `item_id` , COUNT( `item_id` ) AS `num_matches` FROM `anyInventory_values` WHERE 1 AND ( ";
	
	if (is_array($search_terms)){
		foreach($search_terms as $search_term){
			$search_query .= " `value` LIKE '%".$search_term."%' OR ";
		}
	}
	
	$search_query = substr($search_query,0,strlen($search_query) - 4).") GROUP BY `item_id` ORDER BY `num_matches` DESC";
	$search_result = $db->query($search_query);
	if (DB::isError($search_result)) die($search_result->getMessage().': line '.__LINE__.'<br /><br />'.$search_result->userinfo);
	
	if ($search_result->numRows() > 0){
		$output .= '
			<tr class="tableHeader">
				<td colspan="2">&nbsp;</td>
			</tr>';
		
		while($row = $search_result->fetchRow()){
			$item = new item($row["item_id"]);
			
			if ($view_user->can_view($item->category->id)){
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
		$output .= '<tr class="tableHeader"><td colspan="2">'.NO_RESULTS.'</td></tr><tr><td class="tableData">'.NO_MATCHING_ITEMS.'</td></tr>';
	}
}
else{
	$output .= '<tr class="tableHeader"><td colspan="2">'.NO_RESULTS.'</td></tr><tr><td class="tableData">'.NO_MATCHING_ITEMS.'</td></tr>';
}

$output .= '</table>';

display($output);

?>
