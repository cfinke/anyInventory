<?php

// Installation file.

error_reporting(E_ALL ^ E_NOTICE);

include("functions.php");

// Set the text of globals.php
$writetoglobals = '<?php

error_reporting(E_ALL ^ E_NOTICE);

$DIR_PREFIX .= "./";

$db_host = "'.$_REQUEST["db_host"].'";
$db_name = "'.$_REQUEST["db_name"].'";
$db_user = "'.$_REQUEST["db_user"].'";
$db_pass = "'.$_REQUEST["db_pass"].'";

include($DIR_PREFIX."functions.php");
include($DIR_PREFIX."category_class.php");
include($DIR_PREFIX."field_class.php");
include($DIR_PREFIX."item_class.php");
include($DIR_PREFIX."file_class.php");
include($DIR_PREFIX."alert_class.php");

connect_to_database();

?>';

$output .= '<form action="'.$_SERVER["PHP_SELF"].'" method="post">';

if ($_REQUEST["action"] == "install"){
	// First, check for missing data.
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
	
	// Check for current tables with the same names as those we are creating.
	if (count($errors) == 0){
		if (!$_REQUEST["overwrite_tables"]){
			$tables = array("anyInventory_items","anyInventory_categories","anyInventory_fields","anyInventory_files","anyInventory_alerts");
			
			foreach ($tables as $table){
				$query = "SHOW TABLES LIKE '".$table."'";
				$result = mysql_query($query) or die(mysql_error() . '<br />' .$query);
				
				if (mysql_num_rows($result) > 0){
					$errors[] = "The table `".$table."` already exists in the MySQL database ".$_REQUEST["db_name"].".";
				}
			}
		}
	}
	
	// Try to write the globals.php file.
	if (count($errors) == 0){
		// Open the file for writing.
		$handle = @fopen($path . "globals.php","w");
		
		if ($handle){
			fwrite($handle, $writetoglobals);
			fclose($handle);
		}
		else{
			// Try chmodding the file.
			@chmod($path . "globals.php", 0666);
			
			$handle = @fopen($path . "globals.php","w");
			
			if ($handle){
				fwrite($handle, $writetoglobals);
				fclose($handle);
			}
			else{
				$config_errors[] = "anyInventory could not write the globals.php file.  Either make this file writable by the Web server and click 'Try Again', or replace the contents of the current globals.php file with the following code:<br /><pre>" . htmlentities($writetoglobals) . "</pre>If you choose to overwrite the file manually, do so, and then delete the install.php file.  Don't forget to change the permissions back on globals.php after you overwrite it.";
			}
		}
	}
	
	if (count($errors) == 0){
		// Begin writing the database information.
		$query = "DROP TABLE `anyInventory_categories` ,
			`anyInventory_fields` ,
			`anyInventory_items` ,
			`anyInventory_files`,
			`anyInventory_alerts`";
		@mysql_query($query);
		
		$query = "CREATE TABLE `anyInventory_categories` (
				  `id` int(11) NOT NULL auto_increment,
				  `parent` int(11) NOT NULL default '0',
				  `name` varchar(32) NOT NULL default '',
				  UNIQUE KEY `id` (`id`),
				  KEY `parent` (`parent`)
				) TYPE=MyISAM";
		mysql_query($query) or die(mysql_error() . '<br />'.$query);
		
		$query = "CREATE TABLE `anyInventory_fields` (
				  `id` int(11) NOT NULL auto_increment,
				  `name` varchar(32) NOT NULL default '',
				  `input_type` enum('text','textarea','checkbox','radio','select','multiple') NOT NULL default 'text',
				  `values` text NOT NULL,
				  `default_value` varchar(32) NOT NULL default '',
				  `size` int(11) NOT NULL default '0',
				  `categories` text NOT NULL,
				  `importance` int(11) NOT NULL default '0',
				  UNIQUE KEY `id` (`id`),
				  UNIQUE KEY `name` (`name`)
				) TYPE=MyISAM";
		mysql_query($query) or die(mysql_error() . '<br />'.$query);
		
		$query = "CREATE TABLE `anyInventory_items` (
				  `id` int(11) NOT NULL auto_increment,
				  `item_category` int(11) NOT NULL default '0',
				  `name` varchar(64) NOT NULL default '',
				  UNIQUE KEY `id` (`id`)
				) TYPE=MyISAM";
		mysql_query($query) or die(mysql_error() . '<br />'.$query);
		
		$query = "CREATE TABLE `anyInventory_files` (
					`id` INT NOT NULL AUTO_INCREMENT ,
					`key` INT NOT NULL ,
					`file_name` VARCHAR( 255 ) NOT NULL ,
					`file_size` INT NOT NULL ,
					`file_type` VARCHAR( 32 ) NOT NULL ,
					`offsite_link` VARCHAR( 255 ) NOT NULL,
					UNIQUE (
						`id`
					)
				)";
		mysql_query($query) or die(mysql_error() . '<br />'.$query);
		
		$query = "CREATE TABLE `anyInventory_alerts` (
					`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
					`item_ids` text NOT NULL ,
					`title` varchar( 255 ) NOT NULL default '',
					`field_id` int( 11 ) NOT NULL default '0',
					`condition` enum( '==', '!=', '<', '>', '<=', '>=' ) NOT NULL default '==',
					`value` varchar( 255 ) NOT NULL default '',
					`time` timestamp( 14 ) NOT NULL ,
				 	`timed` TINYINT( 1 ) DEFAULT '0' NOT NULL,
					UNIQUE KEY `id` ( `id` )
					) TYPE = MYISAM ;";
		mysql_query($query) or die(mysql_error() . '<br />'.$query);
		
		if (count($config_errors) == 0){
			// Delete the install file.
			if (is_file($_SERVER["PATH_TRANSLATED"])) @unlink($_SERVER["PATH_TRANSLATED"]);
			
			header("Location: index.php");
		}
		else{
			$set_config_error = true;
			
			// Display the config error information
			
			$output .= '
				<input type="hidden" name="action" value="try_again" />
				<input type="hidden" name="db_host" value="'.stripslashes($_REQUEST["db_host"]).'" />
				<input type="hidden" name="db_user" value="'.stripslashes($_REQUEST["db_user"]).'" />
				<input type="hidden" name="db_pass" value="'.stripslashes($_REQUEST["db_pass"]).'" />
				<input type="hidden" name="db_name" value="'.stripslashes($_REQUEST["db_name"]).'" />
				<p>The following errors occurred:</p><ul class="error">';
			
			foreach($config_errors as $error){
				$output .= '<li>'.$error.'</li>';
			}
			
			$output .= '</ul>
						<table>
							<tr>
								<td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="Try Again" /></td>
							</tr>
						</table>';
		}
	}
}

if($_REQUEST["action"] == "try_again"){
	// The user has done the database setup, but the globals.php file has not been written.
	$handle = @fopen($path . "globals.php","w");
	if ($handle){
		fwrite($handle, $writetoglobals);
		fclose($handle);
	}
	else{
		@chmod($path . "globals.php", 0666);
		
		$handle = @fopen($path . "globals.php","w");
		
		if ($handle){
			fwrite($handle, $writetoglobals);
			fclose($handle);
		}
		else{
			$config_errors[] = "anyInventory could not write the globals.php file.  Either make this file writable by the Web server and click 'Try Again', or replace the contents of the current globals.php file with the following code:<br /><pre>" . htmlentities($writetoglobals) . "</pre>If you choose to overwrite the file manually, do so, and then delete the install.php file.  Don't forget to change the permissions back on globals.php after you overwrite it.";
		}
	}
	
	if (count($config_errors) == 0){
		if (is_file($_SERVER["PATH_TRANSLATED"])) @unlink($_SERVER["PATH_TRANSLATED"]);
		
		header("Location: index.php");
	}
	else{
		$output .= '
				<input type="hidden" name="action" value="try_again" />
				<input type="hidden" name="db_host" value="'.stripslashes($_REQUEST["db_host"]).'" />
				<input type="hidden" name="db_user" value="'.stripslashes($_REQUEST["db_user"]).'" />
				<input type="hidden" name="db_pass" value="'.stripslashes($_REQUEST["db_pass"]).'" />
				<input type="hidden" name="db_name" value="'.stripslashes($_REQUEST["db_name"]).'" />
				<p>The following errors occurred:</p><ul class="error">';
		
		foreach($config_errors as $error){
			$output .= '<li>'.$error.'</li>';
		}
		
		$output .= '</ul>
					<table>
						<tr>
							<td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="Try Again" /></td>
						</tr>
					</table>';
	}
}
elseif(!$set_config_error){
	$db_host = ($_REQUEST["action"] != "") ? stripslashes($_REQUEST["db_host"]) : 'localhost';
	$checked = ($_REQUEST["overwrite_tables"]) ? ' checked="true"' : '';
	
	if (count($errors) > 0){
		$output .= '<p>The following errors occurred:</p><ul class="error">';
		
		foreach($errors as $error){
			$output .= '<li>'.$error.'</li>';
		}
		
		$output .= '</ul>';
	}
	
	$output .= '	<input type="hidden" name="action" value="install" />
					<table>
						<tr>
							<td class="formlabel"><label for="db_host">MySQL host:</label></td>
							<td><input type="text" name="db_host" id="db_host" value="'.$db_host.'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="db_user">MySQL Username:</label></td>
							<td><input type="text" name="db_user" id="db_user" value="'.stripslashes($_REQUEST["db_user"]).'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="db_password">MySQL Password:</label></td>
							<td><input type="text" name="db_pass" id="db_pass" value="'.stripslashes($_REQUEST["db_pass"]).'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="db_name">MySQL Database:</label></td>
							<td><input type="text" name="db_name" id="db_name" value="'.stripslashes($_REQUEST["db_name"]).'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="overwrite_tables">Overwrite tables of the same name:</label></td>
							<td><input type="checkbox" name="overwrite_tables" id="overwrite_tables" value="1"'.$checked.' /></td>
						</tr>
						<tr>
							<td class="formlabel"></td>
							<td><input type="submit" name="submit" id="submit" value="Install" /></td>
						</tr>
					</table>';
}

$output .= '</form>';

echo '
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
		<head>
			<title>anyInventory 1.5 Install</title>
			<link rel="stylesheet" type="text/css" href="style.css">
		</head>
		<body>
			<table id="maintable" cellspacing="1" cellpadding="0" border="0">
				<tr>
					<td id="header_cell" style="background-image: url(images/header_bg.jpg); background-color: #000000; background-position: top right; background-repeat: no-repeat;">
						<h1 class="title">anyInventory 1.5</h1>
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
						<h2>Install anyInventory 1.5</h2>
						<p>Welcome to the installation page of anyInventory.  To install, simply fill out the following form.  If there are any errors, such as unexecutable files or incorrect data, you will be notified and ask to fix them before the installation will continue.  After the installation has finished, you will be redirected to the home page of you anyInventory installation.  If you need any help, feel free to contact <a href="mailto:chris@efinke.com">chris@efinke.com</a>.</p>
						'.$output.'
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

?>