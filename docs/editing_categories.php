<?php

require_once("globals.php");

switch (LANG) {
	case 'es':
		$title = "anyInventory: Ayuda > Categor&iacute;as > Editando Categor&iacute;as";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="categories.php">Categor&iacute;as</a> > Editando Categor&iacute;as';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editando Categor&iacute;as</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editar una categor&iacute;a es id&eacute;ntico a agregar una, solamente que la informaci&oacute;n acerca de esta ya se encuentra capturada en la forma.  Es posible mover una sub-categor&iacute;a (y sus respectivas sub-categor&iacute;as) al seleccionar una nueva categor&iacute;a superior.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="categories.php#adding">&lt;&lt; Anterior: Agregando Categor&iacute;as</a></div>
			<div style="text-align: right;"><a href="deleting_categories.php">Siguiente: Eliminando Categor&iacute;as &gt;&gt;</a></div>';
		break;
	case 'fr':
		$title = "anyInventory: Aide > Catégories > Editer une Catégorie";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="categories.php">Catégories</a> > Editer une Catégorie';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editer une Catégorie</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editer une catégorie est identique à ajouter une catégorie, sauf ques les champs du formulaire sont déjà remplis. Vous pouvez déplacer une catégorie (et ses sous-catégories) en choisisant une nouvelle catégorie parente.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="categories.php#adding">&lt;&lt; Précédent: Ajouter une Catégorie</a></div>
			<div style="text-align: right;"><a href="deleting_categories.php">Suivant: Supprimer une Catégorie &gt;&gt;</a></div>';
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Categories > Editing Categories";
		$breadcrumbs = '<a href="./">Help</a> > <a href="categories.php">Categories</a> > Editing Categories';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editing Categories</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editing a category is identical to adding a category, but the information about the category is already filled into the form.  You can move the category (and its subcategories) by choosing a new parent category.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="categories.php#adding">&lt;&lt; Previous: Adding Categories</a></div>
			<div style="text-align: right;"><a href="deleting_categories.php">Next: Deleting Categories &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>