<?php

include("globals.php");

switch (LANG) {
	case 'es':
		$title = "anyInventory: Ayuda > Campos > Editando Campos";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="fields.php">Campos</a> > Editando Campos';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editando Campos</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editar un campo funciona exactamente de la misma manera que agregar uno, excepto que la informaci&oacute;n ya est&aacute; capturada en la forma.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="adding_fields.php">&lt;&lt; Anterior: Agregando Campos</a></div>
			<div style="text-align: right;"><a href="deleting_fields.php">Siguiente: Eliminando Campos &gt;&gt;</a></div>';
		break;
	case 'fr':
		$title = "anyInventory: Aide > Champs > Editer un Champ";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="fields.php">Champs</a> > Editer un Champ';
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editer un Champ</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editer un champ est exactement la même chose que d\'ajouter un champ, seulement l\'information est déjà saisie dans le champ.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="adding_fields.php">&lt;&lt; Précédent: Ajouter un Champ</a></div>
			<div style="text-align: right;"><a href="deleting_fields.php">Suivant: Supprimer un Champ &gt;&gt;</a></div>';
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Fields > Editing Fields";
		$breadcrumbs = '<a href="./">Help</a> > <a href="fields.php">Fields</a> > Editing Fields';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editing Fields</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editing a field works exactly the same way as adding a field, only the information is already entered into the form.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="adding_fields.php">&lt;&lt; Previous: Adding Fields</a></div>
			<div style="text-align: right;"><a href="deleting_fields.php">Next: Deleting Fields &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>