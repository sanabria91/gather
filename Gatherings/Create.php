<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/gatheringsController.php';
//include __root . 'controllers/EventController.php';

$db = Connect::dbConnect();
//$businessview = new BusinessDAO();
//$eventController = new EventConnect($db);

session_start();

$_SESSION['user_id']= 66;

$thisuserDetails = new gatheringsController($db);
$usersDetails = $thisuserDetails->selectUserDetails($db, $_SESSION['user_id']);

$locationList = new gatheringsController($db);
$locationResult=$locationList->get_location_id($db);


$userid = $_SESSION['userid']= 66;
$gatheringName=$gatheringDescription=$creationDate=$locationid='';

//ADD GATHERING

if (isset($_POST['create_gathering_submit'])){
//declare vars
    $userid = $_SESSION['userid'];
    $gatheringName=$_POST['gatheringName'];
    $gatheringDescription=$_POST['gatheringDescription'];
    $creationDate=$_POST['creationDate'];
    $locationid=$_POST['locationid'];


    if ($userid == NULL) {
        $error_message = "Error : There was an issue with your UserId, please try again";
    } else if ($gatheringName == NULL) {
        $error_message = 'You must enter a name for your Gathering';
    } else if (strlen($gatheringName) < 5 ||  strlen($gatheringName) > 50) {
        $error_message = 'Sorry, the length of your Gathering Name must be between 5 and 50 characters';
    } else if ($gatheringDescription == NULL) {
        $error_message = 'Please enter a description for your Gathering';
    } else if (strlen($gatheringDescription) < 20 ||  strlen($gatheringDescription) > 150) {
        $error_message = 'Sorry, the length of your Gathering description must be between 20 and 150 characters';
    } else if ($locationid == NULL) {
        $error_message = 'Please select a location from our dropdown list';
    } else {
        $error_message = '';

    }


    if ($error_message != '') {
        //echo $error_message;
    } else {


        $addGathering = new gatheringsController($db);
        $addGathering->createGathering($db, $gatheringName, $gatheringDescription, $creationDate, $locationid, $userid);
        $newInsertedGatherId = $db->lastInsertId();

        $_SESSION['gatherid'] = $newInsertedGatherId;
        //var_dump($newInsertedGatherId);
       header('Location: gatheringsPage.php');
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
    <title>Business | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">

    <h2 class="page-header">Hello <?php echo $usersDetails['username']?>, please fill out the form below in order to begin creating your Gathering.</h2>
    <div class="row" id="error_row">
        <?php if (!empty($error_message)) { ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php } ?>
    </div><!--end of error row - this is guna by default have a full width column-->
    <form action="create.php" method="post" name="mainForm" enctype="multipart/form-data"><!--enctype means for image upload-->
<!--        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="display">-->
<!--            <p class="usersSignUpinfo_username">Username: --><?php //echo '' . $usersDetails['username']; ?><!--</p>-->
<!--        </div>-->
<!--        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow1">-->
<!--            <label class="user_dob_label">DOB: </label>-->
<!--            <input type="date" id="user_dob" name="user_dob" value="--><?php //echo htmlspecialchars($user_dob); ?><!--">-->
<!--        </div>-->
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow1.5">
            <label class="address_label">Gathering Name: </label>
            <input type="text" id="gatheringName" name="gatheringName" placeholder="ex: Staley Cup Champs 2017" value="<?php echo htmlspecialchars($gatheringName); ?>">
        </div><!--formrow1-->
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow2">
            <label class="education_level_label">Your Gathering's Description: </label>
            <input type="text" id = "gatheringDescription" name="gatheringDescription" placeholder="Must be between 20 and 150 characters"<?php echo htmlspecialchars($gatheringDescription); ?>">
        </div>
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow2.5">
            <label for="LocationId">Select Your Locaton:</label>
                <select name="locationid">
                    <?php
                    foreach ($locationResult as $key){
                        ?><option value="<?php echo $key['Id']; ?>" name="locationId"><?php echo $key['StreetName']; ?></option>
                    <?php } ?>
                </select>
        </div><!--formrow2-->
        <div class="row" id="formbutton">
            <input type="hidden" name="userid-groupcreator" value="<?php echo $_SESSION['user_id'] ?>">
            <input type="hidden" name="creationDate" value="<?php echo date("Y-m-d") ?>">
            <input type="submit" class="btn btn-success btn-lg" name="create_gathering_submit" id="create_gathering_submit"  value="Create Gathering"><br>
        </div>
    </form>
    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>
