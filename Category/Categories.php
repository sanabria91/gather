<?php
//by Chen
 if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/CategoryController.php';

$db = Connect::dbConnect();

$categoryController = new CategoryConnect($db);
$categories = null;

session_start();

if(!isset($_SESSION['LoggedIn']['UserId'])) {
    header("Location: " . __httpRoot);
    exit;
}

if($_SESSION['LoggedIn']['UserRole'] == 'admin') {
    $categories = $categoryController->getCategoriesWithTotal();
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
    <title> All Categories | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">
    <?php if(isset($categories) && ($_SESSION['LoggedIn']['UserRole'] == 'admin')):?>
    <h1>List of all categories</h1>
        <div class="allList-menu row">
            <p class="col-4">
                <a href="<?php echo __httpRoot . "Category/Create.php";?>" class="btn btn-default">Create New Category</a>
            </p>
        </div>
        <div class="row" id="admin-categories-list">
    <?php foreach ($categories as $category) : ?>
            <div class="panel panel-default col-sm-6">
                <div class="panel-heading">
                    <a href="<?php echo __httpRoot . "Event/Events.php?id=" . $category->getId();?>"><?php echo $category->getTitle(); ?></a>
                </div>
                <div class="panel-body">
                    <p><?php echo $category->getDescription()?></p>
                    <p>Total events in this category: <?php echo $category->getTotal()?></p>
                    <div class="row">
                        <p class='col-sm-2'><a href="<?php echo __httpRoot . "Category/Edit.php?id=" . $category->getId();?>" class="btn btn-default">Edit</a></p>
                        <form action="Delete.php" method='POST' class="col-sm-2">
                            <input name="Id" value='<?php echo $category->getId();?>' hidden>
                            <input type="submit" name="subbtn" value='Delete' class="btn btn-danger" />
                        </form>
                    </div>
                </div>
            </div>
    <?php endforeach; ?>
        </div>
    <?php else: ?>
    <div class="alert alert-warning">
        You do not have access to this page.
    </div>
    <?php endif?>
    <?php include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>
