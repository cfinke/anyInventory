<?php

include("globals.php");

$title = "anyInventory: Ayuda";
$breadcrumbs = 'Ayuda';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Tabla de contenido</td>
		</tr>
		<tr>
			<td class="tableData">
			<p>Bienvenido a la secci&oacute;n de ayuda para anyInventory.  Puedes leer en orden a trav&eacute;s de ella, o utilizar esta tabla de contenido para encontrar lo que est&aacute;s buscando.</p>
			<ol style="margin-left: 5%;">
				<li><a href="introduction.php">Introducci&oacute;n</a></li>
				<li><a href="users.php">Usuarios</a></li>
				<ol>
					<li><a href="users.php#types">Tipos de usuarios</a></li>
					<li><a href="adding_users.php">Agregando Usuarios</a></li>
					<li><a href="editing_users.php">Editando Usuarios</a></li>
					<li><a href="deleting_users.php">Eliminando Usuarios</a></li>
				</ol>
				<li><a href="fields.php">Campos</a></li>
				<ol>
					<li><a href="fields.php#types">Tipos de campo</a></li>
					<li><a href="adding_fields.php">Agregando</a></li>
					<li><a href="editing_fields.php">Editando</a></li>
					<li><a href="deleting_fields.php">Eliminando</a></li>
					<li><a href="field_order.php">Orden de campos</a></li>
				</ol>
				<li><a href="categories.php">Categor&iacute;as</a></li>
				<ol>
					<li><a href="categories.php#adding">Agregando</a></li>
					<li><a href="editing_categories.php">Editando</a></li>
					<li><a href="deleting_categories.php">Eliminando</a></li>
				</ol>
				<li><a href="items.php">Art&iacute;culos</a></li>
				<ol>
					<li><a href="items.php#adding">Agregando</a></li>
					<li><a href="editing_items.php">Editando</a></li>
					<li><a href="moving_items.php">Moviendo</a></li>
					<li><a href="deleting_items.php">Eliminando</a></li>
				</ol>
				<li><a href="alerts.php">Alerts</a></li>
				<ol>
					<li><a href="alerts.php#adding">Agregando</a></li>
					<li><a href="editing_alerts.php">Editando</a></li>
					<li><a href="deleting_alerts.php">Eliminando</a></li>
				</ol>
				<li><a href="labels.php">Etiquetas</a></li>
				<li><a href="searching.php">Buscando</a></li>
				<li><a href="whats_next.php">¿Qu&eacute; sigue?</a></li>
			</ol>
		</td>
	</tr>
	</table>
	<div style="text-align: right;"><a href="introduction.php">Primero: La introducci&oacute;n &gt;&gt;</a></div>';

display($output);

?>