<?php

include("globals.php");

if ($_REQUEST["action"] == "log_in"){
	$query = "SELECT * FROM `anyInventory_users` WHERE `username`='".$_POST["username"]."'";
	$result = $db->query($query) or die($db->error() . '<br /><br />' . $query);
	
	if ($result->numRows() == 0){
		header("Location: login.php?f=1&return_to=".$_POST["return_to"]);
		exit;
	}
	else{
		if (md5($_POST["password"]) == mysql_result($result, 0, 'password')){
			unset($_SESSION["user"]);
			
			$_SESSION["user"] = array();
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$_SESSION["user"]["id"] = $row['id'];
			$_SESSION["user"]["username"] = $row['username'];
			$_SESSION["user"]["usertype"] = $row['usertype'];
			
			if ($_POST["return_to"] == ''){
				$_POST["return_to"] = './admin/index.php';
			}
			
			header("Location: ".$_POST["return_to"]);
			exit;
		}
		else{
			header("Location: login.php?f=1&return_to=".$_POST["return_to"]);
			exit;
		}
	}
}
elseif($_REQUEST["action"] == "log_out"){
	session_unset();
	session_destroy();
	
	header("Location: index.php");
	exit;
}

?>
