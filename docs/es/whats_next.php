<?php

include("globals.php");

$title = "anyInventory: Ayuda > What's Next?";
$breadcrumbs = '<a href="./">Ayuda</a> > ¿Qu&eacute; sigue?';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>¿Qu&eacute; sigue?</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Esta p&aacute;gina nos da una idea de funcionalidades que ser&aacute;n añadidad en futuras revisiones.</p>
				<p><b>Fuerte soporte CSS:</b> La presentaci&oacute;n de anyInventory est&aacute; siendo re-escrita usando HTML y dejando recaer la presentaci&oacute;n en CSS.  Eso har&aacute; mas sencillo para los usuarios de anyInventory aplicar sus propios temas y diseños.</p>
				<p><b>Alertas de condici&oacute;n m&uacute;ltiple:</b> Que nos permitir&aacute;n especificar alertas con mas de una condici&oacute;n para cualquier art&iacute;culo.</p>
				<p><b>Soporte a archivos XML:</b> Esta funcionalidad permitir&aacute; descargar y enviar el inventario como un archivo XML, para hacer mas sencillos los respaldos y recuperaciones.</p>
				<p><b>B&uacute;squeda avanzada mejorada:</b> La p&aacute;gina de b&uacute;squeda ser&aacute; mejorada, para permitir especificar condiciones tales como si los resultados puedan ser mayores que, iguales a, menores que, etc.</p>
				<p><b>Mejor soporte a archivos remotos:</b> A partir de la versi&oacute; 1.7, es posible enviar im&aacute;genes solamente si la librer&iacute;a libcurl est&aacute; instalada.  Esto se espera sea implementado a partir de la versi&oacute;n 1.8.</p>
				<p><b>Hojas de etiquetas:</b> Nos permitir&aacute;n crear etiquetas de tamaño estandar para los art&iacute;culos del inventario.</p>
				<p>Si tienes alguna sugerencia, comentario o queja, contacta a <a href="mailto:chris@efinke.com">chris@efinke.com</a>.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="searching.php">&lt;&lt; Anterior: Buscando</a></div>';

display($output);

?>