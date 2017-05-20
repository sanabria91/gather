<?php
session_start();
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/gatheringsController2.php';
include __root . 'controllers/EventController.php';

$db = Connect::dbConnect();

$gathercontroller = new gatheringsController();
$eventId = null;

if(isset($_POST['add'])) {
    if(isset($_POST['gatheringId']) && isset($_POST['eventId'])) {
        $result = $gathercontroller->addEventToGathering($db, $_POST['gatheringId'], $_POST['eventId']);
        if($result) {
            header("Location: " . __httpRoot . "Event/Events.php");
            exit;
        }
    }
}

if(isset($_GET['id'])){
    $eventId = $_GET['id'];
}

$gatherings = $gathercontroller->getGathersbyUser($db,$_SESSION['LoggedIn']['UserId']);
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
<div>
    <h2>My Gathering</h2>
    <?php foreach($gatherings as $gathering):?>
        <div>
            <p>Gathering Name: <?php echo $gathering['gatheringName']?></p>
            <p>Gathering Description: <?php echo $gathering['gatheringDescription']?></p>
            <form action="addEventToGathering.php" method="POST">
                <input name="gatheringId" value='<?php echo $gathering['id']?>' hidden/>
                <input name="eventId" value='<?php echo $_GET['id']?>' hidden/>
                <input type="submit" name="add" value="Add" class="btn btn-default">
            </form>
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
