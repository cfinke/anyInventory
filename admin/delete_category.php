<?php

include("globals.php");

$title = "anyInventory: Delete Category";

$category = new category($_REQUEST["id"]);

$output .= '
	<form method="post" action="category_processor.php">
		<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
		<input type="hidden" name="action" value="do_delete" />
		<table style="width: 100%;"><tr><td>Are you sure you want to delete this category?</td><td style="text-align: right;"><a href="../docs/deleting_categories.php">Help with deleting categories</a></td></tr></table>
		<div>
			<p class="category_name"><b>Name:</b> '.$category->breadcrumb_names.'</p>
			<p class="category_fields"><b>Fields:</b> ';

if(is_array($category->field_names)){
	foreach($category->field_names as $field){
		$output .= $field.', ';
	}
	$output = substr($output, 0, strlen($output) - 2);
}
else{
	$output .= 'None';
}

$output .= '</p><p><b>Number of items inventoried in this category:</b> '.$category->num_items().'</p>';

if ($category->num_items() > 0){
	$output .= '
		<p>
			<input type="radio" name="item_action" value="delete" /> Delete all items in this category<br />
		   	<input type="radio" name="item_action" value="move" /> Move all items in this category to <select name="move_items_to" id="move_items_to">'.get_category_options($category->parent_id).'</select>.
		</p>';
}

$output .= '<p><b>Number of subcategories:</b> '.count($category->children).'</p>';

if (count($category->children) > 0){
	$output .= '
		<p>
			<input type="radio" name="subcat_action" value="delete" /> Delete all sub-categories<br />
		   	<input type="radio" name="subcat_action" value="move" /> Move all sub-categories to <select name="move_subcats_to" id="move_subcats_to">'.get_category_options($category->parent_id).'</select>.
		</p>
		<p><b>Number of items inventoried in this category and its subcategories:</b> '.$category->num_items_r().'</p>';
}

$output .= '<p style="text-align: center;"><input type="submit" name="delete" value="Delete" /> <input type="submit" name="cancel" value="Cancel" /></p>
	</form>';

display($output);

?>