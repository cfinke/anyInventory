<?php

include("globals.php");

$title = "anyInventory: Ayuda > Campos > Editando Campos";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="fields.php">Campos</a> > Editando Campos';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Editando Campos</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Editar un campo funciona exactamente de la misma manera que agregar uno, excepto que la informaci&oacute;n ya est&aacute; capturada en la forma.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="adding_fields.php">&lt;&lt; Anterior: Agregando Campos</a></div>
	<div style="text-align: right;"><a href="deleting_fields.php">Siguiente: Eliminando Campos &gt;&gt;</a></div>';

display($output);

?>