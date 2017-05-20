<?php

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/PaymentsController.php';


//require_once "PaymentsController.php";
//require_once "database.php";
session_start();
$db= Connect::dbConnect();
$a=new Admin($db);

$row3=$a->getpayments($_SESSION['LoggedIn']['BusinessId']);


if(isset($_POST['delete'])){
    echo $_POST['id'];
    $id=$_POST['id'];
    $a = new Admin($db);
    $row5 = $a->deletepayment( $id);

    header("Location: StripePaymentAdmin.php");

}

?>


<h2>Payments</h2>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    th {
        background-color: #4CAF50;
        color: white;
    }

</style>

<table id="table">
    <thead>
    <tr>

        <th>Paid Date</th>

        <th>Event</th>

        <th>Amount</th>

        <th>Payment status</th>
        <th> User Email</th>
        <th>Gathering</th>
        <th> Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (isset($row3)){
        foreach($row3 as $r) {
            echo "<tr>";

            echo "<td>$r->createdtime</td>";

                $row4 = $a->geteventbyid($r->event_id);
                echo "<td>$row4->EventName</td>";

            echo "<td>$r->payment_amount</td>";
            echo "<td>$r->payment_status</td>";
            echo "<td>$r->user_email</td>";
            echo "<td>$r->gathering_id</td>";



            echo "<td style='display: inline-flex;'>";


            echo "<form method='post' action=''>
    <input type='hidden' name='id' value='$r->id'/>
    <input  type='submit' name='delete' value='Delete' onClick=\"javascript: return confirm('Do you really want to delete this record?');\"/>
</form>";

            echo "<form method='post' action='StripePaymentDetailsAdmin.php'>
    <input type='hidden' name='id' value='$r->id'/>
    <input  type='submit' name='details' value='Details' />
</form>";

            echo "</td>";
            echo "</tr>";



        }
    }


    ?>
    </tbody>
</table>




