<?php

require_once("globals.php");

switch (LANG){
	case 'es':
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
		break;
	case 'fr':
		$title = "anyInventory: Aide > Alertes > Editer une Alerte";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="alerts.php">Alertes</a> > Editer une Alerte';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editer une Alerte</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editer une alerte est la même chose qu\'en ajouter une, sauf que les champs sont préremplis.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="alerts.php#adding">&lt;&lt; Précédent: Ajouter une Alerte</a></div>
			<div style="text-align: right;"><a href="deleting_alerts.php">Suivant: Supprimer une Alerte &gt;&gt;</a></div>';
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Alerts > Editing Alerts";
		$breadcrumbs = '<a href="./">Help</a> > <a href="alerts.php">Alerts</a> > Editing Alerts';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editing Alerts</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editing an alert is the same as adding an alert, except the form is already filled in.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="alerts.php#adding">&lt;&lt; Previous: Adding Alerts</a></div>
			<div style="text-align: right;"><a href="deleting_alerts.php">Next: Deleting Alerts &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>