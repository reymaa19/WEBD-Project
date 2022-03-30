<?php 
    include('config.php');
    include('connect.php');
    include('functions/functions.php');

    if(isset($_POST['email'])) {
        $query = 'INSERT INTO accounts (
                first_name,
                last_name,
                email,
                password
            ) VALUES (
                "'.$_POST['first_name'].'",
                "'.$_POST['last_name'].'",
                "'.$_POST['email'].'",
                "'.md5($_POST['password']).'"
            )';

            $statement = $db->prepare($query);
            $statement->execute();
    
            set_message('Successfully registered!');
    
            header('Location: index.php');
            exit();
    }

    include('header.php');    
?>
    <form method="post" autocomplete="off">
        <label for="email">Email: </label>
        <input name="email">

        <label for="password">Password: </label>
        <input type="password" name="password">

        <label for="first_name">First Name: </label>
        <input type="text" name="first_name">

        <label for="last_name">Last Name: </label>
        <input type="text" name="last_name">

        <input type="submit" value="register">
    </form>
<?php include('footer.php'); ?>