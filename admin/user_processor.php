<?php

include("globals.php");

if ($_POST["action"] == "do_add"){
	if ($admin_user->usertype != 'Administrator'){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	
	// Check for duplicate username
	$query = "SELECT `username` FROM `anyInventory_users` WHERE `username`='".$_POST["username"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	if ($result->numRows() > 0){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	else{
		$query_data = array("id"=>get_unique_id('anyInventory_users'),
							"username"=>stripslashes($_POST["username"]),
							"password"=>md5($_POST["password"]),
							"usertype"=>$_POST["usertype"],
							"categories_view"=>serialize($_POST["c_view"]),
							"categories_admin"=>serialize($_POST["c_admin"]));
		$result = $db->autoExecute('anyInventory_users',$query_data,DB_AUTOQUERY_INSERT);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	}
}
elseif($_POST["action"] == "do_edit"){
	if ($admin_user->usertype != 'Administrator'){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	
	// Check for duplicate username
	$query = "SELECT `username` FROM `anyInventory_users` WHERE `username`='".$_POST["username"]."' AND `id` != '".$_POST["id"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	if ($result->numRows() > 0){
		header("Location: ../error_handler.php?eid=16");
		exit;
	}
	else{
		if (!is_array($_POST["c_view"])) $_POST["c_view"] = array();
		if (!is_array($_POST["c_admin"])) $_POST["c_admin"] = array();
		
		$query = "UPDATE `anyInventory_users` SET 
					`username`='".$_POST["username"]."'";
		
		if ($_POST["password"] != ''){
			$query .= ", `password`='".md5($_POST["password"])."'";
		}
		
		if ($_POST["id"] != ADMIN_USER_ID){
		
			$query .= ", `usertype`='".$_POST["usertype"]."',
						`categories_view`='".addslashes(serialize($_POST["c_view"]))."',
						`categories_admin`='".addslashes(serialize($_POST["c_admin"]))."'";
		}
		
		$query .= " WHERE `id`='".$_POST["id"]."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	}
}
elseif($_POST["action"] == "do_edit_own"){
	if ($_POST["id"] != $_SESSION["user"]["id"]){
		header("Location: ../error_handler.php?eid=10");
		exit;
	}
	
	if ($_POST["password"] != ''){
		$query = "UPDATE `anyInventory_users` SET `password`='".md5($_POST["password"])."' WHERE `id`='".$_POST["id"]."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	}
}
elseif($_POST["action"] == "do_delete"){
	if ($admin_user->usertype != 'Administrator'){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	
	if ($_POST["delete"] == "Delete"){
		$query = "DELETE FROM `anyInventory_users` WHERE `id`='".$_POST["id"]."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	}
}

header("Location: users.php");
exit;

?>
