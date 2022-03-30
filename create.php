<?php 
/**
 *		create
 *		Name: Reynald Maala
 *		Date: March 24, 2022
 *		Description: For creation of service requests. */ 

	require('connect.php');
	require('authenticate.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Gothic+A1&display=swap" rel="stylesheet"> 
</head>
<body>
    <?php include('header.php'); ?>
	<div id="wrapper">
		<main>
            <form action="process_post.php" method="post">
                <fieldset>
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" placeholder="Mow my Lawn"/>

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
                    <input id="start_date" type="datetime-local" name="start_date">


                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="3"></textarea>

                    <input type="submit" name="command" value="Create"></input>
                </fieldset>
            </form>
		</main>
	</div>
</body>
</html>