<?php



include("globals.php");



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



display($output);



?>
