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

if (!empty( $_SESSION['username'] ) && !empty($_SESSION['password'])) {
    $arrUser = isUser( $_SESSION['username'], $_SESSION['password'], $dbConn );
}
