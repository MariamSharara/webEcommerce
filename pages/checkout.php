<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="../Styles/checkout.css">
  <link rel="stylesheet" href="../Styles/header.css">
</head>

<body>
  <?php include 'header.php' ?>
  <div class="container">
    <h1>Checkout</h1>

    <div class="shipping-details">
      <label for="address">Shipping Country:</label>
      <select id="Country" name="Country">
        <option value="Lebanon">Lebanon</option>
        <option value="UAE">UAE</option>
        <option value="USA">USA</option>
      </select>
      </textarea>
    </div>
    <div class="input-box">
      <input type="text" class="input-field" name="Address" placeholder="Address:">
    </div>
    <div class="input-box">
      <input type="number" class="input-field" name="Phone" placeholder="Phone:">
    </div>
    <div class="payment-method">
      <label for="payment">Choose a payment method:</label>
      <select id="payment" name="payment">
        <option value="credit-card">Credit Card</option>
        <option value="paypal">PayPal</option>
        <option value="cash-on-delivery">Cash on Delivery</option>
      </select>
    </div>

    <button class="proceed-btn">Proceed to Payment</button>
  </div>
</body>


</html>