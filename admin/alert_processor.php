<?php

include("globals.php");

$replace = array("'",'"','&',"\\",':',';','`','[',']');

if ($_POST["action"] == "do_add"){
	if (!is_array($_POST["i"])){
		header("Location: ../error_handler.php?eid=6");
		exit;
	}
	else{
		$cat_ids = unserialize(stripslashes($_POST["c"]));
		
		if (is_array($cat_ids)){
			foreach($cat_ids as $cat_id){
				if (!$admin_user->can_admin($cat_id)){
					header("Location: ../error_handler.php?eid=13");
					exit;
				}
			}
		}
		else{
			$_POST["c"] = addslashes(serialize(array()));
		}
		
		$_POST["title"] = stripslashes($_POST["title"]);
		$_POST["title"] = str_replace($replace,"",$_POST["title"]);
		$_POST["title"] = trim(addslashes($_POST["title"]));
		
		$timestamp = $_POST["year"];
		$timestamp .= ($_POST["month"] < 10) ? '0' . $_POST["month"] : $_POST["month"];
		$timestamp .= ($_POST["day"] < 10) ? '0' . $_POST["day"] : $_POST["day"];
		$timestamp .= '000000';
		
		if ($_POST["expire"] == "yes"){
			$expire_timestamp = $_POST["expire_year"];
			$expire_timestamp .= ($_POST["expire_month"] < 10) ? '0' . $_POST["expire_month"] : $_POST["expire_month"];
			$expire_timestamp .= ($_POST["expire_day"] < 10) ? '0' . $_POST["expire_day"] : $_POST["expire_day"];
			$expire_timestamp .= '235959';
		}
		else{
			$expire_timestamp = '00000000000000';
		}
		
		$query = "INSERT INTO `anyInventory_alerts` 
					(`title`,
					 `item_ids`,
					 `field_id`,
					 `condition`,
					 `value`,
					 `time`,
 					 `expire_time`,
					 `timed`,
					 `category_ids`
					 )
					VALUES
					('".$_POST["title"]."',
					 '".serialize($_POST["i"])."',
					 '".$_POST["field"]."',
					 '".$_POST["condition"]."',
					 '".$_POST["value"]."',
					 '".$timestamp."',
					 '".$expire_timestamp."',
					 '".(((bool) ($_POST["timed"] == "yes")) / 1)."',
					 '".$_POST["c"]."'
					 )";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	}
}
elseif($_POST["action"] == "do_edit_cat_ids"){
	if ($_POST["cancel"] != CANCEL){
		if (!is_array($_POST["c"])){
			header("Location: ../error_handler.php?eid=5");
			exit;
		}
		else{
			foreach($_POST["c"] as $cat_id){
				if (!$admin_user->can_admin($cat_id)){
					header("Location: ../error_handler.php?eid=13");
					exit;
				}
			}
			
			$query = "SELECT `id`,`name` FROM `anyInventory_fields` WHERE ";
			
			foreach($_POST["c"] as $cat_id){
				$query .= " `categories` LIKE '%\"".$cat_id."\"%' AND ";
			}
			
			$query = substr($query, 0, strlen($query) - 4);
			$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			if (mysql_num_rows($result) == 0){
				header("Location: ../error_handler.php?eid=3");
				exit;
			}
			else{
				$query = "UPDATE `anyInventory_alerts` SET `category_ids`='".serialize($_POST["c"])."'";
				mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
				
				header("Location: edit_alert.php?id=".$_POST["id"]);
				exit;
			}
		}
	}
}
elseif($_POST["action"] == "do_edit"){
	if (!is_array($_POST["i"])){
		header("Location: ../error_handler.php?eid=6");
		exit;
	}
	else{
		$cat_ids = unserialize(stripslashes($_POST["c"]));
		
		if (is_array($cat_ids)){
			foreach($cat_ids as $cat_id){
				if (!$admin_user->can_admin($cat_id)){
					header("Location: ../error_handler.php?eid=13");
					exit;
				}
			}
		}
		
		$timestamp = $_POST["year"];
		$timestamp .= ($_POST["month"] < 10) ? '0' . $_POST["month"] : $_POST["month"];
		$timestamp .= ($_POST["day"] < 10) ? '0' . $_POST["day"] : $_POST["day"];
		$timestamp .= '000000';
		
		if ($_POST["expire"] == "yes"){
			$expire_timestamp = $_POST["expire_year"];
			$expire_timestamp .= ($_POST["expire_month"] < 10) ? '0' . $_POST["expire_month"] : $_POST["expire_month"];
			$expire_timestamp .= ($_POST["expire_day"] < 10) ? '0' . $_POST["expire_day"] : $_POST["expire_day"];
			$expire_timestamp .= '235959';
		}
		else{
			$expire_timestamp = '00000000000000';
		}
		
		$query = "UPDATE `anyInventory_alerts` SET 
					`title`='".$_POST["title"]."',
					`item_ids`='".serialize($_POST["i"])."',
					`field_id`='".$_POST["field"]."',
					`condition`='".$_POST["condition"]."',
					`value`='".$_POST["value"]."',
					`time`='".$timestamp."',
					`expire_time`='".$expire_timestamp."',
					`timed`='".(((bool) ($_POST["timed"] == "yes")) / 1)."'
					 WHERE `id`='".$_POST["id"]."'";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	}
}
elseif($_POST["action"] == "do_delete"){
	if ($_POST["delete"] == _DELETE){
		$alert = new alert($_POST["id"]);
		
		if (is_array($alert->category_ids)){
			foreach($alert->category_ids as $cat_id){
				if (!$admin_user->can_admin($cat_id)){
					header("Location: ../error_handler.php?eid=13");
					exit;
				}
			}
		}
		
		$query = "DELETE FROM `anyInventory_alerts` WHERE `id`='".$_POST["id"]."'";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	}
}

header("Location: alerts.php");

?>