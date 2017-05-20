<?php
session_start();
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/gatheringsController2.php';


$db = Connect::dbConnect();

$gatherController = new gatheringsController();

if(!isset($_SESSION['LoggedIn']['UserId'])) {
    header("Location: " . __httpRoot);
    exit;
}

$gatherlist = $gatherController->getGathersbyUser($db,$_SESSION['LoggedIn']['UserId']);

?>
<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include(__root."views/components/globalhead.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Business Discounts | Gather</title>
</head>
<body>
    <?php include(__root."views/components/userheader.php"); ?>
<div class="container">
<h1>List of Your Gatherings</h1>
    <a class="btn btn-info" href =<?php echo __httpRoot . "Gatherings/AddGathering.php" ?> role="button">Create A New Gathering</a><br /><br />
    <div class="table-responsive">
    <table class="table">
        <tr>
            <th>Gather Name</th>
            <th>Description</th>
            <th>Creation Date</th>
            <th></th>
        </tr>
        <?php foreach($gatherlist as $listgat): ?>
        <tr>
            <td><a href="<?php echo __httpRoot . "Gatherings/Gathering.php?id=" . $listgat['id']; ?>"><?php echo $listgat['gatheringName']; ?></a></td>
            <td><?php echo $listgat['gatheringDescription']; ?></td>
            <td><?php echo $listgat['creationDate']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <?php include(__root."views/components/footer.php"); ?>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>

</body>
</html>
