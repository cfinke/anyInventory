<?php

include("globals.php");

$title = "anyInventory: Ayuda > Usuarios > Eliminando Usuarios";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="users.php">Usuarios</a> > Eliminando Usuarios';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Eliminando Usuarios</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>No es posible eliminar al administrador creado durante la instalaci&oacute;n, y no puedes eliminar tu propia cuenta.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="editing_users.php">&lt;&lt; Anterior: Editando Usuarios</a></div>
	<div style="text-align: right;"><a href="fields.php">Siguiente: Campos &gt;&gt;</a></div>';

display($output);

?>