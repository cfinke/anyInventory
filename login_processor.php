<?php

require_once("globals.php");

if ($_REQUEST["action"] == "log_in"){
	$query = "SELECT * FROM `anyInventory_users` WHERE `username` = ?";
	$query_data = array($_POST["username"]);
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	if ($result->numRows() == 0){
		header("Location: login.php?f=1&return_to=".$_POST["return_to"]);
		exit;
	}
	else{
		$row = $result->fetchRow();
		if (md5($_POST["password"]) == $row['password']){
			unset($_SESSION["user"]);
			
			$_SESSION["user"] = array();
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
