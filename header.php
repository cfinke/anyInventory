<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $DIR_PREFIX; ?>style.css">
		<?php echo $inHead; ?>
	</head>
	<body<?php echo $inBodyTag; ?>>
		<table style="width: 99%; margin: 5px; background-color: #ffffff;" cellspacing="0">
			<tr>
				<td>
					<table cellspacing="0">
						<tr>
							<td id="appTitle">
								anyInventory 1.8
							</td>
							<td>
								<?php
								
								if (isset($_SESSION["user"]["id"])){
									echo '
										<td style="width: 5%; text-align: center; vertical-align: middle; white-space: nowrap;">[ <a href="'.$DIR_PREFIX.'login_processor.php?action=log_out">Log Out</a> ]</td>';
								}
								
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td id="mainMenu">
					<table>
						<tr>
							<?php
							
							if (isset($_SESSION["user"]["id"]) || !get_config_value('PP_VIEW')){
								echo '
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'index.php">Home</a></td>
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'labels.php">Labels</a></td>';
							}
							else{
								echo '
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'index.php">Home</a></td>';
							}
							?>
							<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="<?php echo $DIR_PREFIX; ?>docs/">Help</a></td>
							<?php
							
							if (isset($_SESSION["user"]["id"]) || !get_config_value('PP_ADMIN')){
								echo '
									<td style="width: 15%; text-align: right; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/index.php">Administration</a>:</td>
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/fields.php">Fields</a></td>
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/categories.php">Categories</a></td>
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/items.php">Items</a></td>
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/alerts.php">Alerts</a></td>		
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/users.php">Users</a></td>';
							}
							else{
								echo '
									<td style="width: 55%; text-align: right; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/index.php">Administration</a></td>';
							}
							
							?>
							<td style="width: 20%; text-align: right; vertical-align: middle;" class="submitButtonRow">
								<form action="<?php echo $DIR_PREFIX; ?>search.php" method="get">
									<input type="hidden" name="action" value="quick_search" />
									<?php
									
									if (isset($_SESSION["user"]["id"]) || !get_config_value('PP_VIEW')){
										echo '
											<input type="text" name="q" id="q" />
											<input type="submit" value="Search" />';
									}
									else{
										echo '
											<input type="text" name="q" id="q" disabled="disabled" />
											<input type="submit" value="Search" disabled="disabled" />';
									}
									
									?>
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td id="breadCrumbs">
					<?php echo $breadcrumbs; ?>
				</td>
			</tr>
			<tr>
				<td>
					<div style="min-height: 400px; padding: 5px;">
