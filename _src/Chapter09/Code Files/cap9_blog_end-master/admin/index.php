<?php

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

include_once 'header.php';

?>

	<h1>Admin Panel</h1>
<div class="form-group">

<a class="btn btn-primary" href="categories.php">Manage Categories</a>
	<a class="btn btn-warning" href="articles.php">Manage Articles</a>
	<a class="btn btn-danger" href="comments.php">Manage Comments</a>
</div>
	<?php include_once 'footer.php'; ?>


