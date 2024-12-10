// Send an SMS using Twilio's REST API and PHP
<?php
$message="Invoice / Receipt No # $IN,Customer name #$CN,nPayment Mode #$PM, price #$subtotal";
$mn="8849097364";
$m="+91$mn";

// Required if your environment does not handle autoloading
require __DIR__ . '/vendor/autoload.php';
// require __DIR__ . 'twilio-php-main\src\Twilio\autoload.php';
use Twilio\Rest\Client;
// Your Account SID and Auth Token from console.twilio.com
$sid = "AC0995e863a5a20fcd23b1c24118811d20";
$token = "a6841490f522a5808341b9ee3db2ba0e";
$client = new Client($sid, $token);

// Use the Client to make requests to the Twilio REST API
$client->messages->create(
    // The number you'd like to send the message to
    $m,
    [
        // A Twilio phone number you purchased at https://console.twilio.com
        'from' => '+13158645338',
        // The body of the text message you'd like to send
        'body' => $message
    ]
);