<?php

include("globals.php");

$title = "anyInventory: Ayuda > Art&iacute;culos > Eliminando Art&iacute;culos";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="items.php">Art&iacute;culos</a> > Eliminando Art&iacute;culos';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Eliminando Art&iacute;culos</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Al eliminar un art&iacute;culo, todos los archivos relacionados ser&aacute;n eliminados tambi&eacute;n.  Lo dem&aacute;s es bastante obvio.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="moving_items.php">&lt;&lt; Anterior: Moviendo Art&iacute;culos</a></div>
	<div style="text-align: right;"><a href="alerts.php">Siguiente: Alertas &gt;&gt;</a></div>';

display($output);

?>