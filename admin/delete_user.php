<?php

require_once("globals.php");

if ($_GET["id"] == ADMIN_USER_ID){
	header("Location: ../error_handler.php?eid=12");
	exit;
}
elseif($_GET["id"] == $admin_user->id){
	header("Location: ../error_handler.php?eid=14");
	exit;
}
elseif($admin_user->usertype != 'Administrator'){
	header("Location: ../error_handler.php?eid=11");
	exit;
}
else{
	$title = DELETE_USER;
	$breadcrumbs = '<a href="index.php">' .ADMINISTRATION.'</a> > <a href="users.php">'.USERS.'</a> > '.DELETE_USER;
	
	$userToDelete = new user($_GET["id"]);
	
	$output .= '
		<form action="user_processor.php" method="post">
			<input type="hidden" name="action" value="do_delete" />
			<input type="hidden" name="id" value="'.$_GET["id"].'" />
			<table class="standardTable" cellspacing="0" cellpadding="0">
				<tr class="tableHeader">
					<td>'.DELETE_USER.'</td>
					<td style="text-align: right;">[<a href="../docs/deleting_users.php">'.HELP.'</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<p>'.DELETE_USER_CONFIRM.'</p>
						'.$userToDelete->export_description().'
						<p class="submitButtonRow">
							<input type="submit" name="delete" value="'._DELETE.'" />
							<input type="submit" name="cancel" value="'.CANCEL.'" />
						</p>
					</td>
				</tr>
			</table>
		</form>';
	
	display($output);
}

?>
