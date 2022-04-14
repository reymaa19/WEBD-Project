<?php 
	include('config.php');
	include('connect.php');
	include('functions/functions.php');

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





	if (empty(check_inputs())) {
		if ($_POST['command'] == 'Create') 
		{
			if ($_POST['password'] != $_POST['password2']) {
				header('location: create_user.php');
				set_message('Passwords do not match. Try again.');
				exit();
			}
			create_user($db);
		}
		elseif ($_POST['command'] == 'Update')
		{
			update_user($db);
		}
	}

	if ($_POST['command'] == 'Delete')
	{
		delete_user($db);
	}

	set_message('An error occured while processing your user.<br>' . check_inputs());
	header('location: create_user.php');
	exit();

    include('header.php');
?>
<?php include('footer.php'); ?>