<?php

include("globals.php");

$file = new file_object($_REQUEST["id"]);
$file->output_thumbnail();

?>