<?php



include("globals.php");



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



display($output);



?>
