<?php



include("globals.php");



$title = "anyInventory: Aide > Articles > Editer un Article";

$breadcrumbs = '<a href="./">Aide</a> > <a href="items.php">Articles</a> > Editer un Article';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Editer un Article</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Editer un article est très similaire à en ajouter un à deux exceptions prés:</p>

				<ol>

					<li>Vous n\'avez pas la possibilté de changer la catégorie dans laquelle il se trouve. Cela est réservé à la page <a href="moving_items.php">déplacer un article</a>.</li>

					<li>Vous pouvez choisir de supprimer les fichiers de cet article.  Si le fichier est une image, une miniature sera visible, sinon  cela sera simplement un liens vers le fichier.</li>

				</ol>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="items.php#adding">&lt;&lt; Précédent: Ajouter un Article</a></div>

	<div style="text-align: right;"><a href="moving_items.php">Suivant: Déplacer un Article &gt;&gt;</a></div>';



display($output);



?>
