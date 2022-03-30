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
			header('Location: dashboard.php');
			exit();
		}
	}

	// Updates the request.
	function update_request($db) {
		$request_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$service_type = filter_input(INPUT_POST, 'service_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$start_date = $_POST['start_date'];
		
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
			header('Location: dashboard.php');
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
		$password = $_POST['password'];
		
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