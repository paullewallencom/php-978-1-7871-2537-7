<?php

require_once 'admin/config.php';
require_once 'admin/connection.php';

$dbConn = connect();

if (!empty($_POST['submit'])) {

    if (!empty($_POST['username'])) {
        $username = $_POST['username'];}

    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
    }

    if (!empty($_POST['re-password'])) {
        $rePassword = $_POST['re-password'];
    }

    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
    }

    if (empty($username)) {
        $error['username'] = 'Please enter the username';
    }

    if (empty($password)) {
        $error['password'] = 'Please enter the password';
    }

    if (empty($email)) {
        $error['email'] = 'Please enter the email';
    }

    if ($_POST['password'] !== $_POST['re-password']) {
        $error['re-password'] = 'Passwords do not match';
    }

    if ( empty($error) ) {
        $query  = 'INSERT INTO `users` (username,password,email) VALUES (\'' . $username . '\',\'' . md5($password) . '\',\'' . $email . '\')';
        $result = mysql_query($query, $dbConn);

        header( 'Location: index.php?register=true' );
        die;
    }
}
?>

<?php
    include_once 'header.php';
?>

    <h1>Register</h1>

    <?php if (!empty($error)) : ?>
        <ul>
        <?php foreach ($error as $message) : ?>
            <li><?php echo $message; ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="signup.php" method="post">

        <div class="form-group">
            <label for="user">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo (!empty($username) ? $username : ''); ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo (!empty($password) ? $password : ''); ?>">
        </div>

        <div class="form-group">
            <label for="re-password">Repeat Password</label>
            <input type="password" class="form-control" id="re-password" name="re-password" placeholder="Repeat password" value="<?php echo (!empty($rePassword) ? $rePassword : ''); ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo (!empty($email) ? $email : ''); ?>">
        </div>

        <div class="form-group">
            <input name="submit" type="submit" value="Sign up" class="btn btn-primary" />
        </div>


    </form>

<?php include_once 'footer.php'; ?>