<?php

include("globals.php");

if (($admin_user->usertype != 'Administrator') && ($_GET["id"] != $_SESSION["user"]["id"])){
	header("Location: ../error_handler.php?eid=11");
	exit;
}

$title = "anyInventory: Edit User";
$inHead = '
	<script type="text/javascript">
		<!--
		
		function toggle(){
			document.getElementById(\'c_view[]\').disabled = (document.getElementById(\'usertype\').options[document.getElementById(\'usertype\').selectedIndex].value == "Administrator")
			document.getElementById(\'c_admin[]\').disabled = (document.getElementById(\'usertype\').options[document.getElementById(\'usertype\').selectedIndex].value == "Administrator")
		}
		
		// -->
	</script>';
$inBodyTag = ' onload="toggle();"';
$breadcrumbs = 'Administration > <a href="users.php">Users</a> > Edit User';

$local_user = new user($_GET["id"]);

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
					<input type="hidden" name="id" value="'.$local_user->id.'" />
					<table>';
	
	if ($_GET["id"] != $_SESSION["user"]["id"]){
		$output .= '
				<input type="hidden" name="action" value="do_edit" />
				<tr>
						<td class="form_label"><label for="username">Username:</label></td>
						<td class="form_input"><input type="text" name="username" id="username" value="'.$local_user->username.'" /></td>
					</tr>';
	}
	else{
		$output .= '<input type="hidden" name="action" value="do_edit_own" />';
	}
	
	$output .= '
						<tr>
							<td class="form_label"><label for="password">Password:</label></td>
							<td class="form_input"><input type="password" name="password" id="password" value="" />
								<br /><small>If you do not enter a new password, it will remain unchanged.</small></td>
						</tr>';
	
	if (($local_user->id != ADMIN_USER_ID) && ($_GET["id"] != $_SESSION["user"]["id"])){
		$output .= '
						<tr>
							<td class="form_label"><label for="usertype">User Type:</label></td>
							<td class="form_input">
								<select name="usertype" id="usertype" onchange="toggle();">
									<option value="User"';if($local_user->usertype == 'User') $output .= ' selected="selected"'; $output .= '>User</option>
									<option value="Administrator"';if($local_user->usertype == 'Administrator') $output .= ' selected="selected"'; $output .= '>Administrator</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label"><label for="c_view[]">Allow user to view:</label></td>
							<td class="form_input">
								<select name="c_view[]" id="c_view[]" multiple="multiple" size="10" style="width: 100%;">';
		
		if ($local_user->usertype == 'Administrator'){
			$output .= get_category_options(null);
		}
		else{
			$output .= get_category_options($local_user->categories_view);
		}
		
		$output .= '
									</select>
								</td>
							</tr>
							<tr>
								<td class="form_label"><label for="c_admin[]">Allow user to admin:</label></td>
								<td class="form_input">
									<select name="c_admin[]" id="c_admin[]" multiple="multiple" size="10" style="width: 100%;">';
		
		if ($local_user->usertype == 'Administrator'){
			$output .= get_category_options(null);
		}
		else{
			$output .= get_category_options($local_user->categories_admin);
		}
		
		$output .= '
								</select>
							</td>
						</tr>';
	}
	
	$output .= '
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
