<?php



include("globals.php");



$title = "anyInventory: Aide > Champs > Organiser un Champ";

$breadcrumbs = '<a href="./">Aide</a> > <a href="fields.php">Champs</a> > Organiser un Champ';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Organiser un Champ</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Les Liens [monter] et [descendre] dans la <a href="'.$DIR_PREFIX.'admin/fields.php"> page Champs</a> vous permette de deplacer un champ vers le haut ou vers le bas dans la liste. Cette liste détermine dans quel ordre apparaise les champs quand vous ajoutez un article dans l\'inventaire.  cala n\'affecte que l\'affichage des champs sur l\'addition d\'un article ou sur son édition, rien d\'autre.</p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="deleting_fields.php">&lt;&lt; Précédent: Supprimer un Champ</a></div>

	<div style="text-align: right;"><a href="categories.php">Suivant: Catégories &gt;&gt;</a></div>';



display($output);



?>
