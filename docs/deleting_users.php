<?php

require_once("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Usuarios > Eliminando Usuarios";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="users.php">Usuarios</a> > Eliminando Usuarios';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Eliminando Usuarios</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>No es posible eliminar al administrador creado durante la instalaci&oacute;n, y no puedes eliminar tu propia cuenta.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="editing_users.php">&lt;&lt; Anterior: Editando Usuarios</a></div>
			<div style="text-align: right;"><a href="fields.php">Siguiente: Campos &gt;&gt;</a></div>';
		
		break;
	case 'fr':
		$title = "anyInventory: Aide > Utilisateurs > Supprimer un Utilisateur";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="users.php">Utilisateurs</a> > Supprimer un Utilisateur';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Supprimer un Utilisateur</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Vous ne pouvez pas supprimer le compte d\'administrateur créé pendant l\'installation, et vous ne pouvez pas supprimer votre propre coimpte d\'utilisateur.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="editing_users.php">&lt;&lt; Précédent: Editer un Utilisateur</a></div>
			<div style="text-align: right;"><a href="fields.php">Suivant: Champs &gt;&gt;</a></div>';
		
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Users > Deleting Users";
		$breadcrumbs = '<a href="./">Help</a> > <a href="users.php">Users</a> > Deleting Users';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Deleting Users</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>You cannot delete the administrator user added during the install, and you cannot delete your own user.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="editing_users.php">&lt;&lt; Previous: Editing Users</a></div>
			<div style="text-align: right;"><a href="fields.php">Next: Fields &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>