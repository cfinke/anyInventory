<html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $DIR_PREFIX; ?>style.css" />
	</head>
	<body>
		<table align="center" id="maintable" cellspacing="1" cellpadding="0" border="0">
			<tr>
				<td colspan="2">
					<div align="right" style="width: 100%;height: 100%;color: #cccccc; background: #000000;">
						.
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" class="row_head" style="background: rgb(213,175,112);" colspan="2">
					<h1 style="padding: 6px; font-size: 36pt;">anyInventory</h1>
		
				</td>
			</tr>
			<tr>
				<td align="top" colspan="2">
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
						[ <a href="<?php echo $DIR_PREFIX; ?>admin/categories.php">categories</a> ]
						[ <a href="<?php echo $DIR_PREFIX; ?>admin/fields.php">fields</a> ]
						[ <a href="<?php echo $DIR_PREFIX; ?>admin/items.php">items</a> ]
					</div>	
				</td>
			</tr>
			<tr height="100%">
				<td class="row_head" width="150" align="left" valign="top" style="padding:5px">
					<p><b><a href="<?php echo $DIR_PREFIX; ?>index.php">Inventory</a></b></p>
					<p><b><a href="<?php echo $DIR_PREFIX; ?>search.php">Advanced Search</a></b></p>
					<p><b><a href="<?php echo $DIR_PREFIX; ?>admin/fields.php">Fields</a></b><br />
					<a href="<?php echo $DIR_PREFIX; ?>admin/add_field.php">Add a field</a></p>
					<p><b><a href="<?php echo $DIR_PREFIX; ?>admin/categories.php">Categories</a></b><br />
					<a href="<?php echo $DIR_PREFIX; ?>admin/add_category.php">Add a category</a></p>
					<p><b><a href="<?php echo $DIR_PREFIX; ?>admin/items.php">Items</a></b><br />
					<a href="<?php echo $DIR_PREFIX; ?>admin/add_item.php">Add an item</a></p>
				</td>
				<td bgcolor="#ffffff" width="650" align="left" valign="top" style="padding:5px">
