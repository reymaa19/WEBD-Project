<?php 
    include('config.php');
    include('connect.php');
    include('functions/functions.php');

    $query = "SELECT * FROM services ORDER BY title DESC";
    
    $statement = $db->prepare($query);
    $statement->execute(); 

    $rows = $statement->fetchAll();

    secure();

    include('header.php');    
?>
<div id="wrapper">
    <form action="process_request.php" method="post">
        <fieldset>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="Mow my Lawn"/>

            <!-- Populated with created services -->
            <select id="service_type" name="service_id">
            <option hidden disabled selected> -- Select a Service -- </option>
            <?php foreach ($rows as $row): ?>
                <option value="<?= $row['service_id'] ?>"><?= $row['title'] ?></option>
            <?php endforeach ?>
            </select>

            <label for="start_date">Enter a date and time for your request:</label>
            <input id="start_date" type="datetime-local" name="start_date">

            <label for="description">Description</label>
            <textarea name="description" id="description" rows="3"></textarea>

            <input type="hidden" name="user_id" value="<?= $_SESSION['id'] ?>" />
            <input type="submit" name="command" value="Create"></input>
        </fieldset>
    </form>
</div>
<?php include('footer.php'); ?>