<?php

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/DiscountController.php';
include __root . 'controllers/EventController.php';

$db = Connect::dbConnect();
$discountController = new DiscountDAO();

session_start();

if(isset($_GET['delete'])){
    $id = $_GET['id'];
    $list->deletePromotion($pdoconn, $id);
    header("Location: Admin_PromotionIndex.php");
}

