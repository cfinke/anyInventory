<?php



include("globals.php");



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



display($output);



?>
