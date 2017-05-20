<?php
//By Chen
 if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/Business.php';
include __root . 'controllers/EventController.php';
include __root . 'controllers/CategoryController.php';

$db = Connect::dbConnect();
$eventConnect = new EventConnect($db);
$categoryConnect = new CategoryConnect($db);
$businessview = new BusinessDAO();
$error = null;
$categories_diff = null;

try {
    $categories = $categoryConnect->getCategories();
} catch(Exception $e) {
    $error = $e;
}

$event = null;
$eventCategories = null;
$businessdetails = null;
$user = null;

session_start();

if(!isset($_SESSION['LoggedIn']['UserId'])) {
    header("Location: " . __httpRoot);
    exit;
}

if($_SESSION['LoggedIn']['UserRole'] == 'business') {
    $businessdetails = $businessview->getBusinessInfo($db,$_SESSION['LoggedIn']['BusinessId']);
} 

if(isset($_GET["id"])) {
    try {
        $event = $eventConnect->getEvent($_GET["id"]);
        $eventCategories = $categoryConnect->getEventCategories($_GET["id"]);
    } catch(Exception $e) {
        $message = $e->getMessage();
    }
    // !!useful!!
    if(!($event->getBusinessId() == $_SESSION['LoggedIn']['BusinessId']) && $_SESSION['LoggedIn']['UserRole'] == 'business') {
        $event = new Exception("This event is not yours.");
    }
    if($_SESSION['LoggedIn']['UserRole'] == 'normal' && is_a($event, "EventModel")) {
        $_SESSION['id'] = $event->getBusinessId();
        $businessdetails = $businessview->getBusinessInfo($db,$_SESSION['id']);
    }
    $categories_diff =  array_diff($categories, $eventCategories);
} else {
    $event = new Exception("Event not found!");
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

<div class="container">
    <?php if(is_a($error, "Exception")):?>
        <div class="alert alert-danger">
            <?php echo $error->getMessage();?>
        </div>
    <?php endif;?>
    <?php foreach ($businessdetails as $bd) : ?>
    <div class="row">
        <div class="col-md-3">
                <h1 class=""><a href='<?php echo __httpRoot . "Business/Business.php?id=" . $bd['id']; ?>'><?php echo $bd['businessName']; ?></a></h1>
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
                <?php if($_SESSION['LoggedIn']['UserRole'] == 'normal'):?>
                <div>
                    <button type="button" class="btn btn-danger">Leave A Review</button>
                    <button type="button" class="btn btn-info" style="margin-top:1em;">Send me a message</button>
                </div>
                <?php endif?>
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
            <?php if(is_a($event, "EventModel")): ?>
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $event->getName(); ?></div>
                <div class="panel-body">
                    <p>Description: <?php echo $event->getDescription(); ?></p>
                    <p>Start at: <?php echo $event->getStartDateTime("detail"); ?></p>
                    <p>End at: <?php echo $event->getEndDateTime("detail"); ?></p>
                    <p>Price: <?php echo $event->getPrice(); ?></p>
                    <?php if($event->getStartDateTime("detail") < date("Y-m-d H:i:s")):?>
                        <p class="alert alert-danger">Past Event</p>
                    <?php else: ?>
                        <?php if($_SESSION['LoggedIn']['UserRole'] == 'normal'):?>
                            <a href='addEventToGathering.php?id=<?php echo $event->getEventId()?>' class="btn btn-default">Add to my Gathering</a>
                        <?php else: ?>
                            <a class="btn btn-default" id="category_event_btn">Category This Event</a>
                        <?php endif;?>
                    <?php endif; ?>
                </div>
                <?php if(!is_a($eventCategories, "Exception")) :?>
                <div class="panel-footer event-categories">
                    <?php foreach($eventCategories as $eventCategory) :?>
                    <span class="label label-default"><?php echo $eventCategory->getTitle(); ?></span>
                    <?php endforeach ?>
                </div>
                <?php endif?>
            </div>

            <div class="nondisplay" id="event-category-panel">
                <div id="display-category-description"></div>
                <div class="" id="all-event-category">
                    <h4>All remaining categories</h4>
                    <?php if(isset($categories)):?>
                        <?php foreach($categories_diff as $category):?>
                            <span class="label label-primary click-add cform" data-id='<?php echo $category->getId(); ?>' data-des='<?php echo $category->getDescription();?>'><?php echo $category->getTitle()?></span>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>

                <div class="" id="event-category">
                    <h4>This Event's categories</h4>
                    <?php if(!is_a($eventCategories, "Exception")) :?>
                        <?php foreach($eventCategories as $eventCategory) :?>
                            <span class="label label-default click-remove cform" data-id='<?php echo $eventCategory->getId(); ?>' data-des='<?php echo $eventCategory->getDescription();?>'><?php echo $eventCategory->getTitle(); ?></span>
                        <?php endforeach ?>
                    <?php endif?>
                </div>
                <form action="addCategory.php" method="POST">
                    <input type="text" name="EventId" value='<?php echo $event->getEventId();?>' hidden>
                    <input type="text" name="Categories" id="form-category" hidden>
                    <input type="submit" class="btn btn-default" value="submit"/>
                </form>
            </div>

            <?php if($_SESSION['LoggedIn']['UserRole'] == 'business'):?>
            <form action='Edit.php' method='get'>
                <input type='hidden' name='id' value='<?php echo $event->getEventId(); ?>'>
                <input type='submit' value='Edit' class="btn btn-default">
            </form>
            <form action='Delete.php' method='post'>
                <input type='hidden' name='id' value='<?php echo $event->getEventId(); ?>'>
                <input type='submit'value='Delete' class="btn btn-danger">
            </form>
            <?php endif?>
            <?php elseif(is_a($event, "Exception")):?>
            <div class="alert alert-warning">
                <?php echo $event->getMessage(); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach ?>
    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
    <script src=<?php echo __httpRoot."assest\js\Event.js"?>></script>
</div>
</body>
</html>