<?php

include("globals.php");

if ($_REQUEST["action"] == "do_add"){
	header("Location: ".$_SERVER["PHP_SELF"]);
}
elseif($_REQUEST["action"] == "do_delete"){
	header("Location: ".$_SERVER["PHP_SELF"]);
}

$title = 'anyInventory Items';
$page_key = "items";
$links = array(array("url"=>$_SERVER["PHP_SELF"]."?action=add","name"=>"Add an Item"));

if ($_REQUEST["action"] == "add"){
	$output = '';
}
else{
	$output .= '<p><a href="'.$_SERVER["PHP_SELF"].'?action=add">Add an item.</a></p>';
	/*
	$query = "SELECT *,'' as `nosortcol_`,`name` as `sortcol_Name`,'' as `nosortcol_Fields` FROM `anyInventory_itemsfields`";
	$data_obj = new dataset_library("Fields", $query, $_REQUEST, "mysql");
	$result = $data_obj->get_result_resource();
	$rows = $data_obj->get_result_set();
	
	if (mysql_num_rows($result) > 0){
		$i = 0;
		
		while($row = mysql_fetch_assoc($result)){
			$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
			$table_set .= '<tr class="'.$color_code.'">';
			$table_set .= '<td align="center" style="width: 10%; white-space: nowrap;"><a href="'.$_SERVER["PHP_SELF"].'?action=edit_field&amp;id='.$row["id"].'">[edit]</a> <a href="'.$_SERVER["PHP_SELF"].'?action=delete_field&amp;id='.$row["id"].'">[delete]</a></td>';
			$table_set .= '<td>'.$row["name"].'</td>';
			$table_set .= '<td>'.$row["input_type"].'</td>';
			$table_set .= '<td>'.$row["values"].'</td>';
			$table_set .= '<td>'.$row["default_value"].'</td>';
			$table_set .= '<td>'.$row["size"].'</td>';
			$table_set .= '</tr>';
			$i++;
		}
	}
	else{
		$table_set .= '<tr class="row_off"><td>There are no fields to display.</td></tr>';
	}
	
	$table_set = $data_obj->get_sort_interface() . $table_set . $data_obj->get_paging_interface();
	
	$output .= '<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="2">'.$table_set.'</table>';
	*/
}

include("header.php");
echo $output;
include("footer.php");

exit;

?>