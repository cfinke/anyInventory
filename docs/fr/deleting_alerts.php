<?php



include("globals.php");



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



display($output);



?>
