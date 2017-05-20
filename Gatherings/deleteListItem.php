<?php

session_start();

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/ChecklistController.php';

$db = Connect::dbConnect();
$list = new ListDAO();


if(isset($_GET['delete'])){
    $id = $_GET['id'];
    $list->deleteItem($db,$id);

    header("Location: Gathering.php?id=4");
}