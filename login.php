<?php

include("globals.php");

$title = LOGIN;
$breadcrumbs = LOGIN;

$output .= '<form method="post" action="login_processor.php">
				<input type="hidden" name="return_to" value="'.$_GET["return_to"].'" />
				<input type="hidden" name="action" value="log_in" />
				<table class="standardTable" cellspacing="0">
					<tr class="tableHeader">
						<td>'.LOGIN.'</td>
					</tr>
					<tr>
						<td class="tableData">
							<center>
							';

if ($_GET["f"]){
	$output .= '<p style="text-align: center; color: #ff0000;">Login failed</p>';
}

$output .= '
							<table style="width: 30%;" margin-left: 29%; margin-right: 29%;">
								<tr>
									<td class="form_label">'.USERNAME.':</td>
									<td class="form_input"><input type="text" name="username" /></td>
								</tr>
								<tr>
									<td class="form_label">'.PASSWORD.':</td>
									<td class="form_input"><input type="password" name="password" /></td>
								</tr>
								<tr>
									<td class="submitButtonRow" colspan="2"><input type="submit" value="'.LOGIN.'" /</td>
								</tr>
							</table>
							</center>
						</td>
					</tr>
				</table>
			</form>
		</fieldset>';

display($output);

?>
