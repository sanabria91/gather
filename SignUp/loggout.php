<?php
//by chen
if (!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/LoginController.php';
include __root . 'utils/CryptoEngine.php';
include __root . 'models/LoginModel.php';
include __root . 'models/UserModel.php';

$_db = Connect::dbConnect();
$login = new LoginController($_db);
$loggedIn = null;
$user = null;
$result = null;

session_start();

$login->logout();
header("Location: " . __httpRoot);
exit;