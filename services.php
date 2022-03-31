<?php 
    include('config.php');
    include('connect.php');
    include('functions/functions.php');
    secure();
    include('header.php');    

    $query = 'SELECT * FROM services';
    $statement = $db->prepare($query);
    $statement->execute();

    $rows = $statement->fetchAll();
?>
<div id="wrapper">
    <h2>Users</h2>
    <table border="1">
        <tr id="users_th">
            <th>Title</th>
            <th>Description</th>
            <th>Estimate</th>
            <th>Service Type</th>
        </tr>

        <?php foreach($rows as $row): ?>
        <tr id=<?= $row['service_id']?>>
            <td><?= $row['title'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['estimate'] ?></td>
            <td><?= $row['service_type'] ?></td>
            <script>
                // If an admin is logged in, enable service create link.
                if ("<?php echo $_SESSION['admin']; ?>" == true) {
                    var editLink = document.createElement('a');
                    editLink.innerHTML = "Edit";
                    editLink.href = "update_service.php?id=<?= $row['service_id'] ?>";
                    var newTd = document.createElement('td');
                    newTd.appendChild(editLink);
                    document.getElementById(<?= $row['service_id']?>).appendChild(newTd);
                }
            </script>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<script>
    // If an admin is logged in, enable service create link.
    if ("<?php echo $_SESSION['admin']; ?>" == true) {
        var createLink = document.createElement('a');
        createLink.innerHTML = "Create";
        createLink.href = "create_service.php";
        var newTd = document.createElement('td');
        newTd.appendChild(createLink);
        document.getElementById("users_th").appendChild(newTd);
    }
</script>
<?php include('footer.php'); ?>