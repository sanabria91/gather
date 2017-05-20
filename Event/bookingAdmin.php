<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/bookingController.php';

$db = Connect::dbConnect();

session_start();

?>

<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    <?php include(__root."views/components/globalhead.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Event | Gather</title>
    <style>
        .button {
            margin-left: 16px;
        }
    </style>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">
<?php

$mybooking = new Booking($db);
$list = $mybooking->bookingList();



echo "<h1>List of Bookings</h1>";

echo "<table id='rounded-corner'>
<thead>
<tr>
<th scope='col' class='rounded-company'>Title</th>
<!--<th scope='col' class='rounded-company'>UserName</th>-->
<th scope='col' class='rounded-company'>Action</th>
</tr>
</thead>";
foreach ($list as $l)
{
    echo "
                <tbody>
                    <tr>
                        <td><a href='bookingAdmin.php?id=" . $l->id . "'>" . $l->user_name . "</a></td>
                    
                        <td id='rowbtn'><form action=\"deleteBookingAdmin.php\" method=\"post\">
                            <input type=\"hidden\" value='" . $l->id . "' name=\"id\">
                            <input id='btn1' class='button btn btn-primary btn-sm' type=\"submit\" name=\"delete\" value=\"Delete\" onClick=\"javascript: return confirm('Do you really want to delete this?');\"/>
                            </form>
                            
                            </td>
                    </tr>
                </tbody>
          
    ";
}

echo "</table>";
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $details = $mybooking->bookingDetails($id);
}

if(isset($details))
{
    echo "<h2>Booking Details</h2>";
    echo "<b>Time: </b>" . $details->time . "<br/>";
    echo "<b>Number of People: </b>" . $details->num_of_people . "<br/>";
    echo "<b>User name: </b>" . $details->user_name;
}

include(__root."views/components/footer.php");
?>
</div>
</body>
</html>
