<?php



include("globals.php");



$title = "anyInventory: Aide > Catégories > Supprimer une Catégorie";

$breadcrumbs = '<a href="./">Aide</a> > <a href="categories.php">Catégories</a> > Supprimer une Catégorie';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Supprimer une Catégorie</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Quand vous choisissez de supprimer une catégorie, vous avez l\'option de supprimer toutes ses sous-catégories ou de les déplacer dans une autre catégorie.  Les champs seront transfèrés en déplacant les sous-catégories à la catégorie parente.  Vous serez également informé de combien d\'articles sont inventoriés dans la catégorie et ses sous-catégories.</p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="editing_categories.php">&lt;&lt; Précédent: Editer une Catégorie</a></div>

	<div style="text-align: right;"><a href="items.php">Suivant: Articles &gt;&gt;</a></div>';



display($output);



?>
