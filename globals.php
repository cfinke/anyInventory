<?php

error_reporting(E_ALL ^ E_NOTICE);

$db_host = '';
$db_name = '';
$db_user = '';
$db_pass = '';

include("functions.php");
include("category_class.php");
include("field_class.php");
include("item_class.php");
include("dataset_library.php");

connect_to_database();

?>