<?php



include("globals.php");



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



display($output);



?>
