<?php

require_once("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Usuarios > Agregando Usuarios";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="users.php">Usuarios</a> > Agregando Usuarios';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Agregando Usuarios</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Solo un administrador puede agregar usuarios.  Al agregar un usuario, el administrador puede definirlo como un usuario normal o como un administrador.  Si el usuario es especificado como un administrador, el o ella tendr&aacute;n permisos de consulta y administraci&oacute;n para todas las categor&iacute;as.  De otra manera, el administrador debe seleccionar las categor&iacute;as para las cuales tendra acceso el nuevo usuario.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="users.php#types">&lt;&lt; Anterior: Usuarios</a></div>
			<div style="text-align: right;"><a href="editing_users.php">Siguiente: Editando Usuarios &gt;&gt;</a></div>';
		
		break;
	case 'fr':
		$title = "anyInventory: Aide > Utilisateurs > Ajouter un Utilisateur";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="users.php">Utilisateurs</a> > Ajouter un Utilisateur';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Ajouter un Utilisateur</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Seulement les administrateurs peuvent ajouter un utilisateur.  Qaund il ajoute un utilisateur, l\'administrateur peut choisir si le nouvel utilisateur sera un utilisateur simple ou un administrateur.  Si l\'utilisateur ajouté est un administrateur, alors il aura le droit d\'administrer et de consulter toutes les catégories. Sinon, l\'administrateur doit choisir un groupe de catégories auxquel il donnera accès au nouvel utilisateur.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="users.php#types">&lt;&lt; Précédent: Types d\'Utilisateur</a></div>
			<div style="text-align: right;"><a href="editing_users.php">Suivant: Editer un Utilisateur &gt;&gt;</a></div>';
		
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Users > Adding Users";
		$breadcrumbs = '<a href="./">Help</a> > <a href="users.php">Users</a> > Adding Users';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Adding Users</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Only administrators can add users.  When adding a user, the administrator can specify the new user as a regular user or as an administrator.  If the user is added as an administrator, then he or she will have viewing and administrative access to all categories.  Otherwise, the administrator must select a group of categories to which to give access to the new user.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="users.php#types">&lt;&lt; Previous: User Types</a></div>
			<div style="text-align: right;"><a href="editing_users.php">Next: Editing Users &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>