<?php

include("globals.php");

$title = "anyInventory: Help > Labels";
$breadcrumbs = '<a href="./">Help</a> > Labels';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Labels</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>anyInventory, as of version 1.5, allows you to create a barcode label from any field of an item.  For example, let\'s say that you had bought the DVD of the movie "Shrek," and you added it to your inventory, tracking the UPC, the ISBN, and the name.  You could produce a label from the UPC in one of two ways:</p>
				<ol>
					<li>On the item page for "Shrek," next to each field name is a link to a barcode label of that field\'s value.  To get the UPC label, you would just click on the "Label" link next to the UPC field.</li>
					<li>You could go to the <a href="'.$DIR_PREFIX.'labels.php">labels page</a> and follow the directions to produce a label for the UPC field of "Shrek."  This method produces a PDF of labels that can be printed on label sheets of varying sizes, as depicted in the template options.</li>
				</ol>
				<p>After you choose one of these two methods, you will be presented with a graphic that looks like this:</p>
				<p style="text-align: center;"><img src="'.$DIR_PREFIX.'images/sample_label.png" alt="Shrek UPC label" /></p>
				<p><i>Note: This feature only works if the necessary functions are installed.  <b>According to a self-test, the functions necessary for label production to work are ';

if (!function_exists('imagecreate') ||
    !function_exists('imagecolorallocate') ||
	!function_exists('imagettftext') ||
	!function_exists('imagestring') ||
	!function_exists('imagecopyresized') ||
	!function_exists('imagedestroy') ||
	!function_exists('imagepng')){
	
	$output .= ' not ';
}

$output .= ' installed.</b></i></p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="deleting_alerts.php">&lt;&lt; Previous: Deleting Alerts</a></div>
	<div style="text-align: right;"><a href="searching.php">Next: Searching &gt;&gt;</a></div>';

display($output);

?>