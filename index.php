<?php
    include('config.php');
    include('connect.php');
    include('functions/functions.php');
    
    if(isset($_POST['email'])) {
        $query = 'SELECT * 
                  FROM accounts
                  WHERE email = '.$_POST["email"].'
                  AND password = '.md5($_POST["password"]).'
                  LIMIT 1';
        
        $statement = $db->prepare($query);

        if ($statement->execute())
        {
            $record = $statement->fetch();
            $_SESSION['account_id'] = $record['account_id'];
            $_SESSION['email'] = $record['email'];

            header('Location: dashboard.php');
            exit();
        }
    }

    // $id = $_POST['id'];
    // $query = "DELETE FROM requests WHERE request_id='$id'";

    // $statement = $db->prepare($query);

    // if ($statement->execute()) {
    //     header('Location: index.php');
    //     exit();
    // }

    include('header.php');
?>
    <form action="post">
        <label for="email">Email: </label>
        <input type="text" name="email">
        <label for="password">Password: </label>
        <input type="password" name="password">
        <input type="submit" value="login">
    </form>
<?php include('footer.php'); ?>