<?php



include("globals.php");



$title = "anyInventory: Aide > Champs > Editer un Champ";

$breadcrumbs = '<a href="./">Aide</a> > <a href="fields.php">Champs</a> > Editer un Champ';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Editer un Champ</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Editer un champ est exactement la même chose que d\'ajouter un champ, seulement l\'information est déjà saisie dans le champ.</p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="adding_fields.php">&lt;&lt; Précédent: Ajouter un Champ</a></div>

	<div style="text-align: right;"><a href="deleting_fields.php">Suivant: Supprimer un Champ &gt;&gt;</a></div>';



display($output);



?>
