<?php

include("globals.php");

$replace = array("'",'"','&',"\\",':',';','`','[',']');

if ($_REQUEST["action"] == "do_add"){
	if (!is_array($_REQUEST["i"])){
		header("Location: ../error_handler.php?eid=6");
		exit;
	}
	
	$_REQUEST["title"] = stripslashes($_REQUEST["title"]);
	$_REQUEST["title"] = str_replace($replace,"",$_REQUEST["title"]);
	$_REQUEST["title"] = trim(addslashes($_REQUEST["title"]));
	
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
				 `time`,
				 `timed`,
				 `category_ids`)
				VALUES
				('".$_REQUEST["title"]."',
				 '".serialize($_REQUEST["i"])."',
				 '".$_REQUEST["field"]."',
				 '".$_REQUEST["condition"]."',
				 '".$_REQUEST["value"]."',
				 '".$timestamp."',
				 '".(((bool) ($_REQUEST["timed"] == "yes")) / 1)."',
				 '".$_REQUEST["c"]."')";
	mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
}
elseif($_REQUEST["action"] == "do_edit_cat_ids"){
	if (!is_array($_REQUEST["c"])){
		header("Location: ../error_handler.php?eid=5");
		exit;
	}
	else{
		$_REQUEST["title"] = stripslashes($_REQUEST["title"]);
		$_REQUEST["title"] = str_replace($replace,"",$_REQUEST["title"]);
		$_REQUEST["title"] = trim(addslashes($_REQUEST["title"]));
		
		$query = "SELECT `id`,`name` FROM `anyInventory_fields` WHERE ";
		
		foreach($_REQUEST["c"] as $cat_id){
			$query .= " `categories` LIKE '%\"".$cat_id."\"%' AND ";
		}
		
		$query = substr($query, 0, strlen($query) - 4);
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		if (mysql_num_rows($result) == 0){
			header("Location: ../error_handler.php?eid=3");
			exit;
		}
		else{
			$query = "UPDATE `anyInventory_alerts` SET `category_ids`='".serialize($_REQUEST["c"])."'";
			mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
			
			header("Location: edit_alert.php?id=".$_REQUEST["id"]);
			exit;
		}
	}
}
elseif($_REQUEST["action"] == "do_edit"){
	if (!is_array($_REQUEST["i"])){
		header("Location: ../error_handler.php?eid=6");
		exit;
	}
	else{
		$timestamp = $_REQUEST["year"];
		$timestamp .= ($_REQUEST["month"] < 10) ? '0' . $_REQUEST["month"] : $_REQUEST["month"];
		$timestamp .= ($_REQUEST["day"] < 10) ? '0' . $_REQUEST["day"] : $_REQUEST["day"];
		$timestamp .= '000000';
		
		$query = "UPDATE `anyInventory_alerts` SET 
					`title`='".$_REQUEST["title"]."',
					`item_ids`='".serialize($_REQUEST["i"])."',
					`field_id`='".$_REQUEST["field"]."',
					`condition`='".$_REQUEST["condition"]."',
					`value`='".$_REQUEST["value"]."',
					`time`='".$timestamp."',
					`timed`='".(((bool) ($_REQUEST["timed"] == "yes")) / 1)."'
					 WHERE `id`='".$_REQUEST["id"]."'";
		mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}
elseif($_REQUEST["action"] == "do_delete"){
	if ($_REQUEST["delete"] == "Delete"){
		$query = "DELETE FROM `anyInventory_alerts` WHERE `id`='".$_REQUEST["id"]."'";
		mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}

header("Location: alerts.php");

?>