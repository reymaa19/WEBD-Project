<?php 
/**
 *		process_post
 *		Name: Reynald Maala
 *		Date: March 30, 2022
 *		Description: For process validating of request creations. */ 

	require('connect.php');
    require('authenticate.php');
	require('functions\functions.php');

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
?>
<?php include('header.php'); ?>
	<div id="wrapper">
		<main>
			<h2>An error occured while processing your post.</h2>
			<br>
			<p><?= check_inputs() ?></p>
			<br>
			<a href="index.php"><strong>Return Home</strong></a>
		</main>
	</div>
<?php include('footer.php'); ?>