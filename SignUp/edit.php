<?php
//by chen
if (!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/LoginController.php';
include __root . 'utils/CryptoEngine.php';
include __root . 'models/LoginModel.php';
include __root . 'models/UserModel.php';

$_db = Connect::dbConnect();
$login = new LoginController($_db);
$loggedIn = null;
$user = null;
$result = null;

session_start();

if(isset($_SESSION['LoggedIn']['UserId'])) {
    $loggedIn = $login->loginBySession($_SESSION['LoggedIn']['UserId']);
} else {
    header("Location: " . __httpRoot);
    exit;
}
if(isset($_POST['submit'])) {
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) &&
        isset($_POST['passwordConform']) && isset($_POST['emailConform']) && isset($_POST['firstname']) &&
        isset($_POST['lastname'])) {

        if($_POST['password'] == $_POST['passwordConform'] && $_POST['email'] == $_POST['emailConform']) {
            $user = new UserModel($_POST);
            $user->setId($_SESSION['LoggedIn']['UserId']);
        } else {
            $result = new Exception("Password and email address must be the same.");
        }
        if(is_a($user, "UserModel")) {
            $login = new LoginController($_db);
            $result = $login->editUser($user);
            if($result && !is_a($result, "Exception")) {
                header("Location: " . __httpRoot . "User\UserProfile.php");
                exit;
            } 
        } 
    } else {
        $result = new Exception("The edit is not completed!");
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
    <title> LogIn Edit | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
	<div class="container" id="wrapper">
        <?php if(is_a($result, "Exception")):?>
            <div class="alert alert-danger">
                <?php echo $result->getMessage(); ?>
            </div>
        <?php endif; ?>
        <h2>Edit Log In Details</h2>
        <form action="edit.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" value='<?php echo $loggedIn['username']?>' class="form-control"/>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" value='' class="form-control"/>
            </div>
            <div class="form-group">
                <label for="passwordConform">Password:</label>
                <input type="password" name="passwordConform" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="email">email:</label>
                <input type="email" name="email" value='<?php echo $loggedIn['email']?>' class="form-control"/>
            </div>
            <div class="form-group">
                <label for="email">email conform:</label>
                <input type="email" name="emailConform" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" name="firstname" value='<?php echo $loggedIn['firstname']?>' class="form-control"/>
            </div>
            <div class="form-group">
                <label for="middlename">Middle Name:</label>
                <input type="text" name="middlename" value='<?php 
                    if(isset($loggedIn['middlename']) && ($loggedIn['middlename'] != 'N')) 
                    {
                        echo $loggedIn['middlename'];
                    } 
                ?>' class="form-control"/>
            </div>
            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" name="lastname" value='<?php echo $loggedIn['lastname']?>' class="form-control"/>
            </div>
            <input type="submit" name="submit" value="Edit" class="btn btn-default">
        </form>
    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>