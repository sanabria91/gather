<?php
session_start();
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/gatheringsController.php';
include __root . 'controllers/EventController2.php';

$db = Connect::dbConnect();

if(isset($_GET['id'])){
    $id = $_GET['id'];
}

$gathercontroller = new gatheringsController();

$usersDetails = $gathercontroller->selectUserDetails($db, $_SESSION['LoggedIn']['UserId']);

$gathering = $gathercontroller->selectGathering($db,$id);

$gatheringUsers = $gathercontroller->getGatheringusers($db, $id);

$gatheringEvents = $gathercontroller->getEvents($db, $id);

?>

<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php include(__root."views/components/globalhead.php"); ?>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Business | Gather</title>
</head>
<body>

<?php include(__root."views/components/userheader.php"); ?>
<div class="container">
<div>Owned by <?php echo $usersDetails['username']?></div>
<div>
    <h2>People in this gathering</h2>
    <?php foreach($gatheringUsers as $user):?>
        <div>
            <p>Username: <?php echo $user['username']?></p>
            <p>Email: <?php echo $user['email']?></p>
            <p><?php echo $user['firstname']." ". $user['lastname']?></p>
        </div>
    <?php endforeach;?>
</div>
<div>
    <h2>Events in this gathering</h2>
    <?php foreach($gatheringEvents as $event):?>
        <div>
            <p>Event Name: <?php echo $event['EventName']?></p>
            <p>Business Name: <?php echo $event['businessName']?></p>
            <p>Start: <?php echo $event['StartDateTime']?></p>
            <p>End: <?php echo $event['EndDateTime']?></p>
        </div>
    <?php endforeach?>
</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<?php include(__root."views/components/footer.php"); ?>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
    <script src='<?php echo __httpRoot . 'assest\js\Business.js'?>'></script>
</body>

</html>
