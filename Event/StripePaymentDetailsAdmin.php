<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/PaymentsController.php';


//require_once "database.php";

//require_once "PaymentsController.php";



$id="";
$db=Connect::dbConnect();

if (isset($_POST['id'])) {
    $id = $_POST['id'];

}

$a = new Admin($db);
$row6= $a->getpaymentsbyid($id);
if(isset($row6)) {


    ?>
    <style>
        #details{
            border: solid black;
            border-radius: 8px;
            background-color: lavender;
            margin-top: 50px;

        }
        #list{
            list-style-type: none;
            margin-bottom: 10px;

        }
    </style>
    <ul id="details">
        <li id="list">ID:<?php echo  $row6->id ; ?></li>
        <li>EVENT ID:<?php echo $row6->event_id ; ?></li>
        <li>AMOUNT:<?php echo $row6->payment_amount;?></li>
        <li>PAYMENT STATUS:<?php echo $row6->payment_status;?></li>
        <li>PAID DATE:<?php echo $row6->createdtime;?></li>
        <li>USER EMAIL: <?php echo $row6->user_email; ?></li>

    </ul>




    <?php

}   //header("Location: ReviewAdmin.php");

?>
    <h3><a href="StripePaymentAdmin.php">Back to List</a></h3>


<?php
//require_once "../footer.php";

?>