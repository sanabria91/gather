<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/suggestController.php';


$db = Connect::dbConnect();
$mysuggest = new Suggest($db);
session_start();

$msg = $msgErr = "";

if(isset($_POST['reply'])){
    $id=$_POST['id'];//get the id from form
    $mysuggest = new Suggest($db);
    $reply = $mysuggest->getDetails($id);
}

if(isset($_POST['submit'])){
    $id = $_POST['sugID'];
    $msg = $_POST['f_Msg'];

    if($msgErr == "") {
        $addMsg = $mysuggest->postMsg($id, $msg);
        if ($addMsg == 1) {
            header("Location: suggestionAdmin.php");
        }
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
    <link rel="stylesheet" type="text/css" href="../user/liststyle.css">
    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
    <script src="http://cloud.tinymce.com/stable/tinymce.min.js?apiKey=eocjl47gfzdlmy660z4hpx0j11n4uxidv4cwf6xeroms0j69"></script>
<!--    <script>-->
<!--        tinymce.init({-->
<!--            selector: '#mytextarea'-->
<!--        });-->
<!--    </script>-->
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
    <h3>Reply Message</h3>
    <form action="suggestionReplyAdmin.php" method="post">
        <input type="hidden" value="<?php if(isset($reply)) { echo $reply->id; } ?>" name="sugID">

        <textarea id="mytextarea" name="f_Msg"></textarea>
        <span id="msg"><?php echo $msgErr; ?></span>

        <p>
            <button id="button" value="Submit" name="submit">Post Message</button>
        </p>
    </form>

    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>
