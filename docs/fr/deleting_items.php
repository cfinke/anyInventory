<?php



include("globals.php");



$title = "anyInventory: Aide > Articles > Supprimer un Article";

$breadcrumbs = '<a href="./">Aide</a> > <a href="items.php">Articles</a> > Supprimer un Article';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Supprimer un Article</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Quand vous supprimez un artilce, tous les fichiers qui lui sont relatifs sont supprimés.  Le reste est assez explicite.</p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="moving_items.php">&lt;&lt; Précédent: Déplacer un Article</a></div>

	<div style="text-align: right;"><a href="alerts.php">Suivant: Alertes &gt;&gt;</a></div>';



display($output);



?>
