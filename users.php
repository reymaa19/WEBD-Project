<?php 
    include('config.php');
    include('connect.php');
    include('functions/functions.php');
    secure();
    include('header.php');    

    if(!$_SESSION['admin']) {
        header('Location: dashboard.php');
        exit();
    }

    $query = 'SELECT * FROM users WHERE admin = 0';
    $statement = $db->prepare($query);
    $statement->execute();

    $rows = $statement->fetchAll();
?>
<div id="wrapper">
    <h2>Users</h2>
    <table border="1">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th>
        </tr>

        <?php foreach($rows as $row): ?>
        <tr>
            <td><?= $row['first_name'] ?></td>
            <td><?= $row['last_name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><a href="update_user.php?id=<?= $row['user_id'] ?>">Edit</a></td>
        </tr>
        <?php endforeach; ?>

    </table>
</div>
<?php include('footer.php'); ?>