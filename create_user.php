<?php 
    include('config.php');
    include('connect.php');
    include('functions/functions.php');

    secure();

    include('header.php');    
?>
<div class="wrapper">
    <form action="process_user.php" method="post">
        <fieldset>
            <label for="email">Email: </label>
            <input name="email">

            <label for="password">Password: </label>
            <input type="password" name="password">

            <label for="first_name">First Name: </label>
            <input type="text" name="first_name">

            <label for="last_name">Last Name: </label>
            <input type="text" name="last_name">

            <input type="submit" name="command" value="Create">
        </fieldset>
    </form>
</div>
<?php include('footer.php'); ?>