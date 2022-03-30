<?php 
    include('config.php');
    include('connect.php');
    include('functions/functions.php');

    if (!filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
	    header("Location: dashboard.php");
	    exit;
	}

    $query = "SELECT * FROM services WHERE service_id = :id LIMIT 1";
    $statement = $db->prepare($query);

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $statement->bindValue('id', $id, PDO::PARAM_INT);
    $statement->execute();
    
    $row = $statement->fetch();

    secure();

    include('header.php');    
?>
<div id="wrapper">
    <h2>Edit Service</h2>
    <form action="process_service.php" method="post">
    
        <label for="title">Title: </label>
        <input name="title" value="<?= $row['title'] ?>">

        <label for="description">Description: </label>
        <input name="description" value="<?= $row['description']?>">

        <label for="estimate">Estimate: </label>
        <input name="estimate" value="<?= $row['estimate']?>">

        <label for="service_type">Service Type: </label>
        <input name="service_type" value="<?= $row['service_type']?>">
        
        <input type="hidden" name="id" value="<?= $id ?>" />
        <input type="submit" name="command" value="Update">
        <input type="submit" name="command" value="Delete" 
            onclick="return confirm('Are you sure you wish to delete this user?')">
    </form>
</div>
<?php include('footer.php'); ?>