<?php



include("globals.php");



$title = "anyInventory: Aide > Alertes et Ajouter une Alerte";

$inHead = '

	<script type="text/javascript">

		<!-- 

			function toggle(num){

				document.getElementById(\'field\' + num).disabled = document.getElementById(\'timed\' + num).checked;

				document.getElementById(\'condition\' + num).disabled = document.getElementById(\'timed\' + num).checked;

				document.getElementById(\'value\' + num).disabled = document.getElementById(\'timed\' + num).checked;

			}

		// -->

	</script>';

$breadcrumbs = '<a href="./">Aide</a> > Alertes et Ajouter une Alerte';



$output .= '

	<table class="standardTable" cellspacing="0">

		<tr class="tableHeader">

			<td>Alertes</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Les alertes permettent qu\'anyInventory vous informe quand certaines conditions sont remplies. Par exemple, si vous utilisez anyInventory pour gérér les fournitures de bureau de votre lieu de travail, et que vous voulez savoir quand il y ne reste qu\'une cartouche d\'encre. Les alertes d\'anyInventory vous permettent de faire çà.</p>

				<p><a name="time_based">Vous</a> pouvez également créer une alerte temporelle.  Par exemple, si vous savez que vous devez acheter de l\'encre une fois par mois, vous pourriez créer une alerte qui apparaîtra tous les mois, sans d\'autres conditions.</p>

			</td>

		</tr>

		<tr class="tableHeader">

			<td><a name="adding">Ajouter une Alerte</td>

		</tr>

		<tr>

			<td class="tableData">

				<p>Pour <a href="'.$DIR_PREFIX.'admin/add_alert.php">ajouter une alerte</a>, vous devez d\'abord choisir la catégorie à laquelle l\'article ou les articles appartiennent.  Notez que seulement les catégories qui contiennent un ou plusieurs articles seront montrées dans la liste.</p>

				<p>Une fois que vous avez choisi une catégorie, vous pouvez commencer à choisir les conditions de l\'alerte.  Voici à quoi une page de création d\'alerte pourrait ressembler:</p>

				<form>

					<table>

						'.display_alert_form("doc").'

					</table>

				</form>

				<p>Commencez en indiquant un titre.  C\'est ce ce qui vous verrez quand l\'alerte sera activée. Dans cette situation, le titre approprié serait "Quantité Faible."</p>

				<p>Après çà, choisissez les articles auxquels vous voulez appliquer l\'alerte. (Vous pouvez choisir plusieurs articles en maintenant la touche Ctrl, ainsi si vous voulez savoir quand il y aura une cartouche d\'encre ou moins ou un toner ou moins, vous pourrez choisir les deux articles.)</p>

				<form>

					<table>

						'.display_alert_form("doc","Quantité Faible",1).'

					</table>

				</form>

				<p>Après çà, choisissez le champ, la valeur, et la condition qui doivent activer l\'alerte.  Dans le cas présdent, nous voulons être alertés quand le champ de quantité est inférieur ou égal à un.</p>

				<form>

					<table>

						'.display_alert_form("doc", "Quantité Faible", 1, false, 2, "<=", 1).'

					</table>

				</form>

				<p>Enfin, vous pouvez choisir une date à laquelle l\'alerte sera active. Pratiquement, vous devriez laisser la date du jour par défaut.</p>

				<p>Vous pouvez aussi choisir une date d\'expiration, aprés laquelle l\'alerte sera désactivée,  que la condition d\'alerte ait été vérifiée ou pas.</p>

				<p>Une fois que vous avez ajouté une alerte, elle apparaîtra sur la page d\'acceuil et sur la page de l\'article concerné à chaque fois qu\'elle est activée. Dans ce cas, elle ressemblera à ceci:</p>

				<table class="alertBox" cellspacing="0" cellpadding="2" border="0">

					<tr class="alertTitle">

						<td>

							Alerte

						</td>

						<td style="text-align: right;">

							<a href="alerts.php">?</a>

						</td>

					</tr>

					<tr class="alertContent">

						<td>

							<b>Quantitée faible</b><br><a href="">Cartouches d\'imprimante</a>

						</td>

					</tr>

				</table>

			</td>

		</tr>

	</table>

	<div style="float: left;"><a href="deleting_items.php">&lt;&lt; Précédent: Supprimer un Article</a></div>

	<div style="text-align: right;"><a href="editing_alerts.php">Suivant: Editer une Alerte &gt;&gt;</a></div>';



display($output);



?>
