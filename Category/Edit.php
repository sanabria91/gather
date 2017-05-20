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

if(!isset($_SESSION['LoggedIn']['UserId'])) {
    header("Location: " . __httpRoot);
    exit;
}

if($_SESSION['LoggedIn']['UserRole'] == 'admin') {
    if(isset($_GET['id'])) {
        try {
            $category = $categoryConnect->getCategory($_GET['id']);
        } catch(Exception $e) {
            $message = $e->getMessage();
        }
    }
    if(isset($_POST["subbtn"])) {
        if(isset($_POST['CategoryTitle']) && isset($_POST['CategoryDescription']) && isset($_POST['Id'])) {
            $result = null;
            $category = null;
            $message = null;
            try {
                $category = new CategoryModel($_POST);
            } catch(Exception $e){
                $message = $e->getMessage();
            }
            if(($category != null) && ($category->getTitle() != null) && ($category->getDescription() != null) ) {
                $result = $categoryConnect->EditCategory($category);
            } 
            if($result != null && $result && !is_a($result, "Exception")) {
                header("Location: " . __httpRoot . "Category/Categories.php");
                exit;
            } else if(is_a($result, "Exception")) {
                $message = $result->getMessage();
            } else {
                if($message == null) {
                    $message = "The category is not successfully submitted!";
                }
            }
        } else {
            $message = "The category is not successfully submitted!";
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
    <title> Edit Category | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<body>
<?php if(isset($message)): ?>
    <div class="alert alert-warning">
        <?php echo $message; ?>
    </div>
<?php endif?>
<div class="container">
    <?php if($_SESSION['LoggedIn']['UserRole'] == 'admin'):?>
    <h3>List of existing category titles</h3>
    <div class='row bg-info'>
        <?php foreach($categories as $category):?>
            <p class="col-sm-3 font_bold"><?php echo $category->getTitle()?></p>
        <?php endforeach;?>
    </div>
    <h3>Edit</h3>
    <?php if(isset($category)):?>
    <form action="Edit.php" method="POST">
        <input value='<?php echo $category->getId(); ?>' hidden name="Id">
        <div class="form-group">
            <label for="CategoryTitle">Category Title</label>
            <input type="text" class="form-control" id="" placeholder="Title" name="CategoryTitle" value='<?php echo $category->getTitle(); ?>'>
        </div>
        <div class="form-group">
            <label for="CategoryDescription">Category Description</label>
            <textarea class="form-control" id="" name="CategoryDescription"><?php echo $category->getDescription(); ?></textarea>
        </div>
        <input type="submit" name="subbtn" value="Submit" class="btn btn-default"/>
    </form>
    <?php endif;?>
    <?php endif;?>
    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>