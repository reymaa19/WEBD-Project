<?php 
/**
 *		process_post
 *		Name: Reynald Maala
 *		Date: March 24, 2022
 *		Description: For process validating of request creations. */ 

	require('connect.php');

	if ($_POST['command'] == 'Delete')
	{
		$id = $_POST['id'];
		$query = "DELETE FROM requests WHERE request_id='$id'";

		$statement = $db->prepare($query);

		if ($statement->execute()) 
		{
			header('Location: index.php');
			exit();
		}
	}

	function check_inputs() {
		$message = "";
		if (empty($_POST['title'])) 
			$message .= "The title must be at least one character.";
		if (empty($_POST['description']))
			$message .= "<br>The description must be at least one character.";
		if (empty($_POST['service_type'])) 
			$message .= "<br>A service must be selected.";
		if (empty($_POST['start_date'])) 
			$message .= "<br>A date and time must be selected.";
		return $message;
	}

	if (check_inputs() == "") {
		if ($_POST['command'] == 'Create') 
		{
			$title = $_POST['title'];
			$service_type = $_POST['service_type'];
			$description = $_POST['description'];
			$start_date = $_POST['start_date'];
	
			$query = "INSERT INTO requests (title, service_type, description, start_date) 
									VALUES (:title, :service_type, :description, :start_date)";
	
			$statement = $db->prepare($query);
			$statement->bindValue(':title', $title);
			$statement->bindValue(':service_type', $service_type);
			$statement->bindValue(':description', $description);
			$statement->bindValue(':start_date', $start_date);
	
			if ($statement->execute()) 
			{
				header('Location: index.php');
				exit();
			}
		}
		elseif ($_POST['command'] == 'Update')
		{
			$title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
			
			$query     = "UPDATE posts SET title = :title, content = :content WHERE id = :id";
			$statement = $db->prepare($query);
			$statement->bindValue(':title', $title);        
			$statement->bindValue(':content', $content);
			$statement->bindValue(':id', $id, PDO::PARAM_INT);
			
			$statement->execute();
			
			header("Location: index.php");
			exit;
		}
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