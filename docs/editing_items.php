<?php

include("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Items > Editando art&iacute;culos";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="items.php">Items</a> > Editando art&iacute;culos';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editando art&iacute;culos</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editar un art&iacute;culo es muy similar a agregar uno, con dos excepciones:</p>
						<ol>
							<li>No tienes la opci&oacute;n de cambiar la categor&iacute;a a la que pertenece el art&iacute;culo. Esto se encuentra restringido a la p&aacute;gina de <a href="moving_items.php">mover art&iacute;culos</a>.</li>
							<li>Puedes eliminar los archivos actualmente enviados para este art&iacute;culo.  Si el archivo es una imagen, una vista previa ser&aacute; mostrada, de otro modo, simplemente aparecer&aacute; como un enlace.</li>
						</ol>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="items.php#adding">&lt;&lt; Anterior: Agregando Art&iacute;culos</a></div>
			<div style="text-align: right;"><a href="moving_items.php">Siguiente: Moviendo Art&iacute;culos &gt;&gt;</a></div>';
		break;
	case 'fr':
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
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Items > Editing Items";
		$breadcrumbs = '<a href="./">Help</a> > <a href="items.php">Items</a> > Editing Items';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editing Items</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editing an item is very similar to adding an item, with two exceptions:</p>
						<ol>
							<li>You do not have the option of changing what category in which the item is found. This is restricted to the <a href="moving_items.php">moving items</a> page.</li>
							<li>You can choose to delete currently uploaded files for this item.  If the file is an image, a thumbnail will be shown, otherwise it will simply list the link to the file.</li>
						</ol>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="items.php#adding">&lt;&lt; Previous: Adding Items</a></div>
			<div style="text-align: right;"><a href="moving_items.php">Next: Moving Items &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>