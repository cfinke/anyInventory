<?php

include("globals.php");

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

display($output);

?>