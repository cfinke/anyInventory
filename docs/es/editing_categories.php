<?php

include("globals.php");

$title = "anyInventory: Ayuda > Categor&iacute;as > Editando Categor&iacute;as";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="categories.php">Categor&iacute;as</a> > Editando Categor&iacute;as';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Editando Categor&iacute;as</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Editar una categor&iacute;a es id&eacute;ntico a agregar una, solamente que la informaci&oacute;n acerca de esta ya se encuentra capturada en la forma.  Es posible mover una sub-categor&iacute;a (y sus respectivas sub-categor&iacute;as) al seleccionar una nueva categor&iacute;a superior.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="categories.php#adding">&lt;&lt; Anterior: Agregando Categor&iacute;as</a></div>
	<div style="text-align: right;"><a href="deleting_categories.php">Siguiente: Eliminando Categor&iacute;as &gt;&gt;</a></div>';

display($output);

?>