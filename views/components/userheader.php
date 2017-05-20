<header>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" id="logo" href="#"><img src="../assest/images/gather_logo.png" class="nav_logo"></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-collapse style= collapse in" id="bs-megadropdown-tabs">

                <ul class="nav navbar-nav">
                    <?php if(isset($_SESSION['LoggedIn']) && ($_SESSION['LoggedIn']['UserRole'] ==  'normal')): ?>
                        <li><a href="<?php echo __httpRoot."Gatherings/GatherList.php"?>"><i class="fa fa-group"></i>GATHERINGS</a></li>
                    <?php endif; ?>
                        <li><a href="<?php echo __httpRoot."Event/Events.php"?>"><i class="fa fa-calendar"></i>EVENTS</a></li>
                        <li><a href="<?php echo __httpRoot."Business/BusinessList.php"?>"><i class="fa fa-money"></i>BUSINESSES</a></li>
                    <?php if(isset($_SESSION['LoggedIn']) && ($_SESSION['LoggedIn']['UserRole'] == 'business')): ?>
                        <li><a href="<?php echo __httpRoot."Business/Business.php"?>"><i class="fa fa-bank"></i>MANAGE BUSINESS</a></li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span> 
                            <strong><?php echo $_SESSION['LoggedIn']['Username'];?></strong>
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                        <ul style="background-color:white;" class="dropdown-menu">
                            <li>
                                <div class="navbar-login">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <p class="text-center">
                                                <span class="glyphicon glyphicon-user icon-size"></span>
                                            </p>
                                        </div>
                                        <div class="col-lg-8">
                                            <p class="text-left"><strong><?php echo $_SESSION['LoggedIn']['Firstname']." ".$_SESSION['LoggedIn']['Firstname'];?></strong></p>
                                            <p class="text-left small"><?php echo $_SESSION['LoggedIn']['Email'];?></p>
                                            <p class="text-left">
                                                <a href="#" class="btn btn-primary btn-block btn-sm">Update Login Details</a>
                                                <a href="#" class="btn btn-primary btn-block btn-sm">Update Profile Details</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="navbar-login navbar-login-session">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>
                                                <a href='<?php echo __httpRoot . "SignUp\loggout.php";?>' class="btn btn-danger btn-block">Sign Out</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>