<?php



include("globals.php");



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



display($output);



?>
