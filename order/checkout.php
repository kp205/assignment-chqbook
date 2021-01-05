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
        <div class="col-md-8 offset-md-2" style="border:1px solid #333;">
        <table class="table table-borderless">
            <thead class="thead-dark">
                <tr>
                <th scope="col" colspan="2">Order Info</th>
                </tr>
            </thead>
            <tbody>
                <tr class="">
                    <th>Name</th>
                    <td><?php echo $data['name']?></td>
                </tr>
                <tr class="">
                    <th>Email</th>
                    <td><?php echo $data['prefill']['email']?></td>
                </tr>
                <tr class="">
                    <th>Address</th>
                    <td><?php echo $data['notes']['address']?></td>
                </tr>
                <tr class="">
                    <th>Amount</th>
                    <td><i class="fa fa-rupee"></i> <?php echo $totalPaidAmount;?></td>
                </tr>
                <tr class="text-right">
                    <th colspan="2"><button class="btn btn-info" id="rzp-button1">Pay Now</button></th>
                </tr>
            </tbody>
            </table>    
        </div>
        <div class="col-sm-12">
        
        
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            <form name='razorpayform' action="payment_verification.php" method="POST">
                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
                <input type="hidden" name="order_id"  id="order_id" value="<?php echo base64_encode($data['notes']['merchant_order_id'])?>">
            </form>
            
        </div>
    </div>
</div>
<!--End: main container -->
<script>
            // Checkout details as a json
            var options = <?php echo $json?>;

            /**
             * The entire list of Checkout fields is available at
             * https://docs.razorpay.com/docs/checkout-form#checkout-fields
             */
            options.handler = function (response){
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                document.razorpayform.submit();
            };

            // Boolean whether to show image inside a white frame. (default: true)
            options.theme.image_padding = false;

            options.modal = {
                ondismiss: function() {
                    console.log("This code runs when the popup is closed");
                },
                // Boolean indicating whether pressing escape key 
                // should close the checkout form. (default: true)
                escape: true,
                // Boolean indicating whether clicking translucent blank
                // space outside checkout form should close the form. (default: false)
                backdropclose: false
            };

            var rzp = new Razorpay(options);

            document.getElementById('rzp-button1').onclick = function(e){
                rzp.open();
                e.preventDefault();
            }
            </script>
</body>
</html>


