<?php

include("globals.php");

$title = "anyInventory: Ayuda > Art&iacute;culos y adici&oacute;n de Art&iacute;culos";
$breadcrumbs = '<a href="./">Ayuda</a> > Art&iacute;culos y adici&oacute;n de Art&iacute;culos';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Art&iacute;culos</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>"Art&iacute;culo" es el t&eacute;rmino gen&eacute;rico para cualquier elemento almacenado en el inventario, ya sea una parte de computadora, un documento, un DVD, una foto - lo que sea.  Los art&iacute;culos en un inventario son los que lo hacen &uacute;til.  Los campos y las categor&iacute;as establecen la estructura; los art&iacute;culos la llenan.</p>
			</td>
		</tr>
		<tr class="tableHeader">
			<td><a name="adding">Adici&oacute;n de Art&iacute;culos</a></td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Para <a href="'.$DIR_PREFIX.'admin/add_item.php">agregar un art&iacute;culo</a>, primeramente debes seleccionar una <a href="categories.php">categor&iacute;a</a>.  Esto determina los <a href="fields.php">campos</a> que necesitar&aacute;s capturar.</p>
				<p>Ya que hallas seleccionado una categor&iacute;a, se te mostrar&aacute; una forma con los campos previamente definidos para esta categor&iacute;a.  No hay mucho mas que decir al respecto; debes ya saber como llenar estos campos, ya que t&uacute; los creaste.</p>
				<p>Si el archivo enviado para un campo de tipo archivo es una imagen, esta ser&aacute; mostrada como una pequeña vista previa al ver el art&iacute;culo en el invetario.  Si no es as&iacute;, ser&aacute; listada como un enlace al archivo, permitiendo descargarlo.
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="deleting_categories.php">&lt;&lt; Anterior: Eliminando Categor&iacute;as</a></div>
	<div style="text-align: right;"><a href="editing_items.php">Siguiente: Editando Art&iacute;culos &gt;&gt;</a></div>';

display($output);

?>