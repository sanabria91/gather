<?php
session_start();

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/ChecklistController.php';

$db = Connect::dbConnect();


$_SESSION['Loggin']['UserId'];
$dataAO = new ListDAO();



$user = $_SESSION['Loggin']['UserId'];

$list = $dataAO->getItems($db);



if(isset($_POST['listitem'])){
    $listitem = trim($_POST['listitem']);

    if(!empty($listitem)){
        $dataAO->addItem($db,$listitem,$user);
    }
}
?>
<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include(__root."views/components/globalhead.php"); ?>
    <title>To Do</title>
    <link rel="stylesheet" type="text/css" href="../assest/style/todo_style.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="list">
        <h1 class="header">Checklist</h1>

       <?php if(!empty($list)): ?>
        <ul class="items" id='items'>
            <?php foreach($list as $lists): ?>
                <li>
                    <span class="item<?php echo $lists['done'] ? ' done' : " "?>"><?php echo $lists['listitem'];?></span>
                    <?php if(!$lists['done']): ?>
                        <a href="mark.php?as=done&item=<?php echo $lists['id']?>" class="done-button" id="list">Marked As Done</a>
                    <?php endif; ?>
                    <div class="timestamp">
                    <p id="details">Added by: <?php echo $lists['username']?>On: <?php echo $lists['created']?></p>
                    <?php if($_SESSION['user_id']== $lists['user_id']) :?>
                        <form action="updateList.php" method="get" >
                            <input class="edit" type="hidden" value="<?php echo $lists['id']; ?>" name=id>
                            <input class="edit" type="submit" value="EDIT" name="update">
                        </form>
                       <form action="deleteListItem.php" method="get" >
                            <input class="delete" type="hidden" value="<?php echo $lists['id']; ?>" name=id>
                            <input class="delete" type="submit" value="X" name="delete">
                        </form>
                       </div>
                    <?php endif; ?>

                </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
           <p>You haven't added any items yet!</p>
        <?php endif; ?>
        <form class="item-add" id="item-add" action="Checklist.php" method="post">
            <input type="text" name="listitem" placeholder="Type a New Item Here" id="typedItem" class="input" autocomplete="off" required>
            <input type="button" value="Add" id="Add" class="submit" name="Add">
        </form>
    </div>
</div>
<script>
   // $(document).ready(function() {
        $('#Add').click(function () {
            $.ajax({
                url: 'ajax.php',
                data: {
                    chkVal: 'Add', //value you're sending to ajax
                    message: $('#typedItem').val(),
                    //date: Date() //above is to see whcich request is getting sent to php function called ajaxFunctiom
                    //and then val is sending the actual value - u send 2 vars, 1 is to check the val the other is the val
                },
                type: 'post', //methid is to post like in form
                cache: false, //i dont want to retian, dw bout it , always put false
                success: function (data) { //on success, returns the data

                    $('#items').append(data);
                    $('#typedItem').val('');
                    $('#typedItem').focus();
                }
            });
        });
  //  });
</script>
</body>

</html>
