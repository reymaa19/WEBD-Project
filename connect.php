<?php
/**
 *		connect
 *		Name: Reynald Maala
 *		Date: March 24, 2022
 *		Description: For connecting to database. */ 

    define('DB_DSN','mysql:host=localhost;dbname=project;charset=utf8');
    define('DB_USER','admin');
    define('DB_PASS','123321');     

    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die();
    }
?>