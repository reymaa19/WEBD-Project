<?php
    include('config.php');
    include('connect.php');
    include('functions/functions.php');
    
    if(isset($_POST['email'])) {
        $query = 'SELECT * 
                  FROM accounts
                  WHERE email = "'.$_POST['email'].'"
                  AND password = "'.md5($_POST['password']).'"
                  LIMIT 1';
        
        $statement = $db->prepare($query);
        $statement->execute();

        $record = $statement->fetch();

        if (!empty($record))
        {
            $_SESSION['id'] = $record['account_id'];
            $_SESSION['email'] = $record['email'];

            header('Location: dashboard.php');
            exit();
        }
    }

    include('header.php');
?>
    <form method="post">
        <label for="email">Email: </label>
        <input type="text" name="email" id="email">
        <label for="password">Password: </label>
        <input type="password" name="password" id="password">
        <input type="submit" value="login">
    </form>
<?php include('footer.php'); ?>