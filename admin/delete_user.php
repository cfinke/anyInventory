<?php

include("globals.php");

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
	$title = "anyInventory: Delete User";
	$breadcrumbs = 'Administration > <a href="users.php">Users</a> > Delete User';
	
	$user = new user($_GET["id"]);
	
	$output .= '
		<form action="user_processor.php" method="post">
			<input type="hidden" name="action" value="do_delete" />
			<input type="hidden" name="id" value="'.$_GET["id"].'" />
			<table class="standardTable" cellspacing="0" cellpadding="0">
				<tr class="tableHeader">
					<td>Delete User</td>
					<td style="text-align: right;">[<a href="../docs/deleting_users.php">Help</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<p>Are you sure you want to delete this user?</p>
						'.$user->export_description().'
						<p class="submitButtonRow">
							<input type="submit" name="delete" value="Delete" />
							<input type="submit" name="cancel" value="Cancel" />
						</p>
					</td>
				</tr>
			</table>
		</form>';
	
	display($output);
}

?>