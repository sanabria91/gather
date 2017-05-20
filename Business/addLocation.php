<?php
//By Chen
    if(!defined("__root")) {
        require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
    }
    include __root . "DBConnect/connect.php";
    include __root . "controllers\LocationConnect.php";
    include __root . 'controllers/Business.php';

    session_start();
    $locationConnect = new LocationConnect(Connect::dbConnect());
    $result = null;
    if(isset($_POST['subbtn'])) {
        if (isset($_POST["StreetName"]) && isset($_POST["PostalCode"]) && isset($_POST["City"]) &&
            isset($_POST["Province"]) && isset($_POST["Country"])) {
            $locationModel = new LocationModel($_POST);
            $result = $locationConnect->createLocation($locationModel);
            $locationConnect->updateLocation($_SESSION['LoggedIn']['BusinessId'], $result[1]);
            if($result[0]) {
                header("Location: " . __httpRoot . "User\UserProfile.php");
                exit;
            }
        } else {
            $result = new Exception("Form not filled");
        }
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
    <title>  Location | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>

<div class="container">
    <?php if(is_a($result, "Exception")): ?>
    <div class="alert alert-warning">
        <?php echo $result->getMessage(); ?>
    </div>
    <?php endif?>
    <h2>Add your business location</h2>
        <div>
            <form action="addLocation.php" method="POST" >
                <div class="form-group">
                    <label for="StreetName">Street Name:</label>
                    <input type="text" name="StreetName" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="PostalCode">Postal Code:</label>
                    <input type="text" name="PostalCode" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="City">City:</label>
                    <input type="text" name="City" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="Province">Province:</label>
                    <input type="text" name="Province" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="Country">Country:</label>
                    <input type="text" name="Country" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" value="submit" name="subbtn" class="btn btn-befault"/>
                </div>
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
