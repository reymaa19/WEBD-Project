<?php 
	include('config.php');
	include('connect.php');
	include('functions/functions.php');

	// Creates a service.
	function create_service($db) {
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$estimate = filter_input(INPUT_POST, 'estimate', FILTER_VALIDATE_FLOAT);
		$service_type = filter_input(INPUT_POST, 'service_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$query = "INSERT INTO services (title, description, estimate, service_type) 
					VALUES (:title, :description, :estimate, :service_type)";

		$statement = $db->prepare($query);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':estimate', $estimate);
		$statement->bindValue(':service_type', $service_type);

		if ($statement->execute()) 
		{
			header('Location: services.php');
			exit();
		}
	}

	// Updates the service.
	function update_service($db) {
		$service_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$estimate = filter_input(INPUT_POST, 'estimate', FILTER_VALIDATE_FLOAT);
		$service_type = filter_input(INPUT_POST, 'service_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		$query = "UPDATE services SET title = :title, description = :description, 
			estimate = :estimate, service_type = :service_type WHERE service_id = :service_id";
		$statement = $db->prepare($query);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':estimate', $estimate);
		$statement->bindValue(':service_type', $service_type);
		$statement->bindValue(':service_id', $service_id, PDO::PARAM_INT);
		
		$statement->execute();
		
		header("Location: services.php");
		exit;
	}

	// Deletes the service.
	function delete_service($db) {
		$id = $_POST['id'];
		$query = "DELETE FROM services WHERE service_id='$id'";

		$statement = $db->prepare($query);

		if ($statement->execute()) {
			header('Location: services.php');
			exit();
		}
	}





	if (check_inputs() == "") {
		if ($_POST['command'] == 'Create') 
		{
			create_service($db);
		}
		elseif ($_POST['command'] == 'Update')
		{
			update_service($db);
		}
	}

	if ($_POST['command'] == 'Delete')
	{
		delete_service($db);
	}

	set_message('An error occured while processing your service. <br>'.check_inputs());
	header('location: create_service.php');
	exit();

	secure();

    include('header.php');
?>
<?php include('footer.php'); ?>