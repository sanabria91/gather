<?php
if(!defined("__root")) {
    require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
}
include __root . 'DbConnect/connect.php';
include __root . 'controllers/PaymentsController.php';


require_once('./StripePaymentconfig.php');
//require_once "PaymentsController.php";
?>



<?php

$db=Connect::dbConnect();


$a=new Admin($db);
//$review = $a->getalldata();



session_start();

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
$token  = $_POST['stripeToken'];
//echo $_SESSION['eventid'];
$event_id=$_SESSION['eventid'];
$user_email=$_POST['stripeEmail'];
$payment_amount=$_SESSION['price'];
$user= $_SESSION['LoggedIn']['Firstname'] . ' ' . $_SESSION['LoggedIn']['Lastname'];
$gathering_id=$_SESSION['gatherid'];

$row2=$a->insertdata($user_email,$payment_amount,$event_id,$gathering_id);
//php mailing
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
$mail->setFrom('eventgathering1@gmail.com', 'Gathers');

//Set an alternative reply-to address
$mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to
$mail->addAddress($user_email, $user);

//Set the subject line
$mail->Subject = 'Payment invoice for the event booking';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("<h2>Your payment has been done successfully .<br>You can check your payment invoice here"."<br>"."Event id:".$event_id."<br>"."Your Name:".$user."<br>"."Amount you paid:".$payment_amount."</h2>");

//Replace the plain text body with one created manually
$mail->AltBody = 'You can check your payment invoice here'.$event_id.$user.$payment_amount;

//Attach an image file
$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: ";
} else {
    echo "<h3>We have sent You a confirmation email and your payment invoice!</h3>";
}



//header("Location: stripe_payment.php");


//end of php mail





$customer = \Stripe\Customer::create(array(
    'email' => 'customer@example.com',
    'source'  => $token
));

$charge = \Stripe\Charge::create(array(
    'customer' => $customer->id,
    'amount'   => 5000,
    'currency' => 'usd'
));

echo '<h1>Successfully charged $' . $_SESSION['price'] .'</h1>'."<br>";
echo '<h1>Thank You! '."</h1>" ;

?>

<h3><a href="Gatherings.php">Back to List</a></h3>


    <?php

    include(__root."views/components/footer.php"); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='<?php echo __httpRoot . "assest/"; ?>bootstrap/js/bootstrap.min.js'></script>
</div>
</body>
</html>