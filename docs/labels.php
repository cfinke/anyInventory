<?php

include("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Etiquetas";
		$breadcrumbs = '<a href="./">Ayuda</a> > Etiquetas';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Etiquetas</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>anyInventory, a partir de la versi&oacute;n 1.5, te permite crear c&oacute;digos de barras para cualquier campo de cualquier art&iacute;culo.  Por ejemplo, digamos que compraste el DVD de la pel&iacute;cula "Shrek," y lo agregaste a tu inventario, guardando el UPC, ISBN, y el nombre.  Puedes producir una etiqueta del UPC de dos maneras:</p>
						<ol>
							<li>En la p&aacute;gina del art&iacute;culo "Shrek," a un lado del nombre de cada campo se encuentra un enlace a la etiqueta de ese campo.  Para generar la etiqueta del campo UPC, solo necesitar&iacute;as seleccionar el enlace "Etiqueta" junto al campo UPC.</li>
							<li>Puedes ir a la <a href="'.$DIR_PREFIX.'labels.php">página de etiquetas</a> y seguir las instrucciones para generar una etiqueta para el UPC de "Shrek." Mediante este método se crea un archivo PDF que puede ser impreso en hojas para etiquetas estandar de diferentes tamaños, como se indica en las opciones de las plantillas.</li>
						</ol>
						<p>Despu&eacute;s de esto, se te mostrar&aacute; una imagen, similar a esta:</p>
						<p style="text-align: center;"><img src="'.$DIR_PREFIX.'images/sample_label.png" alt="Shrek, etiqueta del UPC" /></p>
						<p><i>Nota: Esta opci&oacute;n solamente funciona si las librer&iacute;as necesarias se encuentran instaladas.  <b>De acuerdo a una auto-prueba, estas funciones ';
		
		if (!function_exists('imagecreate') ||
		    !function_exists('imagecolorallocate') ||
			!function_exists('imagettftext') ||
			!function_exists('imagestring') ||
			!function_exists('imagecopyresized') ||
			!function_exists('imagedestroy') ||
			!function_exists('imagepng')){
		
			$output .= ' no ';
		}
		
		$output .= ' est&aacute;n instaladas.</b></i></p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="deleting_alerts.php">&lt;&lt; Anterior: Eliminando Alertas</a></div>
			<div style="text-align: right;"><a href="searching.php">Siguiente: Buscando &gt;&gt;</a></div>';
		break;
	case 'fr':
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
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Labels";
		$breadcrumbs = '<a href="./">Help</a> > Labels';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Labels</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>anyInventory, as of version 1.5, allows you to create a barcode label from any field of an item.  For example, let\'s say that you had bought the DVD of the movie "Shrek," and you added it to your inventory, tracking the UPC, the ISBN, and the name.  You could produce a label from the UPC in one of two ways:</p>
						<ol>
							<li>On the item page for "Shrek," next to each field name is a link to a barcode label of that field\'s value.  To get the UPC label, you would just click on the "Label" link next to the UPC field.</li>
							<li>You could go to the <a href="'.$DIR_PREFIX.'labels.php">labels page</a> and follow the directions to produce a label for the UPC field of "Shrek."  This method produces a PDF of labels that can be printed on label sheets of varying sizes, as depicted in the template options.</li>
						</ol>
						<p>After you choose one of these two methods, you will be presented with a graphic that looks like this:</p>
						<p style="text-align: center;"><img src="'.$DIR_PREFIX.'images/sample_label.png" alt="Shrek UPC label" /></p>
						<p><i>Note: This feature only works if the necessary functions are installed.  <b>According to a self-test, the functions necessary for label production to work are ';
		
		if (!function_exists('imagecreate') ||
		    !function_exists('imagecolorallocate') ||
			!function_exists('imagettftext') ||
			!function_exists('imagestring') ||
			!function_exists('imagecopyresized') ||
			!function_exists('imagedestroy') ||
			!function_exists('imagepng')){
			
			$output .= ' not ';
		}
		
		$output .= ' installed.</b></i></p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="deleting_alerts.php">&lt;&lt; Previous: Deleting Alerts</a></div>
			<div style="text-align: right;"><a href="searching.php">Next: Searching &gt;&gt;</a></div>';
		break;
}

display($output);

?>