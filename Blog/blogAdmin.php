<?php
session_start();
 if(!defined("__root")) {
     require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
 }

include __root . 'DbConnect/connect.php';
include __root . 'controllers/blogController.php';

$db = Connect::dbConnect();

$myblog = new Blog($db);
$list = $myblog->listBlog();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" href="mystyle.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    <?php include(__root."views/components/globalhead.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Business | Gather</title>
    <style>
        .custom-inline {
            display: inline-block !important;
        }
        .manage-posts {
            text-align: right;
            padding: 4px 0px 16px 0;
        }
    </style>
</head>

<body>
<?php include(__root."views/components/userheader.php"); ?>
    <div class="container">
<?php
echo"
    <h1>Events Blog</h1>";
    foreach ($list as $l) {
        echo "
            <div class=\"container-fluid\">
                <div class=\"row\" style=\" border: 2px solid black; margin-bottom: 2em; background-color: #ebf5fb;\">
                    <div class=\"col-sm-4\" style=\"padding: 2em;\">
                        <img src='uploads/" . $l->image ."' width='250px' height='250px'/>
                    </div>
            
                    <div class=\"col-sm-8\" style=\"\">
                        <h1> $l->title<br/> </h1>
                        <p>$l->content</p>
                    </div>
                </div>
            </div>
            
            <div class='manage-posts'>
                <form action=\"updatePostAdmin.php\" method=\"post\" class='custom-inline'>
                    <input type=\"hidden\" value='" . $l->id . "' name=\"id\">
                    <input id='btn2' class='button btn btn-default' type=\"submit\" name=\"update\" value=\"Update\">
                </form>
                <form action=\"deletePostAdmin.php\" method=\"post\" class='custom-inline'>
                    <input type=\"hidden\" value='" . $l->id . "' name=\"id\">
                    <input id='btn2' class='button btn btn-default' type=\"submit\" name=\"delete\" value=\"Delete\" onClick=\"javascript: return confirm('Do you really want to delete this?');\" />
                </form>
                <form action=\"getCommentsAdmin.php\" method=\"post\" class='custom-inline'>
                    <input type=\"hidden\" value='" . $l->id . "' name=\"id\">
                    <input id='btn2' class='button btn btn-default' type=\"submit\" name=\"comment\" value=\"Comments\">
                </form>
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
        // echo "<b>Description: </b>" . $details->capacity . "<br/>";
    }
?>
<br/>
<br/>
<form action="createPostAdmin.php" method="post">
    <input type="submit" name="add" value="Create Blog Post" class="btn btn-success" title="Click to create a new blog post" />
</form>
<br />
    <?php include(__root."views/components/footer.php"); ?>
    </div>
</body>
</html>
