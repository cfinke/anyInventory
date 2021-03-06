<?php

require("globals.php");

if (!function_exists('imagecreate') ||
    !function_exists('imagecolorallocate') ||
	!function_exists('imagettftext') ||
	!function_exists('imagestring') ||
	!function_exists('imagecopyresized') ||
	!function_exists('imagedestroy') ||
	!function_exists('imagepng')){
	
	$output .= '<p>'.LABEL_ERROR.'</p>';
	
	display($output);
}

define('FPDF_FONTPATH','barcode/');

require_once("fpdf/fpdf.php");
require_once("label_templates.php");

// Set the template key
if(isset($GET["template"])) $tk = intval($_GET["template"]);
else $tk = intval($_REQUEST["template"]);

$page_width = $templates[$tk]["page_width"];
$page_height = $templates[$tk]["page_height"];

$left_margin = $templates[$tk]["left_margin"];
$right_margin = $left_margin;
$top_margin = $templates[$tk]["top_margin"];
$bottom_margin = $top_margin;

$num_cols = $templates[$tk]["num_cols"];
$num_rows = $templates[$tk]["num_rows"];

$label_width = $templates[$tk]["label_width"];
$label_height = $templates[$tk]["label_height"];

$num_labels = $num_cols * $num_rows;

$col_margin = ($page_width - ($num_cols * $label_width) - (2 * $left_margin)) / ($num_cols );
$row_margin = ($page_height - ($num_rows * $label_height) - (2 * $top_margin)) / ($num_rows );

$pdf = new FPDF("P","in",array($page_width, $page_height));
$pdf->AddPage();
$pdf->SetLeftMargin($left_margin);
$pdf->SetRightMargin($right_margin);
$pdf->SetTopMargin($top_margin);

$ypos = $top_margin;
$xpos = $left_margin;

$pdf->SetX($xpos);
$pdf->SetY($ypos);

if(isset($_GET["i"])){
	$item_id = $_GET["i"]; 
	do {
		$filename = "/tmp/" . rand() .'.png';
	} while (is_file($filename));
	
	$files[] = $filename;
	
	create_label($item_id,$_REQUEST["f"], $filename, ($label_width * 60));
}
else {
	foreach ($_REQUEST["i"] as $item_id){
		do {
			$filename = "/tmp/" . rand() .'.png';
		} while (is_file($filename));
		
		$files[] = $filename;
		create_label($item_id,$_REQUEST["f"], $filename, ($label_width * 60));
	}
}

for ($i = 0; $i < count($files); $i++){
	$info = getimagesize($files[$i]);
	
	$image_margin = ($label_width - ($info[0] / 72)) / 2;
	$newxpos = $xpos + $image_margin;
	
	$image_padding = ($label_height - ($info[1] / 72)) / 2;
	$newypos = $ypos + $image_padding;
	
	$pdf->Image($files[$i], $newxpos, $newypos);
	
	if (($i % $num_cols) != ($num_cols - 1)){
		$xpos += $label_width + $col_margin;
		$pdf->SetX($xpos);
	}
	else{
		if ((($i + 1) % $num_labels == 0) && ($i != (count($files) - 1))){
			$pdf->AddPage();
			$ypos = $top_margin;
			$xpos = $left_margin;
		}
		else{
			$ypos += $label_height + $row_margin;
			$xpos = $left_margin;
		}
		
		$pdf->SetY($ypos);
		$pdf->SetX($xpos);
	}
	
	@unlink($files[$i]);
}

$pdf->Output("label_sheets.pdf","I");

exit;

?>
