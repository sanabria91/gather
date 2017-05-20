<?php
session_start();

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/gatheringsController.php';;

$db = Connect::dbConnect();

if(isset($_GET['as'], $_GET['item']))
{
    $as     = $_GET['as'];
    $item   = $_GET['item'];

    switch($as){
        case 'done':

            $doneQuery = "UPDATE to_do SET done = 1 WHERE id = :item";
            $pdostmt = $db->prepare($doneQuery);
            $pdostmt->bindValue(':item', $item);
            $pdostmt->execute();
            break;

        case 'notdone':

            $doneQuery = "UPDATE to_do SET done = 0 WHERE id = :item";
            $pdostmt = $db->prepare($doneQuery);
            $pdostmt->bindValue(':item', $item);
            $pdostmt->execute();
            break;
    }

}

header('Location: Gatherings.php?id=4');