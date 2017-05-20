<?php
session_start();

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/ChecklistController.php';

$db = Connect::dbConnect();


$dataAO = new ListDAO();
$_SESSION['LoggedIn']['Username'];
var_dump($_SESSION['LoggedIn']['Username']);

if(isset($_POST['chkVal'])) {

    $listitem = trim($_POST['message']);
    $user = $_SESSION['LoggedIn']['UserId'];

    if (!empty($listitem)) {
        $newId = $dataAO->addItem($db, $listitem, $user);
        if ($newId > 0) {
            $today = date("Y-m-d H:i:s");
            $newItem = "";
            $newItem .= "<li>";
            $newItem .= "<span class=\"item\">" . $_POST['message'] . "</span>";
            $newItem .= "<a href=\"mark.php?as=done&item={$newId}\" class=\"done-button\" id=\"list\">Marked As Done</a>";
            $newItem .= "<div class=\"timestamp\">";
            $newItem .= "<p id=\"details\">Added by: " . $_SESSION['LoggedIn']['Username'] . "On:" . $today . "</p>";
            $newItem .= "<form action=\"updateList.php\" method=\"get\" >";
            $newItem .= "<input class=\"edit\" type=\"hidden\" value=\" {$newId}\" name=id>";
            $newItem .= "<input class=\"edit\" type=\"submit\" value=\"EDIT\" name=\"update\">";
            $newItem .= "</form>";
            $newItem .= "<form action=\"deleteListItem.php\" method=\"get\" >";
            $newItem .= "<input class=\"delete\" type=\"hidden\" value=\"{$newId}\" name=id>";
            $newItem .= "<input class=\"delete\" type=\"submit\" value=\"X\" name=\"delete\">";
            $newItem .= "</form>";
            $newItem .= "</div>";
            $newItem .= "</li>";
            echo $newItem;
        } else {
            echo "Fail";
        }
    }
}
