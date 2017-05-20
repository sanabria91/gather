<?php

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/DiscountController.php';
include __root . 'controllers/EventController.php';


$db = Connect::dbConnect();
$discountController = new DiscountDAO();
$eventController = new EventConnect($db);

session_start();

$_SESSION['LoggedIn']['BusinessId'];

$listall = $discountController->getDiscount($db, 18);
$event = $eventController->getEventList($_SESSION['LoggedIn']['BusinessId']);


if(isset($_POST['upd'])){

    $id = $_SESSION['LoggedIn']['BusinessId'];
    $title = $_POST['title'];
    $discount = $_POST['discount'];
    $businessid = $_POST['eventid'];
    $datestart = $_POST['starttime'];
    $expiry = $_POST['expiry'];

    $list->updatePromotion($db, $title, $discount,$businessid, $datestart, $expiry, $id);
    header("Location: Discounts.php");
}





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
    <title>Business Discounts | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">
<h3>Update Promotion</h3>
<form action="updateDiscount.php" method="POST">

    <label>Title: </label><input type="text" name="title" value="<?php echo $listall['title']; ?>"/><br /><br />
    <label>Discount(%): </label><input type="text" name="discount" value="<?php echo $listall['discount']; ?>"/><br /><br />
    <label>Event Name: </label><select name="eventid">
        <?php
        foreach($event as $events){
            echo "<option value=".$events->getEventId().">".$events->getName()."</option>";
        }
        ?>
    </select><br /><br />
    <label>Date Start: </label><input type="date" name="starttime" value="<?php echo $listall['datestart']; ?>"/><br /><br />
    <label>Expiry: </label><input type="date" name="expiry" value="<?php echo $listall['expiry']; ?>"/><br /><br />
    <input type="submit" value="Update Promotion" name="upd" />
</form>
    <button id="back">Go Back To List</button>
    <br/><br/>
    <?php include(__root."views/components/footer.php"); ?>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
<script>
    var btn = document.getElementById('back');
    btn.addEventListener('click', function() {
        document.location.href = 'Discounts.php';
    });
</script>
</body>
</html>