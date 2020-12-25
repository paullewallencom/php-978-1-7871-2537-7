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
	
	$query  = "DELETE FROM `categories` WHERE id = {$_GET['del']}";
	$result = mysql_query($query, $dbConn);
		
	header( 'Location: categories.php?dele=true' );
	die;
}

if ( !empty($_POST['submit']) ) {
	if ( !empty($_POST['name']) ) 	$name 	= $_POST['name'];
	if ( empty($name) ) 	$error['name'] 		= 'Please enter category name';
	if ( empty($error) ) {
		$query  = "INSERT INTO `categories` (value) VALUES ('$name')";
		$result = mysql_query($query, $dbConn);
		header( 'Location: categories.php?add=true' );
		die;
	}
}

if ( !empty($_POST['submitEdit']) ) {
	
	if ( !empty($_POST['name']) ) 		$name 		= $_POST['name'];
	if ( !empty($_POST['id']) ) 	$id 	= $_POST['id'];
	
	if ( empty($name) ) 		$error['name'] 		= 'Please enter the category name';
	if ( empty($id) ) 	$error['id'] 	= 'Id was not found!';
	
	if ( empty($error) ) {
		$query  = "UPDATE `categories` set value = '$name' WHERE id = $id";
		$result = mysql_query($query, $dbConn);
		
		header( 'Location: categories.php?edit=true' );
		die;
	}
		
}

$arrcategories = array();

$query = "SELECT id, value FROM `categories` ORDER BY value ASC";
$resultado = mysql_query ($query, $dbConn);

while ( $row = mysql_fetch_assoc ($resultado)) {
	array_push( $arrcategories,$row );
}

if ( !empty($_GET['id']) ) {
	$query = "SELECT id, value FROM `categories` WHERE id = {$_GET['id']}";
	$resultado = mysql_query ($query, $dbConn);
	$row = mysql_fetch_assoc ($resultado);
}

include_once 'header.php';

?>
	<h2>Categories</h2>
	<p class="bg-success">
	<?php if ( !empty($_GET['add']) ) { ?>
	Category was added successfully
	<?php } elseif ( !empty($_GET['dele']) ) { ?>
	Category was deleted
	<?php } elseif ( !empty($_GET['edit']) ) { ?>
	Category was modified
	<?php } ?>
	</p>
	<div>
		<h3>Category List</h3>
		<table class="table table-striped">
			<thead>
			<tr>
				<th>#id</th>
				<th>Name</th>
				<th></th>
			</tr>
			</thead>

			<?php foreach ($arrcategories as $category) { ?>
			<tr>
				<td><?php echo $category['id']; ?></td>
				<td><?php echo $category['value']; ?></td>
				<td>
					<a class="btn btn-warning" href="categories.php?id=<?php echo $category['id']; ?>">Edit</a>
					<a class="btn btn-danger" href="categories.php?del=<?= $category['id'] ?>">Delete</a>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
	
	<?php if ( empty($_GET['id']) ) { ?>
		<div>
			<h3 id="add">Add new category</h3>
			<?php if (!empty($error)) { ?>
				<ul>
				<?php foreach ($error as $message) { ?>
					<li><?= $message ?></li>
				<?php } ?>
				</ul>
			<?php } ?>
			<form action="categories.php" method="post">
				<div class="form-group">
					<label for="user">Category name</label>
					<input class="form-control" type="text" name="name" id="name"></input>
				</div>
				<div class="form-group">
					<input name="submit" type="submit" value="Add" class="btn btn-primary" />
				</div>
			</form>
		</div>
	<?php } ?>
	
	<?php if ( !empty($_GET['id']) ) { ?>
		<div class="bg-warning">
			<h3 id="add">Edit category</h3>
			<?php if (!empty($error)) { ?>
				<ul>
				<?php foreach ($error as $message) { ?>
					<li><?= $message ?></li>
				<?php } ?>
				</ul>
			<?php } ?>
			<form action="categories.php" method="post">
				<p>
					<label for="name">Category name</label><br />
					<input name="name" type="text" value="<?php echo $row['value']; ?>" />
				</p>
				<input name="id" type="hidden" value="<?php echo $row['id']; ?>" />

				<div class="form-group">
					<input name="submitEdit" type="submit" value="Edit" class="btn btn-primary" />
				</div>

			</form>
		</div>
	<?php }

	include_once 'footer.php';
	?>
	

