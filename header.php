<?php

$top_links = array(array("key"=>"fields","url"=>"fields.php","name"=>"Fields"),
				   array("key"=>"categories","url"=>"categories.php","name"=>"Categories"),
				   array("key"=>"items","url"=>"items.php","name"=>"Items"));

?><html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<table align="center" id="maintable" cellspacing="1" cellpadding="0" border="0">
			<tr>
				<td colspan="2">
					<div align="right" style="width: 100%;height: 100%;color: #cccccc; background: #000000;">
						|
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" class="row_head" style="background: rgb(213,175,112);" colspan="2">
					<div style="padding:6px" class="site_header" style="padding:4px"><b>anyInventory</b></div>
		
				</td>
			</tr>
			<tr>
				<td align="top" colspan="2">
					<div id="mainmenu"style="">
						<b>Main Menu: </b>
						[ <a href="index.php">home</a> ]
						[ <a href="categories.php">categories</a> ]
						[ <a href="fields.php">fields</a> ]
						[ <a href="items.php">items</a> ]
					</div>	
				</td>
			</tr>
			<tr height="100%">
				<td class="row_head" width="150" align="left" valign="top" style="padding:5px">
					<?php 
					
					foreach($top_links as $top_link){
						echo '<p style="font-weight: bold;"><a href="'.$top_link["url"].'">'.$top_link["name"].'</a></p>';
						
						if ($page_key == $top_link["key"]){
							echo '<p style="margin-left: 2ex;">';
							
							foreach($links as $link){
								echo '<a href="'.$link["url"].'">'.$link["name"].'</a><br />';
							}
							
							echo '</p>';
						}
					}
					
					?></td>
				<td bgcolor="#ffffff" width="650" align="left" valign="top" style="padding:5px">