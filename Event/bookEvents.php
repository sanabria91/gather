<?php
session_start();

if(!isset($_POST['submit']) && !isset($_POST['id'])) {
    header("Location: bookings.php");
}

if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}

include __root . 'DbConnect/connect.php';
include __root . 'controllers/bookingController.php';
require_once "validation.php";

$db = Connect::dbConnect();
$mybooking = new Booking($db);

$mybooking = new Booking($db);

$date = $time = $people = $user = $phone = $email = "";
$dateErr = $timeErr = $peopleErr = $userErr = $phoneErr = $emailErr = $DateErr= "";

if(isset($_POST['submit'])){

    $date = $_POST['f_Date'];
    $time = $_POST['f_Time'];
    $people = $_POST['f_People'];
    $user = $_POST['f_Name'];
    $phone = $_POST['f_Phone'];
    $email = $_POST['f_Email'];
    $id = $_POST['eventId'];

    $existDate = $mybooking->checkBookingDate($date);
    //var_dump($existDate);
    if($existDate != null){
        $DateErr = "The Date is booked";
    }

    //$DateErr="er";
    if(!Validation::isEmpty($user)){
        $userErr = "Enter the User Name";
    }

    if(!Validation::isEmpty($phone)){
        $phoneErr = "Enter the Contact Number";
    }

    if(!Validation::isEmpty($email)){
        $emailErr = "Enter the Email";
    }

    if(!Validation::isEmpty($time)){
        $timeErr = "Enter the time";
    }

    if(!Validation::isEmpty($people)){
        $peopleErr = "Enter the number of people";
    }

    if(!Validation::checkName($user)) {
        $userErr = "Only words and white spaces allowed";
    }

    if(!Validation::phoneValid($phone)){
        $phoneErr = "Not a Valid format";
    }

    if(!Validation::emailValid($email)){
        $emailErr = "Email is not valid";
    }

    if(!Validation::integerValue($people)){
        $peopleErr = "Only integer values allowed";
    }

    if($userErr == "" && $phoneErr == "" && $emailErr == "" && $timeErr == "" && $peopleErr == "" && $DateErr =="") {

        $add = $mybooking->eventBook($date, $time, $people, $user, $phone, $email, $id);

        if ($add == 1) {
            //SMTP needs accurate times, and the PHP time zone MUST be set
            //This should be done in your php.ini, but this is how to do it if you don't have access to that
            date_default_timezone_set('Etc/UTC');
            require 'PHPMailer/PHPMailerAutoload.php';
            //Create a new PHPMailer instance
            $mail = new PHPMailer;
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';
            //Set the hostname of the mail server
            $mail->Host = 'smtp.gmail.com';
            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;
            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'tls';
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = "eventgathering1@gmail.com";
            //Password to use for SMTP authentication
            $mail->Password = "gather123";
            //Set who the message is to be sent from
            $mail->setFrom('eventgathering1@gmail.com', 'Admin');
            //Set an alternative reply-to address
            $mail->addReplyTo('replyto@example.com', 'First Last');
            //Set who the message is to be sent to
            $mail->addAddress($email, $user);
            //Set the subject line
            $mail->Subject = 'Confirmation email for booking';
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML("<h2>Thank You for booking the event with us</h2>");
            //Replace the plain text body with one created manually
            $mail->AltBody = 'Thank You for booking the event with Us. Your event has been booked.';
            //Attach an image file
            $mail->addAttachment('images/phpmailer_mini.png');
            //send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error: ";
            } else {
                echo "Message sent!";
            }
            header("Location: bookings.php");
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <?php include(__root."views/components/globalhead.php"); ?>
    <link rel="stylesheet" type="text/css" href="../assest/style/liststyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Business | Gather</title>
</head>
<body>
<?php include(__root."views/components/userheader.php"); ?>

<form action="bookEvents.php" method="post">
    <legend>Online Booking</legend>
    <input type="hidden" value="<?php if(isset($_POST['id'])) { echo $_POST['id']; } ?>" name="eventId"/>

    <!--USER NAME-->
    <label for="in_Fname">
        <input type="text" id="formName" name="f_Name" value="<?php echo $user;?>"/>
        <div class="label-text">User Name</div>
        <span id="msg"><?php echo $userErr; ?></span>
    </label><br/>

    <!--PHONE-->
    <label for="in_phone">
        <input type="text" id="formPhone" name="f_Phone" value="<?php echo $phone;?>"/>
        <div class="label-text">Contact Number</div>
        <span id="msg"><?php echo $phoneErr; ?></span>
    </label><br/>

    <!--EMAIL-->
    <label for="in_Email">
        <input type="text" id="formEmail" name="f_Email" value="<?php echo $email;?>"/>
        <div class="label-text">Email</div>
        <span id="msg"><?php echo $emailErr; ?></span>
    </label><br/>

    <!--DATE-->
    <label for="in_Date">
        <input type="text" id="datepicker" name="f_Date" value="<?php echo $date; ?>"/>
        <div class="label-text">Date</div>
    </label><br/>

    <!--TIME-->
    <label for="in_Time">
        <input type="text" id="formTime" name="f_Time" value="<?php echo $time;?>"/>
        <div class="label-text">Time</div>
        <span id="msg"><?php echo $timeErr; ?></span>
    </label><br/>

    <!-- PEOPLE -->
    <label for="in_People">
        <input type="text" id="formPeople" name="f_People" value="<?php echo $people;?>"/>
        <div class="label-text">Number Of People</div>
        <span id="msg"><?php echo $peopleErr; ?></span>
    </label><br/>

    <!-- SUBMIT -->
    <input id='btn1' class='button' type="submit" name="submit" value="submit" />
</form>
    <?php include(__root."views/components/footer.php"); ?>
    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
        $(function(){

        });
    </script>
</body>
</html>
