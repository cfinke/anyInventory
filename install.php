<?php

// Installation file.

error_reporting(E_ALL ^ E_NOTICE);

require_once("DB.php");
require_once("functions.php");

// Set the text of globals.php
$writetoglobals = '<?php

session_start();

error_reporting(E_ALL ^ E_NOTICE);

$DIR_PREFIX .= "./";

$db_host = "'.$_POST["db_host"].'";
$db_name = "'.$_POST["db_name"].'";
$db_user = "'.$_POST["db_user"].'";
$db_pass = "'.$_POST["db_pass"].'";
$db_type = "'.$_POST["db_type"].'";

require_once($DIR_PREFIX."environment.php");

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
	if (strlen(trim($_POST["db_type"])) == 0){
		$errors[] = 'Please enter the database type.';
	}
	if ($_POST["password_protect_admin"] || $_POST["password_protect_view"]){
		if (strlen(trim($_POST["username"])) == 0){
			$errors[] = 'Please enter a username.';
		}
		if (strlen(trim($_POST["password"])) == 0){
			$errors[] = 'Please enter a password.';
		}
	}
	
	$files_to_read = array("./","./admin","./docs","./barcode","./images");
	
	foreach($files_to_read as $file){
		if (!is_readable(realpath($file))){
			$errors[] = "The path ".realpath($file)." (".$file.") is not readable.";
		}
	}
	
	// Check for the correct database information.	
	if (count($errors) == 0){
		if ($_POST["db_type"] == 'oci8'){
			$dsn = "oci8://".$_POST['db_user'].":".$_POST['db_pass']."@".$_POST['db_name'];
		} else {
			$dsn = $_POST["db_type"]."://".$_POST['db_user'].":".$_POST['db_pass']."@".$_POST['db_host']."/".$_POST['db_name'];
		}
		
		// Establish the connection
		$db = DB::connect($dsn);
		if(DB::isError($db)) $errors[] = 'anyInventory could not connect to the SQL server with the information you provided.';
		else $db->setFetchMode(DB_FETCHMODE_ASSOC);
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
		$query = "DROP TABLE " . $db->quoteIdentifier('anyInventory_categories') . "";
		$db->query($query);
		$query = "DROP TABLE " . $db->quoteIdentifier('anyInventory_fields') . "";
		$db->query($query);
		$query = "DROP TABLE " . $db->quoteIdentifier('anyInventory_items') . "";
		$db->query($query);
		$query = "DROP TABLE " . $db->quoteIdentifier('anyInventory_files') . "";
		$db->query($query);
		$query = "DROP TABLE " . $db->quoteIdentifier('anyInventory_alerts') . "";
		$db->query($query);
		$query = "DROP TABLE " . $db->quoteIdentifier('anyInventory_config') . "";
		$db->query($query);
		$query = "DROP TABLE " . $db->quoteIdentifier('anyInventory_users') . "";
		$db->query($query);
		$query = "DROP TABLE " . $db->quoteIdentifier('anyInventory_values') . "";
		$db->query($query);
		
		$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_categories') . " (
		                  " . $db->quoteIdentifier('id') . " int ,
		                  " . $db->quoteIdentifier('parent') . " int default '0',
		                  " . $db->quoteIdentifier('name') . " varchar(32) default '',
		                  " . $db->quoteIdentifier('auto_inc_field') . " int DEFAULT '0',
		                  CONSTRAINT " . $db->quoteIdentifier('id1') . " UNIQUE (" . $db->quoteIdentifier('id') . ")
		                )";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
        if($_POST['db_type'] == 'oci8'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_fields') . " (
				" . $db->quoteIdentifier('id') . " int ,
				" . $db->quoteIdentifier('name') . " varchar(64) default '',
				" . $db->quoteIdentifier('input_type') . " varchar(30)
				" . "default 'text', 
				" . $db->quoteIdentifier('values') . " VARCHAR(2000),
				" . $db->quoteIdentifier('default_value') . " varchar(32) default '',
				" . $db->quoteIdentifier('size') . " int default '0',
				" . $db->quoteIdentifier('categories') . " VARCHAR(2000),
				" . $db->quoteIdentifier('importance') . " int default '0',
				" . $db->quoteIdentifier('highlight') . " int DEFAULT '0',
				CONSTRAINT " . $db->quoteIdentifier('id2') . " UNIQUE (" . $db->quoteIdentifier('id') . ")
				)";
		}
		else if($_POST['db_type'] == 'mysql'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_fields') . " (
				" . $db->quoteIdentifier('id') . " int ,
				" . $db->quoteIdentifier('name') . " varchar(64) default '',
				" . $db->quoteIdentifier('input_type') . " varchar(30) "
				. "default 'text',
				" . $db->quoteIdentifier('values') . " text,
				" . $db->quoteIdentifier('default_value') . " varchar(32) default '',
				" . $db->quoteIdentifier('size') . " int default '0',
				" . $db->quoteIdentifier('categories') . " text,
				" . $db->quoteIdentifier('importance') . " int default '0',
				" . $db->quoteIdentifier('highlight') . " int DEFAULT '0',
				CONSTRAINT " . $db->quoteIdentifier('id2') . " UNIQUE (" . $db->quoteIdentifier('id') . ")
				)";
		}
		
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if($_POST['db_type'] == 'oci8'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_file_data') . " (
				" . $db->quoteIdentifier('data_id') . " INT,
				" . $db->quoteIdentifier('part_id') . " INT,
				" . $db->quoteIdentifier('data') . " LONG,
				CONSTRAINT " . $db->quoteIdentifier('data_id_part_id'). " UNIQUE (" . $db->quoteIdentifier("data_id") .", " . $db->quoteIdentifier("part_id") . "))";
		}
		elseif($_POST["db_type"] == 'mysql'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_file_data') . " (
				" . $db->quoteIdentifier('data_id') . " INT,
				" . $db->quoteIdentifier('part_id') . " INT,
				" . $db->quoteIdentifier('data') . " LONGTEXT,
				CONSTRAINT " . $db->quoteIdentifier('data_id_part_id'). " UNIQUE (" . $db->quoteIdentifier("data_id") .", " . $db->quoteIdentifier("part_id") . "))";
		}
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_items') . " (
			" . $db->quoteIdentifier('id') . " int ,
			" . $db->quoteIdentifier('item_category') . " int default '0',
			" . $db->quoteIdentifier('name') . " varchar(64) default '',
			CONSTRAINT " . $db->quoteIdentifier('id3') . " UNIQUE (" . $db->quoteIdentifier('id') . ")
			)";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if($_POST['db_type'] == 'oci8'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_values') . " (
				" . $db->quoteIdentifier('item_id') . " int default '0',
				" . $db->quoteIdentifier('field_id') . " int default '0',
				" . $db->quoteIdentifier('value') . " VARCHAR(2000) ,
				CONSTRAINT " . $db->quoteIdentifier('item_id') . " UNIQUE ( " . $db->quoteIdentifier('item_id') . " , " . $db->quoteIdentifier('field_id') . " )
				)";
		}
		else if($_POST['db_type'] == 'mysql'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_values') . " (
				" . $db->quoteIdentifier('item_id') . " int default '0',
				" . $db->quoteIdentifier('field_id') . " int default '0',
				" . $db->quoteIdentifier('value') . " text ,
				CONSTRAINT " . $db->quoteIdentifier('item_id') . " UNIQUE ( " . $db->quoteIdentifier('item_id') . " , " . $db->quoteIdentifier('field_id') . " )                                           )";
		}
		
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_files') . " (
			" . $db->quoteIdentifier('id') . " INT  ,
			" . $db->quoteIdentifier('key') . " INT ,
			" . $db->quoteIdentifier('file_name') . " VARCHAR( 255 ) ,
			" . $db->quoteIdentifier('file_size') . " INT ,
			" . $db->quoteIdentifier('file_type') . " VARCHAR( 32 ) ,
			" . $db->quoteIdentifier('offsite_link') . " VARCHAR( 255 ),
			CONSTRAINT " . $db->quoteIdentifier('id4') . " UNIQUE (" . $db->quoteIdentifier('id') . "))";	
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if($_POST['db_type'] == 'oci8'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_alerts') . " (
				" . $db->quoteIdentifier('id') . " int  ,
				" . $db->quoteIdentifier('item_ids') . " VARCHAR(2000) ,
				" . $db->quoteIdentifier('title') . " varchar( 255 ) default '',
				" . $db->quoteIdentifier('field_id') . " int default '0',
				" . $db->quoteIdentifier('condition') .
				" varchar(32) default '==',
				" . $db->quoteIdentifier('value') . " varchar( 255 ) default '',
				" . $db->quoteIdentifier('modified') . " timestamp ,
				" . $db->quoteIdentifier('time') . " timestamp ,
				" . $db->quoteIdentifier('expire_time') . " timestamp ,
				" . $db->quoteIdentifier('timed') . " int DEFAULT '0',
				" . $db->quoteIdentifier('category_ids') . " VARCHAR(2000),
				CONSTRAINT " . $db->quoteIdentifier('id5') . " UNIQUE ( " . $db->quoteIdentifier('id') . " )
				)";
		}
		else if($_POST['db_type'] == 'mysql'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_alerts') . " (
				" . $db->quoteIdentifier('id') . " int  ,
				" . $db->quoteIdentifier('item_ids') . "text ,
				" . $db->quoteIdentifier('title') . " varchar( 255 ) default '',
				" . $db->quoteIdentifier('field_id') . " int default '0',
				" . $db->quoteIdentifier('condition') .
				" varchar(32) default '==',
				" . $db->quoteIdentifier('value') . " varchar( 255 ) default '',
				" . $db->quoteIdentifier('modified') . " timestamp ,
				" . $db->quoteIdentifier('time') . " timestamp ,
				" . $db->quoteIdentifier('expire_time') . " timestamp ,
				" . $db->quoteIdentifier('timed') . " int DEFAULT '0',
				" . $db->quoteIdentifier('category_ids') . " text,
				CONSTRAINT " . $db->quoteIdentifier('id5') . " UNIQUE ( " . $db->quoteIdentifier('id') . " )
				)";	
		}
		
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if($_POST['db_type'] == 'oci8'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_users') . " (
				" . $db->quoteIdentifier('id') . " int  ,
				" . $db->quoteIdentifier('username') . " varchar(32) default '',
				" . $db->quoteIdentifier('password') . " varchar(255) default '',
				" . $db->quoteIdentifier('usertype') .
				" varchar(32) default 'User',
				" . $db->quoteIdentifier('categories_view') . " VARCHAR(2000) ,
				" . $db->quoteIdentifier('categories_admin') . " VARCHAR(2000) ,
				CONSTRAINT " . $db->quoteIdentifier('id6') . " UNIQUE ( " . $db->quoteIdentifier('id') . " ),
				CONSTRAINT " . $db->quoteIdentifier('username') . " UNIQUE (" . $db->quoteIdentifier('username') . ")
				)";
		}
		else if($_POST['db_type'] == 'mysql'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_users') . " (
				" . $db->quoteIdentifier('id') . " int  ,
				" . $db->quoteIdentifier('username') . " varchar(32) default '',
				" . $db->quoteIdentifier('password') . " varchar(255) default '',
				" . $db->quoteIdentifier('usertype') .
				" varchar(32) default 'User',
				" . $db->quoteIdentifier('categories_view') . " text ,
				" . $db->quoteIdentifier('categories_admin') . " text ,
				CONSTRAINT " . $db->quoteIdentifier('id6') . " UNIQUE ( " . $db->quoteIdentifier('id') . " ),
				CONSTRAINT " . $db->quoteIdentifier('username') . " UNIQUE (" . $db->quoteIdentifier('username') . ")
				)";
		}
		
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if($_POST['db_type'] == 'oci8'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_config') . " (
				" . $db->quoteIdentifier('key') . " varchar( 64 ) default '',
				" . $db->quoteIdentifier('value') . " VARCHAR(2000) ,
				CONSTRAINT " . $db->quoteIdentifier('key') . " UNIQUE ( " . $db->quoteIdentifier('key') . " )
				)";
		}
		else if($_POST['db_type'] == 'mysql'){
			$query = "CREATE TABLE " . $db->quoteIdentifier('anyInventory_config') . " (
				" . $db->quoteIdentifier('key') . " varchar( 64 ) default '',
				" . $db->quoteIdentifier('value') . " text ,
				CONSTRAINT " . $db->quoteIdentifier('key') . " UNIQUE ( " . $db->quoteIdentifier('key') . " )
				)";
		}
		
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('AUTO_INC_FIELD_NAME', 'anyInventory ID')";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('FRONT_PAGE_TEXT', 'This is the front page and top-level category of anyInventory.  You can <a href=\"docs/".$_POST["lang"]."\/\">read the documentation</a> for instructions on using anyInventory, or you can navigate the inventory by clicking on any of the subcategories below; any items in a category will appear below the subcategories.  You can tell where you are in the inventory by the breadcrumb links at the top of each category page.anyInventory ID.')";	
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('LANG', '". $_POST['lang'] ."')";	
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('PP_VIEW', '".intval(($_POST['password_protect_view'] == 'yes'))."')";		
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('PP_ADMIN', '".intval(($_POST['password_protect_admin'] == 'yes'))."')";	
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('ITEM_VIEW', 'list')";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('BAR_TEMPLATE', '6')";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('LABEL_PADDING', '12')";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('PAD_CHAR','0')";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('BARCODE','C128C')";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$blank = array();
		
		$_POST["username"] = ($_POST["username"] == '') ? 'username' : $_POST["username"];
		$_POST["password"] = ($_POST["password"] == '') ? 'password' : $_POST["password"];
		$admin_user_id = nextId('users');
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_users') . " (" . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('username') . "," . $db->quoteIdentifier('password') . "," . $db->quoteIdentifier('usertype') . "," . $db->quoteIdentifier('categories_admin') . "," . $db->quoteIdentifier('categories_view') . ") VALUES ('" .$admin_user_id. "', '" . $_POST["username"] . "', '". md5($_POST["password"]). "' , 'Administrator', '". serialize($blank). "', '" .serialize($blank). "')";	
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery); 
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES ('ADMIN_USER_ID', '".$admin_user_id."')";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_config') . " (" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('value') . ") VALUES (''NAME_FIELD_NAME', '".NAME."')";	
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
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
				<input type="hidden" name="db_type" value="'.stripslashes($_POST["db_type"]).'" />
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
				<input type="hidden" name="db_type" value="'.stripslashes($_POST["db_type"]).'" />
				<input type="hidden" name="db_host" value="'.stripslashes($_POST["db_host"]).'" />
				<input type="hidden" name="db_user" value="'.stripslashes($_POST["db_user"]).'" />
				<input type="hidden" name="db_pass" value="'.stripslashes($_POST["db_pass"]).'" />
				<input type="hidden" name="db_name" value="'.stripslashes($_POST["db_name"]).'" />
				<input type="hidden" name="db_type" value="'.stripslashes($_POST["db_type"]).'" />
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
					        <td class="form_label"><label for="db_type">Database Type:</label></td>
					        <td class="form_input">
								<select name="db_type" id="db_type">
									<option value="mysql"';if($_REQUEST["db_type"] == 'mysql') $output .= ' selected="selected"'; $output .= '>MySQL</option>
									<option value="oci8"';if($_REQUEST["db_type"] == 'oci8') $output .= ' selected="selected"'; $output .= '>Oracle</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label"><label for="db_host">Database host:</label></td>
							<td class="form_input"><input type="text" name="db_host" id="db_host" value="'.$db_host.'" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="db_user">Database Username:</label></td>
							<td class="form_input"><input type="text" name="db_user" id="db_user" value="'.stripslashes($_POST["db_user"]).'" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="db_password">Database Password:</label></td>
							<td class="form_input"><input type="text" name="db_pass" id="db_pass" value="'.stripslashes($_POST["db_pass"]).'" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="db_name">Database Name:</label></td>
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
		<title>Install anyInventory 2.0</title>
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
					anyInventory 2.0
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
								<td>Install anyInventory 2.0</td>
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
