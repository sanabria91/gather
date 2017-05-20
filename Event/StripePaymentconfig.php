


<?php
require_once('./vendor/autoload.php');

$stripe = array(
    "secret_key"      => "sk_test_15jOM3XhBShVZDRpAaf1fucX",
    "publishable_key" => "pk_test_kGxFLtFvhg7QL7YifOZqbybF"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
