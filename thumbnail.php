<?php

include("globals.php");

$file = new file_object($_GET["id"]);
$file->output_thumbnail();

?>