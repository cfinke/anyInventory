<?php

require_once("globals.php");

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

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Alertas y adici&oacute;n de Alertas";
		$breadcrumbs = '<a href="./">Ayuda</a> > Alertas y adici&oacute;n de Alertas';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Alertas</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Las alertas te permiten hacer que anyInventory te avise cuando ciertas condiciones se cumplan. Por ejemplo, digamos que est&aacute;s llevando el control de los consumibles en la oficina, y necesitas saber cuando solo quede un cartucho de impresora.  Las alertas en anyInventory te permiten especificar esto.</p>
						<p><a name="time_based">T&uacute;</a> tambi&eacute;n puedes crear alertas basadas en tiempo.  Por ejemplo, si necesitas comprar tinta cada mes, crear&iacute;as una alerta mensual, sin ninguna otra condici&oacute;n.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="adding">Agregando alertas</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Para <a href="'.$DIR_PREFIX.'admin/add_alert.php">agregar una alerta</a>, primero debes seleccionar la categor&iacute;a a la cual pertenece(n) los art&iacute;culo(s).  Observa que solamente las categor&iacute;as que contengan uno o mas art&iacute;culos aparecer&aacute;n listadas.</p>
						<p>Ya que seleccionaste la categor&iacute;a, puedes comenzar a especificar las condiciones de la alerta.  Aqu&iacute; te mostramos como se podr&iacute;a ver una forma de estas:</p>
						<form>
							<table>
								'.display_alert_form("doc").'
							</table>
						</form>
						<p>Iniciamos especificando el t&iacute;tulo.  Esto es lo que ver&aacute;s cuando la alerta sea activada. En este ejemplo, un t&iacute;tulo adecuado podr&iacute;a ser "Quedan pocos."</p>
						<p>Despu&eacute;s de esto, selecciona los art&iacute;culos a los cuales quieres aplicar la alerta. (Puedes seleccionar varios art&iacute;culos a la vez, presionando la tecla Ctrl mientras seleccionas las entradas, de manera que si quieres saber cuando tengas uno o menos cartuchos o toners, puedas seleccionar ambos art&iacute;culos.)</p>
						<form>
							<table>
								'.display_alert_form("doc","Quedan pocos",1).'
							</table>
						</form>
						<p>A continuaci&oacute;n, selecciona el campo, valor y condici&oacute;n que activar&aacute;n la alerta.  En este caso, queremos saber cuando el campo Cantidad sea menor o igual a uno.</p>
						<form>
							<table>
								'.display_alert_form("doc", "Quedan pocos", 1, false, 2, "<=", 1).'
							</table>
						</form>
						<p>Ahora, puedes seleccionar la fecha a partir de la cual quieres que esta alerta est&eacute; activa. Generalmente, dejaremos la fecha actual, la cual debe aparecer por defecto.</p>
						<p>Tambi&eacute;n es posible seleccionar una fecha de expiraci&oacute;n, despu&eacute;s de la cual la alerta estar&aacute; inactiva, sin importar si las condiciones previas se cumplen o no.</p>
						<p>Una vez añadida la alerta, esta ser&aacute; mostrada en la p&aacute;gina principal, as&iacute; como en la de el art&iacute;culo a la cual est&aacute; siendo aplicada si esta se activa.  En este caso, se ver&iacute;a as&iacute;:</p>
						<table class="alertBox" cellspacing="0" cellpadding="2" border="0">
							<tr class="alertTitle">
								<td>
									Alerta
								</td>
								<td style="text-align: right;">
									<a href="alerts.php">?</a>
								</td>
							</tr>
							<tr class="alertContent">
								<td>
									<b>Quedan pocos </b><br><a href="">Cartuchos de impresora</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="deleting_items.php">&lt;&lt; Anterior: Eliminando art&iacute;culos</a></div>
			<div style="text-align: right;"><a href="editing_alerts.php">Siguiente: Editando Alertas &gt;&gt;</a></div>';
		
		break;
	case 'fr':
		$title = "anyInventory: Aide > Alertes et Ajouter une Alerte";
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
		
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Alerts and Adding Alerts";
		$breadcrumbs = '<a href="./">Help</a> > Alerts and Adding Alerts';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Alerts</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Alerts allow you to have anyInventory notify you when certain conditions arise. For example, say that you are using anyInventory to keep track of the office supplies at your workplace, and you need to know when there is only one printer cartridge left.  anyInventory alerts allow you to do just that.</p>
						<p><a name="time_based">You</a> can also create an alert that is time-based.  For example, if you know that you need to buy printer ink once a month, you could create an alert that will appear in one month, with no other conditions.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="adding">Adding Alerts</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>To <a href="'.$DIR_PREFIX.'admin/add_alert.php">add an alert</a>, you must first choose the category to which the item or items belong.  Note that only the categories which contain one or more items will be shown in the list.</p>
						<p>Once you have chosen a category, you can begin specifying the conditions of the alert.  Here is a what an alert addition page might look like:</p>
						<form>
							<table>
								'.display_alert_form("doc").'
							</table>
						</form>
						<p>Begin by specifying a title.  This is what you will see when the alert is activated. In this situation, an appropriate title would be "Low Quantity."</p>
						<p>After that, select the items that you want to apply the alert to. (You can choose multiple items by holding down the Ctrl key, so if you wanted to know when there is one printer cartridge or less or one toner cartridge or less, you could select both items.)</p>
						<form>
							<table>
								'.display_alert_form("doc","Low Quantity",1).'
							</table>
						</form>
						<p>After that, choose the field, value, and condition that should activate the alert.  In this case, we want to be alerted when the Quantity field is less than or equal to one.</p>
						<form>
							<table>
								'.display_alert_form("doc", "Low Quantity", 1, false, 2, "<=", 1).'
							</table>
						</form>
						<p>Then, you can choose a date on which the alert will be effective. Usually, you will want to just leave this as the current date, to which it should default.</p>
						<p>You can also choose an expiration date, after which the alert will become inactive, no matter if the condition is true or not.</p>
						<p>Once you have added an alert, it will show up on the front page as well as the page of the item it is applied to whenever it is active.  In this case, it would look like this:</p>
						<table class="alertBox" cellspacing="0" cellpadding="2" border="0">
							<tr class="alertTitle">
								<td>
									Alert
								</td>
								<td style="text-align: right;">
									<a href="alerts.php">?</a>
								</td>
							</tr>
							<tr class="alertContent">
								<td>
									<b>Low Quantity</b><br><a href="">Printer Cartridges</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="deleting_items.php">&lt;&lt; Previous: Deleting Items</a></div>
			<div style="text-align: right;"><a href="editing_alerts.php">Next: Editing Alerts &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>