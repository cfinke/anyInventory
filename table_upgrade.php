<?php

$db_host = '';
$db_name = '';
$db_user = '';
$db_pass = '';

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name, $link);

$query = "CREATE TABLE `anyInventory_values` (
			`item_id` int( 11 ) NOT NULL default '0',
			`field_id` int( 11 ) NOT NULL default '0',
			`value` text NOT NULL ,
			UNIQUE KEY `item_id` ( `item_id` , `field_id` )
			) TYPE = MYISAM";
@mysql_query($query);

$query = "SELECT * FROM `anyInventory_categories`";
$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br />' . $query);

while ($row = mysql_fetch_array($result)){
	$newquery = "SELECT * FROM `anyInventory_fields` WHERE `categories` LIKE '%\"".$row["id"]."\"%'";
	$newresult = mysql_query($newquery) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br />' . $newquery);
	
	$newestquery = "SELECT * FROM `anyInventory_items` WHERE `item_category`='".$row["id"]."' ORDER BY `id`";
	$newestresult = mysql_query($newestquery) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br />' . $newestquery);
	
	while ($newestrow = mysql_fetch_array($newestresult)){
		while ($newrow = mysql_fetch_array($newresult)){
			$insert_query = "INSERT INTO `anyInventory_values` 
						(`item_id`,`field_id`,`value`)
						VALUES
						('".$newestrow["id"]."',
						 '".$newrow["id"]."',
						 '".$newestrow[$newrow["name"]]."')";
			@mysql_query($insert_query);
		}
		
		mysql_data_seek($newresult, 0);
	}
}

$query = "SHOW COLUMNS FROM `anyInventory_items`";
$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br />' . $query);

while ($row = mysql_fetch_array($result)){
	if (($row["Field"] != 'id') && ($row["Field"] != 'name') && ($row["Field"] != 'item_category')){
		$newquery = "ALTER TABLE `anyInventory_items` DROP `".$row["Field"]."`";
		mysql_query($newquery) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br />' . $newquery);
	}
}

echo 'Done.';

?>