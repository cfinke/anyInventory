<?php

include("globals.php");

$title = "anyInventory: Ayuda > Alertas y adici&oacute;n de Alertas";
$inHead = '
	<script type="text/javascript">
		<!--
			function toggle(num){
				document.getElementById(\'field\' + num).disabled = document.getElementById(\'timed\' + num).checked;
				document.getElementById(\'condition\' + num).disabled = document.getElementById(\'timed\' + num).checked;
				document.getElementById(\'value\' + num).disabled = document.getElementById(\'timed\' + num).checked;
			}
		// -->
	</script>';
$breadcrumbs = '<a href="./">Ayuda</a> > Alertas y adici&oacute;n de Alertas';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Alertas</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Las alertas te permiten hacer que anyInventory te avise cuando ciertas condiciones se cumplan. Por ejemplo, digamos que est&aacute;s llevando el control de los consumibles en la oficina, y necesitas saber cuando solo quede un cartucho de impresora.  Las alertas en anyInventory te permiten especificar esto.</p>
				<p><a name="time_based">T&uacute;</a> tambi&eacute;n puedes crear alertas basadas en tiempo.  Por ejemplo, si necesitas comprar tinta cada mes, crear&iacute;as una alerta mensual, sin ninguna otra condici&oacute;n.</p>
			</td>
		</tr>
		<tr class="tableHeader">
			<td><a name="adding">Agregando alertas</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Para <a href="'.$DIR_PREFIX.'admin/add_alert.php">agregar una alerta</a>, primero debes seleccionar la categor&iacute;a a la cual pertenece(n) los art&iacute;culo(s).  Observa que solamente las categor&iacute;as que contengan uno o mas art&iacute;culos aparecer&aacute;n listadas.</p>
				<p>Ya que seleccionaste la categor&iacute;a, puedes comenzar a especificar las condiciones de la alerta.  Aqu&iacute; te mostramos como se podr&iacute;a ver una forma de estas:</p>
				<form>
					<table>
						'.display_alert_form("doc").'
					</table>
				</form>
				<p>Iniciamos especificando el t&iacute;tulo.  Esto es lo que ver&aacute;s cuando la alerta sea activada. En este ejemplo, un t&iacute;tulo adecuado podr&iacute;a ser "Quedan pocos."</p>
				<p>Despu&eacute;s de esto, selecciona los art&iacute;culos a los cuales quieres aplicar la alerta. (Puedes seleccionar varios art&iacute;culos a la vez, presionando la tecla Ctrl mientras seleccionas las entradas, de manera que si quieres saber cuando tengas uno o menos cartuchos o toners, puedas seleccionar ambos art&iacute;culos.)</p>
				<form>
					<table>
						'.display_alert_form("doc","Quedan pocos",1).'
					</table>
				</form>
				<p>A continuaci&oacute;n, selecciona el campo, valor y condici&oacute;n que activar&aacute;n la alerta.  En este caso, queremos saber cuando el campo Cantidad sea menor o igual a uno.</p>
				<form>
					<table>
						'.display_alert_form("doc", "Quedan pocos", 1, false, 2, "<=", 1).'
					</table>
				</form>
				<p>Ahora, puedes seleccionar la fecha a partir de la cual quieres que esta alerta est&eacute; activa. Generalmente, dejaremos la fecha actual, la cual debe aparecer por defecto.</p>
				<p>Tambi&eacute;n es posible seleccionar una fecha de expiraci&oacute;n, despu&eacute;s de la cual la alerta estar&aacute; inactiva, sin importar si las condiciones previas se cumplen o no.</p>
				<p>Una vez añadida la alerta, esta ser&aacute; mostrada en la p&aacute;gina principal, as&iacute; como en la de el art&iacute;culo a la cual est&aacute; siendo aplicada si esta se activa.  En este caso, se ver&iacute;a as&iacute;:</p>
				<table class="alertBox" cellspacing="0" cellpadding="2" border="0">
					<tr class="alertTitle">
						<td>
							Alerta
						</td>
						<td style="text-align: right;">
							<a href="alerts.php">?</a>
						</td>
					</tr>
					<tr class="alertContent">
						<td>
							<b>Quedan pocos </b><br><a href="">Cartuchos de impresora</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="deleting_items.php">&lt;&lt; Anterior: Eliminando art&iacute;culos</a></div>
	<div style="text-align: right;"><a href="editing_alerts.php">Siguiente: Editando Alertas &gt;&gt;</a></div>';

display($output);

?>