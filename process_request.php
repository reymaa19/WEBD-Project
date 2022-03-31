<?php 
	include('config.php');
	include('connect.php');
	include('functions/functions.php');

	if (check_date($_POST['start_date'])) {
		if (check_inputs() == "") {
			if ($_POST['command'] == 'Create') 
			{
				create_request($db);
			}
			elseif ($_POST['command'] == 'Update')
			{
				update_request($db);
			}
		}
	
		if ($_POST['command'] == 'Delete')
		{
			include('authenticate.php');
			delete_request($db);
		}
	} 
	
	set_message(check_inputs() . '<br>Put in a date time greater than right now.');

	secure();

    include('header.php');
?>
	<div id="wrapper">
		<main>
			<h2>An error occured while processing your request.</h2>
			<br>
			<a href="dashboard.php"><strong>Return Home</strong></a>
		</main>
	</div>
<?php include('footer.php'); ?>