<?php



include("globals.php");



$title = "anyInventory: Aide > Recherche";

$breadcrumbs = '<a href="./">Aide</a> > Recherche';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Recherche</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Quand vous entrez des termes à rechercher dans la boîte en haut de n\'importe quelle page d\'anyInventory, la recherche est faite de la façon suivante:</p>

				<ol>

					<li>Si vous écrivez un nombre et aucun autre terme, anyInventory recherchera dans chaques champs <em>plus</em> le champ d\'auto-incrémentation unique pour ce nombre.</li>

					<li>Si vous écrivez un terme qui n\'est pas numérique, anyInventory recherchera dans chaques champs que vous avez défini <em>plus</em> dans le champ "Nom".</li>

					<li>Si vous écrivez plus d\'un terme, anyInventory recherchera un article qui a chacuns de ces termes de recherche contenu dans un ou plusieurs de ses champs.</li>

				</ol>

				<p>anyInventory renverra alors les résultats rangé par catégorie.  Les recherches booléennes ne sont pas actuellement supportées (ie. utiliser "AND" ou "OR" n\'affecte pas la recherche).</p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="labels.php">&lt;&lt; Précédent: Etiquettes</a></div>

	<div style="text-align: right;"><a href="whats_next.php">Suivant: Quelles futures évolutions? &gt;&gt;</a></div>';



display($output);



?>
