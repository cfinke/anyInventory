<?php

include("globals.php");

$title = "anyInventory: Ayuda > Introducci&oacute;n";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="introduction.php">Introducci&oacute;n</a>';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Introducci&oacute;n</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>anyInventory fue creado para cubrir la falta de sistemas personalizados de inventario; todos los otros sistemas de inventario han sido diseñados con una cierta clase de inventario en mente.  anyInventory es diferente; ha sido diseñado para permitirte a ti, el usuario, decidir que tipo de art&iacute;culos quieres manejar y que tipo de informaci&oacute;n quieres almacenar.</p>
				<p>Por ejemplo, cualquier otro sistema que pudieras haber probado te dir&iacute;a, "Con este sistema, puedes organizar y controlar los programas de tu computadora.  Para cada un de ellos, puedes guardar el nombre, fabricante, y la fecha de compra; tambi&eacute;n puedes, si as&iacute; lo deseas, subir una imagen." Pero, si tu quisieras tambi&eacute;n manejar el n&uacute;mero de serie, tendr&iacute;as que añadir ese campo en el c&oacute;digo fuente, o simplemente adaptarte.  Esta es la gran diferencia con anyInventory:</p>
				<p>Este sistema viene sin <em>ninguna</em> idea predefinida de lo que quieres hacer con &eacute;l.  Es tan flexible como para llevar el control de la comida en el refrigerador as&iacute; como tu colecci&oacute;n de mas de 1000 estampas.  Tan sencillo como para controlar tu colecci&oacute;n de pel&iacute;culas DVD, pero sufici&eacute;ntemente eficiente como para llevar el control del inventario de tu negocio.</p>
				<p>La raz&oacute;n por la que anyInventory puede ser tan flexible y eficiente es la manera en que t&uacute;, el usuario, captura la informaci&oacute;n.  En lugar de empezar capturando art&iacute;culos, empezamos definiendo que tipo de informaci&oacute;n queremos manejar.  Para una revisi&oacute;n mas detallada de esta informaci&oacute;n, contin&uacute;a leyendo acerda de los <a href="fields.php">campos</a>.  Si eligiste proteger con contraseña tu instalaci&oacute;n, desear&aacute; tambi&eacute;n leer sobre <a href="users.php">usuarios</a>.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="index.php">&lt;&lt; Anterior: Tabla de contenido</a></div>
	<div style="text-align: right;"><a href="users.php">Siguiente: Usuarios &gt;&gt;</a></div>';

display($output);

?>