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
				<p>anyInventory, depuis la version 1.5, vous permet de cr&eacute;er une &eacute;tiquette avec un code barre de n\'importe quel champ d\'un article.  Par exemple, disons que vous avez achet&eacute; le DVD du film "Shrek" et que vous l\'avez ajout&eacute; à votre inventaire, avec l\'UPC, l\'ISBN, et le nom.  Vous pourriez produire une &eacute;tiquette à partir de l\'UPC de deux manières:</p>
				<ol>
					<li>De la page d\'article pour "Shrek", à côt&eacute; de chaque champ il y a un lien pour cr&eacute;er une &eacute;tiquette avec un code barre de la valeur de ce champ.  Pour obtenir l\'&eacute;tiquette de UPC, vous cliqueriez juste le lien "&eacute;tiquette" à côt&eacute; du champ de l\'UPC.</li>
					<li>Vous pourriez aller à la <a href="'.$DIR_PREFIX.'labels.php">page etiquettes</a> et suivre les instructions pour cr&eacute;er une &eacute;tiquette du champ UPC de "Shrek."  Cette m&eacute;thode produit un pdf des &eacute;tiquettes qui peuvent être imprim&eacute;es sur des planches d\'&eacute;tiquettes, de tailles diff&eacute;rentes, comme on peut le voir dans les options de gabarits.</li>
				</ol>
				<p>Après que ayez choisis un de ces deux m&eacute;thodes, vous obtiendrez un graphique qui ressemble à ceci:</p>
				<p style="text-align: center;"><img src="'.$DIR_PREFIX.'images/sample_label.png" alt="Etiquette UPC Shrek" /></p>
				<p>La future version d\'anyInventory vous permettra de cr&eacute;er des &eacute;tiquettes PDF que vous pouvez imprimer sur des feuilles </p>
				<p><i>Note: Cette possibilit&eacute;e marche seulement si les fonctions n&eacute;cessaires sont install&eacute;es.  <b>Selon un auto-test, les fonctions n&eacute;cessaires pour la production d\'&eacute;tiquette ';

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

$output .= ' install&eacute;es.</b></i></p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="deleting_alerts.php">&lt;&lt; Pr&eacute;c&eacute;dent: Supprimer une Alerte</a></div>
	<div style="text-align: right;"><a href="searching.php">Suivant: Rechercher &gt;&gt;</a></div>';

display($output);

?>