<?php



include("globals.php");



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



display($output);



?>
