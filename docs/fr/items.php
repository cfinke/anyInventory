<?php



include("globals.php");



$title = "anyInventory: Aide > Articles et Ajouter un Article";

$breadcrumbs = '<a href="./">Aide</a> > Articles et Ajouter un Article';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Articles</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>"Article" est le terme générique pour tout ce que vous rentrez dans votre inventaire, que ce soit une pièce d\'ordinateur, un document, un DVD, un cadre de tableau - ce que vous voulez. Les articles dans un inventaire sont ce qui le rendent important.  Les champs et les catégories fixent la structure; les articles la remplissent.</p>

			</td>

		</tr>

		<tr class="tableHeader">

			<td><a name="adding">Ajouter un Article</a></td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Pour ajouter un article, vous devez choisir en premier une <a href="categories.php">catégorie</a>.  Cela déterminera quels <a href="fields.php">champs</a> vous devrez remplir.</p>

				<p>Aprés avoir choisi une catégorie, vous obtiendrez un formulaire qui comprend les champs que vous avez définis pour cette catégorie.  Il n\'y a rien de plus à dire sur ce sujet; vous devriez savoir compléter les champs, puisque vous les avez crées.</p>

				<p>Si vous téléchargez un fichier image, il apparaîtra en miniature (petit aperçu de l\'image) quand vous consulterez l\'article dans votre inventaire.  Sinon, il apparaîtra comme lien vers le fichier, que vous pourrez téléchargé.</p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="deleting_categories.php">&lt;&lt; Précédent: Supprimer une Catégorie</a></div>

	<div style="text-align: right;"><a href="editing_items.php">Suivant: Editer un Article &gt;&gt;</a></div>';



display($output);



?>
