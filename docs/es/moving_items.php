<?php

include("globals.php");

$title = "anyInventory: Ayuda > Art&iacute;culos > Moviendo Art&iacute;culos";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="items.php">Art&iacute;culos</a> > Moviendo Art&iacute;culos';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Moviendo Art&iacute;culos</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Al mover un art&iacute;culo, se perder&aacute; la informaci&oacute;n capturada para los campos que no sean parte de la categor&iacute;a destino.  Los campos que tenga la categor&iacute;a destino, que la categor&iacute;a anterior no tuviera, aparecer&aacute;n en blanco para estos art&iacute;culos.  Los dem&aacute;s campos no ser&aacute;n afectados.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="editing_items.php">&lt;&lt; Anterior: Editando Art&iacute;culos</a></div>
	<div style="text-align: right;"><a href="deleting_items.php">Siguiente: Eliminando Art&iacute;culos &gt;&gt;</a></div>';

display($output);

?>