<?php
/**
 *		edit
 *		Name: Reynald Maala
 *		Date: March 24, 2022
 *		Description: For editing requests. */ 

	require('connect.php');
	require('authenticate.php');

	if (!filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) 
	{
	    header("Location: index.php");
	    exit;
	}

    $query = "SELECT * FROM requests WHERE request_id = :id LIMIT 1";
    $statement = $db->prepare($query);
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    $statement->bindValue('id', $id, PDO::PARAM_INT);
    $statement->execute();
    
    $row = $statement->fetch();
	$id = $row['request_id'];
	$start_date = $row['start_date'];
	$service_type = $row['service_type'];
    $title = $row['title'];
    $description = $row['description'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edit</title>
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
		  <form action="process_request.php" method="post">
		    <fieldset>
				<label for="title">Title</label>
				<input type="text" name="title" id="title" placeholder="Mow my Lawn" value="<?= $title ?>"/>

				<p>The original service selected was: <strong><?= $service_type ?></strong></p>
				<select id="service_type" name="service_type">
				<option hidden disabled selected> -- Select a Service -- </option>
				<option value="Yard Trim">Yard Trim</option>
				<option value="Soil Control">Soil Control</option>
				<option value="Soil Inspection">Soil Inspection</option>
				<option value="Weeds Control">Weeds Control</option>
				<option value="Full Service">Full Service</option>
				<option value="Snow Removal">Snow Removal</option>
				</select>

				<label for="start_date">Enter a date and time for your request:</label>
				<p> The original start date was: <strong><?= $start_date ?></strong></p>
				<input id="start_date" type="datetime-local" name="start_date">

				<label for="description">Description</label>
				<textarea name="description" id="description" rows="3"><?= $description ?></textarea>
		      	<div id="options">
					<input type="hidden" name="id" value="<?= $id ?>" />
					<input type="submit" name="command" value="Update" />
					<input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
				</div>
		    </fieldset>
		  </form>
		</main>
	</div>
</body>
</html>