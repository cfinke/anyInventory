<?php

include("globals.php");

$errors = array();

$errors[0] = "There is already a field with the name you specified.  If you wish to add a field to multiple categories, you can do so by editing the field and selecting several categories by holding down the Ctrl key.";

$output = '<h2>Error</h2>'.$errors[$_REQUEST["eid"]];

display($output);

?>