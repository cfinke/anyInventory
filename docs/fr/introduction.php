<?php



include("globals.php");



$title = "anyInventory: Aide > Introduction";

$breadcrumbs = '<a href="./">Aide</a> > <a href="introduction.php">Introduction</a>';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Introduction</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>anyInventory a été créé pour remplir un vide dans le domaine personnel des systèmes d\'inventaire; tous les autres systèmes d\'inventaire étant conçus avec un certain type d\'inventaire à l\'esprit.  anyInventory est différent; il est conçu pour vous permettre de décider de quel type d\'article vous voulez référencer et quel type de données vous voulez maintenir.</p>

				<p>Par exemple, n\'importe quel autre système d\'inventaire que vous pourriez trouver vous indiquerait, "Avec ce produit, vous pouvez référencer vos logiciels. Pour chaque logiciel, vous pouvez sauver le nom, l\'éditeur, et la date de l\'achat; vous pouvez également télécharger une image si vous le souhaitez." Si vous vouliez enregister le numéro de série, vous pourriez essaiyer d\'ajouter ce champ dans le code source, ou vous pourriez juste le négocier.  Voici pourquoi anyInventory est différent:</p>

				<p>Ce logiciel vient avec <em>aucunes</em> notions préconçues de ce que vous voulez faire avec lui. Il est assez flexible pour géré la nourriture dans votre réfrigérateur en plus des dés de votre collection de plus de 1000 pièces. Il est suffisament simple pour être employé comme DVDthèque, et assez puissant pour gérer l\'inventaire de votre entreprise.</p>

				<p>La raison pour laquelle anyInventory peut être si le puissant et flexible est la manière dont vous, l\'utilisateur, saisissez les données.  Au lieu de commencer par entrer les articles dans l\'inventaire, vous commencez par définir quelles données vous voulez y mettre.  Pour une vision plus détaillé de ces données, vous pouvez jeter un oeil sur les <a href="fields.php">champs</a>.  Si vous choisissiez un mot de passe pour protéger votre installation, vous pouvez regarder la documentation sur les <a href="users.php">utilisateurs</a>.</p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="index.php">&lt;&lt; Précédent: Table des Matières</a></div>

	<div style="text-align: right;"><a href="users.php">Suivant: Utilisateurs &gt;&gt;</a></div>';



display($output);



?>
