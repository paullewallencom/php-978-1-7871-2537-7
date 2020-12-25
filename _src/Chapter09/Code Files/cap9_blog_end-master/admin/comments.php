<?
session_start ();

require_once 'config.php';
require_once 'connection.php';
require_once 'isUser.php';

$dbConn = connect();

if ( !empty( $_SESSION['username'] ) && !empty($_SESSION['password']) ) {
	$arrUser = isUser( $_SESSION['username'], $_SESSION['password'], $dbConn );
}

if ( empty($arrUser) || $arrUser['type'] != 'admin' ) {
	header( 'Location: ../index.php' );
	die;
}

if ( !empty($_GET['del']) ) {
	
	$query  = "DELETE FROM `comments` WHERE id = {$_GET['del']}";
	$result = mysql_query($query, $dbConn);
		
	header( 'Location: comments.php?dele=true' );
	die;
	
}

if ( !empty($_GET['valid']) ) {
	$query  = "UPDATE `comments` set status = 'valid' WHERE id = {$_GET['valid']}";
	$result = mysql_query($query, $dbConn);
		
	header( 'Location: comments.php?validated=true' );
	die;
	
}

if ( !empty($_POST['submitEdit']) ) {
	
	if ( !empty($_POST['comment']) ) 	$comment 		= $_POST['comment'];
	if ( !empty($_POST['id']) ) 	$comment_id 		= $_POST['id'];
	
	if ( empty($comment) ) 		$error['comment'] 		= 'Please enter a valid comment';
	if ( empty($comment_id) ) 	$error['id'] 		= 'The comment id was not sent';
	
	if ( empty($error) ) {
		$query  = "UPDATE `comments` set comment = '$comment' WHERE id = $comment_id";
		$result = mysql_query($query, $dbConn);
		
		header( 'Location: comments.php?edit=true' );
		die;
		
	}
		
}

$arrComments = array();
$query = "SELECT comments.id, comments.comment, comments.article_id, users.username, articles.title  
FROM `comments` 
INNER JOIN `users` ON comments.user_id = users.id 
INNER JOIN `articles` ON comments.article_id = articles.id 
WHERE comments.status = 'pending' 
ORDER BY comments.id ASC";
$resultado = mysql_query ($query, $dbConn);
while ( $row = mysql_fetch_assoc ($resultado)) {
	array_push( $arrComments,$row );
}

if ( !empty($_GET['id']) ) {
	$query = "SELECT id, comment FROM `comments` WHERE id = {$_GET['id']}";
	$resultado = mysql_query ($query, $dbConn);
	$row = mysql_fetch_assoc ($resultado);
}

include_once 'header.php';

?>
	<p class="bg-success">

	<?php if ( !empty($_GET['validated']) ) { ?>
	The comment was accepted.
	<?php } elseif ( !empty($_GET['dele']) ) { ?>
	The comment was deleted.
	<?php } elseif ( !empty($_GET['edit']) ) { ?>
	The comment was modified.
	
	<?php } ?>
	</p>
	<div>
		<h3>Pending comments list</h3>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#id</th>
					<th>Comment</th>
					<th></th>
				</tr>
			</thead>

			<?php foreach ($arrComments as $comment) { ?>
			<tr>
				<td><?php echo $comment['id']; ?></td>
				<td>
					<?php echo $comment['comment']; ?><br />
					<i><b><?php echo $comment['username']; ?></b> said in <a href="../article.php?id=<?php echo $comment['article_id']; ?>"><?php echo $comment['title']; ?></a></i>
				</td>
				<td>
					<a href="comments.php?valid=<?php echo $comment['id']; ?>" class="btn btn-success">Accept</a>
					<a href="comments.php?id=<?php echo $comment['id']; ?>" class="btn btn-warning">Edit</a>
					<a href="comments.php?del=<?= $comment['id'] ?>" class="btn btn-danger">Delete</a>
			</tr>
			<?php } ?>
		</table>
	</div>
	
	<?php if ( !empty($_GET['id']) ) { ?>
		<div>
			<h3 id="add">Edit comment</h3>
			<?php if (!empty($error)) { ?>
				<ul>
				<?php foreach ($error as $message) { ?>
					<li><?= $message ?></li>
				<?php } ?>
				</ul>
			<?php } ?>
			<form action="comments.php" method="post">
				<div class="form-group">
					<label for="user">Comment</label>
					<textarea class="form-control" rows="3" cols="50" name="comment" id="comment"><?php echo $row['comment']; ?></textarea>
				</div>

				<input name="id" type="hidden" value="<?php echo $row['id']; ?>" />

				<div class="form-group">
					<input name="submitEdit" type="submit" value="Edit comment" class="btn btn-primary" />
				</div>
			</form>
		</div>
	<?php }

	include_once 'footer.php'; ?>

