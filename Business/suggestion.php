<?php
session_start();
 if(!defined("__root")) {
     require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
 }

include __root . 'DbConnect/connect.php';
include __root . 'controllers/suggestController.php';

$db = Connect::dbConnect();

$mysuggest = new Suggest($db);

$list = $mysuggest->listSuggestions();

$mysuggest = new Suggest($db);
$listBusiness = $mysuggest->listBusiness();

if(isset($_SESSION['businessid'])) {
    $id = $_SESSION['businessid'];
    $list = $mysuggest->listSuggestions();
    $msg = $mysuggest->getMsg($id);
}
?>

<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php include(__root."views/components/globalhead.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title>Business | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>
<div class="container">

    <?php
    echo "<h2>List of Business</h2>";
    foreach($listBusiness as $lb){
        echo "
        $lb->businessName <br/>
        <form action=\"suggestionForm.php\" method=\"post\">
        <input type=\"hidden\" value='" . $lb->id . "' name=\"id\">
        <input id='btn1' class='button' type=\"submit\" name=\"create\" value=\"Post Suggestion\" />
        </form>
        ";
    }

    echo "<h2 id='list'>List of Your Suggestions</h2>";
    echo "<table id='rounded-corner'>
            <thead>
            <tr>
                <th scope='col' class='rounded-company'>Title</th>
                <th scope='col' class='rounded-company'>Message From Admin</th>
                <th scope='col' class='rounded-company'>Action</th>
            </tr>
        </thead>
            <tbody>";
            foreach ($list as $l)
            {
                echo "<tr>
                      <td><a href='suggestion.php?id=" . $l->id . "'>" . $l->title . "</a>
                      </td>
                      <td>";if($l->Reply == null)
              {
                  echo "No message";
              }
              else
              {
                  echo $l->Reply;
              }

    echo "</td>
               <td id='rowbtn'><form action=\"deleteSuggest.php\" method=\"post\">
               <input type=\"hidden\" value='" . $l->id . "' name=\"id\">
               <input id='btn1' class='button' type=\"submit\" name=\"delete\" value=\"Delete\" onClick=\"javascript: return confirm('Do you really want to delete this?');\"/>
               </form>
                         
               <form action=\"updateSuggest.php\" method=\"post\">
               <input type=\"hidden\" value='" . $l->id . "' name=\"id\">
               <input id='btn2' class='button' type=\"submit\" name=\"update\" value=\"Update\">
               </form>
           </td>
       </tr>
    ";
}
echo "</tbody></table>";

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
?>

<br/>
<br/>
<form action="suggestionForm.php" method="post">
    <input type="submit" name="add" value="Create Suggestion">
</form>
    <?php include(__root."views/components/footer.php"); ?>
</div>
</body>
</html>

