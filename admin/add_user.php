<?php

include("globals.php");

if ($admin_user->usertype != 'Administrator'){
	header("Location: ../error_handler.php?eid=11");
	exit;
}

$title = "anyInventory: Add User";
$inHead = '
	<script type="text/javascript">
		<!--
		
		function toggle(){
			document.getElementById(\'c_view[]\').disabled = (document.getElementById(\'usertype\').options[document.getElementById(\'usertype\').selectedIndex].value == "Administrator")
			document.getElementById(\'c_admin[]\').disabled = (document.getElementById(\'usertype\').options[document.getElementById(\'usertype\').selectedIndex].value == "Administrator")
		}
		
		// -->
	</script>';
$breadcrumbs = 'Administration > <a href="users.php">Users</a> > Add User';

$output .= '
	<table class="standardTable" cellspacing="0" cellpadding="3">
		<tr class="tableHeader">
			<td>Add User</td>
			</td>
			<td style="text-align: right;">
				[<a href="../docs/adding_users.php">Help</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<form method="post" action="user_processor.php">
					<input type="hidden" name="action" value="do_add" />
					<table>
						<tr>
							<td class="form_label"><label for="username">Username:</label></td>
							<td class="form_input"><input type="text" name="username" id="username" value="" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="password">Password:</label></td>
							<td class="form_input"><input type="password" name="password" id="password" value="" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="usertype">User Type:</label></td>
							<td class="form_input">
								<select name="usertype" id="usertype" onchange="toggle();">
									<option value="User">User</option>
									<option value="Administrator">Administrator</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label"><label for="c_view[]">Allow user to view:</label></td>
							<td class="form_input">
								<select name="c_view[]" id="c_view[]" multiple="multiple" size="10" style="width: 100%;">
									'.get_category_options(null).'
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label"><label for="c_admin[]">Allow user to admin:</label></td>
							<td class="form_input">
								<select name="c_admin[]" id="c_admin[]" multiple="multiple" size="10" style="width: 100%;">
									'.get_category_options(null).'
								</select>
							</td>
						</tr>
						<tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>';

display($output);

?>
