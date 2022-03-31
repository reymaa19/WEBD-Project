<?php
    include('config.php');
    include('connect.php');
    include('functions/functions.php');
    
    if(isset($_POST['email'])) {
        $query = 'SELECT * 
                  FROM users
                  WHERE email = "'.$_POST['email'].'"
                  AND password = "'.md5($_POST['password']).'"
                  LIMIT 1';
        
        $statement = $db->prepare($query);
        $statement->execute();

        $record = $statement->fetch();

        if (!empty($record))
        {
            // Successful
            $_SESSION['id'] = $record['user_id'];
            $_SESSION['admin'] = $record['admin'];
            
            header('Location: dashboard.php');
            set_message('Login Successful');
            exit();
        } else {
            // Unsuccessful
            set_message('Login Unsuccessful');
        }
    }

    include('header.php');
?>
    <form method="post">
        <label for="email">Email: </label>
        <input type="text" name="email"
        >
        <label for="password">Password: </label>
        <input type="password" name="password">

        <input type="submit" value="login">
    </form>
<?php include('footer.php'); ?>