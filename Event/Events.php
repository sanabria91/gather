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
$categoryConnect = new CategoryConnect($db);
$businessview = new BusinessDAO();
$events = null;
$categories = null;
$category = null;

session_start();


if(!isset($_SESSION['LoggedIn']['UserId'])) {
    header("Location: " . __httpRoot);
    exit;
}

if(isset($_GET['category'])) {
    try {
        $category = $categoryConnect->getCategory($_GET['category']);
    } catch (Exception $e) {
        $category = $e;
    }
    if(is_a($category, "CategoryModel")){
        $events = $categoryConnect->getEventsByCategory($_GET['category']);
    }
} else {
    $events = $eventConnect->getEvents();
}

$categories = $categoryConnect->getCategories();

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
    <title> All Event | Gather</title>
</head>
<body>

<?php include(__root."views/components/userheader.php"); ?>
<?php if(is_a($category, "Exception")): ?>
    <div class="alert alert-warning">
        <?php echo $category->getMessage(); ?>
    </div>
<?php endif?>
<div class="container">

    <?php if(is_a($category, "CategoryModel")): ?>
        <h1>List of <?php echo $category->getTitle(); ?> Events</h1>
    <?php else:?>
        <h1>List of Event</h1>
    <?php endif?>
    <div class="row">

        <div class="col-md-3">
            <div class="list-group">
                <?php foreach($categories as $category):?>
                <a href="<?php echo __httpRoot . "Event/Events.php?category=" . $category->getId(); ?>" class="list-group-item"><?php echo $category->getTitle();?></a>
                <?php endforeach;?>
            </div>
        </div>

        <div class="col-md-9">
        <div class="row">
        <?php if(count($events) > 0) :?>
        <?php foreach($events as $event) : ?>
            <div class="col-sm-4 fixheight">
                <div class="thumbnail">
                    <img src="http://placehold.it/320x150" alt="">
                    <div class="caption">
                        <h4 class="pull-right">$24.99</h4>
                        <h4><a href="<?php echo __httpRoot . "Event/Event.php?id=" . $event->getEventId(); ?>"><?php echo $event->getName(); ?></a>
                        </h4>
                        <p><?php echo $event->getDescription(); ?></p>
                    </div>
                    <div class="ratings">
                        <p class="pull-right">15 reviews</p>
                        <p>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning">
                No events in this category yet!
            </div>
        <?php endif;?>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>