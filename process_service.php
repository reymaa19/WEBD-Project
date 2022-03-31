<?php 
	include('config.php');
	include('connect.php');
	include('functions/functions.php');

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