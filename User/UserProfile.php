<?php
//by chen
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/LoginController.php';

$_db = Connect::dbConnect();
$login = new LoginController($_db);
session_start();
$login->loginBySession($_SESSION['LoggedIn']['UserId']);

if(isset($_GET['loggout'])) {
	if($_GET['loggout'] == 'Log Out') {
		$login->logout();
        header("Location: " . __httpRoot);
        exit;
	}
}
echo var_dump($_SESSION);
if($_SESSION['LoggedIn']['UserRole'] == "business") {

    if(isset($_SESSION['LoggedIn']['BusinessId'])) {
        header("Location: " . __httpRoot."Business/Business.php");
    } else {
        header("Location: " . __httpRoot."Business/addBusiness.php");
    }

} elseif ($_SESSION['LoggedIn']['UserRole'] == "normal") {
    header("Location: " . __httpRoot."Event/Events.php");
} elseif ($_SESSION['LoggedIn']['UserRole'] == "admin") {
    header("Location: " . __httpRoot."Category/Categories.php");
}

?>