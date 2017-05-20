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
var_dump($row);

if(isset($_POST['edit'])){
    $id = $_POST['id'];
    require_once ( __root . 'DbConnect/connect.php');
    $query = "SELECT * FROM user_profile WHERE id = :id";
    $pdostmt2 = $db->prepare($query);
    $pdostmt2->bindValue(':id',$id, PDO::PARAM_INT);
    $pdostmt2->execute();
    $results = $pdostmt2->fetch();

}


if(isset($_POST['updateProfileButton'])) {
    $error_message = '';

    $user_id = $_POST['userid'];
    $user_role = $_POST['userrole'];
    $user_dob = $_POST['user_dob'];
    $current_jobtitle = $_POST['current_jobtitle'];
    $education_level = $_POST['education_level'];
    $address = $_POST['address'];
    $user_description = $_POST['user_description'];
    $pic_likes = 0;
    $id = $_POST['profileid'];
//echo "================================";
//var_dump($_FILES['profile_image']);
// $imgFile = $_FILES['profile_image']['name'];
//  $tmp_dir = $_FILES['profile_image']['tmp_name'];
//   $imgSize = $_FILES['profile_image']['size'];
    if ($_FILES['profile_image']['tmp_name'] != "") {
        $fileDimensioncheck = $_FILES['profile_image']['tmp_name'];
        list($width, $height) = getimagesize($fileDimensioncheck);

        if ($width != "300" && $height != "300") {
            $error_message = "Error : image size must be 300 x 300 pixels.";
        } else if ($width === 300 && $height === 300) {
            //unlink("images/" . $results['profile_image']);
            move_uploaded_file($_FILES["profile_image"]["tmp_name"], "images/" . $_FILES["profile_image"]["name"]);
            $profile_image = $profile_image = "images/" . $_FILES["profile_image"]["name"];
            //echo "===========";
            //var_dump($profile_image);
        }
    }


    if ($user_dob === NULL) {
        $error_message = 'You must enter a Date of Birth';
    }
    if ($address == NULL) {
        $error_message = 'Please enter an address';
    }
    if (strlen($address) < 5 || strlen($address) > 500) {
        $error_message = 'Address must be more than 5 characters and less than 500 characters';
    }
    if ($education_level == NULL) {
        $error_message = 'Please enter education level';
    }
    if (strlen($education_level) < 5 || strlen($education_level) > 200) {
        $error_message = 'Educaion Level Must be more than 5 characters and less than 200 characters';
    }
    if ($current_jobtitle == NULL) {
        $error_message = 'Please enter your current job title';
    }
    if (strlen($current_jobtitle) < 5 || strlen($current_jobtitle) > 200) {
        $error_message = 'Job title be more than 5 characters and less than 200 characters';
    }
    if ($user_description == NULL) {
        $error_message = 'Please enter your user description';
    }
    if (strlen($user_description) < 300 || strlen($user_description) > 1000) {
        $error_message = 'You must use at between 300 and 1000 characters to describe yourself';
    }


    if ($error_message != '') {
        echo $error_message;
    } else {
//
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], "images/" . $_FILES["profile_image"]["name"]);
////
////
        $profile_image = "images/" . $_FILES["profile_image"]["name"];

        require_once(__root . 'DbConnect/connect.php');
        $query = "UPDATE user_profile 
                 SET  
                 user_role = :user_role,
                 user_dob = :user_dob,
                 current_jobtitle = :current_jobtitle,
                 education_level = :education_level,
                 address = :address,
                 pic_likes = :pic_likes,
                 user_description = :user_description,
                 profile_image = :profile_image
                  WHERE user_id = :user_id AND id = :id";
        $pdostmt2 = $db->prepare($query);
        $pdostmt2->bindValue(':user_id', $user_id);
        $pdostmt2->bindValue(':user_role', $user_role);
        $pdostmt2->bindValue(':user_dob', $user_dob);
        $pdostmt2->bindValue(':current_jobtitle', $current_jobtitle);
        $pdostmt2->bindValue(':education_level', $education_level);
        $pdostmt2->bindValue(':address', $address);
        $pdostmt2->bindValue(':user_description', $user_description);
        $pdostmt2->bindValue(':pic_likes', $pic_likes);
        $pdostmt2->bindValue(':profile_image', $profile_image);
        $pdostmt2->bindValue(':id', $id);
        $row = $pdostmt2->execute();
        header('Location: user_profile_page.php');
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
    <script src='<?php echo __httpRoot . "assest/"; ?>scripts/user_profile_deletebutton.js'></script>
    <?php include(__root."views/components/globalhead.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Business | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">

    <h3>Update Profile</h3>
    <form action="updateProfile.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="profileid"  value="<?php echo $id; ?>"/>
        <input type="hidden" name="userid"  value="<?php echo $usersDetails['id']; ?>"/>
        <input type="hidden" name="userrole"  value="<?php echo $usersDetails['roleid']; ?>"/>
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow1">
            <label class="user_dob_label">DOB: </label>
            <input type="date" id="user_dob" name="user_dob" value="<?php echo $results['user_dob']; ?>">
        </div>
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow1.5">
            <label class="address_label">Address: </label>
            <input type="text" id="address" name="address" placeholder="ex: 883 Drysdale Drive, Mississauga ON, L5V 1X5" value="<?php echo $results['address']; ?>">
        </div><!--formrow1-->
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow2">
            <label class="education_level_label">Highest Education: </label>
            <input type="text" id = "education_level" name="education_level" placeholder="ex. Postgraduate Diploma in Web Development" value="<?php echo $results['education_level']; ?>">
        </div>
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow2.5">
            <label class="current_jobtitle_label">Current Job Title: </label>
            <input type="text" id = "current_jobtitle" name="current_jobtitle" placeholder="ex. Strategy Assistant at Starcom Mediavest" value="<?php echo $results['current_jobtitle']; ?>">
        </div><!--formrow2-->
        <div class="row" id="formrow4">
            <label class="user_description_label">Please write a brief description about yourself:</label><br>
            <input type="text" class="user_description" id="user_description" name="user_description" rows="2" cols="50" placeholder="Must be between 300 and 1000 characters" value="<?php echo $results['user_description']; ?>"
            <!--        <textarea input type="text" class="user_description" id="user_description" name="user_description" rows="2" cols="50" placeholder="Must be between 300 and 1000 characters" value="--><?php //echo $results['user_description']; ?><!--"></textarea>-->
        </div><!--formrow4-->
        <div class="row" id="formrow5">
            <label class="profile_image_label">Please upload a picture of yourself to be used as a profile picture. Picture must be 300px X 300px.</label><br>
            <input type="file" enctype="multipart/form-data" name="profile_image" id="profile_image" value="<?php echo $results['profile_image']; ?>"/>
            <img src="<?php echo $results['profile_image']; ?>" name="new_image" id="new_imae" value="<?php echo $results['profile_image']; ?>"/>
        </div><!--formrow5-->
        <?php
        ?>
        <input type="submit" value="Update Your Profile" name="updateProfileButton"/>
    </form>

    <script>
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#new_imae').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#profile_image").change(function(){
            readURL(this);
        });
    </script>


    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>

