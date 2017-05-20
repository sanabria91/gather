<?php
session_start();
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/suggestController.php';

$db = Connect::dbConnect();
$bid = $_SESSION['LoggedIn']['BusinessId'];

$mysuggest = new Suggest($db);
$list = $mysuggest->listSuggestions();

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
<?php
    echo "<h1>List of Suggestions</h1>";
    echo "<table id='rounded-corner'>
    <thead>
        <tr>
            <th scope='col' class='rounded-company'>Title</th>
            <th scope='col' class='rounded-company'>UserName</th>
            <th scope='col' class='rounded-company'>Action</th>
        </tr>
    </thead>";
    foreach ($list as $l)
    {
        echo "
            <tbody>
                <tr>
                    <td><a href='suggestionAdmin.php?id=" . $l->id . "'>" . $l->title . "</a></td>                  
                    <td>$l->first_name $l->last_name</td>
                    <td id='rowbtn'><form action=\"deleteSuggestAdmin.php\" method=\"post\">
                        <input type=\"hidden\" value='" . $l->id . "' name=\"id\">
                        <input id='btn1' class='button' type=\"submit\" name=\"delete\" value=\"Delete\" onClick=\"javascript: return confirm('Do you really want to delete this?');\"/>
                        </form>
                        <form action=\"suggestionReplyAdmin.php\" method=\"post\">
                        <input type=\"hidden\" value='" . $l->id . "' name=\"id\">
                        <input id='btn2' class='button' type=\"submit\" name=\"reply\" value=\"Reply\">
                        </form>
                    </td>
                </tr>
            </tbody>          
            ";
    }

    echo "</table>";
    if(isset($_GET['id'])){
    $id = $_GET['id'];
    $details = $mysuggest->getDetails($id);
}

    if(isset($details))
{
    echo "<h2>Suggestion Details</h2>";
    echo "<b>Title: </b>" . $details->title . "<br/>";
    echo "<b>Date: </b>" . $details->date . "<br/>";
    echo "<b>Suggestion: </b>" . $details->suggest;
}

    include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>
