<?php

require_once("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Categor&iacute;as y adici&oacute;n Categor&iacute;as";
		$breadcrumbs = '<a href="./">Ayuda</a> > Categor&iacute;as y adici&oacute;n Categor&iacute;as';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Categor&iacute;as</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>El sistema de categor&iacute;as funciona justo como la estructura de directorios de tu computadora.  Puedes crear un conjunto de categor&iacute;as principales o superiores (como "Electr&oacute;nicos" o "Deportes") y despu&eacute;s puedes crear sub-categor&iacute;as para cada categor&iacute;a ("Computadoras" y "Equipo de balonpi&eacute;," respectivamente).  Incluso puedes crear sub-categor&iacute;as para las sub-categor&iacute;as ("Discos duros" y "Balones") y de ah&iacute; para el Real.  Esto te facilita la organizaci&oacute;n del inventario de una manera sencilla y l&oacute;gica de entender.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="adding">Adici&oacute;n de Categor&iacute;as</a></td>
				</tr>
				<tr>
					<td class="tableData">
					<p><a href="'.$DIR_PREFIX.'admin/add_category.php">Agregar una categor&iacute;a</a> es bastante obvio.  Se te preguntar&aacute; el nombre que le quieres dar, y la categor&iacute;a superior.  La categor&iacute;a que est&eacute;s agregando ser&aacute; creada "debajo" de la categor&iacute;a superior, haci&eacute;ndola una "sub-categor&iacute;a" de esta.</p>
					<p>La primera categor&iacute;a que agregues debe ser "Principal," un tipo de categor&iacute;as especiales que no pueden ser eliminadas o editadas.  (Si borraras la categor&iacute;a superior estar&iacute;as eliminando todo tu inventario.)</p>
					<p>La &uacute;nica otra informaci&oacute;n que debes proporcionar es la de los <a href="fields.php">campos</a> que quieres que contenga.  Esto te permite adecuar la categor&iacute;a, para guardar &uacute;nicamente la informaci&oacute;n que es relevante para cada art&iacute;culo.</p>
					<p>Al escoger los campos, tienes la opci&oacute;n de hacer que "Herede los campos de la categor&iacute;a superior (adem&aacute;s de los campos seleccionados a continuaci&oacute;n)."  Esto simplemente te permite dar a la nueva categor&iacute;a los mismo campos que la categor&iacute;a superior, con la opci&oacute;n de seleccionar campos adicionales.  Por ejemplo, si creaste una categor&iacute;a principal "Libros" y le diste los campos: Autor, UPC, e ISBN, podr&iacute;as seleccionar la opci&oacute;n "Heredar..." al agregar todas las sub-categor&iacute;as para hacer que tengan los mismos campos, sin tener que seleccionar cada campo para cada sub-categor&iacute;a.</p>
					<p>Tambi&eacute;n tienes la opci&oacute;n de desplegar el campo de autoincremento.  Esto mostrar&aacute; el valor num&eacute;rico &uacute;nico en el inventario para cada art&iacute;culo, en la parte superior de la descripci&oacute;n y a la izquierda del enlace a su categor&iacute;a.  Esto puede ser activado o desactivado para cada categor&iacute;a.</p>
					<p>Una vez que has agregado la categor&iacute;a, esta aparecer&aacute; en la <a href="'.$DIR_PREFIX.'admin/categories.php">Lista de Categor&iacute;as</a>, y puedes comenzar <a href="items.php#adding">agregando art&iacute;culos</a> a esta.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="field_order.php">&lt;&lt; Anterior: Orden de campos</a></div>
			<div style="text-align: right;"><a href="editing_categories.php">Siguiente: Editando Categor&iacute;as &gt;&gt;</a></div>';
		
		break;
	case 'fr':
		$title = "anyInventory: Aide > Catégories et Ajouter une Catégorie";
		$breadcrumbs = '<a href="./">Aide</a> > Catégories et Ajouter une Catégorie';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Catégories</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Le système de catégorie fonctionne comme la structure des répertoire de votre ordinateur.  Vous pouvez créer un ensemble de catégories principales (comme "Electronique" ou "Marchandises Sportives") et créer des sous-catégories pour chacunes d\'elles ("Ordinateur" et "Equipement Baseball").  Vous pouvez créer des sous-catégories de sous-catégories ("Disques Dur" et "Gants de baseball Mitts") et ainsi de suite.  Cela vous permet d\'organiser votre inventaire pour qu\'il soit facilement compréhensible.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="adding">Ajouter une Catégorie</a></td>
				</tr>
				<tr>
					<td class="tableData">
					<p><a href="'.$DIR_PREFIX.'admin/add_category.php">Ajouter une catégorie</a> est trés rapide.  Vous serez invités à fournir un nom et une catégorie parente.  La catégorie que vous ajoutez sera placée "en-dessous" de la catégorie parente, elle sera donc un "enfant" de la parente.</p>
					<p>La première catégorie que vous ajoutez sera donc une enfant de la catégorie "Top", catégorie spéciale qui ne peut être supprimeée ou éditée.  (Si vous supprimiez la catégorie "Top", vous perdriez tout votre inventaire.)</p>
					<p>Les seul autres informations que vous devez compléter pour créer une catégorie sont les <a href="fields.php">champs</a>  que vous voulez qu\'elle contienne.  Ceci vous permet de travailler sur chaque catégorie, en sauvant seulement les données qui sont appropriées pour chaque article.</p>
					<p>En choisissant les champs, vous avez l\'option "Héritez des champs parent (en plus des champs vérifiés ci-dessous)."  Ceci permet simplement à la catégorie que vous ajoutez d\'avoir les mêmes champs que son parent, avec l\'option de choisir les champs additionnels.  Par exemple, Si vous crée une catégorie principale "Livres" et lui donnez les champs Auteurs, UPC, et ISBN, vous pouvez cocher "Héritez..." en ajoutant les nombreuses sous-catégories pour avoir toujours les mêmes champs sans les vérifier individuellemnt chaque fois.</p>
					<p>Vous avez également l\'option d\'afficher le champ d\'auto-incrémentation.  Ceci montrera l\'identification numérique unique de chaque article dans l\'inventaire en haut de sa page de description et à la gauche de son lien à chaque page de catégorie. Ceci peut être activé ou désactivé sur une catégorie par catégorie.</p>
					<p>Une fois que vous avez ajouté une catégorie, elle apparaîtra dans <a href="'.$DIR_PREFIX.'admin/categories.php">la liste des catégories</a>, et vous pourrez commencer à <a href="items.php#adding">ajouter des articles</a>.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="field_order.php">&lt;&lt; Précédent: Organiser un Champ</a></div>
			<div style="text-align: right;"><a href="editing_categories.php">Suivant: Editer une Catégorie &gt;&gt;</a></div>';
		
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Categories and Adding Categories";
		$breadcrumbs = '<a href="./">Help</a> > Categories and Adding Categories';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Categories</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>The category system works just like the directory structure on your computer.  You can create a set of top-level categories (such as "Electronics" or "Sporting Goods") and then you can create sub-categories for each category ("Computers" and "Baseball Equipment," respectively).  You can then create sub-categories under the sub-categories ("Hard Drives" and "Catchers\' Mitts") and so on and so forth.  This allows you to categorize your inventory in an easy to understand, logical structure.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="adding">Adding Categories</a></td>
				</tr>
				<tr>
					<td class="tableData">
					<p><a href="'.$DIR_PREFIX.'admin/add_category.php">Adding a category</a> is quite straight-forward.  You will be asked to supply a name and a parent category.  The category you are adding will be created "under" the parent category, making it a "child" of the parent.</p>
					<p>The first category you add must be a child of the "Top Level," a special category that cannot be deleted or edited.  (If you deleted the top level, you\'d be deleting your entire inventory.)</p>
					<p>The only other information you must fill in to create a category is what <a href="fields.php">fields</a> you want it to contain.  This allows you to tailor each category, saving only the data that is relevant for each item.</p>
					<p>When choosing the fields, you have the option of having the category "Inherit fields from parent (in addition to fields checked below)."  This simply gives the category you are adding the same fields as its parent, with the option of selecting additional fields.  For example, if you created a "Books" top-level category and gave it the fields Author, UPC, and ISBN, you could check the "Inherit..." box when adding the many subcategories to have them all use the same fields without individully checking them each time.</p>
					<p>You also have the option of displaying the auto-incrementing field.  This will display the unique numerical ID of each item in the inventory at the top of its description page and to the left of its link on each category page.  This can be activated and deactivated on a category by category basis.</p>
					<p>Once you have added a category, it will appear in the <a href="'.$DIR_PREFIX.'admin/categories.php">categories list</a>, and you can start <a href="items.php#adding">adding items</a> to it.</p> 
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="field_order.php">&lt;&lt; Previous: Field Order</a></div>
			<div style="text-align: right;"><a href="editing_categories.php">Next: Editing Categories &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>