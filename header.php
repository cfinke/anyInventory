<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title><?php echo APP_TITLE.': '.$title; ?></title>
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
								<?php echo APP_TITLE; ?>
							</td>
							<td>
								<?php
								
								if (isset($_SESSION["user"]["id"])){
									echo '
										<td style="width: 5%; text-align: center; vertical-align: middle; white-space: nowrap;">[ <a href="'.$DIR_PREFIX.'login_processor.php?action=log_out">'.LOG_OUT.'</a> ]</td>';
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
							
							if (isset($_SESSION["user"]["id"]) || !PP_VIEW){
								echo '
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'index.php">'.HOME.'</a></td>
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'labels.php">'.LABELS.'</a></td>';
							}
							else{
								echo '
									<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'index.php">'.HOME.'</a></td>';
							}
							?>
							<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="<?php echo $DIR_PREFIX; ?>docs/"><?php echo HELP; ?></a></td>
							<?php
							
							if (isset($_SESSION["user"]["id"]) || !PP_ADMIN){
								if (PP_ADMIN || PP_VIEW){
									echo '
										<td style="width: 15%; text-align: right; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/index.php">'.ADMINISTRATION.'</a>:</td>
										<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/fields.php">'.FIELDS.'</a></td>
										<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/categories.php">'.CATEGORIES.'</a></td>
										<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/items.php">'.ITEMS.'</a></td>
										<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/alerts.php">'.ALERTS.'</a></td>
										<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/users.php">'.USERS.'</a></td>';
								}
								else{
									echo '
										<td style="width: 20%; text-align: right; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/index.php">'.ADMINISTRATION.'</a>:</td>
										<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/fields.php">'.FIELDS.'</a></td>
										<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/categories.php">'.CATEGORIES.'</a></td>
										<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/items.php">'.ITEMS.'</a></td>
										<td style="width: 5%; text-align: center; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/alerts.php">'.ALERTS.'</a></td>';
								}
							}
							else{
								echo '
									<td style="width: 55%; text-align: right; vertical-align: middle;"><a href="'.$DIR_PREFIX.'admin/index.php">'.ADMINISTRATION.'</a></td>';
							}
							
							?>
							<td style="width: 20%; text-align: right; vertical-align: middle;" class="submitButtonRow">
								<form action="<?php echo $DIR_PREFIX; ?>search.php" method="get">
									<input type="hidden" name="action" value="quick_search" />
									<?php
									
									if (isset($_SESSION["user"]["id"]) || !PP_VIEW){
										echo '
											<input type="text" name="q" id="q" />
											<input type="submit" value="'.SEARCH.'" />';
									}
									else{
										echo '
											<input type="text" name="q" id="q" disabled="disabled" />
											<input type="submit" value="'.SEARCH.'" disabled="disabled" />';
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