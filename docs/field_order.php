<?php

require_once("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Campos > Orden de campos";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="fields.php">Campos</a> > Orden de campos';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Orden de campos</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Los enlaces [Arriba] y [Abajo] en la <a href="'.$DIR_PREFIX.'">p&aacute;gina de campos</a> te permiten mover un campo arriba y abajo en la lista. La cual determina el orden de aparici&oacute;n de los mismos cuando estamos agregando o editando un art&iacute;culo del inventario.  Esto solo afecta el orden en que los campos son desplegados en la p&aacute;gina, nada mas.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="deleting_fields.php">&lt;&lt; Anterior: Eliminando Campos</a></div>
			<div style="text-align: right;"><a href="categories.php">Siguiente: Categor&iacute;as &gt;&gt;</a></div>';
		break;
	case 'fr':
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
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Fields > Field Order";
		$breadcrumbs = '<a href="./">Help</a> > <a href="fields.php">Fields</a> > Field Order';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Field Order</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>The [up] and [down] links on the <a href="'.$DIR_PREFIX.'">field page</a> allow you to move a field up and down the list. This list determines in what order the fields appear when you are adding an item to the inventory.  It only affects the display of the fields on the item addition and editing page, nothing else.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="deleting_fields.php">&lt;&lt; Previous: Deleting Fields</a></div>
			<div style="text-align: right;"><a href="categories.php">Next: Categories &gt;&gt;</a></div>';
		break;
}

display($output);

?>