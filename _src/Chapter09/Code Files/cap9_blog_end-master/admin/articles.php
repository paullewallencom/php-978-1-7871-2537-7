







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
	
	$query  = "DELETE FROM `articles` WHERE id = {$_GET['del']}";
	$result = mysql_query($query, $dbConn);
		
	header( 'Location: articles.php?dele=true' );
	die;
	
}

if ( !empty($_POST['submit']) ) {
	
	if ( !empty($_POST['title']) ) 		$title 		= $_POST['title'];
	if ( !empty($_POST['extract']) ) 		$extract 		= $_POST['extract'];
	if ( !empty($_POST['text']) ) 		$text 		= $_POST['text'];
	if ( !empty($_POST['category_id']) ) 	$category_id 	= $_POST['category_id'];
	if ( !empty($_POST['published_at']) ) 	$published_at 	= $_POST['published_at'];	
	
	if ( empty($title) ) 	$error['title'] 		= 'Please enter a title';
	if ( empty($extract) ) 	$error['extract'] 		= 'Please enter a extract';
	if ( empty($text) ) 	$error['text'] 		= 'Please complete the text';
	if ( empty($category_id) ) 	$error['category_id'] 	= 'Please select a category';
	
	if ( empty($error) ) {
		$created_at = date("Y-m-d H:i:s");
		$updated_at = date("Y-m-d H:i:s");
		if ( empty($published_at) ) $published_at = date("Y-m-d H:i:s");
		$user_id = $arrUser['id'];
		$query  = "INSERT INTO `articles` (title,extract,text,category_id,user_id,created_at,updated_at,published_at) VALUES ('$title','$extract','$text','$category_id','$user_id','$created_at','$updated_at','$published_at')";
		$result = mysql_query($query, $dbConn);
		header( 'Location: articles.php?add=true' );
		die;
		
	}
		
}

if ( !empty($_POST['submitEdit']) ) {
	
	if ( !empty($_POST['id']) ) 		$id 		= $_POST['id'];
	if ( !empty($_POST['title']) ) 		$title 		= $_POST['title'];
	if ( !empty($_POST['extract']) ) 		$extract 		= $_POST['extract'];
	if ( !empty($_POST['text']) ) 		$text 		= $_POST['text'];
	if ( !empty($_POST['category_id']) ) 	$category_id 	= $_POST['category_id'];
	if ( !empty($_POST['published_at']) ) 	$published_at 	= $_POST['published_at'];	
	
	if ( empty($id) ) 	$error['id'] 		= 'Article id not found';
	if ( empty($title) ) 		$error['title'] 			= 'Please enter a title';
	if ( empty($extract) ) 		$error['extract'] 			= 'Please enter the extract';
	if ( empty($text) ) 		$error['text'] 			= 'Please enter the text';
	if ( empty($category_id) ) 	$error['category_id'] 		= 'Please select a category';
	
	if ( empty($error) ) {
		
		$updated_at = date("Y-m-d H:i:s");
		if ( empty($published_at) ) $published_at = date("Y-m-d H:i:s");
		$user_id = $arrUser['id'];
		
		$query  = "UPDATE `articles` set title = '$title', extract = '$extract', text = '$text', category_id = $category_id, user_id = $user_id, updated_at = '$updated_at', published_at = '$published_at' WHERE id = $id";

		$result = mysql_query($query, $dbConn);
		
		header( 'Location: articles.php?edit=true' );
		die;
		
	}
		
}

$url = "http://localhost/categories/public/categories";
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);
$arrCategories = json_decode($result, true);


$arrarticles = array();
$query = "SELECT id, title FROM `articles` ORDER BY id DESC";
$result = mysql_query ($query, $dbConn);
while ( $row = mysql_fetch_assoc ($result)) {
	array_push( $arrarticles,$row );
}
	
if ( !empty($_GET['id']) ) {
	
	// traemos una categoria
	$query = "SELECT id, title, extract, text, category_id, published_at FROM `articles` WHERE id = {$_GET['id']}";
	$result = mysql_query ($query, $dbConn);
	$row = mysql_fetch_assoc ($result);
}

include_once 'header.php';

?>
	<p class="bg-success">
	<?php if ( !empty($_GET['add']) ) { ?>
		Article was added successfully
	<?php } elseif ( !empty($_GET['dele']) ) { ?>
		Article was deleted
	<?php } elseif ( !empty($_GET['edit']) ) { ?>
		Article was modified
	<?php } ?>
	</p>
	
	<div>
		<h3>Articles</h3>
		<table class="table table-striped">
			<thead>
			<tr>
				<th>#id</th>
				<th>Article</th>
				<th></th>
			</tr>
			</thead>

			<?php foreach ($arrarticles as $articles) { ?>
			<tr>
				<td><?php echo $articles['id']; ?></td>
				<td><?php echo $articles['title']; ?></td>
				<td>
					<a href="articles.php?id=<?php echo $articles['id']; ?>" class="btn btn-warning">Edit</a>
					<a href="articles.php?del=<?= $articles['id'] ?>" class="btn btn-danger">Delete</a>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
	
	<?php if ( empty($_GET['id']) ) { ?>
		<div>
			<h3 id="add">Add article</h3>
			<?php if (!empty($error)) { ?>
				<ul>
				<?php foreach ($error as $message) { ?>
					<li><?= $message ?></li>
				<?php } ?>
				</ul>
			<?php } ?>
			<form action="articles.php" method="post">
				<div class="form-group">
					<label for="title">Title</label>
					<input class="form-control" type="text" name="title" id="title">
				</div>
				<div class="form-group">
					<label for="category_id">Category</label>
					<select class="form-control" name="category_id">
						<option value="">Select category</option>
						<option value="">------------------------</option>
						<?php foreach ( $arrCategories as $category ) { ?>
						<option value="<?php echo $category['id']; ?>"><?php echo $category['value']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="title">Publish date (aaaa-mm-dd hh:mm:ss) i.e: 2008-10-29 17:20:00 </label>
					<input class="form-control" type="text" name="published_at" id="published_at">
				</div>
				<div class="form-group">
					<label for="extract">Extract</label>
					<textarea class="form-control" rows="3" cols="50" name="extract" id="extract"></textarea>
				</div>
				<div class="form-group">
					<label for="extract">Text</label>
					<textarea class="form-control" rows="3" cols="50" name="text" id="text"></textarea>
				</div>
				<div class="form-group">
					<input name="submit" type="submit" value="Add Article" class="btn btn-primary" />
				</div>
			</form>
		</div>
	<?php } ?>
	
	<?php if ( !empty($_GET['id']) ) { ?>
		<div>
			<h3 id="add">Edit Article</h3>
			<?php if (!empty($error)) { ?>
				<ul>
				<?php foreach ($error as $message) { ?>
					<li><?= $message ?></li>
				<?php } ?>
				</ul>
			<?php } ?>
			<form action="articles.php" method="post">
				<div class="form-group">
					<label for="title">Title</label>
					<input class="form-control" type="text" name="title" id="title" value="<?php echo $row['title']; ?>">
				</div>
				<div class="form-group">
					<label for="category_id">Category</label>
					<select class="form-control" name="category_id">
						<option value="">Select category</option>
						<option value="">------------------------</option>
						<?php foreach ( $arrCategories as $category ) { ?>
							<option value="<?php echo $category['id']; ?>" <?php if ( $category['id'] == $row['category_id'] ) echo 'selected="selected"' ?>><?php echo $category['value']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="title">Publish date (aaaa-mm-dd hh:mm:ss) Ej: 2008-10-29 17:20:00 </label>
					<input class="form-control" type="text" name="published_at" id="published_at" value="<?php echo $row['published_at']; ?>">
				</div>
				<div class="form-group">
					<label for="extract">Extract</label>
					<textarea class="form-control" rows="3" cols="50" name="extract" id="extract"><?php echo $row['extract']; ?></textarea>
				</div>
				<div class="form-group">
					<label for="extract">Extract</label>
					<textarea class="form-control" rows="3" cols="50" name="text" id="text"><?php echo $row['text']; ?></textarea>
				</div>
					<input name="id" type="hidden" value="<?php echo $row['id']; ?>" />
				<div class="form-group">
					<input name="submitEdit" type="submit" value="Edit Article" class="btn btn-warning" />
				</div>
				
				
			</form>
		</div>
	<?php }

	include_once 'footer.php';
	?>

