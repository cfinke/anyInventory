<?php



include("globals.php");



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



display($output);



?>
