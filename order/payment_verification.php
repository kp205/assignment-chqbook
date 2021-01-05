<?php

require('../conf/config.php');

session_start();

require('../library/razorpay-php/Razorpay.php');

include('../conf/db.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Transaction Failed";


if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

$orderIdBase_64 = $_POST['order_id'];
$orderId = base64_decode($_POST['order_id']); 

if ($success === true)
{
             $razorpayPaymentId = $_POST['razorpay_payment_id'];
             $razorpayOrderId = $_SESSION['razorpay_order_id'];
             
             $sql = "UPDATE orders SET razorpay_order_id = '$razorpayOrderId', razorpay_payment_id = '$razorpayPaymentId', is_payment_received='1' WHERE order_id = $orderId ";

            if ($mysqli->query($sql) === TRUE) {
                header("Location: payment_success.php?id=$orderIdBase_64");
            } else {
                echo "Error: " . $sql . "<br>" . $mysqli->error;
            }

}
else
{   
             $transactionAttemptDate = date('Y-m-d H:i:s');
             $ipAddress = $_SERVER['REMOTE_ADDR'];
             $latitude = ''; // TODO : for this we have to implement google map api
             $longitude = ''; // TODO : for this we have to implement google map api

             $sql = "INSERT INTO orders (order_id, transaction_attempt_date,transaction_error,ip_address,latitude,longitude)
                VALUES ('$orderId','$transactionAttemptDate','$error','$ipAddress','$latitude','$longitude')";

                if ($mysqli->query($sql) === FALSE){
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                }

                if ($mysqli->query($sql) === TRUE) {
                    header("Location: payment_success.php?id=$orderIdBase_64");
                } else {
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                }
              
}

