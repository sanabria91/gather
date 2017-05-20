<?php
session_start();
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/bookingController.php';

$db = Connect::dbConnect();

$mybooking = new Booking($db);
$list = $mybooking->listEvents();

?>

<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php include(__root."views/components/globalhead.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Business | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">

    <?php

echo "<h2 id='list'>Events Listing</h2>";
echo "<table id='rounded-corner'>
        <thead>
            <tr>
                <th scope='col' class='rounded-company'>Title</th>
                <th scope='col' class='rounded-company'>Action</th>
            </tr>
        </thead>
        <tbody>";



foreach ($list as $l) {
    echo "
    <tr>
    <td>
        <a href='bookings.php?id=" . $l->id . "'>" . $l->EventName . "</a>
    </td>
    <td>
        <form action=\"bookEvents.php\" method=\"post\">
        <input type=\"hidden\" value='" . $l->id . "' name=\"id\">
        <input id='btn1' class='button btn btn-primary' type=\"submit\" name=\"book\" value=\"Book\"/>
        </form>
    </td>
    </tr>
    ";
}
echo "</tbody></table>";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $details = $mybooking->eventDetails($id);
}

if(isset($details))
{
    echo "<h2>Event Details</h2>";
    echo "<b>Event Name: </b>" . $details->EventName . "<br/>";
    echo "<b>Description: </b>" . $details->EventDescription . "<br/>";
    // echo "<b>Description: </b>" . $details->capacity . "<br/>";
}

    include(__root."views/components/footer.php"); ?>
</div>
</body>
</html>
