<?php

include("globals.php");

$title = "anyInventory: Login";
$breadcrumbs = "Login";

$output .= '<form method="post" action="login_processor.php">
				<input type="hidden" name="return_to" value="'.$_REQUEST["return_to"].'" />
				<input type="hidden" name="action" value="log_in" />
				<table class="standardTable" cellspacing="0">
					<tr class="tableHeader">
						<td>Login</td>
					</tr>
					<tr>
						<td class="tableData">
							';

if ($_REQUEST["f"]){
	$output .= '<p style="text-align: center; color: #ff0000;">Login failed</p>';
}

$output .= '
							<table>
								<tr>
									<td class="form_label">Username:</td>
									<td class="form_input"><input type="text" name="username" /></td>
								</tr>
								<tr>
									<td class="form_label">Password:</td>
									<td class="form_input"><input type="password" name="password" /></td>
								</tr>
								<tr>
									<td class="submitButtonRow" colspan="2"><input type="submit" value="Login" /</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</fieldset>';

display($output);

?>