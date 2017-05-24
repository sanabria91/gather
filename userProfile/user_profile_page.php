<?php

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/userProfile.php';

session_start();
if (!isset($_SESSION['user_id']) && !isset($_SESSION['profileid'])) {
    echo "Sorry, there was a problem with your profile, you will now be redirected to sign up again";
    header('Location: create.php');
}

$db= Connect::dbConnect();

$thisuserDetails = new userProfile($db);
$usersDetails = $thisuserDetails->selectUserDetails($db, $_SESSION['user_id']);

$profileDetails = new userProfile($db);
$row = $profileDetails->selectUserProfile($db, $_SESSION['profileid']);
//var_dump($row);

$id = $row['id'];


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
    <link rel="stylesheet" href='<?php echo __httpRoot . "assest/"; ?>style/profileStylsheet.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>User Profile | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">
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
    <?php if ($_SESSION['user_id'] = $usersDetails['id']) {?>
    <div class="row">
        <div class="page-header">
            <header>
                <h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="headerheader">Hello <span id="uName"><?php echo '' . $usersDetails['username']; ?></span>, view your profile below</h2>
            </header>
        </div><!--page header div-->
    </div><!--div for row of header--><br>
    <main class="userProfile">

        <!--        <div class="row" id="buttonRow">-->
        <!---->
        <!--                <form action="updateProfile.php" class="editform" method="post">-->
        <!--                    <input type="hidden" value="--><?php //echo $row['id'];?><!--" name="id">-->
        <!--                    <input type ='submit' class='btn btn-success btn-lg'  id='edit' name="edit" value="Edit Profile">-->
        <!--                </form>-->
        <!--                <input type ='submit' class='btn btn-success btn-lg'  id='deleteNotifier' name='deleteNotifier' value="Delete Profile">-->
        <!---->
        <!--               <div class="hidethedeletion" id="hidethedeletion">-->
        <!--                    <form action="deleteProfile.php" class="deleteform" id="deleteform" method="post">-->
        <!--                        <input type="hidden" value="--><?php //echo $row['id'];?><!--" name="id">-->
        <!--                        <!--                        <p class="deleteconfirmationparagraph">Are you sure you want to delete your profile? If so, you will still be registered as a user, but will need to recreate your profile.</p>-->
        <!--                      <input type ='submit' class='btn-danger'  id='delete' name='delete' value="Yes, delete my profile!">-->
        <!--                    </form>-->
        <!--                    <input type ='submit' class='btn-danger'  id='deletenope' name='deletenope' value="No thanks!">-->
        <!--                </div>-->
        <!--            </div>-->
        <!---->
        <!--            --><?php //} ?>
        <br>
        <div class="row" id="toprow">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="leftBar">
                <div class="col-lg-6 col md-6  col-sm-12 col-xs-12" id="pictureColumn">
                    <?php echo "<img src='".$row['profile_image']."' />"; ?>
                </div><!--div for pic column-->
            </div>
            <!---->
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" id="rightBar">

                <div class="options" id="options">
                    <button type="button" class="btn btn-default btn-fb responsive-width" id="hider">Edit or Delete Your Profile</button>
                    <button type="button" class="btn btn-default btn-fb responsive-width" id="hiddenhider">Click to Close Options</button><br>
                    <!--                    <h2 class="btn-fb" id="hider">Edit or Delete Your Profile</h2>-->
                    <!--                    <h2 class="btn-fb" id="hiddenhider">Edit or Delete Your Profile Bitch</h2>-->


                    <div class="editdelete" id="editdelete">
                        <form action="updateProfile.php" class="editform" method="post">
                            <input type="hidden" value="<?php echo $row['id'];?>" name="id">
                            <input type ='submit' class='btn btn-sm'  id='edit' name="edit" value="Edit Profile">
                        </form>
                        <input type ='submit' class='btn btn-sm'  id='deleteNotifier' name='deleteNotifier' value="Delete Profile">

                        <div class="hidethedeletion" id="hidethedeletion">
                            <form action="deleteProfile.php" class="deleteform" id="deleteform" method="post">
                                <input type="hidden" value="<?php echo $row['id'];?>" name="id">
                                <!--                        <p class="deleteconfirmationparagraph">Are you sure you want to delete your profile? If so, you will still be registered as a user, but will need to recreate your profile.</p>-->
                                <input type ='submit' class='btn-danger'  id='delete' name='delete' value="Yes, delete my profile!">
                            </form>
                            <input type ='submit' class='btn-danger'  id='deletenope' name='deletenope' value="No thanks!">
                        </div>
                    </div>
                    <?php } ?>
                </div><br>


                <!--                s-->

                <div class="userNameProfile" id="userNameProfile">
                    <span class="mainuName"><?php echo '' . $usersDetails['username']; ?></span>
                    <p class="usersAddress" id="label"><span class="text"><?php echo '' . $row['address']; ?></span></p>
                </div><!--username profile--><br>

                <div id="userdetails">
                    <p class="nameProfile" id="label">Full Name: <span class="text"><?php echo '' . $usersDetails['firstname'] . ' ' . $usersDetails['middlename'] . ' ' . $usersDetails['lastname']; ?></span></p>
                    <p class="usersEmail" id="label">Email: <span class="text"><?php echo '' . $usersDetails['email']; ?></span></p>
                    <p class="usersProfiledob" id="label">Date of Birth: <span class="text"><?php echo '' . $row['user_dob']; ?></span></p>
                    <p class="usersEducationLevel" id="label">Highest Educational Achievement: <br> <span class="text"><?php echo '' . $row['education_level']; ?></span></p>
                    <p class="usersJobTitle" id="label">Current Job Title: <br><span class='text'><span class="text"> <?php echo '' . $row['current_jobtitle']; ?></span></p>
                </div>



            </div>

        </div>
        <br><br>

        <div class="panel panel-default">
            <div class="panel-heading" id="descriptionhead"><span id="uNameDescription"><?php echo $usersDetails['username']?>'s Story:</span></div>
            <div class="panel-body" id="descriptionbody">
                <?php echo $row['user_description'];?></p>
            </div>
        </div>
</div>


</main>




<?php include(__root."views/components/footer.php"); ?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src='<?php echo __httpRoot . "assest/"; ?>scripts/user_profile_deletebutton.js'></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>


