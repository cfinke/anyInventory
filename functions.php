<?php

function connect_to_database(){
	global $db_host;
	global $db_name;
	global $db_user;
	global $db_pass;
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($db_name, $link);
	
	return $link;
}

function query($query){
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	return $result;
}

function fetch_array($result){
	$row = mysql_fetch_array($result);
	
	return $row;
}

function num_rows($result){
	return mysql_num_rows($result);
}

function result($result, $row, $field){
	return mysql_result($result, $row, $field);
}

function insert_id(){
	return mysql_insert_id();
}

?>