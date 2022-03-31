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

	set_message(check_inputs());

	secure();

    include('header.php');
?>
	<div id="wrapper">
		<main>
			<h2>An error occured while processing your service.</h2>
			<br>
			<a href="dashboard.php"><strong>Return Home</strong></a>
		</main>
	</div>
<?php include('footer.php'); ?>