<?php

session_start ();

require_once 'admin/config.php';
require_once 'admin/connection.php';
require_once 'admin/isUser.php';

$dbConn = connect();

if (!empty( $_SESSION['username']) && !empty($_SESSION['password'])) {
    if (isUser($_SESSION['username'], $_SESSION['password'], $dbConn)) {
        header( 'Location: index.php' );
        die;
    }
}

if (!empty($_POST['submit'])) {

    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
    }

    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
    }

    if (empty($username)) {
        $error['username'] = 'Please enter username';
    }

    if (empty($password)) {
        $error['password'] = 'Please enter password';
    }

    if (empty($error)) {
        if ($arrUser = isUser($username, md5($password), $dbConn)) {

            $_SESSION['username'] = $arrUser['username'];
            $_SESSION['password'] = $arrUser['password'];

            header('Location: index.php');
            die;

        } else {
            $error['noExists'] = 'Password is not correct';
        }
    }
}

?>

<?php
    include_once 'header.php';
?>

    <h1>Log in</h1>

    <?php if (!empty($error)) : ?>
        <ul>
        <?php foreach ($error as $message) : ?>
            <li><?php echo $message ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="login.php" method="post">
        <div class="form-group">
            <label for="user">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo (!empty($username) ? $username : ''); ?>">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo (!empty($password) ? $password : ''); ?>">
        </div>

        <div class="form-group">
            <input name="submit" type="submit" value="Sign up" class="btn btn-primary" />
        </div>

    </form>

<?php include_once 'footer.php'; ?>