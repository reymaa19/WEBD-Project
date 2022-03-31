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
			delete_request($db);
		}
	} 
	
	set_message('An error occured while processing your request.<br>'.check_inputs()
		.'<br>Put in a date time greater than right now.');
	header('location: create_request.php');
	exit();
	secure();

    include('header.php');
?>
<?php include('footer.php'); ?>