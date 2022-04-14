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
	$start_date = $_GET['start_date'];
    
    $statement->bindValue('id', $request_id, PDO::PARAM_INT);
    $statement->execute();
    
    $request = $statement->fetch();

	// Fetch services to populate selection.
	$query = "SELECT * FROM services ORDER BY title DESC";
    
    $statement = $db->prepare($query);
    $statement->execute(); 

    $services = $statement->fetchAll();

	$query = "SELECT * FROM images WHERE request_id = '$request_id'";
    
    $statement = $db->prepare($query);
    $statement->execute(); 

	$image = $statement->fetch();

    secure();

    include('header.php');
?>
	<div id="wrapper">
		<main>
		  <form action="process_request.php" method="post">
		    <fieldset>
				<label for="title">Title</label>
				<input type="text" name="title" placeholder="Mow my Lawn" value="<?= $request['title'] ?>"/>

				<select name="service_id">
				<option hidden disabled> -- Select a Service -- </option>
				<?php foreach ($services as $service): ?>
					<?php if($service_id == $service['service_id']): ?>
						<option value="<?= $service['service_id'] ?>" selected><?= $service['title'] ?></option>
					<?php else: ?>
						<option value="<?= $service['service_id'] ?>"><?= $service['title'] ?></option>
					<?php endif; ?>
				<?php endforeach ?>
				</select>

				<label for="start_date">Enter a date and time for your request:</label>
				<input type="datetime-local" name="start_date" value="<?= $start_date ?>">

				<label for="description">Description</label>
				<textarea name="description" rows="3"><?= $request['description'] ?></textarea>

				<?php if(isset($image['medium_path'])): ?>
					<input type="hidden" name="image_id" value="<?= $image['image_id'] ?>" />
					<img src="<?= $image['medium_path']?>" alt="<?= $image['medium_path']?>">
					<label for="image">Delete Image</label>
					<input type="checkbox" name="image" value="Delete" />
				<?php endif; ?>

		      	<div>
					<input type="hidden" name="id" value="<?= $request_id ?>" />
					<input type="submit" name="command" value="Update" />
					<input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
				</div>
		    </fieldset>
		  </form>
		</main>
	</div>
<?php include('footer.php'); ?>