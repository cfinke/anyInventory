<?php

include("globals.php");

$title = "anyInventory: Ayuda > Categor&iacute;as y adici&oacute;n Categor&iacute;as";
$breadcrumbs = '<a href="./">Ayuda</a> > Categor&iacute;as y adici&oacute;n Categor&iacute;as';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Categor&iacute;as</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>El sistema de categor&iacute;as funciona justo como la estructura de directorios de tu computadora.  Puedes crear un conjunto de categor&iacute;as principales o superiores (como "Electr&oacute;nicos" o "Deportes") y despu&eacute;s puedes crear sub-categor&iacute;as para cada categor&iacute;a ("Computadoras" y "Equipo de balonpi&eacute;," respectivamente).  Incluso puedes crear sub-categor&iacute;as para las sub-categor&iacute;as ("Discos duros" y "Balones") y de ah&iacute; para el Real.  Esto te facilita la organizaci&oacute;n del inventario de una manera sencilla y l&oacute;gica de entender.</p>
			</td>
		</tr>
		<tr class="tableHeader">
			<td><a name="adding">Adici&oacute;n de Categor&iacute;as</a></td>
		</tr>
		<tr>
			<td class="tableData">
			<p><a href="'.$DIR_PREFIX.'admin/add_category.php">Agregar una categor&iacute;a</a> es bastante obvio.  Se te preguntar&aacute; el nombre que le quieres dar, y la categor&iacute;a superior.  La categor&iacute;a que est&eacute;s agregando ser&aacute; creada "debajo" de la categor&iacute;a superior, haci&eacute;ndola una "sub-categor&iacute;a" de esta.</p>
			<p>La primera categor&iacute;a que agregues debe ser "Principal," un tipo de categor&iacute;as especiales que no pueden ser eliminadas o editadas.  (Si borraras la categor&iacute;a superior estar&iacute;as eliminando todo tu inventario.)</p>
			<p>La &uacute;nica otra informaci&oacute;n que debes proporcionar es la de los <a href="fields.php">campos</a> que quieres que contenga.  Esto te permite adecuar la categor&iacute;a, para guardar &uacute;nicamente la informaci&oacute;n que es relevante para cada art&iacute;culo.</p>
			<p>Al escoger los campos, tienes la opci&oacute;n de hacer que "Herede los campos de la categor&iacute;a superior (adem&aacute;s de los campos seleccionados a continuaci&oacute;n)."  Esto simplemente te permite dar a la nueva categor&iacute;a los mismo campos que la categor&iacute;a superior, con la opci&oacute;n de seleccionar campos adicionales.  Por ejemplo, si creaste una categor&iacute;a principal "Libros" y le diste los campos: Autor, UPC, e ISBN, podr&iacute;as seleccionar la opci&oacute;n "Heredar..." al agregar todas las sub-categor&iacute;as para hacer que tengan los mismos campos, sin tener que seleccionar cada campo para cada sub-categor&iacute;a.</p>
			<p>Tambi&eacute;n tienes la opci&oacute;n de desplegar el campo de autoincremento.  Esto mostrar&aacute; el valor num&eacute;rico &uacute;nico en el inventario para cada art&iacute;culo, en la parte superior de la descripci&oacute;n y a la izquierda del enlace a su categor&iacute;a.  Esto puede ser activado o desactivado para cada categor&iacute;a.</p>
			<p>Una vez que has agregado la categor&iacute;a, esta aparecer&aacute; en la <a href="'.$DIR_PREFIX.'admin/categories.php">Lista de Categor&iacute;as</a>, y puedes comenzar <a href="items.php#adding">agregando art&iacute;culos</a> a esta.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="field_order.php">&lt;&lt; Anterior: Orden de campos</a></div>
	<div style="text-align: right;"><a href="editing_categories.php">Siguiente: Editando Categor&iacute;as &gt;&gt;</a></div>';

display($output);

?>