<?php
session_start();
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/gatheringsController.php';
include __root . 'controllers/EventController.php';
include __root . 'controllers/ChecklistController.php';

$db = Connect::dbConnect();

if(isset($_GET['id'])){
    $id = $_GET['id'];
}

$eventController = new EventConnect($db);

$gathercontroller = new gatheringsController($db);

$usersDetails = $gathercontroller->selectUserDetails($db, $_SESSION['LoggedIn']['UserId']);
$row = $gathercontroller->selectGathering($db,$id);


$events = $gathercontroller->getgatheringsEvents($db);

$gathercontroller = new gatheringsController();

$usersDetails = $gathercontroller->selectUserDetails($db, $_SESSION['LoggedIn']['UserId']);

$gathering = $gathercontroller->selectGathering($db,$id);

$gatheringUsers = $gathercontroller->getGatheringusers($db, $id);

$gatheringEvents = $gathercontroller->getEvents($db, $id);

$dataAO = new ListDAO();
$user = $_SESSION['LoggedIn']['UserId'];

$list = $dataAO->getItems($db);
if(isset($_POST['listitem'])){
    $listitem = trim($_POST['listitem']);

    if(!empty($listitem)){
        $dataAO->addItem($db,$listitem,$user);
    }
}
?>

<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php include(__root."views/components/globalhead.php"); ?>
    <link rel="stylesheet" type="text/css" href="../assest/style/todo_style.css">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Business | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h1 class=""><?php echo $row['gatheringName']; ?></h1>
        </div>
        <div class="col-md-9">
            <img title="profile image" class="img-responsive" src="http://lorempixel.com/850/250/sports">
        </div>
    </div>
    <div class="row" style="margin-top:1em;">
        <div class="col-sm-3">
            <!--------------------------------left col------------------------------->
            <ul class="list-group">
                <li class="list-group-item text-muted" contenteditable="false">Gathering's Info</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Date Created</strong></span> <?php echo $row['creationDate']?></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Status:</strong></span>Closed Group</li>
            </ul>
            <ul class="list-group">
                <li class="list-group-item text-muted">Created By: <i class="fa fa-address-book-o fa-1x"></i></li>
                <li class="list-group-item text-left"><strong class=""><?php echo $row['userid']; ?></strong></li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Gathering's Members<i class="fa fa-link fa-1x"></i></div>
                <div class="panel-body">
                    <p>Kevin</p>
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
        <!-----------GATHER MAIN------------------------->
        <div class="col-sm-9" contenteditable="false" >
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $row['gatheringName']; ?> Gathering Description</div>
                <div class="panel-body"><?php echo $row['gatheringDescription']; ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" contenteditable="false">Events<span class="pull-right"><a href="#">View More</a></span></div>
                <div class="panel-body">
                    <div class="row">
                        <?php foreach($events as $event): ?>
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <img alt="300x200" src="http://lorempixel.com/300/150/technics">
                                    <div class="caption">
                                        <h4 class="pull-right"></h4>
                                        <?php echo $event->EventName;
                                        echo $event->EventDescription;
                                        echo "<br/> ";
                                        echo '$'. $event->price;
                                        echo "<br/>";?>
                                        <span><a href="<?php echo __httpRoot . "Event/bookEvents.php?id=".$event->id ?>" class="btn btn-danger" role="button">Book</a></span>
                                        <span><a href="<?php echo __httpRoot . "Event/StripePaymentForm.php?id=".$event->id ?>" class="btn btn-info" role="button">Pay</a></span>
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
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Review</div>
                <div class="panel-body"> Insert Reviews Here. </div>
            </div>
                <!------------------ Checklist (Kevin)-------------->
                <div class="panel panel-default">
                    <div class="panel-heading">Checklist</div>
                    <div class="panel-body">
                        <?php if(!empty($list)): ?>
                            <ul class="items" id='items'>
                                <?php foreach($list as $lists): ?>
                                    <li>
                                        <span class="item<?php echo $lists['done'] ? ' done' : " "?>"><?php echo $lists['listitem'];?></span>
                                        <?php if(!$lists['done']): ?>
                                            <a href="mark.php?as=done&item=<?php echo $lists['id']?>" class="done-button" id="list">Marked As Done</a>
                                        <?php endif; ?>
                                        <div class="timestamp">
                                            <p id="details">Added by: <?php echo $lists['username']?>On: <?php echo $lists['created']?></p>
                                            <?php if($_SESSION['LoggedIn']['UserId']== $lists['user_id']) :?>
                                            <form action="updateList.php" method="get" >
                                                <input class="edit" type="hidden" value="<?php echo $lists['id']; ?>" name=id>
                                                <input class="edit" type="submit" value="EDIT" name="update">
                                            </form>
                                            <form action="deleteListItem.php" method="get" >
                                                <input class="delete" type="hidden" value="<?php echo $lists['id']; ?>" name=id>
                                                <input class="delete" type="submit" value="X" name="delete">
                                            </form>
                                        </div>
                                    <?php endif; ?>

                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>You haven't added any items yet!</p>
                        <?php endif; ?>
                        <form class="item-add" id="item-add" action="Checklist.php" method="post">
                            <input type="text" name="listitem" placeholder="Type a New Item Here" id="typedItem" class="input" autocomplete="off" required>
                            <input type="button" value="Add" id="Add" class="submit" name="Add">
                        </form>
                    </div>
                </div>
            </div>
        </div>
   <script>
        // $(document).ready(function() {
        $('#Add').click(function () {
            $.ajax({
                url: 'ajax.php',
                data: {
                    chkVal: 'Add', //value you're sending to ajax
                    message: $('#typedItem').val(),
                    //date: Date() //above is to see whcich request is getting sent to php function called ajaxFunctiom
                    //and then val is sending the actual value - u send 2 vars, 1 is to check the val the other is the val
                },
                type: 'post', //methid is to post like in form
                cache: false, //i dont want to retian, dw bout it , always put false
                success: function (data) { //on success, returns the data

                    $('#items').append(data);
                    $('#typedItem').val('');
                    $('#typedItem').focus();
                }
            });
        });
        //  });
    </script>


<?php include(__root."views/components/footer.php"); ?>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
    <script src='<?php echo __httpRoot . 'assest\js\Business.js'?>'></script>

</body>

</html>
