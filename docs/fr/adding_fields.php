<?php

include("globals.php");

$title = "anyInventory: Aide > Champs > Ajouter un Champ";
$inHead = '
	<script type="text/javascript">
	   _editor_url = "'.$DIR_PREFIX.'htmlarea/";
	   _editor_lang = "'.LANG.'";
	</script>
	<script type="text/javascript" src="'.$DIR_PREFIX.'htmlarea/htmlarea.js"></script>';
$inBodyTag = ' onload="HTMLArea.replaceAll();"';
$breadcrumbs = '<a href="./">Aide</a> > <a href="fields.php">Fields</a> > Ajouter un Champ';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Ajouter un Champ</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>
					Pour commencer à gérer vos reçus, vous devez ajouter les champs énumérés à la page précédente de sorte que vous puissiez entrer les données plus tard.
					Pour ceci, procédez a l\'<a href="'.$DIR_PREFIX.'admin/add_field.php">ajout de champ</a>. Là, vous verrez
					quelque chose qui ressemble à ceci:
				</p>
				<form method="post" action="#">
					<table>
						'.display_field_form().'
					</table>
				</form>
				<p>Commençons à ajouter nos champs, n\'est-ce pas?  D\'abord la date de l\'achat.</p>
				<p>"Mais attendez, ne devrions-nous pas entrer le nom de chaque article?" Ne vous inquiétez pas.  Vous ne devrez jamais créer un champ pour le nom d\'article; c\'est un des deux champs préintégrés dans anyInventory, l\'autre étant le champ d\'auto-incrementation.</p>
				<p>Si vous choisissez de cocher "Mettre ce champ en surbrillance", le champ et sa valeur serons affiché avec une couleur de fond dans la description de l\'article.  Ceci pourrait être utile pour mettre en valeur des champs spéciaux pour un article, tel que l\'UPC, le numéro de série, ou les codes produit.</p>
				<p>Retournons à la date d\'achat: d\'abord, nous entrons dans le champ Nom:</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Date D\'Achat','text').'
					</table>
				</form>
				<p>Là nous allons choisir quel type de champ nous voulons.  Puisque "texte" est déjà choisi ici, il n\'y a aucun besoin de changer le type de données.</p>
				<p>La "Valeur par défaut" définie ce qui est affiché par défaut dans un champ, quand vous ajoutez un article.  Par exemple, nous voulons nous rappeler dans quel format écrire la date, ainsi nous avons mis par DDMMYYYY:</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Date D\'Achat','text','','DDMMYYYY').'
					</table>
				</form>
				<p>Après nous avons la taille du champ.  Ceci limite le nombre de caractères qui peuvent être écrits dans le champ. Puisque nous savons déjà le format de notre date, nous pouvons mettre 10, puisque c\'est exactement la taile de notre format de date.</p>
				<p><em>Note: si la taille est de 256 ou davantage, vous obtiendrez une boîte texte à la place d\'une ligne texte pour saisir vos données.  La boîte texte, montré ci-dessous, rend simplement les données plus visible.</em></p>
				<form style="padding-left: 50px; margin: 10px;">
					<textarea rows="10" cols="60" style="width: 100%;">
						Ceci est une boîte texte.  Soyez libre de taper ce que vous voulez dedans.
					        Si vous avez un navigateur compatible, ceci devrait également être un éditeur WYSIWYG.
					</textarea>
				</form>
				<br />
				<form method="post" action="#">
					<table>
						'.display_field_form('','Date D\'Achat','text','','DDMMYYYY',8).'
					</table>
				</form>
				<p>Le dernier champ, "Appliquer à", permet d\'appliquer ce champ à un ensemble de catégories.  Nous n\'avons pas besoin de nous inquiéter à ce sujet, puisque nous n\'avons ajouté encore aucune catégorie. Si nous avions déjà ajouté quelques catégories, nous pourrions choisir les catégories nous voulons pour contenir ce champ. Ajouter des champs aux catégories est décrit plus loin dans <a href="categories.php#adding">ajouter une catégorie</a>.</p>
				<p>Ajouter le prix total et l\'article acheté se fera de la même manière, mais jetons un coup d\'oeil à un des autres champs pour voir comment en ajoutant des champs "énumérés" cela marche, "énuméré" signifiant que vous pouvez indiquer un ensemble de valeurs pour le champ.</p>
				<p>Ajoutons le champ "Lieu d\'Achat" maintenant, avec le type "multiple."  (Nous le choisisons multiple au lieu de le choisir en boîte de sélection afin de nous permettre de saisir un endroit qui n\'est pas dans la liste.)</p>
				<p>D\'abord, nous entrons dans le champ nom et choisissons le type de champ:</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Lieu d\'Achat','multiple').'
					</table>
				</form>
				<p>La prochaine chose que nous devons faire est de donner à ce champ quelques valeurs. Nous faisons ceci en entrant les magasins que nous voulons voir apparaître dans la liste, séparés par des virgules. Ainsi, nous mettons les cinq magasins où nous faisons des emplettes le plus souvent, et nous placerons par défaut le magasin où nous allons le plus.</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Lieu d\'Achat','multiple',array("Staples", "Bureau Max", "Bureau de Dépôt", "Radio Shack", "Sam Goody"),'Bureau Max').'
					</table>
				</form>
				<p>Puisque nous n\'avons ajouté aucune catégorie, nous pouvons ignorer le champ "Appliquer à :".<p>
				<p>Ce champ, dans une page d\'ajout d\'article, ressemblera à ceci:</p>
				<form style="padding-left: 50px; margin: 10px;">
					<input type="text" value="Bureau Max" id="store_we_shop_at"/>
					<select name="field_values">
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Staples\';">Staples</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Bureau Max\';">Bureau Max</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Bureau de Dépôt\';">Bureau de Dépôt</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Radio Shack\';">Radio Shack</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Sam Goody\';">Sam Goody</option>
					</select>
				</form>
				<p>Ajouter un radio bouton, une case à cocher, ou une boîte de sélection se fait de la même manière.</p>
				<p>Ajouter un champ de type \'fichier\' vous permet d\'importer un fichier pour ce champ au lieu de saisir ou de choisir une valeur.  Depuis la version 1.6, ceci a remplacé les champs intégrés "de téléchargement de fichiers" et "de fichiers distant".</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="fields.php#types">&lt;&lt; Précédent: Champs</a></div>
	<div style="text-align: right;"><a href="editing_fields.php">Suivant: Editer un Champ &gt;&gt;</a></div>';

display($output);

?>