<?php

include("globals.php");

if ($_POST["action"] == "do_add"){
	if ($admin_user->usertype != 'Administrator'){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	
	// Check for duplicate username
	$query = "SELECT `username` FROM `anyInventory_users` WHERE `username`='".$_POST["username"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if (mysql_num_rows($result) > 0){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	else{
		$query = "INSERT INTO `anyInventory_users` 
					(`username`,
					 `password`,
					 `usertype`,
					 `categories_view`,
					 `categories_admin`)
					VALUES
					('".$_POST["username"]."',
					 '".md5($_POST["password"])."',
					 '".$_POST["usertype"]."',
					 '".addslashes(serialize($_POST["c_view"]))."',
					 '".addslashes(serialize($_POST["c_admin"]))."')";
		mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}
elseif($_POST["action"] == "do_edit"){
	if ($admin_user->usertype != 'Administrator'){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	
	// Check for duplicate username
	$query = "SELECT `username` FROM `anyInventory_users` WHERE `username`='".$_POST["username"]."' AND `id` != '".$_POST["id"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if (mysql_num_rows($result) > 0){
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
		
		if ($_POST["id"] != get_config_value('ADMIN_USER_ID')){
		
			$query .= ", `usertype`='".$_POST["usertype"]."',
						`categories_view`='".addslashes(serialize($_POST["c_view"]))."',
						`categories_admin`='".addslashes(serialize($_POST["c_admin"]))."'";
		}
		
		$query .= " WHERE `id`='".$_POST["id"]."'";
		mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}
elseif($_POST["action"] == "do_edit_own"){
	if ($_POST["id"] != $_SESSION["user"]["id"]){
		header("Location: ../error_handler.php?eid=10");
		exit;
	}
	
	if ($_POST["password"] != ''){
		$query = "UPDATE `anyInventory_users` SET `password`='".md5($_POST["password"])."' WHERE `id`='".$_POST["id"]."'";
		mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}
elseif($_POST["action"] == "do_delete"){
	if ($admin_user->usertype != 'Administrator'){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	
	if ($_POST["delete"] == "Delete"){
		$query = "DELETE FROM `anyInventory_users` WHERE `id`='".$_POST["id"]."'";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}

header("Location: users.php");
exit;

?>
