<?php



include("globals.php");



$title = "anyInventory: Aide > Etiquettes";

$breadcrumbs = '<a href="./">Aide</a> > Etiquettes';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Etiquettes</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>anyInventory, depuis la version 1.5, vous permet de créer une étiquette avec un code barre de n\'importe quel champ d\'un article.  Par exemple, disons que vous avez acheté le DVD du film "Animal House" et que vous l\'avez ajouté à votre inventaire, avec l\'UPC, l\'ISBN, et le nom.  Vous pourriez produire une étiquette à partir de l\'UPC de deux manières:</p>

				<ol>

					<li>De la page d\'article pour "Animal House," à côté de chaque champ il y a un lien pour créer une étiquette avec un code barre de la valeur de ce champ.  Pour obtenir l\'étiquette de UPC, vous cliqueriez juste le lien "étiquette" à côté du champ de l\'UPC.</li>

					<li>Vous pourriez aller à la <a href="'.$DIR_PREFIX.'labels.php">page etiquettes</a> et suivre les instructions pour créer une étiquette du champ UPC de "Animal House."  Cette méthode vous permet également de faire des étiquettes pour plusieurs articles en même temps.</li>

				</ol>

				<p>Après que ayez choisis un de ces deux méthodes, vous obtiendrez un graphique qui ressemble à ceci:</p>

				<p style="text-align: center;"><img src="'.$DIR_PREFIX.'images/sample_label.png" alt="Etiquette UPC Animal House" /></p>

				<p>La future version d\'anyInventory vous permettra de créer des étiquettes PDF que vous pouvez imprimer sur des feuilles </p>

				<p><i>Note: Cette possibilitée marche seulement si les fonctions nécessaires sont installées.  <b>Selon un auto-test, les fonctions nécessaires pour la production d\'étiquette ';



if (!function_exists('imagecreate') ||

    !function_exists('imagecolorallocate') ||

	!function_exists('imagettftext') ||

	!function_exists('imagestring') ||

	!function_exists('imagecopyresized') ||

	!function_exists('imagedestroy') ||

	!function_exists('imagepng')){

	

	$output .= ' ne sont pas ';

}
else {   $output .= ' sont ';}


$output .= ' installées.</b></i></p>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="deleting_alerts.php">&lt;&lt; Précédent: Supprimer une Alerte</a></div>

	<div style="text-align: right;"><a href="searching.php">Suivant: Rechercher &gt;&gt;</a></div>';



display($output);



?>
