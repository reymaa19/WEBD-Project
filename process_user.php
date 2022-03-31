<?php 
/**
 *		process_post
 *		Name: Reynald Maala
 *		Date: March 30, 2022
 *		Description: For process validating of request creations. */ 

	include('config.php');
	include('connect.php');
	include('functions/functions.php');

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