<?php 
	include('config.php');
	include('connect.php');
	include('functions/functions.php');
	include('functions/ImageResize.php');
	include('functions/ImageResizeException.php');

	// Creates a request.
	function create_request($db, $image = null) {
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
		$service_id = filter_input(INPUT_POST, 'service_id', FILTER_SANITIZE_NUMBER_INT);
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$start_date = $_POST['start_date'];

		$query = "INSERT INTO requests (title, user_id, service_id, description, start_date) 
		VALUES (:title, :user_id, :service_id, :description, :start_date)";
		
		$statement = $db->prepare($query);

		$statement->bindValue(':title', $title);
		$statement->bindValue(':service_id', $service_id);
		$statement->bindValue(':user_id', $user_id);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':start_date', $start_date);

		if ($statement->execute()) 
		{
			if (!is_null($image)) {
				$statement = $db->prepare("SELECT * FROM requests ORDER BY request_id DESC LIMIT 1");
				$statement->execute();
				$result = $statement->fetch();
				upload_image($image, $result['request_id'], $db);
			}

			header('Location: requests.php');
			exit();
		}
	}

	// Updates the request.
	function update_request($db) {
		$request_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$service_id = filter_input(INPUT_POST, 'service_id', FILTER_SANITIZE_NUMBER_INT);
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$start_date = $_POST['start_date'];
		
		$query = "UPDATE requests SET service_id = :service_id,
			title = :title, description = :description, start_date = :start_date
			WHERE request_id = :request_id";
		$statement = $db->prepare($query);
		$statement->bindValue(':request_id', $request_id, PDO::PARAM_INT);
		$statement->bindValue(':service_id', $service_id);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':start_date', $start_date);

		$statement->execute();
		
		header("Location: requests.php");
		exit;
	}

	// Deletes the request.
	function delete_request($db) {
		delete_comments($db);
		$query = "DELETE FROM requests WHERE request_id=" . $_POST['id'];

		$statement = $db->prepare($query);

		if ($statement->execute()) {
			header('Location: requests.php');
			exit();
		}
	}

	// Delete all comments from request.
	function delete_comments($db) {
		$query = "DELETE FROM comments WHERE request_id=" . $_POST['id'];
		$statement = $db->prepare($query);
		$statement->execute();
	}



	

	if (check_date($_POST['start_date'])) {
		if (empty(check_inputs())) {
			if ($_POST['command'] == 'Create') 
			{
				if (isset($_FILES['image'])) {
					create_request($db, $_FILES['image']);
				} else {
					create_request($db);	
				}
			}
			elseif ($_POST['command'] == 'Update')
			{
				if ($_POST['image_checkbox'] == 'on') {
					delete_image($db, $_POST['image_id']);
				}
				if (isset($_FILES['image'])) {
					upload_image($_FILES['image'], $_POST['id'], $db);
				}
				update_request($db);
			}
		}
	
		if ($_POST['command'] == 'Delete')
		{
			delete_image($db, $_POST['image_id']);
			delete_request($db);
		}
	}

	set_message('An error occured while processing your request.<br>'.check_inputs()
		.'<br>Put in a date time greater than right now.');
	if ($_POST['command'] == 'Update') {
		header("Refresh:0");
	} else {
		header('location: create_request.php');
	}
	exit();
	secure();

    include('header.php');
	include('footer.php');
?>