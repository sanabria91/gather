<?php
if (!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/Business.php';
include __root . 'controllers/LoginController.php';


$_db = Connect::dbConnect();
$addbusiness = new BusinessDAO();
$login = new LoginController($_db);


session_start();

if (!isset($_SESSION['LoggedIn']['UserRole']) && ($_SESSION['LoggedIn']['UserRole'] == 'business')) {
    header("Location: " . __httpRoot);
}

if(isset($_POST['submit'])){

    $businessName = $_POST['businessName'];
    $businessDescription = $_POST['businessDescription'];
    $businessCapacity = $_POST['businessCapacity'];
    $userId = $_SESSION['LoggedIn']['UserId'];

    $addbusiness->addBusiness($_db,$businessName, $businessDescription, $businessCapacity, $userId);
    $loginResult = $login->loginBySession($_SESSION['LoggedIn']['UserId']);
    header("Location: addLocation.php");
}
?>

<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Gather</title>
    <!-- Bootstrap -->
    <link href='<?php echo __httpRoot . "assest/bootstrap/css/bootstrap.min.css"; ?>' rel="stylesheet">
	<link href='<?php echo __httpRoot . "assest/style/master_stylesheet.css"; ?>' rel="stylesheet">
  </head>
  <body>
	<div class="container" id="wrapper">
        <header>
            <div class="row" id="header">
                <div class="col-xs-3 col-xs-offset-1">
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                    <a href='<?php echo __httpRoot; ?>'>
                        <img src='<?php echo __httpRoot . "assest/images/gather_logo.png"; ?>' id="logo">
                    </a>
                </div>
            </div>
        </header>
        <h2>Create Business Profile</h2>
        <form action="addBusiness.php" method="POST">
            <div class="form-group">
                <label for="username">Business Name:</label>
                <input type="text" name="businessName" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="password">Description:</label>
                <input type="text" name="businessDescription" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="passwordConform">Max Capacity:</label>
                <input type="text" name="businessCapacity" value="" class="form-control"/>
            </div>
            <input type="submit" name="submit" value="Create Profile" class="btn btn-default">
        </form>
    </div>
    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>

</div>
</body>
</html>
