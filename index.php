<?php
    require('connect.php');

    $query = "SELECT * FROM requests ORDER BY start_date DESC LIMIT 10";

    if(isset($_POST['sort'])) {
        $query = "SELECT * FROM requests ORDER BY " . $_POST['sort'] . " LIMIT 10";
    }
    
    $statement = $db->prepare($query);
    $statement->execute(); 

    $result = $statement->fetchAll();

    function truncateContent($description)
    {
        if(strlen($description) <= 200)
        {
            echo $description;
            return false;
        }
        else
        {
            echo substr($description, 0, 192) . ' ...';
            return true;
        }
    }
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

            <div id="board">
                <h2>Requests Board</h2>
                <!-- Sort -->
                <form id="sortform" action="" method="post">
                    <select id="sort" name="sort" onchange="this.form.submit()">
                        <option hidden disabled selected> Sort </option>
                        <option value="title ASC">Title</option>
                        <option value="start_date ASC">Earliest Start Date</option>
                        <option value="start_date DESC">Latest Start Date</option>
                        <option value="service_type DESC">Service Type</option>
                    </select>
                </form>

                <!-- Requests -->
                <?php foreach ($result as $row): ?>
                    <div class="request">
                        <h3><a href="show.php?id=<?= $row['request_id'] ?>"><?= $row['title'] ?></a></h3>
                        <?php if (truncateContent($row['description'])): ?>
	    					<a href="show.php?id=<?= $row['request_id'] ?>">Read Full Request</a>
	    				<?php endif ?>
                        <br>
                        <small>Requested start date: <?= $row['start_date'] ?></small>
                    </div>
                <?php endforeach ?>
            </div>
		</main>
	</div>
</body>
</html>