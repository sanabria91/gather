<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/ReviewsController.php';


//require_once "../header.php";
//require_once "database.php";

//require_once "ReviewsController.php";
?>

<?php


$post_id="";
$db=connect::dbConnect();

if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    //var_dump($post_id);
}


//var_dump($post_id);
    $a = new Admin($db);
    $row= $a->displayalldata($post_id);
if(isset($row)) {


         ?>
        <style>
            #details{
                border: solid black;
                border-radius: 8px;
                background-color: lavender;
                margin-top: 50px;

            }
            #list{
                list-style-type: none;
                margin-bottom: 10px;

            }
        </style>
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
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Business | Gather</title>
    </head>
    <body>
    <?php include(__root."views/components/userheader.php"); ?>
    <div class="container">
    <br /><br />
    <ul id="details">
<li id="list">ID:<?php echo  $row->post_id ; ?></li>
<li>DATE:<?php echo $row->date ; ?></li>
 <li>NAME:<?php echo $row->fname;?></li>
        <li>EMAIL:<?php echo $row->email;?></li>
        <li>REVIEW:<?php echo $row->review;?></li>
        <li>Business: <?php echo $row->business_id; ?></li>
        <li>Rating: <?php echo $row->rating; ?></li>

        <li>STATUS:<?php echo $row->status;?></li>
</ul>




 <?php

}

 ?>
<h3><a href="ReviewAdmin.php">Back to reviews</a></h3>

<?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>

</div>
</body>
    </html>

<?php
include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>

</div>
</body>
</html>
