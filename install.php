<?php

// Installation file.

error_reporting(E_ALL ^ E_NOTICE);

include("functions.php");

// Set the text of globals.php
$writetoglobals = '<?php

session_start();

error_reporting(E_ALL ^ E_NOTICE);

$DIR_PREFIX .= "./";

$db_host = "'.$_POST["db_host"].'";
$db_name = "'.$_POST["db_name"].'";
$db_user = "'.$_POST["db_user"].'";
$db_pass = "'.$_POST["db_pass"].'";

include($DIR_PREFIX."environment.php");

?>';

$output .= '<form action="'.$_SERVER["PHP_SELF"].'" method="post">';

if ($_POST["action"] == "install"){
	// First, check for missing data.
	if (strlen(trim($_POST["db_host"])) == 0){
		$errors[] = 'Please enter the name of your MySQL host.';
	}
	if (strlen(trim($_POST["db_user"])) == 0){
		$errors[] = 'Please enter the MySQL username.';
	}
	if (strlen(trim($_POST["db_name"])) == 0){
		$errors[] = 'Please enter the MySQL database name.';
	}
	if (strlen(trim($_POST["db_pass"])) == 0){
		$errors[] = 'Please enter the MySQL password.';
	}
	if ($_POST["password_protect_admin"] || $_POST["password_protect_view"]){
		if (strlen(trim($_POST["username"])) == 0){
			$errors[] = 'Please enter a username.';
		}
		if (strlen(trim($_POST["password"])) == 0){
			$errors[] = 'Please enter a password.';
		}
	}
	
	$files_to_read = array("./","./admin","./docs","./docs/en","./images","./fonts","./item_files");
	
	foreach($files_to_read as $file){
		if (!is_readable(realpath($file))){
			$errors[] = "The path ".realpath($file)." (".$file.") is not readable.";
		}
	}
	
	if (!is_writable(realpath("./item_files/"))){
		$errors[] = 'The path '.realpath("./item_files/").' is not writable by the Web server.';
	}
	
	// Check for the correct database information.	
	if (count($errors) == 0){
		if(!@mysql_connect($_POST["db_host"],$_POST["db_user"],$_POST["db_pass"])){
			$errors[] = 'anyInventory could not connect to the MySQL host with the information you provided.';
		}
		elseif(!mysql_select_db($_POST["db_name"])){
			$errors[] = 'anyInventory connected to the MySQL host, but could not find the database '.$_POST["db_name"].'.';
		}
	}
	
	// Try to write the globals.php file.
	if (count($errors) == 0){
		// Open the file for writing.
		$handle = @fopen(realpath("./globals.php"),"w");
		
		if ($handle){
			fwrite($handle, $writetoglobals);
			fclose($handle);
		}
		else{
			// Try chmodding the file.
			@chmod(realpath("./globals.php"), 0666);
			
			$handle = @fopen(realpath("./globals.php"),"w");
			
			if ($handle){
				fwrite($handle, $writetoglobals);
				fclose($handle);
			}
			else{
				$config_errors[] = "anyInventory could not write the globals.php file.  Either make this file writable by the Web server and click 'Try Again', or replace the contents of the current globals.php file with the following code:<br /><pre>" . htmlentities($writetoglobals) . "</pre>If you choose to overwrite the file manually, do so, and then delete the install.php file.  Don't forget to change the permissions back on globals.php after you overwrite it.";
			}
		}
		
		// Begin writing the database information.
		$query = "DROP TABLE `anyInventory_categories` ,
			`anyInventory_fields`,
			`anyInventory_items`,
			`anyInventory_files`,
			`anyInventory_alerts`,
			`anyInventory_config`,
			`anyInventory_users`,
			`anyInventory_values`";
		@mysql_query($query);
		
		$query = "CREATE TABLE `anyInventory_categories` (
				  `id` int(11) NOT NULL auto_increment,
				  `parent` int(11) NOT NULL default '0',
				  `name` varchar(32) NOT NULL default '',
			 	  `auto_inc_field` TINYINT( 1 ) DEFAULT '0' NOT NULL,
				  UNIQUE KEY `id` (`id`),
				  KEY `parent` (`parent`)
				)";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "CREATE TABLE `anyInventory_fields` (
				  `id` int(11) NOT NULL auto_increment,
				  `name` varchar(64) NOT NULL default '',
				  `input_type` enum('text','textarea','checkbox','radio','select','multiple','file','divider','item') NOT NULL default 'text',
				  `values` text NOT NULL,
				  `default_value` varchar(32) NOT NULL default '',
				  `size` int(11) NOT NULL default '0',
				  `categories` text NOT NULL,
				  `importance` int(11) NOT NULL default '0',
				  `highlight` TINYINT( 1 ) DEFAULT '0' NOT NULL,
				  UNIQUE KEY `id` (`id`)
				)";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "CREATE TABLE `anyInventory_items` (
				  `id` int(11) NOT NULL auto_increment,
				  `item_category` int(11) NOT NULL default '0',
				  `name` varchar(64) NOT NULL default '',
				  UNIQUE KEY `id` (`id`)
				)";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "CREATE TABLE `anyInventory_values` (
					`item_id` int( 11 ) NOT NULL default '0',
					`field_id` int( 11 ) NOT NULL default '0',
					`value` text NOT NULL ,
					UNIQUE KEY `item_id` ( `item_id` , `field_id` )
					)";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
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
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "CREATE TABLE `anyInventory_alerts` (
					`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
					`item_ids` text NOT NULL ,
					`title` varchar( 255 ) NOT NULL default '',
					`field_id` int( 11 ) NOT NULL default '0',
					`condition` enum( '==', '!=', '<', '>', '<=', '>=' ) NOT NULL default '==',
					`value` varchar( 255 ) NOT NULL default '',
					`modified` timestamp( 14 ) NOT NULL ,
					`time` timestamp( 14 ) NOT NULL ,
					`expire_time` timestamp( 14 ) NOT NULL ,
				 	`timed` TINYINT( 1 ) DEFAULT '0' NOT NULL,
					`category_ids` TEXT NOT NULL,
					UNIQUE KEY `id` ( `id` )
					)";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "CREATE TABLE `anyInventory_users` (
					`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
					`username` varchar(32) NOT NULL default '',
					`password` varchar(32) NOT NULL default '',
					`usertype` ENUM( 'User', 'Administrator' ) DEFAULT 'User' NOT NULL,
					`categories_view` text NOT NULL ,
					`categories_admin` text NOT NULL ,
					UNIQUE KEY `id` ( `id` ),
					UNIQUE KEY `username` (`username`)
					)";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "CREATE TABLE `anyInventory_config` (
					`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
					`key` varchar( 64 ) NOT NULL default '',
					`value` text NOT NULL ,
					UNIQUE KEY `id` ( `id` ),
					UNIQUE KEY `key` ( `key` )
					)";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO `anyInventory_config` (`key`,`value`) VALUES ('AUTO_INC_FIELD_NAME','anyInventory ID')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO `anyInventory_config` (`key`,`value`) VALUES ('FRONT_PAGE_TEXT','This is the front page and top-level category of anyInventory.  You can <a href=\"docs/".$_REQUEST["lang"]."\">read the documentation</a> for instructions on using anyInventory, or you can navigate the inventory by clicking on any of the subcategories below; any items in a category will appear below the subcategories.  You can tell where you are in the inventory by the breadcrumb links at the top of each category page.')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO `anyInventory_config` (`key`,`value`) VALUES ('LANG','".$_REQUEST["lang"]."')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO `anyInventory_config` (`key`,`value`) VALUES ('PP_VIEW','".(((int) ($_POST["password_protect_view"] == "yes")) / 1)."')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO `anyInventory_config` (`key`,`value`) VALUES ('PP_ADMIN','".(((int) ($_POST["password_protect_admin"] == "yes")) / 1)."')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO `anyInventory_config` (`key`,`value`) VALUES ('ITEM_VIEW','list')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$blank = array();
		
		$_POST["username"] = ($_POST["username"] == '') ? 'username' : $_POST["username"];
		$_POST["password"] = ($_POST["password"] == '') ? 'password' : $_POST["password"];
		
		$query = "INSERT INTO `anyInventory_users`
					(`username`,
					 `password`,
					 `usertype`,
					 `categories_admin`,
					 `categories_view`)
					VALUES
					('".$_POST["username"]."',
					 '".md5($_POST["password"])."',
					 'Administrator',
					 '".addslashes(serialize($blank))."',
					 '".addslashes(serialize($blank))."')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO `anyInventory_config` (`key`,`value`) VALUES ('ADMIN_USER_ID','".mysql_insert_id()."')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO `anyInventory_config` (`key`,`value`) VALUES ('NAME_FIELD_NAME','Name')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO `anyInventory_config` (`key`, `value`) VALUES ('BAR_TEMPLATE', '6')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);

		$query = "INSERT INTO `anyInventory_config` (`key`, `value`) VALUES ('LABEL_PADDING', '12')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);

		$query = "INSERT INTO `anyInventory_config` (`key`, `value`) VALUES ('PAD_CHAR','0')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);

		$query = "INSERT INTO `anyInventory_config` (`key`, `value`) VALUES ('BARCODE','C128C')";
		mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if (count($config_errors) == 0){
			header("Location: ./index.php");
			exit;
		}
		else{
			$set_config_error = true;
			
			// Display the config error information
			
			$output .= '
				<input type="hidden" name="action" value="try_again" />
				<input type="hidden" name="lang" value="'.$_REQUEST["lang"].'" />
				<input type="hidden" name="db_host" value="'.stripslashes($_POST["db_host"]).'" />
				<input type="hidden" name="db_user" value="'.stripslashes($_POST["db_user"]).'" />
				<input type="hidden" name="db_pass" value="'.stripslashes($_POST["db_pass"]).'" />
				<input type="hidden" name="db_name" value="'.stripslashes($_POST["db_name"]).'" />
				<input type="hidden" name="password_protect_view" value="'.stripslashes($_POST["password_protect_view"]).'" />
				<input type="hidden" name="password_protect_admin" value="'.stripslashes($_POST["password_protect_admin"]).'" />
				<input type="hidden" name="username" value="'.stripslashes($_POST["username"]).'" />
				<input type="hidden" name="password" value="'.stripslashes($_POST["password"]).'" />
				<p>The following errors occurred:</p><ul class="error">';
			
			foreach($config_errors as $error){
				$output .= '<li>'.$error.'</li>';
			}
			
			$output .= '</ul>
						<table>
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" value="Try Again" /></td>
							</tr>
						</table>';
		}
	}
}

if($_POST["action"] == "try_again"){
	// The user has done the database setup, but the globals.php file has not been written.
	$handle = @fopen(realpath("./globals.php"),"w");
	if ($handle){
		fwrite($handle, $writetoglobals);
		fclose($handle);
	}
	else{
		@chmod(realpath("./globals.php"), 0666);
		
		$handle = @fopen(realpath("./globals.php"),"w");
		
		if ($handle){
			fwrite($handle, $writetoglobals);
			fclose($handle);
		}
		else{
			$config_errors[] = "anyInventory could not write the globals.php file.  Either make this file writable by the Web server and click 'Try Again', or replace the contents of the current globals.php file with the following code:<br /><pre>" . htmlentities($writetoglobals) . "</pre>If you choose to overwrite the file manually, do so, and then delete the install.php file.  Don't forget to change the permissions back on globals.php after you overwrite it.";
		}
	}
	
	if (count($config_errors) == 0){
		header("Location: index.php");
		exit;
	}
	else{
		$output .= '
				<input type="hidden" name="action" value="try_again" />
				<input type="hidden" name="lang" value="'.$_REQUEST["lang"].'" />
				<input type="hidden" name="db_host" value="'.stripslashes($_POST["db_host"]).'" />
				<input type="hidden" name="db_user" value="'.stripslashes($_POST["db_user"]).'" />
				<input type="hidden" name="db_pass" value="'.stripslashes($_POST["db_pass"]).'" />
				<input type="hidden" name="db_name" value="'.stripslashes($_POST["db_name"]).'" />
				<input type="hidden" name="password_protect_view" value="'.stripslashes($_POST["password_protect_view"]).'" />
				<input type="hidden" name="password_protect_admin" value="'.stripslashes($_POST["password_protect_admin"]).'" />
				<input type="hidden" name="username" value="'.stripslashes($_POST["username"]).'" />
				<input type="hidden" name="password" value="'.stripslashes($_POST["password"]).'" />
				<p>The following errors occurred:</p><ul class="error">';
		
		foreach($config_errors as $error){
			$output .= '<li>'.$error.'</li>';
		}
		
		$output .= '</ul>
					<table>
						<tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" value="Try Again" /></td>
						</tr>
					</table>';
	}
}
elseif(!$set_config_error){
	$db_host = ($_POST["action"] != "") ? stripslashes($_POST["db_host"]) : 'localhost';
	$pp_view_checked = ($_POST["password_protect_view"]) ? ' checked="true"' : '';
	$pp_admin_checked = ($_POST["password_protect_admin"]) ? ' checked="true"' : '';
	$inBodyTag = ' onload="toggle();"';
	if (!isset($_REQUEST["lang"])) $_REQUEST["lang"] = "en";
		
	if (count($errors) > 0){
		$output .= '<p>The following errors occurred:</p><ul class="error">';
		
		foreach($errors as $error){
			$output .= '<li>'.$error.'</li>';
		}
		
		$output .= '</ul>';
	}
	
	$output .= '	<input type="hidden" name="action" value="install" />
					<table>
						<tr class="tableHeader">
							<td colspan="2">
								Language
							</td>
						</tr>
						<tr>
							<td class="form_label"><label for="db_host">Language:</label></td>
							<td class="form_input">
								<select name="lang" id="lang">
									<option value="de"';if($_REQUEST["lang"] == "de") $output .= ' selected="selected"'; $output .= '>Deutsch</option>
									<option value="en"';if($_REQUEST["lang"] == "en") $output .= ' selected="selected"'; $output .= '>English</option>
									<option value="es"';if($_REQUEST["lang"] == "es") $output .= ' selected="selected"'; $output .= '>Espa&ntilde;ol</option>
									<option value="fr"';if($_REQUEST["lang"] == "fr") $output .= ' selected="selected"'; $output .= '>Fran&ccedil;ais</option>
								</select>
							</td>
						</tr>
						<tr class="tableHeader">
							<td colspan="2">
								Database
							</td>
						</tr>
						<tr>
							<td class="form_label"><label for="db_host">MySQL host:</label></td>
							<td class="form_input"><input type="text" name="db_host" id="db_host" value="'.$db_host.'" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="db_user">MySQL Username:</label></td>
							<td class="form_input"><input type="text" name="db_user" id="db_user" value="'.stripslashes($_POST["db_user"]).'" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="db_password">MySQL Password:</label></td>
							<td class="form_input"><input type="text" name="db_pass" id="db_pass" value="'.stripslashes($_POST["db_pass"]).'" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="db_name">MySQL Database:</label></td>
							<td class="form_input"><input type="text" name="db_name" id="db_name" value="'.stripslashes($_POST["db_name"]).'" /></td>
						</tr>
						<tr class="tableHeader">
							<td colspan="2">
								Password Protection
							</td>
						</tr>
						<tr>
							<td class="form_label"><input onclick="toggle();" type="checkbox" name="password_protect_view" id="password_protect_view" value="yes"'.$pp_view_checked.' /></td>
							<td class="form_input"><label for="password_protect">Password protect entire inventory</label></td>
						</tr>
						<tr>
							<td class="form_label"><input onclick="toggle();" type="checkbox" name="password_protect_admin" id="password_protect_admin" value="yes"'.$pp_admin_checked.' /></td>
							<td class="form_input"><label for="password_protect">Password protect admin directory</label></td>
						</tr>
						<tr>
							<td class="form_label"><label for="username">Username:</label></td>
							<td class="form_input"><input type="text" name="username" id="username" value="'.stripslashes($_POST["username"]).'" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="password">Password:</label></td>
							<td class="form_input"><input type="text" name="password" id="password" value="'.stripslashes($_POST["password"]).'" /></td>
						</tr>
						<tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="Install" /></td>
						</tr>
					</table>';
}

$output .= '</form>';

echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Install anyInventory 1.9.3</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		'.$inHead.'
		<script type="text/javascript">
			<!--
			
			function toggle(){
				document.getElementById(\'username\').disabled = !(document.getElementById(\'password_protect_view\').checked || document.getElementById(\'password_protect_admin\').checked);
				document.getElementById(\'password\').disabled = !(document.getElementById(\'password_protect_view\').checked || document.getElementById(\'password_protect_admin\').checked);
				
				document.getElementById(\'password_protect_admin\').checked = (document.getElementById(\'password_protect_view\').checked || document.getElementById(\'password_protect_admin\').checked);
			}
			
			// -->
		</script>
	</head>
	<body'.$inBodyTag.'>
		<table style="width: 99%; margin: 5px; background-color: #ffffff;" cellspacing="0">
			<tr>
				<td id="appTitle">
					anyInventory 1.9.3
				</td>
			</tr>
			<tr>
				<td id="mainMenu">
					<table style="width: 100%;">
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<div style="min-height: 400px;">
						<table class="standardTable" cellspacing="0">
							<tr class="tableHeader">
								<td>Install anyInventory 1.9.3</td>
							</tr>
							<tr>
								<td class="tableData">
									<p>Welcome to the installation page of anyInventory.  To install, simply fill out the following form.  If there are any errors, such as unexecutable files or incorrect data, you will be notified and ask to fix them before the installation will continue.  After the installation has finished, you will be redirected to the home page of your anyInventory installation.  If you need any help, feel free to contact <a href="mailto:chris@efinke.com">chris@efinke.com</a>.</p>
									'.$output.'
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			<tr class="footerCell">
				<td>
					<a href="http://anyinventory.sourceforge.net/">anyInventory, the most flexible and powerful web-based inventory system</a>
				</td>
			</tr>
		</table>
	</body>
</html>';

?>