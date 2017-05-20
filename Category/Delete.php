<?php
//by Chen
 if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/CategoryController.php';

$db = Connect::dbConnect();
$categoryConnect = new CategoryConnect($db);
$categories = $categoryConnect->getCategories();
$category = null;
session_start();

$_SESSION['role'] = "admin";

if($_SESSION['role'] == 'admin') {
    if(isset($_POST["subbtn"])) {
        if(isset($_POST['Id'])) {
            $result = null;
            try {
                $category = $categoryConnect->getCategory($_POST['Id']);
            } catch(Exception $e){
                $message = $e->getMessage();
            }
            if(($category != null) && ($category->getTitle() != null) && ($category->getDescription() != null) ) {
                $result = $categoryConnect->deleteCategory($category);
            } 
            if($result != null && $result && !is_a($result, "Exception")) {
                header("Location: " . __httpRoot . "Category/Categories.php");
                exit;
            } else if(is_a($result, "Exception")) {
                $message = $result->getMessage();
            } else {
                if($message == null) {
                    $message = "The category is not successfully deleted!";
                }
            }
        } else {
            $message = "The category is not successfully deleted!";
        }
    }
} else {
    $message = "You are not logged in as a admin account!";
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
    <title>Create Category | Gather</title>
</head>
<body>
<?php if(isset($message)): ?>
    <div class="alert alert-warning">
        <?php echo $message; ?>
    </div>
<?php endif?>
<hr class="">
<div class="container">
    <?php include(__root."views/components/header.php"); ?>
    <h2>New Category</h2>
    <?php if($_SESSION['role'] == 'admin'):?>
    <h3>List of existing category titles</h3>
    <div class='row bg-info'>
        <?php foreach($categories as $category):?>
            <p class="col-sm-3 font_bold"><?php echo $category->getTitle()?></p>
        <?php endforeach;?>
    </div>
    <?php endif;?>
    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>