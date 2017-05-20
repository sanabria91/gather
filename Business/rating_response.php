<?php

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/ReviewsController.php';

//require_once "database.php";
//require_once "ReviewsController.php";

$db= Connect::dbConnect();

//echo "test";
//$clicked_val="";
$clicked_val=$_REQUEST['clicked_val'];
$businessid=$_REQUEST['BId'];

if($clicked_val === 0 || $clicked_val > 5)
{
    echo "Please give a rating.";

}
else {

    echo $clicked_val;
    //echo $businessid;
$a=new Admin($db);
$row7=$a->insertintorating($businessid,$clicked_val);

}