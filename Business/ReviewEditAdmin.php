

<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/ReviewsController.php';


//require_once "../header.php";
//require_once "database.php";

//require_once "ReviewsController.php";

$post_id="";
$db=Connect::dbConnect();

if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
}
if(isset($_POST['update']))
{
    $status = $_POST['status'];
    echo $status;
    var_dump($status);
    var_dump($post_id);
    $a = new Admin($db);
    $row2 = $a->toeditdata( $status,$post_id);

    header("Location: ReviewAdmin.php");
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
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Business | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">
    <h2>Publish Review </h2>


 <form method='post' action='ReviewEditAdmin.php'>

   <div id="edit">
       <input type="hidden" name="post_id" value="<?php echo $post_id ?>"/>
    <!--   <label for="status">Status:</label>

       <input type="text" id="status" name="status" placeholder="Approved/Not Seen"/><span id="email_text"></span>-->
       <label for="status">Status:</label>
       <select id="status" name="status">
           <option value="Approved">Approved</option>
           <option value="Not Seen">Not Seen</option>
       </select>
    </div>
     <style>#edit{margin-left: 100px; margin-top: 50px;}</style>


           <input class='btn btn-danger' type='submit' name='update' value='update' />
</form>
    <h3><a href="ReviewAdmin.php">Back to reviews</a></h3>

<?php include(__root."views/components/footer.php"); ?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>

</div>
</body>
</html>












