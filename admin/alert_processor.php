<?php

include("globals.php");

if ($_REQUEST["action"] == "do_add"){
	$query = "INSERT INTO `anyInventory_alerts` 
				(`title`)
				VALUES
				('".$_REQUEST["title"]."')";
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