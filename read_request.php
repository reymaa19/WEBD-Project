<?php 
	include('config.php');
	include('connect.php');
	include('functions/functions.php');

	function user_comment($user_id, $db) {
		$query = "SELECT * FROM users WHERE user_id = '".$user_id."' LIMIT 1";
		$statement = $db->prepare($query);
		$statement->execute();
	
		$comment_user = $statement->fetch();
		return $comment_user['first_name'] . " " . $comment_user['last_name'];
	}

	if(isset($_POST['content'])) {
		create_comment($db);
	}

	// Fetch selected request.
    $query = "SELECT * FROM requests WHERE request_id = :id LIMIT 1";
    $statement = $db->prepare($query);
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    $statement->bindValue('id', $id, PDO::PARAM_INT);
    $statement->execute();

    $request = $statement->fetch();

	// Fetch title of service based on service_id.
	$query = "SELECT * FROM services WHERE service_id = '".$request['service_id']."' LIMIT 1";
    $statement = $db->prepare($query);
	$statement->execute();

	$service = $statement->fetch();

	// Fetch name of user based on user_id.
	$query = "SELECT * FROM users WHERE user_id = '".$request['user_id']."' LIMIT 1";
	$statement = $db->prepare($query);
	$statement->execute();

	$user = $statement->fetch();

	// Fetch comments based on request_id.
	$query = "SELECT * FROM comments WHERE request_id = '".$request['request_id']."' ORDER BY datetime DESC";
	$statement = $db->prepare($query);
	$statement->execute();

	$comments = $statement->fetchAll();
	
	secure();

    include('header.php');
?>
<div id="wrapper">
	<div class="full_request">
		<h2 id="request_title"><?= $request['title'] ?></h2>
		<h4>
			Requested start date: <?= $request['start_date'] ?>
		</h4>
		<?php if(isset($service['title'])) : ?>
			<h3>Service chosen: <?= $service['title'] ?></h3>
			<h2>Estimate: $<?= $service['estimate'] ?></h2>
		<?php endif; ?>	
		<div>
			<?= $request['description'] ?>
			<br>
			<?php if(isset($user['first_name'])) : ?>
    			<small>- <?= $user['first_name'] . ' ' . $user['last_name'] ?></small>
			<?php endif; ?>	
		</div>
	</div>

	<div class="comment_section">
		<h3>Comments</h3>
		<form method="post">
			<label for="comment">Add Comment</label>
			<input type="text" name="content">
			<input type="hidden" name="request_id" value="<?= $request['request_id'] ?>" />
			<input type="submit" value="Comment">
		</form>

		<div class="comments">
			<?php foreach ($comments as $comment): ?>
				<div class="comment">
					<p> <?= $comment['content'] ?></p>
					<small>- <?= user_comment($comment['user_id'], $db) ?></small>
				</div>
			<?php endforeach ?>
		</div>
	</div>


</div>
<script>
	// If an admin is logged in.
	if ("<?php echo $_SESSION['admin']; ?>" == true || 
	"<?php echo $_SESSION['id']; ?>" == "<?php echo$user['user_id']; ?>") {
		var editLink = document.createElement('a');
		editLink.innerHTML = "Edit";
		editLink.href = "update_request.php?id=<?= $request['request_id'] ?>
						&service_id=<?= $request['service_id'] ?>
						&start_date=<?= $request['start_date'] ?>";

		document.getElementById("request_title").appendChild(editLink);
	} 
</script>
<?php include('footer.php'); ?>