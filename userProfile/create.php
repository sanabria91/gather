<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/userProfile.php';

//Part1 - This will act as the index page

//start the session and declare user id and user role as sessions
session_start();
$_SESSION['user_id']= 66;
//$_SESSION['user_role'] = 1;

$db= Connect::dbConnect();

$thisuserDetails = new userProfile($db);
$usersDetails = $thisuserDetails->selectUserDetails($db, $_SESSION['user_id']);
//var_dump($usersDetails);
//public function add_user_profile($db, $user_id, $user_role, $user_dob, $current_jobtitle, $education_level, $address, $user_description, $pic_likes, $profile_image)

//DECLARE INITIAL VARIABLES
$user_id=$_SESSION['user_id'];
$user_role=$usersDetails['roleid'];
$user_dob=$current_jobtitle=$education_level=$address=$user_description=$pic_likes=$profile_image='';

//NOW FOR THE CASE THE THE USER PROFIE PAG IS SET
if(isset($_POST['create_profile_submit'])) {
    $user_id = $_POST['userIdfromSession'];
    $user_role = $usersDetails['roleid'];
    $user_dob = $_POST['user_dob'];
    $current_jobtitle = $_POST['current_jobtitle'];
    $education_level = $_POST['education_level'];
    $address = $_POST['address'];
    $user_description = $_POST['user_description'];
    $pic_likes = 0;

    $fileDimensioncheck = $_FILES["profile_image"]['tmp_name'];
    list($width, $height) = getimagesize($fileDimensioncheck);

    if ($width != "300" && $height != "300") {
        $error_message = "Error : image size must be 300 x 300 pixels.";
    } else if ($user_dob === NULL) {
        $error_message = 'You must enter a Date of Birth';
    } else if ($address == NULL) {
        $error_message = 'Please enter an address';
    } else if (strlen($address) < 5 || strlen($address) > 500) {
        $error_message = 'Address must be more than 5 characters and less than 500 characters';
    } else if ($education_level == NULL) {
        $error_message = 'Please enter education level';
    } else if (strlen($education_level) < 5 || strlen($education_level) > 200) {
        $error_message = 'Educaion Level Must be more than 5 characters and less than 200 characters';
    } else if ($current_jobtitle == NULL) {
        $error_message = 'Please enter your current job title';
    } else if (strlen($current_jobtitle) < 5 || strlen($current_jobtitle) > 200) {
        $error_message = 'Job title be more than 5 characters and less than 200 characters';
    } else if ($user_description == NULL) {
        $error_message = 'Please enter your user description';
    } else if (strlen($user_description) < 300 || strlen($user_description) > 1000) {
        $error_message = 'You must use at between 300 and 1000 characters to describe yourself';
    } else {
        $error_message = '';

    }


    if ($error_message != '') {
        //echo $error_message;
    } else {

        move_uploaded_file($_FILES["profile_image"]["tmp_name"],"images/" . $_FILES["profile_image"]["name"]);


        $profile_image = ('images/' . $_FILES["profile_image"]["name"]);



        $addUserProfile = new userProfile($db);
        $addUserProfile->add_user_profile($db, $user_id, $user_role, $user_dob, $current_jobtitle, $education_level, $address, $user_description, $pic_likes, $profile_image);

        $newInsertedUserProfileId = $db->lastInsertId();

       $_SESSION['profileid'] = $newInsertedUserProfileId;
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
    <?php include(__root."views/components/globalhead.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Business | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">

<h2 class="page-header">Hello <?php echo $usersDetails['username']?>, please fill out the form below to create your profile.</h2>
    <div class="row" id="error_row">
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php } ?>
</div><!--end of error row - this is guna by default have a full width column-->
    <form action="create.php" method="post" name="mainForm" enctype="multipart/form-data"><!--enctype means for image upload-->
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="display">
            <p class="usersSignUpinfo_username">Username: <?php echo '' . $usersDetails['username']; ?></p>
            <p class="usersSignUpinfo_fullName">Full Name: <?php echo '' . $usersDetails['firstname'] . ' ' . $usersDetails['middlename'] . ' ' . $usersDetails['lastname']; ?></p>
            <p class="usersSignUpinfo_middleName">Email: <?php echo '' . $usersDetails['email']; ?></p>
        </div>
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow1">
            <label class="user_dob_label">DOB: </label>
            <input type="date" id="user_dob" name="user_dob" value="<?php echo htmlspecialchars($user_dob); ?>">
        </div>
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow1.5">
            <label class="address_label">Address: </label>
            <input type="text" id="address" name="address" placeholder="ex: 883 Drysdale Drive, Mississauga ON, L5V 1X5" value="<?php echo htmlspecialchars($address); ?>">
        </div><!--formrow1-->
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow2">
            <label class="education_level_label">Highest Education: </label>
            <input type="text" id = "education_level" name="education_level" placeholder="ex. Postgraduate Diploma in Web Development" value="<?php echo htmlspecialchars($education_level); ?>">
        </div>
        <div class="row col-lg-12 col md-12  col-sm-12 col-xs-12" id="formrow2.5">
            <label class="current_jobtitle_label">Current Job Title: </label>
            <input type="text" id = "current_jobtitle" name="current_jobtitle" placeholder="ex. Strategy Assistant at Starcom Mediavest" value="<?php echo htmlspecialchars($current_jobtitle); ?>">
        </div><!--formrow2-->
        <div class="row" id="formrow4">
            <label class="user_description_label">Please write a brief description about yourself:</label><br>
            <input type="text" class="user_description" id="user_description" name="user_description" rows="2" cols="50" placeholder="Must be between 300 and 1000 characters" value="<?php echo htmlspecialchars($user_description); ?>">
            <!--                    <textarea input type="text" class="user_description" id="user_description" name="user_description" rows="2" cols="50" placeholder="Must be between 300 and 1000 characters" value="--><?php //echo htmlspecialchars($user_description); ?><!--"></textarea>-->
        </div><!--formrow4-->
        <div class="row" id="formrow5">
            <label class="profile_image_label">Please upload a picture of yourself to be used as a profile picture. Picture must be 300px X 300px.</label><br>
            <input type="file" enctype="multipart/form-data" name="profile_image" id="profile_image">
        </div><!--formrow5-->
        <div class="row" id="formbutton">
            <input type="hidden" name="userIdfromSession" value="<?php echo $_SESSION['user_id'] ?>">
            <input type="submit" class="btn btn-success btn-lg" name="create_profile_submit" id="create_profile_submit"  value="Create Profile"><br>
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
