<?php

include("globals.php");

$title = "anyInventory: Ayuda > Usuarios";
$breadcrumbs = '<a href="./">Ayuda</a> > Usuarios';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Usuarios</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>anyInventory 1.8 tiene un sistema de control de usuarios mucho mas complejo que las versiones anteriores.  Este te permite hacer una instalaci&oacute;n protegida por contraseña, ya sea para todo el inventario o solo para la secci&oacute;n de administraci&oacute;n.  El sistema de usuarios en la versi&oacute;n 1.8 es mas complejo y eficiente que las versiones previas ya que es posible crear varios usuarios, con diferentes privilegios de consulta y administraci&oacute;n.</p>
			</td>
		</tr>
		<tr class="tableHeader">
			<td><a name="types">Tipos de usuario</a></td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Hay dos tipos de usuarios: normales y de administraci&oacute;n.  Los administradores tienen privilegios para agregar, editar y eliminar otros usuarios, campos, categor&iacute;as, art&iacute;culos y el texto de la p&aacute;gina principal. Tambi&eacute;n pueden deshabilitar la protecci&oacute;n de contraseña para el inventario e incluso para la secci&oacute;n de administraci&oacute;n.  Los usuarios normales solamente pueden editar campos, art&iacute;culos, y categor&iacute;as sobre las cuales hayan sido permitidos expl&iacute;citamente por alg&uacute;n administrador.</p>
				<p>La cuenta de administrador creada por la instalaci&oacute;n no puede ser eliminada.  Para evitar que por alg&uacute;n error te vieras imposibilitado para administrar el sistema al eliminar todas las cuentas de usuarios.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="introduction.php">&lt;&lt; Anterior: Introducci&oacute;n</a></div>
	<div style="text-align: right;"><a href="adding_users.php">Siguiente: Agregando Usuarios &gt;&gt;</a></div>';

display($output);

?>