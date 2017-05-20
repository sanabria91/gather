<?php
//by chen
 if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/EventController.php';

session_start();

$db = Connect::dbConnect();
$eventConnect = new EventConnect($db);
$results = array();

if(isset($_SESSION['LoggedIn']['UserRole']) && ($_SESSION['LoggedIn']['UserRole'] == 'business')) {
    if(isset($_POST['Categories']) && isset($_POST['EventId'])) {
        $categories = explode("," , $_POST['Categories']);
        $eventConnect->delinkEventAndCategory($_POST['EventId']);
        foreach($categories as $category) {

            $result = $eventConnect->linkEventAndCategory($_POST['EventId'], $category);
            array_push($results, $result);
        };
        header("Location: " . __httpRoot . "Event/Event.php?id=" . $_POST['EventId']);
        exit;
    }
}
?>