<?php

// Installation file.

error_reporting(E_ALL ^ E_NOTICE);

include("functions.php");

$writetoglobals = '<?php

error_reporting(E_ALL ^ E_NOTICE);

$db_host = "'.$_REQUEST["db_host"].'";
$db_name = "'.$_REQUEST["db_name"].'";
$db_user = "'.$_REQUEST["db_user"].'";
$db_pass = "'.$_REQUEST["db_pass"].'";

$files_dir = "'.$_REQUEST["files_dir"].'";

include("functions.php");
include("category_class.php");
include("field_class.php");
include("item_class.php");
include("file_class.php");
include("dataset_library.php");

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
	if (strlen(trim($_REQUEST["files_dir"])) == 0){
		$errors[] = 'Please enter the full path of the directory where uploaded files will be stored.';
	}
	
	if (count($errors) == 0){
		if(!@mysql_connect($_REQUEST["db_host"],$_REQUEST["db_user"],$_REQUEST["db_pass"])){
			$errors[] = 'anyInventory could not connect to the MySQL host with the information you provided.';
		}
		elseif(!mysql_select_db($_REQUEST["db_name"])){
			$errors[] = 'anyInventory connected to the MySQL host, but could not find the database '.$_REQUEST["db_name"].'.';
		}
		else{
			if (!$_REQUEST["overwrite_tables"]){
				$tables = array("anyInventory_items","anyInventory_categories","anyInventory_fields","anyInventory_files");
				
				foreach ($tables as $table){
					$query = "SHOW TABLES LIKE '".$table."'";
					$result = mysql_query($query) or die(mysql_error() . '<br />' .$query);
					
					if (mysql_num_rows($result) > 0){
						$errors[] = "The table `".$table."` already exists in the MySQL database ".$_REQUEST["db_name"].".";
					}
				}
			}
		}
	}
	
	if (count($errors) == 0){
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
	}
	
	if (count($errors) == 0){
			$query = "DROP TABLE `anyInventory_categories` ,
			`anyInventory_fields` ,
			`anyInventory_items` ,
			`anyInventory_files`";
		$result = @mysql_query($query);
		
		$query = "CREATE TABLE `anyInventory_categories` (
				  `id` int(11) NOT NULL auto_increment,
				  `parent` int(11) NOT NULL default '0',
				  `name` varchar(32) NOT NULL default '',
				  UNIQUE KEY `id` (`id`),
				  KEY `parent` (`parent`)
				) TYPE=MyISAM";
		$result = mysql_query($query) or die(mysql_error() . '<br />'.$query);
		
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
		$result = mysql_query($query) or die(mysql_error() . '<br />'.$query);
		
		$query = "CREATE TABLE `anyInventory_items` (
				  `id` int(11) NOT NULL auto_increment,
				  `item_category` int(11) NOT NULL default '0',
				  `name` varchar(64) NOT NULL default '',
				  UNIQUE KEY `id` (`id`)
				) TYPE=MyISAM";
		$result = mysql_query($query) or die(mysql_error() . '<br />'.$query);
		
		$query = "CREATE TABLE `anyInventory_files` (
					`id` INT NOT NULL AUTO_INCREMENT ,
					`key` INT NOT NULL ,
					`file_name` VARCHAR( 255 ) NOT NULL ,
					`file_size` INT NOT NULL ,
					`file_type` VARCHAR( 32 ) NOT NULL ,
					UNIQUE (
						`id`
					)
				)";
		$result = mysql_query($query) or die(mysql_error() . '<br />'.$query);
		
		if (count($config_errors) == 0){
			if (is_file($_SERVER["DOCUMENT_ROOT"].$_SERVER["PHP_SELF"])) @unlink($_SERVER["DOCUMENT_ROOT"].$_SERVER["PHP_SELF"]);
			
			header("Location: index.php");
		}
		else{
			$set_config_error = true;
			
			$output .= '
				<input type="hidden" name="action" value="try_again" />
				<input type="hidden" name="db_host" value="'.stripslashes($_REQUEST["db_host"]).'" />
				<input type="hidden" name="db_user" value="'.stripslashes($_REQUEST["db_user"]).'" />
				<input type="hidden" name="db_pass" value="'.stripslashes($_REQUEST["db_pass"]).'" />
				<input type="hidden" name="db_name" value="'.stripslashes($_REQUEST["db_name"]).'" />
				<input type="hidden" name="files_dir" value="'.stripslashes($_REQUEST["files_dir"]).'" />
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
		if (is_file($_SERVER["DOCUMENT_ROOT"].$_SERVER["PHP_SELF"])) @unlink($_SERVER["DOCUMENT_ROOT"].$_SERVER["PHP_SELF"]);
		
		header("Location: index.php");
	}
	else{
		$output .= '
				<input type="hidden" name="action" value="try_again" />
				<input type="hidden" name="db_host" value="'.stripslashes($_REQUEST["db_host"]).'" />
				<input type="hidden" name="db_user" value="'.stripslashes($_REQUEST["db_user"]).'" />
				<input type="hidden" name="db_pass" value="'.stripslashes($_REQUEST["db_pass"]).'" />
				<input type="hidden" name="db_name" value="'.stripslashes($_REQUEST["db_name"]).'" />
				<input type="hidden" name="files_dir" value="'.stripslashes($_REQUEST["files_dir"]).'" />
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
	$files_dir = ($_REQUEST["action"] != "") ? stripslashes($_REQUEST["files_dir"]) : $_SERVER["DOCUMENT_ROOT"].str_replace("install.php","",$_SERVER["PHP_SELF"]);
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
							<td class="formlabel"><label for="database_host">MySQL host:</label></td>
							<td><input type="text" name="db_host" id="db_host" value="'.$db_host.'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="database_user">MySQL Username:</label></td>
							<td><input type="text" name="db_user" id="db_user" value="'.stripslashes($_REQUEST["db_user"]).'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="database_password">MySQL Password:</label></td>
							<td><input type="text" name="db_pass" id="db_pass" value="'.stripslashes($_REQUEST["db_pass"]).'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="database_name">MySQL Database:</label></td>
							<td><input type="text" name="db_name" id="db_name" value="'.stripslashes($_REQUEST["db_name"]).'" /></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="directory"><i>Full Path</i> to Toby Installation Directory:</label></td>
							<td><input type="text" name="files_dir" id="files_dir" value="'.$files_dir.'" /></td>
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

display($output);

?>