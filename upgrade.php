<?php

// Upgrade file.

error_reporting(E_ALL ^ E_NOTICE);

include("functions.php");

$errors = array();

// Set the text of globals.php
$writetoglobals = '<?php

error_reporting(E_ALL ^ E_NOTICE);

$DIR_PREFIX .= "./";

$db_host = "'.$_REQUEST["db_host"].'";
$db_name = "'.$_REQUEST["db_name"].'";
$db_user = "'.$_REQUEST["db_user"].'";
$db_pass = "'.$_REQUEST["db_pass"].'";

';

if ($_REQUEST["password_protect"] == "yes"){
	$writetoglobals .= '$admin_pass = "'.$_REQUEST["admin_password"].'";

';
}

$writetoglobals .= 'include($DIR_PREFIX."functions.php");
include($DIR_PREFIX."category_class.php");
include($DIR_PREFIX."field_class.php");
include($DIR_PREFIX."item_class.php");
include($DIR_PREFIX."file_class.php");
include($DIR_PREFIX."alert_class.php");

connect_to_database();

?>';

if (is_array($_REQUEST)) foreach($_REQUEST as $key => $value) $_REQUEST[$key] = stripslashes($value);

if ($_REQUEST["action"] == "upgrade"){
	if (strlen(trim($_REQUEST["db_host"])) == 0){
		$errors[] = 'Please enter the name of your MySQL host.';
	}
	if (strlen(trim($_REQUEST["db_user"])) == 0){
		$errors[] = 'Please enter the MySQL username.';
	}
	if (strlen(trim($_REQUEST["db_name"])) == 0){
		$errors[] = 'Please enter the MySQL database name.';
	}
	if (strlen(trim($_REQUEST["db_pass"])) == 0){
		$errors[] = 'Please enter the MySQL password.';
	}
	
	$files_to_read = array("./","./admin","./images","./docs","./docs/images","./fonts","./item_files");
	
	foreach($files_to_read as $file){
		if (!is_readable(realpath($file))){
			$errors[] = "The path ".realpath($file)." is not readable.";
		}
	}
	
	if (!is_writable(realpath("./item_files/"))){
		$errors[] = 'The path '.realpath("./item_files/").' is not writable by the Web server.';
	}
	
	// Check for the correct database information.	
	if (count($errors) == 0){
		if(!@mysql_connect($_REQUEST["db_host"],$_REQUEST["db_user"],$_REQUEST["db_pass"])){
			$errors[] = 'anyInventory could not connect to the MySQL host with the information you provided.';
		}
		elseif(!mysql_select_db($_REQUEST["db_name"])){
			$errors[] = 'anyInventory connected to the MySQL host, but could not find the database '.$_REQUEST["db_name"].'.';
		}
	}
	
	// Make the appropriate changes, depending on the old version.	
	if (count($errors) == 0){
		mysql_connect($_REQUEST["db_host"],$_REQUEST["db_user"],$_REQUEST["db_pass"]);
		mysql_select_db($_REQUEST["db_name"]);
		
		switch($_REQUEST["old_version"]){
			case '1.0':
			case '1.2':
			case '1.3':
				## Changes introduced in 1.4
				$query = "CREATE TABLE `anyInventory_alerts` (
					`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
					`item_ids` text NOT NULL ,
					`title` varchar( 255 ) NOT NULL default '',
					`field_id` int( 11 ) NOT NULL default '0',
					`condition` enum( '==', '!=', '<', '>', '<=', '>=' ) NOT NULL default '==',
					`value` varchar( 255 ) NOT NULL default '',
					`time` timestamp( 14 ) NOT NULL ,
					UNIQUE KEY `id` ( `id` )
					) TYPE = MYISAM ;";
				mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
				
				$query = "ALTER TABLE `anyInventory_files` ADD `offsite_link` VARCHAR(255) NOT NULL";
				@mysql_query($query);
				
				// Fix field values data type
				
				$query = "SELECT `id`,`values` FROM `anyInventory_fields`";
				$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
				
				while ($row = mysql_fetch_array($result)){
					$values = unserialize($row["values"]);
					
					if (!is_array($values)){
						$values = explode(",",$row["values"]);
						
						if (is_array($values)){
							foreach($values as $key => $thing) $values[$key] = trim($thing);
						}
						else{
							$values = array();
						}
						
						$sql_values = serialize($values);
						
						$new_query = "UPDATE `anyInventory_fields` SET `values`='".$sql_values."' WHERE `id`='".$row["id"]."'";
						mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
					}
				}
				
				// Fix field categories data type
				
				$query = "SELECT `id`,`categories` FROM `anyInventory_fields`";
				$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
				
				while ($row = mysql_fetch_array($result)){
					$categories = unserialize($row["categories"]);
					
					if (!is_array($categories)){
						$categories = explode(",",$row["categories"]);
						
						if (is_array($categories)){
							foreach($categories as $key => $thing) $categories[$key] = trim($thing);
							$categories = array_unique($categories);
							sort($categories);
						}
						else{
							$categories = array();
						}
						
						$sql_categories = serialize($categories);
						
						$new_query = "UPDATE `anyInventory_fields` SET `categories`='".$sql_categories."' WHERE `id`='".$row["id"]."'";
						mysql_query($new_query) or die(mysql_error() . '<br /><br />'. $new_query);
					}
				}
				
				break;
			case '1.4.':
			case '1.4.1':
			case '1.5':
				# Changes introduced in 1.6
				
				// Added timed alerts
				$query = "ALTER TABLE `anyInventory_alerts` ADD `timed` TINYINT( 1 ) DEFAULT '0' NOT NULL";
				@mysql_query($query);
				
				$query = "ALTER TABLE `anyInventory_fields` CHANGE `input_type` `input_type` ENUM( 'text', 'textarea', 'checkbox', 'radio', 'select', 'multiple', 'file' ) DEFAULT 'text' NOT NULL ";
				mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
				
				$query = "SELECT COUNT(`key`) AS `num_files` FROM `anyInventory_files` GROUP BY `key` ORDER BY `key` DESC LIMIT 1";
				$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
				
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
					$max_files = $row["num_files"];
					
					if ($max_files > 0){
						$catquery = "SELECT `id` FROM `anyInventory_categories`";
						$catresult = mysql_query($catquery) or die(mysql_error() . '<br /><br />'. $catquery);
						
						$cat_ids = array();
						$values = array();
						
						while ($catrow = mysql_fetch_array($catresult)){
							$cat_ids[] = $catrow["id"];
						}
						
						for($i = 1; $i <= $max_files + 1; $i++){
							$query = "ALTER TABLE `anyInventory_items` ADD `Generic File ".$i."` INT NOT NULL";
							mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
							
							$query = "INSERT INTO `anyInventory_fields` (`name`,`input_type`,`categories`,`values`) VALUES ('Generic File ".$i."','file','".serialize($cat_ids)."','".serialize($values)."')";
							mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
						}
						
						$query = "SELECT `id`,`key` FROM `anyInventory_files` ORDER BY `key`,`id`";
						$file_result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
						
						$currrent_key = 0;
						
						while($file_row = mysql_fetch_array($file_result, MYSQL_ASSOC)){
							if ($current_key != $file_row["key"]){
								$i = 1;
								$current_key = $file_row["key"];
							}
							
							$query = "UPDATE `anyInventory_items` SET `Generic File ".$i."`='".$file_row["id"]."' WHERE `id`='".$file_row["key"]."'";
							mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
							
							$i++;
						}
					}
				}
			case '1.6':
				# Changes introduced in 1.7
		}
		
		// Attempt to write the globals file.
		@chmod(realpath("globals.php"), 0777);
		
		$handle = @fopen(realpath("globals.php"),"w");
		
		if ($handle){
			fwrite($handle, $writetoglobals);
			fclose($handle);
			@chmod(realpath("globals.php"), 0755);
			
			$globals_written = true;
		}
		
		if ($globals_written){
			if (is_file(realpath("install.php"))) @unlink(realpath("install.php"));
			if (is_file(realpath("upgrade.php"))) @unlink(realpath("upgrade.php"));
			
			header("Location: index.php");
		}
		else{
			$globals_error = true;
			
			$output .= '
				<input type="hidden" name="action" value="try_again" />
				<input type="hidden" name="db_host" value="'.stripslashes($_REQUEST["db_host"]).'" />
				<input type="hidden" name="db_user" value="'.stripslashes($_REQUEST["db_user"]).'" />
				<input type="hidden" name="db_pass" value="'.stripslashes($_REQUEST["db_pass"]).'" />
				<input type="hidden" name="db_name" value="'.stripslashes($_REQUEST["db_name"]).'" />
				<input type="hidden" name="password_protect" value="'.stripslashes($_REQUEST["password_protect"]).'" />
				<input type="hidden" name="admin_password" value="'.stripslashes($_REQUEST["admin_password"]).'" />
				<p>The following error occurred:</p>
				<ul class="error">
					<li>anyInventory could not write the globals.php file.  Either make this file writable by the Web server and click "Try Again", or replace the contents of the current globals.php file with the following code:<br /><pre>' . htmlentities($writetoglobals) . '</pre>If you choose to overwrite the file manually, do so, and then delete the install.php file.  Don\'t forget to change the permissions back on globals.php after you overwrite it.</li>
				</ul>
				<table>
					<tr>
						<td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="Try Again" /></td>
					</tr>
				</table>';
		}
	}
}

if($_REQUEST["action"] == "try_again"){
	$handle = @fopen(realpath("globals.php"),"w");
	
	if ($handle){
		fwrite($handle, $writetoglobals);
		fclose($handle);
		
		$globals_written = true;
	}
	else{
		@chmod(realpath("globals.php"), 0666);
		
		$handle = @fopen(realpath("globals.php"),"w");
		
		if ($handle){
			fwrite($handle, $writetoglobals);
			fclose($handle);
			
			$globals_written = true;
		}
	}
	
	if ($globals_written){
		if (is_file(realpath("install.php"))) @unlink(realpath("install.php"));
		if (is_file(realpath("upgrade.php"))) @unlink(realpath("upgrade.php"));
		
		header("Location: index.php");
	}
	else{
		$output .= '
			<input type="hidden" name="action" value="try_again" />
			<input type="hidden" name="db_host" value="'.stripslashes($_REQUEST["db_host"]).'" />
			<input type="hidden" name="db_user" value="'.stripslashes($_REQUEST["db_user"]).'" />
			<input type="hidden" name="db_pass" value="'.stripslashes($_REQUEST["db_pass"]).'" />
			<input type="hidden" name="db_name" value="'.stripslashes($_REQUEST["db_name"]).'" />
			<input type="hidden" name="password_protect" value="'.stripslashes($_REQUEST["password_protect"]).'" />
			<input type="hidden" name="admin_password" value="'.stripslashes($_REQUEST["admin_password"]).'" />
			<p>The following error occurred:</p>
			<ul class="error">
				<li>anyInventory could not write the globals.php file.  Either make this file writable by the Web server and click "Try Again", or replace the contents of the current globals.php file with the following code:<br /><pre>' . htmlentities($writetoglobals) . '</pre>If you choose to overwrite the file manually, do so, and then delete the install.php file.  Don\'t forget to change the permissions back on globals.php after you overwrite it.</li>
			</ul>
			<table>
				<tr>
					<td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="Try Again" /></td>
				</tr>
			</table>';
	}
}
elseif(!$globals_error){
	$db_host = ($_REQUEST["action"] != "") ? $_REQUEST["db_host"] : 'localhost';
	$ppchecked = ($_REQUEST["password_protect"]) ? ' checked="true"' : '';
	$inBodyTag = ($_REQUEST["password_protect"]) ? '' : ' onload="document.getElementById(\'admin_password\').disabled = true;"';
	
	if (count($errors) > 0){
		$output .= '
			<p>The following errors occurred:</p>
			<ul class="error">';
		
		foreach($errors as $error){
			$output .= '<li>'.$error.'</li>';
		}
		
		$output .= '</ul>';
	}
	
	$output .= '	<input type="hidden" name="action" value="upgrade" />
					<table>
						<tr>
							<td>From which version of anyInventory are you upgrading?</td>
							<td>
								<select name="old_version">
									<option value="1.6">1.6</option>
									<option value="1.5">1.5</option>
									<option value="1.4">1.4.1</option>
									<option value="1.4">1.4</option>
									<option value="1.3">1.3</option>
									<option value="1.2">1.2</option>
									<option value="1.1">1.1</option>
									<option value="1.0">1.0</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="formlabel"><label for="db_host">MySQL host:</label></td>
							<td><input type="text" name="db_host" id="db_host" value="'.$db_host.'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="db_user">MySQL Username:</label></td>
							<td><input type="text" name="db_user" id="db_user" value="'.stripslashes($_REQUEST["db_user"]).'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="db_pass">MySQL Password:</label></td>
							<td><input type="text" name="db_pass" id="db_pass" value="'.stripslashes($_REQUEST["db_pass"]).'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="db_name">MySQL Database:</label></td>
							<td><input type="text" name="db_name" id="db_name" value="'.stripslashes($_REQUEST["db_name"]).'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="password_protect">Password protect admin directory:</label></td>
							<td><input onclick="document.getElementById(\'admin_password\').disabled = !this.checked;" type="checkbox" name="password_protect" id="password_protect" value="yes"'.$ppchecked.' /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="admin_password">Admin Password:</label></td>
							<td><input type="text" name="admin_password" id="admin_password" value="'.stripslashes($_REQUEST["admin_password"]).'" /></td>
						</tr>
						<tr>
							<td class="formlabel">&nbsp;</td>
							<td><input type="submit" name="submit" id="submit" value="Upgrade" /></td>
						</tr>
					</table>';
}

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
		<head>
			<title>anyInventory 1.7 Upgrade</title>
			<link rel="stylesheet" type="text/css" href="style.css">
		</head>
		<body'.$inBodyTag.'>
			<table id="maintable" cellspacing="1" cellpadding="0" border="0">
				<tr>
					<td id="header_cell" style="background-image: url(images/header_bg.jpg); background-color: #000000; background-position: top right; background-repeat: no-repeat;">
						<h1 class="title">anyInventory 1.7</h1>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td style="background: #ffffff; width: 100%; padding: 5px; height: 400px;">
						<div style="min-height: 400px; padding: 5px;">
							<h2>Upgrade anyInventory</h2>
							<form action="upgrade.php" method="post">
								'.$output.'
							</form>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div style="text-align: center; width: 100%; color: #cccccc; font-size: 10px; padding: 4px;">
							<a href="http://anyinventory.sourceforge.net/">anyInventory, the web\'s most flexible and powerful inventory system</a>
						</div>
					</td>
				</tr>
			</table>
		</body>
	</html>';

exit;

?>