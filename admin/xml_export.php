<?php

include("globals.php");

$cr = "\n";

$output .= '<?xml version="1.0" ?>'.$cr.'<'.xmlize(APP_TITLE).'>'.$cr;

$query = "SELECT * FROM `anyInventory_fields` ORDER BY `importance` ASC";
$result = $db->query($query) or die($db->error() . '<br /><br />' . $query);

if ($result->numRows() > 0){
	$output .= '	<'.xmlize(FIELDS).'>'.$cr;
	
	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$field = new field($row["id"]);
		$output .= '		<'.xmlize(FIELD).' id="'.$field->id.'">'.$cr;
		
		if ($field->input_type != 'divider'){
			$output .= '			<'.xmlize(NAME).'>'.$field->name.'</'.xmlize(NAME).'>'.$cr;
			$output .= '			<'.xmlize(TYPE).'>'.$field->input_type.'</'.xmlize(TYPE).'>'.$cr;
			
			if (($field->input_type == 'select') || ($field->input_type == 'multiple') || ($field->input_type == 'checkbox') || ($field->input_type == 'radio')){
				if (is_array($field->values)){
					$output .= '			<'.xmlize(VALUES).'>'.$cr;
					
					foreach($field->values as $value){
						$output .= '				<'.xmlize(VALUE).'>'.$value.'</'.xmlize(VALUE).'>'.$cr;
					}
					
					$output .= '			</'.xmlize(VALUES).'>'.$cr;
				}
			}
			
			if (($field->input_type == 'select') || ($field->input_type == 'multiple') || ($field->input_type == 'text') || ($field->input_type == 'radio')){
				$output .= '			<'.xmlize(DEFAULT_VALUE).'>'.$field->default_value.'</'.xmlize(DEFAULT_VALUE).'>'.$cr;
			}
						
			if ($field->input_type == 'text'){
				$output .= '			<'.xmlize(_SIZE).'>'.$field->size.'</'.xmlize(_SIZE).'>'.$cr;
			}
			
			$output .= '				<'.XMLIZE(HIGHLIGHT).'>'.$field->highlight.'</'.xmlize(HIGHLIGHT).'>'.$cr;
		}
		else{
			$output .= '			<'.xmlize(TYPE).'>'.DIVIDER.'</'.xmlize(TYPE).'>'.$cr;
		}
		$output .= '			</'.xmlize(FIELD).'>'.$cr;
	}
	
	$output .= '	</'.xmlize(FIELDS).'>'.$cr;
}

$cat_ids = get_category_array();

if (is_array($cat_ids)){
	$output .= '		<'.xmlize(CATEGORIES).'>'.$cr;
	foreach($cat_ids as $cat){
		$category = new category($cat["id"]);
		
		$output .= '		<'.xmlize(CATEGORY).' id="'.$category->id.'" '.xmlize(NAME).'="'.$category->breadcrumb_names.'">'.$cr;
		
		$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`='".$category->id."' ORDER BY `name`";
		$result = $db->query($query) or die($db->error() . '<br /><br />' . $query);
		
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			$item = new item($row["id"]);
			$output .= '			<'.xmlize(ITEM).' id="'.$row["id"].'" '.xmlize(CATEGORY).'="'.htmlentities($item->name).'">'.$cr;
			if (is_array($category->field_ids)){
				foreach($category->field_ids as $field_id){
					$field = new field($field_id);
					
					if ($field->input_type != 'divider'){
						$output .= '				<'.str_replace(" ","_",$field->name).'>';
						
						if ($field->input_type == 'item'){
							$item_ids = unserialize($row[$field->name]);
							
							if (is_array($item_ids)){
								$output .= $cr;
								
								foreach($item_ids as $item_id){
									$item = new item($item_id);
									
									$output .= '					<'.xmlize(ITEM).' id="'.$item->id.'">'.$item->name.'</'.xmlize(ITEM).'>'.$cr;
								}
								
								$output .= '				';
							}
						}
						else{
							$output .= $row[$field->name];
						}
						
						$output .= '</'.str_replace(" ","_",$field->name).'>'.$cr;
					}
				}
			}
			
			$output .= '			</'.xmlize(ITEM).'>'.$cr;
		}
		
		$output .= '		</'.xmlize(CATEGORY).'>'.$cr;
	}
	
	$output .= '	</'.xmlize(CATEGORIES).'>'.$cr;
}

$output .= '</'.xmlize(APP_TITLE).'>';

header('Content-Type: text/xml');

if ($_GET["type"] == 'file'){
	header('Content-Disposition: attachment; filename="anyInventory_'.date("YmdHis").'.xml"');
	header('Pragma: no-cache');
}

echo $output;

function xmlize($string){
	return str_replace(",","",str_replace(" ","_",strtolower($string)));
}

?>   
