<?php

error_reporting(E_ALL ^ E_NOTICE);

// This is a blank template.  If you are reading this, you should run
// the included install.php script to fill in the values, or you can
// fill them in by hand and upload the new file.

$DIR_PREFIX .= "./";

$db_host = '';
$db_name = '';
$db_user = '';
$db_pass = '';

$files_dir = "";

include($DIR_PREFIX."functions.php");
include($DIR_PREFIX."category_class.php");
include($DIR_PREFIX."field_class.php");
include($DIR_PREFIX."item_class.php");
include($DIR_PREFIX."file_class.php");

connect_to_database();

?>