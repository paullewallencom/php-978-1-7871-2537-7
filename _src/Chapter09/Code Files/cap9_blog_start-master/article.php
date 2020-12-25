<?
include_once 'libraries.php';

if ( !empty($_POST['submit']) ) {

    if ( !empty($_POST['comment']) ) 	$comment 	= $_POST['comment'];
    if ( !empty($_GET['id']) )		$article_id 	= $_GET['id'];
    if ( !empty($arrUser['id']))	$user_id		= $arrUser['id'];

    if ( empty($comment) ) 	$error['comment'] 		 = true;
    if ( empty($article_id) ) 	$error['article_id'] = true;
    if ( empty($user_id) ) 	$error['user_id'] 		 = true;

    if ( empty($error) ) {
        $query  = "INSERT INTO `comments` (comment, user_id, article_id) VALUES ('$comment','$user_id','$article_id')";
        $result = mysql_query($query, $dbConn);

        header ( 'Location: article.php?id='.$article_id);
        die;
    }
}

$query = "SELECT articles.id, articles.title, articles.extract, articles.text, articles.updated_at, categories.value as category, users.username FROM `articles` 
INNER JOIN `categories` ON categories.id = articles.category_id 
INNER JOIN `users` ON users.id = articles.user_id 
WHERE articles.id = " . $_GET['id'] . " LIMIT 1";
$result = mysql_query ($query, $dbConn);
$article = mysql_fetch_assoc ($result);

$arrComments = array();
$query = "SELECT comments.id, comments.comment, users.username  
FROM `comments` 
INNER JOIN `users` ON comments.user_id = users.id 
WHERE comments.status = 'valid' AND comments.article_id = " . $_GET['id'] . " 
ORDER BY comments.id DESC";

$result = mysql_query ($query, $dbConn);
while ( $row = mysql_fetch_assoc ($result)) {
    array_push( $arrComments,$row );
}


include_once 'header.php';
?>

    <h1>Article</h1>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $article['title']; ?></h3>
        </div>
        <div class="panel-body">
            <span class="label label-primary">Published</span> by <b><?php echo $article['username']; ?></b> in <i><?php echo $article['category']; ?></i> <b><?php echo date_format(date_create($article['fModificacion']), 'd/m/y h:m'); ?></b>
            <hr/>
            <?php echo $article['text']; ?>
        </div>
    </div>

    <h2>Comments</h2>
<?php foreach ($arrComments as $comment) { ?>

    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $comment['username']; ?> said</h3>
        </div>
        <div class="panel-body">
            <?php echo $comment['comment']; ?>
        </div>
    </div>
<?php } ?>

    <div>
        <?php if ( !empty( $arrUser ) ) { ?>

            <form action="article.php?id=<?php echo $_GET['id']; ?>" method="post">
                <div class="form-group">
                    <label for="user">Post a comment</label>
                    <textarea class="form-control" rows="3" cols="50" name="comment" id="comment"></textarea>
                </div>

                <div class="form-group">
                    <input name="submit" type="submit" value="Send" class="btn btn-primary" />
                </div>
            </form>

        <?php } else { ?>
            <p>Please sign up to leave a comment on this article. <a href="signup.php">Sign up</a> or <a href="login.php">Log in</a></p>
        <?php } ?>
    </div>

<?php include_once 'footer.php'; ?>
