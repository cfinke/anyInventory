<?php

require_once("globals.php");

$replace = array("'",'"','&',"\\",':',';','`');

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
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_alerts') . " 
					(".$db->quoteIdentifier('id').",
                     " . $db->quoteIdentifier('title') . ",
					 " . $db->quoteIdentifier('item_ids') . ",
					 " . $db->quoteIdentifier('field_id') . ",
					 " . $db->quoteIdentifier('condition') . ",
					 " . $db->quoteIdentifier('value') . ",
					 " . $db->quoteIdentifier('time') . ",
 					 " . $db->quoteIdentifier('expire_time') . ",
					 " . $db->quoteIdentifier('timed') . ",
					 " . $db->quoteIdentifier('category_ids') . "
					 )
					VALUES
					('".nextId('alerts')."',
                                         '".$_POST["title"]."',
					 '".serialize($_POST["i"])."',
					 '".$_POST["field"]."',
					 '".$_POST["condition"]."',
					 '".$_POST["value"]."',
					 '".$timestamp."',
					 '".$expire_timestamp."',
					 '".(((bool) ($_POST["timed"] == "yes")) / 1)."',
					 '".$_POST["c"]."'
					 )";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
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
			
			$query = "SELECT " . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_fields') . " WHERE ";
			
			foreach($_POST["c"] as $cat_id){
				$query .= " " . $db->quoteIdentifier('categories') . " LIKE '%\"".$cat_id."\"%' AND ";
			}
			
			$query = substr($query, 0, strlen($query) - 4);
			$result = $db->query($query);
			if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			if ($result->numRows() == 0){
				header("Location: ../error_handler.php?eid=3");
				exit;
			}
			else{
				$query = "UPDATE " . $db->quoteIdentifier('anyInventory_alerts') . " SET " . $db->quoteIdentifier('category_ids') . "='".serialize($_POST["c"])."'";
				$result = $db->query($query);
				if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
				
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
		
		$query = "UPDATE " . $db->quoteIdentifier('anyInventory_alerts') . " SET 
					" . $db->quoteIdentifier('title') . "='".$_POST["title"]."',
					" . $db->quoteIdentifier('item_ids') . "='".serialize($_POST["i"])."',
					" . $db->quoteIdentifier('field_id') . "='".$_POST["field"]."',
					" . $db->quoteIdentifier('condition') . "='".$_POST["condition"]."',
					" . $db->quoteIdentifier('value') . "='".$_POST["value"]."',
					" . $db->quoteIdentifier('time') . "='".$timestamp."',
					" . $db->quoteIdentifier('expire_time') . "='".$expire_timestamp."',
					" . $db->quoteIdentifier('timed') . "='".(((bool) ($_POST["timed"] == "yes")) / 1)."'
					 WHERE " . $db->quoteIdentifier('id') . "='".$_POST["id"]."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
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
		
		$query = "DELETE FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('id') . "='".$_POST["id"]."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	}
}

header("Location: alerts.php");

?>
