<?php

//Declare session at very beginning
session_start();

//Set web config in case there is a routing error
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

//Include all controllers being used and db connect files
include __root . 'DbConnect/connect.php';
include __root . 'controllers/newsfeedController.php';

//Set the session id as the logged in user so that I keep track of the user
$_SESSION['user_id']= $_SESSION['LoggedIn']['UserId'];

//Connect to the database
$db= Connect::dbConnect();


//Set all empty variables as empty strings for now so that they can be used later
$newsfeed_post = '';
$dateposted=date('Y-m-d');

//Instantiate so that I can get the user details from the newsfeed class in controller so that I can track all the user's informtion and use it in case of posting
$userInfo = new newsfeedController($db);
$usersDetails = $userInfo->selectUserDetails($db, $_SESSION['user_id']);

$getFeed = new newsfeedController($db);
//$result = $getFeed->getAllPosts($db);

?>


<!--DECLARE HTML AND GET THE HEADER VIEW AS WELL AS GET ALL OF THE ASSETS I NEED -->
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
    <link rel="stylesheet" href='<?php echo __httpRoot . "assest/"; ?>style/profileStylsheet.css'>
    <link rel="stylesheet" href='<?php echo __httpRoot . "assest/"; ?>style/newsfeedStylesheet.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Newsfeed | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">
    <!--PAGE HEADER FOR NEWSFEED --->
    <div class="row">
        <div class="page-header" id="phdr">
            <h3 class="text-center" id="mainheaderNF">GATHERING NEWSFEED</h3>
        </div>

    </div><!--END OF ROW ONE--><br>

    <!--SIDE PANEL-->
    <div class="row">
        <div class="col-md-3" id="usernamediv">
            <h1 class="usernameHeader"><?php
                    echo $usersDetails['username'];
                 ?>
                </h1>
            <p class="userD">Full Name:<span id="deets"><?php echo ' ' .$usersDetails['firstname'] . ' ' .  $usersDetails['lastname'];?></span></p>
            <p class="userD">Email:<span id="deets"><?php echo ' '. $usersDetails['email'];?></span></p>
            <br>

<!--            <p>Hello --><?php //echo $usersDetails['username']; ?><!--, see below to compose your own post, look to the right in order to see some of the latest-->
<!--            news and to see all posts from Gathering members.</p>-->
            <div class="panel panel-default">
                <div class="panel-heading" id="posttothefeed">POST TO THE FEED<i class="label-primary"></i>

                </div>
                <div class="panel-body" id="newsfeedbody">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label class="label_message">Type your Post: </label>
<!--                        <input type="text" class='container-fluid bounceIn animated' id = "newsfeed_post" name="newsfeed_post" placeholder="Max 1000 characters" value="--><?php //echo htmlspecialchars($newsfeed_post); ?><!--">-->
                        <textarea name="newsfeed_post" class='form-control' value="<?php echo htmlspecialchars($newsfeed_post); ?>" id="newsfeed_post" rows="5" placeholder="Max 1000 characters"></textarea>
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $usersDetails['id'] ?> ">
                        <input type="hidden" name="user_name" id="user_name" value="<?php echo $usersDetails['username'] ?> ">
                        <input type="hidden" name="dateposted" id="dateposted" value="<?php echo $dateposted ?> ">
                        <br/><br/>

                        <input type="button" value="Post" id="Add" class="btn-success" name="Add">
                    </form>
                </div>
            </div>

        </div>



        <!--PANEL FOR CAROUSEL-->


        <div class="panel col-md-9">
            <div class="panel-heading" id="newsfeedhead"><span id="newsfeedDescription">LATEST NEWS STORIES</span></div>
            <div class="panel-body" id="newsfeedbody">


        <!--CAROUSEL-->
        <div id="mainCarousel" class="carousel slide " data-ride="carousel">
            <ol class="carousel-indicators">
                <li class="active" data-target="#mainCarousel" data-slide-to="0"></li>
                <li data-target="#mainCarousel" data-slide-to="1"></li>
                <li data-target="#mainCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="http://lorempixel.com/1100/500/nightlife" alt="First slide">
                </div>
                <div class="item">
                    <img src="http://lorempixel.com/1100/500/sports/1" alt="Second slide">
                </div>
                <div class="item">
                    <img src="http://lorempixel.com/1100/500/fashion" alt="Third slide">
                </div>
            </div>
        </div>
        </div>
        </div>



    </div>


    <div class="row" style="margin-top:1em;">
        <div class="col-sm-3">

            <!--LEFT COLUMN-->

            <!--Post Form-->


            <!--Social Media-->
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
<!--old styling postsheader-->
        <!--RIGHT COLUMN - NEWSFEED-->
        <div class="col-sm-9" contenteditable="false" >
            <div class="panel panel-default">
                <div class="panel-heading" id='newsfeedheadFeed' contenteditable="false"><span id="newsfeedDescription">POSTS LIVE FEED</span></div>
                <div class="panel-body" id="newsfeedbody">
                    <div class="row" id="postforeach">

                        <!--for each loop to get the posts from the database - echoed out in a table so that I could get some formatting-->
                        <?php
                        $result = $getFeed->getAllPosts($db);
                        if(count($result>0)){
                            echo "<table class='wholeTable'>";
                            foreach ($result as $post){
                                echo "<tr>";
                                echo "<td class='usernameTable'>".$post['user_name']." posted:</td>";
                                echo "<td class='dateTable'>Posted on: ".$post['dateposted']."</td>";
                                echo "</tr>";
                                echo"<tr class='postTable'><td colspan='2' >".$post['posttext']."</td></tr>";
                                if($post['likes']>0){
                                    echo"<tr class='likesTable'><td colspan='2' >".$post['likes']. ' ' . 'Likes' ;"</td></tr>";
                                }
                                echo "<tr style='padding: 10px; border-bottom: 1px #000 solid; margin-bottom: 10px;'><td class='btnTable'><div id='btnLike' data-id='".$post['id']."' class='btn btn-primary'>Like</div></td>";
                                if($post['user_id']==$_SESSION['user_id']){
                                    echo"<td class='btnTable'><div id='btnDelete' data-id='".$post['id']."' class='btn btn-danger'>Delete</div></td>";

                                }
                                else
                                {
                                    echo "<td></td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                        }



                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
    <!--LINK TO AJAX-->
        <script src='<?php echo __httpRoot . "assest/"; ?>scripts/newsfeed_script.js'></script>
</div>
</body>
</html>
