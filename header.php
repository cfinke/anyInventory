<html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $DIR_PREFIX; ?>style.css" />
	</head>
	<body>
		<table align="center" id="maintable" cellspacing="1" cellpadding="0" border="0" width="90%">
			<tr>
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td valign="top" class="row_head" style="background: rgb(213,175,112);">
					<h1 style="padding: 6px; font-size: 36pt;">anyInventory 1.2</h1>		
				</td>
			</tr>
			<tr>
				<td align="top">
					<div id="searchbox">
						<form method="get" action="<?php echo $DIR_PREFIX; ?>search.php">
							<input type="hidden" name="action" value="search" />
							<input type="text" name="name" value="" />
							<input type="submit" name="submit" value="Search" />
						</form>
					</div>
					<div id="mainmenu"style="">
						<b>Main Menu: </b>
						[ <a href="<?php echo $DIR_PREFIX; ?>index.php">home</a> ]
						[ <a href="<?php echo $DIR_PREFIX; ?>search.php">advanced search</a> ]
						[ <a href="<?php echo $DIR_PREFIX; ?>admin/categories.php">categories</a> ]
						[ <a href="<?php echo $DIR_PREFIX; ?>admin/fields.php">fields</a> ]
						[ <a href="<?php echo $DIR_PREFIX; ?>admin/items.php">items</a> ]
						[ <a href="<?php echo $DIR_PREFIX; ?>docs/">help</a> ]
					</div>	
				</td>
			</tr>
			<tr height="100%">
				<td bgcolor="#ffffff" width="100%" align="left" valign="top" style="padding:5px">
