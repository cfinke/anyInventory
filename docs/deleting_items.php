<?php

require_once("globals.php");

switch (LANG) {
	case 'es':
		$title = "anyInventory: Ayuda > Art&iacute;culos > Eliminando Art&iacute;culos";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="items.php">Art&iacute;culos</a> > Eliminando Art&iacute;culos';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Eliminando Art&iacute;culos</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Al eliminar un art&iacute;culo, todos los archivos relacionados ser&aacute;n eliminados tambi&eacute;n.  Lo dem&aacute;s es bastante obvio.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="moving_items.php">&lt;&lt; Anterior: Moviendo Art&iacute;culos</a></div>
			<div style="text-align: right;"><a href="alerts.php">Siguiente: Alertas &gt;&gt;</a></div>';
		break;
	case 'fr':
		$title = "anyInventory: Aide > Articles > Supprimer un Article";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="items.php">Articles</a> > Supprimer un Article';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Supprimer un Article</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Quand vous supprimez un artilce, tous les fichiers qui lui sont relatifs sont supprimés.  Le reste est assez explicite.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="moving_items.php">&lt;&lt; Précédent: Déplacer un Article</a></div>
			<div style="text-align: right;"><a href="alerts.php">Suivant: Alertes &gt;&gt;</a></div>';
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Items > Deleting Items";
		$breadcrumbs = '<a href="./">Help</a> > <a href="items.php">Items</a> > Deleting Items';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Deleting Items</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>When you delete an item, all related files will be deleted as well.  The rest is pretty self-explanatory.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="moving_items.php">&lt;&lt; Previous: Moving Items</a></div>
			<div style="text-align: right;"><a href="alerts.php">Next: Alerts &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>