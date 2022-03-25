<?php 
/**
 *		show
 *		Name: Reynald Maala
 *		Date: March 24, 2022
 *		Description: For showing full request details. */ 

	require('connect.php');

    $query = "SELECT * FROM requests WHERE request_id = :id LIMIT 1";
    $statement = $db->prepare($query);
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    $statement->bindValue('id', $id, PDO::PARAM_INT);
    $statement->execute();

    $row = $statement->fetch();
	$id = $row['request_id'];
	$start_date = $row['start_date'];
    $title = $row['title'];
    $description = $row['description'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Show</title>
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
		    <div class="full_request">
				<h2><?= $row['title'] ?> <small><a href="edit.php?id=<?= $id ?>">edit</a></small></h2>
				<h4>
					Requested start date: <?= $start_date ?>
				</h4>
				<div>
					<?= $description ?>
				</div>
		    </div>
		</main>
	</div>
</body>
</html>