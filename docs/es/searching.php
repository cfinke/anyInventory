<?php

include("globals.php");

$title = "anyInventory: Ayuda > Buscando";
$breadcrumbs = '<a href="./">Ayuda</a> > Buscando';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Buscando</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Cuando introduces un t&eacute;rmino en la forma localizada en la parte superior de cualquier p&aacute;gina de anyInventory, la b&uacute;squeda se efect&uacute;a de la siguiente manera:</p>
				<ol>
					<li>Si escribes solamente un n&uacute;mero, anyInventory buscar&aacute; en cada campo, <em>adem&aacute;s</em> del de autoincremento.</li>
					<li>Si introduces una t&eacute;rmino no num&eacute;rico, anyInventory buscar&aacute; en cada campo, <em>adem&aacute;s</em> del nombre.</li>
					<li>En caso de que introduzcas mas de un t&eacute;rmino, anyInventory buscar&aacute; los art&iacute;culos que contengas todos los t&eacute;rminos, en cualquiera de sus campos.</li>
				</ol>
				<p>anyInventory entonces mostrar&aacute; los resultado ordenados por categor&iacute;a.  Las b&uacute;squedas Booleanas no han sido implementadas a&uacute;n (ej. usar "AND" o "OR" no afectar&aacute; la b&uacute;squeda).</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="labels.php">&lt;&lt; Anterior: Etiquetas</a></div>
	<div style="text-align: right;"><a href="whats_next.php">Siguiente: ¿Qu&eacute; sigue? &gt;&gt;</a></div>';

display($output);

?>