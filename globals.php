<?php

session_start();

error_reporting(E_ALL ^ E_NOTICE);

$DIR_PREFIX .= "./";

$db_host = "";
$db_name = "";
$db_user = "";
$db_pass = "";
$db_type = "";

require_once($DIR_PREFIX."environment.php");

?>