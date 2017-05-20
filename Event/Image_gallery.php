<?php

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/ImageGalleryController.php';


//include "../header.php";
//require_once "database.php";
//require_once "ImageGalleryController.php";
$db= Connect::dbConnect();

$a=new Admin($db);
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

<table id="table">
    <thead>
    <tr>

        <th>Event Name</th>


    </tr>
    </thead>
    <tbody>

<?php

    $row3=$a->getevents();


    if (isset($row3)){
        foreach($row3 as $r) {
            //echo "<tr>";

            echo "<td>$r->EventName</td>";


            echo "<td style='display: inline-flex;'>";
            echo "<form method='post' action='ImageGalleryView_images.php '>
                                    <input type='hidden' name='id' value='$r->id'/>
                                    <input  type='submit' name='view_images' value='view images'/>
                              </form>";

            echo "</td>";
            echo "</tr>";

        }

    }


    ?>

</tbody>
</table>


    <?php

    include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>

</body>
</html>
