<?php

include("globals.php");

$title = "anyInventory: Ayuda > Items > Editando art&iacute;culos";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="items.php">Items</a> > Editando art&iacute;culos';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Editando art&iacute;culos</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Editar un art&iacute;culo es muy similar a agregar uno, con dos excepciones:</p>
				<ol>
					<li>No tienes la opci&oacute;n de cambiar la categor&iacute;a a la que pertenece el art&iacute;culo. Esto se encuentra restringido a la p&aacute;gina de <a href="moving_items.php">mover art&iacute;culos</a>.</li>
					<li>Puedes eliminar los archivos actualmente enviados para este art&iacute;culo.  Si el archivo es una imagen, una vista previa ser&aacute; mostrada, de otro modo, simplemente aparecer&aacute; como un enlace.</li>
				</ol>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="items.php#adding">&lt;&lt; Anterior: Agregando Art&iacute;culos</a></div>
	<div style="text-align: right;"><a href="moving_items.php">Siguiente: Moviendo Art&iacute;culos &gt;&gt;</a></div>';

display($output);

?>