<?php

include("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Campos > Eliminando Campos";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="fields.php">Campos</a> > Eliminando Campos';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Eliminando Campos</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Cuando eliminas un campo, tambi&eacute;n est&aacute;s eliminando toda la informaci&oacute;n capturada para este campo en todos los art&iacute;culos en los que lo hayas utilizado, as&iacute; que debes ser muy cuidadoso al hacer esto.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="editing_fields.php">&lt;&lt; Anterior: Editando Campos</a></div>
			<div style="text-align: right;"><a href="field_order.php">Siguiente: Orden de campos &gt;&gt;</a></div>';
		
		break;
	case 'fr':
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Fields > Deleting Fields";
		$breadcrumbs = '<a href="./">Help</a> > <a href="fields.php">Fields</a> > Deleting Fields';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Deleting Fields</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>When you delete a field, you\'re also deleting all of the data you\'ve entered in for that field for any items that you\'ve added, so be careful when you delete.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="editing_fields.php">&lt;&lt; Previous: Editing Fields</a></div>
			<div style="text-align: right;"><a href="field_order.php">Next: Field Order &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>