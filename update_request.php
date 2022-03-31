<?php
	include('config.php');
	include('connect.php');
	include('functions/functions.php');

	if (!filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) 
	{
	    header("Location: dashboard.php");
	    exit;
	}

	// Fetch selected request.
    $query = "SELECT * FROM requests WHERE request_id = :id LIMIT 1";
    $statement = $db->prepare($query);
    
    $request_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	$service_id = filter_input(INPUT_GET, 'service_id', FILTER_SANITIZE_NUMBER_INT);
    
    $statement->bindValue('id', $request_id, PDO::PARAM_INT);
    $statement->execute();
    
    $result = $statement->fetch();

	// Fetch services to populate selection.
	$query = "SELECT * FROM services ORDER BY title DESC";
    
    $statement = $db->prepare($query);
    $statement->execute(); 

    $rows = $statement->fetchAll();

    secure();

    include('header.php');
?>
	<div id="wrapper">
		<main>
		  <form action="process_request.php" method="post">
		    <fieldset>
				<label for="title">Title</label>
				<input type="text" name="title" id="title" placeholder="Mow my Lawn" value="<?= $result['title'] ?>"/>

				<select id="service_type" name="service_id">
				<option hidden disabled> -- Select a Service -- </option>
				<?php foreach ($rows as $row): ?>
					<?php if($service_id == $row['service_id']): ?>
						<option value="<?= $row['service_id'] ?>" selected><?= $row['title'] ?></option>
					<?php else: ?>
						<option value="<?= $row['service_id'] ?>"><?= $row['title'] ?></option>
					<?php endif; ?>
				<?php endforeach ?>
				</select>

				<label for="start_date">Enter a date and time for your request:</label>
				<input id="start_date" type="datetime-local" name="start_date">

				<label for="description">Description</label>
				<textarea name="description" id="description" rows="3"><?= $result['description'] ?></textarea>
		      	<div id="options">
					<input type="hidden" name="id" value="<?= $id ?>" />
					<input type="submit" name="command" value="Update" />
					<input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
				</div>
		    </fieldset>
		  </form>
		</main>
	</div>
<?php include('footer.php'); ?>