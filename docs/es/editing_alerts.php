<?php

include("globals.php");

$title = "anyInventory: Ayuda > Alertas > Editando Alertas";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="alerts.php">Alertas</a> > Editando Alertas';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Editando Alertas</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Editar una alerta es exactamente igual a agregar una, con la excepci&oacute;n de que los valores ya se encuentran capturados en la forma.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="alerts.php#adding">&lt;&lt; Anterior: Agregando Alertas</a></div>
	<div style="text-align: right;"><a href="deleting_alerts.php">Siguiente: Eliminando Alertas &gt;&gt;</a></div>';

display($output);

?>