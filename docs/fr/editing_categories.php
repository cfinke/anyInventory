<?php



include("globals.php");



$title = "anyInventory: Aide > Catégories > Editer une Catégorie";

$breadcrumbs = '<a href="./">Aide</a> > <a href="categories.php">Catégories</a> > Editer une Catégorie';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Editer une Catégorie</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Editer une catégorie est identique à ajouter une catégorie, sauf ques les champs du formulaire sont déjà remplis. Vous pouvez déplacer une catégorie (et ses sous-catégories) en choisisant une nouvelle catégorie parente.</p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="categories.php#adding">&lt;&lt; Précédent: Ajouter une Catégorie</a></div>

	<div style="text-align: right;"><a href="deleting_categories.php">Suivant: Supprimer une Catégorie &gt;&gt;</a></div>';



display($output);



?>
