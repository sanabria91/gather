<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/suggestController.php';

require_once "validation.php";

$fname = $lname = $email = $date = $title = $suggest = "";
$fnameErr = $lnameErr = $emailErr = $titleErr = $suggestErr = "";

$db = Connect::dbConnect();

if(isset($_POST['update'])){
    $id=$_POST['id'];//get the id from form
    $mysuggest = new Suggest($db);
    $update = $mysuggest->getDetails($id);
}

if(isset($_POST['updateSuggest'])) {
    // Get form data
    $id = $_POST['sugID'];
    $fname=$_POST['f_Fname'];
    $lname = $_POST['f_Lname'];
    $email = $_POST['f_Email'];
    $date = $_POST['f_Date'];
    $title = $_POST['f_Title'];
    $suggest = $_POST['f_Sug'];

    if(!Validation::isEmpty($fname)){
        $fnameErr = "Enter the First Name";
    }
    if(!Validation::isEmpty($lname)){
        $lnameErr = "Enter the Last Name";
    }
    if(!Validation::isEmpty($email)){
        $emailErr = "Email is required";
    }
    if(!Validation::isEmpty($title)){
        $titleErr = "Enter the title";
    }
    if(!Validation::isEmpty($suggest)){
        $suggestErr = "Suggestion is required";
    }

    if(!Validation::checkName($fname)) {
        $fnameErr = "Only words and white spaces allowed";
    }

    if(!Validation::checkName($lname)){
        $lnameErr = "Only words and white spaces allowed";
    }

    if(!Validation::emailValid($email)){
        $emailErr = "Invalid email";
    }

    if($fnameErr == "" && $lnameErr == "" && $emailErr == "" && $titleErr == "" && $suggestErr == "") {

        // Update dino details
        $mysuggest = new Suggest($db);
        $result = $mysuggest->updateDetails($id, $fname, $lname, $email, $date, $title, $suggest);
        if ($result == 1) {
            header("Location: suggestion.php");
        }
    }
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
    <title>Business | Gather</title>
    </head>
    <body>
    <?php include(__root."views/components/userheader.php"); ?>
    <div class="container">
        <h3>Update Suggestion</h3>
        <form action="updateSuggest.php" method="post">
            <fieldset>
                <legend>Suggestion Form</legend>

                <input type="hidden" value="<?php if(isset($update)) { echo $update->id; } ?>" name="sugID">


                <!--FIRST NAME-->
                <label for="in_Fname">
                    <input type="text" id="formFname" name="f_Fname"
                           value="<?php if(isset($update)) { echo $update->first_name; } else { echo $fname; } ?>"/>
                    <div class="label-text">First name</div>
                    <span id="msg"><?php echo $fnameErr; ?></span>
                </label><br/>

                <!--LAST NAME-->
                <label for="in_Lname">
                    <input type="text" id="formLname" name="f_Lname" value="<?php if(isset($update)) { echo $update->last_name; } else { echo $lname; } ?>"/>
                    <div class="label-text">Last name</div>
                    <span id="msg"><?php echo $lnameErr; ?></span>
                </label><br/>

                <!--EMAIL-->
                <label for="in_Email">
                    <input type="text" id="formEmail" name="f_Email" value="<?php if(isset($update)) { echo $update->email; } else { echo $email; } ?>"/>
                    <div class="label-text">Email</div>
                    <span id="msg"><?php echo $emailErr; ?></span>
                </label><br/>

                <!--DATE-->
                <label for="in_Date">
                    <input type="text" id="formDate" name="f_Date" value="<?php if(isset($update)) { echo $update->date; } else { echo $date; } ?>"/>
                    <div class="label-text">Date</div>
                </label><br/>

                <!--TITLE-->
                <label for="in_Title">
                    <input type="text" id="formTitle" name="f_Title" value="<?php if(isset($update)) { echo $update->title; } else { echo $title; } ?>"/>
                    <div class="label-text">Title</div>
                    <span id="msg"><?php echo $titleErr; ?></span>
                </label><br/>

                <!-- SUGGESTION -->
                <label for="in_Sug">
                    <input type="text" id="in_Sug" name="f_Sug" value="<?php if(isset($update)) { echo $update->suggest; } else { echo $suggest; } ?>"/>
                    <div class="label-text">Suggestion</div>
                    <span id="msg"><?php echo $suggestErr; ?></span>
                </label><br/>

                <!-- SUBMIT -->
                <p>
                    <button id="button" type="submit" value="Update Product Details" name="updateSuggest">Update</button>
                </p>

            </fieldset>
        </form>

        <?php include(__root."views/components/footer.php"); ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
    </div>
    </body>
</html>
