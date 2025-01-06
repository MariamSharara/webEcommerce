<?php
session_start();
include 'database.php';

if (isset($_POST['add_to_cart'])) {
  $products_name = $_POST['product_name'];
  $products_price = $_POST['product_price'];
  $products_image = $_POST['product_image'];
  $product_quantity = 1;

  $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$products_name'");
  if (mysqli_num_rows($select_cart) > 0) {
    $update_quantity = mysqli_query($conn, "UPDATE `cart` SET quantity = quantity + 1 WHERE name='$products_name'");
  } else {
    $insert_products = mysqli_query($conn, "INSERT INTO `cart` (name, price, image, quantity) VALUES ('$products_name', '$products_price', '$products_image', '$product_quantity')");
  }

  echo "Product added to cart!";
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping</title>
  <link rel="stylesheet" href="../Styles/shop.css">
  <link rel="stylesheet" href="../Styles/header.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div><?php include('header.php'); ?></div>

  <div class="container">
    <section class="products">
      <h1>Lets Shop</h1>
      <div class="product_container">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products`");
        if (mysqli_num_rows($select_products) > 0) {
          while ($fetch_product = mysqli_fetch_assoc($select_products)) { ?>
            <form action="shopping.php" method="post" class="form_container">
              <div class="edit_form">
                <img src="../image/<?php echo $fetch_product['product_image'] ?>" alt="">
                <h3><?php echo $fetch_product['product_name'] ?></h3>
                <div class="price">Price: $<?php echo $fetch_product['product_price'] ?></div>
                <input type="hidden" name="product_name" value="<?php echo $fetch_product['product_name'] ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_product['product_price'] ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_product['product_image'] ?>">
                <input type="submit" class="submit_btn cart_btn" value="Add to Cart" name="add_to_cart">
                <div class="message"></div>
              </div>
            </form>
        <?php
          }
        } else {
          echo "<tr class='no-products'><td colspan='5'>No products available.</td></tr>";
        }
        ?>
      </div>
    </section>
  </div>

  <script>
    $(document).ready(function() {
      $(".cart_btn").click(function(e) {
        e.preventDefault();
        var productName = $(this).closest('form').find("input[name='product_name']").val();
        var productPrice = $(this).closest('form').find("input[name='product_price']").val();
        var productImage = $(this).closest('form').find("input[name='product_image']").val();

        var messageDiv = $(this).closest('.form_container').find('.message');
        $.ajax({
          url: 'shopping.php',
          method: 'POST',
          data: {
            add_to_cart: true,
            product_name: productName,
            product_price: productPrice,
            product_image: productImage
          },
          success: function(response) {
            messageDiv.html('<div class="success-message">Product added to cart!</div>');
          },
          error: function() {
            messageDiv.html('<div class="error-message">Something went wrong! Please try again.</div>');
          }
        });
        setTimeout(function() {
          messageDiv.html('');
        }, 2000);
      });
    });
  </script>
</body>

</html>