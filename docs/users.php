<?php

require_once("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Usuarios";
		$breadcrumbs = '<a href="./">Ayuda</a> > Usuarios';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Usuarios</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>anyInventory 1.8 tiene un sistema de control de usuarios mucho mas complejo que las versiones anteriores.  Este te permite hacer una instalaci&oacute;n protegida por contraseña, ya sea para todo el inventario o solo para la secci&oacute;n de administraci&oacute;n.  El sistema de usuarios en la versi&oacute;n 1.8 es mas complejo y eficiente que las versiones previas ya que es posible crear varios usuarios, con diferentes privilegios de consulta y administraci&oacute;n.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="types">Tipos de usuario</a></td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Hay dos tipos de usuarios: normales y de administraci&oacute;n.  Los administradores tienen privilegios para agregar, editar y eliminar otros usuarios, campos, categor&iacute;as, art&iacute;culos y el texto de la p&aacute;gina principal. Tambi&eacute;n pueden deshabilitar la protecci&oacute;n de contraseña para el inventario e incluso para la secci&oacute;n de administraci&oacute;n.  Los usuarios normales solamente pueden editar campos, art&iacute;culos, y categor&iacute;as sobre las cuales hayan sido permitidos expl&iacute;citamente por alg&uacute;n administrador.</p>
						<p>La cuenta de administrador creada por la instalaci&oacute;n no puede ser eliminada.  Para evitar que por alg&uacute;n error te vieras imposibilitado para administrar el sistema al eliminar todas las cuentas de usuarios.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="introduction.php">&lt;&lt; Anterior: Introducci&oacute;n</a></div>
			<div style="text-align: right;"><a href="adding_users.php">Siguiente: Agregando Usuarios &gt;&gt;</a></div>';
		break;
	case 'fr':
		$title = "anyInventory: Aide > Utilisateurs";
		$breadcrumbs = '<a href="./">Aide</a> > Utilisateur';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Utilisateurs</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>La version 1.8 d\'anyInventory offre un système plus complexe de gestion des utilisateurs que dans les versions précédentes. Celle-ci vous permet d\'installer une protection par mot de passe pour l\'application entière de l\'inventaire ou juste la section d\'administration.  Le système mis en place dans la version 1.8 est plus complexe et plus puissant pour la protection par mot de passe car différents utilisateurs peuvent être créés avec des droits de consultation et des privilèges administratifs.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="types">Types d\'Utilisateur</a></td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Il y\'a deux types d\'utilisateur: utilisateur simple et administrateur.  Les administrateurs ont le plein pouvoir pour ajouter, éditer, et supprimer des utilisateurs, des champs, des catégories, des articles, et le texte de la page d\'accueil.  Ils peuvent aussi supprimer la protection par mot de passe pour l\'inventaire et l\'administration.  Les utilisateurs simples peuvent seulement éditer les champs, les articles, et les catégories autorisées par un administrateur.</p>
						<p>Le compte d\'administrateur créé à l\'installation ne peut être supprimé.  Ceci afin d\'assurer que le système d\'inventaire ne soit accidentellement fermé en supprimant tous les utilisateurs.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="introduction.php">&lt;&lt; Précédent: Introduction</a></div>
			<div style="text-align: right;"><a href="adding_users.php">Suivant: Ajouter un Utilisateur &gt;&gt;</a></div>';
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Users";
		$breadcrumbs = '<a href="./">Help</a> > Users';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Users</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Version 1.8 of anyInventory has a more complex user system than that of previous versions.  This allows you to setup password protection for the entire inventory application or just the administration section.  The system put in place in version 1.8 is more complex and more powerful than the previous password protection because multiple users can be created with different viewing and administrative priveleges.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="types">User Types</a></td>
				</tr>
				<tr>
					<td class="tableData">
						<p>There are two types of users: regular users and administrators.  Administrators have full power to add, edit, and delete users, fields, categories, items, and the front page text.  They can turn off password protection for the inventory and the administration as well.  Regular users can only edit fields, items, and categories that they are explicitly allowed to by an administrator.</p>
						<p>The administrator account that is created at install cannot be deleted.  This is to ensure that one cannot get accidentally locked out of the inventory system by deleting all users.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="introduction.php">&lt;&lt; Previous: Introduction</a></div>
			<div style="text-align: right;"><a href="adding_users.php">Next: Adding Users &gt;&gt;</a></div>';
		break;
}

display($output);

?>