<?php
//by chen
 if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/Business.php';
include __root . 'controllers/EventController.php';
include __root . 'controllers/CategoryController.php';

$db = Connect::dbConnect();
$eventConnect = new EventConnect($db);
$businessview = new BusinessDAO();
$event = null;
$message = null;

session_start();

$_SESSION['id']= 3;
$_SESSION['role'] = "business";

$businessdetails = $businessview->getBusinessInfo($db,$_SESSION['id']);
if(isset($_POST["id"])) {
    try {
        $event = $eventConnect->getEvent($_POST["id"]);
    } catch(Exception $e) {
        $message = $e->getMessage();
    }
    // !!useful!!
    //if(!($event->getBusinessId() == $_SESSION['id']) && $_SESSION['role'] == 'business') {
    //    $event = new Exception("This event is not yours.");
    //}
} else {
    $event = new Exception("Event not found!");
}

    if(is_a($event, 'EventModel')) {
        $result = $eventConnect->deleteEvent($event);
        if($result) {
            header("Location: http://localhost/php_gather/Business/Business.php");
            exit;
        } else {
            $message= "Something went wrong!";
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
    <title> <?php echo $businessdetails[0]['businessName'];?> Event | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<?php if(isset($message)): ?>
    <div class="alert alert-warning">
        <?php echo $message; ?>
    </div>
<?php endif?>

<div class="container">
    <?php foreach ($businessdetails as $bd) : ?>
    <div class="row">
        <div class="col-md-3">
                <h1 class=""><?php echo $bd['businessName']; ?></h1>
                <i style="color:green" class="fa fa-check-square"></i> Still In Business
                <div class="ratings">
                    <span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                    </span>
                    <span>15 reviews</span><br/><br/>
                </div>
                <div>
                    <button type="button" class="btn btn-danger">Leave A Review</button>
                    <button type="button" class="btn btn-info" style="margin-top:1em;">Send me a message</button>
                </div>
        </div>
        <div class="col-md-9">
            <img title="profile image" class="img-responsive" src="http://lorempixel.com/850/250/nightlife">
        </div>
    </div>
    <div class="row" style="margin-top:1em;">
        <div class="col-sm-3">
            <!--left col-->
            <ul class="list-group">
                <li class="list-group-item text-muted" contenteditable="false">Business Info</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Joined</strong></span> 2.13.2014</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Capacity:</strong></span><?php echo $bd['businessCapacity']; ?></li>
            </ul>
            <ul class="list-group">
                <li class="list-group-item text-muted">Location <i class="fa fa-address-book-o fa-1x"></i></li>
                <li class="list-group-item text-left"><strong class=""><?php echo $bd['StreetName']; ?></strong></li>
                <li class="list-group-item text-left"><strong class=""><?php echo $bd['City']; ?>, <?php echo $bd['Province']; ?></strong></li>
                <li class="list-group-item text-left"><strong><?php echo $bd['PostalCode']; ?></strong></li>
                <li class="list-group-item text-left"><strong ><?php echo $bd['Country']; ?></strong></li>
             </ul>

            <div class="panel panel-default">
                <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i>

                </div>
                <div class="panel-body"><a href="#" class="">yourwebsite.com</a>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Social Media</div>
                <div class="panel-body">
                    <i class="fa fa-facebook fa-2x"></i>
                    <i class="fa fa-github fa-2x"></i>
                    <i class="fa fa-twitter fa-2x"></i>
                    <i class="fa fa-pinterest fa-2x"></i>
                    <i class="fa fa-google-plus fa-2x"></i>
                </div>
            </div>
        </div>

        <!--BUSINESS MAIN-->
        <div class="col-sm-9" contenteditable="false" >
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $bd['businessName']; ?> Information</div>
                <div class="panel-body"><?php echo $bd['businessDescription']; ?></div>
            </div>
        </div>
    </div>
    <?php endforeach ?>
    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>