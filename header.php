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
				<td id="appTitle">
					anyInventory 1.7
				</td>
			</tr>
			<tr>
				<td id="mainMenu">
					<table style="width: 100%;">
						<tr>
							<td style="width: 5%; text-align: center;"><a href="<?php echo $DIR_PREFIX; ?>index.php">Home</a></td>
							<td style="width: 5%; text-align: center;"><a href="<?php echo $DIR_PREFIX; ?>search.php">Search</a></td>
							<td style="width: 5%; text-align: center;"><a href="<?php echo $DIR_PREFIX; ?>labels.php">Labels</a></td>
							<td style="width: 5%; text-align: center;"><a href="<?php echo $DIR_PREFIX; ?>docs/">Help</a></td>
							<td style="width: 40%; text-align: right;">Administration:</td>
							<td style="width: 5%; text-align: center;"><a href="<?php echo $DIR_PREFIX; ?>admin/fields.php">Fields</a></td>
							<td style="width: 5%; text-align: center;"><a href="<?php echo $DIR_PREFIX; ?>admin/categories.php">Categories</a></td>
							<td style="width: 5%; text-align: center;"><a href="<?php echo $DIR_PREFIX; ?>admin/items.php">Items</a></td>
							<td style="width: 5%; text-align: center;"><a href="<?php echo $DIR_PREFIX; ?>admin/alerts.php">Alerts</a></td>
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
