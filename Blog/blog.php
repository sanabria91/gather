<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/blogController.php';

$db = Connect::dbConnect();

session_start();
$_SESSION['role'] = 'business';
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!--  <script>
>>>>>>> master
        window.onload = function () {

        var outTwo =document.getElementById('output');
        outTwo.style.display = "none";
        var msg = document.getElementById('title');
        msg.onclick = process;
        function process(){
            var outOne = document.getElementById('output');
            outOne.style.display = "block";
        }
        }
<<<<<<< HEAD
    </script>
</head>
<body>
    </script>-->

</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
    <div class="container">

<?php
    $myblog = new Blog($db);
    $list = $myblog->listBlog();
    $message = "";
    echo"<h1>Hello World! The GATHER BLOG</h1>";
    foreach ($list as $l) {
    echo "
            <div class=\"container-fluid\">
    
        <div class=\"row\" style=\" border: 2px solid black; margin-bottom: 2em; background-color: #ebf5fb;\">
            <div class=\"col-sm-4\" style=\"padding: 2em;\">
            <img src='uploads/" . $l->image ."' width='250px' height='250px'/>        
        </div>
            <div class=\"col-sm-8\" style=\"\">
            <h2>
            <a href='blog.php?id=" . $l->id . "'>" . $l->title . "</a></h2>" . $l->content . "<br/>        
            </div>
        </div>
        
        <div>
            <form action=\"comment.php\" method=\"post\">
                <input type=\"hidden\" value='" . $l->id . "' name=\"id\">
                <input id='btn2' class='button' type=\"submit\" name=\"reply\" value=\"Comment\">
            </form>
        </div>
    </div>
            ";
}

    if(isset($_GET['id'])){
    $id = $_GET['id'];
    $details = $myblog->blogDetails($id);
}

    if(isset($details))
    {
        echo "<h2>Post Details</h2>";
        echo "<b>Post Title: </b>" . $details->title . "<br/>";
        echo "<b>Content: </b>" . $details->content . "<br/>";
    }

    echo "<br />";
    include(__root."views/components/footer.php");
?>
    </div>
</body>
</html>
