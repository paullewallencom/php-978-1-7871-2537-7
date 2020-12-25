<?php

session_start ();

require_once 'admin/config.php';
require_once 'admin/connection.php';
require_once 'admin/isUser.php';

$dbConn = connect();

if (!empty($_GET['logout'])) {
    session_unset();
    session_destroy();
}

if (!empty($_SESSION['username']) && !empty($_SESSION['password'])) {
    $arrUser = isUser( $_SESSION['username'], $_SESSION['password'], $dbConn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Super Blog</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="padding-top: 20px;">
<div class="container">
    <div class="header clearfix">
        <?php if (!empty($_GET['register'])) : ?>
            <div>The user was created successfully.</div>
        <?php endif; ?>
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation" class="active"><a href="index.php">Home</a></li>

                <?php if (empty($arrUser['username'])) : ?>
                    <li role="presentation"><a href="login.php">Log in</a></li>
                    <li role="presentation"><a href="signup.php">Sign up</a></li>
                <?php else : ?>

                    <?php if ($arrUser['type'] === 'admin') : ?>
                        <li role="presentation"><a href="admin/index.php">Admin Panel</a></li>
                    <?php endif; ?>
                    <li role="presentation"><a href="index.php?logout=true">Log out</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <h3 class="text-muted">Super Blog</h3>
        <?php if (!empty($arrUser['username'])) : ?>
            <p>Welcome <b><?= $arrUser['username'] ?></b></p>
        <?php endif; ?>
    </div>