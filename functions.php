<?php 
	
	require_once("User.class.php");
	require_once("../config_global.php");
	
	
	$database = "if15_hendrik7";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	$User = new User($mysqli);
	
	
?>	