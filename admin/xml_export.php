<?php

require_once("globals.php");

$cr = "\n";

$output .= '<?xml version="1.0" ?>'.$cr.'<anyinventory>'.$cr;

$query = "SELECT * FROM `anyInventory_fields` ORDER BY `importance` ASC";
$result = $db->query($query);
if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);

if ($result->numRows() > 0){
	$output .= '	<fields>'.$cr;
	
	while ($row = $result->fetchRow()){
		$field = new field($row["id"]);
		$output .= '		<field id="'.$field->id.'">'.$cr;
		
		if ($field->input_type != 'divider'){
			$output .= '			<name>'.$field->name.'</name>'.$cr;
			$output .= '			<type>'.$field->input_type.'</type>'.$cr;
			
			if (($field->input_type == 'select') || ($field->input_type == 'multiple') || ($field->input_type == 'checkbox') || ($field->input_type == 'radio')){
				if (is_array($field->field_values)){
					$output .= '			<field_values>'.$cr;
					
					foreach($field->field_values as $value){
						$output .= '				<value>'.$value.'</value>'.$cr;
					}
					
					$output .= '			</field_values>'.$cr;
				}
			}
			
			if (($field->input_type == 'select') || ($field->input_type == 'multiple') || ($field->input_type == 'text') || ($field->input_type == 'radio')){
				$output .= '			<default_value>'.$field->default_value.'</default_value>'.$cr;
			}
						
			if ($field->input_type == 'text'){
				$output .= '			<size>'.$field->size.'</size>'.$cr;
			}
			
			$output .= '				<highlight>'.$field->highlight.'</highlight>'.$cr;
		}
		else{
			$output .= '			<type>'.DIVIDER.'</type>'.$cr;
		}
		$output .= '			</field>'.$cr;
	}
	
	$output .= '	</fields>'.$cr;
}

$cat_ids = get_category_array();

if (is_array($cat_ids)){
	$output .= '		<categories>'.$cr;
	foreach($cat_ids as $cat){
		$category = new category($cat["id"]);
		
		$output .= '		<category id="'.$category->id.'" name="'.$category->breadcrumb_names.'">'.$cr;
		
		$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`='".$category->id."' ORDER BY `name`";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
		
		while ($row = $result->fetchRow()){
			$item = new item($row["id"]);
			$output .= '			<item id="'.$row["id"].'" category="'.htmlentities($item->name).'">'.$cr;
			
			if (is_array($category->field_ids)){
				foreach($category->field_ids as $field_id){
					$field = new field($field_id);
					
					if (($field->input_type != 'divider') && ($field->input_type != 'file')){
						$output .= '				<'.str_replace(" ","_",$field->name).'>';
						
						if ($field->input_type == 'item'){
							$item_ids = unserialize($item->fields[$field->name]);
							
							if (is_array($item_ids)){
								$output .= $cr;
								
								foreach($item_ids as $item_id){
									$item = new item($item_id);
									
									$output .= '					<item id="'.$item->id.'">'.$item->name.'</item>'.$cr;
								}
								
								$output .= '				';
							}
						}
						elseif (is_array($item->fields[$field->name])){
							$output .= implode(", ",$item->fields[$field->name]);
						}
						else{
							$output .= $item->fields[$field->name];
						}
						
						$output .= '</'.str_replace(" ","_",$field->name).'>'.$cr;
					}
				}
			}
			
			$output .= '			</item>'.$cr;
		}
		
		$output .= '		</category>'.$cr;
	}
	
	$output .= '	</categories>'.$cr;
}

$output .= '</anyinventory>';

header('Content-Type: text/xml');

if ($_GET["type"] == 'file'){
	header('Content-Disposition: attachment; filename="anyInventory_'.date("YmdHis").'.xml"');
	header('Pragma: no-cache');
}

echo $output;

?>   
