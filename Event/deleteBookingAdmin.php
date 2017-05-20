<?php

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/bookingController.php';

$db = Connect::dbConnect();

session_start();

$mybooking = new Booking($db);

if(isset($_POST['delete']))
{
    $id = $_POST['id'];
    $delete = $mybooking->deleteBooking($id);
    if($delete == 1) {
        header("Location: bookingAdmin.php");
    }
}

?>
