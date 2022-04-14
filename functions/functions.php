<?php
	use \Gumlet\ImageResize;

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

	// IMAGE UPLOADING

	// Creates the file upload path.
	function upload_path($original_filename, $upload_subfolder_name = 'uploads') {
		$current_folder = dirname(__FILE__);
		
		$path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

		return join(DIRECTORY_SEPARATOR, $path_segments);
	}
		
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
				$original_size->save('uploads/' . $image_filename . $request_id . '-ORIGINAL.jpg');
				$original_path = 'uploads/' . $image_filename . $request_id . '-ORIGINAL.jpg';
		
				$medium_size = $original_size->resizeToWidth(400);
				$medium_size->save('uploads/' . $image_filename . $request_id . '-MEDIUM.jpg');
				$medium_path = 'uploads/' . $image_filename . $request_id . '-MEDIUM.jpg';
		
				$thumbnail_size = $original_size->resizeToWidth(50);
				$thumbnail_size->save('uploads/' . $image_filename . $request_id . '-THUMBNAIL.jpg');
				$thumbnail_path = 'uploads/' . $image_filename . $request_id . '-THUMBNAIL.jpg';

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

	// Deletes the image record from the database.
	function delete_image($db, $image_id) {
		delete_image_path($db, $image_id);

		$query = "DELETE FROM images WHERE image_id = '$image_id'";
		$statement = $db->prepare($query);

		$statement->execute();
	}

	// Deletes the image from the server.
	function delete_image_path($db, $image_id) {
		$query = "SELECT * FROM images WHERE image_id = '$image_id'";
		$statement = $db->prepare($query);
		$statement->execute();

		$image = $statement->fetch();
		$original = $image['original_path'];
		$medium = $image['medium_path'];
		$thumbnail = $image['thumbnail_path'];

		$files = [
			$original, $medium, $thumbnail
		];

		foreach ($files as $file) {
			if (file_exists($file)) {
				unlink($file);
			} else {
				return;
			}
		}
	}

	// TEMP!!!!!!!!!
	function debug_to_console($data) {
		$output = $data;
		if (is_array($output))
			$output = implode(',', $output);
	
		echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
	}
?>