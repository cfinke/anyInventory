<?php

include("globals.php");

switch (LANG){
	case 'es':
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
		
		break;
	case 'fr':
		$title = "anyInventory: Aide > Alertes > Supprimer une Alerte";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="alerts.php">Alertes</a> > Supprimer une Alerte';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Supprimer une Alerte</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Supprimer une alerte n\'affecte aucun article, catégorie, ou champ.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="editing_alerts.php">&lt;&lt; Précédent: Editer une Alerte</a></div>
			<div style="text-align: right;"><a href="labels.php">Suivant: Etiquettes &gt;&gt;</a></div>';
		
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Alerts > Deleting Alerts";
		$breadcrumbs = '<a href="./">Help</a> > <a href="alerts.php">Alerts</a> > Deleting Alerts';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Deleting Alerts</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Deleting an alert simply removes the alert.  It does not affect any items, categories, or fields.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="editing_alerts.php">&lt;&lt; Previous: Editing Alerts</a></div>
			<div style="text-align: right;"><a href="labels.php">Next: Labels &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>