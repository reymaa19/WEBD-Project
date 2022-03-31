<?php 
	include('config.php');
	include('connect.php');
	include('functions/functions.php');

	// Fetch selected request.
    $query = "SELECT * FROM requests WHERE request_id = :id LIMIT 1";
    $statement = $db->prepare($query);
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    $statement->bindValue('id', $id, PDO::PARAM_INT);
    $statement->execute();

    $row = $statement->fetch();
	$request_id = $row['request_id'];
	$service_id = $row['service_id'];
	$start_date = $row['start_date'];
    $title = $row['title'];
    $description = $row['description'];

	// Fetch title of service based on service_id.
	$query = "SELECT * FROM services WHERE service_id = '".$service_id."' LIMIT 1";
    $statement = $db->prepare($query);
	$statement->execute();

	$result = $statement->fetch();
	$service_title = $result['title'];
	
	secure();

    include('header.php');
?>
	</header>
	<div id="wrapper">
		<div class="full_request">
			<h2><?= $title ?> <small><a href="update_request.php?id=<?= $request_id ?>&service_id=<?= $service_id ?>">edit</a></small></h2>
			<h4>
				Requested start date: <?= $start_date ?>
			</h4>
			<h3>Service chosen: <?= $service_title ?></h3>
			<div>
				<?= $description ?>
			</div>
		</div>
	</div>
<?php include('footer.php'); ?>