<?php

include("globals.php");

if (($admin_user->usertype != 'Administrator') && ($_GET["id"] != $_SESSION["user"]["id"])){
	header("Location: ../error_handler.php?eid=11");
	exit;
}

$title = EDIT_USER;
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
$breadcrumbs = ADMINISTRATION.' > <a href="users.php">'.USERS.'</a> > '.EDIT_USER;

$local_user = new user($_GET["id"]);

$output .= '
	<table class="standardTable" cellspacing="0" cellpadding="3">
		<tr class="tableHeader">
			<td>'.EDIT_USER.'</td>
			</td>
			<td style="text-align: right;">
				[<a href="../docs/'.LANG.'/editing_users.php">'.HELP.'</a>]
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
						<td class="form_label"><label for="username">'.USERNAME.':</label></td>
						<td class="form_input"><input type="text" name="username" id="username" value="'.htmlspecialchars($local_user->username, ENT_QUOTES).'" /></td>
					</tr>';
	}
	else{
		$output .= '<input type="hidden" name="action" value="do_edit_own" />';
	}
	
	$output .= '
						<tr>
							<td class="form_label"><label for="password">'.PASSWORD.':</label></td>
							<td class="form_input"><input type="password" name="password" id="password" value="" />
								<br /><small>'.EDIT_PASSWORD_INFO.'</small></td>
						</tr>';
	
	if (($local_user->id != ADMIN_USER_ID) && ($_GET["id"] != $_SESSION["user"]["id"])){
		$output .= '
						<tr>
							<td class="form_label"><label for="usertype">'.USER_TYPE.':</label></td>
							<td class="form_input">
								<select name="usertype" id="usertype" onchange="toggle();">
									<option value="User"';if($local_user->usertype == 'User') $output .= ' selected="selected"'; $output .= '>'.USER.'</option>
									<option value="Administrator"';if($local_user->usertype == 'Administrator') $output .= ' selected="selected"'; $output .= '>'.ADMINISTRATOR.'</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label"><label for="c_view[]">'.GIVE_VIEW_TO.':</label></td>
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
								<td class="form_label"><label for="c_admin[]">'.GIVE_ADMIN_TO.':</label></td>
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
							<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /> <input type="submit" name="cancel" value="'.CANCEL.'" /></td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>';

display($output);

?>
