<?php

include("globals.php");

$title = "anyInventory: Ayuda > Etiquetas";
$breadcrumbs = '<a href="./">Ayuda</a> > Etiquetas';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Etiquetas</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>anyInventory, a partir de la versi&oacute;n 1.5, te permite crear c&oacute;digos de barras para cualquier campo de cualquier art&iacute;culo.  Por ejemplo, digamos que compraste el DVD de la pel&iacute;cula "Shrek," y lo agregaste a tu inventario, guardando el UPC, ISBN, y el nombre.  Puedes producir una etiqueta del UPC de dos maneras:</p>
				<ol>
					<li>En la p&aacute;gina del art&iacute;culo "Shrek," a un lado del nombre de cada campo se encuentra un enlace a la etiqueta de ese campo.  Para generar la etiqueta del campo UPC, solo necesitar&iacute;as seleccionar el enlace "Etiqueta" junto al campo UPC.</li>
					<li>Tambi&eacute;n puedes ir a la <a href="'.$DIR_PREFIX.'labels.php">p&aacute;gina de etiquetas</a> y seguir las instrucciones para generar la etiqueta del campo UPC del art&iacute;culo "Shrek."  Este m&eacute;todo tambi&eacute;n de permite generar m&uacute;ltiples etiquetas.</li>
				</ol>
				<p>Despu&eacute;s de esto, se te mostrar&aacute; una imagen, similar a esta:</p>
				<p style="text-align: center;"><img src="'.$DIR_PREFIX.'images/sample_label.png" alt="Shrek, etiqueta del UPC" /></p>
				<p><i>Nota: Esta opci&oacute;n solamente funciona si las librer&iacute;as necesarias se encuentran instaladas.  <b>De acuerdo a una auto-prueba, estas funciones ';

if (!function_exists('imagecreate') ||
    !function_exists('imagecolorallocate') ||
	!function_exists('imagettftext') ||
	!function_exists('imagestring') ||
	!function_exists('imagecopyresized') ||
	!function_exists('imagedestroy') ||
	!function_exists('imagepng')){

	$output .= ' no ';
}

$output .= ' est&aacute;n instaladas.</b></i></p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="deleting_alerts.php">&lt;&lt; Anterior: Eliminando Alertas</a></div>
	<div style="text-align: right;"><a href="searching.php">Siguiente: Buscando &gt;&gt;</a></div>';

display($output);

?>