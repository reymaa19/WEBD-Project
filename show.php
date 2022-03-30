<?php 
/**
 *		show
 *		Name: Reynald Maala
 *		Date: March 24, 2022
 *		Description: For showing full request details. */ 

	include('config.php');
	include('connect.php');
	include('functions/functions.php');

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
	
	secure();

    include('header.php');
?>
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
<?php include('footer.php'); ?>