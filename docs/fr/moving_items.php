<?php



include("globals.php");



$title = "anyInventory: Aide > Articles > Déplacer un Article";

$breadcrumbs = '<a href="./">Aide</a> > <a href="items.php">Articles</a> > Déplacer un Article';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Déplacer un Article</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Quand vous voulez déplacer un article, vous perdez les données que vous avez saisies pour les champs qui ne font pas partie de la catégorie dans laquelle il est déplacé.  Les champs que la catégorie de destination qui n\'existaient pas dans l\'ancienne catégorie sont laissé vide.  Toute autre information reste inchangée.</p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="editing_items.php">&lt;&lt; Précédent: Editer un Article</a></div>

	<div style="text-align: right;"><a href="deleting_items.php">Suivant: Supprimer un Article &gt;&gt;</a></div>';



display($output);



?>
