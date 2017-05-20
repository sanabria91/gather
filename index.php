<?php
     if(!defined("__root")) {
        require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
    }

    include __root . 'DbConnect/connect.php';
    include __root . 'controllers/LoginController.php';

    $_db = Connect::dbConnect();
    $login = new LoginController($_db);
    
    session_start();

    if(isset($_SESSION['LoggedIn']['UserId'])) {
        $user = $login->loginBySession($_SESSION['LoggedIn']['UserId']);
        if($user && $user['UserId'] == $_SESSION['LoggedIn']['UserId']) {
            header("Location: " . __httpRoot . "User\UserProfile.php?id=" . $user['UserId']);
            exit;
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
    <title>Gather</title>
    <!-- Bootstrap -->
    <link href="assest/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assest/style/master_stylesheet.css" rel="stylesheet">
  </head>
  <body>
	<div class="container" id="wrapper">
        <header>
            <div class="row" id="header">
                <div class="col-xs-3 col-xs-offset-1"><p id="head"><a href="<?php echo __httpRoot.'userProfile/create.php'?>">CREATE A PROFILE</a></p></div>
                <div class="col-xs-2 col-xs-offset-1"><a href="#"><img src="assest/images/gather_logo.png" id="logo"></a></div>
                <div id="login">
                    <nav class="navbar" role="navigation">
                        <ul class="nav navbar-nav">

                            <li>
                                <a href="<?php /*echo __httpRoot.'userProfile/create.php'*/?>">
                                    <strong>SIGN UP</strong></a>
							</li>
							

                            <li class="dropdown">
                                <a href='<?php echo __httpRoot . "SignUp/new.php"?>' class="" data-toggle="">
                                    <strong>SIGN UP</strong>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">LOGIN <span class="caret"></span></a>
                                <ul id="login-dp" class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                Login via
                                                <div class="social-buttons">
                                                    <a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
                                                    <a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> Twitter</a>
                                                </div>
                                                or
                                                <form class="form" role="form" method="post" action="checklogin.php" accept-charset="UTF-8" id="login-nav">
                                                    <div class="form-group">
                                                        <label class="sr-only" for="identifier">UserName or Email Address</label>
                                                        <input type="text" name="identifier" class="form-control" id="exampleInputEmail2" placeholder="User Name" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                        <input type="password" name="password" class="form-control" id="exampleInputPassword2" placeholder="Password" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"> keep me logged-in
                                                        </label>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="bottom text-center">
                                                New here ? <a href="#"><b>Join Us</b></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                    </nav>
                </div>
            </div>
        </header>
        <section class="row" id="banner">
            <div class="col-xs-12">
                <img src="assest/images/main_image_notext.png" id="main" class="img-responsive" />
                <div id="main_message">
                    <p class="big_text">begin gathering</p><p class="big_text">with purpose</p><p class="subtext">create you own gathering now</p>
                    <a href='<?php echo __httpRoot . "SignUp/new.php"?>' class="btn btn-primary" role="button">SIGN UP</a>
                </div>
            </div>
        </section>
        <section class="row">
            <h2 class="col-xs-8 col-xs-offset-2 text-center">Definition of a Plan in Modern Times:</h2>
            <p class="col-xs-8 col-xs-offset-2 text-center">A string of noncommittal text messages leading up to a series of potential, though unlikely, events.</p>
            <p class="col-xs-8 col-xs-offset-2 text-center">Leave the flakiness back in the ceral aisle and begin planning with <span>gather</span></p>
        </section>

        <h3 class="text-center">How Does It Work?</h3>
        <section class="row" id="icons">
            <div id="first" class="col-sm-3 col-xs-8 col-xs-offset-2">
                <div class="img_box">
                    <img src="assest/images/Icon1.png" class="icon"/>
                </div>
                <h4 class="text-center">START A GATHERING</h4>
                <p>Begin one of the old rituals in human history. Invite your group to commonarea, where all the decision will be made. </p>
            </div>
            <div class="col-sm-3 col-sm-offset-1 col-xs-8 col-xs-offset-2">
                <div class="img_box">
                    <img src="assest/images/Icon2.png" class="icon"/>
                </div>
                <h4 class="text-center">PLAN ALL THE DETAILS</h4>
                <p>As a group, beginning planning all the details. Discover new events, vote on the location reserve your spot, split the bill, figure out logistics and plan the carpooling -
                    ALL IN  ONE SPOT</p>
            </div>
            <div class="col-sm-3 col-sm-offset-1 col-xs-8 col-xs-offset-2">
                <div class="img_box">
                    <img src="assest/images/Icon3.png" class="icon" />
                </div>
                <h4 class="text-center">ENJOY THE FUN</h4>
                <p>Enjoy the new experience and ponder how you ever made plans without <span>gather</span></p>
            </div>
        </section>
        <section class="row">
            <h3 class="text-center">Where Do You Start?</h3>
            <section class="col-md-6 col-xs-12 call-to-action">
                <h2>Are You A Gatherer?</h2>
                <p>Begin taking advantage of all of gather's tools and discover what you have been missing.<p><a href="#">CREATE A GATHERING</a></p>
            </section>
            <section class="col-md-6 col-xs-12 call-to-action">
                <h2>Are You A Business Owner?</h2>
                <p>If you have an event space or want help setting up your offering for other Gatherers to taken advantage of then, then click below.</p><p><a href="#">HOST AN EVENT</a></p>
            </section>
        </section>
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