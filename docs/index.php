<?php

include("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda";
		$breadcrumbs = 'Ayuda';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Tabla de contenido</td>
				</tr>
				<tr>
					<td class="tableData">
					<p>Bienvenido a la secci&oacute;n de ayuda para anyInventory.  Puedes leer en orden a trav&eacute;s de ella, o utilizar esta tabla de contenido para encontrar lo que est&aacute;s buscando.</p>
					<ol style="margin-left: 5%;">
						<li><a href="introduction.php">Introducci&oacute;n</a></li>
						<li><a href="users.php">Usuarios</a></li>
						<ol>
							<li><a href="users.php#types">Tipos de usuarios</a></li>
							<li><a href="adding_users.php">Agregando Usuarios</a></li>
							<li><a href="editing_users.php">Editando Usuarios</a></li>
							<li><a href="deleting_users.php">Eliminando Usuarios</a></li>
						</ol>
						<li><a href="fields.php">Campos</a></li>
						<ol>
							<li><a href="fields.php#types">Tipos de campo</a></li>
							<li><a href="adding_fields.php">Agregando</a></li>
							<li><a href="editing_fields.php">Editando</a></li>
							<li><a href="deleting_fields.php">Eliminando</a></li>
							<li><a href="field_order.php">Orden de campos</a></li>
						</ol>
						<li><a href="categories.php">Categor&iacute;as</a></li>
						<ol>
							<li><a href="categories.php#adding">Agregando</a></li>
							<li><a href="editing_categories.php">Editando</a></li>
							<li><a href="deleting_categories.php">Eliminando</a></li>
						</ol>
						<li><a href="items.php">Art&iacute;culos</a></li>
						<ol>
							<li><a href="items.php#adding">Agregando</a></li>
							<li><a href="editing_items.php">Editando</a></li>
							<li><a href="moving_items.php">Moviendo</a></li>
							<li><a href="deleting_items.php">Eliminando</a></li>
						</ol>
						<li><a href="alerts.php">Alerts</a></li>
						<ol>
							<li><a href="alerts.php#adding">Agregando</a></li>
							<li><a href="editing_alerts.php">Editando</a></li>
							<li><a href="deleting_alerts.php">Eliminando</a></li>
						</ol>
						<li><a href="labels.php">Etiquetas</a></li>
						<li><a href="searching.php">Buscando</a></li>
						<li><a href="whats_next.php">¿Qu&eacute; sigue?</a></li>
					</ol>
				</td>
			</tr>
			</table>
			<div style="text-align: right;"><a href="introduction.php">Primero: La introducci&oacute;n &gt;&gt;</a></div>';
		
		break;
	case 'fr':
		$title = "anyInventory: Aide";
		$breadcrumbs = 'Aide';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Table des Matières</td>
				</tr>
				<tr>
					<td class="tableData">
					<p>Bienvenue dans la section d\'aide d\'anyInventory.  Vous pouvez lire par les pages dans l\'ordre, ou employez la table des matières ci-dessous pour vous aider à trouver ce que vous recherchez.</p>
					<ol style="margin-left: 5%;">
						<li><a href="introduction.php">Introduction</a></li>
						<li><a href="users.php">Utilisateurs</a></li>
						<ol>
							<li><a href="users.php#types">Types d\'Utilisateur</a></li>
							<li><a href="adding_users.php">Ajouter un Utilisateur</a></li>
							<li><a href="editing_users.php">Editer un Utilisateur</a></li>
							<li><a href="deleting_users.php">Supprimer un Utilisateur</a></li>
						</ol>
						<li><a href="fields.php">Champs</a></li>
						<ol>
							<li><a href="fields.php#types">Types de Champ</a></li>
							<li><a href="adding_fields.php">Ajouter un Champ</a></li>
							<li><a href="editing_fields.php">Editer un Champ</a></li>
							<li><a href="deleting_fields.php">Supprimer un Champ</a></li>
							<li><a href="field_order.php">Organiser un Champ</a></li>
						</ol>
						<li><a href="categories.php">Catégories</a></li>
						<ol>
							<li><a href="categories.php#adding">Ajouter une Catégorie</a></li>
							<li><a href="editing_categories.php">Editer une Catégorie</a></li>
							<li><a href="deleting_categories.php">Supprimer une Catégorie</a></li>
						</ol>
						<li><a href="items.php">Articles</a></li>
						<ol>
							<li><a href="items.php#adding">Ajouter un Article</a></li>
							<li><a href="editing_items.php">Editer un Article</a></li>
							<li><a href="moving_items.php">Déplacer un Article</a></li>
							<li><a href="deleting_items.php">Supprimer un Article</a></li>
						</ol>
						<li><a href="alerts.php">Alertes</a></li>
						<ol>
							<li><a href="alerts.php#adding">Ajouter une Alerte</a></li>
							<li><a href="editing_alerts.php">Editer une Alerte</a></li>
							<li><a href="deleting_alerts.php">Supprimer une Alerte</a></li>
						</ol>
						<li><a href="labels.php">Etiquettes</a></li>
						<li><a href="searching.php">Recherche</a></li>
						<li><a href="whats_next.php">Quelles futures évolutions?</a></li>
					</ol>
				</td>
			</tr>
			</table>
			<div style="text-align: right;"><a href="introduction.php">D\'abord: Introduction &gt;&gt;</a></div>';
		
		break;
	case 'en':
	default:
		$title = "anyInventory: Help";
		$breadcrumbs = 'Help';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Table of Contents</td>
				</tr>
				<tr>
					<td class="tableData">
					<p>Welcome to the help section for anyInventory.  You can read through the pages in order, or use the table of contents below to help you find what you\'re looking for.</p>
					<ol style="margin-left: 5%;">
						<li><a href="introduction.php">Introduction</a></li>
						<li><a href="users.php">Users</a></li>
						<ol>
							<li><a href="users.php#types">User Types</a></li>
							<li><a href="adding_users.php">Adding Users</a></li>
							<li><a href="editing_users.php">Editing Users</a></li>
							<li><a href="deleting_users.php">Deleting Users</a></li>
						</ol>
						<li><a href="fields.php">Fields</a></li>
						<ol>
							<li><a href="fields.php#types">Field Types</a></li>
							<li><a href="adding_fields.php">Adding</a></li>
							<li><a href="editing_fields.php">Editing</a></li>
							<li><a href="deleting_fields.php">Deleting</a></li>
							<li><a href="field_order.php">Field Order</a></li>
						</ol>
						<li><a href="categories.php">Categories</a></li>
						<ol>
							<li><a href="categories.php#adding">Adding</a></li>
							<li><a href="editing_categories.php">Editing</a></li>
							<li><a href="deleting_categories.php">Deleting</a></li>
						</ol>
						<li><a href="items.php">Items</a></li>
						<ol>
							<li><a href="items.php#adding">Adding</a></li>
							<li><a href="editing_items.php">Editing</a></li>
							<li><a href="moving_items.php">Moving</a></li>
							<li><a href="deleting_items.php">Deleting</a></li>
						</ol>
						<li><a href="alerts.php">Alerts</a></li>
						<ol>
							<li><a href="alerts.php#adding">Adding</a></li>
							<li><a href="editing_alerts.php">Editing</a></li>
							<li><a href="deleting_alerts.php">Deleting</a></li>
						</ol>
						<li><a href="labels.php">Labels</a></li>
						<li><a href="searching.php">Searching</a></li>
						<li><a href="whats_next.php">What\'s Next?</a></li>
					</ol>
				</td>
			</tr>
			</table>
			<div style="text-align: right;"><a href="introduction.php">First: Introduction &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>