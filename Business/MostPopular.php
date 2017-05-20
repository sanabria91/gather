<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/MostPopularController.php';

//include "../header.php";

//require_once "database.php";
//require_once "MostPopularController.php";
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

<h2 style="font-size: 45px">Most Popular Business</h2>

<p style="font-size: 30px" style="font-style: italic" >List of our most popular business according to our customer ratings and reviews.</p>
<?php
$db= Connect::dbConnect();

$a=new Ratings($db);

$row=$a->getmostpopular();

 foreach ($row as $r) {  ?>

    <ul>
        <li id="heading" style="font-size: 40px"><?php echo $r->businessName; ?></li>
        <li id="rating" style="font-size: 40px"><?php echo $r->Average_Rating ."(Out of 5)" ; ?>
            <img src="<?php echo __httpRoot . "assest/"?>images/blankn.png"/>
            <img src="<?php echo __httpRoot . "assest/"?>images/blankn.png"/>
            <img src="<?php echo __httpRoot . "assest/"?>images/blankn.png"/>
            <img src="<?php echo __httpRoot . "assest/"?>images/blankn.png"/>
            <img src="<?php echo __httpRoot . "assest/"?>images/blankn.png"/>
        </li>
    </ul>

     <style>
         ul{
             list-style: none;
         }
         #heading{
             font-size: 50px;
         }
     </style>
<?php } ?>
<?php

 include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>






