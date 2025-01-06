<?php
session_start();
include('database.php');
if (isset($_POST['update_product_quantity'])) {
  $update_value = $_POST['update_quantity'];
  $update_id = $_POST['update_quantity_id'];
  $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity=$update_value WHERE id=$update_id");
  if ($update_quantity_query) {
    echo 'Quantity updated successfully';
  } else {
    echo 'Error updating quantity';
  }
  exit();
}

if (isset($_GET['remove'])) {
  $remove_id = $_GET['remove'];
  mysqli_query($conn, "DELETE FROM `cart` WHERE id= $remove_id");
  header('location:cart.php');
  exit();
}
if (isset($_GET['deleteall'])) {
  mysqli_query($conn, "DELETE FROM `cart`");
  header('location:cart.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shopping Cart</title>
  <link rel="stylesheet" href="../Styles/cart.css" />
  <link rel="stylesheet" href="../Styles/header.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $("form").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var updateId = form.find("input[name='update_quantity_id']").val();
        var updateQuantity = form.find("input[name='update_quantity']").val();

        $.ajax({
          url: 'cart.php',
          method: 'POST',
          data: {
            update_product_quantity: true,
            update_quantity: updateQuantity,
            update_quantity_id: updateId
          },
          success: function(response) {
            location.reload();
          },
          error: function() {
            alert("Error updating quantity.");
          }
        });
      });
      $(".delete_product").click(function(e) {
        e.preventDefault();
        var removeId = $(this).data("id");

        $.ajax({
          url: 'cart.php',
          method: 'GET',
          data: {
            remove: removeId
          },
          success: function(response) {
            location.reload();
          },
          error: function() {
            alert("Error removing product.");
          }
        });
      });
    });
  </script>
</head>

<body>
  <?php include('header.php'); ?>
  <div class="container">
    <section class="shopping_cart">
      <h1>My Cart</h1>
      <table>
        <?php
        $select_cart_products = mysqli_query($conn, "SELECT * FROM `cart`");
        $idnb = 1;
        $granddtotal = 0;
        if (mysqli_num_rows($select_cart_products) > 0) {
          echo "
            <thead>
            <tr>
            <th>Product Id</th>
            <th>Product Name</th>
            <th>Product Image</th> 
            <th>Product Price</th>
            <th>Product Quantity</th>
            <th>Total Price</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>";
          while ($fetch_cart_products = mysqli_fetch_assoc($select_cart_products)) {
        ?>
            <tr>
              <td><?php echo $idnb ?></td>
              <td><?php echo $fetch_cart_products['name'] ?></td>
              <td>
                <img class="product-image" src="../image/<?php echo $fetch_cart_products['image'] ?>" alt="Product Image">
              </td>
              <td><?php echo $fetch_cart_products['price'] ?>$</td>
              <td>
                <form action="" method="POST">
                  <input type="hidden" value="<?php echo $fetch_cart_products['id'] ?>" name="update_quantity_id">
                  <div class="quantity_box">
                    <input type="number" min="1" value="<?php echo $fetch_cart_products['quantity'] ?>" name="update_quantity">
                    <input type="submit" class="update_quantity" value="Update" name="update_product_quantity">
                  </div>
                </form>
              </td>
              <td><?php echo $subtotal = ($fetch_cart_products['price'] * $fetch_cart_products['quantity']) ?>$</td>
              <td><a href="#" class="delete_product" data-id="<?php echo $fetch_cart_products['id'] ?>"
                  onclick="return confirm('Are you sure you want to delete this product?')">
                  <img src='../Images/delete.png' alt='Delete' class='delete_product_image'></a></td>
            </tr>
        <?php
            $granddtotal += $subtotal;
            $idnb++;
          }
        } else {
          echo "<tr class='no-products'><td colspan='5'>Cart is empty.</td></tr>";
        }
        ?>
        </tbody>
      </table>
      <div class="table_bottom"><a href="shopping.php"
          class="bottom_btn">
          Continue Shopping</a>
        <h3>Grand total: <span><?php echo $granddtotal ?>$</span></h3>
        <a href="cart.php?deleteall"
          onclick="return confirm('Are you sure you want to delete all products?')" class="bottom_btn">
          Delete all</a>
      </div>

    </section>
  </div>
  <a href="checkout.php" class="checkout">Proceed to checkout</a>
</body>

</html>