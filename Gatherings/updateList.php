<?php

session_start();

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/ChecklistController.php';

$db = Connect::dbConnect();
$list = new ListDAO();


if(isset($_GET['update'])) {
    $id = $_GET['id'];
    $listall = $list->getItemsDetails($db, $id);

}

if(isset($_GET['upd'])){

    $id = $_GET['aid'];
    $listitem= $_GET['item'];
    $done = $_GET['completed'];

    $list->updateItem($db,$listitem, $done, $id);
    header("Location: Gatherings.php?id=4");
}

?>
<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include(__root."views/components/globalhead.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Business | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">
    <h3>Update List Item:</h3>
    <form action="updateList.php" method="get">
        <input type="hidden" name="aid" value="<?php echo $id ?>" />
        <label>List Item: </label><input type="text" name="item" value="<?php echo $listall['listitem']; ?>"/><br /><br />
        <label>Completed: </label>
            <select name="completed">
                    <option value=0>Not Done</option>";
                    <option value=1>Done</option>";
            </select><br /><br />
        <input type="submit" value="Update List Item" name="upd" />
    </form>
    <button id="back">Go Back To List</button>
    <br/><br/>
    <?php include(__root."views/components/footer.php"); ?>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
    var btn = document.getElementById('back');
    btn.addEventListener('click', function() {
        document.location.href = 'Gatherings.php?id=4';
    });
</script>
</body>
</html>