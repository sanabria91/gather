<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/blogController.php';

$db = Connect::dbConnect();
session_start();

$myblog = new Blog($db);

$date = $title = $content = "";
$dateErr = $titleErr = $contentErr = "";

if(isset($_POST['upload'])){

    //path of the file in temp directory
    $file_temp = $_FILES['upfile']['tmp_name'];
    //original path and file name of the uploaded file
    $file_name = $_FILES['upfile']['name'];
    //size of the uploaded file in bytes
    $file_size = $_FILES['upfile']['size'];
    //type of the file(if browser provides)
    $file_type = $_FILES['upfile']['type'];
    //error number
    $file_error = $_FILES['upfile']['error'];

    echo $file_temp . "<br />";
    echo $file_name . "<br />";
    echo $file_size . "<br />";
    echo $file_type . "<br />";
    echo $file_error . "<br />";
    if ($file_error > 0)
    {
        echo "Problem";
        switch ($file_error)
        {
            case 1:
                echo "File exceeded upload_max_filesize.";
                break;
            case 2:
                echo "File exceeded max_file_size";
                break;
            case 3:
                echo "File only partially uploaded.";
                break;
            case 4:
                echo "No file uploaded.";
                break;
        }
        exit;
    }

    $max_file_size = 200000;
    if($file_size > $max_file_size)
    {
        echo "file size too big";
    }

    //folder to move the uploaded file
    $target_path = "uploads/";
    $target_path = $target_path .  $_FILES['upfile']['name'];
    //move the uploaded file from tempe path to taget path
    if(move_uploaded_file($_FILES['upfile']['tmp_name'], $target_path)) {
        echo "The file ".  $_FILES['upfile']['name'] . " has been uploaded ";
    } else{
        echo "There was an error uploading the file, please try again!";
    }
}
if(isset($_POST['submit'])) {

    $date = $_POST['f_Date'];
    $title = $_POST['f_Title'];
    $content = $_POST['f_Content'];
    $imgData =$_FILES['upfile']['name'];
    $target_path = "uploads/";
    $target_path = $target_path .  $_FILES['upfile']['name'];
    // move the uploaded file from tempe path to taget path
    if(move_uploaded_file($_FILES['upfile']['tmp_name'], $target_path)) {
        echo "The file ".  $_FILES['upfile']['name'] . " has been uploaded ";
    } else{
        echo "There was an error uploading the file, please try again!";
    }

    $add = $myblog->blogPost($date, $title, $content, $imgData);
    if ($add == 1) {
        header("Location: blogAdmin.php");
    }
}
?>
<!DOCTYPE html>
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

    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
    <script src="http://cloud.tinymce.com/stable/tinymce.min.js?apiKey=eocjl47gfzdlmy660z4hpx0j11n4uxidv4cwf6xeroms0j69"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#mytextarea',
            theme: 'modern',
            width: 600,
            height: 300,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template paste textcolor'
            ],
            content_css: 'css/content.css',
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
        });
    </script>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">

    <form action="createPostAdmin.php" enctype="multipart/form-data" method="post">
    <legend>Create Blog Post</legend>

    <!-- DATE -->
    <label for="in_Date">
        <input type="text" id="formDate" name="f_Date" value="<?php echo date("Y/m/d"); ?>"/>
        <div class="label-text">Date</div>
    </label><br/>

    <!-- TITLE -->
    <label for="in_Title">
        <input type="text" id="formTitle" name="f_Title" value="<?php echo $title;?>"/>
        <div class="label-text">Title</div>
        <span id="msg"><?php echo $titleErr; ?></span>
    </label><br/>

    <!-- CONTENT -->
    <textarea id="mytextarea" name="f_Content"></textarea>
    <span id="msg"><?php echo $contentErr; ?></span>

    <!-- IMAGE -->
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
    Select file: <input type="file" name="upfile" id="upfile" >

    <!-- SUBMIT -->
    <input id='btn1' class='button' type="submit" name="submit" value="submit" />
</form>

    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>
