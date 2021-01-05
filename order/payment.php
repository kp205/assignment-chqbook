<?php

require('../conf/config.php');


require('../library/razorpay-php/Razorpay.php');
session_start();

//save details in order table 

$clientName = $_POST['client_name'];
$clientEmail = $_POST['client_email'];
$address = $_POST['client_address'];
$orderDate = date('Y-m-d H:i:s');
$orderStatusId = '1';
$totalOrderAmount = $_POST['order_amount'];
$totalPaidAmount = $_POST['order_amount'];
$transactionVerifyCode = rand();
$created = date('Y-m-d H:i:s');
$ipAddress = $_SERVER['REMOTE_ADDR'];


include('../conf/db.php');

$sql = "INSERT INTO orders (client_name, client_email,address,order_date,order_status_id,total_order_amount,total_paid_amount,transaction_verify_code,created,ip_address)
VALUES ('$clientName','$clientEmail','$address','$orderDate','$orderStatusId','$totalOrderAmount','$totalPaidAmount','$transactionVerifyCode','$created','$ipAddress')";


if ($mysqli->query($sql) === TRUE) {
    $orderId = $mysqli->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
  }

// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);



//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//


$orderData = array(
    'receipt'         => $orderId,
    'amount'          => $totalPaidAmount * 100, // rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
);

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;
$_SESSION['transaction_verify_code'] = $transactionVerifyCode;


$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$checkout = 'manual'; // TO do: we test only manual


$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => $clientName,
    "description"       => "Test",
    "image"             => "../assets/image/avtar.jpg",
    "prefill"           => [
    "name"              => $clientName,
    "email"             => $clientEmail,
    "contact"           => "",
    ],
    "notes"             => [
    "address"           => $address,
    "merchant_order_id" => $orderId,
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

require("checkout.php");
