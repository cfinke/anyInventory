<?php

require_once("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Art&iacute;culos > Moviendo Art&iacute;culos";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="items.php">Art&iacute;culos</a> > Moviendo Art&iacute;culos';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Moviendo Art&iacute;culos</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Al mover un art&iacute;culo, se perder&aacute; la informaci&oacute;n capturada para los campos que no sean parte de la categor&iacute;a destino.  Los campos que tenga la categor&iacute;a destino, que la categor&iacute;a anterior no tuviera, aparecer&aacute;n en blanco para estos art&iacute;culos.  Los dem&aacute;s campos no ser&aacute;n afectados.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="editing_items.php">&lt;&lt; Anterior: Editando Art&iacute;culos</a></div>
			<div style="text-align: right;"><a href="deleting_items.php">Siguiente: Eliminando Art&iacute;culos &gt;&gt;</a></div>';
		break;
	case 'fr':
		$title = "anyInventory: Aide > Articles > Déplacer un Article";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="items.php">Articles</a> > Déplacer un Article';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Déplacer un Article</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Quand vous voulez déplacer un article, vous perdez les données que vous avez saisies pour les champs qui ne font pas partie de la catégorie dans laquelle il est déplacé.  Les champs que la catégorie de destination qui n\'existaient pas dans l\'ancienne catégorie sont laissé vide.  Toute autre information reste inchangée.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="editing_items.php">&lt;&lt; Précédent: Editer un Article</a></div>
			<div style="text-align: right;"><a href="deleting_items.php">Suivant: Supprimer un Article &gt;&gt;</a></div>';
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Items > Moving Items";
		$breadcrumbs = '<a href="./">Help</a> > <a href="items.php">Items</a> > Moving Items';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Moving Items</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>When you move an item, you lose the data you have entered for fields that are not part of the category to which it is moved.  The fields that the destination category contains that the old category does not will appear blank for the item.  All other information is unaffected.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="editing_items.php">&lt;&lt; Previous: Editing Items</a></div>
			<div style="text-align: right;"><a href="deleting_items.php">Next: Deleting Items &gt;&gt;</a></div>';
		break;
}

display($output);

?>