<?php
    // Creates a request.
	function create_request($db) {
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$service_type = filter_input(INPUT_POST, 'service_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$start_date = $_POST['start_date'];

		$query = "INSERT INTO requests (title, service_type, description, start_date) 
					VALUES (:title, :service_type, :description, :start_date)";

		$statement = $db->prepare($query);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':service_type', $service_type);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':start_date', $start_date);

		if ($statement->execute()) 
		{
			header('Location: index.php');
			exit();
		}
	}

	// Updates the request.
	function update_request($db) {
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$service_type = filter_input(INPUT_POST, 'service_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$start_date = $_POST['start_date'];
		$request_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		
		$query = "UPDATE requests SET title = :title, description = :description, 
			service_type = :service_type, start_date = :start_date WHERE request_id = :request_id";
		$statement = $db->prepare($query);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':service_type', $service_type);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':start_date', $start_date);
		$statement->bindValue(':request_id', $request_id, PDO::PARAM_INT);
		
		$statement->execute();
		
		header("Location: requests.php");
		exit;
	}

	// Deletes the request.
	function delete_request($db) {
		$id = $_POST['id'];
		$query = "DELETE FROM requests WHERE request_id='$id'";

		$statement = $db->prepare($query);

		if ($statement->execute()) {
			header('Location: index.php');
			exit();
		}
	}

	// Checks if all inputs are filled in and selected.
	function check_inputs() {
		$message = "";
		if (empty($_POST['title'])) 
			$message .= "The title must be at least one character.";
		if (empty($_POST['description']))
			$message .= "<br>The description must be at least one character.";
		if (empty($_POST['service_type'])) 
			$message .= "<br>A service must be selected.";
		if (empty($_POST['start_date'])) 
			$message .= "<br>A date and time must be selected.";
		return $message;
	}

	// Checks if a user is logged in and a session id is on.
	function secure() {
		if(!isset($_SESSION['id'])) {
			set_message('You must first log in to access this page.');
			header('Location: index.php');
			exit();
		}
	}

	// Sets a message to a session variable.
	function set_message($message) {
		$_SESSION['message'] = $message;
	}

	// Gets the session message variable. 
	function get_message() {
		if(isset($_SESSION['message'])) {
			echo '<p>' . $_SESSION['message'] . '</p>' . 
			'<hr>';
			unset($_SESSION['message']);
		}
	}
?>