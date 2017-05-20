<?php
session_start();
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/gatheringsController.php';


$db = Connect::dbConnect();

$gatherController = new gatheringsController();


if(!isset($_SESSION['LoggedIn']['UserId'])) {
    header("Location: " . __httpRoot);
    exit;
}

$_SESSION['LoggedIn']['UserId'];

if(isset($_POST['add'])){

    $gatheringName = $_POST['gatheringName'];
    $description = $_POST['gatheringDescription'];
    $locationid = $_POST['locationid'];

    $gatherController->createGathering($db, $gatheringName, $description, $locationid, $_SESSION['LoggedIn']['UserId']);
    header("Location: GatherList.php");
}

$location = $gatherController->get_location_id($db);


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
    <h3>Add Promotion For Event</h3>
<form action="addGathering.php" method="post">

    <label>Gathering Name: </label><input type="text" name="gatheringName" /><br/><br />
    <label>Description: </label><input type="text" name="gatheringDescription" /><br/><br />
    <label>Location: </label><select name="locationid">
        <?php
        foreach($location as $loc){
            echo "<option value=".$loc['id'].">".$loc['StreetName']."</option>";
        }
        ?>
    </select><br/><br/>
    <input type="submit" value="Create Gathering" name="add" />
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
        document.location.href = 'GatherList.php';
    });
</script>
</body>
</html>