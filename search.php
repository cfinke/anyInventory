<?php

include("globals.php");

$title = "anyInventory: Search Results";

if ($_REQUEST["action"] == "quick_search"){
	$breadcrumbs = "Search Results: ".$_REQUEST["q"];
	
	$search_terms = explode(" ",$_REQUEST["q"]);
	$search_fields = array("name");
	
	$output .= '<table>';
	
	if (trim($_REQUEST["q"]) != ''){
		$query = "SELECT `name` FROM `anyInventory_fields`";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$search_fields[] = $row["name"];
		}
		
		$search_query = "SELECT `id`,`item_category` FROM `anyInventory_items` WHERE 1 AND ( ";
		
		foreach($search_terms as $search_term){
			foreach($search_fields as $search_field){
				$search_query .= " `".$search_field."` LIKE '%".$search_term."%' OR ";
			}
			
			$search_query = substr($search_query,0,strlen($search_query) - 3)." ) AND ( ";
		}
		
		$search_query = substr($search_query,0,strlen($search_query) - 6)." ORDER BY `item_category`";
		$search_result = mysql_query($search_query) or die(mysql_error() . '<br /><br />' . $search_query);
		
		$cat_id = -1;
		
		if (mysql_num_rows($search_result) > 0){
			while($row = mysql_fetch_array($search_result)){
				$item = new item($row["id"]);
				
				if ($cat_id != $row["item_category"]){
					$cat_id = $row["item_category"];
					$output .= '
						<tr class="tableHeader">
							<td>In '.$item->category->get_breadcrumb_links().'</td></tr><tr><td class="tableData">';
				}
				
				$output .= '<tr><td>'.$item->export_teaser().'</td></tr>';
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