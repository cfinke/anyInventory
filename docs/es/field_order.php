<?php

include("globals.php");

$title = "anyInventory: Ayuda > Campos > Orden de campos";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="fields.php">Campos</a> > Orden de campos';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Orden de campos</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Los enlaces [Arriba] y [Abajo] en la <a href="'.$DIR_PREFIX.'">p&aacute;gina de campos</a> te permiten mover un campo arriba y abajo en la lista. La cual determina el orden de aparici&oacute;n de los mismos cuando estamos agregando o editando un art&iacute;culo del inventario.  Esto solo afecta el orden en que los campos son desplegados en la p&aacute;gina, nada mas.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="deleting_fields.php">&lt;&lt; Anterior: Eliminando Campos</a></div>
	<div style="text-align: right;"><a href="categories.php">Siguiente: Categor&iacute;as &gt;&gt;</a></div>';

display($output);

?>