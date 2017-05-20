<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/userProfile.php';

$db= Connect::dbConnect();

if(isset($_POST['delete'])){
$id = $_POST['id'];
$query = "DELETE FROM user_profile WHERE id = :id";
$pdostmt = $db->prepare($query);
$pdostmt->bindValue(':id',$id, PDO::PARAM_INT);
$row = $pdostmt->execute();
//echo "Deleted " . $row;
header("Location: create.php");
}


?>


