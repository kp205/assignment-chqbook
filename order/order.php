<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" >
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!--Start: main container -->
<div class="container">
    <div class="row">
    <div class="col-sm-12">
    <form method="POST" action="payment.php">
  <fieldset>
    <legend>Order Details</legend>
    
    <div class="form-group">
      <label for="exampleInputEmail1">Name</label>
      <input type="text" name='client_name' class="form-control" id="clientName" placeholder="Enter name">
     
    </div>
    <div class="form-group">
      <label for="clientEmail">Email address</label>
      <input type="text" class="form-control" id="clientEmail" name='client_email' aria-describedby="emailHelp" placeholder="Enter email" kl_ab.original_type="email">
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>

    <div class="form-group">
      <label for="amount">Amount</label>
      <input type="text" class="form-control" id="amount" placeholder="Enter amount" name='order_amount'>
      
    </div>

    <div class="form-group">
      <label for="exampleTextarea">Address</label>
      <textarea class="form-control" id="address" rows="3" name='client_address'></textarea>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Go for payment</button>
  </fieldset>
</form>
    </div> 
    
    </div>
</div>
<!--End: main container -->
</body>
</html>
