<?php

require_once("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Art&iacute;culos y adici&oacute;n de Art&iacute;culos";
		$breadcrumbs = '<a href="./">Ayuda</a> > Art&iacute;culos y adici&oacute;n de Art&iacute;culos';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Art&iacute;culos</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>"Art&iacute;culo" es el t&eacute;rmino gen&eacute;rico para cualquier elemento almacenado en el inventario, ya sea una parte de computadora, un documento, un DVD, una foto - lo que sea.  Los art&iacute;culos en un inventario son los que lo hacen &uacute;til.  Los campos y las categor&iacute;as establecen la estructura; los art&iacute;culos la llenan.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="adding">Adici&oacute;n de Art&iacute;culos</a></td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Para <a href="'.$DIR_PREFIX.'admin/add_item.php">agregar un art&iacute;culo</a>, primeramente debes seleccionar una <a href="categories.php">categor&iacute;a</a>.  Esto determina los <a href="fields.php">campos</a> que necesitar&aacute;s capturar.</p>
						<p>Ya que hallas seleccionado una categor&iacute;a, se te mostrar&aacute; una forma con los campos previamente definidos para esta categor&iacute;a.  No hay mucho mas que decir al respecto; debes ya saber como llenar estos campos, ya que t&uacute; los creaste.</p>
						<p>Si el archivo enviado para un campo de tipo archivo es una imagen, esta ser&aacute; mostrada como una pequeña vista previa al ver el art&iacute;culo en el invetario.  Si no es as&iacute;, ser&aacute; listada como un enlace al archivo, permitiendo descargarlo.
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="deleting_categories.php">&lt;&lt; Anterior: Eliminando Categor&iacute;as</a></div>
			<div style="text-align: right;"><a href="editing_items.php">Siguiente: Editando Art&iacute;culos &gt;&gt;</a></div>';
		break;
	case 'fr':
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
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Items and Adding Items";
		$breadcrumbs = '<a href="./">Help</a> > Items and Adding Items';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Items</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>"Item" is the generic term for anything you enter into your inventory, whether it be a computer part, a document, a DVD, a picture frame - whatever.  The items in an inventory are what make it important.  Fields and categories set the structure; items fill it in.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="adding">Adding Items</a></td>
				</tr>
				<tr>
					<td class="tableData">
						<p>To <a href="'.$DIR_PREFIX.'admin/add_item.php">add an item</a>, you must first choose a <a href="categories.php">category</a>.  This determines what <a href="fields.php">fields</a> you will need to fill in.</p>
						<p>After you have chosen a category, you will be presented with a form that consists of the fields that you have defined for this category.  There is not much more to say on this subject; you should know how to fill in the fields, because you created them.</p>
						<p>If the file you upload for a file-type field is an image, it will appear as a thumbnail (a small preview of the image) when you view the item in your inventory.  Otherwise, it will be listed as a link to the file, allowing it to be downloaded.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="deleting_categories.php">&lt;&lt; Previous: Deleting Categories</a></div>
			<div style="text-align: right;"><a href="editing_items.php">Next: Editing Items &gt;&gt;</a></div>';
		break;
}

display($output);

?>