<?php

session_start();
if (!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/Business.php';
include __root . 'controllers/EventController.php';
include __root . 'controllers/ReviewsController.php';
include __root . 'controllers/MostPopularController.php';

$db = Connect::dbConnect();
$businessview = new BusinessDAO();
$eventController = new EventConnect($db);
$reviewController = new Admin($db);
$rating = new Ratings($db);
$error_text=$fname=$review=$email_error=""; 
$error = null;

if(!isset($_SESSION['LoggedIn']['UserId'])) {
    header("Location: " . __httpRoot);
    exit;
}

if(isset($_SESSION['LoggedIn']['BusinessId'])) {
    try{
        $businessdetails = $businessview->getBusinessInfo($db,$_SESSION['LoggedIn']['BusinessId']);
        $events = $eventController->getEventList($_SESSION['LoggedIn']['BusinessId']);
        $reviews = $reviewController->displayreviewsbybusinessid($_SESSION['LoggedIn']['BusinessId']);
    } catch (Exception $e) {
        $error = $e;
    }
} elseif (isset($_SESSION['LoggedIn']['UserId']) && isset($_GET['id'])) {
    try {
        $businessdetails = $businessview->getBusinessInfo($db, $_GET['id']);
        $events = $eventController->getEventList($_GET['id']);
        $reviews = $reviewController->displayreviewsbybusinessid($_GET['id']);
    } catch (Exception $e) {
        $error = $e;
    }
}

if(isset($_POST['like'])) {
    $row4 = $reviewController->getlikes($_POST['post_id']);
}

if(isset($_GET['id'])){
    $businessId = $_GET['id'];
} else {
    $businessId = $_SESSION['LoggedIn']['BusinessId'];
}
$businessdetails = $businessview->getBusinessInfo($db,$businessId);
$events = $eventController->getEventList($businessId);
$reviews = $reviewController->displayreviewsbybusinessid($businessId);
$ratings = $rating->getmostpopularbyId($businessId);
$totalreview = $reviewController->getCountReviews($businessId);


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
    <?php if(is_a($error, "Exception")):?>
        <div class="alert alert-danger">
            <?php echo $error->getMessage(); ?>
        </div>
    <?php endif;?>
    <?php foreach($businessdetails as $bd): ?>
    <div class="row">
        <div class="col-md-3">
                <h1 class=""><?php echo $bd['businessName']; ?></h1>
                <i style="color:green" class="fa fa-check-square"></i> Still In Business
                <div class="ratings">
                    <span>
                        <?php foreach($ratings as $star) :
                            echo $star->Average_Rating; ?>(Out of 5) <span class="glyphicon glyphicon-star"></span>
                        <?php endforeach; ?>
                    </span>
                    <span><?php foreach($totalreview as $tr): echo $tr['totalreview']; endforeach; ?> Reviews</span><br/><br/>
                </div>
                <?php if(($_SESSION['LoggedIn']['UserRole'] == 'normal')): ?>
                    <div>
                        <a href="<?php echo __httpRoot . "Business/addReviews.php?id=" .$businessId; ?>" class="btn btn-danger" role="button">Leave A Review</a><br /><br/>
                        <a href="<?php echo __httpRoot . "Business/suggestionForm.php?id=" .$businessId; ?>" class="btn btn-info" role="button">Make Suggestion</a>
                    </div>
                <?php endif; ?>

                <?php if(($_SESSION['LoggedIn']['UserRole']== 'business')&&(!isset($_GET['id']))) :?>
                     <div>
                         <a href="<?php echo __httpRoot . "Business/SuggestionAdmin.php?id=" .$businessId; ?>" class="btn btn-info">Manage Suggestions</a></span><br /><br />
                         <a href="<?php echo __httpRoot . "Business/Discounts.php?id=" .$businessId; ?>" class="btn btn-info">Manage Discount</a></span>
                    </div>
                <?php endif; ?>
        </div>
        <div class="col-md-9">
            <img title="profile image" class="img-responsive" src="https://unsplash.it/850/275?image=<?php echo $bd['imageId']; ?>">
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
                <div class="panel-heading">
                    Website <i class="fa fa-link fa-1x"></i>
                </div>
                <div class="panel-body">
                    <a href="#" class=""><?php echo $bd['businessName'] ?>.com</a>
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

        <!-----------------------------------------BUSINESS MAIN (KEVIN)------------------------------------>
        <div class="col-sm-9" contenteditable="false" >
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $bd['businessName']; ?> Description<span class="pull-right">
                <?php if(($_SESSION['LoggedIn']['UserRole']== 'business')&&(!isset($_GET['id']))): ?>
                        <a href="<?php echo __httpRoot . "Business/updateBusiness.php?id=" .$businessId; ?>">Update Details</a></span>
                <?php endif; ?></div>
                <div class="panel-body"><?php echo $bd['businessDescription']; ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" contenteditable="false">Events<span class="pull-right">
                <?php if(($_SESSION['LoggedIn']['UserRole']== 'business')&&(!isset($_GET['id']))): ?>
                    <a href='<?php echo __httpRoot . "Event\Create.php";?>' >Add New Event</a>
                <?php endif; ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <!-----------------------------------------EVENTS (CHEN)------------------------------------>
                        <?php foreach($events as $event): ?>
                            <div class="col-sm-4 fixheight">
                                <div class="thumbnail">
                                    <img alt="300x200" src="https://unsplash.it/320/150?image=<?php echo $event->getImage();?>">
                                    <div class="caption">
                                        <h4 class="pull-right">$<?php echo $event->getPrice();?></h4>
                                        <h4>
                                            <a href='<?php echo __httpRoot . "Event/Event.php?id=" . $event->getEventId(); ?>'><?php echo $event->getName(); ?></a>
                                        </h4>
                                        <p><?php echo $event->getDescription(); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php if($_SESSION['LoggedIn']['UserRole'] == "normal"):?>
                <?php include "addReviews.php";?>
            <?php endif;?>
            <?php include "Business_reviews.php";?>
        </div>
    <?php endforeach; ?>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
    <script src='<?php echo __httpRoot . 'assest\js\Business.js'?>'></script>
<?php include(__root."views/components/footer.php"); ?>

</div>
</body>

</html>
