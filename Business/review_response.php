
<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/ReviewsController.php';


$db= Connect::dbConnect();
$a = new Admin($db);


$fname=$_REQUEST['fname'];
$email=$_REQUEST['email'];
$review=$_REQUEST['review'];
$businessId=$_REQUEST['BID'];



$valid = true;

if ((empty($fname)) || (empty($review))) {
    $error_text = "Required field. ";
    $valid = false;

}

if (empty($email)) {
    $email_error = "Please enter email";
    $valid = false;
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_error = "Please enter valid email format";
    $valid = false;
}

header('Content-Type: application/json');
if ($valid) {

    $row = $a->insertdata($fname, $email, $review, $businessId);
    echo json_encode(array('code' => 200, 'msg' => 'success'));
} else {
    echo json_encode(array('code' => 400, 'msg' => 'not valid'));
}




