<?php

include("globals.php");

$title = "anyInventory: Ayuda > Usuarios > Editando Usuarios";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="users.php">Usuarios</a> > Editando Usuarios';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Editando Usuarios</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Editar un usuario es muy similar a agregar uno, solo que la informaci&oacute;n ya est&aacute; capturada.  Editar un usuario es diferente a agregar uno en las siguientes situaciones:</p>
				<ul>
					<li>Cuando editas al administrador agregado por la instalaci&oacute;n, solo puedes cambiar el nombre de usuario y contraseña.</li>
					<li>Al editar tu propia cuenta, solo puedes cambiar la contraseña.</li>
				</ul>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="adding_users.php">&lt;&lt; Anteior: Agregando Usuarios</a></div>
	<div style="text-align: right;"><a href="deleting_users.php">Siguiente: Eliminando Usuarios &gt;&gt;</a></div>';

display($output);

?>