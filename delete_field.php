<?php

include("globals.php");

$field = new field($_REQUEST["id"]);

$output .= '
	<form method="post" action="field_processor.php">
		<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
		<input type="hidden" name="action" value="do_delete" />
		<p>Are you sure you want to delete this field?</p>
		<div>
			<p><b>Field:</b> '.$field->name.'</p>
			<p><b>Input type:</b> '.$field->input_type.'</p>';

if ($field->input_type != "text"){
	$output .= '<p><b>Values:</b> ';
	
	if(is_array($field->values)){
		foreach($field->values as $value){
			$output .= $value.', ';
		}
		$output = substr($output, 0, strlen($output) - 2);
	}
	else{
		$output .= 'None';
	}
}

if (($field->input_type == "text") || ($field->input_type == "multiple")){
	$output .= '<p><b>Size:</b> '.$field->size.'</p>';
}

$output .= '
		<p><b>Default value:</b> '.$field->default_value.'</p>
		<p><b>This field is used in '.count($field->categories).' categories.</b></p>
		<p style="text-align: center;"><input type="submit" name="delete" value="Delete" /> <input type="submit" name="cancel" value="Cancel" /></p>
	</form>';

display($output);

?>