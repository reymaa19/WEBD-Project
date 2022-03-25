<?php
/**
 *		authenticate
 *		Name: Reynald Maala
 *		Date: March 24, 2022
 *		Description: For authenticating for high access. */ 

	define('ADMIN_LOGIN','Hello');
	define('ADMIN_PASSWORD','World!');
	if (!isset($_SERVER['PHP_AUTH_USER']) 
		|| !isset($_SERVER['PHP_AUTH_PW'])
		|| ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)
		|| ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) 
	{
		header('HTTP/1.1 401 Unauthorized');
		header('WWW-Authenticate: Basic realm="Our Blog"');
		exit("Access Denied: Username and password required.");
	}
?>