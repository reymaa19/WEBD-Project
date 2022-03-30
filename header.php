<?php
/**
 *		header
 *		Name: Reynald Maala
 *		Date: March 30, 2022
 *		Description: The header for every page. */ 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">    
    <title>WEBD Project</title>
    <!-- <link rel="stylesheet" href="styles.css" type="text/css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Gothic+A1&display=swap" rel="stylesheet"> 
</head>
<body>
    <header>
        <nav>
            <h1><a href="dashboard.php">Reynald Lawncare and Snow Removal</a></h1>
            <a href="create.php">Create Request</a>
            <a href="create_account.php">Register</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <?php get_message(); ?>