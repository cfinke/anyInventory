<?php

include("globals.php");

$title = "anyInventory: Ayuda > Usuarios > Agregando Usuarios";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="users.php">Usuarios</a> > Agregando Usuarios';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Agregando Usuarios</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Solo un administrador puede agregar usuarios.  Al agregar un usuario, el administrador puede definirlo como un usuario normal o como un administrador.  Si el usuario es especificado como un administrador, el o ella tendr&aacute;n permisos de consulta y administraci&oacute;n para todas las categor&iacute;as.  De otra manera, el administrador debe seleccionar las categor&iacute;as para las cuales tendra acceso el nuevo usuario.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="users.php#types">&lt;&lt; Anterior: Usuarios</a></div>
	<div style="text-align: right;"><a href="editing_users.php">Siguiente: Editando Usuarios &gt;&gt;</a></div>';

display($output);

?>