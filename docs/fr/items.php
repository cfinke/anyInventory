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
				<p>"Article" est le terme g&eacute;n&eacute;rique pour tout ce que vous rentrez dans votre inventaire, que ce soit une pièce d\'ordinateur, un document, un DVD, un cadre de tableau - ce que vous voulez. Les articles dans un inventaire sont ce qui le rendent important.  Les champs et les cat&eacute;gories fixent la structure; les articles la remplissent.</p>
			</td>
		</tr>
		<tr class="tableHeader">
			<td><a name="adding">Ajouter un Article</a></td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Pour <a href="'.$DIR_PREFIX.'admin/add_item.php">ajouter un article</a>, vous devez choisir en premier une <a href="categories.php">cat&eacute;gorie</a>.  Cela d&eacute;terminera quels <a href="fields.php">champs</a> vous devrez remplir.</p>
				<p>Apr&eacute;s avoir choisi une cat&eacute;gorie, vous obtiendrez un formulaire qui comprend les champs que vous avez d&eacute;finis pour cette cat&eacute;gorie.  Il n\'y a rien de plus à dire sur ce sujet; vous devriez savoir compl&eacute;ter les champs, puisque vous les avez cr&eacute;es.</p>
				<p>Si vous t&eacute;l&eacute;chargez un fichier image, il apparaîtra en miniature (petit aperçu de l\'image) quand vous consulterez l\'article dans votre inventaire.  Sinon, il apparaîtra comme lien vers le fichier, que vous pourrez t&eacute;l&eacute;charger.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="deleting_categories.php">&lt;&lt; Pr&eacute;c&eacute;dent: Supprimer une Cat&eacute;gorie</a></div>
	<div style="text-align: right;"><a href="editing_items.php">Suivant: Editer un Article &gt;&gt;</a></div>';

display($output);

?>