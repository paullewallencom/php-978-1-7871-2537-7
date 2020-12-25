<?

session_start ();

require_once 'config.php';
require_once 'connection.php';
require_once 'isUser.php';

include_once '../Controller.php';

$controller = new Controller();
$dbConn = connect();

if ( !empty( $_SESSION['username'] ) && !empty($_SESSION['password']) ) {
	$arrUser = isUser( $_SESSION['username'], $_SESSION['password'], $dbConn );
}

if ( empty($arrUser) || $arrUser['type'] != 'admin' ) {
	header( 'Location: ../index.php' );
	die;
}

if ( !empty($_GET['del']) ) {

	$controller->call("http://localhost/categories/public/category/".$_GET['del'], "DELETE");

	header( 'Location: categories.php?dele=true' );
	die;
}

if ( !empty($_POST['submit']) ) {
	if ( !empty($_POST['name']) ) 	$name 	= $_POST['name'];
	if ( empty($name) ) 	$error['name'] 		= 'Please enter category name';
	if ( empty($error) ) {

		$controller->call("http://localhost/categories/public/category", "POST", $name);

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

		$controller->call("http://localhost/categories/public/category/".$id, "PUT", $name);

		header( 'Location: categories.php?edit=true' );
		die;
	}
		
}

$arrCategories = $controller->call("http://localhost/categories/public/categories", "GET");


if ( !empty($_GET['id']) ) {

	$row = $controller->call("http://localhost/categories/public/category/".$_GET['id'], "GET");
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

			<?php foreach ($arrCategories as $category) { ?>
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
					<input name="name" class="form-control" type="text" value="<?php echo $row['value']; ?>" />
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
	

