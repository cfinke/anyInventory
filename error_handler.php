<?php

include("globals.php");

$errors = array();

$errors[0] = "There is already a field with the name you specified.  If you wish to add a field to multiple categories, you can do so by editing the field and selecting several categories by holding down the Ctrl key.";
$errors[1] = "The default value for a select or radio field must be included in the list of values.";
$errors[2] = "There must be items in a category for you to add an alert in it.";
$errors[3] = "There were no common fields in the categories you selected.";

$output = '<h2>Error</h2>'.$errors[$_REQUEST["eid"]];

display($output);

?>