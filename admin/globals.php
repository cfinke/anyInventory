<?php

error_reporting(E_ALL ^ E_NOTICE);

$DIR_PREFIX .= "../";

require_once($DIR_PREFIX."globals.php");

if (!isset($_SESSION["ai_options"]["on_submit"])){
	$_SESSION["ai_options"]["on_submit"] = 'add_another';
}

?>