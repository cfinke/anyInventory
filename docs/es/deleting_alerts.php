<?php

include("globals.php");

$title = "anyInventory: Ayuda > Alertas > Eliminando Alertas";
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="alerts.php">Alertas</a> > Eliminando Alertas';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Eliminando Alertas</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Eliminar una alerta simplemente la remueve.  Esto no afecta ning&uacute;n art&iacute;culo, categor&iacute;a, o campo.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="editing_alerts.php">&lt;&lt; Anterior: Editando Alertas</a></div>
	<div style="text-align: right;"><a href="labels.php">Siguiente: Etiquetas &gt;&gt;</a></div>';

display($output);

?>