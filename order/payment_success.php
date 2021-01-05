<?php 


  include('../conf/db.php');

  session_start();

   $orderIdBase_64 = $_GET['id'];
   $orderid = base64_decode($orderIdBase_64);

   $sql = "SELECT client_name, razorpay_payment_id, is_payment_received,razorpay_order_id,razorpay_payment_id FROM orders WHERE order_id='$orderid'";
   $result = $mysqli->query($sql);

   while($row = $result->fetch_assoc()) {
    $isPaymentReceived = $row["is_payment_received"];
    $razorpayOrderId = $row["razorpay_order_id"];
    $razorpayPaymentId = $row["razorpay_payment_id"];
  }


?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!--Start: main container -->
<div class="container">
    <div class="row">
    <?php if($isPaymentReceived && isset($_SESSION['transaction_verify_code']) && !empty($_SESSION['transaction_verify_code'])){ ?>
        <div class="col-sm-8 offset-md-2">
           <h1 style="color:green;"><i class="far fa-check-circle"></i></h2>
           <h4>Order Complete succesfully </h4>
           <p>Your payment is completed your trasection id is-<b><?php echo $razorpayPaymentId?></b></p>
        </div>
    <?php } elseif ($isPaymentReceived) { ?> 
        
        <div class="col-sm-8 offset-md-2">
           <h1 style="color:green;"><i class="far fa-check-circle"></i></h2>
           <h4>Order Complete succesfully </h4>
        </div>
         

    <?php }else{ ?> 
        <div class="col-sm-8 offset-md-2">
           <h1 style="color:red;"><i class="far fa-times-circle"></i></h2>
           <h4>Your payment failed</h4>
        </div>
    <?php }?> 
     
    
    </div>
</div>
<!--End: main container -->
<?php session_unset();?>   
</body>
</html>
