<?php

include("globals.php");

/*
if ($_SESSION["usertype"] != 'Administrator'){
	header("Location: ../error_handler.php?eid=11");
	exit;
}
*/

$title = "anyInventory: Edit User";
$breadcrumbs = 'Administration > <a href="users.php">Users</a> > Edit User';

$user = new user($_REQUEST["id"]);

$output .= '
	<table class="standardTable" cellspacing="0" cellpadding="3">
		<tr class="tableHeader">
			<td>Edit User</td>
			</td>
			<td style="text-align: right;">
				[<a href="../docs/editing_users.php">Help</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<form method="post" action="user_processor.php">
					<input type="hidden" name="action" value="do_edit" />
					<input type="hidden" name="id" value="'.$user->id.'" />
					<table>
						<tr>
							<td class="form_label"><label for="username">Username:</label></td>
							<td class="form_input"><input type="text" name="username" id="username" value="'.$user->username.'" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="password">Password:</label></td>
							<td class="form_input"><input type="password" name="password" id="password" value="" />
								<br /><small>If you do not enter a new password, it will remain unchanged.</small></td>
						</tr>';
	
	if ($user->id != get_config_value('ADMIN_USER_ID')){
		$output .= '
						<tr>
							<td class="form_label"><label for="usertype">User Type:</label></td>
							<td class="form_input">
								<select name="usertype" id="usertype">
									<option value="User"';if($user->usertype == 'User') $output .= ' selected="selected"'; $output .= '>User</option>
									<option value="Administrator"';if($user->usertype == 'Administrator') $output .= ' selected="selected"'; $output .= '>Administrator</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label"><label for="c_view[]">Allow user to view:</label></td>
							<td class="form_input">
								<select name="c_view[]" id="c_view[]" multiple="multiple" size="10" style="width: 100%;">';
			
		if ($user->usertype == 'Administrator'){
			$output .= get_category_options(null);
		}
		else{
			$output .= get_category_options($user->categories_view);
		}
		
		$output .= '
									</select>
								</td>
							</tr>
							<tr>
								<td class="form_label"><label for="c_admin[]">Allow user to admin:</label></td>
								<td class="form_input">
									<select name="c_admin[]" id="c_admin[]" multiple="multiple" size="10" style="width: 100%;">';
			
		if ($user->usertype == 'Administrator'){
			$output .= get_category_options(null);
		}
		else{
			$output .= get_category_options($user->categories_view);
		}
		
		$output .= '
								</select>
							</td>
						</tr>';
	}
	
	$output .= '
						<tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="Submit" /></td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>';

display($output);

?>
