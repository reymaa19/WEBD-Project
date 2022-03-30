<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">    
    <title>Index</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Gothic+A1&display=swap" rel="stylesheet"> 
</head>
<body>
    <?php include('header.php'); ?>
    <div id="wrapper">
		<main>
            <h2 id="about">About</h2>
            <p>
                Reynald Lawncare and Snow Removal is a lawn and snow management service based
                in Winnipeg, Manitoba. Specialized in snow and ice removal of driveways, entrances,
                walkways, and parking lots of residential and small business establishments. They are
                also lawn experts in keeping your yard in its best condition, offering services like yard
                trims, soil quality and weeds control, and more.
            </p>

            <div id="images">
                <img class="img" src="images/snow_house.jpg" alt="snow house">
                <img class="img" src="images/kept_lawn.jpg" alt="kept lawn">
            </div>

            <div id="board_index">
                <h2 id="requests_board"><a href="requests.php">Requests Board</a></h2>
            </div>
		</main>
	</div>
</body>
</html>