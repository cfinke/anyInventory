<?php

require_once("globals.php");

if (isset($_REQUEST["fid"])){
	$query = "SELECT * FROM " . $db->quoteIdentifier("anyInventory_file_data") . " WHERE " . $db->quoteIdentifier("file_id") . "='".$_REQUEST["fid"]."' ORDER BY " . $db->quoteIdentifier("part_id") . " ASC";
	$result = $db->query($query);
	
	$file_string = '';
	
	while ($row = $result->fetchRow()){
		$file_string .= $row["data"];
	}
	
	$file_string = base64_decode($file_string);
	
	$query = "SELECT * FROM " . $db->quoteIdentifier("anyInventory_files") . " WHERE " . $db->quoteIdentifier("id") . "='".$_REQUEST["fid"]."'";
	$result = $db->query($query);
	$row = $result->fetchRow();
	
	header("Content-Type: " . $row["file_type"]);
	echo $file_string;
}

?>