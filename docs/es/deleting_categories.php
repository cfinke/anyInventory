<?php

include("globals.php");

$title = "anyInventory: Ayuda > Categor&iacute;as > Eliminando Categor&iacute;as";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="categories.php">Categor&iacute;as</a> > Eliminando Categor&iacute;as';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Eliminando Categor&iacute;as</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Cuando decides eliminar una categor&iacute;a, tienes la opci&oacute;n de eliminar tambi&eacute;n sus sub-categor&iacute;as o moverlas a otra categor&iacute;a.  Por defecto est&aacute; seleccionada la opci&oacute;n de moverlas a la categor&iacute;a superior.  Tambi&eacute;n se te mostrar&aacute; el n&uacute;mero de elementos en la categor&iacute;a y sus respectivas sub-categor&iacute;as.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="editing_categories.php">&lt;&lt; Anterior: Editando Categor&iacute;as</a></div>
	<div style="text-align: right;"><a href="items.php">Siguiente: Art&iacute;culos &gt;&gt;</a></div>';

display($output);

?>