<?php

require_once("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Usuarios > Editando Usuarios";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="users.php">Usuarios</a> > Editando Usuarios';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editando Usuarios</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editar un usuario es muy similar a agregar uno, solo que la informaci&oacute;n ya est&aacute; capturada.  Editar un usuario es diferente a agregar uno en las siguientes situaciones:</p>
						<ul>
							<li>Cuando editas al administrador agregado por la instalaci&oacute;n, solo puedes cambiar el nombre de usuario y contraseña.</li>
							<li>Al editar tu propia cuenta, solo puedes cambiar la contraseña.</li>
						</ul>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="adding_users.php">&lt;&lt; Anteior: Agregando Usuarios</a></div>
			<div style="text-align: right;"><a href="deleting_users.php">Siguiente: Eliminando Usuarios &gt;&gt;</a></div>';
		break;
	case 'fr':
		$title = "anyInventory: Aide > Utilisateurs > Editer un Utilisateur";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="users.php">Utilisateurs</a> > Editer un Utilisateur';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editer un Utilisateur</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>L\'édition d\'un utilisateur est semblable à ajouter un utilisateur, sauf que les champs sont pré-remplis.  L\'édition différera de d\'ajouter dans les situations suivantes:</p>
						<ul>
							<li>Quand vous éditez l\'administrateur créé pendant l\'installation, vous ne pouvez changer que son nom et son mot de passe.</li>
							<li>En éditant votre propre compte utilisateur, vous ne pouvez changer que votre mot de passe.</li>
						</ul>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="adding_users.php">&lt;&lt; Précédent: Ajouter un Utilsateur</a></div>
			<div style="text-align: right;"><a href="deleting_users.php">Suivant: Supprimer un Utilisateur &gt;&gt;</a></div>';
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Users > Editing Users";
		$breadcrumbs = '<a href="./">Help</a> > <a href="users.php">Users</a> > Editing Users';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Editing Users</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Editing a user is similar to adding a user, only the information is already filled in.  Editing will differ from adding in the following situations:</p>
						<ul>
							<li>When editing the administrator user added during the install, you can only change the username and password.</li>
							<li>When editing your own user, you can only change the password.</li>
						</ul>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="adding_users.php">&lt;&lt; Previous: Adding Users</a></div>
			<div style="text-align: right;"><a href="deleting_users.php">Next: Deleting Users &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>