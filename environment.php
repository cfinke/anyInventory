<?php

// Trim all of the global variables

if (is_array($_GET)) foreach($_GET as $key => $value) if (!is_array($_GET[$key])) $_GET[$key] = trim($value);

if (is_array($_POST)) foreach($_POST as $key => $value) if (!is_array($_POST[$key])) $_POST[$key] = trim($value);

$i = 0;

do {
	$found = require_once("DB.php");
	$i++;
} while ((!$found) && ($i < 10));

require_once($DIR_PREFIX."functions.php");

// $db_type comes from globals.php
if ($db_type == 'oci8'){
	$dsn = "oci8://$db_user:$db_pass@$db_name";
} else {
	$dsn = "$db_type://$db_user:$db_pass@$db_host/$db_name";
}

$db = connect_to_database();

$query = "SELECT * FROM " . $db->quoteIdentifier('anyInventory_config')."";
$result = $db->query($query);
if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);

while ($row = $result->fetchRow()) define($row["key"],$row["value"]);

require_once($DIR_PREFIX."lang/".LANG.".php");
require_once($DIR_PREFIX."category_class.php");
require_once($DIR_PREFIX."field_class.php");
require_once($DIR_PREFIX."item_class.php");
require_once($DIR_PREFIX."file_class.php");
require_once($DIR_PREFIX."alert_class.php");
require_once($DIR_PREFIX."user_class.php");

if (!stristr($_SERVER["PHP_SELF"], "/login") && !stristr($_SERVER["PHP_SELF"], "/docs")){
	if ((($DIR_PREFIX == './') && PP_VIEW && !isset($_SESSION["user"]["id"])) || 
		(($DIR_PREFIX == '.././') && PP_ADMIN && !isset($_SESSION["user"]["id"]))){
		$return_to = $_SERVER["PHP_SELF"]."?";
		
		foreach($_POST as $key => $value) $return_to .= $key . '=' . $value . '&';
		foreach($_GET as $key => $value) $return_to .= $key . '=' . $value . '&';
		
		header("Location: ".$DIR_PREFIX."login.php?return_to=".$return_to);
		exit;
	}
	
	if (PP_VIEW) $view_user = new user($_SESSION["user"]["id"]);
	else $view_user = new user(ADMIN_USER_ID);
	
	if (PP_ADMIN){
		$admin_user = new user($_SESSION["user"]["id"]);
		
		if (!isset($_SESSION["user"]["id"])){
			$admin_user->user_type = 'User';
			$admin_user->categories_admin = array();
		}
	}
	else{
		$admin_user = new user(ADMIN_USER_ID);
	}
}

?>
