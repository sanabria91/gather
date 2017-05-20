<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/ImageGalleryController.php';


//require_once "database.php";
//require_once "ImageGalleryController.php";
$db= Connect::dbConnect();

$a=new Admin($db);

$image_id="";
if(isset($_POST['image_id']))
{
    $image_id=$_POST['image_id'];
}
if(isset($_POST['delete']))
{
//var_dump($image_id);
    $row6=$a->todeletedata($image_id);



//header("Location: ImageGalleryImageuploadAdmin.php");

}


//var_dump($_POST['id']);

//getting event id
$id="";
if(isset($_POST['id']))
{
    $id=$_POST['id'];

    $row4=$a->getimagebyeventid($id);

}

function GetImageExtension($imagetype)

{

    if(empty($imagetype)) return false;

    switch($imagetype)

    {

        case 'image/bmp': return '.bmp';

        case 'image/gif': return '.gif';

        case 'image/jpeg': return '.jpg';

        case 'image/png': return '.png';

        default: return false;

    }

}





if (!empty($_FILES["uploadedimage"]["name"])) {

    $file_name=$_FILES["uploadedimage"]["name"];

    $temp_name=$_FILES["uploadedimage"]["tmp_name"];

    $imgtype=$_FILES["uploadedimage"]["type"];

    $ext= GetImageExtension($imgtype);
    $date=date("d-m-Y");

    $imagename=$date."-".time().$ext;

    $target_path =  "uploadfromimagegallery/".$imagename;


var_dump($target_path);
    if(move_uploaded_file($temp_name, $target_path)) {


        $row=$a->insertimage($target_path,$id);

    }
    else{

        exit("Error While uploading image on the server");

    }

    if(isset($_POST['delete']))
    {
        unlink($target_path);
    }

}

//display images


$row4=$a->getimagebyeventid($id);

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


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!--<table style="border-collapse: collapse; font: 12px Tahoma;" border="7" bordercolor="#DCDCDC" cellspacing="5" cellpadding="5">-->
    <table width="300" style="border-collapse: collapse; font: 12px Tahoma;" border="7" bordercolor="#DCDCDC" cellspacing="5" cellpadding="5" ">

    <tbody>

        <div class="container" id="duc" style="height: 400px; margin-top: 15px">

            <div class="row" style="height: 400px;">

        <?php
        foreach ($row4 as $ro)

        {
            ?>

<!--            <td style="border: solid #DCDCDC 5px">-->
                <div class="col-md-4" style="margin-bottom: 10px" style="margin-top: 10px" style="border-radius: 8px">
                <img src="<?php echo $ro->image_path; ?>" alt="" height="300" width="300" border="5px" />


                <form method='post' action='ImageGalleryImageuploadAdmin.php'>
                    <input type='hidden' name='image_id' value='<?php echo $ro->Id ; ?>'/>
                    <input type='hidden' name='id' value='<?php echo $_POST['id'] ; ?>'/>
                    <input  type='submit' name='delete' value='Delete' onClick="javascript: return confirm('Do you really want to delete this image?');" />

                </form>

                </div>





            <?php

        }
        ?>
            </div>
            </div>


    </tbody></table>







<form action=" " enctype="multipart/form-data" method="post" style="margin-top: 10px">

    <table style="border-collapse: collapse; font: 12px Tahoma;" border="1" cellspacing="5" cellpadding="5">

        <tbody><tr>

            <td><input name="uploadedimage" type="file"></td>
        </tr>


        <tr>
            <td><input type='hidden' name='id' value='<?php echo $id ; ?>'/>
                <input name="Upload Now" type="submit" value="Upload Image"></td>
        </tr>

        </tbody></table>
</form>


<h3><a href="ImageGalleryAdmin.php">Back to list</a></h3>


    <?php

    include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>

</body>
</html>
