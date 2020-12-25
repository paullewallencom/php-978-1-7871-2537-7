<?php
include_once 'libraries.php';

$arrArticles = array();
$query = "SELECT id, title, extract, text FROM `articles` WHERE created_at < '".date('Y-m-d H:i:s')."' ORDER BY published_at DESC";

$result = mysql_query ($query, $dbConn);
while ( $row = mysql_fetch_assoc ($result)) {
    array_push( $arrArticles,$row );
}

?>

<?php
    include_once 'header.php';
?>

    <div class="jumbotron">
        <h1>The best blog ever!</h1>
        <p class="lead"> From now on you can post your own articles and share your comments with other bloggers.</p>
        <?php if (empty($arrUser['username'])) : ?>
        <p><a class="btn btn-lg btn-success" href="signup.php" role="button">Sign up today</a></p>
        <?php endif; ?>
    </div>

    <div class="row marketing">
        <div class="col-lg-6">
            <h2>Last articles</h2>
            <hr/>
            <?php foreach ($arrArticles as $article) : ?>
                    <h4><a href="article.php?id=<?php echo $article['id']; ?>"><?php echo $article['title']; ?></a></h4>
                    <p><?php echo $article['extract']; ?></p>
            <?php endforeach; ?>
        </div>

        <div class="col-lg-6">
            <h4>Users who are not registered</h4>
            <p>Users who are not registered can read the articles but they are not able to post comments.</p>

            <h4>Registered Users</h4>
            <p>Registered users can post comments on the articles.</p>

            <h4>Admin Users</h4>
            <p>Admin Users can post new articles, categories and comments and even accept or denny comments posted by other users.</p>
        </div>
    </div>
<?php include_once 'footer.php'; ?>
