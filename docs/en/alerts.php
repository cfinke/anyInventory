<?php

require_once("globals.php");

$title = "anyInventory: Help > Alerts and Adding Alerts";
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

display($output);

?>