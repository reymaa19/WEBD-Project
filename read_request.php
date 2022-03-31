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

    $request = $statement->fetch();

	// Fetch title of service based on service_id.
	$query = "SELECT * FROM services WHERE service_id = '".$request['service_id']."' LIMIT 1";
    $statement = $db->prepare($query);
	$statement->execute();

	$service = $statement->fetch();

	// Fetch name of user based on user_id.
	$query = "SELECT * FROM users WHERE user_id = '".$request['user_id']."' LIMIT 1";
	$statement = $db->prepare($query);
	$statement->execute();

	$user = $statement->fetch();
	
	secure();

    include('header.php');
?>
	</header>
	<div id="wrapper">
		<div class="full_request">
			<h2 id="request_title"><?= $request['title'] ?></h2>
			<h4>
				Requested start date: <?= $request['start_date'] ?>
			</h4>
			<h3>Service chosen: <?= $service['title'] ?></h3>
			<div>
				<?= $request['description'] ?>
				<br>
				<small>- <?= $user['first_name'] . ' ' . $user['last_name'] ?></small>
			</div>
		</div>
	</div>
<script>
	// If an admin is logged in, create edit link.
	if ("<?php echo $_SESSION['admin']; ?>" == true) {
		var editLink = document.createElement('a');
		editLink.innerHTML = "Edit";
		editLink.href = "update_request.php?id=<?= $request['request_id'] ?>
							&service_id=<?= $request['user_id'] ?>
							&start_date=<?= $request['start_date'] ?>";

		document.getElementById("request_title").appendChild(editLink);
	} 
</script>
<?php include('footer.php'); ?>