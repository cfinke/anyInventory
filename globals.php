<?php

error_reporting(E_ALL ^ E_NOTICE);

$db_host = '';
$db_name = '';
$db_user = '';
$db_pass = '';

$images_dir = "";

$mime_to_ext = array("image/png"=>"png","image/jpg"=>"jpg","image/jpeg"=>"jpg","image/pjpg"=>"jpg","image/pjpeg"=>"jpg");

include("functions.php");
include("category_class.php");
include("field_class.php");
include("item_class.php");
include("dataset_library.php");

connect_to_database();

?>