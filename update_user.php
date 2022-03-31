<?php 
    include('config.php');
    include('connect.php');
    include('functions/functions.php');

    if (!filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
	    header("Location: dashboard.php");
	    exit;
	}

    $query = "SELECT * FROM users WHERE user_id = :id LIMIT 1";
    $statement = $db->prepare($query);

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $statement->bindValue('id', $id, PDO::PARAM_INT);
    $statement->execute();

    echo("<h1>".$id."</h1>");
    
    $row = $statement->fetch();

    secure();

    include('header.php');    
?>
<div id="wrapper">
    <h2>Edit User</h2>
    <form action="process_user.php" method="post">
    
        <label for="email">Email: </label>
        <input name="email" value="<?= $row['email'] ?>">

        <label for="password">Password: </label>
        <input name="password" type="password" value="<?= $row['password']?>">

        <label for="first_name">First Name: </label>
        <input name="first_name" value="<?= $row['first_name']?>">

        <label for="last_name">Last Name: </label>
        <input name="last_name" value="<?= $row['last_name']?>">
        
        <input type="hidden" name="id" value="<?= $id ?>" />
        <input type="submit" name="command" value="Update">
        <input type="submit" name="command" value="Delete" 
            onclick="return confirm('Are you sure you wish to delete this user?')">
    </form>
</div>
<?php include('footer.php'); ?>