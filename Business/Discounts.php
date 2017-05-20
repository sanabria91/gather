<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/DiscountController.php';
include __root . 'controllers/EventController.php';


$db = Connect::dbConnect();

$discountcontroller = new DiscountDAO();

session_start();

if(!isset($_SESSION['LoggedIn']['UserId'])) {
    header("Location: " . __httpRoot);
    exit;
}

$_SESSION['LoggedIn']['BusinessId'];



$listdiscounts = $discountcontroller->getDiscountListbyBusiness($db,$_SESSION['LoggedIn']['BusinessId']);



$discounts = $discountcontroller->getDiscount($db,$_SESSION['LoggedIn']['BusinessId']);


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
<h1>Manage Promotions</h1>
        <span>
            <form action="addDiscount.php" method="get">
                <input type="submit" value="Add Promotion" name="ADD">
            </form>
            <button id="back">Go Back To Business</button><br/><br/>
        </span>
    <div class="table-responsive">
    <table class="table">
        <tr>
            <th>Title</th>
            <th>Discount(%)</th>
            <th>Event Name</th>
            <th>Start Date</th>
            <th>Expiry Date</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach($listdiscounts as $listdis): ?>
        <tr>
            <td><?php echo $listdis['title']; ?></td>
            <td><?php echo $listdis['discount']; ?></td>
            <td><?php echo $listdis['EventName']; ?></td>
            <td><?php echo $listdis['datestart']; ?></td>
            <td><?php echo $listdis['expiry']; ?></td>
            <td>
                <!--add new foreach for just promotions table-->
                <form action="updateDiscount.php" method="get">
                    <input type="hidden" value="<?php echo $listdis['id'];?>" name=id>
                    <input type="submit" value="Update" name="update">
                </form>
            </td>
            <td>
                <form action="deleteDiscount.php" method="get">
                    <input type="hidden" value="<?php echo $listdis['id'];?>" name=id>
                    <input type="submit" value="Delete" name="delete">
                </form>
            </td>
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
    <script>
        var btn = document.getElementById('back');
        btn.addEventListener('click', function() {
            document.location.href = 'Business.php';
        });
    </script>
</body>
</html>
