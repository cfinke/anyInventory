<?php

error_reporting(E_ALL ^ E_NOTICE);

// This is a blank template.  If you are reading this, you should run
// the included install.php script to fill in the values, or you can
// fill them in by hand and upload the new file.

$db_host = '';
$db_name = '';
$db_user = '';
$db_pass = '';

$files_dir = "";

include("functions.php");
include("category_class.php");
include("field_class.php");
include("item_class.php");
include("file_class.php");
include("dataset_library.php");

connect_to_database();

?>