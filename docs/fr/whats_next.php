<?php



include("globals.php");



$title = "anyInventory: Aide > Quelles futures évolutions?";

$breadcrumbs = '<a href="./">Aide</a> > Quelles futures évolutions?';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Quelles futures évolutions?</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Cette page détaille certains des fonctionnalitées qui seront ajoutés à anyInventory dans les futures versions.</p>

				<p><b>Un meilleur support du CSS:</b> L\'interface d\'anyInventory est actuellement récrite en utilisant le HTML strict et le CSS.  Ceci permettra aux utilisateurs d\'anyInventory d\'appliquer leurs propres thèmes plus facilement.</p>

				<p><b>Conditions d\'alertes multiple:</b>Ceci vous permettra de créer une alerte avec plus d\'une condition sur un article.</p>

				<p><b>Support de fichier XML:</b> Ce dispositif vous permettra d\'exporter et d\'importer l\'inventaire dans un fichier XML, pour des sauvegardes et des restaurations plus faciles.</p>

				<p><b>Recherche avançée améliorée:</b> La page de recherche sera améliorée pour tenir compte des critères recherche telles que devraient être égales, pas égale à, moins que, etc.</p>

				<p><b>Un soutien amélioré des fichiers:</b> Depuis la version 1.7, des images peuvent être ajoutées en tant que fichiers locaux si la bibliothèque libcurl est installée.  Cette fonctionalitée sans cette bibliothèque est prévu pour la version 1.8.</p>

				<p>Si vous avez des suggestions, descommentaires, ou des plaintes, contactez <a href="mailto:chris@efinke.com">chris@efinke.com</a>.</p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="searching.php">&lt;&lt; Précédent: Recherche</a></div>';



display($output);



?>
