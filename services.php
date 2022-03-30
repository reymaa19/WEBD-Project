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

    $query = 'SELECT * FROM services';
    $statement = $db->prepare($query);
    $statement->execute();

    $rows = $statement->fetchAll();
?>
<div id="wrapper">
    <h2>Users</h2>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Estimate</th>
            <th>Service Type</th>
            <th><a href="create_service.php">Create</a></th>
        </tr>

        <?php foreach($rows as $row): ?>
        <tr>
            <td><?= $row['title'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['estimate'] ?></td>
            <td><?= $row['service_type'] ?></td>
            <td><a href="update_service.php?id=<?= $row['service_id'] ?>">Edit</a></td>
        </tr>
        <?php endforeach; ?>

    </table>
</div>
<?php include('footer.php'); ?>