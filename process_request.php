<?php 
/**
 *		process_post
 *		Name: Reynald Maala
 *		Date: March 30, 2022
 *		Description: For process validating of request creations. */ 

	require('connect.php');
    require('authenticate.php');
	require('functions\request_functions.php');

	if (check_inputs() == "") {
		if ($_POST['command'] == 'Create') 
		{
			create_request($db);
		}
		elseif ($_POST['command'] == 'Update')
		{
			update_request($db);
		}
	}

	if ($_POST['command'] == 'Delete')
	{
		delete_request($db);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Process Post</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Gothic+A1&display=swap" rel="stylesheet"> 
</head>
<body>
	<header>
		<div>
			<h1><a href="index.php">Reynald Lawncare and Snow Removal</a></h1>
		</div>
		<nav>
			<a href="create.php">Create Request</a>
		</nav>
	</header>
	<table>
</table>
	<div id="wrapper">
		<main>
			<h2>An error occured while processing your post.</h2>
			<br>
			<p><?= check_inputs() ?></p>
			<br>
			<a href="index.php"><strong>Return Home</strong></a>
		</main>
	</div>
</body>
</html>