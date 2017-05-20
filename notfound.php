<?php
//by chen
     if(!defined("__root")) {
        require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
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
    <style>
        img.not-found {width: 100%}
        h1.not-found-title {
            text-align: center
        }
    </style>
  </head>
  <body>
      <div class="container" id="wrapper">
        <header>
            <div class="row" id="header">
                <div class="col-xs-3 col-xs-offset-1"><p id="head"><a href="#">CREATE A GATHERING</a></p></div>
                <div class="col-xs-2 col-xs-offset-1"><a href="#"><img src="assest/images/gather_logo.png" id="logo"></a></div>
                <div id="login">
                    <nav class="navbar" role="navigation">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
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
                                                <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                                                    <div class="form-group">
                                                        <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                        <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" required="">
                                                        <div class="help-block text-right"><a href="">Forget the password ?</a></div>
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
    <img src='<?php echo __httpRoot . "assest/images/notfound.png"?>' alt="Old Jadi master gave the best advices." class="not-found">
    <h1 class="not-found-title">This is not the page you are looking for!</h1>

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
	</body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assest/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>