<?php

include("globals.php");

$title = SEARCH_RESULTS;

$breadcrumbs = SEARCH_RESULTS.": ".stripslashes($_GET["q"]);

$search_terms = explode(" ",$_GET["q"]);
$search_fields = array("name");

$output .= '<table>';

if (is_array($search_terms)){
	if ((count($search_terms) == 1) && (is_numeric($search_terms[0]))){
		$search_query = "SELECT `id` FROM `anyInventory_items` WHERE `id`='".$search_terms[0]."'";
		$search_result = mysql_query($search_query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $search_query);
		
		if (mysql_num_rows($search_result) > 0){
			$row = mysql_fetch_array($search_result);
			
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
	$search_result = mysql_query($search_query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'  .$search_query);
	
	if (mysql_num_rows($search_result) > 0){
		$output .= '
			<tr class="tableHeader">
				<td colspan="2">'.NAME_MATCH.'</td>
			</tr>';
		
		while ($row = mysql_fetch_array($search_result)){
			$item = new item($row["id"]);
			
			if ($view_user->can_view($item->category->id)){
				$output .= '
					<tr>
						<td>'.$item->id.'</td>
						<td>'.$item->export_teaser().'</td>
					</tr>';
			}
		}
	}
	
	$search_query = "SELECT `item_id`, COUNT(`item_id`) AS `num_matches` FROM `anyInventory_values` WHERE 1 AND ( ";
	
	if (is_array($search_terms)){
		foreach($search_terms as $search_term){
			$search_query .= " `value` LIKE '%".$search_term."%' OR ";
		}
	}
	
	$search_query = substr($search_query,0,strlen($search_query) - 4).") GROUP BY `item_id` ORDER BY `num_matches` DESC";
	$search_result = mysql_query($search_query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'  .$search_query);
	
	if (mysql_num_rows($search_result) > 0){
		$output .= '
			<tr class="tableHeader">
				<td colspan="2">'.SEARCH_RESULTS.'</td>
			</tr>';
		
		while ($row = mysql_fetch_array($search_result)){
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
		$output .= '<tr class="tableHeader"><td colspan="2">'.NO_RESULTS.'</td></tr><tr><td class="tableData" colspan="2">'.NO_MATCHING_ITEMS.'</td></tr>';
	}
}
else{
	$output .= '<tr class="tableHeader"><td colspan="2">'.NO_RESULTS.'</td></tr><tr><td class="tableData" colspan="2">'.NO_MATCHING_ITEMS.'</td></tr>';
}

$output .= '</table>';

display($output);

?>