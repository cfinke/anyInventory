<?php

session_start();

error_reporting(E_ALL ^ E_NOTICE);

// This is a blank template.  If you are reading this, you should run
// the included install.php script to fill in the values, or you can
// fill them in by hand and upload the new file.

$DIR_PREFIX .= "./";

//database connection setup
$db_host = '';
$db_name = '';
$db_user = '';
$db_pass = '';

<?php
require_once('DB.php');

// select one of these three values for $dbtype

// $dbtype = 'pgsql';
// $dbtype = 'oci8';
$dbtype = 'mysql';

// check for Oracle 8 - data source name syntax is different

if ($phptype != 'oci8'){
	$dsn = "$dbtype://$username:$password@$hostspec/$database";
} else {
	$net8name = 'www';
	$dsn = "$phptype://$username:$password@$net8name";
}

include($DIR_PREFIX."environment.php");

?>
