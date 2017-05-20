<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/blogController.php';

$db = Connect::dbConnect();

session_start();

$myblog = new Blog($db);

$msg = $userErr= $msgErr = "";

if(isset($_POST['reply'])){
    $id=$_POST['id'];//get the id from form
    $myblog = new Blog($db);
    $reply = $myblog->blogDetails($id);
}

if(isset($_POST['submit'])){

    $user = $_POST['f_User'];
    $msg = $_POST['f_Msg'];
    $blog_id = $_POST['sugID'];
    $addMsg = $myblog->postMsg($user, $msg, $blog_id);
    if ($addMsg == 1) {
        header("Location: blog.php");
    }
}

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

<h3>Reply Message</h3>
<form action="comment.php" method="post">


    <input type="hidden" value="<?php if(isset($reply)) { echo $reply->id; } ?>" name="sugID">

    User Name: <input type="text" name="f_User">
    <span id="msg"><?php echo $userErr ?></span>

    Comment: <textarea id="mytextarea" name="f_Msg"></textarea>
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
