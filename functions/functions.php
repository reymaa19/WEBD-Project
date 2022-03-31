<?php
    // Creates a request.
	function create_request($db) {
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
		$id = $_POST['id'];
		$query = "DELETE FROM requests WHERE request_id='$id'";

		$statement = $db->prepare($query);

		if ($statement->execute()) {
			header('Location: requests.php');
			exit();
		}
	}

	// Creates a user.
	function create_user($db) {
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = md5($_POST['password']);

		$query = "INSERT INTO users (email, first_name, last_name, password) 
					VALUES (:email, :first_name, :last_name, :password)";

		$statement = $db->prepare($query);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':first_name', $first_name);
		$statement->bindValue(':last_name', $last_name);
		$statement->bindValue(':password', $password);

		if ($statement->execute()) 
		{
			header('Location: dashboard.php');
			exit();
		}
	}

	// Updates the user.
	function update_user($db) {
		$user_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = md5($_POST['password']);
		
		$query = "UPDATE users SET email = :email, first_name = :first_name, 
			last_name = :last_name, password = :password WHERE user_id = :user_id";
		$statement = $db->prepare($query);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':first_name', $first_name);
		$statement->bindValue(':last_name', $last_name);
		$statement->bindValue(':password', $password);
		$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		
		$statement->execute();
		
		header("Location: users.php");
		exit;
	}

	// Deletes the user.
	function delete_user($db) {
		$id = $_POST['id'];
		$query = "DELETE FROM users WHERE user_id='$id'";

		$statement = $db->prepare($query);

		if ($statement->execute()) {
			header('Location: users.php');
			exit();
		}
	}


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


	// Checks if all inputs for  are filled in and selected.
	function check_inputs() {
		$message = "";
		foreach ($_POST as $key => $value) {
			if(empty($value)) {
				$message = "Fill in all inputs and selections.";
			}
		}
		return $message;
	}

	// Checks if a user is logged in and a session id is on.
	function secure() {
		if(!isset($_SESSION['id'])) {
			set_message('You must first log in to access any other page.');
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