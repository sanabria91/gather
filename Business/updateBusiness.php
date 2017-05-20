<?php

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/Business.php';


$db = Connect::dbConnect();
$list = new BusinessDAO();

session_start();

$_SESSION['LoggedIn']['BusinessId'];

if(isset($_GET['update'])) {
    $id = $_SESSION['LoggedIn']['BusinessId'];
}

if(isset($_POST['upd'])){

    $id = $_SESSION['LoggedIn']['BusinessId'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];

    $list->updateBusiness($db, $name, $description, $capacity, $id);
    header("Location: Business.php");
}


$business = $list->getBusinessProfile($db,$_SESSION['LoggedIn']['BusinessId']);

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
<h3>Update Business Profile</h3>
<form action="updateBusiness.php" method="post">

    <label>Business Name: </label><input type="text" name="name" value="<?php echo $business['businessName']; ?>"/><br /><br />
    <label>Business Description: </label><input type="text" name="description" value="<?php echo $business['businessDescription']; ?>"/><br /><br />
    <label>Capacity: </label><input type="text" name="capacity" value="<?php echo $business['businessCapacity']; ?>"/><br /><br />
    <input type="submit" value="Update Promotion" name="upd" />
</form>
    <button id="back">Go Back To Business Page</button>
    <br/><br/>
    <?php include(__root."views/components/footer.php"); ?>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
<script>
    var btn = document.getElementById('back');
    btn.addEventListener('click', function() {
        document.location.href = 'Business.php';
    });
</script>
</body>
</html>