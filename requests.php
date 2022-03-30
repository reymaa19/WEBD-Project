<?php
    require('connect.php');
    require('authenticate.php');

    $query = "SELECT * FROM requests ORDER BY start_date DESC";

    if(isset($_POST['sort'])) {
        $query = "SELECT * FROM requests ORDER BY " . $_POST['sort'];
    }

    $current_sort = str_replace('_', ' ', substr($query, 32));
    
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
    <?php include('header.php'); ?>
    <div id="wrapper">
		<main>
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
                <small>Currently sorted by: <?= $current_sort ?></small>

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