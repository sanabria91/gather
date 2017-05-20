<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/Business.php';


$db = Connect::dbConnect();

$business = new BusinessDAO();

session_start();

if(!isset($_SESSION['LoggedIn']['UserId'])) {
    header("Location: " . __httpRoot);
    exit;
}

$_SESSION['LoggedIn']['BusinessId'];


$list = $business->getAll($db);

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
<h1>List of Businesses</h1>

    <div class="table-responsive">
    <table class="table">
        <tr>
            <th>Business Name</th>
            <th>Description</th>
            <th>Capacity</th>
        </tr>
        <?php foreach($list as $listbus): ?>
        <tr>
            <td><a href="<?php echo __httpRoot . "Business/Business.php?id=" . $listbus->id; ?>"><?php echo $listbus->businessName; ?></a></td>
            <td><?php echo $listbus->businessDescription; ?></td>
            <td><?php echo $listbus->businessCapacity; ?></td>
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
