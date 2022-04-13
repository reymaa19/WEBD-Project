<?php
	use \Gumlet\ImageResize;

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
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$query = "INSERT INTO users (email, first_name, last_name, password) 
					VALUES (:email, :first_name, :last_name, :password)";

		$statement = $db->prepare($query);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':first_name', $first_name);
		$statement->bindValue(':last_name', $last_name);
		$statement->bindValue(':password', $password);

		if ($statement->execute()) 
		{
			header('Location: index.php');
			set_message('Registration successful.');
			exit();
		}
	}

	// Updates the user.
	function update_user($db) {
		$user_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		
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

	
	// Creates a Comment.
	function create_comment($db) {
		$date = date('Y-m-d H:i:s');
		$user_id = $_SESSION['id'];
		$request_id = filter_input(INPUT_POST, 'request_id', FILTER_SANITIZE_NUMBER_INT);
		$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$datetime = $date;

		$query = "INSERT INTO comments (user_id, request_id, content, datetime) 
					VALUES (:user_id, :request_id, :content, :datetime)";

		$statement = $db->prepare($query);
		$statement->bindValue(':user_id', $user_id);
		$statement->bindValue(':request_id', $request_id);
		$statement->bindValue(':content', $content);
		$statement->bindValue(':datetime', $datetime);

		if ($statement->execute()) 
		{
			header('Location: read_request.php?id=' . $request_id);
			exit();
		}
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

	// Checks the if the input date is greater than right now.
	function check_date($date) {
		$current_date = date('Y-m-d H:i:s');
		if ($date > $current_date) {
			return true;
		}
		return false;
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

	// Creates the file upload path.
	function upload_path($original_filename, $upload_subfolder_name = 'uploads') {
		$current_folder = dirname(__FILE__);
		
		$path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

		return join(DIRECTORY_SEPARATOR, $path_segments);
	}

	// IMAGE UPLOADING
		
	// Checks if the file is of appropriate type. 
	function file_check($temporary_path) {
		$allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];

		foreach ($allowed_mime_types as $type) {
			if (str_contains($temporary_path, $type)) {
				return "You have uploaded a file of type {$type}.";
			}
		}
		return null;
	}

	// Uploads images to uploads folder.
	function upload_image($image, $request_id, $db) {
		if ($image['error'] === 0) {
			$temporary_image_path  = $image['tmp_name'];
			$image_filename        = $image['name'];
	
			if (file_check($image['type']) != null) {
				$original_size= new ImageResize($temporary_image_path);
				$original_size->save('uploads\\' . $image_filename . '-ORIGINAL.jpg');
				$original_path = 'uploads\\' . $image_filename . '-ORIGINAL.jpg';
		
				$medium_size = $original_size->resizeToWidth(400);
				$medium_size->save('uploads\\' . $image_filename . '-MEDIUM.jpg');
				$medium_path = 'uploads\\' . $image_filename . '-MEDIUM.jpg';
		
				$thumbnail_size = $original_size->resizeToWidth(50);
				$thumbnail_size->save('uploads\\' . $image_filename . '-THUMBNAIL.jpg');
				$thumbnail_path = 'uploads\\' . $image_filename . '-THUMBNAIL.jpg';

				create_image($original_path, $medium_path, $thumbnail_path, $request_id, $db);
			} else {
				set_message("Incorrect image file type.");
			}   
		} 
	}

	// Creates an image
	function create_image($original_path, $medium_path, $thumbnail_path, $request_id, $db) {
		$datetime = date('Y-m-d H:i:s');

		$query = "INSERT INTO images (request_id, original_path, medium_path, thumbnail_path, datetime) 
					VALUES (:request_id, :original_path, :medium_path, :thumbnail_path, :datetime)";

		$statement = $db->prepare($query);
		$statement->bindValue(':request_id', $request_id);
		$statement->bindValue(':original_path', $original_path);
		$statement->bindValue(':medium_path', $medium_path);
		$statement->bindValue(':thumbnail_path', $thumbnail_path);
		$statement->bindValue(':datetime', $datetime);

		$statement->execute();
	}
?>