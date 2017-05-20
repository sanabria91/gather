<?php
//by chen
if (!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/LoginController.php';
include __root . 'utils/CryptoEngine.php';
include __root . 'models/UserModel.php';

$_db = Connect::dbConnect();
$user = null;
$result = null;

session_start();
if(isset($_SESSION['LoggedIn']['UserId'])) {
    $user = $login->loginBySession($_SESSION['LoggedIn']['UserId']);
    if($user && $user['UserId'] == $_SESSION['LoggedIn']['UserId']) {
        header("Location: " . __httpRoot . "User\UserProfile.php?id=" . $user['UserId']);
        exit;
    }
}
if(isset($_POST['submit'])) {
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) &&
        isset($_POST['passwordConform']) && isset($_POST['emailConform']) && isset($_POST['firstname']) &&
        isset($_POST['lastname']) && isset($_POST['accountType'])) {

        if($_POST['password'] == $_POST['passwordConform'] && $_POST['email'] == $_POST['emailConform']) {
            $user = new UserModel($_POST);
        } else {
            $result = new Exception("Password and email address must be the same.");
        }
        if(is_a($user, "UserModel")) {
            $login = new LoginController($_db);
            $result = $login->signup($user);
            if($result && !is_a($result, "Exception")) {
                $login->login($user->getUsername(), $user->getPassword());
                header("Location: " . __httpRoot . "User\UserProfile.php");
                exit;
            } 
        } 
    } else {
        $result = new Exception("The sign up is not completed!");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Signup | Gather</title>
    <!-- Bootstrap -->
    <link href='<?php echo __httpRoot . "assest/bootstrap/css/bootstrap.min.css"; ?>' rel="stylesheet">
	<link href='<?php echo __httpRoot . "assest/style/master_stylesheet.css"; ?>' rel="stylesheet">
  </head>
  <body>
	<div class="container" id="wrapper">
        <?php if(is_a($result, "Exception")):?>
            <div class="alert alert-danger">
                <?php echo $result->getMessage(); ?>
            </div>
        <?php endif; ?>
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
        <form action="new.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="passwordConform">Password:</label>
                <input type="password" name="passwordConform" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="email">email:</label>
                <input type="email" name="email" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="email">email conform:</label>
                <input type="email" name="emailConform" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" name="firstname" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="middlename">Middle Name:</label>
                <input type="text" name="middlename" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" name="lastname" value="" class="form-control"/>
            </div>
            <div class="radio">
            <label>
                <input type="radio" name="accountType" value="business">
                I am a business owner! I want to do business on the Gather.
            </label>
            </div>
            <div class="radio">
            <label>
                <input type="radio" name="accountType" value="normal">
                I am just a regular fun lover. I look forward for some interesting events!
            </label>
            </div>
            <input type="submit" name="submit" value="Sign up" class="btn btn-default">
        </form>
        	<footer>
		<div class="row">
			<div class="col-xs-4 col-xs-offset-1">
				<p id="copyright">© Copyright Gather, 2017. All rights reserved.</p>
			</div>
			<div class="col-xs-7">
				<nav id="footer-navigation">
					<ul class="menu">
					  <div class="col-sm-4">
					  <li><a href="#">Pre-Planning</a>
						<ul>
						  <li><a href="#">Most Popular</a></li>
						  <li><a href="#">Suggestions</a></li>
						  <li><a href="#">FAQ</a></li>
						</ul>
					  </li>
					 </div>
					 <div class="col-sm-4">
					  <li><a href="#">Planning</a>
						<ul>
						  <li><a href="#">Want-To-Do List</a></li>
						  <li><a href="#">Car-Pooling</a></li>
						  <li><a href="#">Split The Bill</a></li>
						  <li><a href="#">Public Gathering</a></li>
						</ul>
					  </li>
					</div>
					 <div class="col-sm-4">
					  <li><a href="#">Post-Event</a>
						<ul>
						  <li><a href="#">Leave A Review</a></li>
						  <li><a href="#">Our guarantee</a></li>
						</ul>
					  <li><a href="#">Business Tools</a>
						<ul>
						  <li><a href="#">Offer Discounts</a></li>
						</ul>
					  </li>
					  </div>
					</ul>
				</nav>
			</div>
		</div>
	</footer>
		
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assest/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>