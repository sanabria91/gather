<?php

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/ImageGalleryController.php';


//include_once "../header.php";
//require_once "database.php";
//require_once "ImageGalleryController.php";
$db= connect::dbConnect();

$a=new Admin($db);

//get event id
$id="";
if(isset($_POST['id']))
{
    $id=$_POST['id'];

    $row4=$a->getimagebyeventid($id);

}

?>





<!DOCTYPE html>
<html lang="en">
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: 70%;
            margin: auto;
        }
    </style>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">
<div class="container" style="margin-top: 40px">
    <br>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="uploadfromimagegallery/2.jpg" alt="Chania" width="460" height="345">
            </div>



               <?php  foreach ($row4 as $r)
                { ?>
            <div class="item">
                <img src="<?php echo  $r->image_path; ?>" alt="images" width="460" height="345">
            </div>
                <?php } ?>



        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>


<table width="300" style="border-collapse: collapse; font: 12px Tahoma;" border="7" bordercolor="#DCDCDC" cellspacing="5" cellpadding="5" ">

    <tbody>
    <h3 style="font-style: italic">Have a look at our most adorable images from our successful events here.</h3>
    <div class="container" id="duc" style="height: 400px; margin-top: 15px">
        <div class="row" style="height: 400px;">
        <?php
        foreach ($row4 as $ro)

        {
        ?>
<!--        <tr>-->
<!--        <td style="width: 100%">-->
            <div class="col-md-4" style="margin-bottom: 10px" style="margin-top: 10px" style="border-radius: 8px">
            <img src="<?php echo $ro->image_path; ?>" alt="" height="300" width="300" border="5px" style="border:solid #e7c3c3 " />
            </div>

<!--        </td>-->
<!--        </tr>-->

            <?php

        }
        ?>
        </div>
    </div>
    </tbody></table>



<h3><a href="Image_gallery.php">Back to list</a></h3>

<?php
include(__root."views/components/footer.php"); ?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>

</body>
</html>

