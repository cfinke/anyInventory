<?php

include("globals.php");

foreach($_POST as $key => $value){
	if (!is_array($_POST[$key])){
		$_POST[$key] = stripslashes($value);
	}
}

foreach($_GET as $key => $value){
	if (!is_array($_GET[$key])){
		$_GET[$key] = stripslashes($value);
	}
}

$replace = array("'",'"','&',"\\",':',';','`','[',']');

if ($_POST["action"] == "do_add"){
	if (!is_array($_POST["i"])){
		header("Location: ../error_handler.php?eid=6");
		exit;
	}
	else{
		$cat_ids = unserialize($_POST["c"]);
		
		if (is_array($cat_ids)){
			foreach($cat_ids as $cat_id){
				if (!$admin_user->can_admin($cat_id)){
					header("Location: ../error_handler.php?eid=13");
					exit;
				}
			}
		}
		else{
			$_POST["c"] = serialize(array());
		}
		
		$_POST["title"] = str_replace($replace,"",$_POST["title"]);
		$_POST["title"] = trim($_POST["title"]);
		
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
		
		$query = "INSERT INTO ".$db->quoteIdentifier('anyInventory_alerts')." (".$db->quoteIdentifier('id').",".$db->quoteIdentifier('title').",".$db->quoteIdentifier('item_ids').",".$db->quoteIdentifier('field_id').",".$db->quoteIdentifier('time').",".$db->quoteIdentifier('expire_time').",".$db->quoteIdentifier('timed').",".$db->quoteIdentifier('category_ids')."";
		if ($_POST["condition"] != '') $query .= ", ".$db->quoteIdentifier('condition')."";
		if ($_POST["value"] != '') $query .= ", ".$db->quoteIdentifier('value')."";
		$query .= ") VALUES (?, ?, ?, ?, ?, ?, ?, ?";
		if ($_POST["condition"] != '') $query .= ", ?";
		if ($_POST["value"] != '') $query .= ", ?";
		$query .= ")";
		$query_data = array(get_unique_id('anyInventory_alerts'),$_POST["title"],serialize($_POST["i"]),intval($_POST["field"]),$timestamp,$expire_timestamp,intval(($_POST["timed"] == "yes")),$_POST["c"]);
		if ($_POST["condition"] != '') $query_data[] = $_POST["value"];
		if ($_POST["value"] != '') $query_data[] = $_POST["condition"];
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
}
elseif($_POST["action"] == "do_edit_cat_ids"){
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
		
		$query = "SELECT ".$db->quoteIdentifier('id').",".$db->quoteIdentifier('name')." FROM ".$db->quoteIdentifier('anyInventory_fields')." WHERE ";
		
		foreach($_POST["c"] as $cat_id){
			$query .= " ".$db->quoteIdentifier('categories')." LIKE '%\"".$cat_id."\"%' AND ";
		}
		
		$query = substr($query, 0, strlen($query) - 4);
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		
		if ($result->numRows() == 0){
			header("Location: ../error_handler.php?eid=3");
			exit;
		}
		else{
			$query = "UPDATE ".$db->quoteIdentifier('anyInventory_alerts')." SET ".$db->quoteIdentifier('category_ids')."='".serialize($_POST["c"])."'";
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
			
			header("Location: edit_alert.php?id=".$_POST["id"]);
			exit;
		}
	}
}
elseif($_POST["action"] == "do_edit"){
	if (!is_array($_POST["i"])){
		header("Location: ../error_handler.php?eid=6");
		exit;
	}
	else{
		$cat_ids = unserialize($_POST["c"]);
		
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
		
		$query = "UPDATE ".$db->quoteIdentifier('anyInventory_alerts')." SET ".$db->quoteIdentifier('title')." = ?, ".$db->quoteIdentifier('item_ids')." = ?, ".$db->quoteIdentifier('field_id')." = ?, ".$db->quoteIdentifier('time')." = ?, ".$db->quoteIdentifier('expire_time')." = ?, ".$db->quoteIdentifier('timed')." = ?";
		if ($_POST["condition"] != '') $query .= ", ".$db->quoteIdentifier('condition')." = ?";
		if ($_POST["value"] != '') $query .= ", ".$db->quoteIdentifier('value')." = ?";
		$query .= " WHERE ".$db->quoteIdentifier('id')." = ?";
		$query_data = array($_POST["title"],serialize($_POST["i"]),intval($_POST["field"]),$timestamp,$expire_timestamp,intval(($_POST["timed"] == "yes")));
		if ($_POST["condition"] != '') $query_data[] = $_POST["value"];
		if ($_POST["value"] != '') $query_data[] = $_POST["condition"];
		$query_data[] = $_POST["id"];
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
}
elseif($_POST["action"] == "do_delete"){
	if ($_POST["delete"] == "Delete"){
		$alert = new alert($_POST["id"]);
		
		if (is_array($alert->category_ids)){
			foreach($alert->category_ids as $cat_id){
				if (!$admin_user->can_admin($cat_id)){
					header("Location: ../error_handler.php?eid=13");
					exit;
				}
			}
		}
		
		$query = "DELETE FROM ".$db->quoteIdentifier('anyInventory_alerts')." WHERE ".$db->quoteIdentifier('id')."='".$_POST["id"]."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
}

header("Location: alerts.php");

?>
