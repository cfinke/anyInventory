<?php

include("globals.php");

if ($_POST["action"] == "do_add"){
	if ($admin_user->usertype != 'Administrator'){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	
	// Check for duplicate username
	$query = "SELECT ".$db->quoteIdentifier('username')." FROM ".$db->quoteIdentifier('anyInventory_users')." WHERE ".$db->quoteIdentifier('username')."='".$_POST["username"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	if ($result->numRows() > 0){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	else{
		$query = "INSERT INTO ".$db->quoteIdentifier('anyInventory_users')." (".$db->quoteIdentifier('id').",".$db->quoteIdentifier('username').",".$db->quoteIdentifier('password').",".$db->quoteIdentifier('usertype').",".$db->quoteIdentifier('categories_admin').",".$db->quoteIdentifier('categories_view').") VALUES (?, ?, ?, ?, ?, ?)";
		$query_data = array(get_unique_id('anyInventory_users'),stripslashes($_POST["username"]),md5($_POST["password"]),$_POST["usertype"],serialize($_POST["c_view"]),serialize($_POST["c_admin"]));
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
}
elseif($_POST["action"] == "do_edit"){
	if ($admin_user->usertype != 'Administrator'){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	
	// Check for duplicate username
	$query = "SELECT ".$db->quoteIdentifier('username')." FROM ".$db->quoteIdentifier('anyInventory_users')." WHERE ".$db->quoteIdentifier('username')."='".$_POST["username"]."' AND ".$db->quoteIdentifier('id')." != '".$_POST["id"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	if ($result->numRows() > 0){
		header("Location: ../error_handler.php?eid=16");
		exit;
	}
	else{
		if (!is_array($_POST["c_view"])) $_POST["c_view"] = array();
		if (!is_array($_POST["c_admin"])) $_POST["c_admin"] = array();
		
		$query = "UPDATE ".$db->quoteIdentifier('anyInventory_users')." SET 
					".$db->quoteIdentifier('username')."='".$_POST["username"]."'";
		
		if ($_POST["password"] != ''){
			$query .= ", ".$db->quoteIdentifier('password')."='".md5($_POST["password"])."'";
		}
		
		if ($_POST["id"] != ADMIN_USER_ID){
		
			$query .= ", ".$db->quoteIdentifier('usertype')."='".$_POST["usertype"]."',
						".$db->quoteIdentifier('categories_view')."='".addslashes(serialize($_POST["c_view"]))."',
						".$db->quoteIdentifier('categories_admin')."='".addslashes(serialize($_POST["c_admin"]))."'";
		}
		
		$query .= " WHERE ".$db->quoteIdentifier('id')."='".$_POST["id"]."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
}
elseif($_POST["action"] == "do_edit_own"){
	if ($_POST["id"] != $_SESSION["user"]["id"]){
		header("Location: ../error_handler.php?eid=10");
		exit;
	}
	
	if ($_POST["password"] != ''){
		$query = "UPDATE ".$db->quoteIdentifier('anyInventory_users')." SET ".$db->quoteIdentifier('password')."='".md5($_POST["password"])."' WHERE ".$db->quoteIdentifier('id')."='".$_POST["id"]."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
}
elseif($_POST["action"] == "do_delete"){
	if ($admin_user->usertype != 'Administrator'){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	
	if ($_POST["delete"] == "Delete"){
		$query = "DELETE FROM ".$db->quoteIdentifier('anyInventory_users')." WHERE ".$db->quoteIdentifier('id')."='".$_POST["id"]."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
}

header("Location: users.php");
exit;

?>
