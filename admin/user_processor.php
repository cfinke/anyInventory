<?php

include("globals.php");

/*
if ($_SESSION["usertype"] != 'Administrator'){
	header("Location: ../error_handler.php?eid=11");
	exit;
}
*/

if ($_REQUEST["action"] == "do_add"){
	// Check for duplicate username
	$query = "SELECT `username` FROM `anyInventory_users` WHERE `username`='".$_REQUEST["username"]."'";
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
					('".$_REQUEST["username"]."',
					 '".md5($_REQUEST["password"])."',
					 '".$_REQUEST["usertype"]."',
					 '".addslashes(serialize($_REQUEST["c_view"]))."',
					 '".addslashes(serialize($_REQUEST["c_admin"]))."')";
		mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}
elseif($_REQUEST["action"] == "do_edit"){
	// Check for duplicate username
	$query = "SELECT `username` FROM `anyInventory_users` WHERE `username`='".$_REQUEST["username"]."' AND `id` != '".$_REQUEST["id"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if (mysql_num_rows($result) > 0){
		header("Location: ../error_handler.php?eid=11");
		exit;
	}
	else{
		$query = "UPDATE `anyInventory_users` SET 
					`username`='".$_REQUEST["username"]."', ";
		
		if ($_REQUEST["password"] != ''){
			$query .= "	`password`='".md5($_REQUEST["password"])."', ";
		}
		
		$query .= " `usertype`='".$_REQUEST["usertype"]."',
					`categories_view`='".addslashes(serialize($_REQUEST["c_view"]))."',
					`categories_admin`='".addslashes(serialize($_REQUEST["c_admin"]))."'
					 WHERE `id`='".$_REQUEST["id"]."'";
		mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}
elseif($_REQUEST["action"] == "do_delete"){
	if ($_REQUEST["delete"] == "Delete"){
		$query = "DELETE FROM `anyInventory_users` WHERE `id`='".$_REQUEST["id"]."'";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}

header("Location: users.php");
exit;

?>
