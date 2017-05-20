<?php
/**
 * @Author: mindfog, chen
 */
if (!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/LoginController.php';
include __root . 'utils/CryptoEngine.php';
include __root . 'models/LoginModel.php';

session_start();

$_db = Connect::dbConnect();

if (isset($_POST['identifier']) && isset($_POST['password'])) {
    ob_start();
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];
    
    $login = new LoginController($_db);
    $loginResult = $login->login($identifier, $password);
    header("Location: " . __httpRoot);
    ob_end_flush();
}
