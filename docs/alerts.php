<?php

include("globals.php");

$title = "anyInventory: Help > Alerts and Adding Alerts";

$output .= '
	<h2>Alerts</h2>
	<p>Alerts allow you to have anyInventory notify you when certain conditions arise. For example, say that you are using anyInventory to keep track of the office supplies at your workplace, and you need to know when there is only one printer cartridge left.  anyInventory alerts allow you to do just that.</p>
	<p><a name="time_based">You</a> can also create an alert that is time-based.  For example, if you know that you need to buy printer ink once a month, you could create an alert that will appear in one month, with no other conditions.</p>
	<h2><a name="adding">Adding Alerts</a></h2>
	<p>To <a href="../admin/add_alert.php">add an alert</a>, you must first choose the category to which the item or items belong.  Note that only the categories which contain one or more items will be shown in the list.</p>
	<p>Once you have chosen a category, you can begin specifying the conditions of the alert.  Here is a what an alert addition page might look like:</p>
	<form>
		<table>
			<tr>
				<td class="form_label"><label for="name">Alert Title:</label></td>
				<td class="form_input"><input type="text" name="title" id="title" value="" maxlength="255" />
			</tr>
			<tr>
				<td class="form_label"><label for="c">Applies to:</label></td>
				<td class="form_input">
					<select name="i[]" id="i[]" multiple="multiple" size="10">
						<option value="">Printer Cartridges</option>
						<option value="">Paper</option>
						<option value="">Toner</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="field">Field:</label></td>
				<td class="form_input">
					<select name="field" id="field">
						<option value=""> Brand</option>
						<option value=""> Quantity</option>
						<option value=""> UPC</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="condition">Condition:</label></td>
				<td class="form_input">
					<select name="condition" id="condition">
						<option value="==">Equal to</option>
						<option value="!=">Not equal to</option>
						<option value="<">Less than</option>
						<option value=">">Greater than</option>
						<option value="<=">Less than or equal to</option>
						<option value=">=">Greater than or equal to</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="value">Value:</label></td>
				<td class="form_input"><input type="text" name="value" id="value" value="" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="month">Effective as of:</label></td>
				<td class="form_input">
					<select name="month" id="month">
						<option value="1">January</option>
						<option value="2">February</option>
						<option value="3">March</option>
						<option value="4">April</option>
						<option value="5">May</option>
						<option value="6" selected="selected">June</option>
						<option value="7">July</option>
						<option value="8">August</option>
						<option value="9">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					<select name="day" id="day"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9" selected="selected">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>			</select>,
					<select name="year" id="year"><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option>			</select>
					</td>
			</tr>
		</table>
	</form>
	<p>Begin by specifying a title.  This is what you will see when the alert is activated. In this situation, an appropriate title would be "Low Quantity."</p>
	<p>After that, select the items that you want to apply the alert to. (You can choose multiple items by holding down the Ctrl key, so if you wanted to know when there is one printer cartridge or less or one toner cartridge or less, you could select both items.)</p>
	<form>
		<table>
			<tr>
				<td class="form_label"><label for="name">Alert Title:</label></td>
				<td class="form_input"><input type="text" name="title" id="title" value="Low Quantity" maxlength="255" />
			</tr>
			<tr>
				<td class="form_label"><label for="c">Applies to:</label></td>
				<td class="form_input">
					<select name="i[]" id="i[]" multiple="multiple" size="10">
						<option value="" selected="selected">Printer Cartridges</option>
						<option value="">Paper</option>
						<option value="">Toner</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="field">Field:</label></td>
				<td class="form_input">
					<select name="field" id="field">
						<option value=""> Brand</option>
						<option value=""> Quantity</option>
						<option value=""> UPC</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="condition">Condition:</label></td>
				<td class="form_input">
					<select name="condition" id="condition">
						<option value="==">Equal to</option>
						<option value="!=">Not equal to</option>
						<option value="<">Less than</option>
						<option value=">">Greater than</option>
						<option value="<=">Less than or equal to</option>
						<option value=">=">Greater than or equal to</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="value">Value:</label></td>
				<td class="form_input"><input type="text" name="value" id="value" value="" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="month">Effective as of:</label></td>
				<td class="form_input">
					<select name="month" id="month">
						<option value="1">January</option>
						<option value="2">February</option>
						<option value="3">March</option>
						<option value="4">April</option>
						<option value="5">May</option>
						<option value="6" selected="selected">June</option>
						<option value="7">July</option>
						<option value="8">August</option>
						<option value="9">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					<select name="day" id="day"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9" selected="selected">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>			</select>,
					<select name="year" id="year"><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option>			</select>
					</td>
			</tr>
		</table>
	</form>
	<p>After that, choose the field, value, and condition that should activate the alert.  In this case, we want to be alerted when the Quantity field is less than or equal to one.</p>
	<form>
		<table>
			<tr>
				<td class="form_label"><label for="name">Alert Title:</label></td>
				<td class="form_input"><input type="text" name="title" id="title" value="Low Quantity" maxlength="255" />
			</tr>
			<tr>
				<td class="form_label"><label for="c">Applies to:</label></td>
				<td class="form_input">
					<select name="i[]" id="i[]" multiple="multiple" size="10">
						<option value="" selected="selected">Printer Cartridges</option>
						<option value="">Paper</option>
						<option value="">Toner</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="field">Field:</label></td>
				<td class="form_input">
					<select name="field" id="field">
						<option value=""> Brand</option>
						<option value="" selected="selected"> Quantity</option>
						<option value=""> UPC</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="condition">Condition:</label></td>
				<td class="form_input">
					<select name="condition" id="condition">
						<option value="==">Equal to</option>
						<option value="!=">Not equal to</option>
						<option value="<">Less than</option>
						<option value=">">Greater than</option>
						<option value="<=" selected="selected">Less than or equal to</option>
						<option value=">=">Greater than or equal to</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="value">Value:</label></td>
				<td class="form_input"><input type="text" name="value" id="value" value="1" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="month">Effective as of:</label></td>
				<td class="form_input">
					<select name="month" id="month">
						<option value="1">January</option>
						<option value="2">February</option>
						<option value="3">March</option>
						<option value="4">April</option>
						<option value="5">May</option>
						<option value="6" selected="selected">June</option>
						<option value="7">July</option>
						<option value="8">August</option>
						<option value="9">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					<select name="day" id="day"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9" selected="selected">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>			</select>,
					<select name="year" id="year"><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option>			</select>
					</td>
			</tr>
		</table>
	</form>
	<p>Then, you can choose a date on which the alert will be effective. Usually, you will want to just leave this as the current date, to which it should default.</p>
	<p>Once you have added an alert, it will show up on the front page as well as the page of the item it is applied to whenever it is active.  In this case, it would look like this:</p>
	<table style="background: rgb(0, 0, 0); width: 25ex; margin-bottom: 10px;" border="0" cellpadding="2" cellspacing="1">
		<tr style="background: rgb(0, 0, 0); color: rgb(211, 211, 166);">
			<td>
				Alert
			</td>
		</tr>
		<tr style="background: rgb(211, 211, 166);">
			<td style="text-align: center;">
				<b>Low Quantity</b><br><a href="">Printer Cartridges</a>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="deleting_items.php">&lt;&lt; Previous: Deleting Items</a></div>
	<div style="text-align: right;"><a href="editing_alerts.php">Next: Editing Alerts &gt;&gt;</a></div>';

display($output);

?>