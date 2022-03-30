<?php 
    include('config.php');
    include('connect.php');
    include('functions/functions.php');

    secure();

    include('header.php');    
?>
<div class="wrapper">
    <form action="process_service.php" method="post">
        <fieldset>
            <label for="title">Title: </label>
            <input name="title">

            <label for="description">Description: </label>
            <input name="description">

            <label for="estimate">Estimate: </label>
            <input name="estimate">

            <label for="service_type">Service Type: </label>
            <input name="service_type">

            <input type="submit" name="command" value="Create">
        </fieldset>
    </form>
</div>
<?php include('footer.php'); ?>