<?php

include("globals.php");

if ($_REQUEST["action"] == "do_add"){
	$timestamp = $_REQUEST["year"];
	$timestamp .= ($_REQUEST["month"] < 10) ? '0' . $_REQUEST["month"] : $_REQUEST["month"];
	$timestamp .= ($_REQUEST["day"] < 10) ? '0' . $_REQUEST["day"] : $_REQUEST["day"];
	$timestamp .= '000000';
	
	$query = "INSERT INTO `anyInventory_alerts` 
				(`title`,
				 `item_ids`,
				 `field_id`,
				 `condition`,
				 `value`,
				 `time`)
				VALUES
				('".$_REQUEST["title"]."',
				 '".serialize($_REQUEST["i"])."',
				 '".$_REQUEST["field"]."',
				 '".$_REQUEST["condition"]."',
				 '".$_REQUEST["value"]."',
				 '".$timestamp."')";
	query($query);
}
elseif($_REQUEST["action"] == "do_edit"){
	$query = "UPDATE `anyInventory_alerts` SET `title`='".$_REQUEST["title"]."'";
	query($query);
}
elseif($_REQUEST["action"] == "do_delete"){
	$query = "DELETE FROM `anyInventory_alerts` WHERE `id`='".$_REQUEST["id"]."'";
	query($query);
}

header("Location: alerts.php");

?>